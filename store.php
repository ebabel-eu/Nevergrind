<?php
	session_start();
	if(php_uname('n')=="JOE-PC"){
		error_reporting(E_ALL);
		ini_set('display_errors', true);
	}
	require('/php/values.php');
	
	if(!isset($_SESSION['email']) || !strlen($_SESSION['email'])){
		header("Location: /login.php");
		exit();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Nevergrind | Purchase Never Crystals</title>
	<meta charset="utf-8">
	<meta name="author" content="Joe Leonard">
	<meta name="referrer" content="always">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<meta name="viewport" content="width=1280,user-scalable=no">
	<meta name="twitter:widgets:csp" content="on">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="mobile-web-app-capable" content="yes">
	<link rel="shortcut icon" href="/images1/favicon.ico">
	<link rel='stylesheet' type='text/css' href="/css/global.css">
</head>

<body id="curtain">
	<div id="window2">
		<header id="currencyIndicator" class="strongShadow">
		<?php
			echo 
			'<div class="accountDetails">
				<div id="globalGold" class="accountValues"></div>
				<div id="globalGoldCount" class="accountValueText2">0</div>
			</div>';
			if($_SESSION['protocol']=="https:"){
				echo 
				'<div class="accountDetails">
					<div id="crystals" class="crystalIcon accountValues"></div>
					<div id="crystalCount" class="accountValueText2">0</div>
				</div>';
			}
			if($_SESSION['protocol']=='https:'){
				echo 
				'<div class="accountValueText accountDetails">
					Character Slots: <span id="characterSlots">0</span>
				</div>
				<div class="accountValueText accountDetails">
					Bank Slots: <span id="bankSlots">0</span>
				</div>';
				echo
				'<div id="sendEmailConfirmation" class="accountDetails accountValueText pointer raceClassButtonsOn ccActive">Confirm Account</div>';
			}else{
				echo 
				'<div class="accountValueText accountDetails">
					Character Slots: <span id="characterSlots">1</span>
				</div>
				<div class="accountValueText accountDetails">
					Bank Slots: <span id="bankSlots">1080</span>
				</div>';
			}
				echo "<div class='modePanel'>";
					echo "Server Mode | Version 1-0-98";
				echo '</div>';
			?>
		</header>
		<?php
			echo 
			'<div id="storeWrap" class="fire"></div>

			<div id="payment-form">
				<p class="centerFont">
					Purchase Never Crystals to unlock premium features in Nevergrind.
				</p>
				<div id="old-cards" class="strongShadow">
					<hr class="fancyHR">
					<div id="last-credit-card" class="noSelect" data-oldcard="false">Use credit card: **** **** **** <span id="CC-last-four">****</span></div>
					<div class="centerize">
						<button id="deleteCards" class="NGgradient strongShadow">Delete Card</button>
					</div>
				</div>
				<div id="newCard">
					<hr class="fancyHR">
					<p>
						<div>Card Number (no spaces or hyphens)</div>
						<input id="card-number" type="text" size="20" maxlength="16" autocomplete="off">
					</p>
					<p>
						<div>CVC (number on the back of your credit card)</div>
						<input id="card-cvc" type="text" size="4" maxlength="4" autocomplete="off">
					</p>
					<p>
						<div>Expiration Month/Year (MM/YYYY)</div>
						<input id="card-month" type="text" size="2" maxlength="2"> / 
						<input id="card-year" type="text" size="4" maxlength="4">
					</p>
					<p>
						<input id="rememberCard" type="checkbox" checked><label for="rememberCard">Remember me</label>
					</p>
				</div>
				<hr class="fancyHR">
				<div id="crystalWrap" class="strongShadow">
					<div data-amount="100" class="floater purchase">
						$1 
						<div class="crystals"></div>
					</div>
					<div data-amount="500" class="floater">
						$5
						<div class="crystals"></div>
					</div>
					<div data-amount="1000" class="floater">
						$10
						<div class="crystals"></div>
					</div>
				</div>
				<div id="crystalsExplained">$1 will purchase 70 Never Crystals</div>
				<div id="payment-errors" class="red"></div>
				<div class="centerize">
					<button id="payment-confirm" class="NGgradient strongShadow">Submit</button>
				</div>
				<hr class="fancyHR">
					<center>
						<div>To pay via PayPal, send your payment to:</div>
						<div><a target="_blank" href="mailto:support@nevergrind.com">support@nevergrind.com</a></div>
					</center>
			</div>';
		?>
			
	</div><!-- window 2 -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/EaselJS/0.7.1/easeljs.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/gsap/1.15.0/plugins/EaselPlugin.min.js"></script>
	<script>
		patchVersion="1-0-98";
		(function(d){
			if(location.host==='localhost'){
				var _scriptLoader = [
					'functions4',
					'core',
					'battle',
					'skills',
					'monsters',
					'quests',
					'town',
					'items',
					'ui'
				];
			}else{
				var _scriptLoader = [
					'nevergrind-'+patchVersion
				];
			}
			if (location.hash !== ""){
				var _scriptLoader = [
					'nevergrind-'+patchVersion
				];
			}
			var target = d.getElementsByTagName('script')[0];
			for(var i=0, len=_scriptLoader.length; i<len; i++){
				var x=d.createElement('script');
				x.src = 'scripts/'+_scriptLoader[i]+'.js';
				x.async=false;
				target.parentNode.appendChild(x);
			}
		})(document);
	</script>
	
	<script>
		if(location.hostname!=="localhost"){
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
			ga('create', 'UA-35167620-1', 'auto');
			ga('send', 'pageview');
		}
	</script>
	<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
	<script>
		if(location.protocol==="https:"){
			if(location.host==="localhost"){
				Stripe.setPublishableKey('pk_test_I7D5QZ64HRxIkWvYIVLhomLs');
			}else{
				Stripe.setPublishableKey('pk_live_1EVTTTw84wpPdLgWSIfB8d5E');
			}
		}
		function checkCC() {
			$.ajax({
				data: {
					run: "checkCC"
				}
			}).done(function(data) {
				if (data != "cardNotFound") {
					$('#CC-last-four').text(data);
					$('#old-cards').css({
						display: 'block'
					});
					$("#last-credit-card").trigger('click');
				}
			});
		}
	
	</script>
</body>
</html>