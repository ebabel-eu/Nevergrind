<?php
	require_once('connect1.php');
	
	$gameId = $_POST['gameId']*1;
	
	$query = 'select w.name, count(p.game) players, w.max max, w.timer timer from fwGames w join fwplayers p on w.row=p.game where w.row=? group by p.game';
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
	
	$_SESSION['gameId'] = $gameId;
	$_SESSION['gameName'] = $gameName;
	$_SESSION['players'] = $players;
	$_SESSION['max'] = $max;
	$_SESSION['timer'] = $timer;
	/* ??
	*/
	
	$count = $stmt->num_rows;
	if ($players == 0){
		header('HTTP/1.1 500 All players have left the game');
		exit;
	}
	if ($players >= $max){
		header('HTTP/1.1 500 The game is full');
		exit;
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
		$nation = $dNation;
		$flag = $dFlag;
	}

	// delete from fwPlayers
	$query = 'delete from fwPlayers where account=?';
	$stmt = $link->prepare($query);
	$stmt->bind_param('s', $_SESSION['account']);
	$stmt->execute();
	
	// insert into fwplayers
	$query = "insert into fwPlayers (`game`, `account`, `host`, `nation`, `flag`) values (?, ?, 0, ?, ?)";
	$stmt = $link->prepare($query);
	$stmt->bind_param('isss', $gameId, $_SESSION['account'], $nation, $flag);
	$stmt->execute();
	
	require('refreshLobby.php');
?>