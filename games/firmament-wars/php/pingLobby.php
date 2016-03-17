<?php
	// delete from fwPlayers
	$query = 'delete from fwPlayers where account=?';
	$stmt = $link->prepare($query);
	$stmt->bind_param('s', $_SESSION['account']);
	$stmt->execute();
	
	// insert into fwplayers
	$query = "insert into fwPlayers (`game`, `account`, `host`, `nation`, `flag`, `player`) values (?, ?, 1, ?, ?, ?)";
	$stmt = $link->prepare($query);
	$stmt->bind_param('isssi', $_SESSION['gameId'], $_SESSION['account'], $_SESSION['nation'], $_SESSION['flag'], $_SESSION['player']);
	$stmt->execute();
?>