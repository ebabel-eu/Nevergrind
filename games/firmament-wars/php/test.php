<?php
	require('values.php');
	require('connect1.php');
	
	$start = microtime(true);
	
	$attacker = new stdClass();
	$attacker->units = 10;
	
	$defender = new stdClass();
	$defender->units = 10;
	
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
	
	
	$result = battle($attacker->units, $defender->units);
	
	$delay = microtime(true) - $start;
	echo "Is adjacent? ". isAdjacent(0, 1) . "<BR>";
	echo $result[0] . " " . $result[1] . "<BR>";
	echo $delay;

?>