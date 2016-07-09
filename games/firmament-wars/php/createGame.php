<?php
	// create a new lobby 
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
		require('checkDisconnects.php');
	}
	// if maps are added, this will have to be POST'd
	$map = "Earth Alpha";
	// create game
	$query = "insert into fwGames (`name`, `max`, `map`) values (?, ?, ?)";
	$stmt = $link->prepare($query);
	$stmt->bind_param('sis', $name, $players, $map);
	$stmt->execute();
	
	// set session values
	$_SESSION['gameId'] = $stmt->insert_id*1;
	$_SESSION['max'] = $players;
	$_SESSION['gameName'] = $name;
	$_SESSION['gameStarted'] = 0;
	$_SESSION['player'] = 1;
	$_SESSION['map'] = $map;
	$_SESSION['food'] = 0;
	$_SESSION['foodMax'] = 25;
	$_SESSION['foodMilestone'] = 0;
	$_SESSION['production'] = 0;
	$_SESSION['culture'] = 0;
	$_SESSION['cultureMax'] = 400;
	$_SESSION['cultureMilestone'] = 0;
	$_SESSION['manpower'] = 0;
	$_SESSION['resourceTick'] = 0;
	// init chat
	$query = "select row from fwchat order by row desc limit 1";
	$stmt = $link->prepare($query);
	$stmt->execute();
	$stmt->bind_result($row);
	while($stmt->fetch()){
		$_SESSION['chatId'] = $row;
	}
	
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