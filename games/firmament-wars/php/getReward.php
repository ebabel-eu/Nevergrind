<?php
	function getReward($bar){
		// 2 digit
		function checkDubs($x, $y){
			if ($x === $y){
				return 1;
			}
			return 0;
		}
		function checkHitlerDubs($x, $y){
			if ($x === 8){
				if ($x === $y){
					return 1;
				}
				return 0;
			}
			return 0;
		}
		function check69($x, $y){
			if ($x === 6 && $y === 9){
				return 1;
			}
			return 0;
		}
		// 3 digit
		function checkTrips($x, $y, $z){
			if ($x === $y && $y === $z){
				return 1;
			}
			return 0;
		}
		function checkSatanicTrips($x, $y, $z){
			if ($x === 6){
				if ($x === $y && $y === $z){
					return 1;
				}
				return 0;
			}
			return 0;
		}
		function checkDankTrips($x, $y, $z){
			if ($x === 4 && $y === 2 && $z === 0){
				return 1;
			}
			return 0;
		}
		function checkHolyTrips($x, $y, $z){
			if ($x === 7){
				if ($x === $y && $y === $z){
					return 1;
				}
				return 0;
			}
			return 0;
		}
		function checkEternalSalvationTrips($x, $y, $z){
			if ($x === 3 && $y === 1 && $z === 6){
				return 1;
			}
			return 0;
		}
		// 4 digit
		function checkAmericaQuads($w, $x, $y, $z){
			if ($w === 1 && $x === 7 && $y === 7 && $z === 6){
				return 1;
			}
			return 0;
		}
		function checkLeetQuads($w, $x, $y, $z){
			if ($w === 1 && $x === 7 && $y === 7 && $z === 6){
				return 1;
			}
			return 0;
		}
		function checkHitlerQuads($w, $x, $y, $z){
			if ($w === 1 && $x === 4 && $y === 8 && $z === 8){
				return 1;
			}
			return 0;
		}
		function checkQuads($w, $x, $y, $z){
			if ($w === $x && $x === $y && $y === $z){
				return 1;
			}
			return 0;
		}
		// 5 digit
		function checkBoobs($v, $w, $x, $y, $z){
			if ($v === 8 && $w === 0 && $x === 0 && $y === 8 && $z === 5){
				return 1;
			}
			return 0;
		}
		function checkPents($v, $w, $x, $y, $z){
			if ($v === $w && $w === $x && $x === $y && $y === $z){
				return 1;
			}
			return 0;
		}
		// 6 digit
		function checkHex($u, $v, $w, $x, $y, $z){
			if ($u === $v && $v === $w && $w === $x && $x === $y && $y === $z){
				return 1;
			}
			return 0;
		}
		// 7 digit
		function checkSects($t, $u, $v, $w, $x, $y, $z){
			if ($t === $u && $u === $v && $v === $w && $w === $x && $x === $y && $y === $z){
				return 1;
			}
			return 0;
		}
		// 8 digit
		function checkOcts($s, $t, $u, $v, $w, $x, $y, $z){
			if ($s === $t && $t === $u && $u === $v && $v === $w && $w === $x && $x === $y && $y === $z){
				return 1;
			}
			return 0;
		}
		// start checking
		$get = (string)$bar;
		$reward = 0;
		$len = strlen($get);
		$arr = str_split($get);
		// init values
		$eight = -1;
		$seven = -1;
		$six = -1;
		$five = -1;
		$four = -1;
		$three = -1;
		$two = -1;
		$one = $arr[$len - 1]*1;
		// set values
		if ($len > 7){
			$eight = $arr[$len - 8]*1;
		} 
		if ($len >= 7){
			$seven = $arr[$len - 7]*1;
		} 
		if ($len >= 6){
			$six = $arr[$len - 6]*1;
		} 
		if ($len >= 5){
			$five = $arr[$len - 5]*1;
		} 
		if ($len >= 4){
			$four = $arr[$len - 4]*1;
		}
		if ($len >= 3){
			$three = $arr[$len - 3]*1;
		}
		if ($len >= 2){
			$two = $arr[$len - 2]*1;
		}
		// check rewards
		if ($eight > -1){
			if (checkOcts($eight, $seven, $six, $five, $four, $three, $two, $one)){
				$reward = 50;
			}
		}
		if ($seven > -1 && $reward === 0){
			if (checkSects($seven, $six, $five, $four, $three, $two, $one)){
				$reward = 42;
			}
		} 
		if ($six > -1 && $reward === 0){
			if (checkHex($six, $five, $four, $three, $two, $one)){
				$reward = 33;
			}
		} 
		if ($five > -1 && $reward === 0){
			if (checkBoobs($five, $four, $three, $two, $one)){
				$reward = 30;
			} else if (checkPents($five, $four, $three, $two, $one)){
				$reward = 25;
			}
		} 
		if ($four > -1 && $reward === 0){
			if (checkAmericaQuads($four, $three, $two, $one)){
				$reward = 21;
			} else if (checkLeetQuads($four, $three, $two, $one)){
				$reward = 21;
			} else if (checkHitlerQuads($four, $three, $two, $one)){
				$reward = 21;
			} else if (checkQuads($four, $three, $two, $one)){
				$reward = 18;
			}
		} 
		if ($three > -1 && $reward === 0){
			if (checkEternalSalvationTrips($three, $two, $one)){
				$reward = 15;
			} else if (checkHolyTrips($three, $two, $one)){
				$reward = 12;
			} else if (checkDankTrips($three, $two, $one)){
				$reward = 10;
			} else if (checkSatanicTrips($three, $two, $one)){
				$reward = 9;
			} else if(checkTrips($three, $two, $one)){
				$reward = 7;
			}
		}
		if ($two > -1 && $reward === 0){
			if (check69($two, $one)){
				$reward = 3;
			} else if (checkHitlerDubs($two, $one)){
				$reward = 3;
			} else if (checkDubs($two, $one)){
				$reward = 2;
			}
		}
		return $reward;
	}