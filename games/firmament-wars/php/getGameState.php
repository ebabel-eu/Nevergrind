<?php
	header('Content-Type: application/json');
	$start = microtime(true);
	require_once('connect1.php');
	
	require('pingLobby.php');
	// get game tiles
	$query = "select tile, player, units, food, production, culture from `fwTiles` where game=?";
	$stmt = $link->prepare($query);
	$stmt->bind_param('i', $_SESSION['gameId']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($tile, $player, $units, $food, $production, $culture);
	
	$x = new stdClass();
	$x->tiles = array();
	while($stmt->fetch()){
		$t = (object) array(
			'tile' => $tile, 
			'player' => $player, 
			'units' => $units, 
			'food' => $food, 
			'production' => $production, 
			'culture' => $culture
		);
		array_push($x->tiles, $t);
	}
	
	$x->delay = microtime(true) - $start;
	echo json_encode($x);
?>