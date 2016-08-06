<?php
	session_start();
	if($_SERVER["SERVER_NAME"] === "localhost"){
		error_reporting(E_ALL);
		ini_set('display_errors', true);
	}
	require('../php/values.php');
	
	if(!isset($_SESSION['email']) || !strlen($_SESSION['email'])){
		header("Location: /login.php?back=/store");
		exit();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Nevergrind | Never Crystal Store</title>
	<meta charset="utf-8">
	<meta name="author" content="Joe Leonard">
	<meta name="referrer" content="always">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<meta name="viewport" content="width=1024,user-scalable=no">
	<meta name="twitter:widgets:csp" content="on">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="mobile-web-app-capable" content="yes">
	<link rel="shortcut icon" href="/images1/favicon.ico">
	<link rel='stylesheet' type='text/css' href="/css/global.css">
	<style>
		input{
			margin-top: 4px;
			font-size:20px;
		}
		#screenLock{
			display: none;
			position: absolute;
			top: 0;
			left: 0;
			width: 2000px;
			height: 2000px;
			opacity: .6;
			background: #111;
			z-index:9999999;
		}
		#currencyIndicator{
			width: 100%;
		}
		#mainBG{
			width: 1024px;
			height: 768px;
			background: url('/backgrounds/home.jpg') -110px 0px;
		}
		.accountValueText3{
			margin-right: 6px;
		}
		#payment-form{
			visibility: hidden;
		}
	</style>
</head>

<body id="curtain">
	<div id="mainBG">
		<header id="currencyIndicator" class="strongShadow">
		<?php
				require_once('../php/connect_plain.php');
				// crystals
				$query = "select crystals from accounts where email='".$_SESSION['email']."' limit 1";
				$result = $link->query($query);
				$crystals = '';
				while($row = $result->fetch_assoc()){
					$crystals .= $row['crystals'];
				}
				
				echo 
				'<div class="accountDetails">
					<div class="accountValueText2 accountValueText3"><a title="Manage Account" href="/account/?back=games/firmament-wars">'.$_SESSION['account'].'</a></div>
					<div id="crystals" class="crystalIcon accountValues"></div>
					<div id="crystalCount" class="accountValueText2">'.$crystals.'</div>
				</div>';
				echo "<div class='modePanel'>";
					echo "Never Crystal Store";
				echo '</div>';
			?>
		</header>
		<?php
			echo 
			'<div id="payment-form">
				<p class="centerize">
					Purchase Never Crystals to unlock premium features in all of our games.
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
			</div>';
		?>
		<div id="screenLock"></div>
	</div><!-- window 2 -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	
	<?php
		require($_SERVER['DOCUMENT_ROOT'] . "/includes/ga.html");
	?>
	<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
	<script>
		if(location.host==="localhost"){
			Stripe.setPublishableKey('pk_test_GtNfTRB1vYUiMv1GY2kSSRRh');
		}else{
			Stripe.setPublishableKey('pk_live_rPSfoOYjUrmJyQYLnYJw71Zm');
		}
	</script>
	<script>
		$.ajaxSetup({
			type: 'POST',
			url: '/php/master1.php'
		});
		
		var g = {
			lockScreen: function(){
				$("#screenLock").css('display', 'block');
			},
			unlockScreen: function(){
				$("#screenLock").css('display', 'none');
			}
		}
		
		// init
		$("#last-credit-card").css({
			background: '#777',
			border: '2px ridge #aaa'
		}).data('oldcard', 'false');
		$("#newCard").css({
			display: 'block',
		});
		$("#payment-form").css('display', 'block');
		$("#card-number").focus();
		if ($("#old-cards").css('display') === 'block') {
			$("#last-credit-card").trigger('click');
		}
		// check known cards
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
				$("#last-credit-card").trigger("click");
			}
			$("#payment-form").css('visibility', 'visible');
		});
		
		$("#last-credit-card").on('click', function() {
			$("#card-number, #card-cvc, #card-month, #card-year").val("");
			$("#payment-errors").text("");
			if ($(this).data('oldcard') === "false") {
				$(this).css({
					background: '#080',
					border: '2px ridge #0d0'
				}).data('oldcard', 'true');
				$("#newCard").css('display', 'none');
				$("#rememberCard").prop("checked", false);
			} else {
				$(this).css({
					background: '#777',
					border: '2px ridge #aaa'
				}).data('oldcard', 'false');
				$("#newCard").css('display', 'block');
				$("#rememberCard").prop("checked", true);
			}
		});
		
		$(".floater").on('click', function() {
			var that = this;
			var e = document.getElementsByClassName('floater');
			for (var i = 0; i < e.length; i++) {
				e[i].className = "floater";
			}
			that.className += " purchase";
			var amount = parseInt($(".purchase").data('amount'), 10);
			var e1 = document.getElementById('crystalsExplained');
			if (amount === 1000) {
				e1.textContent = "$10 will purchase 1000 Never Crystals";
			} else if (amount === 500) {
				e1.textContent = "$5 will purchase 400 Never Crystals";
			} else {
				e1.textContent = "$1 will purchase 70 Never Crystals";
			}
		});
		
		function QMsg(msg){
			var e = $("#payment-errors");
			e.text(msg);
			TweenMax.set(e, {
				transformPerspective: 300,
				transformOrigin: '50% 0'
			});
			TweenMax.killTweensOf(e);
			TweenMax.fromTo(e, 2, {
				rotationX: 0,
				height: "auto"
			}, {
				rotationX: -90,
				delay: 8,
				height: 0,
				onComplete: function(){
					e.text("");
				}
			});
		}
		
		$("#deleteCards").on('click', function(e) {
			var that = $(this);
			g.lockScreen();
			that.text("Deleting...");
			$.ajax({
				data: {
					run: "deleteCards"
				}
			}).done(function(data) {
				QMsg("All customer card data has been deleted.");
				$("#last-credit-card").data("oldcard", "false");
				$('#CC-last-four').text("****");
				$('#old-cards').css({
					display: 'none'
				});
				that.text("Delete Card");
				$("#newCard").css('display', 'block');
				g.unlockScreen();
			}).fail(function() {
				QMsg("Failed to communicate with the server!");
			});
		});
		
		function reportError(msg) {
			$("#payment-errors").text(msg);
			g.unlockScreen();
		}
		
		$("#payment-confirm").on('click', function(e) {
			g.lockScreen();
			var response = {};
			var ccNum = $('#card-number').val(),
				cvcNum = $('#card-cvc').val(),
				expMonth = $('#card-month').val(),
				expYear = $('#card-year').val(),
				oldcard = $("#last-credit-card").data("oldcard"),
				error = false;
			var lastFour = ccNum.slice(12);
			// Validate the number:
			if (oldcard === "true") {
				document.getElementById('payment-errors').textContent = '';
				stripeResponseHandler('Using old card', {
					id: "oldCard"
				});
			} else {
				if (!Stripe.validateCardNumber(ccNum)) {
					error = true;
					reportError('The credit card number appears to be invalid.');
				}
				// Validate the CVC:
				if (!Stripe.validateCVC(cvcNum)) {
					error = true;
					reportError('The CVC number appears to be invalid.');
				}
				// Validate the expiration:
				if (!Stripe.validateExpiry(expMonth, expYear)) {
					error = true;
					reportError('The expiration date appears to be invalid.');
				}
				if (!error) {
					createToken();
				}
			}

			function createToken() {
				Stripe.createToken({
					number: ccNum,
					cvc: cvcNum,
					exp_month: expMonth,
					exp_year: expYear
				}, stripeResponseHandler);
				document.getElementById('payment-errors').textContent = '';
			}

			function stripeResponseHandler(status, response) {
				if (response.error) {
					reportError(response.error.message);
				} else {
					// No errors, submit the form.
					var amount = parseInt($(".purchase").data('amount'), 10);
					var crystals = 0;
					if (amount > 1000) {
						amount = 1000;
					}
					if (amount < 100) {
						amount = 100;
					}
					var valid = false;
					if (amount === 100) {
						valid = true;
						crystals = 70;
					}
					if (amount === 500) {
						valid = true;
						crystals = 400;
					}
					if (amount === 1000) {
						valid = true;
						crystals = 1000;
					}
					var rememberMe = "false";
					if ($("#rememberCard").prop('checked') === true) {
						rememberMe = "true";
					}
					if (valid === true) {
						QMsg("Communicating with the server...");
						$.ajax({
							data: {
								run: "submitCC",
								stripeToken: response.id,
								amount: amount,
								crystals: crystals,
								lastFour: lastFour,
								oldcard: oldcard,
								rememberMe: rememberMe
							}
						}).done(function(data) {
							var a = data.split("|");
							if (a[0] === "Error") {
								document.getElementById('payment-errors').textContent = a[1];
							} else {
								var o = {};
								if (amount === 1000) {
									QMsg("You have spent $10 on 1000 Never Crystals");
									o.add = 1000;
								} else if (amount === 500) {
									QMsg("You have spent $5 on 400 Never Crystals");
									o.add = 400;
								} else {
									QMsg("You have spent $1 on 70 Never Crystals");
									o.add = 70;
								}
								var e = document.getElementById('crystalCount');
								o.start = parseInt(e.textContent, 10);
								o.end = o.start + o.add;
								TweenMax.to(o, 2, {
									start: o.end,
									onUpdate: function() {
										e.textContent = ~~o.start;
									}
								});
							}
							g.unlockScreen();
						}).fail(function(data) {
							QMsg("Error: " + data.responseText);
						});
					}
				}
			}
		});
	</script>
</body>
</html>