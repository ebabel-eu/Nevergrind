<?php
	require_once('connect1.php');
	
	require('pingLobby.php');

	$str =  
	"<div id='lobby'>
		<div id='lobbyHead'>
			<div class='row'>
				<div class='col-xs-12 text-center'>
					<span class='text-primary'>Game Name:</span> {$_SESSION['gameName']}
				</div>
			</div>
			<div class='row'>
				<div class='col-xs-12 text-center'>
					<span class='text-primary'>Max Players:</span> {$_SESSION['max']}
				</div>
			</div>
		</div>
		<hr class='fancyhr'>
		<div class='clearfix'>";
		

		$query = "select account, nation, flag, player from fwPlayers where game=? and timestamp > date_sub(now(), interval {$_SESSION['lag']} second) order by player";
		$stmt = $link->prepare($query);
		$stmt->bind_param('i', $_SESSION['gameId']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($account, $nation, $flag, $player);

		$players = 0;
		while($stmt->fetch()){
			$str .= "<div class='col-xs-3 pull-left'>";
			if ($flag != "Default.jpg"){
				$str .= "<img src='images/flags/{$flag}' class='w100 block center'>";
			} else {
				$str .= "<div class='defaultFlag player{$player} w100 block center'></div>";
			}
			$str .= "</div>
			<div class='col-xs-3 text-center lobbyNationInfo pull-left'>
				<div class='text-warning'>{$account}</div>
				<div class='lobbyNationName'>{$nation}</div>
			</div>";
		}
		
		$str .= 
		"</div>
		<hr class='fancyhr'>
		<div id='lobbyFoot' class='row text-center'>
			<button id='startGame' type='button' class='btn btn-info btn-md shadow3'>Start Game</button>
			<button id='cancelGame' type='button' class='btn btn-default btn-md shadow3'>Exit</button>
		</div>
	</div>";

	echo $str;
?>