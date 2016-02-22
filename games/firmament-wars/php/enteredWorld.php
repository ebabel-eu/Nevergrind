<?php
	$php = $_POST['php'];
	if($php=="local"){
		$con = mysqli_connect("localhost:3306","root","2M@elsw6", "nevergrind");
	}else{
		$con = mysqli_connect("localhost","nevergri_ng","!M6a1e8l2f4y6n", "nevergri_ngLocal");
	}
	if (!$con) {
		echo 'Server Error - Could not connect to database: ';
		exit;
	}
	
	$a = $_POST['name'];
	$b = $_POST['level'];
	$c = $_POST['job'];
	$d = $_POST['race'];
	$e = $_POST['experience'];
	$f = $_POST['deaths'];
	$g = $_POST['gold'];
	$h = $_POST['playtime'];
	$i = $_POST['uniques'];
	$j = $_POST['ID'];	
	
	//check double ID
	$query = "SELECT id, kills, name, race, job, level FROM kills WHERE id='$j'";
	if($stmt = mysqli_prepare($con, $query)){
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		mysqli_stmt_bind_result($stmt, $dRow, $dID, $dKills, $dName, $dRace, $dJob, $dLevel);
		$rowCount = mysqli_stmt_num_rows($stmt);
		echo "$rowCount";
	}
	
	// pre-processing
	$timeStamp = date('j F Y h:i:s A');
	$h = round($h);
	$stringData = "$j: $timeStamp,$a,$b,$c,$d, Experience: $e, Deaths: $f, Gold: $g, Playtime: $h Uniques: $i\n";
			
	$stmt = $con->prepare("INSERT INTO enterworld (`id`,`timeStamp`,`name`,`level`,`job`, `race`, `kills`, `deaths`, `gold`, `playtime`, `uniques`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$stmt->bind_param('ississiiiii', $j, $timeStamp, $a, $b, $c, $d, $e, $f, $g, $h, $i);
	$stmt->execute();
	mysqli_stmt_close($stmt);	
	
	mysqli_close($con);
?>