<?php
	session_start();
	if(php_uname('n')=="JOE-PC"){
		error_reporting(E_ALL);
		ini_set('display_errors', true);
	}
	require('/php/values.php');
	
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
	<link rel='stylesheet' type='text/css' href="css/fw1.css">
	<link rel="shortcut icon" href="/images1/favicon.ico">
</head>

<body>
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
	
	<div id="chatId">
		<div id="chatLogWrap">
			<div id="chatLog" class='chatLogs'></div>
			<input type='text' id="chatInput" maxlength="240" autocomplete="off"></input>
		</div>
	</div>

	<audio id="bgmusic" autoplay preload="auto"></audio>
</body>
<script src="//cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/EaselJS/0.7.1/easeljs.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/gsap/1.15.0/plugins/EaselPlugin.min.js"></script>
<script>
	patchVersion="0-0-1";
	(function(d){
		if(location.host==='localhost'){
			var _scriptLoader = [
				'core',
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