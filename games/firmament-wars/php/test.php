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
	echo "<br>". (microtime(true) - $start);
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
?>