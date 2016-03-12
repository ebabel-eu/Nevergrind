<?php
	require_once('connect1.php');
	$name = $_POST['name'];
	$players = $_POST['players'];
	
	$len = strlen($name);
	if ($len < 4 || $len > 32){
		header('HTTP/1.1 500 Game name invalid');
		exit;
	}
	
	if ($players < 2 || $players > 8 || $players % 1 != 0){
		$players = 2;
	}
	
	$_SESSION['gameName'] = $name;
	$_SESSION['max'] = $players;
	
	$query = "select name from fwGames where name=?";
	$stmt = $link->prepare($query);
	$stmt->bind_param('s', $name);
	$stmt->execute();
	$stmt->store_result();
	$count = $stmt->num_rows;
	if ($count > 0){
		header('HTTP/1.1 500 Game name already exists.');
		exit;
	}
	
	// create game
	$query = "insert into fwGames (`name`, `max`) values (?, ?)";
	$stmt = $link->prepare($query);
	$stmt->bind_param('si', $name, $players);
	$stmt->execute();
	
	// get created game ID
	$min = 2;
	$query = "select row from fwGames where max>=? order by row desc limit 1";
	$stmt = $link->prepare($query);
	$stmt->bind_param('i', $min);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($dRow);
	while($stmt->fetch()){
		$gameId = $dRow;
	}
	$_SESSION['gameId'] = $gameId*1;

	// get account flag
	$nation = "";
	$flag = "";

	$query = "select nation, flag from fwNations where account=?";
	$stmt = $link->prepare($query);
	$stmt->bind_param('s', $_SESSION['account']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($dNation, $dFlag);
	$count = $stmt->num_rows;
	if ($count < 1){
		header('HTTP/1.1 500 Cannot access nation data.');
		exit;
	}
	while($stmt->fetch()){
		$nation = $dNation;
		$flag = $dFlag;
	}

	// delete from fwPlayers
	$query = 'delete from fwPlayers where account=?';
	$stmt = $link->prepare($query);
	$stmt->bind_param('s', $_SESSION['account']);
	$stmt->execute();
	
	// insert into fwplayers
	$query = "insert into fwPlayers (`game`, `account`, `host`, `nation`, `flag`) values (?, ?, 1, ?, ?)";
	$stmt = $link->prepare($query);
	$stmt->bind_param('isss', $gameId, $_SESSION['account'], $nation, $flag);
	$stmt->execute();
	
	require('refreshLobby.php');
?>