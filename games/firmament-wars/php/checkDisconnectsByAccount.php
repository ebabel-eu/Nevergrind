<?php
	$query = "SELECT account FROM fwplayers where timestamp < date_sub(now(), interval {$_SESSION['lag']} second) and account=?";
	$stmt = $link->prepare($query);
	$stmt->bind_param('i', $_SESSION['account']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($account);
	
	
	if ($stmt->num_rows > 0){
		// delete from players
		$query = 'delete from fwPlayers where account=?';
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $_SESSION['account']);
		$stmt->execute();
		// add disconnect
		$query = "insert into fwNations (`account`, `disconnects`, `games`) VALUES (?, 1, 1) on duplicate key update disconnects=disconnects+1, games=games+1";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $_SESSION['account']);
		$stmt->execute();
	}
?>