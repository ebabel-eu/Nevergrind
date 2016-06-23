<?php
	header('Content-Type: application/json');
	$start = microtime(true);
	require_once('connect1.php');
	
	require('pingLobby.php');
	// get game tiles
	$query = "select tile, player, units, nation, flag, account, food, production, culture from `fwTiles` where game=?";
	$stmt = $link->prepare($query);
	$stmt->bind_param('i', $_SESSION['gameId']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($dTile, $dPlayer, $dUnits, $dNation, $dFlag, $dAccount, $dFood, $dProduction, $dCulture);
	
	$tiles = array();
	while($stmt->fetch()){
		$x = new stdClass();
		$x->tile = $dTile;
		$x->player = $dPlayer;
		$x->units = $dUnits;
		$x->nation = $dNation;
		$x->flag = $dFlag;
		$x->account = $dAccount;
		$x->food = $dFood;
		$x->production = $dProduction;
		$x->culture = $dCulture;
		array_push($tiles, $x);
	}
	
	$x = new stdClass();
	$x->player = $_SESSION['player'];
	$x->tiles = $tiles;
	$x->delay = microtime(true) - $start;
	echo json_encode($x);
?>