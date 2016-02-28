<?php
	require_once('connect1.php');
	$email = "xy@test.com";
	$query = "select row from item where slotType='bank' and email=?";
	$stmt = $link->prepare($query);
	$stmt->bind_param('s', $email);
	$stmt->execute();
	$stmt->store_result();
	$count = $stmt->num_rows;
	echo $count;
?>