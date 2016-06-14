<?php
	header('Content-Type: application/json');
	$start = microtime(true);
	require_once('connect1.php');
	
	require('pingLobby.php');
	// get game tiles
	$query = "select tile, player, units, nation, flag from `fwTiles` where game=?";
	$stmt = $link->prepare($query);
	$stmt->bind_param('i', $_SESSION['gameId']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($dTile, $dPlayer, $dUnits, $dNation, $dFlag);
	
	$tiles = array();
	while($stmt->fetch()){
		$x = new stdClass();
		$x->tile = $dTile;
		$x->player = $dPlayer;
		$x->units = $dUnits;
		$x->nation = $dNation;
		$x->flag = $dFlag;
		array_push($tiles, $x);
	}
	
	$x = new stdClass();
	$x->player = $_SESSION['player'];
	$x->tiles = $tiles;
	$delay = microtime(true) - $start;
	$x->delay = $delay;
	echo json_encode($x);
?>