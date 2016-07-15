<?php
	header('Content-Type: application/json');
	session_start();
	if(php_uname('n')=="JOE-PC"){
		$link = mysqli_connect("localhost:3306","root","2M@elsw6","nevergrind");
	} else {
		$link = mysqli_connect("localhost", "nevergri_ng", "!M6a1e8l2f4y6n", "nevergri_ngLocal");
	}
	
	require($_SERVER['DOCUMENT_ROOT'] . '/games/firmament-wars/php/pingLobby.php');
	if ($_SESSION['resourceTick'] % 4 === 0){
		require('checkDisconnectsByGame.php');
	}
	// get game tiles
	$query = 'select sum(food), sum(culture) from `fwTiles` where account=?';
	$stmt = $link->prepare($query);
	$stmt->bind_param('s', $_SESSION['account']);
	$stmt->execute();
	$stmt->bind_result($food, $culture);
	
	$x = new stdClass();
	while($stmt->fetch()){
		$newFood = $_SESSION['food'] + $food;
		$x->food = $newFood > 9999 ? 9999 : $newFood;
		$x->sumFood = $food;
		/*
		$newProduction = $_SESSION['production'] + $production;
		$x->production = $newProduction > 9999 ? 9999 : $newProduction;
		$x->sumProduction = $production;
		*/
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
		// last insert id is GET value
		
		$x->get = $stmt->insert_id;
		$bonus = getReward($x->get);
		$x->getBonus = $bonus->units;
		$_SESSION['manpower'] += $bonus->units;
		if ($_SESSION['manpower'] > 999){
			$_SESSION['manpower'] = 999;
		}
		// write GET to chat
		$flag = $_SESSION['flag'] === 'Default.jpg' ? 
			'<img src="images/flags/Player'.$_SESSION['player'].'.jpg" class="player'.$_SESSION['player'].' p'.$_SESSION['player'].'b inlineFlag">' :
			'<img src="images/flags/'.$_SESSION['flag'].'" class="player'.$_SESSION['player'].' p'.$_SESSION['player'].'b inlineFlag">';
		$msg = '';
		if ($bonus->img){
			$msg .= '<img src="'. $bonus->img .'" class="chat-img">';
		}
		if ($bonus->units){
			$msg .= $flag.'<span class="chat-get">' . $x->get . ' '.$bonus->msg.'! ' . $_SESSION['nation'] . ' receives ' . $manpowerBonus . ' (+' . $bonus->units . ' bonus) armies!</span>';
		} else {
			$msg .= $flag.$x->get . ': ' . $_SESSION['nation'] . ' receives ' . $manpowerBonus . ' armies!';
		}
		$stmt = $link->prepare('insert into fwchat (`message`, `gameId`) values (?, ?);');
		$stmt->bind_param('si', $msg, $_SESSION['gameId']);
		$stmt->execute();
		
		mysqli_query($link, 'delete from fwchat where timestamp < date_sub(now(), interval 20 second)');
	}
	// culture milestone
	if ($x->culture >= $_SESSION['cultureMax']){
		$x->culture -= $_SESSION['cultureMax'];
		$_SESSION['cultureMax'] += 250;
		$_SESSION['cultureMilestone']++;
		// provide culture milestone here
	}
	
	$_SESSION['food'] = $x->food;
	// $_SESSION['production'] = $x->production;
	$_SESSION['culture'] = $x->culture;
	
	$x->manpower = $_SESSION['manpower'];
	$x->foodMax = $_SESSION['foodMax'];
	$x->cultureMax = $_SESSION['cultureMax'];
	
	$_SESSION['resourceTick']++;
	echo json_encode($x);
?>