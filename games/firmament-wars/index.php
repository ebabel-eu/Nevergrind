<?php
	session_start();
	if(php_uname('n')=="JOE-PC"){
		error_reporting(E_ALL);
		ini_set('display_errors', true);
	} else {
		error_reporting(0);
	}
	require('php/values.php');
	
	if(!isset($_SESSION['email']) || !strlen($_SESSION['email'])){
		header("Location: /login.php?back=/games/firmament-wars");
		exit();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head id='head'>
	<title>Firmament Wars | Grand Strategy Warfare</title>
	<meta charset="utf-8">
	<meta name="keywords" content="political, online, multiplayer, free, game, strategy">
	<meta name="description" content="Firmament Wars is a turn-based warfare strategy game created by Neverworks Games. Establish your nation, choose your flag, and select your dictator and vie for global domination.">
	<meta name="author" content="Joe Leonard">
	<meta name="referrer" content="always">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<meta name="viewport" content="width=1024,user-scalable=no">
	<meta name="twitter:widgets:csp" content="on">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="mobile-web-app-capable" content="yes">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel='stylesheet' type='text/css' href="css/fw1.css">
	<link rel="shortcut icon" href="/images1/favicon.png">
</head>

<body id="body">
	<div id="mainWrap" class="portal">
	
		<?php
			$svg = file_get_contents("images/flat5.svg");
			echo $svg;
		?>
	
		<div id="titleMain" class="portal">
			<header class="shadow4">
				<div id="headerWrap">
			<?php
				require_once('php/connect_plain.php');
				// crystals
				$query = "select crystals from accounts where email='".$_SESSION['email']."' limit 1";
				$result = $link->query($query);
				$crystals = '';
				while($row = $result->fetch_assoc()){
					$crystals .= $row['crystals'];
				}
				
				echo 
				'<div class="accountDetails text-primary">
					' . $_SESSION['account'] . ' <i class="fa fa-diamond" title="Never Crystals"></i>
					<span id="crystalCount" class="text-primary" title="Crystals Remaining">'.$crystals.'</span>&ensp;<a target="_blank" title="Manage Account" href="/account/?back=games/firmament-wars">Account</a>&ensp;
					<a target="_blank" title="Store" href="/store/">Store</a>&ensp;
					
				</div>
				<div class="pull-right text-primary">
					<a target="_blank" href="//www.youtube.com/user/Maelfyn">
						<i class="fa fa-youtube-square text-primary pointer" title="YouTube"></i>
					</a>
					<a target="_blank" href="//twitter.com/neverworksgames">
						<i class="fa fa-twitter-square text-primary pointer" title="Twitter"></i>
					</a>
					<a target="_blank" href="//www.facebook.com/neverworksgames">
						<i class="fa fa-facebook-square text-primary pointer" title="Facebook"></i>
					</a>
					Firmament Wars
				</div>';
				
				?>
				</div>
			</header>
			
			<div id="menu" class="fw-primary">
				<!-- SELECT count(row) FROM `fwplayers` where timestamp > date_sub(now(), interval 20 second) -->
				<div id='menuOnline' class='shadow4'>
					<div>
				<?php
					require('php/checkDisconnectsByAccount.php');
				
					$result = mysqli_query($link, 'select count(row) count from `fwplayers` where timestamp > date_sub(now(), interval 20 second)');
					// Associative array
					$row = mysqli_fetch_assoc($result);
					printf ("%s", 'There '. 
						($row["count"] == 1 ? 'is' : 'are')  .' currently '.$row["count"].' '.
						($row["count"] == 1 ? 'player' : 'players') . ' playing Firmament Wars'
					);
					echo '</div><div>';
					// check if nation exists; create if not
					$query = 'select count(row) from fwNations where account=?';
					$stmt = $link->prepare($query);
					$stmt->bind_param('s', $_SESSION['account']);
					$stmt->execute();
					$stmt->store_result(); // don't need
					$stmt->bind_result($dbcount);
					while($stmt->fetch()){
						$count = $dbcount;
					}
					$nation = 'Kingdom of '.ucfirst($_SESSION['account']);
					$flag = 'Default.jpg';
					if($count > 0){
						$query = "select nation, flag, wins, losses, disconnects from fwNations where account=?";
						$stmt = $link->prepare($query);
						$stmt->bind_param('s', $_SESSION['account']);
						$stmt->execute();
						$stmt->store_result();
						$stmt->bind_result($dName, $dFlag, $wins, $losses, $disconnects);
						while($stmt->fetch()){
							$nation = $dName;
							$flag = $dFlag;
							$wins = $wins;
							$losses = $losses;
							$disconnects = $disconnects;
							// show record
							echo 'Record: ' .$wins. ' wins, '. $losses .' losses, '. $disconnects .' disconnects';
						}
					} else {
						$query = "insert into fwNations (`account`, `nation`, `flag`) VALUES (?, '$nation', '$flag')";
						$stmt = $link->prepare($query);
						$stmt->bind_param('s', $_SESSION['account']);
						$stmt->execute();
						// show record; new nation
						echo 'Record: 0 wins, 0 losses, 0 disconnects';
					}
				?>
					</div>
				</div>
				<hr class='fancyhr'>
				<div id="menuHead" class="btn-group" role="group">
					<button id="refreshGames" type="button" class="btn btn-primary btn-responsive btn-md shadow4 active btn-head">Refresh Games</button>
					<button id="create" type="button" class="btn btn-primary btn-responsive btn-md shadow4 btn-head">Create</button>
					<button id="toggleNation" type="button" class="btn btn-primary btn-responsive btn-md shadow4 btn-head">Configure Nation</button>
				</div>
				<hr class="fancyhr">
				
				<div id="menuContent" class="shadow4"></div>
				<hr class="fancyhr">
				
				<div id="menuFoot" class="text-center">
					<button id="logout" type="button" class="btn btn-primary btn-xs shadow4">
						Logout
					</button>
				</div>
			</div>
			
			<div id="configureNation" class="fw-primary">
				<div class="row">
					<div class="col-xs-6">
						<img id="nationFlag" class="w100" src="images/flags/<?php echo $flag; ?>">
					</div>
					<div id="nationName" class="col-xs-6 shadow4 nation text-center"><?php echo $nation; ?></div>
				</div>
				<hr class="fancyhr">
				<div class="input-group">
					<span class="input-group-btn">
						<button id="submitNationName" class="btn btn-primary shadow4" type="button">Change Nation's Name</button>
					</span>
					<input id="updateNationName" class="form-control" type="text" maxlength="32" autocomplete="off" size="24" aria-describedby="updateNationNameStatus">
				</div>
				
				<hr class="fancyhr">
				<div class="row">
					<div class="col-xs-5">
						<select id="flagDropdown" class="form-control">
							<!-- flags -->
						</select>
						<div id="flagPurchased" class="flagPurchaseStatus">
							<hr class="fancyhr">
							<h4 class="text-center text-success shadow4">
								<i class="fa fa-check"></i>
								&ensp;Flag Purchased!
							</h4>
						</div>
						<div id="offerFlag" class="flagPurchaseStatus shadow4">
							<hr class="fancyhr">
							<h5 class="text-center">Buy flag for 100 Never Crystals?</h5>
							<div class="center block">
								<button id="buyFlag" type="button" class="btn btn-primary shadow4 text-primary" title="Purchase Flag">
									<i class="fa fa-diamond" title="Never Crystals"></i> 100
								</button>
							</div>
							<h4 class="text-center">
								<a target="_blank" href="/store/">Purchase Crystals</a>
							</h4>
						</div>
						
					</div>
					<div class="col-xs-7">
						<img id="updateNationFlag" class="w100 block center" src="images/flags/<?php echo $flag; ?>">
					</div>
				</div>
			</div>
		</div>
	
		<div id="joinGameLobby" class="shadow4">
			<div id="lobbyPlayers" class="fw-primary">
				<div id='lobby'>
					<div id='lobbyBody' class='clearfix'>
					</div>
				</div>
			</div>
			<div id="lobbyGame" class="fw-primary">
				<div class='text-primary text-center margin-top'>Game Name:</div> 
				<div id='lobbyGameName' class='text-center'></div>
				<div class='text-primary text-center margin-top'>Max Players:</div>
				<div id='lobbyGameMax' class='text-center'></div>
				<div class='text-primary text-center margin-top'>Map:</div>
				<div id='lobbyGameMap' class='text-center'></div>
			</div>
			<div id="lobbyButtons" class="fw-primary text-center">
				<button id='startGame' type='button' class='btn btn-default btn-md btn-block btn-responsive shadow4'>Start Game</button>
				<button id='cancelGame' type='button' class='btn btn-default btn-md btn-block btn-responsive shadow4'>Exit</button>
			</div>
		</div>
		
	</div>
	
	<div id="gameWrap">
		<div id="wrap-ui" class="ui-window stagBlue">
			<div id="diplomacy-ui" class="shadow4">
			</div>
			
			<div id="target-ui" class="container">
				<div class="row">
					<div id="target" class="col-xs-4 text-center no-select">
					</div>
					<div id="actions" class="col-xs-8">
					</div>
				</div>
			</div>
			
			<div id="resources-ui" class="container no-select shadow4">
				<div class="row">
					<div id='manpowerWrap' class="col-sm-12 no-padding">
						<span class="manpower" data-toggle="tooltip" title="You can deploy armies to any territory you have conquered">Armies</span>
					</div>
					<div>
						<span id="manpower">0</span>
					</div>
				</div>
				
				<div class="row">
					<div class="col-sm-12 no-padding food">
						<span data-toggle="tooltip" title="Food milestones produce new armies"><i class="glyphicon glyphicon-apple"></i> Food</span>
					</div>
				</div>
				
				<div class="row">
					<div class="col-sm-12 no-padding">
						<div class="resourceIndicator">
							<span id="food">0</span>/<span id="foodMax">25</span> (+<span id="sumFood">0</span>)
						</div>
					</div>
				</div>
				<!--
				<div class="row">
					<div class="col-sm-12 no-padding production">
						<span data-toggle="tooltip" title="Used to build structures and weapons"><i class="fa fa-gavel"></i> Production</span>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 no-padding nowrap resourceIndicator">
						<span id="production">0</span> (+<span id="sumProduction">0</span>)
					</div>
				</div>
				-->
				
				<div class="row">
					<div class="col-sm-12 no-padding culture">
						<span data-toggle="tooltip" title="Culture milestones produce special rewards"><i class="fa fa-flag"></i> Culture</span>
					</div>
				</div>
				
				<div class="row">
					<div class="col-sm-12 no-padding">
						<div class="resourceIndicator">
							<span id="culture">0</span>/<span id="cultureMax">400</span> (+<span id="sumCulture">0</span>)
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<table id="chat-ui" class="fw-text noselect">
			<tr>
				<td id="chat-content">
				</td>
			</tr>
		</table>
		<input id="chat-input" class="fw-text noselect nobg" type='text' maxlength="240" autocomplete="off"/>
		
		<div id="worldWrap">
			<?php
				$svg = file_get_contents("images/world_simple3.svg");
				echo $svg;
			?>
		</div>

		<audio id="bgmusic" autoplay preload="auto"></audio>
		
		<div id="hud" class="shadow4">Select Target</div>
		
		<div id="victoryScreen" class="fw-primary fw-text no-select"></div>
	
	<div id="Msg" class="shadow4"></div>
	<div id="overlay" class="portal"></div>
</body>
<script src="//cdnjs.cloudflare.com/ajax/libs/gsap/1.18.2/TweenMax.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/EaselJS/0.7.1/easeljs.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/gsap/1.15.0/plugins/EaselPlugin.min.js"></script>
<script src="js/libs/DrawSVGPlugin.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.5/utils/Draggable.min.js"></script>
<script src="js/libs/ScrambleTextPlugin.min.js"></script>
<script src="js/libs/SplitText.min.js"></script>
<script src="js/libs/ThrowPropsPlugin.min.js"></script> 
<script src="js/libs/MorphSVGPlugin.min.js"></script> 
<script src="js/libs/AttrPlugin.min.js"></script>
<script src="js/libs/bootstrap.min.js"></script>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/16327/findShapeIndex.js"></script>

<script>
	if (location.host === 'nevergrind.com'){
		if (location.hash !== "#beta"){
		}
	}
	patchVersion="0-0-1";
	(function(d){
		if(location.host==='localhost'){
			var _scriptLoader = [
				'core',
				'title',
				'lobby',
				'map',
				'game',
				'actions'
			];
		}else{
			var _scriptLoader = [
				'fw-'+patchVersion
			];
		}
		if (location.hash !== ""){
			var _scriptLoader = [
				'fw-'+patchVersion
			];
		}
		var target = d.getElementsByTagName('script')[0];
		for(var i=0, len=_scriptLoader.length; i<len; i++){
			var x=d.createElement('script');
			x.src = 'js/'+_scriptLoader[i]+'.js';
			x.async=false;
			target.parentNode.appendChild(x);
		}
	})(document);
</script>
<?php require($_SERVER['DOCUMENT_ROOT'] . "/includes/ga.php"); ?>
</html>