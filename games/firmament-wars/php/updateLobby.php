<?php
	require_once('connect1.php');
	
	require('pingLobby.php');

	$str =  
	"<div id='lobby'>
		<div id='lobbyHead' class='row'>
			<div class='col-xs-12'>
				<button id='startGame' type='button' class='btn btn-info btn-md shadow3'>Start Game</button>
				<button id='cancelGame' type='button' class='btn btn-default btn-md shadow3'>Exit</button>
			
				<div class='pull-right pad-top'>
					<span class='text-primary'>Game Name:</span> {$_SESSION['gameName']}
					<span class='text-primary'>Max Players:</span> {$_SESSION['max']}
				</div>
				
			</div>
		</div>
		<hr class='fancyhr'>
		<div id='lobbyBody' class='clearfix'>";
		

		$query = "select distinct account, nation, flag, player from fwPlayers where game=? and timestamp > date_sub(now(), interval {$_SESSION['lag']} second) order by player";
		$stmt = $link->prepare($query);
		$stmt->bind_param('i', $_SESSION['gameId']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($account, $nation, $flag, $player);

		$players = 0;
		$count = 0;
		while($stmt->fetch()){
			$count++;
			if ($count % 2 == 1){
				$str .= "<div class='row lobbyRow'>";
			}
			$str .= "<div class='col-xs-3'>";
			if ($flag != "Default.jpg"){
				$str .= "<img src='images/flags/{$flag}' class='player{$player} w100 block center'>";
			} else {
				$str .= "<img src='images/flags/Player{$player}.jpg' class='player{$player} w100 block center'>";
			}
			$str .= "</div>
			<div class='col-xs-3 text-center lobbyNationInfo'>
				<div class='text-warning'>{$account}</div>
				<div class='lobbyNationName'>{$nation}</div>
			</div>";
			if ($count % 2 == 0){
				$str .= "</div>";
			}
		}
		if ($count % 2 == 1){
			$str .= "</div>";
		}
		
		$str .= 
		"</div>
	</div>";

	echo $str;
?>