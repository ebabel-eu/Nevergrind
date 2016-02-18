<?php
	if(php_uname('n')=="JOE-PC"){
		$link = mysqli_connect("localhost:3306","root","2M@elsw6","nevergrind");
	}else{
		$link = mysqli_connect("localhost", "nevergri_ng", "!M6a1e8l2f4y6n", "nevergri_ngLocal");
	}
	if (!$link) {
		die('Could not connect: ' . mysqli_error());
	}
	$s = "<b>Fix bank accounts. Go!</b><BR>";
	
	$a = array();
	$add = array();
	$query = "select email, bankSlots from accounts order by email";
	$stmt = mysqli_prepare($link, $query);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);
	mysqli_stmt_bind_result($stmt, $email, $bankSlots);
	while(mysqli_stmt_fetch($stmt)){
		//array_push($a, $email, $bankSlots);
		$a[$email] = new STDClass();
		array_push($add, $email);
		$a[$email]->bankSlots = $bankSlots;
	}
	$query = "select email, count(row) total from item where slotType='bank' and hardcoreMode='false' group by email order by email";
	$stmt = mysqli_prepare($link, $query);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);
	mysqli_stmt_bind_result($stmt, $em, $total);
	while(mysqli_stmt_fetch($stmt)){
		if(array_key_exists($em, $a)){
			$a[$em]->total  = $total;
		}
	}
	
	$len = count($a);
	for($i=0;$i < $len;$i++){
		if($a[$add[$i]]->bankSlots > $a[$add[$i]]->total){
			echo $add[$i]." | ".$a[$add[$i]]->bankSlots." | ".$a[$add[$i]]->total."<br>";
		}
	}
	echo "<BR><BR><b>DONE!</b>"
?>