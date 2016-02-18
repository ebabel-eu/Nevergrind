<?php
	session_start();
	if(php_uname('n')=="JOE-PC"){
		error_reporting(E_ALL);
		ini_set('display_errors', true);
	}
	require('php/values.php');
	
	if(strlen($_SESSION['email']) > 0){
		header("Location: /");
		exit();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Nevergrind | Login & Account Creation</title>
	<meta charset="utf-8">
	<meta name="author" content="Joe Leonard">
	<meta name="referrer" content="always">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<meta name="viewport" content="width=1280,user-scalable=no">
	<meta name="twitter:widgets:csp" content="on">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="mobile-web-app-capable" content="yes">
	<link rel='stylesheet' type='text/css' href="/css/global.css">
	<link rel="shortcut icon" href="/images1/favicon.ico">
</head>

<body id="curtain">
	<div id="window2">
		<header id="currencyIndicator" class="strongShadow">
		<?php
			echo 
			'<div class="accountDetails">
				<div id="crystals" class="crystalIcon accountValues"></div>
				<div id="crystalCount" class="accountValueText2">0</div>
			</div>';
			echo "<div class='modePanel'>";
				echo "Login & Account Creation";
			echo '</div>';
		?>
		</header>
		<div class="message blackOutline3"></div>
	<?php
		if($_SESSION['protocol']=="https:"){
			if(isset($_GET['reset'])){
				echo 
					'<form id="loginWrap" class="strongShadow">
						<div>Reset Your Password</div>
						<div class="textLeft">Password</div>
						<input type="password" id="resetPassword" class="loginInputs strongShadow" maxlength="20" placeholder="Password">
						<div class="textLeft">Re-type Password</div>
						<input type="password" id="resetVerifyPassword" class="loginInputs strongShadow" maxlength="20" placeholder="Verify Password">
						<div id="resetPW" class="strongShadow NGgradient">Reset Password</div>
					</form>';
			}else{
				echo 
					'<form id="loginWrap" class="strongShadow" autocomplete="on">
						<div id="createAccountWrap">
							<span id="createAccount">Create Account</span>
						</div>
						
						<div class="textLeft">Email Address</div>
						<input type="text" id="loginEmail" class="loginInputs strongShadow" maxlength="255" placeholder="Email Address" autocomplete="on" name="username">
						
						<div class="textLeft create-account signupHeader">Account Name</div>
						<input type="text" id="loginAccount" class="loginInputs strongShadow create-account" maxlength="16" placeholder="Account Name" name="user">
						
						<div class="textLeft">Password</div>
						<input type="password" id="loginPassword" class="loginInputs strongShadow" maxlength="20" placeholder="Password" autocomplete="on" name="password">
						
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
					</form>';
			}
		}
	?>
	</div><!-- window 2 -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	<script>
	$.ajaxSetup({
		type: 'POST',
		url: '/php/master1.php'
	});
	function QMsg(msg){
		var str = "<p>" + msg + "</p>";
		$(".message").html(str);
	}
	function createAccount() {
		if (createAccountLock === true) {
			return;
		}
		var pw = $("#loginPassword").val();
		var pw2 = $("#loginVerifyPassword").val();
		var acc = $("#loginAccount").val();
		var accRawLength = acc.length;
		var newAcc = acc.replace(/[^A-z]/gmi, '');
		if (acc.match(/[A-z]/gmi, '').length < accRawLength) {
			QMsg("Your account name should only contain letters.");
			return;
		}
		if (acc.length < 2) {
			QMsg("Your account name must be at least two characters long.");
			return;
		}
		if (acc.length > 16) {
			QMsg("Your account name must be less than 16 characters long.");
			return;
		}
		if (pw !== pw2) {
			QMsg("Your passwords do not match.");
			return;
		}
		if (pw.length < 6) {
			QMsg("Your password must be at least six characters long.");
			return;
		}
		QMsg("Connecting to server...");
		createAccountLock = true;
		$.ajax({
			data: {
				run: "createAccount",
				email: $("#loginEmail").val().toLowerCase(),
				account: newAcc.toLowerCase().toLowerCase(),
				password: pw,
				verify: pw2,
				promo: $("#promoCode").val().toLowerCase()
			}
		}).done(function(data) {
			QMsg(data + " Redirecting!");
			setTimeout(function(){
				location.reload();
			}, 1000);
			createAccountLock = false;
		}).fail(function() {
			QMsg("Could not contact the server!");
		});
	}
	function authenticate() {
		if (authenticationLock === true) {
			return;
		}
		if ($("#loginEmail").val().length < 3) {
			QMsg("This is not a valid email address.");
			return;
		}
		if ($("#loginPassword").val().length < 6) {
			QMsg("Passwords must be at least six characters long.");
			return;
		}
		QMsg("Connecting to server...");
		authenticationLock = true;
		if ($("#rememberEmail").prop('checked')) {
			var email = $("#loginEmail").val();
			localStorage.setItem('email', email);
		} else {
			localStorage.removeItem('email');
		}
		$.ajax({
			data: {
				run: "authenticate",
				email: $("#loginEmail").val().toLowerCase(),
				password: $("#loginPassword").val()
			}
		}).done(function(data) {
			if (data === "Login successful!") {
				location.reload();
			} else {
				QMsg(data);
			}
		}).fail(function() {
			QMsg("Could not contact the server!");
		}).always(function(){
			authenticationLock = false;
		});
	}
	$('#login').on('click', function() {
		var text = $(this).text();
		if (text === "Login") {
			// check password and login are ok
			authenticate();
		} else if (text === "Create Account") {
			createAccount();
		} else if (text === "Reset Password") {
			resetPassword();
		}
	});
	$("#createAccount").on('click', function() {
		var text = $(this).text();
		if (text === "Create Account") {
			$(this).text("Cancel");
			$(".create-account").css('display', 'block');
			$("#emailWrap").css('display', 'none');
			document.getElementById('login').textContent = "Create Account";
			$("#loginEmail, #loginPassword, #loginAccount, #loginVerifyPassword").val("");
			loginMode = "create";
		} else {
			$(this).text("Create Account");
			$(".create-account").css('display', 'none');
			$("#emailWrap").css('display', 'block');
			document.getElementById('login').textContent = "Login";
			$("#loginEmail, #loginPassword, #loginVerifyPassword, #promoCode").val("");
			loginMode = "login";
			if ($("#rememberEmail").prop('checked')) {
				var email = localStorage.getItem("email");
				$("#loginEmail").val(email);
			}
		}
	});
	$("#forgotPassword").on('click', function() {
		if (this.textContent === "Checking...") {
			return;
		}
		var email = $("#loginEmail").val().toLowerCase();
		var msg = "Forgot Password";
		$("#forgotPassword").text("Checking...");
		if (!email || email.length < 3) {
			QMsg("Enter a valid email address");
			$("#forgotPassword").text(msg);
			return;
		}
		QMsg("Checking account status...");
		$.ajax({
			data: {
				run: "forgotPassword",
				email: email
			}
		}).done(function(data) {
			QMsg(data, 0, 0, 8000);
			$("#forgotPassword").text(msg);
		});
	});
	
	var loginMode = "login",
		focusPassword = false,
		focusPasswordVerify = false,
		createAccountLock = false,
		buttonLock = false,
		authenticationLock = false;
		
	$("#loginPassword").on('focus', function() {
		focusPassword = true;
	}).on('blur', function() {
		focusPassword = false;
	});
	$("#loginVerifyPassword").on('focus', function() {
		focusPasswordVerify = true;
	}).on('blur', function() {
		focusPasswordVerify = false;
	});
	
	$(document).on('keydown',function(e){
		// hit enter
		if(e.keyCode===13){
			if(focusPassword===true&&loginMode==="login"){
				authenticate();
			}
			if(focusPasswordVerify===true&&loginMode==="create"){
				createAccount();
			}
		}
	});
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
</body>
</html>