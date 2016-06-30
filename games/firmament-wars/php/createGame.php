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
	
	$query = "select count(p.game) players, g.name from fwGames g join fwPlayers p on g.row=p.game and g.name=? group by p.game having players > 0";
	
	$stmt = $link->prepare($query);
	$stmt->bind_param('s', $name);
	$stmt->execute();
	$stmt->store_result();
	$count = $stmt->num_rows;
	if ($count > 0){
		header('HTTP/1.1 500 Game name already exists.');
		exit;
	} else {
		// delete old game
		$query = 'delete from fwGames where name=?';
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $name);
		$stmt->execute();
		
		// delete from lobby
		$query = 'delete from fwPlayers where account=?';
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $_SESSION['account']);
		$stmt->execute();
	}
	// if maps are added, this will have to be POST'd
	$map = "Earth Alpha";
	// create game
	$query = "insert into fwGames (`name`, `max`, `map`) values (?, ?, ?)";
	$stmt = $link->prepare($query);
	$stmt->bind_param('sis', $name, $players, $map);
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
	
	// set session values
	$_SESSION['gameId'] = $gameId*1;
	$_SESSION['max'] = $players;
	$_SESSION['gameName'] = $name;
	$_SESSION['player'] = 1;
	$_SESSION['map'] = $map;
	$_SESSION['food'] = 0;
	$_SESSION['foodMax'] = 150;
	$_SESSION['production'] = 0;
	$_SESSION['culture'] = 0;
	$_SESSION['cultureMax'] = 400;
	
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
		$_SESSION['nation'] = $dNation;
		$_SESSION['flag'] = $dFlag;
	}
	require('updateLobby.php');
?>