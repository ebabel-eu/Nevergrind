<?php
	header('Content-Type: application/json');
	require_once('connect1.php');
	$x = new stdClass();
	$x->gameDone = 0;
	
	$stmt = $link->prepare('select player from fwtiles where game=? and player>0 and player=? group by account');
	$stmt->bind_param('ii', $_SESSION['gameId'], $_SESSION['player']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($player);
	if ($stmt->num_rows === 1){
		$x->gameDone = 1;
	}
	// I am the only player that has tiles left
	if (isset($_SESSION['gameId']) && $x->gameDone){
		$x->win = 1;
		$query = "insert into fwNations (`account`, `wins`, `games`) VALUES (?, 1, 1) on duplicate key update wins=wins+1, games=games+1";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $_SESSION['account']);
		$stmt->execute();
		
		$query = 'delete from fwPlayers where account=?';
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $_SESSION['account']);
		$stmt->execute();
		
		require('checkAllDisconnects.php');
		
		$x->gameName = $_SESSION['gameName'];
		$x->map = $_SESSION['map'];
		$x->duration = $_SESSION['resourceTick']*5;
		// delete game
		$query = 'delete from fwgames where row=?';
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $_SESSION['gameId']);
		$stmt->execute();
		
		unset($_SESSION['gameId']);
	}
	
	echo json_encode($x);
?>