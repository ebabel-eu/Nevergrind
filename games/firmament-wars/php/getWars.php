<?php
	require_once('connect1.php');

	$noGameFound = "<tr><td colspan='3' class='text-info col-md-12 warCells'>No active games found. Create a game to play!</td></tr>";

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
		$query = 'select w.row row, w.name name, count(p.game) players, w.max max, w.timer timer from fwGames w join fwplayers p on w.row=p.game group by p.game having players > 0 and players < max';
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