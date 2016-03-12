<?php
	require_once('connect1.php');
	
	if (isset($_SESSION['gameId'])){
		$query = 'delete from fwPlayers where account=?';
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $_SESSION['account']);
		$stmt->execute();
		
		unset($_SESSION['gameId']);
		unset($_SESSION['players']);
		unset($_SESSION['max']);
		unset($_SESSION['timer']);
	} else {
		header('HTTP/1.1 500 Game session data not found.');
	}
?>