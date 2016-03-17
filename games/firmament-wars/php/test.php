<?php
	require('values.php');
	require('connect1.php');
	
	unset($player);
	$a = array(1,2,3,4,5,6,7,8);
	for ($i=1; $i < 8; $i++){
		if (!in_array($i, $a)){
			if (!isset($player)){
				$player = $i;
			}
		}
	}
	if (!isset($player)){
		echo 0;
	} else {
		echo $player;
	}

?>