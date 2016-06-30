<?php
	session_start();
	if(php_uname('n')=="JOE-PC"){
		error_reporting(E_ALL);
		ini_set('display_errors', true);
	}
	
	if(!isset($_SESSION['email']) || !strlen($_SESSION['email'])){
		header("Location: /login.php?back=/account/");
		exit();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Nevergrind | Manage Account</title>
	<meta name="viewport" content="width=1024,user-scalable=no">
	<link rel='stylesheet' type='text/css' href="/css/global.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<?php
		include($_SERVER['DOCUMENT_ROOT'] . "/includes/head.html");
	?>
	<style>
		.title{
			margin-top: 12px;
		}
		.align-right{
			text-align: right;
		}
		#currencyIndicator{
			width: 100%;
		}
		#mainBG{
			width: 1024px;
			height: 768px;
			background: url('/backgrounds/home.jpg') -110px 0px;
		}
		#account{
			position: relative;
			top: 50px;
			margin: 0 auto;
			width: 360px;
			background: #222;
			padding: 0 12px 12px;
			border-radius: 6px;
			border: 1px solid #667;
			z-index: 999999;
			font-size: 1.25em;
			box-shadow: 0 0 12px #000 inset, 0 0 5px #000 inset;
		}
		#sendEmailConfirmation{
			position: relative;
			display: block;
			margin: 2px auto 16px;
			border: 1px solid #08f;
		}
		#payment-form{
			width: 640px;
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
					<span class="accountValues accountValueText">'.$_SESSION['account'].'</span>&ensp;
					<div id="crystals" class="crystalIcon accountValues"></div>
					<div id="crystalCount" class="accountValueText2">'.
						$crystals.
					'</div>';
					
					require_once('../php/connect_plain.php');
					$query = "select row, created, confirmed, subscribed, characters, bankSlots, hcBankSlots, kstier from accounts where email='".$_SESSION['email']."' limit 1";
					$result = $link->query($query);
					$confirmed = '0';
					while($row = $result->fetch_assoc()){
						$number = $row['row'];
						$created = $row['created'];
						$confirmed = $row['confirmed'];
						$subscribed = $row['subscribed'];
						$characters = $row['characters'];
						$bankSlots = $row['bankSlots'];
						$hcBankSlots = $row['hcBankSlots'];
						$kstier = $row['kstier'];
					}
				echo '</div>
				<div class="modePanel">
					Manage Account
				</div>';
			?>
		</header>
	
		<?php
			$phpdate = strtotime($created);
			$mysqldate = date('F j, Y', $phpdate);
			
			$confirmed = $confirmed ? "ON" : "OFF";
			$subscribed = $subscribed ? "ON" : "OFF";
			echo 
			'<div id="payment-form">
				<p class="title">
					<div class="centerize">Email Address: '.$_SESSION['email'].'</div>
					<div class="centerize">Account Name: '.$_SESSION['account'].'</div>
					<div class="centerize">Member Number: '.$number.'</div>
					<div class="centerize">Member Since '.$mysqldate.'</div>';
					
					if ($confirmed == 'OFF'){
						echo 
						'<div class="col-md-12 center-block text-center">
							<button id="sendEmailConfirmation" type="button" class="btn btn-primary center-block strongShadow">
								Confirm Email Account
							</button>
						</div>';
					}
				echo '</p>
				<p class="centerize title">
					<div class="centerize">Manage your Nevergrind account settings</div>
				</p>
				<hr class="fancyHR">
				
				<div class="row">
					<div class="col-md-9">
						Email Address Confirmed
					</div>
					<div class="col-md-3">'.$confirmed.'</div>
				</div>
				
				<div class="row">
					<div class="col-md-9">
						Subscribed to Email Notifications
					</div>
					<div class="col-md-3">
						<button id="subscribed" type="button" class="btn btn-info btn-xs strongShadow">'.$subscribed.'</button>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-9">
						Kickstarter Tier
					</div>
					<div class="col-md-3">'.$kstier.'</div>
				</div>
					
				<hr class="fancyHR">
				
				<div class="row">
					<div class="col-md-12 centerize">
						Nevergrind
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-9">
						Character Slots:
					</div>
					<div class="col-md-3">'.$characters.'</div>
				</div>
				
				<div class="row">
					<div class="col-md-9">
						Bank Slots:
					</div>
					<div class="col-md-3">'.$bankSlots.'</div>
				</div>
				
				<div class="row">
					<div class="col-md-9">
						Hardcore Bank Slots:
					</div>
					<div class="col-md-3">'.$hcBankSlots.'</div>
				</div>
					
				<hr class="fancyHR">
				
				<div class="row">
					<div class="col-md-12 centerize">
						Firmament Wars
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-12 centerize">
						Coming Soon!
					</div>
				</div>
					
				<hr class="fancyHR">
				
				<div id="errors" class="text-center"></div>
				<div class="centerize">
					<button id="update" type="button" class="btn btn-primary strongShadow">
						Update Settings
					</button>
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
	<script>
		$.ajaxSetup({
			type: 'POST',
			url: '/php/master1.php'
		});
		var settings = {
			subscribed: 1
		}
		
		var g = {
			lockScreen: function(){
				$("#screenLock").css('display', 'block');
			},
			unlockScreen: function(){
				$("#screenLock").css('display', 'none');
			}
		}
		
		$("#subscribed").on("click", function(){
			var e = $(this);
			var msg = e.text() == "ON" ? "OFF" : "ON";
			settings.subscribed = msg === "ON" ? 1 : 0;
			e.text(msg);
		});
		
		function QMsg(msg){
			var e = $("#errors");
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
		
		$("#update").on("click", function(){
			g.lockScreen();
			console.info("SENDING: ", settings.subscribed);
			$.ajax({
				url: '/php/updateAccount.php',
				data: {
					settings: settings
				}
			}).done(function(data) {
				QMsg("Account settings updated!");
			}).fail(function() {
				QMsg("Failed to communicate with the server!");
			}).always(function(data){
				console.info(data);
				g.unlockScreen();
			});
		});

		$("#sendEmailConfirmation").on('click', function(){
				var x = $(this);
				TweenMax.set(x, {color: "#00ff00"});
				x.off('click')
					.text("Confirmation Email Sent!");
					TweenMax.to(x, 1, {
						alpha: 0,
						delay: 2,
						onComplete: function(){
							x.remove();
						}
					});
				$.ajax({
					data: {
						run: "sendEmailConfirmation"
					}
				}).done(function(data) {
					console.info(data);
				}).fail(function(data) {
					failToCommunicate();
				});
			});
	</script>
</body>
</html>