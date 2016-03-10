<?php
	require_once('connect1.php');
	$name = $_POST['name'];
	$players = $_POST['players'];
	
	$len = strlen($name);
	if ($len < 4 || $len > 32){
		header('HTTP/1.1 500 Game name invalid');
		exit;
	}
	
	if ($players < 2 || $players > 8 || $players % 1 != 0){
		$players = 2;
	}
	
	$query = "select name from fwWars where name=?";
	$stmt = $link->prepare($query);
	$stmt->bind_param('s', $name);
	$stmt->execute();
	$stmt->store_result();
	$count = $stmt->num_rows;
	if ($count > 0){
		header('HTTP/1.1 500 Game name already exists.');
		exit;
	}
	
	// create game
	$query = "insert into fwWars (`name`, `max`) values (?, ?)";
	$stmt = $link->prepare($query);
	$stmt->bind_param('si', $name, $players);
	$stmt->execute();
	
	// get created game ID
	$min = 2;
	$query = "select row from fwWars where max>=? order by row desc limit 1";
	$stmt = $link->prepare($query);
	$stmt->bind_param('i', $min);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($dRow);
	while($stmt->fetch()){
		$gameId = $dRow;
	}
	// delete from fwPlayers
	$query = 'delete from fwPlayers where account=?';
	$stmt = $link->prepare($query);
	$stmt->bind_param('s', $_SESSION['account']);
	$stmt->execute();
	
	// insert into fwplayers
	$query = "insert into fwPlayers (`game`, `account`, `host`) values (?, ?, 1)";
	$stmt = $link->prepare($query);
	$stmt->bind_param('is', $gameId, $_SESSION['account']);
	$stmt->execute();
	
	echo 
	"<div id='lobby'>
		<div id='lobbyHead'>
			<div class='row'>
				<div class='col-xs-12 text-center'>
					<span class='text-primary'>Game Name:</span> {$name}
				</div>
			</div>
			<div class='row'>
				<div class='col-xs-12 text-center'>
					<span class='text-primary'>Max Players:</span> {$players}
				</div>
			</div>
		</div>
		<hr class='fancyhr'>
		
		<div class='row footMargin'>
			<div class='col-xs-3'>
				<img src='images/flags/Botswana.jpg' class='w100 block center'>
			</div>
			<div class='col-xs-3 text-center lobbyNationInfo'>
				<div class='text-warning'>Palmer</div>
				<div class='lobbyNationName'>Botswana</div>
			</div>
			<div class='col-xs-3'>
				<img src='images/flags/MAGA.jpg' class='w100 block center'>
			</div>
			<div class='col-xs-3 text-center lobbyNationInfo'>
				<div class='text-warning'>Donald</div>
				<div class='lobbyNationName'>MAGA</div>
			</div>
		</div>
		
		<div class='row footMargin'>
			<div class='col-xs-3'>
				<img src='images/flags/Spain.jpg' class='w100 block center'>
			</div>
			<div class='col-xs-3 text-center lobbyNationInfo'>
				<div class='text-warning'>Miguel</div>
				<div class='lobbyNationName'>Spain</div>
			</div>
			
			<div class='col-xs-3'>
				<img src='images/flags/South Korea.jpg' class='w100 block center'>
			</div>
			<div class='col-xs-3 text-center lobbyNationInfo'>
				<div class='text-warning'>Frank</div>
				<div class='lobbyNationName'>South Korea</div>
			</div>
		</div>
		
		<div class='row footMargin'>
			<div class='col-xs-3'>
				<img src='images/flags/Nepal.png' class='w100 block center'>
			</div>
			<div class='col-xs-3 text-center lobbyNationInfo'>
				<div class='text-warning'>Ben Garrison</div>
				<div class='lobbyNationName'>Nepal</div>
			</div>
			<div class='col-xs-3'>
				<img src='images/flags/Finland.jpg' class='w100 block center'>
			</div>
			<div class='col-xs-3 text-center lobbyNationInfo'>
				<div class='text-warning'>Hax0r 1337</div>
				<div class='lobbyNationName'>Finland</div>
			</div>
		</div>
		
		<div class='row footMargin'>
			<div class='col-xs-3'>
				<img src='images/flags/Brazil.jpg' class='w100 block center'>
			</div>
			<div class='col-xs-3 text-center lobbyNationInfo'>
				<div class='text-warning'>Jim</div>
				<div class='lobbyNationName'>Brazil</div>
			</div>
			<div class='col-xs-3'>
				<img src='images/flags/United Kingdom.jpg' class='w100 block center'>
			</div>
			<div class='col-xs-3 text-center lobbyNationInfo'>
				<div class='text-warning'>Bob</div>
				<div class='lobbyNationName'>United Kingdom</div>
			</div>
		</div>
		
		<hr class='fancyhr'>
		<div id='lobbyFoot' class='row text-center'>
			<button id='startGame' type='button' class='btn btn-info btn-md shadow3'>Start</button>
			<button id='cancelGame' type='button' class='btn btn-info btn-md shadow3'>Cancel</button>
		</div>
	</div>";
?>