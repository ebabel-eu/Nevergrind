<?php
	require_once('connect1.php');
	function setMob(){
		global $link;
		$name = $_POST['name'];
		$Slot = $_POST['Slot']*1;
		$exp = $_POST['exp']*1;
		$gold = $_POST['gold']*1;
		// set mob values
		$_SESSION['mob'][$Slot]->name = $name;
		$_SESSION['mob'][$Slot]->exp = $exp;
		$_SESSION['mob'][$Slot]->gold = $gold;
		echo $_SESSION['mob'][$Slot]->exp;
	}
	function updateExpGold(){
		global $link;
		$exp = $_POST['exp']*1;
		$mobExp = $_POST['mobExp']*1;
		$Slot = $_POST['Slot']*1;
		$gold = $_POST['gold']*1;
		$name = $_POST['name'];
		$name = $_POST['name'];
		$email = $_SESSION['email'];
		if($mobExp > 0){
			// was the value changed/hacked?
			if($mobExp != $_SESSION['mob'][$Slot]->exp){
				$exp = 0;
			}
		}
		// sanity check
		if($exp > 200000){
			$exp = 0;
		}
		// insert
		$query = "select gold, exp from characters where name=? and email=?";
		$stmt = $link->prepare($query);
		$stmt->bind_param('ss', $name, $_SESSION['email']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($db_gold, $db_exp);
		while($stmt->fetch()){
			$my_gold = $db_gold;
			$my_exp = $db_exp;
		}
		$my_gold = $my_gold + $gold;
		$my_exp = $my_exp + $exp;
		if($my_exp > 103835784){
			$my_exp = 103835784;
		}
		$query = "update characters set exp=?, gold=? where email=? and season=? and name=?";
		$stmt = $link->prepare($query);
		$stmt->bind_param('iisis', $my_exp, $my_gold, $email, $_SESSION['season'], $name);
		$stmt->execute();
		echo $exp;
	}
	function updateCombo(){
		global $link;
		$rating = $_POST['rating']*1;
		$name = $_POST['name'];
		$query = "select comboOverall from characters where name=? and season=?";
		$stmt = $link->prepare($query);
		$stmt->bind_param('si', $name, $_SESSION['season']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($db_combo);
		while($stmt->fetch()){
			$combo = $db_combo*1;
		}
		if($rating > $combo){
			$query = "update characters set comboOverall=? where email=? and season=? and name=?";
			$stmt = $link->prepare($query);
			$stmt->bind_param('isis', $rating, $_SESSION['email'], $_SESSION['season'], $name);
			$stmt->execute();
		}
	}
	function updateQuests(){
		global $link;
		$Q = $_POST['Q'];
		$diff = $_POST['diff'];
		$name = $_POST['name'];
		$stmt = $link->prepare('update quests set bb1=?, bb2=?, bb3=?, bb4=?, befallen=?, 
		bf1=?, bf2=?, bf3=?, bf4=?, blackburrow=?, 
		castleMistmoore=?, cazicThule=?, cb1=?, cb2=?, cb3=?, 
		cb4=?, cb5=?, cm1=?, cm2=?, cm3=?, 
		cm4=?, cm5=?, cm6=?, crushbone=?, ct1=?, 
		ct2=?, ct3=?, ct4=?, ct5=?, er1=?, 
		er2=?, er3=?, er4=?, er5=?, estateOfUnrest=?, 
		gf1=?, greaterFaydark=?, kedgeKeep=?, kk1=?, kk2=?, 
		kk3=?, kk4=?, kk5=?, kk6=?, kk7=?, 
		kk8=?, lesserFaydark=?, lf1=?, lf2=?, lg1=?, 
		lg2=?, lg3=?, lg4=?, lg5=?, lg6=?, 
		lowerGuk=?, nagafensLair=?, najena=?, nj1=?, nj2=?, 
		nj3=?, nj4=?, nj5=?, nl1=?, nl2=?, 
		nl3=?, nl4=?, nl5=?, nl6=?, nl7=?, 
		nl8=?, nl9=?, nl10=?, nl11=?, nl12=?, 
		northRo=?, nr1=?, nr2=?, permafrostKeep=?, pf1=?, 
		pf2=?, pf3=?, pf4=?, pf5=?, pf6=?, 
		pf7=?, pf8=?, pf9=?, pf10=?, pf11=?, 
		pf12=?, pf13=?, pf14=?, pf15=?, pf16=?, 
		pf17=?, pf18=?, pf19=?, pf20=?, pf21=?, 
		pf22=?, ph1=?, ph2=?, ph3=?, ph4=?, 
		ph5=?, ph6=?, ph7=?, ph8=?, ph9=?, 
		ph10=?, ph11=?, ph12=?, ph13=?, pk1=?, 
		pk2=?, pk3=?, pk4=?, pk5=?, pk6=?, 
		pk7=?, pk8=?, pk9=?, planeOfFear=?, planeOfHate=?, 
		repeatCB=?, repeatCm3=?, repeatCt3=?, repeatER=?, repeatKk3=?, 
		repeatKk4=?, repeatLg3=?, repeatNl3=?, repeatNl4=?, repeatPk4=?, 
		ug1=?, ug2=?, ug3=?, ug4=?, upperGuk=? 
		where email=? 
		and name=? 
		and difficulty=?');
		$stmt->bind_param('iiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiissi', $Q['BB1'], $Q['BB2'], $Q['BB3'], $Q['BB4'], $Q['Befallen'], 
		$Q['BF1'], $Q['BF2'], $Q['BF3'], $Q['BF4'], $Q['Blackburrow'], 
		$Q['CastleMistmoore'], $Q['CazicThule'], $Q['CB1'], $Q['CB2'], $Q['CB3'], 
		$Q['CB4'], $Q['CB5'], $Q['CM1'], $Q['CM2'], $Q['CM3'], 
		$Q['CM4'], $Q['CM5'], $Q['CM6'], $Q['Crushbone'], $Q['CT1'], 
		$Q['CT2'], $Q['CT3'], $Q['CT4'], $Q['CT5'], $Q['ER1'], 
		$Q['ER2'], $Q['ER3'], $Q['ER4'], $Q['ER5'], $Q['EstateofUnrest'], 
		$Q['GF1'], $Q['GreaterFaydark'], $Q['KedgeKeep'], $Q['KK1'], $Q['KK2'], 
		$Q['KK3'], $Q['KK4'], $Q['KK5'], $Q['KK6'], $Q['KK7'], 
		$Q['KK8'], $Q['LesserFaydark'], $Q['LF1'], $Q['LF2'], $Q['LG1'], 
		$Q['LG2'], $Q['LG3'], $Q['LG4'], $Q['LG5'], $Q['LG6'], 
		$Q['LowerGuk'], $Q['NagafensLair'], $Q['Najena'], $Q['NJ1'], $Q['NJ2'], 
		$Q['NJ3'], $Q['NJ4'], $Q['NJ5'], $Q['NL1'], $Q['NL2'], 
		$Q['NL3'], $Q['NL4'], $Q['NL5'], $Q['NL6'], $Q['NL7'], 
		$Q['NL8'], $Q['NL9'], $Q['NL10'], $Q['NL11'], $Q['NL12'], 
		$Q['NorthRo'], $Q['NR1'], $Q['NR2'], $Q['PermafrostKeep'], $Q['PF1'], 
		$Q['PF2'], $Q['PF3'], $Q['PF4'], $Q['PF5'], $Q['PF6'], 
		$Q['PF7'], $Q['PF8'], $Q['PF9'], $Q['PF10'], $Q['PF11'], 
		$Q['PF12'], $Q['PF13'], $Q['PF14'], $Q['PF15'], $Q['PF16'], 
		$Q['PF17'], $Q['PF18'], $Q['PF19'], $Q['PF20'], $Q['PF21'], 
		$Q['PF22'], $Q['PH1'], $Q['PH2'], $Q['PH3'], $Q['PH4'], 
		$Q['PH5'], $Q['PH6'], $Q['PH7'], $Q['PH8'], $Q['PH9'], 
		$Q['PH10'], $Q['PH11'], $Q['PH12'], $Q['PH13'], $Q['PK1'], 
		$Q['PK2'], $Q['PK3'], $Q['PK4'], $Q['PK5'], $Q['PK6'], 
		$Q['PK7'], $Q['PK8'], $Q['PK9'], $Q['PlaneofFear'], $Q['PlaneofHate'], 
		$Q['repeatCB'], $Q['repeatCm3'], $Q['repeatCt3'], $Q['repeatER'], $Q['repeatKk3'], 
		$Q['repeatKk4'], $Q['repeatLg3'], $Q['repeatNl3'], $Q['repeatNl4'], $Q['repeatPk4'], 
		$Q['UG1'], $Q['UG2'], $Q['UG3'], $Q['UG4'], $Q['UpperGuk'], 
		$_SESSION['email'], $name, $diff);
		$stmt->execute();
	}
	function updateGLB(){
		global $link;
		$GLB = $_POST['GLB'];
		$query = "update glb set chatMyHit=?, hideMenu=?, musicStatus=?, soundStatus=?, tooltipMode=?, videoSetting=?, showCombatLog=?, debugMode=? where email=?;";
		$stmt = $link->prepare($query);
		$stmt->bind_param('ssiisssss', 
			$GLB['chatMyHit'], $GLB['hideMenu'], $GLB['musicStatus'], $GLB['soundStatus'], $GLB['tooltipMode'], $GLB['videoSetting'], $GLB['showCombatLog'], $GLB['debugMode'], $_SESSION['email']
		);
		$stmt->execute();
	}
	function updateMy(){
		global $link;
		$my = $_POST['my'];
		$stmt = $link->prepare("update characters set comboMistmoore=?,
		comboLowerGuk=?,
		comboCazicThule=?,
		comboKedgeKeep=?,
		comboPermafrost=?,
		comboSolB=?,
		comboPlaneofHate=?,
		comboPlaneofFear=?,
		abjuration=?,
		agi=?,
		alteration=?,
		cha=?,
		championsSlain=?,
		channeling=?,
		conjuration=?,
		deaths=?,
		defense=?,
		dex=?,
		difficulty=?,
		dodge=?,
		doubleAttack=?,
		dualWield=?,
		epicQuests=?,
		escapes=?,
		evocation=?,
		gender=?,
		handtohand=?,
		hardcoreMode=?,
		hp=?,
		intel=?,
		job=?,
		lastName=?,
		level=?,
		magicFound=?,
		maxHp=?,
		maxMp=?,
		mobsSlain=?,
		mp=?,
		offense=?,
		oneHandBlunt=?,
		oneHandSlash=?,
		parry=?,
		patch=?,
		piercing=?,
		playtime=?,
		quests=?,
		race=?,
		raresFound=?,
		riposte=?,
		setFound=?,
		sta=?,
		story=?,
		str=?,
		subzone=?,
		subzoneN=?,
		subzoneH=?,
		svcold=?,
		svfire=?,
		svlightning=?,
		svmagic=?,
		svpoison=?,
		talent1=?,
		talent2=?,
		talent3=?,
		talent4=?,
		talent5=?,
		talent6=?,
		talent7=?,
		talent8=?,
		talent9=?,
		talent10=?,
		talent11=?,
		talent12=?,
		title=?,
		totalGold=?,
		twoHandBlunt=?,
		twoHandSlash=?,
		uniquesFound=?,
		upgrades=?,
		wis=?,
		zone=?,
		zoneH=?,
		zoneN=?, 
		raresSlain=? 
		where email=? 
		and name=?");
		$stmt->bind_param('iiiiiiiiiiiiiiiiiiiiiiiiisisiissiiiiiiiiiisiiisiiiisiiiiiiiiiiiiiiiiiiiiisiiiiiisssiss', 
			$my['comboMistmoore'], $my['comboLowerGuk'], $my['comboCazicThule'], $my['comboKedgeKeep'], 
			$my['comboPermafrost'], $my['comboSolB'], $my['comboPlaneofHate'], $my['comboPlaneofFear'], 
			$my['abjuration'], $my['agi'], $my['alteration'], $my['cha'], 
			$my['championsSlain'], $my['channeling'], $my['conjuration'], $my['deaths'], $my['defense'], 
			$my['dex'], $my['difficulty'], $my['dodge'], $my['doubleAttack'], $my['dualWield'], 
			$my['epicQuests'], $my['escapes'], $my['evocation'], $my['gender'], 
			$my['handtohand'], $my['hardcoreMode'], $my['hp'], $my['intel'], 
			$my['job'], $my['lastName'], $my['level'], $my['magicFound'], 
			$my['maxHp'], $my['maxMp'], $my['mobsSlain'], $my['mp'], $my['offense'], 
			$my['oneHandBlunt'], $my['oneHandSlash'], $my['parry'], $my['patch'], $my['piercing'], 
			$my['playtime'], $my['quests'], $my['race'], $my['raresFound'], $my['riposte'], 
			$my['setFound'], $my['sta'], $my['story'], $my['str'], $my['subzone'], 
			$my['subzoneN'], $my['subzoneH'], $my['svcold'], $my['svfire'], $my['svlightning'], 
			$my['svmagic'], $my['svpoison'], $my['talent1'], $my['talent2'], $my['talent3'], 
			$my['talent4'], $my['talent5'], $my['talent6'], $my['talent7'], $my['talent8'], 
			$my['talent9'], $my['talent10'], $my['talent11'], $my['talent12'], $my['title'], 
			$my['totalGold'], $my['twoHandBlunt'], $my['twoHandSlash'], $my['uniquesFound'], $my['upgrades'], 
			$my['wis'], $my['zone'], $my['zoneH'], $my['zoneN'], $my['raresSlain'], $_SESSION['email'], $my['name']
		);
		$stmt->execute();
		$str = '';
		$color = 1;
		if($my['hardcoreMode']=='true' &&
		($my['deaths']*1) > 0){
			// report hardcore death
			$query = "insert into chat (`message`, `class`) values (?, ?);";
			$stmt = $link->prepare($query);
			if($my['gender']=="Male"){
				$str = "We regret to announce that {$my['name']}, a level {$my['level']} {$my['job']}, has been tragically slain. His blood's upon the soil!";
				$stmt->bind_param('si', $str, $color);
			}else{
				$str = "We regret to announce that {$my['name']}, a level {$my['level']} {$my['job']}, has been tragically slain. Her blood's upon the soil!!";
				$stmt->bind_param('si', $str, $color);
			}
			$stmt->execute();
		}
	}
	function updateItem(){
		global $link;
		$item = $_POST['item'];
		$Slot = $_POST['Slot'];
		$name = $_POST['name'];
		$slotType = $_POST['slotType'];
		if($slotType=='bank'){
			$stmt = $link->prepare("update item set abjuration=?,
			absorbCold=?,
			absorbFire=?,
			absorbLightning=?,
			absorbMagic=?,
			absorbPoison=?,
			agi=?,
			allResist=?,
			allSkills=?,
			allStats=?,
			alteration=?,
			armor=?,
			attack=?,
			castingHaste=?,
			cha=?,
			channeling=?,
			cold=?,
			coldDamage=?,
			conjuration=?,
			critChance=?,
			critDamage=?,
			damage=?,
			defense=?,
			delay=?,
			dex=?,
			dodge=?,
			doubleAttack=?,
			dualWield=?,
			enhanceAll=?,
			enhanceCold=?,
			enhanceFire=?,
			enhanceLightning=?,
			enhanceMagic=?,
			enhancePhysical=?,
			enhancePoison=?,
			enhancedArmor=?,
			enhancedDamage=?,
			evocation=?,
			expFind=?,
			fear=?,
			fireDamage=?,
			flavorText=?,
			globalHaste=?,
			goldFind=?,
			handtohand=?,
			haste=?,
			hp=?,
			hpKill=?,
			hpRegen=?,
			ias=?,
			itemSlot=?,
			intel=?,
			leech=?,
			lightRadius=?,
			lightningDamage=?,
			magMit=?,
			magicDamage=?,
			mp=?,
			mpKill=?,
			mpRegen=?,
			name=?,
			offense=?,
			oneHandBlunt=?,
			oneHandSlash=?,
			parry=?,
			phyMit=?,
			physicalDamage=?,
			piercing=?,
			poisonDamage=?,
			proc=?,
			quality=?,
			rarity=?,
			req=?,
			resistCold=?,
			resistFire=?,
			resistLightning=?,
			resistMagic=?,
			resistPoison=?,
			riposte=?,
			runSpeed=?,
			silence=?,
			sta=?,
			str=?,
			stun=?,
			thorns=?,
			twoHandBlunt=?,
			twoHandSlash=?,
			type=?,
			upgrade=?,
			weight=?,
			wis=?,
			wraith=?,
			xPos=?,
			yPos=? 
			where email=? 
			and slotType=? 
			and slot=? and hardcoreMode=?");
			$stmt->bind_param('iiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiisiiiiiiiisiiiiiiiiisiiiiiiiisiiiiiiiiiiiiiiiiisiiiiiissis', 
				$item['abjuration'], $item['absorbCold'], $item['absorbFire'], $item['absorbLightning'], $item['absorbMagic'], 
				$item['absorbPoison'], $item['agi'], $item['allResist'], $item['allSkills'], $item['allStats'], 
				$item['alteration'], $item['armor'], $item['attack'], $item['castingHaste'], $item['cha'], 
				$item['channeling'], $item['cold'], $item['coldDamage'], $item['conjuration'], $item['critChance'], 
				$item['critDamage'], $item['damage'], $item['defense'], $item['delay'], $item['dex'], 
				$item['dodge'], $item['doubleAttack'], $item['dualWield'], $item['enhanceAll'], $item['enhanceCold'], 
				$item['enhanceFire'], $item['enhanceLightning'], $item['enhanceMagic'], $item['enhancePhysical'], $item['enhancePoison'], 
				$item['enhancedArmor'], $item['enhancedDamage'], $item['evocation'], $item['expFind'], $item['fear'], 
				$item['fireDamage'], $item['flavorText'], $item['globalHaste'], $item['goldFind'], $item['handtohand'], 
				$item['haste'], $item['hp'], $item['hpKill'], $item['hpRegen'], $item['ias'], 
				$item['itemSlot'], $item['intel'], $item['leech'], $item['lightRadius'], $item['lightningDamage'], 
				$item['magMit'], $item['magicDamage'], $item['mp'], $item['mpKill'], $item['mpRegen'], 
				$item['name'], $item['offense'], $item['oneHandBlunt'], $item['oneHandSlash'], $item['parry'], 
				$item['phyMit'], $item['physicalDamage'], $item['piercing'], $item['poisonDamage'], $item['proc'], 
				$item['quality'], $item['rarity'], $item['req'], $item['resistCold'], $item['resistFire'], 
				$item['resistLightning'], $item['resistMagic'], $item['resistPoison'], $item['riposte'], $item['runSpeed'], 
				$item['silence'], $item['sta'], $item['str'], $item['stun'], $item['thorns'], 
				$item['twoHandBlunt'], $item['twoHandSlash'], $item['type'], $item['upgrade'], $item['weight'], 
				$item['wis'], $item['wraith'], $item['xPos'], $item['yPos'], $_SESSION['email'], 
				$slotType, $Slot, $_SESSION['hardcoreMode']);
		}else{
			$stmt = $link->prepare("update item set abjuration=?,
				absorbCold=?,
				absorbFire=?,
				absorbLightning=?,
				absorbMagic=?,
				absorbPoison=?,
				agi=?,
				allResist=?,
				allSkills=?,
				allStats=?,
				alteration=?,
				armor=?,
				attack=?,
				castingHaste=?,
				cha=?,
				channeling=?,
				cold=?,
				coldDamage=?,
				conjuration=?,
				critChance=?,
				critDamage=?,
				damage=?,
				defense=?,
				delay=?,
				dex=?,
				dodge=?,
				doubleAttack=?,
				dualWield=?,
				enhanceAll=?,
				enhanceCold=?,
				enhanceFire=?,
				enhanceLightning=?,
				enhanceMagic=?,
				enhancePhysical=?,
				enhancePoison=?,
				enhancedArmor=?,
				enhancedDamage=?,
				evocation=?,
				expFind=?,
				fear=?,
				fireDamage=?,
				flavorText=?,
				globalHaste=?,
				goldFind=?,
				handtohand=?,
				haste=?,
				hp=?,
				hpKill=?,
				hpRegen=?,
				ias=?,
				itemSlot=?,
				intel=?,
				leech=?,
				lightRadius=?,
				lightningDamage=?,
				magMit=?,
				magicDamage=?,
				mp=?,
				mpKill=?,
				mpRegen=?,
				name=?,
				offense=?,
				oneHandBlunt=?,
				oneHandSlash=?,
				parry=?,
				phyMit=?,
				physicalDamage=?,
				piercing=?,
				poisonDamage=?,
				proc=?,
				quality=?,
				rarity=?,
				req=?,
				resistCold=?,
				resistFire=?,
				resistLightning=?,
				resistMagic=?,
				resistPoison=?,
				riposte=?,
				runSpeed=?,
				silence=?,
				sta=?,
				str=?,
				stun=?,
				thorns=?,
				twoHandBlunt=?,
				twoHandSlash=?,
				type=?,
				upgrade=?,
				weight=?,
				wis=?,
				wraith=?,
				xPos=?,
				yPos=? 
				where email=? 
				and characterName=? 
				and slotType=? 
				and slot=?");
			$stmt->bind_param('iiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiisiiiiiiiisiiiiiiiiisiiiiiiiisiiiiiiiiiiiiiiiiisiiiiiisssi', 
				$item['abjuration'], $item['absorbCold'], $item['absorbFire'], $item['absorbLightning'], $item['absorbMagic'], 
				$item['absorbPoison'], $item['agi'], $item['allResist'], $item['allSkills'], $item['allStats'], 
				$item['alteration'], $item['armor'], $item['attack'], $item['castingHaste'], $item['cha'], 
				$item['channeling'], $item['cold'], $item['coldDamage'], $item['conjuration'], $item['critChance'], 
				$item['critDamage'], $item['damage'], $item['defense'], $item['delay'], $item['dex'], 
				$item['dodge'], $item['doubleAttack'], $item['dualWield'], $item['enhanceAll'], $item['enhanceCold'], 
				$item['enhanceFire'], $item['enhanceLightning'], $item['enhanceMagic'], $item['enhancePhysical'], $item['enhancePoison'], 
				$item['enhancedArmor'], $item['enhancedDamage'], $item['evocation'], $item['expFind'], $item['fear'], 
				$item['fireDamage'], $item['flavorText'], $item['globalHaste'], $item['goldFind'], $item['handtohand'], 
				$item['haste'], $item['hp'], $item['hpKill'], $item['hpRegen'], $item['ias'], 
				$item['itemSlot'], $item['intel'], $item['leech'], $item['lightRadius'], $item['lightningDamage'], 
				$item['magMit'], $item['magicDamage'], $item['mp'], $item['mpKill'], $item['mpRegen'], 
				$item['name'], $item['offense'], $item['oneHandBlunt'], $item['oneHandSlash'], $item['parry'], 
				$item['phyMit'], $item['physicalDamage'], $item['piercing'], $item['poisonDamage'], $item['proc'], 
				$item['quality'], $item['rarity'], $item['req'], $item['resistCold'], $item['resistFire'], 
				$item['resistLightning'], $item['resistMagic'], $item['resistPoison'], $item['riposte'], $item['runSpeed'], 
				$item['silence'], $item['sta'], $item['str'], $item['stun'], $item['thorns'], 
				$item['twoHandBlunt'], $item['twoHandSlash'], $item['type'], $item['upgrade'], $item['weight'], 
				$item['wis'], $item['wraith'], $item['xPos'], $item['yPos'], $_SESSION['email'], 
				$name, $slotType, $Slot);
		}
		$stmt->execute();
	}
	function camp(){
		global $link;
		$query = 'delete from ping where email=?';
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $_SESSION['email']);
		$stmt->execute();
	}
	call_user_func($_POST['run']);
?>