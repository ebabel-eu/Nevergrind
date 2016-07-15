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
		function checkSalvationTrips($x, $y, $z){
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
		function checkDoubleDubs($w, $x, $y, $z){
			if ($w === $x && $y === $z){
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
		function checkTripleDubs($u, $v, $w, $x, $y, $z){
			if ($u === $v && $w === $x && $y === $z){
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
		function checkQuadDubs($s, $t, $u, $v, $w, $x, $y, $z){
			if ($s === $t && $u === $v && $w === $x && $y === $z){
				return 1;
			}
			return 0;
		}
		// start checking
		$get = (string)$bar;
		$reward = new stdClass();
		$reward->units = 0;
		$reward->msg = '';
		$reward->img = '';
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
				$reward->units = 50;
				$reward->msg = 'Almighty octs';
				$reward->img = '';
			} else if (checkQuadDubs($eight, $seven, $six, $five, $four, $three, $two, $one)){
				$reward->units = 25;
				$reward->msg = 'Sick quad dubs';
				$reward->img = '';
			}
		}
		if ($seven > -1 && $reward->units === 0){
			if (checkSects($seven, $six, $five, $four, $three, $two, $one)){
				$reward->units = 42;
				$reward->msg = 'Righteous sects';
				$reward->img = '';
			}
		} 
		if ($six > -1 && $reward->units === 0){
			if (checkHex($six, $five, $four, $three, $two, $one)){
				$reward->units = 35;
				$reward->msg = 'Accursed hex';
				$reward->img = '';
			} else if (checkTripleDubs($six, $five, $four, $three, $two, $one)){
				$reward->units = 16;
				$reward->msg = 'Triple double';
				$reward->img = 'images/chat/tripleDouble/'.mt_rand(0,1).'.jpg';
			}
		} 
		if ($five > -1 && $reward->units === 0){
			if (checkBoobs($five, $four, $three, $two, $one)){
				$reward->units = 30;
				$reward->msg = 'Boobs';
				$reward->img = '';
			} else if (checkPents($five, $four, $three, $two, $one)){
				$reward->units = 27;
				$reward->msg = 'Glorious pents';
				$reward->img = '';
			}
		} 
		if ($four > -1 && $reward->units === 0){
			if (checkAmericaQuads($four, $three, $two, $one)){
				$reward->units = 21;
				$reward->msg = 'Liberty quads';
				$reward->img = '';
			} else if (checkLeetQuads($four, $three, $two, $one)){
				$reward->units = 21;
				$reward->msg = 'Leet quads';
				$reward->img = '';
			}/* else if (checkHitlerQuads($four, $three, $two, $one)){
				$reward->units = 21;
				$reward->msg = 'Nazi quads';
				$reward->img = '';
			}*/ else if (checkQuads($four, $three, $two, $one)){
				$reward->units = 18;
				$reward->msg = 'Sweet quads';
				$reward->img = '';
			} else if (checkDoubleDubs($four, $three, $two, $one)){
				$reward->units = 7;
				$reward->msg = 'Double dubs';
				$reward->img = '';
			}
		} 
		if ($three > -1 && $reward->units === 0){
			if (checkSalvationTrips($three, $two, $one)){
				$reward->units = 15;
				$reward->msg = 'Jesus trips';
				$reward->img = '';
			} else if (checkHolyTrips($three, $two, $one)){
				$reward->units = 12;
				$reward->msg = 'Holy trips';
				$reward->img = '';
			} else if (checkDankTrips($three, $two, $one)){
				$reward->units = 11;
				$reward->msg = 'Dank ass trips';
				$reward->img = '';
			} else if (checkSatanicTrips($three, $two, $one)){
				$reward->units = 10;
				$reward->msg = 'Satanic trips';
				$reward->img = '';
			} else if(checkTrips($three, $two, $one)){
				$reward->units = 9;
				$reward->msg = 'Savage trips';
				$reward->img = '';
			}
		}
		if ($two > -1 && $reward->units === 0){
			/*if (check69($two, $one)){
				$reward->units = 4;
				$reward->msg = 'Sexy dubs';
				$reward->img = '';
			} else if (checkHitlerDubs($two, $one)){
				$reward->units = 4;
				$reward->msg = 'Hitler dubs';
				$reward->img = 'images/chat/hitlerDubs/'.mt_rand(0,1).'.jpg';
			} else */if (checkDubs($two, $one)){
				$reward->units = 3;
				$reward->msg = 'Nice dubs';
				$reward->img = 'images/chat/dubs/'.mt_rand(0,3).'.jpg';
			}
		}
		return $reward;
	}
?>