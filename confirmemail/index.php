<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Nevergrind | Email Confirmation</title>
		<?php
			include($_SERVER['DOCUMENT_ROOT'] . "/includes/head.html");
		?>
		<style>
			html{
				background:#000;
				color:#fff;
				text-shadow:
					.6px .6px #222,
					-.4px .6px #222,
					-.4px 0 #222,
					.6px 0 #222,
					0 .6px #222,
					0 -.6px #222,
					0px 0px 5px #222,
					0px 0px 2px #222;
			}
			body{
				font-size:1.5em;
				text-align:center;
				position:relative;
				left:0;
				right:0;
				margin:0 auto;
				width:1280px;
				height:768px;
				background:url('http://nevergrind.com/backgrounds/home.jpg');
				overflow:hidden;
			}
			div{
				box-shadow:0 999px rgba(0,0,0,.75) inset;
			}
			a{
				color:#0bf;
				font-weight:normal;
				text-decoration:none;
				border-bottom:1px solid #0bf;
			}
			a:visited{
				color:#0bf;
				font-weight:normal;
			}
			#report{
				position:absolute;
				top:60px;
				width:1280px;
				left:0;
				right:0;
				margin:0 auto;
				border-top:1px solid #666;
				border-bottom:1px solid #666;
			}
			#play-now{
				font-size:2em;
			}
		</style>
	</head>
	<body>
		<?php
			if(isset($_GET['email'])&&isset($_GET['code'])){
				if(php_uname('n')=="JOE-PC"){
					$link = mysqli_connect("localhost:3306","root","2M@elsw6","nevergrind");
				}else{
					$link = mysqli_connect("localhost", "nevergri_ng", "!M6a1e8l2f4y6n", "nevergri_ngLocal");
				}
				if (!$link) {
					die('Could not connect: ' . mysqli_error());
				}
				$email = $_GET['email'];
				$code = $_GET['code'];
				$query = "select crystals, totalCrystals, confirmed, confirmCode from accounts where email=?";
				$stmt = $link->prepare($query);
				$stmt->bind_param('s', $email);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($db_crystals, $db_totalCrystals, $db_confirmed, $db_confirmCode);
				while($stmt->fetch()){
					$crystals = $db_crystals*1;
					$totalCrystals = $db_totalCrystals*1;
					$confirmed = $db_confirmed*1;
					$confirmCode = $db_confirmCode;
				}
				if($confirmed==0){
					if ($code==$confirmCode){
						$crystals += 75;
						$totalCrystals += 75;
						$query = "update accounts set confirmed=1, crystals=$crystals, totalCrystals=$totalCrystals where email=?;";
						$stmt = $link->prepare($query);
						$stmt->bind_param('s', $email);
						$stmt->execute();
						echo "<div id='report'>
							<p>Email account confirmed!</p>
							<p>You have earned 75 Never Crystals!</p>
							<p>Enjoy your time playing our games!</p>
							<p>
								<div>
									<a id='play-now' href='https://nevergrind.com'>Play Nevergrind!</a>
								</div>
							</p>
						</div>";
					} else {
						echo "
						<div id='report'>
							<p>The confirmation code did not match!</p>
							<p>Contact <a href='support@nevergrind.com'>support@nevergrind.com</a> if you have any concerns.</p>
							<p>Or just ignore this message and go <a href='https://nevergrind.com/'>play vidya games</a>
							</p>
						</div>";
					}
				}else{
					echo "
					<div id='report'>
						<p>This email account has already been confirmed... or something else went wrong.</p>
						<p>Contact <a href='support@nevergrind.com'>support@nevergrind.com</a> if you have any concerns.</p>
						<p>Or just ignore this message and go <a href='https://nevergrind.com/'>slay some dragons</a></p>
					</div>";
				}
			}
		?>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	</body>
</html>