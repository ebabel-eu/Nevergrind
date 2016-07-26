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
			$amount = 30 + ($tier * 10);
			$msg = 'Plunder! We discovered <span class="chat-food">' . $amount . ' food</span> in ' . $defender->tileName. '!';
			$_SESSION['foodReward'] += $amount;
		} else if ($reward === 1){
			// production
			$amount = 30 + ($tier * 5);
			$msg = 'Plunder! We discovered <span class="chat-production">'. $amount .' energy</span> in ' . $defender->tileName. '!';
			$_SESSION['productionReward'] += $amount;
			
		} else if ($reward === 2){
			// culture
			$amount = 60 + ($tier * 20);
			$msg = 'Plunder! We discovered <span class="chat-culture">' . $amount . ' culture</span> in ' . $defender->tileName. '!';
			$_SESSION['cultureReward'] += $amount;
			
		} else if ($reward === 3){
			// +6, 8, 10 units at capital
			$amount = 6 + ($tier * 2);
			$msg = 'Nationalist fervor yields <span class="chat-manpower">' . $amount . ' armies</span> in our capital!';
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
			// +4-6 units at tile
			$amount = 4 + $tier;
			$msg = 'A militia joins you in ' . $defender->tileName . ', yielding <span class="chat-manpower">' . $amount . ' armies!</span>';
			
			$newTotal = $defender->units + $amount;
			$stmt = $link->prepare('update fwTiles set units=? where tile=? and game=?');
			$stmt->bind_param('iii', $newTotal, $defender->tile, $_SESSION['gameId']);
			$stmt->execute();
			
		} else if ($reward === 5){
			// reveal food bonus
			$msg = 'The granary revealed in ' . $defender->tileName. ' boosts <span class="chat-food">food +10%!</span>';
			$_SESSION['foodBonus'] += 10;
			
		} else if ($reward === 6){
			// reveal energy bonus
			$msg = 'A mine revealed in ' . $defender->tileName. ' boosts <span class="chat-production">energy +10%!</span>';
			$_SESSION['turnBonus'] += 10;
			
		} else if ($reward === 7){
			// reveal culture bonus
			$msg = 'A famous artist in ' . $defender->tileName. ' boosts <span class="chat-culture">culture +10%!</span>';
			$_SESSION['cultureBonus'] += 10;
			
		}
		return $msg;
	}
?>