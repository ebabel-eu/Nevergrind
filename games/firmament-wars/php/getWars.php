<?php
	require_once('connect1.php');
	$query = 'select row from fwWars';
	$result = $link->query($query);
	$count = $result->num_rows;
	
	if($count > 0){
		$str = 
		'<table class="table table-condensed table-borderless">
			<tr>
				<th class="col-md-6 warCells">Game</th>
				<th class="col-md-3 warCells">Players/Max</th>
				<th class="col-md-3 warCells">Time Limit</th>
			</tr>';
			
		// game data
		$query = 'select w.row row, w.name name, count(p.game) players, w.max max, w.timer timer from fwwars w join fwplayers p on w.row=p.game group by p.game having players > 0';
		$result = $link->query($query);
		while($row = $result->fetch_assoc()){
			$row['timer'] = $row['timer'] == 0 ? 'None' : $row['timer'];
			$str .= 
			"<tr class='wars' data-id='{$row['row']}'>
				<td class='col-md-6 warCells'>{$row['name']}</td>
				<td class='col-md-3 warCells'>{$row['players']}/{$row['max']}</td>
				<td class='col-md-3 warCells'>{$row['timer']}</td>
			</tr>";
		}
		
		$str .= "</table>";
		echo $str;
	} else {
		echo "No active games found. Create a game to play!";
	}
?>