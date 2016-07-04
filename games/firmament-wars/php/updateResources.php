<?php
	header('Content-Type: application/json');
	require_once('connect1.php');
	require_once('pingLobby.php');
	$start = microtime(true);
	// get game tiles
	$query = 'select sum(food), sum(production), sum(culture) from `fwTiles` where account=? and game=? limit 1';
	$stmt = $link->prepare($query);
	$stmt->bind_param('si', $_SESSION['account'], $_SESSION['gameId']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($food, $production, $culture);
	
	$x = new stdClass();
	while($stmt->fetch()){
		$newFood = $_SESSION['food'] + $food;
		$x->food = $newFood > 9999 ? 9999 : $newFood;
		$x->sumFood = $food;
		
		$newProduction = $_SESSION['production'] + $production;
		$x->production = $newProduction > 9999 ? 9999 : $newProduction;
		$x->sumProduction = $production;
		
		$newCulture = $_SESSION['culture'] + $culture;
		$x->culture = $newCulture > 9999 ? 9999 : $newCulture;
		$x->sumCulture = $culture;
	}
	$x->foodMax = $_SESSION['foodMax'];
	$x->cultureMax = $_SESSION['cultureMax'];
	$x->bonus = 0;
	
	// milestones?
	if ($x->food >= $_SESSION['foodMax']){
		function getManpowerReward(){
			$reward = 3 + $_SESSION['foodMilestone'];
			$foo = $_SESSION['foodMilestone'];
			if ($foo > 1){
				$reward++;
			}
			if ($foo > 5){
				$reward+=2;
			}
			if ($foo > 9){
				$reward+=4;
			}
			if ($foo > 14){
				$reward+=6;
			}
			if ($foo > 20){
				$reward+=8;
			}
			if ($foo > 27){
				$reward+=12; 
			}
			if ($foo > 35){
				$reward+=20; // max bonus 53 + 2 + 35
			}
			return $reward;
		}
		require('getReward.php');
		$x->food -= $_SESSION['foodMax'];
		$manpowerBonus = getManpowerReward();
		$_SESSION['manpower'] += $manpowerBonus;
		$_SESSION['foodMilestone']++;
		$_SESSION['foodMax'] = $_SESSION['foodMax'] + 25;
		// GET?!
		$query = "insert into fwGets (`account`) VALUES (?)";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $_SESSION['account']);
		$stmt->execute();
		
		$query = mysqli_query($link, 'select row from fwGets order by row desc limit 1');
		while ($row = mysqli_fetch_array($query)){
			$get = $row[0];
		}
		$x->get = $get*1;
		$bonus = getReward($get);
		$x->getBonus = $bonus->units;
		$_SESSION['manpower'] += $bonus->units;
		if ($_SESSION['manpower'] > 999){
			$_SESSION['manpower'] = 999;
		}
		// write GET to chat
		$flag = $_SESSION['flag'] === 'Default.jpg' ? 
			'<img src="images/flags/Player'.$_SESSION['player'].'" class="player'.$_SESSION['player'].' p'.$_SESSION['player'].'b inlineFlag">' :
			'<img src="images/flags/'.$_SESSION['flag'].'" class="player'.$_SESSION['player'].' p'.$_SESSION['player'].'b inlineFlag">';
			
		if ($bonus->units){
			$msg = $flag.'<span class="chat-get">' . $get . ' '.$bonus->msg.'! ' . $_SESSION['nation'] . ' receives ' . $manpowerBonus . ' (+' . $bonus->units . ' bonus) soldiers!</span>';
		} else {
			$msg = $flag.$get . ': ' . $_SESSION['nation'] . ' receives ' . $manpowerBonus . ' soldiers!';
		}
		$stmt = $link->prepare('insert into fwchat (`message`, `gameId`) values (?, ?);');
		$stmt->bind_param('si', $msg, $_SESSION['gameId']);
		$stmt->execute();
		
		mysqli_query($link, 'delete from fwchat where timestamp < date_sub(now(), interval 20 second)');
		
	}
	
	$_SESSION['food'] = $x->food;
	$_SESSION['production'] = $x->production;
	$_SESSION['culture'] = $x->culture;
	
	$x->manpower = $_SESSION['manpower'];
	$x->foodMax = $_SESSION['foodMax'];
	
	$x->delay = microtime(true) - $start;
	echo json_encode($x);
?>