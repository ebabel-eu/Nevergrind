<?php
	require('connect1.php');
	require('battle.php');
	
	$attacker = new stdClass();
	$attacker->tile = $_POST['attacker'];
	
	$defender = new stdClass();
	$defender->tile = $_POST['defender'];
	
	if (isAdjacent($attacker->tile, $defender->tile)){
		$query = 'select tile, tileName, nation, flag, units, player, account from fwTiles where (tile=? or tile=?) and game=? limit 2';
		$stmt = $link->prepare($query);
		$stmt->bind_param('iii', $attacker->tile, $defender->tile, $_SESSION['gameId']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($tile, $tileName, $nation, $flag, $units, $player, $account);
		
		while($stmt->fetch()){
			if ($_POST['attacker'] == $tile){
				// use classes?
				$attacker->tile = $tile;
				$attacker->tileName = $tileName;
				$attacker->nation = $nation;
				$attacker->flag = $flag;
				$attacker->units = $units;
				$attacker->player = $player;
				$attacker->account = $account;
			} else {
				$defender->tile = $tile;
				$defender->tileName = $tileName;
				$defender->nation = $nation;
				$defender->flag = $flag;
				$defender->units = $units;
				$defender->player = $player;
				$defender->account = $account;
			}
		}
		$originalAttackingUnits = $attacker->units;
		$originalDefendingUnits = $defender->units;
		// add adjacent validation
		if ($defender->account == $_SESSION['account']){
			// move to allied territory
			if ($defender->units + $attacker->units > 255){
				$diff = (255 - ($defender->units + $attacker->units) ) * -1;
				$defender->units = $defender->units + $attacker->units - $diff;
				$attacker->units = $diff;
			} else {
				$defender->units = $defender->units + $attacker->units - 1;
				$attacker->units = 1;
			}
			// update attacker
			$query = 'update fwTiles set units=? where tile=? and game=?';
			$stmt = $link->prepare($query);
			$stmt->bind_param('iii', $attacker->units, $attacker->tile, $_SESSION['gameId']);
			$stmt->execute();
			// update defender
			$query = 'update fwTiles set units=? where tile=? and game=?';
			$stmt = $link->prepare($query);
			$stmt->bind_param('iii', $defender->units, $defender->tile, $_SESSION['gameId']);
			$stmt->execute();
		} else {
			if ($stmt->num_rows == 2 && 
				$attacker->units > 1 &&
				$defender->account != $_SESSION['account']){
				$result = battle($attacker->units, $defender->units);
				if ($result[0] > $result[1]){
					// victory
					$attacker->units = 1;
					$defender->units = $result[0] - $attacker->units;
					// update attacker
					$query = "update fwTiles set units=? where tile=? and game=?";
					$stmt = $link->prepare($query);
					$stmt->bind_param('iii', $attacker->units, $attacker->tile, $_SESSION['gameId']);
					$stmt->execute();
					// update defender
					$query = 'update fwTiles set nation=?, flag=?, units=?, player=?, account=? where tile=? and game=?';
					$stmt = $link->prepare($query);
					$stmt->bind_param('ssiisii', $attacker->nation, $attacker->flag, $defender->units, $attacker->player, $attacker->account, $defender->tile, $_SESSION['gameId']);
					$stmt->execute();
					
					if ($originalDefendingUnits > 0){
						// write victory to chat
						$atkFlag = $attacker->flag === 'Default.jpg' ? 
							'<img src="images/flags/Player'.$attacker->player.'" class="player'.$attacker->player.' p'.$attacker->player.'b inlineFlag">' :
							'<img src="images/flags/'.$attacker->flag.'" class="player'.$attacker->player.' p'.$attacker->player.'b inlineFlag">';
						$defFlag = '';
						// non-barbarian flag
						if ($defender->flag){
						$defFlag = $defender->flag === 'Default.jpg' ? 
							'<img src="images/flags/Player'.$defender->player.'" class="player'.$defender->player.' p'.$defender->player.'b inlineFlag">' :
							'<img src="images/flags/'.$defender->flag.'" class="player'.$defender->player.' p'.$defender->player.'b inlineFlag">';
						}
							
						$msg = $atkFlag. $attacker->nation . ' (' .$originalAttackingUnits. ') conquers ' . $defFlag . $defender->tileName. ' ('.$originalDefendingUnits.')';
						$stmt = $link->prepare('insert into fwchat (`message`, `gameId`) values (?, ?);');
						$stmt->bind_param('si', $msg, $_SESSION['gameId']);
						$stmt->execute();
						
						mysqli_query($link, 'delete from fwchat where timestamp < date_sub(now(), interval 20 second)');
					}
					
				} else {
					// defeat
					$attacker->units = $result[0];
					$defender->units = $result[1];
					// update attacker
					$query = 'update fwTiles set units=? where tile=? and game=?';
					$stmt = $link->prepare($query);
					$stmt->bind_param('iii', $attacker->units, $attacker->tile, $_SESSION['gameId']);
					$stmt->execute();
					// update defender
					$query = 'update fwTiles set units=? where tile=? and game=?';
					$stmt = $link->prepare($query);
					$stmt->bind_param('iii', $defender->units, $defender->tile, $_SESSION['gameId']);
					$stmt->execute();
					
					// write victory to chat
					$atkFlag = $attacker->flag === 'Default.jpg' ? 
						'<img src="images/flags/Player'.$attacker->player.'" class="player'.$attacker->player.' p'.$attacker->player.'b inlineFlag">' :
						'<img src="images/flags/'.$attacker->flag.'" class="player'.$attacker->player.' p'.$attacker->player.'b inlineFlag">';
					$defFlag = '';
					// non-barbarian flag
					if ($defender->flag){
					$defFlag = $defender->flag === 'Default.jpg' ? 
						'<img src="images/flags/Player'.$defender->player.'" class="player'.$defender->player.' p'.$defender->player.'b inlineFlag">' :
						'<img src="images/flags/'.$defender->flag.'" class="player'.$defender->player.' p'.$defender->player.'b inlineFlag">';
					}
						
					$msg = $atkFlag. $attacker->nation . ' (' .$originalAttackingUnits. ') is defeated in ' . $defFlag . $defender->tileName. ' ('.$originalDefendingUnits.')';
					$stmt = $link->prepare('insert into fwchat (`message`, `gameId`) values (?, ?);');
					$stmt->bind_param('si', $msg, $_SESSION['gameId']);
					$stmt->execute();
					
					mysqli_query($link, 'delete from fwchat where timestamp < date_sub(now(), interval 20 second)');
					
				}
			} else {
				header('HTTP/1.1 500 Invalid attack command.');
				exit();
			}
		}
	} else {
		header('HTTP/1.1 500 Invalid attack command.');
		exit();
	}
	echo "BATTLE COMPLETE:";
?>