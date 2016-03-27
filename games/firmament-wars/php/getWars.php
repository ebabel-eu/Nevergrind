<?php
	require_once('connect1.php');

	$noGameFound = "<tr><td colspan='3' class='text-warning text-center col-md-12 warCells'>No active games found. Create a game to play!</td></tr>";

	$query = 'select row from fwGames';
	$result = $link->query($query);
	$count = $result->num_rows;
	
	$str = 
	'<table id="getWars" class="table table-condensed table-borderless">
		<tr>
			<th class="col-md-6 warCells">Game</th>
			<th class="col-md-3 warCells">Players/Max</th>
			<th class="col-md-3 warCells">Time Limit</th>
		</tr>';
	if($count > 0){
			
		// game data
		$query = "select g.row row, min(p.player) host, g.name name, count(p.game) players, g.max max, g.timer timer from fwGames g join fwplayers p on g.row=p.game and p.timestamp > date_sub(now(), interval {$_SESSION['lag']} second) group by p.game having players > 0 and host=1 order by p.account";
		
		$result = $link->query($query);
		$count = $result->num_rows;
		if ($count > 0){
			while($row = $result->fetch_assoc()){
				$row['timer'] = $row['timer'] == 0 ? 'None' : $row['timer'];
				$str .= "<tr class='wars' data-id='{$row['row']}'>
					<td class='col-md-6 warCells'>{$row['name']}</td>
					<td class='col-md-3 warCells'>{$row['players']}/{$row['max']}</td>
					<td class='col-md-3 warCells'>{$row['timer']}</td>
				</tr>";
			}
			$str .=
			"<tr><td class='col-md-6'></td><td class='col-md-3'></td>
			<td class='col-md-3'>
				<button id='joinGame' type='button' class='btn btn-md btn-info shadow3'>Join Game</button>
			</td></tr>";
		} else {
			$str .= $noGameFound;
		}
	} else {
		$str .= $noGameFound;
	}
	$str .= "</table>";
	echo $str;
?>