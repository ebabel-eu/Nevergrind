<?php
	require('values.php');
	session_start();
	
	// echo session
	if (isset($_SESSION['email'])){
		echo "email: " . $_SESSION['email'];
		echo "<br>account: " . $_SESSION['account'];
	}
	if (isset($_SESSION['max'])){
		echo "<br>gameId: " . $_SESSION['gameId'];
		echo "<br>max: " . $_SESSION['max'];
		echo "<br>gameName: " . $_SESSION['gameName'];
		echo "<br>gameStarted: " . $_SESSION['gameStarted'];
		echo "<br>gameType: " . $_SESSION['gameType'];
		echo "<br>player: " . $_SESSION['player'];
		echo "<br>map: " . $_SESSION['map'];
		echo "<br>food: " . $_SESSION['food'];
		echo "<br>foodMax: " . $_SESSION['foodMax'];
		echo "<br>foodMilestone: " . $_SESSION['foodMilestone'];
		echo "<br>production: " . $_SESSION['production'];
		echo "<br>culture: " . $_SESSION['culture'];
		echo "<br>cultureMax: " . $_SESSION['cultureMax'];
		echo "<br>cultureMilestone: " . $_SESSION['cultureMilestone'];
		echo "<br>manpower: " . $_SESSION['manpower'];
		echo "<br>capital: " . $_SESSION['capital'];
		echo "<br>chatId: " . $_SESSION['chatId'];
		echo "<br>resourceTick: " . $_SESSION['resourceTick'];
	} else {
		echo '<br>Game values not detected in session.';
	}
	echo "<hr>";
	
	$start = microtime(true);
	
	/*
	
	$attacker = new stdClass();
	$attacker->units = 10;
	
	$defender = new stdClass();
	$defender->units = 10;
	
	function battle($x, $y){
		$oBonus = 0; // + atk 500
		$dBonus = 0; // + def 500
		// add o tile bonus 
		// add d tile bonus 
		// $oTileUpgrades = [0, 16, 32, 48];
		// $dTileUpgrades = [0, 30, 40, 50];
		// Math.ceil(Math.random() * (6 + bonus)) + (Math.random() * 100 < oTile ? 3 : 0);
		
		// add o general bonus 750
		// add d general bonus 750
		
		while ($y > 0 && $x > 1){
			$diceX = $x > 2 ? 3 : 2;
			$diceY = $y > 1 ? 2 : 1;
			$xRoll = array();
			$yRoll = array();
			
			$x -= $diceX;
			$y -= $diceY;
			for ($i=0; $i<$diceX; $i++){
				$die = ceil(mt_rand(0, 6000 + $oBonus)/1000);
				array_push($xRoll, $die);
			}
			for ($i=0; $i<$diceY; $i++){
				$die = ceil(mt_rand(0, 6000 + $dBonus)/1000);
				array_push($yRoll, $die);
			}
			
			rsort($xRoll);
			rsort($yRoll);
			
			while( ($x && count($xRoll) > 0 || !$x && 
				count($xRoll) > 1) && 
				count($yRoll) > 0){
				$xRoll[0] > $yRoll[0] ? $diceY-=1 : $diceX-=1;
				$xRoll = array_slice($xRoll, 1);
				$yRoll = array_slice($yRoll, 1);
			}
			$x += $diceX;
			$y += $diceY;
		}
		
		return array($x, $y);
	}
	
	function isAdjacent($x, $y){
		if ($_SESSION['map'] == 'Earth Alpha'){
			require('adjEarthAlpha.php');
		}
		return in_array($y, $adj[$x]);
	}
	
	$result = battle($attacker->units, $defender->units);
	$foo = ceil(mt_rand(0, 6000 + 0)/1000);
	echo $foo.'<br>';
	
	echo "Is adjacent? ". isAdjacent(0, 1) . "<BR>";
	echo $result[0] . " " . $result[1] . "<BR>";
	 //Enter your code here, enjoy!
    // $start = microtime(true);
    $x = "";
    
    for ($i=0; $i<1000; $i++){
		require_once('adjEarthAlpha.php');
    }
	$x = new stdClass();
	$x->reward = 0;
	function getReward(){
	}
	getReward();
	*/
	
	/*
	$query = "select crystals from accounts where email='".$_SESSION['email']."' limit 1";
	$result = $link->query($query);
	while($row = $result->fetch_assoc()){
		$crystals .= $row['crystals'];
	}
	*/
	// require('connect1.php');
		
	if (isset($_SESSION['account'])){
		for ($i=0; $i<500; $i++){
			require('connect1.php');
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
				
				$newCulture = $_SESSION['culture'] + $culture;
				$x->culture = $newCulture > 9999 ? 9999 : $newCulture;
				$x->sumCulture = $culture;
			}
			$x->foodMax = $_SESSION['foodMax'];
			$x->cultureMax = $_SESSION['cultureMax'];
			$x->bonus = 0;
			if ($x->culture >= $_SESSION['cultureMax']){
				$x->culture -= $_SESSION['cultureMax'];
				$_SESSION['cultureMax'] += 250;
				$_SESSION['cultureMilestone']++;
				// provide culture milestone here
			}
			
			$_SESSION['food'] = $x->food;
			$_SESSION['culture'] = $x->culture;
			
			$x->manpower = $_SESSION['manpower'];
			$x->foodMax = $_SESSION['foodMax'];
			$x->cultureMax = $_SESSION['cultureMax'];
			
			$_SESSION['resourceTick']++;
		}
	}
	echo "<hr>";
	echo "<br>". (microtime(true) - $start);
	
	// UPDATE fwtiles 
    // SET `food` = `food` + 1
    // WHERE game=517 and tile=40;
	
	
	
	
	
	
	
	
	
	
	
	
	
	// updateResources.php
	/*
		// get game tiles
		$query = 'select sum(food), sum(production), sum(culture) from `fwTiles` where account=?';
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $_SESSION['account']);
		$stmt->execute();
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
		if ($x->culture >= $_SESSION['cultureMax']){
			$x->culture -= $_SESSION['cultureMax'];
			$_SESSION['cultureMax'] += 250;
			$_SESSION['cultureMilestone']++;
			// provide culture milestone here
		}
		
		$_SESSION['food'] = $x->food;
		$_SESSION['production'] = $x->production;
		$_SESSION['culture'] = $x->culture;
		
		$x->manpower = $_SESSION['manpower'];
		$x->foodMax = $_SESSION['foodMax'];
		$x->cultureMax = $_SESSION['cultureMax'];
		
		$_SESSION['resourceTick']++;
		*/
	
	
	// getGameState.php
		/*
		$stmt = $link->prepare('select player, units from `fwTiles` where game=? order by tile');
		$stmt->bind_param('i', $_SESSION['gameId']);
		$stmt->execute();
		$stmt->bind_result($player, $units);
		
		$x = new stdClass();
		$x->tiles = [];
		$x->player =[0,0,0,0,0,0,0,0,0];
		$count = 0;
		while($stmt->fetch()){
			$o = new stdClass();
			$o->player = $player;
			$o->units = $units;
			$x->tiles[$count++] = $o;
			//$x->player[$player] = 1;
		}
		// chat
		$stmt = $link->prepare('select row, message from fwchat where row > ? and gameId=? order by row');
		$stmt->bind_param('ii', $_SESSION['chatId'], $_SESSION['gameId']);
		$stmt->execute();
		$stmt->bind_result($row, $message);
		$x->chat = [];
		$z = 0;
		while($stmt->fetch()){
			$o = new stdClass();
			$_SESSION['chatId'] = $row;
			$o->message = $message;
			$x->chat[$z++] = $o;
		}
		$x->chatId = $_SESSION['chatId'];
		*/
	
	
	
?>