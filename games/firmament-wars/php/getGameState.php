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
	// get chat/get $_SESSION['chatId'] = 0;
	$query = 'select row, message, msgType from fwchat where row > ? and gameId=? order by row';
	$stmt = $link->prepare($query);
	$stmt->bind_param('ii', $_SESSION['chatId'], $_SESSION['gameId']);
	$stmt->execute();
	$stmt->bind_result($row, $message, $msgType);
	$x->chat = array();
	$i = 0;
	while($stmt->fetch()){
		$o = new stdClass();
		$_SESSION['chatId'] = $row;
		$o->message = $message;
		$o->msgType = $msgType;
		$x->chat[$i++] = $o;
	}
	$x->chatId = $_SESSION['chatId'];
	$x->timeout = 1000;
	$x->delay = microtime(true) - $start;
	echo json_encode($x);
?>