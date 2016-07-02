<?php
	header('Content-Type: application/json');
	$start = microtime(true);
	// connect1.php
	session_start();
	if(php_uname('n')=="JOE-PC"){
		$link = mysqli_connect("localhost:3306","root","2M@elsw6","nevergrind");
	}else{
		$link = mysqli_connect("localhost", "nevergri_ng", "!M6a1e8l2f4y6n", "nevergri_ngLocal");
	}
	
	// get game tiles
	$query = 'select tile, player, units, food, production, culture from `fwTiles` where game=?';
	$stmt = $link->prepare($query);
	$stmt->bind_param('i', $_SESSION['gameId']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($tile, $player, $units, $food, $production, $culture);
	
	$x = new stdClass();
	$x->tiles = array();
	$count = 0;
	while($stmt->fetch()){
		$x->tiles[$count++] = (object) array(
			'tile' => $tile, 
			'player' => $player, 
			'units' => $units, 
			'food' => $food, 
			'production' => $production, 
			'culture' => $culture
		);
	}
	
	$x->delay = microtime(true) - $start;
	echo json_encode($x);
?>