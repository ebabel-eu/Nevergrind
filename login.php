<?php
	session_start();
	
	if($_SERVER["SERVER_NAME"] === "localhost"){
		error_reporting(E_ALL);
		ini_set('display_errors', true);
	}
	require('php/values.php');
	
	if(isset($_SESSION['email'])){
		if(strlen($_SESSION['email']) > 0){
			header("Location: /");
			exit();
		}
	}
	$refer = isset($_GET['back']) ? $_GET['back'] : "/";
	// redirect if set
	if(strlen($_SESSION['email'])){
		header('Location: ' . $refer);
		exit();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Nevergrind | Login & Account Creation</title>
	<meta name="viewport" content="width=1280,user-scalable=no">
	<link rel='stylesheet' type='text/css' href="/css/global.css">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<?php
		include($_SERVER['DOCUMENT_ROOT'] . "/includes/head.html");
	?>
	<style>
		#currencyIndicator{
			width: 100%;
		}
		#mainBG{
			width: 1024px;
			height: 768px;
			background: url('/backgrounds/sanctum.jpg') -110px 0px;
		}
		label{
			font-weight: normal;
			display: block;
			margin: .1em 0;
		}
		#login{
			border: 2px groove #357;
		}
		#createAccount{
			color: #fff;
		}
		#createAccount:hover{
			color: #fff;
		}
		#forgotPassword{
			color: #fff;
		}
		.textLeft, .signupHeader{
			margin-top: .375em;
		}
		.loginInputs{
			background: #132239;
			border: 1px solid #357;
		}
	</style>
</head>

<body id="curtain">
	<div id="mainBG">
		<header id="currencyIndicator" class="strongShadow">
		<?php
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
						<input type="password" id="resetPassword" class="loginInputs" maxlength="20" placeholder="Password" />
						<div class="textLeft">Re-type Password</div>
						<input type="password" id="resetVerifyPassword" class="loginInputs" maxlength="20" placeholder="Verify Password" />
						<div id="resetPW" class="strongShadow NGgradient">Reset Password</div>
					</form>';
			} else {
				echo 
					'<form id="loginWrap" accept-charset="UTF-8" class="strongShadow" onSubmit="return authenticate(this);">
						<fieldset>
							<div id="createAccountWrap">
								<span id="createAccount">Create Account</span>
							</div>
							
							<label class="textLeft" for="loginEmail">Email Address
								<input name="username" type="text" id="loginEmail" class="loginInputs" maxlength="255" placeholder="Email Address" required="required" />
							</label>
							
							<label class="textLeft" for="password">Password
								<input name="password" type="password" id="password" class="loginInputs" maxlength="20" placeholder="Password" required="required" />
							</label>
							
							<label class="textLeft create-account signupHeader" for="loginAccount">Account Name
								<input type="text" name="account" id="loginAccount" class="loginInputs create-account" maxlength="16" placeholder="Account Name"  />
							</label>
							
							<label class="signupHeader create-account" for="promoCode">Promo Code
								<input type="text" id="promoCode" class="loginInputs create-account" maxlength="20" placeholder="Promo Code" />
							</label>
							
							<div id="tosWrap" class="create-account">
								<span id="tos" class="aqua">
									<a target="_blank" href="//nevergrind.com/blog/terms-of-service/">Terms of Service</a> | <a target="_blank" href="//nevergrind.com/blog/privacy-policy/">Privacy Policy</a>
								</span>
							</div>
							
							<input id="login" type="submit" value="Login" class="btn btn-primary strongShadow" value="Login" />
							
							<div id="forgotPasswordWrap">
								<span title="Neverworks Games will send you an email. Click the link to reset your password." id="forgotPassword">Forgot Password?</span>
							</div>
						</fieldset>
					</form>';
			}
		}
		echo "<a id='refer' style='display:none' href='{$refer}'></a>";
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
		var pw = $("#password").val();
		var acc = $("#loginAccount").val();
		
		var newAcc = acc.replace(/[^a-z0-9]/gi, '');
		if (acc.match(/[a-z0-9]/gi, '').length < acc.length) {
			QMsg("Your account name should only contain letters and numbers.");
			return;
		}
		if (acc.length < 2) {
			QMsg("Your account name must be more than two characters long.");
			return;
		}
		if (acc.length > 16) {
			QMsg("Your account name must be less than 16 characters long.");
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
				account: newAcc.toLowerCase(),
				password: pw,
				promo: $("#promoCode").val().toLowerCase()
			}
		}).done(function(data) {
			if (data.indexOf("Account Created") === -1){
				QMsg(data);
			} else {
				QMsg(data + " Redirecting!");
				setTimeout(function(){
					$("#refer")[0].click();
				}, 100);
			}
			createAccountLock = false;
		}).fail(function() {
			QMsg("Could not contact the server!");
		});
	}
	function authenticate(f) {
		if (authenticationLock === true) {
			return false;
		}
		if ($("#loginEmail").val().length < 3) {
			QMsg("This is not a valid email address.");
			return false;
		}
		if ($("#password").val().length < 6) {
			QMsg("Passwords must be at least six characters long.");
			return false;
		}
		QMsg("Connecting to server...");
		authenticationLock = true;
		
		$.ajax({
			data: {
				run: "authenticate",
				email: $("#loginEmail").val().toLowerCase(),
				password: $("#password").val()
			}
		}).done(function(data) {
			var target = "https://" + location.host + $("#refer").attr("href");
			if (data === "Login successful!"){
				location.replace(target);
			} else {
				QMsg(data);
			}
		}).fail(function() {
			QMsg("Could not contact the server!");
		}).always(function(){
			authenticationLock = false;
		});
		return false; // prevent form submission
	}
	$('#login').on('click', function() {
		var text = $(this).val();
		if (text === "Login") {
			// check password and login are ok
			authenticate();
		} else if (text === "Create Account") {
			createAccount();
		} else if (text === "Reset Password") {
			resetPassword();
		}
	});
	// toggle forms
	$("#createAccount").on('click', function() {
		var text = $(this).text();
		if (text === "Create Account") {
			$(this).text("Cancel");
			$(".create-account").css('display', 'block');
			$("#emailWrap").css('display', 'none');
			$('#login').val("Create Account");
			$("#loginEmail, #password, #loginAccount").val("");
			loginMode = "create";
		} else {
			$(this).text("Create Account");
			$(".create-account").css('display', 'none');
			$("#emailWrap").css('display', 'block');
			$('#login').val("Login");
			$("#loginEmail, #password, #promoCode").val("");
			loginMode = "login";
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
		
	$("#password").on('focus', function() {
		focusPassword = true;
	}).on('blur', function() {
		focusPassword = false;
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
	$("#loginEmail").focus();
	</script>
	<?php
		require($_SERVER['DOCUMENT_ROOT'] . "/includes/ga.html");
	?>
</body>
</html>