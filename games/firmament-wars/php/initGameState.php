<?php
	header('Content-Type: application/json');
	require('connect1.php');
	
	require('pingLobby.php');
	$_SESSION['gameStarted'] = 1; // determines if exitGame is a loss or not
	// get game tiles
	$query = "select account, flag, nation, tile, tileName, player, units, food, culture from `fwTiles` where game=?";
	$stmt = $link->prepare($query);
	$stmt->bind_param('i', $_SESSION['gameId']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($dAccount, $dFlag, $dNation, $dTile, $dTileName, $dPlayer, $dUnits, $dFood, $dCulture);
	
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
		$x->culture = $dCulture;
		$tiles[$count++] = $x;
	}
	// set capital
	$query = "select startTile from fwPlayers where game=? and account=?;";
	$stmt = $link->prepare($query);
	$stmt->bind_param('is', $_SESSION['gameId'], $_SESSION['account']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($startTile);
	while($stmt->fetch()){
		$_SESSION['capital'] = $startTile;
	}
	
	$x = new stdClass();
	$x->player = $_SESSION['player'];
	$x->flag = $_SESSION['flag'];
	$x->nation = $_SESSION['nation'];
	$x->foodMax = $_SESSION['foodMax'];
	$x->food = $_SESSION['food'];
	$x->production = $_SESSION['production'];
	$x->turnProduction = $_SESSION['turnProduction'];
	$x->culture = $_SESSION['culture'];
	$x->cultureMax = $_SESSION['cultureMax'];
	
	$x->manpower = $_SESSION['manpower'];
	$x->turnBonus = $_SESSION['turnBonus'];
	$x->foodBonus = $_SESSION['foodBonus'];
	$x->cultureBonus = $_SESSION['cultureBonus'];
	$x->oBonus = $_SESSION['oBonus'];
	$x->dBonus = $_SESSION['dBonus'];
	// turn
	$x->turnProduction = $_SESSION['turnProduction'];
	$x->ajax = 'initGameState';
	
	$query = 'select sum(food), sum(culture) from `fwTiles` where account=? and game=?';
	$stmt = $link->prepare($query);
	$stmt->bind_param('si', $_SESSION['account'], $_SESSION['gameId']);
	$stmt->execute();
	$stmt->bind_result($food, $culture);
	
	while($stmt->fetch()){
		$x->sumFood = $food + round($food * ($_SESSION['foodBonus'] / 100)) + $_SESSION['foodReward'];
		$x->sumCulture = $culture + round($culture * ($_SESSION['cultureBonus'] / 100)) + $_SESSION['cultureReward'];
	}
	
	$x->tiles = $tiles;
	echo json_encode($x);
?>