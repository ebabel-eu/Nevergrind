<?php
	header('Content-Type: application/json');
	require_once('connect1.php');
	$start = microtime(true);
	// get game tiles
	$query = "select sum(food), sum(production), sum(culture) from `fwTiles` where account=? and game=? limit 1";
	$stmt = $link->prepare($query);
	$stmt->bind_param('si', $_SESSION['account'], $_SESSION['gameId']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($food, $production, $culture);
	
	$x = new stdClass();
	while($stmt->fetch()){
		$newFood = $_SESSION['food'] + $food;
		$x->food = $newFood > 9999 ? 9999 : $newFood;
		$x->sumFood = $food;
		
		$newProduction = $_SESSION['production'] + $production;
		$x->production = $newProduction > 9999 ? 9999 : $newProduction;
		$x->sumProduction = $production;
		
		$newCulture = $_SESSION['culture'] + $culture;
		$x->culture = $newCulture > 9999 ? 9999 : $newCulture;
		$x->sumCulture = $culture;
	}
	$x->foodMax = $_SESSION['foodMax'];
	$x->cultureMax = $_SESSION['cultureMax'];
	
	$_SESSION['food'] = $x->food;
	$_SESSION['production'] = $x->production;
	$_SESSION['culture'] = $x->culture;
	$x->delay = microtime(true) - $start;
	echo json_encode($x);
?>