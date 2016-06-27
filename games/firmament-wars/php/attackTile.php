<?php
	$start = microtime(true);
	require_once('connect1.php');
	
	$attacker = new stdClass();
	$attacker->tile = $_POST['attacker'];
	
	$defender = new stdClass();
	$defender->tile = $_POST['defender'];
	
	$query = "select nation, flag, units, player, account from fwTiles where (tile=? or tile=?) and game=?";
	$stmt = $link->prepare($query);
	$stmt->bind_param('iii', $attacker->tile, $defender->tile, $_SESSION['gameId']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($nation, $flag, $units, $player, $account);
	
	while($stmt->fetch()){
		if ($_SESSION['player'] == $player){
			$attacker->nation = $nation;
			$attacker->flag = $flag;
			$attacker->units = $units;
			$attacker->player = $player;
			$attacker->account = $account;
		} else {
			$defender->nation = $nation;
			$defender->flag = $flag;
			$defender->units = $units;
			$defender->player = $player;
			$defender->account = $account;
		}
	}
	
	function battle($x, $y){
		$oBonus = 0;
		$dBonus = 0;
		
		while ($y > 0 && $x > 1){
			$diceX = $x > 2 ? 3 : 2;
			$diceY = $y > 1 ? 2 : 1;
			$xRoll = array();
			$yRoll = array();
			
			$x -= $diceX;
			$y -= $diceY;
			for ($i=0; $i<$diceX; $i++){
				$die = rand(100, (600 + $oBonus));
				array_push($xRoll, $die);
			}
			for ($i=0; $i<$diceY; $i++){
				$die = rand(100, (600 + $dBonus));
				array_push($yRoll, $die);
			}
			
			rsort($xRoll);
			rsort($yRoll);
			
			while( ($x && count($xRoll) > 0 || !$x && 
				count($xRoll) > 1) && 
				count($yRoll) > 0){
				$xRoll[0] > $yRoll[0] ? $diceY-=1 : $diceX-=1;
				$xRoll = array_slice($xRoll, 1);
				$yRoll = array_slice($yRoll, 1);
			}
			$x += $diceX;
			$y += $diceY;
		}
		
		return array($x, $y);
	}
	function isAdjacent($x, $y){
		if ($_SESSION['map'] == 'Earth Alpha'){
			require('adjEarthAlpha.php');
		}
		return in_array($y, $adj[$x]);
	}
	
	// add adjacent validation
	if ($defender->account == $_SESSION['account']){
		// move to allied territory
		$attacker->units = 1;
		echo $defender->units."<br>";
		$defender->units = $defender->units + $attacker->units - 1;
		// update attacker
		$query = "update fwTiles set units=? where tile=? and game=?";
		$stmt = $link->prepare($query);
		$stmt->bind_param('iii', $attacker->units, $attacker->tile, $_SESSION['gameId']);
		$stmt->execute();
		// update defender
		$query = "update fwTiles set units=? where tile=? and game=?";
		$stmt = $link->prepare($query);
		$stmt->bind_param('iii', $defender->units, $defender->tile, $_SESSION['gameId']);
		$stmt->execute();
	} else {
		if (isAdjacent($attacker->tile, $defender->tile) &&
			$stmt->num_rows == 2 && 
			$attacker->units > 1 &&
			$defender->account != $_SESSION['account']){
			$result = battle($attacker->units, $defender->units);
			if ($result[0] > $result[1]){
				// victory
				$attacker->units = 1;
				$defender->units = $result[0] - $attacker->units;
				// update attacker
				$query = "update fwTiles set units=? where tile=? and game=?";
				$stmt = $link->prepare($query);
				$stmt->bind_param('iii', $attacker->units, $attacker->tile, $_SESSION['gameId']);
				$stmt->execute();
				// update defender
				$query = "update fwTiles set nation=?, flag=?, units=?, player=?, account=? where tile=? and game=?";
				$stmt = $link->prepare($query);
				$stmt->bind_param('ssiisii', $attacker->nation, $attacker->flag, $defender->units, $attacker->player, $attacker->account, $defender->tile, $_SESSION['gameId']);
				$stmt->execute();
			} else {
				// defeat
				$attacker->units = $result[0];
				$defender->units = $result[1];
				// update attacker
				$query = "update fwTiles set units=? where tile=? and game=?";
				$stmt = $link->prepare($query);
				$stmt->bind_param('iii', $attacker->units, $attacker->tile, $_SESSION['gameId']);
				$stmt->execute();
				// update defender
				$query = "update fwTiles set units=? where tile=? and game=?";
				$stmt = $link->prepare($query);
				$stmt->bind_param('iii', $defender->units, $defender->tile, $_SESSION['gameId']);
				$stmt->execute();
			}
		} else {
			header('HTTP/1.1 500 Invalid attack command.');
		}
	}
	$delay = microtime(true) - $start;
	echo "BATTLE COMPLETE: $delay";
?>