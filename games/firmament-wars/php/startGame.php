<?php
	require_once('connect1.php');
	
	// must be host
	if ($_SESSION['player'] === 1){
		// must have 2-8 players
		$query = "SELECT player FROM `fwplayers` where game=? and timestamp > date_sub(now(), interval {$_SESSION['lag']} second)";
		$stmt = $link->prepare($query);
		$stmt->bind_param('i', $_SESSION['gameId']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($dPlayer);
		$count = $stmt->num_rows;
		
		$players = array();
		while($stmt->fetch()){
			$x = new stdClass();
			$x->test = 1;
			array_push($players, $x);
		}
		
		if ($count < 2 || $count > 8){
			header('HTTP/1.1 500 You failed to join the game.');
			exit;
		}
		// must timestamp start of game
		$query = "update fwGames set start=now() where row=?";
		$stmt = $link->prepare($query);
		$stmt->bind_param('i', $_SESSION['gameId']);
		$stmt->execute();
		
		// determine map and 8 possible start points
		$map = $_SESSION['map'];
		if ($map === "Earth Alpha"){
			echo "{$map} map found.";
			$start = array(79, 24, 29, 47, 69, 52, 9, 46);
			$len = count($players);
			for ($i=0; $i<$len; $i++){
				$startLen = count($start);
				$startIndex = rand(0, $startLen-1);
				$players[$i]->start = $start[$startIndex];
				$players[$i]->startIndex = $startIndex;
				array_splice($start, $startIndex, 1);
				
			}
			var_dump($players);
		}
		exit;
		
		// allocate initial units
		// players transition to world map view and see starting units
	}
?>