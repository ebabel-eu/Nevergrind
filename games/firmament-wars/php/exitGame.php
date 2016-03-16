<?php
	require_once('connect1.php');
	
	if (isset($_SESSION['gameId'])){
		$query = 'delete from fwPlayers where account=?';
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $_SESSION['account']);
		$stmt->execute();
		require('unsetSession.php');
	} else {
		header('HTTP/1.1 500 Game session data not found.');
	}
?>