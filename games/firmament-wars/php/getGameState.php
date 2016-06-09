<?php
	header('Content-Type: application/json');
	require_once('connect1.php');
	
	require('pingLobby.php');
	
	$x = new stdClass();
	$x->timer = $_SESSION['timer'];
	$x->player = $_SESSION['player'];
	echo json_encode($x);
?>