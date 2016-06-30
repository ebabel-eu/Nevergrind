<?php
	header('Content-Type: application/json');
	require_once('connect1.php');
	
	require('pingLobby.php');
	// get game tiles
	$query = "select account, flag, nation, tile, player, units, food, production, culture from `fwTiles` where game=?";
	$stmt = $link->prepare($query);
	$stmt->bind_param('i', $_SESSION['gameId']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($dAccount, $dFlag, $dNation, $dTile, $dPlayer, $dUnits, $dFood, $dProduction, $dCulture);
	
	$tiles = array();
	while($stmt->fetch()){
		$x = new stdClass();
		$x->account = $dAccount;
		$x->flag = $dFlag;
		$x->nation = $dNation;
		$x->tile = $dTile;
		$x->player = $dPlayer;
		$x->units = $dUnits;
		$x->food = $dFood;
		$x->production = $dProduction;
		$x->culture = $dCulture;
		array_push($tiles, $x);
	}
	
	$x = new stdClass();
	$x->player = $_SESSION['player'];
	$x->tiles = $tiles;
	echo json_encode($x);
?>