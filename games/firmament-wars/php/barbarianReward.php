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
			$msg = 'After plundering farms in ' . $defender->tileName. ', we discovered ' . $amount . ' food in storage!';
			$_SESSION['foodReward'] += $amount;
		} else if ($reward === 1){
			// production
			$amount = 15 + ($tier * 5);
			$msg = 'After plundering mines in ' . $defender->tileName. ', we discovered '. $amount .' energy in storage!';
			$_SESSION['productionReward'] += $amount;
			
		} else if ($reward === 2){
			// culture
			$amount = 40 + ($tier * 10);
			$msg = 'After plundering temples in ' . $defender->tileName. ', we discovered ' . $amount . ' culture in storage!';
			$_SESSION['cultureReward'] += $amount;
			
		} else if ($reward === 3){
			// + 4-6 units at capital
			$amount = 4 + $tier;
			$msg = 'Your victory boosts morale in the homeland, yielding ' . $amount . ' armies in our capital!';
			// get capital unit value
			$query = 'select units from fwTiles where tile=? and game=?';
			$stmt = $link->prepare($query);
			$stmt->bind_param('ii', $_SESSION['capital'], $_SESSION['gameId']);
			$stmt->execute();
			$stmt->bind_result($units);
			
			while($stmt->fetch()){
				$capitalUnits = $units;
			}
			
			// update capital value
			$newTotal = $capitalUnits + $amount;
			$stmt = $link->prepare('update fwTiles set units=? where tile=? and game=?');
			$stmt->bind_param('iii', $newTotal, $_SESSION['capital'], $_SESSION['gameId']);
			$stmt->execute();
		} else if ($reward === 4){
			// +2-4 units at tile
			$amount = 2 + $tier;
			$msg = 'A local militia has decided to join you, yielding ' . $amount . ' armies in ' . $defender->tileName . '!';
			
			$newTotal = $defender->units + $amount;
			$stmt = $link->prepare('update fwTiles set units=? where tile=? and game=?');
			$stmt->bind_param('iii', $newTotal, $defender->tile, $_SESSION['gameId']);
			$stmt->execute();
			
		} else if ($reward === 5){
			// reveal food bonus
			$msg = 'The barbarian tribe reveals an unused granary yielding a +10% food bonus!';
			$_SESSION['foodBonus'] += 10;
			
		} else if ($reward === 6){
			// reveal energy bonus
			$msg = 'The barbarian tribe reveals an unused oil field in ' . $defender->tileName. ' yielding a +1 production bonus!';
			$_SESSION['turnBonus'] += 10;
			
		} else if ($reward === 7){
			// reveal culture bonus
			$msg = 'A Great Artist has joined us in ' . $defender->tileName. ' yielding a +10% culture bonus!';
			$_SESSION['cultureBonus'] += 10;
			
		} else if ($reward === 8){
			// offensive bonus
			$msg = 'A Great General has joined us! All armies receive a +1 offense bonus!';
			$_SESSION['oBonus']++;
			
		} else if ($reward === 9){
			// defensive bonus
			$msg = 'A Great Tactician has joined us! All armies receive +1 defense bonus!';
			$_SESSION['dBonus']++;
			
		}
		return $msg;
	}
?>