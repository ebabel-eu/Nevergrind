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
	$stmt->bind_result($dFood, $dProduction, $dCulture);
	
	while($stmt->fetch()){
		$_SESSION['food'] += $dFood;
		$_SESSION['production'] += $dProduction;
		$_SESSION['culture'] += $dCulture;
	}
	
	$x = new stdClass();
	$x->food = $_SESSION['food'];
	$x->production = $_SESSION['production'];
	$x->culture = $_SESSION['culture'];
	$x->delay = microtime(true) - $start;
	echo json_encode($x);
?>