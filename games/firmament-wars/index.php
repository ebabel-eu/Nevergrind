<?php
	session_start();
	if(php_uname('n')=="JOE-PC"){
		error_reporting(E_ALL);
		ini_set('display_errors', true);
	}
	require('php/values.php');
	
	if(!isset($_SESSION['email']) || !strlen($_SESSION['email'])){
		header("Location: /login.php?back=games/firmament-wars");
		exit();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Firmament Wars | Ultimate Global Warfare Strategy Game</title>
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
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel='stylesheet' type='text/css' href="css/fw1.css">
	<link rel="shortcut icon" href="/images1/favicon.ico">
</head>

<body id="body">
	<header class="strongShadow">
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
		'<div class="accountDetails">
			<a target="_blank" title="Manage Account" class="accountValues accountValueText" href="/account.php?back=games/firmament-wars">'.
				$_SESSION['account'].
			'</a>&ensp;
			<div id="crystals" class="crystalIcon accountValues"></div>
			<div id="crystalCount" class="accountValueText2">'.$crystals.'</div>
		</div>
		<div class="modePanel">
			version 0.0.1
		</div>';
		
		?>
	</header>
	<div id="game">
		<div id="menu" class="fw-primary">
			<div id="menuHead" class="btn-group" role="group">
				<button id="" type="button" class="btn btn-primary btn-md shadow3">
					Create
				</button>
				<button id="" type="button" class="btn btn-primary btn-md shadow3">
					Join
				</button>
				<button id="toggleConfigureNation" type="button" class="btn btn-primary btn-md shadow3">
					Configure Nation
				</button>
			</div>
			
			<hr class="fancyhr">
			<div id="menuContent" class="shadow3">
				Contents stuffs goes here
			</div>
			<hr class="fancyhr">
			
			<div id="menuFoot" class="text-center">
				<button id="logout" type="button" class="btn btn-primary btn-xs shadow3">
					Logout
				</button>
			</div>
		</div>
		
		<div id="configureNation" class="fw-primary">
			<div class="row">
				<div class="col-md-6">
					<img class="w100" src="images/flags/usa.jpg">
				</div>
				<div class="col-md-6 shadow3 nation text-center">
					Kingdom of <?php echo ucfirst($_SESSION['account']); ?>
				</div>
			</div>
			<hr class="fancyhr">
			<div>Change Nation</div>
			<div>Change Flag</div>
		</div>
	
		<div id="battle">
			<img class="flag" src="images/flags/un.jpg">
			<img class="flag pull-right" src="images/flags/ussr.jpg">
		</div>
	
		<div id="chatId">
			<div id="chatLogWrap">
				<div id="chatLog" class='chatLogs'></div>
				<input type='text' id="chatInput" maxlength="240" autocomplete="off"></input>
			</div>
		</div>

		<audio id="bgmusic" autoplay preload="auto"></audio>
		
		<?php
			$svg = file_get_contents("images/world6.svg");
			echo $svg;
		?>
		
	<div id="overlay"></div>
	</div>
</body>
<script src="//cdnjs.cloudflare.com/ajax/libs/gsap/1.18.2/TweenMax.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/EaselJS/0.7.1/easeljs.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/gsap/1.15.0/plugins/EaselPlugin.min.js"></script>
<script src="js/libs/DrawSVGPlugin.min.js"></script>
<script src="js/libs/Draggable.min.js"></script> 
<script src="js/libs/ThrowPropsPlugin.min.js"></script> 
<script src="js/libs/MorphSVGPlugin.min.js"></script> 
<script src="js/libs/AttrPlugin.min.js"></script>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/16327/findShapeIndex.js"></script>

<script>
	patchVersion="0-0-1";
	(function(d){
		if(location.host==='localhost'){
			var _scriptLoader = [
				'core',
				'events'
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
<?php
	require($_SERVER['DOCUMENT_ROOT'] . "/includes/ga.php");
?>
</html>