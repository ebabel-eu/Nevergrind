<?php
	require_once('connect1.php');
	$flag = $_SESSION['flag'] === 'Default.jpg' ? 
		'<img src="images/flags/Player'.$_SESSION['player'].'" class="player'.$_SESSION['player'].' p'.$_SESSION['player'].'b inlineFlag">' :
		'<img src="images/flags/'.$_SESSION['flag'].'" class="player'.$_SESSION['player'].' p'.$_SESSION['player'].'b inlineFlag">';
	$message = $flag . $_SESSION['account'] . ': '. strip_tags($_POST['message']);
	
	$stmt = $link->prepare('insert into fwchat (`message`, `gameId`) values (?, ?);');
	$stmt->bind_param('si', $message, $_SESSION['gameId']);
	$stmt->execute();
	
	mysqli_query($link, 'delete from fwchat where timestamp < date_sub(now(), interval 20 second)');
?>