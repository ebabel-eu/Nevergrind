<?php
	header('Content-Type: application/json');
	require('connect1.php');
	
	require('pingLobby.php');
	// get game tiles
	$query = "select account, flag, nation, tile, tileName, player, units, food, production, culture from `fwTiles` where game=?";
	$stmt = $link->prepare($query);
	$stmt->bind_param('i', $_SESSION['gameId']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($dAccount, $dFlag, $dNation, $dTile, $dTileName, $dPlayer, $dUnits, $dFood, $dProduction, $dCulture);
	
	$tiles = array();
	$count = 0;
	while($stmt->fetch()){
		$x = new stdClass();
		$x->account = $dAccount;
		$x->flag = $dFlag;
		$x->nation = $dNation;
		$x->tile = $dTile;
		$x->tileName = $dTileName;
		$x->player = $dPlayer;
		$x->units = $dUnits;
		$x->food = $dFood;
		$x->production = $dProduction;
		$x->culture = $dCulture;
		$tiles[$count++] = $x;
	}
	
	$x = new stdClass();
	$x->player = $_SESSION['player'];
	$x->flag = $_SESSION['flag'];
	$x->nation = $_SESSION['nation'];
	$x->foodMax = $_SESSION['foodMax'];
	$x->cultureMax = $_SESSION['cultureMax'];
	$x->tiles = $tiles;
	echo json_encode($x);
?>