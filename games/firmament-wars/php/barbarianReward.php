<?php
	function getBarbarianReward($attacker, $defender){
		global $link;
		$msg = 'No reward was found.';
		
		$reward = mt_rand(0,7);
		$tier = mt_rand(0,2);
		
		if ($reward === 3){
			// do I even own my capital?
			$query = 'select account from fwTiles where tile=? and game=?';
			$stmt = $link->prepare($query);
			$stmt->bind_param('ii', $_SESSION['capital'], $_SESSION['gameId']);
			$stmt->execute();
			$stmt->bind_result($account);
			
			while($stmt->fetch()){
				$capitalAccount = $account;
			}
			
			if ($capitalAccount !== $_SESSION['account']){
				$reward = 4;
			}
		}
		
		if ($reward === 0){
			// food
			$amount = 15 + ($tier * 5);
			$msg = 'After plundering their farms in ' . $defender->tileName. ', we discovered ' . $amount . ' food in storage!';
			$_SESSION['food'] += $amount;
		} else if ($reward === 1){
			// production
			$amount = 10 + ($tier * 5);
			$msg = 'After plundering their workshops in ' . $defender->tileName. ', we discovered ' . $amount . ' production in storage!';
			$_SESSION['production'] += $amount;
			
		} else if ($reward === 2){
			// culture
			$amount = 40 + ($tier * 10);
			$msg = 'After plundering their temples in ' . $defender->tileName. ', we discovered ' . $amount . ' culture in storage!';
			$_SESSION['culture'] += $amount;
			
		} else if ($reward === 3){
			// + units at capital
			$amount = 4 + $tier;
			$msg = 'The barbarian tribe have offered to defend our capital, yielding ' . $amount . ' armies in ' . $_SESSION['capital'] . '!';
			$newTotal = $defender->units + $amount;
			$stmt = $link->prepare('update fwTiles set units=? where tile=? and game=?');
			$stmt->bind_param('iii', $newTotal, $_SESSION['capital'], $_SESSION['gameId']);
			$stmt->execute();
		} else if ($reward === 4){
			// +2 units at tile
			$amount = 2 + $tier;
			$msg = 'The barbarian tribe has decided to join you, yielding ' . $amount . ' armies in ' . $defender->tileName . '!';
			
			$newTotal = $defender->units + $amount;
			$stmt = $link->prepare('update fwTiles set units=? where tile=? and game=?');
			$stmt->bind_param('iii', $newTotal, $defender->tile, $_SESSION['gameId']);
			$stmt->execute();
			
		} else if ($reward === 5){
			// reveal food to tile
			$amount = 2 + $tier;
			$msg = 'The barbarian tribe reveals a hidden granary yielding +' . $amount . ' food in ' . $defender->tileName. '!';
			
			$query = 'select food from fwTiles where tile=? and game=?';
			$stmt = $link->prepare($query);
			$stmt->bind_param('ii', $defender->tile, $_SESSION['gameId']);
			$stmt->execute();
			$stmt->bind_result($food);
			
			while($stmt->fetch()){
				$food = $food;
			}
			// should I update a bonus value instead?
			$food += $amount;
			$query = 'update fwTiles set food=? where tile=? and game=?';
			$stmt = $link->prepare($query);
			$stmt->bind_param('iii', $food, $defender->tile, $_SESSION['gameId']);
			$stmt->execute();
			
		} else if ($reward === 6){
			// reveal production to tile
			$amount = 2 + $tier;
			$msg = 'The barbarian tribe reveals a hidden workshop yielding +' . $amount . ' production in ' . $defender->tileName. '!';
			
			$query = 'select production from fwTiles where tile=? and game=?';
			$stmt = $link->prepare($query);
			$stmt->bind_param('ii', $defender->tile, $_SESSION['gameId']);
			$stmt->execute();
			$stmt->bind_result($production);
			
			while($stmt->fetch()){
				$production = $production;
			}
			// should I update a bonus value instead?
			$production += $amount;
			$query = 'update fwTiles set production=? where tile=? and game=?';
			$stmt = $link->prepare($query);
			$stmt->bind_param('iii', $production, $defender->tile, $_SESSION['gameId']);
			$stmt->execute();
			
		} else if ($reward === 7){
			// reveal culture to tile
			$amount = 3 + $tier;
			$msg = 'The barbarian tribe reveals ancient artifacts yielding +' . $amount . ' culture in ' . $defender->tileName. '!';
			
			$query = 'select culture from fwTiles where tile=? and game=?';
			$stmt = $link->prepare($query);
			$stmt->bind_param('ii', $defender->tile, $_SESSION['gameId']);
			$stmt->execute();
			$stmt->bind_result($culture);
			
			while($stmt->fetch()){
				$culture = $culture;
			}
			// should I update a bonus value instead?
			$culture += $amount;
			$query = 'update fwTiles set culture=? where tile=? and game=?';
			$stmt = $link->prepare($query);
			$stmt->bind_param('iii', $culture, $defender->tile, $_SESSION['gameId']);
			$stmt->execute();
			
		}
		return $msg;
	}
?>