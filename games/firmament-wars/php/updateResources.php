<?php
	header('Content-Type: application/json');
	require_once('connect1.php');
	$start = microtime(true);
	// get game tiles
	$query = "select sum(food), sum(production), sum(culture) from `fwTiles` where account=? and game=?";
	$stmt = $link->prepare($query);
	$stmt->bind_param('si', $_SESSION['account'], $_SESSION['gameId']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($food, $production, $culture);
	
	while($stmt->fetch()){
		$newFood = $_SESSION['food'] + $food;
		$food = $newFood > 9999 ? 9999 : $newFood;
		$newProduction = $_SESSION['production'] + $production;
		$production = $newProduction > 9999 ? 9999 : $newProduction;
		$newCulture = $_SESSION['culture'] + $culture;
		$culture = $newCulture > 9999 ? 9999 : $newCulture;
	}
	
	$x = new stdClass();
	$x->food = $food;
	$x->production = $production;
	$x->culture = $culture;
	$x->delay = microtime(true) - $start;
	echo json_encode($x);
?>