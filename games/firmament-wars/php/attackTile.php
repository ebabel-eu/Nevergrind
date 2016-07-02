<?php
	require('connect1.php');
	require('battle.php');
	
	$attacker = new stdClass();
	$attacker->tile = $_POST['attacker'];
	
	$defender = new stdClass();
	$defender->tile = $_POST['defender'];
	
	if (isAdjacent($attacker->tile, $defender->tile)){
		$query = 'select tile, nation, flag, units, player, account from fwTiles where (tile=? or tile=?) and game=?';
		$stmt = $link->prepare($query);
		$stmt->bind_param('iii', $attacker->tile, $defender->tile, $_SESSION['gameId']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($tile, $nation, $flag, $units, $player, $account);
		
		while($stmt->fetch()){
			if ($_POST['attacker'] == $tile){
				// use classes?
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
		
		// add adjacent validation
		if ($defender->account == $_SESSION['account']){
			// move to allied territory
			$defender->units = $defender->units + $attacker->units - 1;
			$attacker->units = 1;
			// update attacker
			$query = 'update fwTiles set units=? where tile=? and game=?';
			$stmt = $link->prepare($query);
			$stmt->bind_param('iii', $attacker->units, $attacker->tile, $_SESSION['gameId']);
			$stmt->execute();
			// update defender
			$query = 'update fwTiles set units=? where tile=? and game=?';
			$stmt = $link->prepare($query);
			$stmt->bind_param('iii', $defender->units, $defender->tile, $_SESSION['gameId']);
			$stmt->execute();
		} else {
			if ($stmt->num_rows == 2 && 
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
					$query = 'update fwTiles set nation=?, flag=?, units=?, player=?, account=? where tile=? and game=?';
					$stmt = $link->prepare($query);
					$stmt->bind_param('ssiisii', $attacker->nation, $attacker->flag, $defender->units, $attacker->player, $attacker->account, $defender->tile, $_SESSION['gameId']);
					$stmt->execute();
				} else {
					// defeat
					$attacker->units = $result[0];
					$defender->units = $result[1];
					// update attacker
					$query = 'update fwTiles set units=? where tile=? and game=?';
					$stmt = $link->prepare($query);
					$stmt->bind_param('iii', $attacker->units, $attacker->tile, $_SESSION['gameId']);
					$stmt->execute();
					// update defender
					$query = 'update fwTiles set units=? where tile=? and game=?';
					$stmt = $link->prepare($query);
					$stmt->bind_param('iii', $defender->units, $defender->tile, $_SESSION['gameId']);
					$stmt->execute();
				}
			} else {
				header('HTTP/1.1 500 Invalid attack command.');
				exit();
			}
		}
	} else {
		header('HTTP/1.1 500 Invalid attack command.');
		exit();
	}
	echo "BATTLE COMPLETE:";
?>