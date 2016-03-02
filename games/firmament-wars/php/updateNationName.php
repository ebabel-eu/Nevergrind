<?php
	require_once('connect1.php');
	function validateName($x){
		// min/max length
		$len = strlen($x);
		$nospaces = str_replace(" ", "", $x);
		if ($len < 4){
			header('HTTP/1.1 500 Nation name must be at least 4 characters.');
		} else if ($len > 32){
			header('HTTP/1.1 500 Nation name must contain less than 33 characters.');
		} else if (!ctype_alnum($nospaces)){
			header('HTTP/1.1 500 Nation name must contain letters and numbers only.');
		}
		return true;
	}
	$name = $_POST['name'];
	
	if (validateName($name)){
		$query = 'update fwnations set name=? where email=?';
		$stmt = $link->prepare($query);
		$stmt->bind_param('ss', $name, $_SESSION['email']);
		$stmt->execute();
		echo $name;
	} else {
	}
?>