<?php
	require('connect1.php');
	
	$target = $_POST['target'];
	$all = $_POST['all'];
	
	$query = "select player, units from fwTiles where tile=? and game=?";
	$stmt = $link->prepare($query);
	$stmt->bind_param('ii', $target, $_SESSION['gameId']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($dPlayer, $dUnits);
	while($stmt->fetch()){
		$player = $dPlayer;
		$units = $dUnits;
	}
	
	if ($_SESSION['player'] === $player &&
		$units <= 254 &&
		$_SESSION['manpower'] > 0){
		if ($all){
			$foo = $_SESSION['manpower'];
			$rem = 0;
			if ($units + $foo > 255){
				$rem = ($units + $foo) - 255;
				$foo = 255 - $units;
			}
			$units += $foo;
			$_SESSION['manpower'] = $rem;
			
			/*
			$units += $_SESSION['manpower'];
			$_SESSION['manpower'] = 0;
			*/
		} else {
			$_SESSION['manpower']--;
			$units++;
		}
		
		// update attacker
		$query = 'update fwTiles set units=? where tile=? and game=?';
		$stmt = $link->prepare($query);
		$stmt->bind_param('iii', $units, $target, $_SESSION['gameId']);
		$stmt->execute();
	} else {
		header('HTTP/1.1 500 You cannot deploy to enemy territory!');
	}
?>