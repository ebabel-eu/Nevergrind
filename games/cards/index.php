<?php
	session_start();
	/*
	if($_SESSION['protocol']=="https:"){
		if(php_uname('n')=="JOE-PC"){
			$_SESSION['STRIPE_TEST'] = 'sk_test_3zyOCnInUEhcpkM6H0FDegZr';
		}else{
			$_SESSION['STRIPE_LIVE'] = 'sk_live_GtiutFgWYDWNyXnaaL4ShHQt';
		}
	}
	if(php_uname('n')=="JOE-PC"){
		error_reporting(E_ALL);
		ini_set('display_errors', true);
	}
	require('php/values.php');
	if(isset($_SESSION['email'])){
		// nothing
	}else{
		$_SESSION['email'] = '';
		$_SESSION['account'] = '';
		$_SESSION['customerId'] = '';
	}
	if(isset($_GET['reset'])){
		$_SESSION['reset'] = $_GET['reset'];
		$hash = crypt($_SESSION['reset'], '$2a$07$'.$_SESSION['salt'].'$');
		$verify = crypt($_SESSION['reset'], $hash);
		if(php_uname('n')=="JOE-PC"){
			$link = mysqli_connect("localhost:3306","root","2M@elsw6","nevergrind");
		}else{
			$link = mysqli_connect("localhost", "nevergri_ng", "!M6a1e8l2f4y6n", "nevergri_ngLocal");
		}
		// 1-hour valid token
		$query = "select email from resetpassword where reset='".$_SESSION['reset']."' and timestamp>date_sub(now(), interval 1 hour)";
		$stmt = $link->prepare($query);
		$stmt->execute();
		$stmt->store_result();
		if($stmt->num_rows==0){
			// email address exists
			echo "Your token has expired. Tokens are valid for one hour. Reset your password again at <a href='//nevergrind.com'>Nevergrind</a>.";
			if(php_uname('n')!="JOE-PC"){
				exit;
			}
		}else{
			$stmt->bind_result($stmtEmail);
			while($stmt->fetch()){
				$_SESSION['tempEmail'] = $stmtEmail;
			}
		}
		// hash token
		$query = "select hashedReset from accounts where email=? limit 1";
		if($stmt = $link->prepare($query)){
			$stmt->bind_param('s', $_SESSION['tempEmail']);
			$stmt->execute();
			$stmt->store_result();
			$count = $stmt->num_rows;
			$stmt->bind_result($stmtPassword);
			while($stmt->fetch()){
				$dbPassword = $stmtPassword;
			}
			if($dbPassword!=$verify){
				// receives this error if they clicked twice or the token is wrong
				echo "Password reset failed due to mismatched or expired string! If you believe this is in error, contact <a href='mailto:support@nevergrind.com'>support@nevergrind.com</a> or visit <a href='//nevergrind.com'>Nevergrind</a> to reset your password again.";
				// exit if not localhost
				if(php_uname('n')!="JOE-PC"){ 
					exit;
				}
			}else{
				// sets hashedReset to nothing; only works once
				$query = 'update accounts set hashedReset="" where email=?';
				$stmt = $link->prepare($query);
				$stmt->bind_param('s', $_SESSION['tempEmail']);
				$stmt->execute();
			}
		}
	}else{
		unset($_SESSION['reset']);
		unset($_SESSION['tempEmail']);
	}
	*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Nevergrind Card Battle | Free Browser Card Game</title>
	<meta charset="utf-8">
	<meta name="keywords" content="fantasy, card, browser, free, game, f2p">
	<meta name="description" content="Nevergrind Card Battle is a free card battle game">
	<meta name="author" content="Joe Leonard">
	<meta name="referrer" content="always">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1"/>
	<meta name="viewport" content="width=1024,user-scalable=no">
	<meta name="twitter:widgets:csp" content="on">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="mobile-web-app-capable" content="yes">
	<link rel='stylesheet' type='text/css' href="css/cards.css">
	<link rel="shortcut icon" href="//nevergrind.com/images1/favicon.ico">
</head>

<body class='staggeredGrey'>
	<div id='main'>
<?php
	/*
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
			echo "Server Mode | Version 1-0-96";
		echo '</div>';
		*/
	?>
<?php
/*
if($_SESSION['protocol']=="https:"){
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
}
*/
?>
<?php
		/*
		if($_SESSION['protocol']=="https:"){
			echo '<div id="showCrystals" class="fire strongShadow2 NGgradient">
				Buy Crystals
				<div class="crystals crystals2"></div>
			</div>';
		}
		echo '<div id="createcharacter" class="strongShadow NGgradient">Create Character</div>';
		if($_SESSION['protocol']!="https:"){
			echo '<div id="deletecharacter" class="strongShadow NGgradient">Delete Character</div>';
		}
		*/
	?>
		<?php
			echo "<p>Updated ".date ("F d Y H:i:s", filemtime("index.php"))." CST</p>";
		?>
<?php
	/*
	if($_SESSION['protocol']=="https:"){
		if(isset($_GET['reset'])){
			echo '<div id="loginWrap" class="strongShadow">
					<div>Reset Your Password</div>
					<div class="textLeft">Password</div>
					<input type="password" id="resetPassword" class="loginInputs strongShadow" maxlength="20" placeholder="Password">
					<div class="textLeft">Re-type Password</div>
					<input type="password" id="resetVerifyPassword" class="loginInputs strongShadow" maxlength="20" placeholder="Verify Password">
					<div id="resetPW" class="strongShadow NGgradient">Reset Password</div>
			</div>';
		}else{
			echo '<div id="loginWrap" class="strongShadow">
					<div id="createAccountWrap">
						<span id="createAccount">Create Account</span>
					</div>
					<div class="textLeft">Email Address</div>
					<input type="text" id="loginEmail" class="loginInputs strongShadow" maxlength="255" placeholder="Email Address">
					<div class="textLeft create-account signupHeader">Account Name</div>
					<input type="text" id="loginAccount" class="loginInputs strongShadow create-account" maxlength="16" placeholder="Account Name">
					<div class="textLeft">Password</div>
					<input type="password" id="loginPassword" class="loginInputs strongShadow" maxlength="20" placeholder="Password">
					<div class="signupHeader create-account">Re-type Password</div>
					<input type="password" id="loginVerifyPassword" class="loginInputs strongShadow create-account" maxlength="20" placeholder="Verify Password">
					<p id="emailWrap">
						<input id="rememberEmail" type="checkbox" checked><label for="rememberEmail">Remember my email address</label>
					</p>
					<div class="signupHeader create-account">Promo Code</div>
					<input type="text" id="promoCode" class="loginInputs strongShadow create-account" maxlength="20" placeholder="Promo Code">
					<div id="tosWrap" class="create-account">
						<span id="tos" class="aqua">
							<a target="_blank" href="//nevergrind.com/blog/terms-of-service/">Terms of Service</a> | <a target="_blank" href="//nevergrind.com/blog/privacy-policy/">Privacy Policy</a>
						</span>
					</div>
					<div id="login" class="strongShadow NGgradient">Login</div>
					<div id="forgotPasswordWrap">
						<span title="Neverworks Games will send you an email. Click the link to reset your password." id="forgotPassword">Forgot Password?</span>
					</div>
			</div>';
		}
	}
	*/
	?>
	<?php
		if($_SESSION['protocol']=="https:"){
			echo '<p>Welcome to Nevergrind Card Battle</p>';
		}
	?>
	</div>
</body>
<script src="//cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/EaselJS/0.7.1/easeljs.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/gsap/1.15.0/plugins/EaselPlugin.min.js"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script>

patchVersion="0-0-1";
(function(d){
	var _scriptLoader;
	if(location.host==='localhost'){
		_scriptLoader = [
			'init'
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

if(location.protocol==="https:"){
	if(location.host==="localhost"){
		Stripe.setPublishableKey('pk_test_I7D5QZ64HRxIkWvYIVLhomLs');
	}else{
		Stripe.setPublishableKey('pk_live_1EVTTTw84wpPdLgWSIfB8d5E');
	}
}

if(location.hostname!=="localhost"){
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	ga('create', 'UA-35167620-1', 'auto');
	ga('send', 'pageview');
}

</script>
</html>