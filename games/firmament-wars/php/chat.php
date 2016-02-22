<?php
	require_once('connect_plain.php');
	function chatWho(){
		global $link;
		$name = $_POST['name'];
		$job = $_POST['job'];
		// count unique character logins
		if($name!=''){
			$query = "select level, job, name, hardcoreMode, account, zone from ping where timestamp > date_sub(now(), interval 30 second) and name=? group by email order by level";
			$stmt = $link->prepare($query);
			$stmt->bind_param('s', $name);
		}else if($job!=''){
			$query = "select level, job, name, hardcoreMode, account, zone from ping where timestamp > date_sub(now(), interval 30 second) and job=? group by email order by level";
			$stmt = $link->prepare($query);
			$stmt->bind_param('s', $job);
		}else{
			$query = "select level, job, name, hardcoreMode, account, zone from ping where timestamp > date_sub(now(), interval 30 second) group by email order by level";
			$stmt = $link->prepare($query);
		}
		$stmt->execute();
		$stmt->bind_result($level, $job, $name, $hardcoreMode, $account, $zone);
		$s = '';
		while($stmt->fetch()){
			$s.= $level."|";
			$s.= $job."|";
			$s.= $name."|";
			$s.= $hardcoreMode."|";
			$s.= $account."|";
			$s.= $zone."|";
		}
		echo $s;
	}
	function chatInit(){
		global $link;
		$query = "select row from chat order by row desc limit 1";
		$stmt = $link->prepare($query);
		$stmt->execute();
		$stmt->bind_result($row);
		while($stmt->fetch()){
			echo $row;
		}
	}
	function chatUpdate(){
		global $link;
		$query = "select row, GM, message, nameFrom, nameTo, class, level, job from chat where row > ? order by row";
		$stmt = $link->prepare($query);
		$stmt->bind_param('i', $_POST['chatRow']);
		$stmt->execute();
		$stmt->bind_result($row, $GM, $message, $nameFrom, $nameTo, $class, $level, $job);
		$s = '';
		while($stmt->fetch()){
			$s.= $row."|";
			$s.= $GM."|";
			$s.= $message."|";
			$s.= $nameFrom."|";
			$s.= $nameTo."|";
			$s.= $class."|";
			$s.= $level."|";
			$s.= $job."|";
		}
		echo $s;
	}
	call_user_func($_POST['run']);
?>