<?php
	require_once('connect1.php');
	
	// generate random string
	function rand_str($length, $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'){
		$str = '';
		$count = strlen($charset);
		while($length--){
			$str .= $charset[mt_rand(0, $count-1)];
		}
		return $str;
	}
	function createAccount(){
		global $link;
		// echo "The server is down for maintenace. Please try again later.";
		// exit;
		// is server up?
		$query = "select status from server_status order by row desc limit 1";
		$stmt = mysqli_prepare($link, $query);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		mysqli_stmt_bind_result($stmt, $db_status);
		if(mysqli_stmt_fetch($stmt)){
			$status = $db_status;
		}
		if($status=="down"){
			echo "The server is down for maintenace. Please try again later.";
			exit;
		}
		
		$email = strtolower($_POST['email']);
		$account = strtolower($_POST['account']);
		$password = $_POST['password'];
		$verify = $_POST['verify'];
		$promo = $_POST['promo'];
		
		//validate email address
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			echo "The server reported an error. Please use a valid email address.";
			exit;
		}
		// all alphabetic?
		if (!ctype_alpha($account)){
			echo "Please use only alphabetical characters in your account name.";
			exit;
		}
		// check account name isn't too long or short
		if(strlen($account)<2){
			echo "The server reported an error. Please try again. Code: 3";
			exit;
		}
		if(strlen($account)>16){
			echo "The server reported an error. Please try again. Code: 4";
			exit;
		}
		//check password length
		if(strlen($password)<6){
			echo "The server reported an error. Please try again. Code: 5";
			exit;
		}
		if($password!=$verify){
			echo "The server reported an error. Please try again. Code: 6";
			exit;
		}
		// check that email does not exist
		$query = "select email from accounts where email=?";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$stmt->store_result();
		$count = $stmt->num_rows;
		if($count>0){
			// email address exists
			echo "The server reported an error. Please try again. Code: 7";
			exit;
		}
		// check that account does not exist
		$query = "select account from accounts where account=?";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $account);
		$stmt->execute();
		$stmt->store_result();
		$count = $stmt->num_rows;
		if($count>0){
			// email address exists
			echo "The server reported an error. Please try again. Code: 8";
			exit;
		}
		$status = 'active';
		
		$hash = '';
		if(isset($_POST['password']) && !empty($_POST['password']) && is_string($_POST['password'])){
			$salt = rand_str(rand(100,200));
			// generate hashed password using random salt
			$hash = crypt($_POST['password'], '$2a$07$'.$salt.'$'); // blowfish
			$password = crypt($_POST['password'], $hash);
			//echo "Posted Password:".$_POST['password']."\nSALT: ".$salt."\nHASH: ".$hash."\nPASSWORD: ".$password;
		}
		// create account
		$crystals = 0;
		$kstier = 0;
		// promo codes
		if($promo=="civilization"||
		$promo=="civrev"||
		$promo=="youtube"||
		$promo=="rerolled"||
		$promo=="reddit"||
		$promo=="voat"||
		$promo=="twitter"||
		$promo=="bacon"||
		$promo=="pathofexile"||
		$promo=="diablo"||
		$promo=="nexus"||
		$promo=="minecraft"||
		$promo=="everquest"||
		$promo=="steam"||
		$promo=="facebook"){
			$crystals += 75;
		}
		$confirmCode = rand_str(rand(35, 45));
		// set all data in the DB
		$query = "insert into `accounts` (`email`, `account`, `password`, `salt`, `status`, `paid`, `created`, `crystals`, `totalCrystals`, `kstier`, `promo`, `confirmCode`) VALUES (?, ?, ?, ?, ?, 'false', now(), $crystals, $crystals, $kstier, ?, ?)";
		$stmt = $link->prepare($query);
		$stmt->bind_param('sssssss', $email, $account, $password, $salt, $status, $promo, $confirmCode);
		$stmt->execute();
		$_SESSION['email'] = $email;
		$_SESSION['account'] = $account;
		
		// initialize GLB
		$query = "insert into glb (
			`email`, `chatMyHit`, `hideMenu`, `tooltipMode`, `videoSetting`, `showCombatLog`, `debugMode`
		) values (
			?, 'Off', 'Off', 'Long', 'High', 'On', 'Off'
		)";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $email);
		$stmt->execute();
		// initialize 10 bank slots
		$query = "insert into item (
			`email`, `slotType`, `name`, `slot`, `flavorText`, `itemSlot`, `proc`, `type`, `hardcoreMode`
		) VALUES 
		(?, 'bank', '', 0, '', '', '', '', 'false'),
		(?, 'bank', '', 1, '', '', '', '', 'false'),
		(?, 'bank', '', 2, '', '', '', '', 'false'),
		(?, 'bank', '', 3, '', '', '', '', 'false'),
		(?, 'bank', '', 4, '', '', '', '', 'false'),
		(?, 'bank', '', 5, '', '', '', '', 'false'),
		(?, 'bank', '', 6, '', '', '', '', 'false'),
		(?, 'bank', '', 7, '', '', '', '', 'false'),
		(?, 'bank', '', 8, '', '', '', '', 'false'),
		(?, 'bank', '', 9, '', '', '', '', 'false')";
		$stmt = $link->prepare($query);
		$stmt->bind_param('ssssssssss', $email, $email, $email, $email, $email, $email, $email, $email, $email, $email);
		$stmt->execute();
		// hardcore mode
		$query = "insert into item (
			`email`, `slotType`, `name`, `slot`, `flavorText`, `itemSlot`, `proc`, `type`, `hardcoreMode`
		) VALUES 
		(?, 'bank', '', 0, '', '', '', '', 'true'),
		(?, 'bank', '', 1, '', '', '', '', 'true'),
		(?, 'bank', '', 2, '', '', '', '', 'true'),
		(?, 'bank', '', 3, '', '', '', '', 'true'),
		(?, 'bank', '', 4, '', '', '', '', 'true'),
		(?, 'bank', '', 5, '', '', '', '', 'true'),
		(?, 'bank', '', 6, '', '', '', '', 'true'),
		(?, 'bank', '', 7, '', '', '', '', 'true'),
		(?, 'bank', '', 8, '', '', '', '', 'true'),
		(?, 'bank', '', 9, '', '', '', '', 'true')";
		$stmt = $link->prepare($query);
		$stmt->bind_param('ssssssssss', $email, $email, $email, $email, $email, $email, $email, $email, $email, $email);
		$stmt->execute();
		echo "Account Created!";
		// send confirmation email
		$msg1 = "<p>Hail, $account!</p><p>You have successfully registered for an account at Nevergrind. Here is your information:</p><div>Username: $account</div><div>Email: <a href='mailto:$email'>$email</a></div><p>You can access the site at <a href='https://nevergrind.com/'>https://nevergrind.com/</a>.</p><div>Please confirm your email address to continue:</div><div><a href='https://nevergrind.com/confirmemail/index.php?email=$email&code=$confirmCode'>https://nevergrind.com/confirmemail/index.php?email=$email&code=$confirmCode</a></div><p>Have a great day!</p>";
		$msg2 = "Hail, $account,\n\nYou have successfully registered for an account at Nevergrind. Here is your information:\n\nUsername: $account\nEmail: $email\n\nYou can access the site at https://nevergrind.com/\n\nPlease confirm your email address to continue:\n\nhttps://nevergrind.com/confirmemail/index.php?email=$email&code=$confirmCode\n\nHave a great day!";
		
		require 'PHPMailer/PHPMailerAutoload.php';
		$mail = new PHPMailer;
		$mail->isSMTP(); // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers ;smtp2.example.com
		$mail->SMTPAuth = true; // Enable SMTP authentication
		$mail->Username = 'support@nevergrind.com'; // SMTP username
		$mail->Password = '!M6a1e8l2f4y6n'; // SMTP password
		$mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;  // TCP port to connect to 587 tls or 465 ssl
		$mail->From = 'support@nevergrind.com';
		$mail->FromName = 'Neverworks Games';
		$mail->addAddress($email);
		$mail->Subject = 'Nevergrind Account Confirmation';
		$mail->isHTML(true);
		$mail->Body = $msg1;
		$mail->altBody = $msg2;
		$mail->send();
	}
	
	function sendEmailConfirmation(){
		// send email to session email
		global $link;
		$email = $_SESSION['email'];
		$account = $_SESSION['account'];
		$confirmCode = rand_str(rand(35, 45));
		
		$query = 'update accounts set confirmCode=? where email=?';
		$stmt = $link->prepare($query);
		$stmt->bind_param('ss', $confirmCode, $email);
		$stmt->execute();
		
		$msg1 = "<p>Hail, $account!</p><p>You have requested an account confirmation email. Here is your information:</p><div>Username: $account</div><div>Email: <a href='mailto:$email'>$email</a></div><p>You can access the site at <a href='https://nevergrind.com/'>https://nevergrind.com/</a>.</p><div>Please confirm your email address to continue:</div><div><a href='https://nevergrind.com/confirmemail/index.php?email=$email&code=$confirmCode'>https://nevergrind.com/confirmemail/index.php?email=$email&code=$confirmCode</a></div><p>Have a great day!</p>";
		$msg2 = "Hail, $account,\n\nYou have requested an account confirmation email. Here is your information:\n\nUsername: $account\nEmail: $email\n\nYou can access the site at https://nevergrind.com/\n\nPlease confirm your email address to continue:\n\nhttps://nevergrind.com/confirmemail/index.php?email=$email&code=$confirmCode\n\nHave a great day!";
		
		require 'PHPMailer/PHPMailerAutoload.php';
		$mail = new PHPMailer;
		$mail->isSMTP(); // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers ;smtp2.example.com
		$mail->SMTPAuth = true; // Enable SMTP authentication
		$mail->Username = 'support@nevergrind.com'; // SMTP username
		$mail->Password = '!M6a1e8l2f4y6n'; // SMTP password
		$mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;  // TCP port to connect to 587 tls or 465 ssl
		$mail->From = 'support@nevergrind.com';
		$mail->FromName = 'Neverworks Games';
		$mail->addAddress($email);
		$mail->Subject = 'Nevergrind Account Confirmation';
		$mail->isHTML(true);
		$mail->Body = $msg1;
		$mail->altBody = $msg2;
		$mail->send();
		echo "Email sent!";
	}
	
	function authenticate(){
		global $link;
		$email = $_POST['email'];
		$password = $_POST['password'];
		
		// is server up?
		$query = "select status from server_status order by row desc limit 1";
		$stmt = mysqli_prepare($link, $query);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		mysqli_stmt_bind_result($stmt, $db_status);
		if(mysqli_stmt_fetch($stmt)){
			$status = $db_status;
		}
		if($email!='joemattleonard@gmail.com'){
			if($status=="down"){
				echo "The server is down for maintenance. Please try again later.";
				exit;
			}
		}

		// Get account name to set it
		
		$query = "select account from accounts where email=?";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($data);
		while($stmt->fetch()){
			$account = $data;
			$_SESSION['account'] = $data;
		}
		
		$query = "select salt, password, status from accounts where email=? limit 1";
		if($stmt = $link->prepare($query)){
			$stmt->bind_param('s', $email);
			$stmt->execute();
			$stmt->store_result();
			$count = $stmt->num_rows;
			if($count==0){
				// nothing found
				echo "Login Not Successful.";
				exit;
			}
			$stmt->bind_result($stmtSalt, $stmtPassword, $stmtStatus);
			while($stmt->fetch()){
				$dbSalt = $stmtSalt;
				$dbPassword = $stmtPassword;
				$dbStatus = $stmtStatus;
			}
			$stmt->close();
		}else{
			echo "Login Failure.";
			exit;
		}
		if($dbStatus=="suspended"){
			echo "Account has been suspended.";
			exit;
		}
		if($dbStatus=="banned"){
			echo "Account has been banned.";
			exit;
		}
		// check if account is locked
		$query = "select row from accountloginfailure where email=? and timestamp > date_sub(now(), interval 5 minute)";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$stmt->store_result();
		$count = $stmt->num_rows;
		if($count>4){
			echo "Your account is temporarily locked. Try again in 5 minutes.";
			exit;
		}
		// compare database value to input - does it match?
		$hash = crypt($password, '$2a$07$'.$dbSalt.'$');
		$verify = crypt($password, $hash); 
		
		if($dbPassword!=$verify){
			echo "Bad password! Please try again.";
			// login failure
			$query = "insert into accountloginfailure (`email`) VALUES (?)";
			$stmt = $link->prepare($query);
			$stmt->bind_param('s', $email);
			$stmt->execute();
			$count++;
			if($count==4){
				echo "<br>One more failure and your account will be temporarily locked!";
			}else if($count>4){
				echo "<br>Your account has been temporarily locked. Try again in 5 minutes.";
			}	
			exit;
		}
		$_SESSION['email'] = $email;
		$_SESSION['account'] = $account;
		// login success
		$query = "insert into accountloginsuccess (`email`) VALUES (?)";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $email);
		$stmt->execute();
		
		echo "Login successful!";
	}
	function addLoot(){
		global $link;
		// insert enter world event
		$itemName = $_POST['itemName'];
		$query = "INSERT INTO lootDrops (itemName) VALUES (?)";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $itemName);
		$stmt->execute();
	}
	function createCharacter(){
		global $link;
		if(!isset($_SESSION['season'])){
			echo "Session has timed out! Try logging in again.";
			exit;
		}
		if($_SESSION['email']==''){
			echo "You must login to create a character.";
			exit;
		}
		$my = $_POST['my'];
		$illegal = array("\\", "/", ":", "*", "?", '"', "'", ">", "<", "1", "2", "3", "4", "5", "6", "7", "8", "9", "`", "0");
		$my['name'] = str_replace($illegal, "", $my['name']);
		// Check name constraint - only allow one name per season
		$query = 'select count(row) from characters where name=? and season=1';
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $my['name']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($dbcount);
		while($stmt->fetch()){
			$count = $dbcount;
		}
		if($count>0){
			echo "This character name is already taken!";
			exit;
		}
		// Check max characters on this account
		$query = "select characters from accounts where email=?";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $_SESSION['email']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($characters);
		while($stmt->fetch()){
			$maxCharacters = $characters;
		}
		
		// Check current active characters
		$query = 'select count(row) from characters where email=? and season=1';
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $_SESSION['email']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($count);
		while($stmt->fetch()){
			$activeCharacters = $count;
		}
		if($activeCharacters==16){
			echo "You cannot create anymore characters on this account.";
			exit;
		}
		if($activeCharacters>=$maxCharacters){
			echo "You must purchase additional character slots<br>to create another character.";
			exit;
		}
		
		$my['story'] = "Intro";
		
		$query = "insert into characters (
			`created`, `email`, `account`, `name`, `abjuration`, `agi`,
			`alteration`, `cha`, `channeling`, `conjuration`, `dex`, `dodge`,
			`dualWield`, `evocation`, `gender`, `hardcoreMode`, `hp`,
			`intel`, `job`, `lastName`, `maxHp`, `maxMp`,
			`mp`, `oneHandBlunt`, `oneHandSlash`, `parry`, `patch`,
			`piercing`, `race`, `sta`, `story`, `str`, 
			`subzone`, `subzoneN`, `subzoneH`, `svcold`, `svfire`, 
			`svlightning`, `svmagic`, `svpoison`, `title`, `twoHandBlunt`, 
			`twoHandSlash`, `wis`, `zone`, `zoneH`, `zoneN`
		) VALUES (
			now(), ?, ?, ?, ?, ?,
			?, ?, ?, ?, ?, ?,
			?, ?, ?, ?, ?,
			?, ?, '', ?, ?,
			?, ?, ?, ?, ?,
			?, ?, ?, ?, ?,
			?, ?, ?, ?, ?, 
			?, ?, ?, '', ?, 
			?, ?, ?, ?, ?
		)";
		$stmt = $link->prepare($query);
		$stmt->bind_param('sssiiiiiiiiiissiisiiiiiisisisisssiiiiiiiisss', 
			$_SESSION['email'], $_SESSION['account'], $my['name'], $my['abjuration'], $my['agi'],
			$my['alteration'], $my['cha'], $my['channeling'], $my['conjuration'], $my['dex'], $my['dodge'],
			$my['dualWield'], $my['evocation'], $my['gender'], $my['hardcoreMode'], $my['hp'],
			$my['intel'], $my['job'], $my['maxHp'], $my['maxMp'],
			$my['mp'], $my['oneHandBlunt'], $my['oneHandSlash'], $my['parry'], $my['patch'], 
			$my['piercing'], $my['race'], $my['sta'], $my['story'], $my['str'], 
			$my['subzone'], $my['subzoneN'], $my['subzoneH'], $my['svcold'], $my['svfire'], 
			$my['svlightning'], $my['svmagic'], $my['svpoison'], $my['twoHandBlunt'], 
			$my['twoHandSlash'], $my['wis'], $my['zone'], $my['zoneH'], $my['zoneN']
		);
		$stmt->execute();
		// 24 items
		$query = "insert into item (`email`, `slotType`, `characterName`, `name`, `slot`, `flavorText`, `itemSlot`, `proc`, `type`) 
		VALUES 
		(?, 'item', ?, '', 0, '', '', '', ''),
		(?, 'item', ?, '', 1, '', '', '', ''),
		(?, 'item', ?, '', 2, '', '', '', ''),
		(?, 'item', ?, '', 3, '', '', '', ''),
		(?, 'item', ?, '', 4, '', '', '', ''),
		(?, 'item', ?, '', 5, '', '', '', ''),
		(?, 'item', ?, '', 6, '', '', '', ''),
		(?, 'item', ?, '', 7, '', '', '', ''),
		(?, 'item', ?, '', 8, '', '', '', ''),
		(?, 'item', ?, '', 9, '', '', '', ''),
		(?, 'item', ?, '', 10, '', '', '', ''),
		(?, 'item', ?, '', 11, '', '', '', ''),
		(?, 'item', ?, '', 12, '', '', '', ''),
		(?, 'item', ?, '', 13, '', '', '', ''),
		(?, 'item', ?, '', 14, '', '', '', ''),
		(?, 'item', ?, '', 15, '', '', '', ''),
		(?, 'item', ?, '', 16, '', '', '', ''),
		(?, 'item', ?, '', 17, '', '', '', ''),
		(?, 'item', ?, '', 18, '', '', '', ''),
		(?, 'item', ?, '', 19, '', '', '', ''),
		(?, 'item', ?, '', 20, '', '', '', ''),
		(?, 'item', ?, '', 21, '', '', '', ''),
		(?, 'item', ?, '', 22, '', '', '', ''),
		(?, 'item', ?, '', 23, '', '', '', '')";
		$stmt = $link->prepare($query);
		$stmt->bind_param('ssssssssssssssssssssssssssssssssssssssssssssssss', $_SESSION['email'], $my['name'], $_SESSION['email'], $my['name'], $_SESSION['email'], $my['name'], $_SESSION['email'], $my['name'], $_SESSION['email'], $my['name'], $_SESSION['email'], $my['name'], $_SESSION['email'], $my['name'], $_SESSION['email'], $my['name'], $_SESSION['email'], $my['name'], $_SESSION['email'], $my['name'], $_SESSION['email'], $my['name'], $_SESSION['email'], $my['name'], $_SESSION['email'], $my['name'], $_SESSION['email'], $my['name'], $_SESSION['email'], $my['name'], $_SESSION['email'], $my['name'], $_SESSION['email'], $my['name'], $_SESSION['email'], $my['name'], $_SESSION['email'], $my['name'], $_SESSION['email'], $my['name'], $_SESSION['email'], $my['name'], $_SESSION['email'], $my['name'], $_SESSION['email'], $my['name'], $_SESSION['email'], $my['name']);
		$stmt->execute();
		// SLOT 12, 13
		if($my['job']!="Monk"){
			$eq12damage = 3;
			$eq12delay = 3600;
			$eq12type = "slashed";
			$eq12itemSlot = "weapons";
			$eq12xPos = -576;
			$eq12name = "Rusty Blade";
		}else{
			$eq12damage = 1;
			$eq12delay = 3000;
			$eq12type = "punched";
			$eq12itemSlot = "";
			$eq12xPos = 0;
			$eq12yPos = 0;
			$eq12name = "";
		}		
		$eq13damage = 0;
		$eq13delay = 0;
		$eq13type = "shield";
		$eq13itemSlot = "shield";
		$eq13xPos = -768;
		$eq13name = "Wooden Shield";
		$eq13armor = 1;
		if($my['job']=="Necromancer" ||
		$my['job']=="Enchanter" ||
		$my['job']=="Magician" ||
		$my['job']=="Wizard" ||
		$my['job']=="Rogue")
		{
			$eq12damage = 2;
			$eq12delay = 2600;
			$eq12type = "pierced";
			$eq12xPos = -704;
			$eq12name = "Rusty Dagger";
		}
		if($my['job']=="Cleric" ||
		$my['job']=="Druid" ||
		$my['job']=="Shaman")
		{
			$eq12damage = 4;
			$eq12delay = 4400;
			$eq12type = "crushed";
			$eq12xPos = -640;
			$eq12name = "Rusty Mace";
		}
		// SLOT 12
		$query = "insert into item 
		(`email`, `slotType`, `characterName`, `slot`, `flavorText`, `itemSlot`, `proc`, `type`, `damage`, `delay`, `xPos`, `name`) 
		VALUES 
		(?, 'eq', ?, 12, '', ?, '', ?, ?, ?, ?, ?)";
		$stmt = $link->prepare($query);
		$stmt->bind_param('ssssiiis', $_SESSION['email'], $my['name'], $eq12itemSlot, $eq12type, $eq12damage, $eq12delay, $eq12xPos, $eq12name);
		$stmt->execute();
		// SLOT 13
		$query = "insert into item 
		(`email`, `slotType`, `characterName`, `slot`, `flavorText`, `itemSlot`, `proc`, `type`, 
		`damage`, `delay`, `xPos`, `name`, `armor`) 
		VALUES 
		(?, 'eq', ?, 13, '', ?, '', ?, 
		?, ?, ?, ?, ?)";
		$stmt = $link->prepare($query);
		$stmt->bind_param('ssssiiisi', $_SESSION['email'], $my['name'], $eq13itemSlot, $eq13type, $eq13damage, $eq13delay, $eq13xPos, $eq13name, $eq13armor);
		$stmt->execute();
		// SLOT 6
		$eq6type = "cloth";
		$eq6itemSlot = "chest";
		$eq6xPos = -256;
		$eq6yPos = -256;
		$eq6name = "Training Tunic";
		$eq6armor = 1;
		
		if($my['job']=="Necromancer" ||
		$my['job']=="Enchanter" ||
		$my['job']=="Magician" ||
		$my['job']=="Wizard")
		{
			$eq6yPos = -64;
			$eq6name = "Apprentice Robe";
		}
		$query = "insert into item 
		(`email`, `slotType`, `characterName`, `slot`, `flavorText`, `itemSlot`, `proc`, `type`, `xPos`, `yPos`, `name`, `armor`) 
		VALUES 
		(?, 'eq', ?, 6, '', ?, '', ?, ?, ?, ?, ?)";
		$stmt = $link->prepare($query);
		$stmt->bind_param('ssssiisi', $_SESSION['email'], $my['name'], $eq6itemSlot, $eq6type, $eq6xPos, $eq6yPos, $eq6name, $eq6armor);
		$stmt->execute();
		// SLOT 14
		if($my['job']=="Ranger")
		{
			$eq14damage = 4;
			$eq14delay = 4500;
			$eq14type = "range";
			$eq14itemSlot = "range";
			$eq14xPos = -704;
			$eq14yPos = -512;
			$eq14name = "Cracked Bow";
		}else{
			$eq14damage = 1;
			$eq14delay = 30000;
			$eq14type = "";
			$eq14itemSlot = "";
			$eq14xPos = 0;
			$eq14yPos = 0;
			$eq14name = "";
		}
		$query = "insert into item 
		(`email`, `slotType`, `characterName`, `slot`, `flavorText`, `itemSlot`, 
		`proc`, `type`, `damage`, `delay`, `xPos`, `yPos`, `name`) 
		VALUES 
		(?, 'eq', ?, 14, '', ?, 
		'', ?, ?, ?, ?, ?, ?)";
		$stmt = $link->prepare($query);
		$stmt->bind_param('ssssiiiis', $_SESSION['email'], $my['name'], $eq14itemSlot, $eq14type, $eq14damage, $eq14delay, $eq14xPos, $eq14yPos, $eq14name);
		$stmt->execute();
		// REST OF EQ SLOTS
		$query = "insert into item (`email`, `slotType`, `characterName`, `name`, `slot`, `flavorText`, `itemSlot`, `proc`, `type`) VALUES 
		(?, 'eq', ?, '', 0, '', '', '', ''),
		(?, 'eq', ?, '', 1, '', '', '', ''),
		(?, 'eq', ?, '', 2, '', '', '', ''),
		(?, 'eq', ?, '', 3, '', '', '', ''),
		(?, 'eq', ?, '', 4, '', '', '', ''),
		(?, 'eq', ?, '', 5, '', '', '', ''),
		(?, 'eq', ?, '', 7, '', '', '', ''),
		(?, 'eq', ?, '', 8, '', '', '', ''),
		(?, 'eq', ?, '', 9, '', '', '', ''),
		(?, 'eq', ?, '', 10, '', '', '', ''),
		(?, 'eq', ?, '', 11, '', '', '', '')";
		$stmt = $link->prepare($query);
		$stmt->bind_param('ssssssssssssssssssssss', $_SESSION['email'], $my['name'], $_SESSION['email'], $my['name'], $_SESSION['email'], $my['name'], $_SESSION['email'], $my['name'], $_SESSION['email'], $my['name'], $_SESSION['email'], $my['name'], $_SESSION['email'], $my['name'], $_SESSION['email'], $my['name'], $_SESSION['email'], $my['name'], $_SESSION['email'], $my['name'], $_SESSION['email'], $my['name']);
		$stmt->execute();
		// init Q
		$query = "insert into quests (`email`, `name`, `season`, `difficulty`
		) VALUES 
		(?, ?, ".$_SESSION['season'].", 0),
		(?, ?, ".$_SESSION['season'].", 1),
		(?, ?, ".$_SESSION['season'].", 2)";
		$stmt = $link->prepare($query);
		$stmt->bind_param('ssssss', $_SESSION['email'], $my['name'], $_SESSION['email'], $my['name'], $_SESSION['email'], $my['name']);
		$stmt->execute();
	}
	function deleteCharacter(){
		global $link;
		$email = $_SESSION['email'];
		$name = $_POST['name'];
		if($name=='*'||$name==''){
			exit;
		}
		// character
		$query = 'delete from characters where name=? and season=? and email=?';
		$stmt = $link->prepare($query);
		$stmt->bind_param('sis', $name, $_SESSION['season'], $email);
		$stmt->execute();
		// quests
		$query = 'delete from quests where name=? and season=? and email=?';
		$stmt = $link->prepare($query);
		$stmt->bind_param('sis', $name, $_SESSION['season'], $email);
		$stmt->execute();
		// items
		$query = 'delete from item where characterName=? and season=? and email=?';
		$stmt = $link->prepare($query);
		$stmt->bind_param('sis', $name, $_SESSION['season'], $email);
		$stmt->execute();
	}
	function checkLoginStatus(){
		if($_SESSION['email']==''){
			echo "absent|X";
		}else{
			echo "present|X";
		}
	}
	function loadAllCharacters(){
		global $link;
		$email = $_SESSION['email'];
		$season = $_SESSION['season'];
		$now = date('U');
		$query = "select name, level, race, job, difficulty, zone, zoneN, zoneH, subzone, subzoneN, subzoneH, hardcoreMode, timestamp from characters where email='".$email."' and season=1 order by row limit 16";
		$result = $link->query($query);
		$str = $email.'|';
		while($row = $result->fetch_assoc()){
			if($row['level'] >= 15){
				// character not eligible for deletion
				$str .= $row['name'] ."|";
				$str .= $row['level'] ."|";
				$str .= $row['race'] ."|";
				$str .= $row['job'] ."|";
				$str .= $row['difficulty'] ."|";
				$str .= $row['zone'] ."|";
				$str .= $row['zoneN'] ."|";
				$str .= $row['zoneH'] ."|";
				$str .= $row['subzone'] ."|";
				$str .= $row['subzoneN'] ."|";
				$str .= $row['subzoneH'] ."|";
				$str .= $row['hardcoreMode'] ."|";
				$str .= "0|";
			}else{
				$diff = ($now - strtotime($row['timestamp']));
				if($diff < 1296000){ // 1209600000 1296000000
					// indicate days remaining until deletion
					$remain = (15 - floor($diff / 86400));
					$str .= $row['name'] ."|";
					$str .= $row['level'] ."|";
					$str .= $row['race'] ."|";
					$str .= $row['job'] ."|";
					$str .= $row['difficulty'] ."|";
					$str .= $row['zone'] ."|";
					$str .= $row['zoneN'] ."|";
					$str .= $row['zoneH'] ."|";
					$str .= $row['subzone'] ."|";
					$str .= $row['subzoneN'] ."|";
					$str .= $row['subzoneH'] ."|";
					$str .= $row['hardcoreMode'] ."|";
					$str .= "{$remain}|";
				}else{
					// character
					$name = $row['name'];
					$query = 'delete from characters where name=? and season=? and email=?';
					$stmt = $link->prepare($query);
					$stmt->bind_param('sis', $name, $season, $email);
					$stmt->execute();
					// quests
					$query = 'delete from quests where name=? and season=? and email=?';
					$stmt = $link->prepare($query);
					$stmt->bind_param('sis', $name, $season, $email);
					$stmt->execute();
					// items
					$query = 'delete from item where characterName=? and season=? and email=?';
					$stmt = $link->prepare($query);
					$stmt->bind_param('sis', $name, $season, $email);
					$stmt->execute();
				}
			}
		}
		echo $str;
	}
	function checkDifficulty(){
		global $link;
		$email = $_SESSION['email'];
		$query = "select q.planeOfFear from quests q join characters c on q.name=c.name where q.email=? and q.season=1 and q.difficulty<2 order by q.row, q.difficulty";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $_SESSION['email']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($DBpof);
		$str = '';
		while($stmt->fetch()){
			$str.= $DBpof."|";
		}
		echo $str;
	}
	function logout(){
		global $link;
		$_SESSION = array();
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			);
		}
		session_destroy();
	}
	function submitCC(){
		global $link;
		$amount = $_POST['amount']*1;
		$oldcard = $_POST['oldcard'];
		require('lib/Stripe.php');
		if(php_uname('n')=="JOE-PC"){
			$stripeKey = $_SESSION['STRIPE_TEST'];
		}else{
			$stripeKey = $_SESSION['STRIPE_LIVE'];
		}
		// validate POST data
		$validPost = "true";
		if($amount==100 || $amount==500 || $amount==1000){
			echo "OK!";
		}else{
			exit;
		}
		if($oldcard=="true" || $oldcard=="false"){
			echo "OK!";
		}else{
			exit;
		}
		// create customer if necessary
		Stripe::setApiKey($stripeKey);
		if (isset($_POST['stripeToken']) && isset($_SESSION['email'])){
			if($oldcard=="false"){
				$token = $_POST['stripeToken'];
				if($_SESSION['customerId']==''){
					// Create a Customer
					$customer = Stripe_Customer::create(array(
						"card" => $token,
						"description" => $_SESSION['email']
					));
					$_SESSION['customerId'] = $customer->id;
				}
			}
		}else{
			echo 'The order cannot be processed. You have not been charged.';
			exit;
		}
		//record last four if rememberMe
		$rememberMe = $_POST['rememberMe'];
		if($rememberMe=="true"){
			$lastFour = $_POST['lastFour'];
			$query = "insert into lastfour (`email`, `digits`, `customerId`) values (?, ?, ?);";
			$stmt = $link->prepare($query);
			$stmt->bind_param('sss', $_SESSION['email'], $lastFour, $_SESSION['customerId']);
			$stmt->execute();
		}
		// charge card
		$errorMessage='';
		try{
			// charge the customer, not the card
			$charge = Stripe_Charge::create(array(
				'amount' => $amount,
				'currency' => 'usd',
				'customer' => $_SESSION['customerId'],
				'description' => $_SESSION['email']
			));
		} catch (Stripe_ApiConnectionError $e) {
			// Network problem, perhaps try again.
			$errorMessage = "There appears to be a temporary network problem. Please try again later.";
			echo $errorMessage;
		} catch (Stripe_InvalidRequestError $e) {
			// You screwed up in your programming. Shouldn't happen!
			$errorMessage = "There has been a server error. The administrator has been contacted to resolve this problem.";
			echo $errorMessage;
		} catch (Stripe_ApiError $e) {
			// Stripe's servers are down!
			$errorMessage = "The payment processing servers are down. Please try again later.";
			echo $errorMessage;
		} catch (Stripe_CardError $e) {
			// Card was declined.
			$e_json = $e->getJsonBody();
			$error = $e_json['error'];
			$errorMessage = "".$error['message'];
			echo $errorMessage;
		}
		if($errorMessage==''){
			if($charge->paid==true){
				// insert purchase into db
				$query = "insert into purchases (`email`, `amount`) VALUES (
				?, ?)";
				$stmt = $link->prepare($query);
				$stmt->bind_param('si', $_SESSION['email'], $amount);
				$stmt->execute();
				// increment two fields: total and current crystals	
				$query = "select crystals, totalCrystals from accounts where email='".$_SESSION['email']."'";
				if($stmt = mysqli_prepare($link, $query)){
					mysqli_stmt_execute($stmt);
					mysqli_stmt_store_result($stmt);
					mysqli_stmt_bind_result($stmt, $db1, $db2);
					if(mysqli_stmt_fetch($stmt)){
						$crystals = $db1;
						$totalCrystals = $db2;
					}
					$crystals+=$_POST['crystals'];
					$totalCrystals+=$_POST['crystals'];
					$stmt = $link->prepare("update accounts set  
						crystals=?, 
						totalCrystals=? 
						where email=?");
					$stmt->bind_param('iis', $crystals, $totalCrystals, $_SESSION['email']);
					$stmt->execute();
				}
			}
		}else{
			// errors
			require 'PHPMailer/PHPMailerAutoload.php';
			$mail = new PHPMailer;
			$mail->isSMTP(); // Set mailer to use SMTP
			$mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers ;smtp2.example.com
			$mail->SMTPAuth = true; // Enable SMTP authentication
			$mail->Username = 'support@nevergrind.com'; // SMTP username
			$mail->Password = '!M6a1e8l2f4y6n'; // SMTP password
			$mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 587;  // TCP port to connect to 587 tls or 465 ssl
			$mail->From = 'support@nevergrind.com';
			$mail->FromName = 'Neverworks Games';
			$mail->addAddress('joemattleonard@gmail.com');
			$mail->Subject = 'Server Error';
			$mail->Body = $errorMessage;
			$mail->send();
		}
	}
	function forgotPassword(){
		global $link;
		$email = $_POST['email'];
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			echo "The server reported an error. Please try again. Code: 9";
			exit;
		}
		// check email exists at all
		$query = "select email from accounts where email=?";
		$stmt = $link->prepare($query);
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$stmt->store_result();
		if($stmt->num_rows==0){
			// email address exists
			echo "The server reported an error. Please try again. Code: 10";
			exit;
		}
		// 1-hour valid token check
		$query = "select email from resetpassword where email=? and timestamp>date_sub(now(), interval 1 hour)";
		$stmt = $link->prepare($query);
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$stmt->store_result();
		if($stmt->num_rows>0){
			// email address exists
			echo "A token has already been emailed to you.";
			exit;
		}
		if(php_uname('n')=="JOE-PC"){
			$host="localhost";
			$email="joemattleonard@gmail.com";
		}else{
			$host="nevergrind.com";
		}
		
		$plainReset = rand_str(rand(35, 45));
		$hash = crypt($plainReset, '$2a$07$'.$_SESSION['salt'].'$'); // blowfish
		$dbReset = crypt($plainReset, $hash);
		
		require 'PHPMailer/PHPMailerAutoload.php';
		$mail = new PHPMailer;
		$mail->isSMTP(); // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers ;smtp2.example.com
		$mail->SMTPAuth = true; // Enable SMTP authentication
		$mail->Username = 'support@nevergrind.com'; // SMTP username
		$mail->Password = '!M6a1e8l2f4y6n'; // SMTP password
		$mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;  // TCP port to connect to 587 tls or 465 ssl
		$mail->From = 'support@nevergrind.com';
		$mail->FromName = 'Neverworks Games';
		$mail->addAddress($email); // $email
		$mail->Subject = 'Reset Your Password';
		$mail->isHTML(true);
		$mail->Body = "<style>p{color:#111;}</style><p>Dear Customer,</p><p>This password reset request originated from https://nevergrind.com. Please click the link below to reset your account's password:</p><p><a class='neverworksReset' href='https://".$host."reset.php?reset=".$plainReset."'>Reset Your Password</a></p><p>Neverworks Games</p>";
		$mail->altBody = "Dear Customer,\n\nThis password reset request originated from https://nevergrind.com. Please click the link below to reset your account's password:\n\nhttps://".$host."reset.php?reset=".$plainReset." \n\nNeverworks Games";
		$mail->send();
		
		// insert into database
		$query = "insert into resetpassword (`email`, `reset`) values (?, '$plainReset')";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $email);
		$stmt->execute();
		
		$query = 'update accounts set hashedReset="'.$dbReset.'" where email=?';
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $email);
		$stmt->execute();
		echo "Please check your email. The link is valid for one hour.";
	}
	function resetPW(){
		global $link;
		$password = $_POST['password'];
		$verify = $_POST['verify'];
		//check password length
		if(strlen($password)<6){
			echo "The server reported an error. Please try again. Code: 11";
			exit;
		}
		if($password!=$verify){
			echo "The server reported an error. Please try again. Code: 12";
			exit;
		}
		$hash = '';
		if(isset($password) && !empty($password) && is_string($password)){
			$salt = rand_str(rand(100,200));
			$hash = crypt($password, '$2a$07$'.$salt.'$'); // blowfish
			$hashedPW = crypt($password, $hash);
			// set new password and salt
			$query = "update accounts set password='$hashedPW', salt='$salt' where email=?;";
			$stmt = $link->prepare($query);
			$stmt->bind_param('s', $_SESSION['tempEmail']);
			$stmt->execute();
			// delete token
			$query = "delete from resetpassword where email=?;";
			$stmt = $link->prepare($query);
			$stmt->bind_param('s', $_SESSION['tempEmail']);
			$stmt->execute();
			$_SESSION['email'] = $_SESSION['tempEmail'];
			unset($_SESSION['tempEmail']);
			echo "Password Reset Successful.";
		}
	}
	function checkCC(){
		global $link;
		$query = "select digits, customerId from lastfour where email=? order by timestamp desc limit 1";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $_SESSION['email']);
		$stmt->execute();
		$stmt->store_result();
		if($stmt->num_rows>0){
			$stmt->bind_result($lastFour, $customerId);
			while($stmt->fetch()){
				$four = $lastFour;
				$_SESSION['customerId'] = $customerId;
			}
			echo $four;
		}else{
			echo "cardNotFound";
		}
	}
	function deleteCards(){
		global $link;
		$query = "delete from lastfour where email=?;";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $_SESSION['email']);
		$stmt->execute();
		$_SESSION['customerId']='';
	}
	function addCharacterSlot(){
		global $link;
		// check crystal balance
		$query = "select crystals, characters from accounts where email=?";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $_SESSION['email']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($dbcrystals, $dbchars);
		while($stmt->fetch()){
			$crystals = $dbcrystals*1;
			$totalCharacters = $dbchars*1;
		}
		// check current total characters
		$query = "select row from characters where email=? and season=1;";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $_SESSION['email']);
		$stmt->execute();
		$stmt->store_result();
		$activeCharacters = $stmt->num_rows*1;
		if($activeCharacters==16){
			echo 'maxed';
		}else if($activeCharacters>=$totalCharacters){
			//pay up
			if($crystals < 150){
				echo 'buyCrystals';
			}else{
				echo 'pay150';
				$crystals = $crystals - 150;
				$activeCharacters = $activeCharacters + 1;
				$query = "update accounts set crystals=$crystals, characters=$activeCharacters where email=?";
				$stmt = $link->prepare($query);
				$stmt->bind_param('s', $_SESSION['email']);
				$stmt->execute();
			}
		}else{
			echo 'create';
		}
	}
	function testAjax(){
		echo "{ \"a\": 1, \"b\": 2 }";
	}
	
	function checkSessionActive(){
		echo $_SESSION['email'];
	}
	
	call_user_func($_POST['run']);
?>