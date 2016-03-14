<?php
	require_once('connect1.php');
	
	$gameId = $_POST['gameId']*1;
	
	if (isset($_SESSION['gameId'])){
		$gameId = $_SESSION['gameId'];
	}
	
	$query = 'select g.name, count(p.game) players, g.max max, g.timer timer 
				from fwGames g 
				join fwplayers p 
				on g.row=p.game and p.timestamp > date_sub(now(), interval 5 second)
				where g.row=? 
				group by p.game';
	$stmt = $link->prepare($query);
	$stmt->bind_param('i', $gameId);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($dgameName, $dplayers, $dmax, $dtimer);
	while($stmt->fetch()){
		$gameName = $dgameName;
		$players = $dplayers;
		$max = $dmax;
		$timer = $dtimer;
	}
	
	$count = $stmt->num_rows;
	if ($players == 0){
		header('HTTP/1.1 500 All players have left the game');
		exit;
	}
	if ($players >= $max){
		header('HTTP/1.1 500 The game is full');
		exit;
	}
	
	$_SESSION['gameId'] = $gameId;
	$_SESSION['gameName'] = $gameName;
	$_SESSION['players'] = $players;
	$_SESSION['max'] = $max;
	$_SESSION['timer'] = $timer;
	
	// get account flag
	$_SESSION['nation'] = "";
	$_SESSION['flag'] = "";

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
	
	require('pingLobby.php');
	
	require('updateLobby.php');
?>