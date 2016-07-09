<?php
	require('values.php');
	require('connect1.php');
	
	$start = microtime(true);
	
	$attacker = new stdClass();
	$attacker->units = 10;
	
	$defender = new stdClass();
	$defender->units = 10;
	
	/*
	function battle($x, $y){
		$oBonus = 0; // + atk 500
		$dBonus = 0; // + def 500
		// add o tile bonus 
		// add d tile bonus 
		// $oTileUpgrades = [0, 16, 32, 48];
		// $dTileUpgrades = [0, 30, 40, 50];
		// Math.ceil(Math.random() * (6 + bonus)) + (Math.random() * 100 < oTile ? 3 : 0);
		
		// add o general bonus 750
		// add d general bonus 750
		
		while ($y > 0 && $x > 1){
			$diceX = $x > 2 ? 3 : 2;
			$diceY = $y > 1 ? 2 : 1;
			$xRoll = array();
			$yRoll = array();
			
			$x -= $diceX;
			$y -= $diceY;
			for ($i=0; $i<$diceX; $i++){
				$die = ceil(mt_rand(0, 6000 + $oBonus)/1000);
				array_push($xRoll, $die);
			}
			for ($i=0; $i<$diceY; $i++){
				$die = ceil(mt_rand(0, 6000 + $dBonus)/1000);
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
	
	$result = battle($attacker->units, $defender->units);
	$foo = ceil(mt_rand(0, 6000 + 0)/1000);
	echo $foo.'<br>';
	
	echo "Is adjacent? ". isAdjacent(0, 1) . "<BR>";
	echo $result[0] . " " . $result[1] . "<BR>";
	 //Enter your code here, enjoy!
    // $start = microtime(true);
    $x = "";
    
    for ($i=0; $i<1000; $i++){
		require_once('adjEarthAlpha.php');
    }
	$x = new stdClass();
	$x->reward = 0;
	function getReward(){
	}
	getReward();
	*/
	
	/*
	$query = "select crystals from accounts where email='".$_SESSION['email']."' limit 1";
	$result = $link->query($query);
	while($row = $result->fetch_assoc()){
		$crystals .= $row['crystals'];
	}
	*/
	echo $_SESSION['gameId'].'<br>';
	$a = 'firefox';
		// notify game player has disconnected
		$msg = $a . ' has disconnected from the game.';
		$stmt = $link->prepare('insert into fwchat (`message`, `gameId`) values (?, ?);');
		$stmt->bind_param('si', $msg, $_SESSION['gameId']);
		$stmt->execute();
		// set all tiles and player to 0
		$query = 'update fwTiles set account="", player=0, nation="", flag="", units=0 where game=? and account=?';
		$stmt = $link->prepare($query);
		$stmt->bind_param('is', $_SESSION['gameId'], $a);
		$stmt->execute();
		// delete from players
		$query = 'delete from fwPlayers where account=?';
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $a);
		$stmt->execute();
		// add disconnect
		$query = "insert into fwNations (`account`, `disconnects`) VALUES (?, 1) on duplicate key update disconnects=disconnects+1";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $a);
		$stmt->execute();
	
	echo "<br>". (microtime(true) - $start);
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
?>