<?php
	require_once('connect1.php');
	
	function loadGlb(){
		global $link;
		$query = "select chatMyHit, hideMenu, musicStatus, soundStatus, tooltipMode, videoSetting, showCombatLog, debugMode from glb where email='".$_SESSION['email']."' limit 1";
		$result = $link->query($query);
		$str = '';
		while($row = $result->fetch_assoc()){
			$str .= $row['chatMyHit'] ."|";
			$str .= $row['hideMenu'] ."|";
			$str .= $row['musicStatus'] ."|";
			$str .= $row['soundStatus'] ."|";
			$str .= $row['tooltipMode'] ."|";
			$str .= $row['videoSetting'] ."|";
			$str .= $row['showCombatLog'] ."|";
			$str .= $row['debugMode'] ."|";
		}
		// check GLB balance
		$query = "select gold from accounts where email=?";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $_SESSION['email']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($dbGold);
		while($stmt->fetch()){
			$bankGold = $dbGold*1;
		}
		$str .= $bankGold ."|";
		// hardcore bank balance
		$query = "select hcgold from accounts where email=?";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $_SESSION['email']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($dbGold);
		while($stmt->fetch()){
			$bankGold = $dbGold*1;
		}
		$str .= $bankGold ."|";
		// crystals
		$query = "select bankSlots, hcBankSlots, characters, crystals, kstier, account, confirmed from accounts where email='".$_SESSION['email']."' limit 1";
		$result = $link->query($query);
		while($row = $result->fetch_assoc()){
			$_SESSION['characterSlots'] = $row['characters']*1;
			$str .= $row['bankSlots']."|";
			$str .= $row['hcBankSlots']."|";
			$str .= $_SESSION['characterSlots']."|";
			$str .= $row['crystals']."|";
			$str .= $row['kstier']."|";
			$str .= $row['account']."|";
			$str .= $row['confirmed']."|";
		}
		echo $str;
	}
	function loadMy(){
		global $link;
		// Nevergrounds uses this - use $ng to avoid use of $_SESSION!
		$ng = $_POST['ng'];
		
		if(strlen($_POST['name'])<1 && is_string($_POST['name'])){
			echo '';
			exit;
		}
		if($ng=='false'){
			$query = "select status from accounts where email=? limit 1";
			$stmt = $link->prepare($query);
			$stmt->bind_param('s', $_SESSION['email']);
			$stmt->execute();
			$stmt->bind_result($stmtStatus);
			while($stmt->fetch()){
				$dbStatus = $stmtStatus;
			}
			if($dbStatus=="suspended"){
				echo "Account has been suspended.";
				exit;
			}
			if($dbStatus=="banned"){
				echo "Account has been banned.";
				exit;
			}
			
			if($_SESSION['email']==''){
				echo "Your session has expired.";
				exit;
			}
		}
		$query = "select name, abjuration, agi, alteration, cha, championsSlain, channeling, conjuration, deaths, defense, dex, difficulty, dodge, doubleAttack, dualWield, epicQuests, escapes, evocation, exp, gender, gold, handtohand, hardcoreMode, hp, intel, job, lastName, level, magicFound, maxHp, maxMp, mobsSlain, mp, offense, oneHandBlunt, oneHandSlash, parry, patch, piercing, playtime, quests, race, raresFound, riposte, setFound, sta, story, str, subzone, subzoneN, subzoneH, svcold, svfire, svlightning, svmagic, svpoison, talent1, talent2, talent3, talent4, talent5, talent6, talent7, talent8, talent9, talent10, talent11, talent12, title, totalGold, twoHandBlunt, twoHandSlash, uniquesFound, upgrades, wis, zone, zoneH, zoneN, comboOverall, comboMistmoore, comboLowerGuk, comboCazicThule, comboKedgeKeep, comboPermafrost, comboSolB, comboPlaneofHate, comboPlaneofFear, raresSlain, views from characters where name=? order by row";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $_POST['name']);
		$stmt->execute();
		$stmt->bind_result($name, $abjuration, $agi, $alteration, $cha, 
		$championsSlain, $channeling, $conjuration, $deaths, $defense, 
		$dex, $diff, $dodge, $doubleAttack, $dualWield, 
		$epicQuests, $escapes, $evocation, $exp, $gender, 
		$gold, $handtohand, $hardcoreMode, $hp, $intel, 
		$job, $lastName, $level, $magicFound, 
		$maxHp, $maxMp, $mobsSlain, $mp, $offense, 
		$oneHandBlunt, $oneHandSlash, $parry, $patch, $piercing, 
		$playtime, $quests, $race, $raresFound, $riposte, 
		$setFound, $sta, $story, $str, $subzone, 
		$subzoneN, $subzoneH, $svcold, $svfire, $svlightning, 
		$svmagic, $svpoison, $talent1, $talent2, $talent3, 
		$talent4, $talent5, $talent6, $talent7, $talent8, 
		$talent9, $talent10, $talent11, $talent12, $title, 
		$totalGold, $twoHandBlunt, $twoHandSlash, $uniquesFound, $upgrades, 
		$wis, $zone, $zoneH, $zoneN, 
		$comboOverall, $comboMistmoore, $comboLowerGuk, $comboCazicThule, $comboKedgeKeep, 
		$comboPermafrost, $comboSolB, $comboPlaneofHate, $comboPlaneofFear, $raresSlain, $views);
		$s = '';
		while($stmt->fetch()){
			if($ng=='false'){
				$_SESSION['hardcoreMode'] = $hardcoreMode;
				$_SESSION['difficulty'] = $diff;
			}
			$s.= $name."|";
			$s.= $abjuration."|";
			$s.= $agi."|";
			$s.= $alteration."|";
			$s.= $cha."|";
			$s.= $championsSlain."|";
			$s.= $channeling."|";
			$s.= $conjuration."|";
			$s.= $deaths."|";
			$s.= $defense."|";
			$s.= $dex."|";
			$s.= $diff."|";
			$s.= $dodge."|";
			$s.= $doubleAttack."|";
			$s.= $dualWield."|";
			$s.= $epicQuests."|";
			$s.= $escapes."|";
			$s.= $evocation."|";
			$s.= $exp."|";
			$s.= $gender."|";
			$s.= $gold."|";
			$s.= $handtohand."|";
			$s.= $hardcoreMode."|";
			$s.= $hp."|";
			$s.= $intel."|";
			$s.= $job."|";
			$s.= $lastName."|";
			$s.= $level."|";
			$s.= $magicFound."|";
			$s.= $maxHp."|";
			$s.= $maxMp."|";
			$s.= $mobsSlain."|";
			$s.= $mp."|";
			$s.= $offense."|";
			$s.= $oneHandBlunt."|";
			$s.= $oneHandSlash."|";
			$s.= $parry."|";
			$s.= $patch."|";
			$s.= $piercing."|";
			$s.= $playtime."|";
			$s.= $quests."|";
			$s.= $race."|";
			$s.= $raresFound."|";
			$s.= $riposte."|";
			$s.= $setFound."|";
			$s.= $sta."|";
			$s.= $story."|";
			$s.= $str."|";
			$s.= $subzone."|";
			$s.= $subzoneN."|";
			$s.= $subzoneH."|";
			$s.= $svcold."|";
			$s.= $svfire."|";
			$s.= $svlightning."|";
			$s.= $svmagic."|";
			$s.= $svpoison."|";
			$s.= $talent1."|";
			$s.= $talent2."|";
			$s.= $talent3."|";
			$s.= $talent4."|";
			$s.= $talent5."|";
			$s.= $talent6."|";
			$s.= $talent7."|";
			$s.= $talent8."|";
			$s.= $talent9."|";
			$s.= $talent10."|";
			$s.= $talent11."|";
			$s.= $talent12."|";
			$s.= $title."|";
			$s.= $totalGold."|";
			$s.= $twoHandBlunt."|";
			$s.= $twoHandSlash."|";
			$s.= $uniquesFound."|";
			$s.= $upgrades."|";
			$s.= $wis."|";
			$s.= $zone."|";
			$s.= $zoneH."|";
			$s.= $zoneN."|";
			$s.= $comboOverall."|";
			$s.= $comboMistmoore."|";
			$s.= $comboLowerGuk."|";
			$s.= $comboCazicThule."|";
			$s.= $comboKedgeKeep."|";
			$s.= $comboPermafrost."|";
			$s.= $comboSolB."|";
			$s.= $comboPlaneofHate."|";
			$s.= $comboPlaneofFear."|";
			$s.= $raresSlain."|";
			$s.= $views."|";
		}
		if($ng=='false'){
			if($_SESSION['hardcoreMode']=='true'){
				if(($deaths*1)>0){
					echo "DEAD";
				}else{
					echo $s;
				}
			}else{
				echo $s;
			};
			$query = "update characters set timestamp=now() where name=?";
			$stmt = $link->prepare($query);
			$stmt->bind_param('s', $_POST['name']);
			$stmt->execute();
		}else{
			echo $s;
		}
	}
	function loadItem(){
		global $link;
		$_SESSION['mob'] = array();
		for($i=0;$i<=4;$i++){
			$_SESSION['mob'][$i] = new STDClass();
		}
		if(strlen($_POST['name'])<1 && is_string($_POST['name'])){
			echo '';
			exit;
		}
		// check if server is up - only I am allowed to enter while down
		$query = "select status from server_status order by row desc limit 1";
		$stmt = mysqli_prepare($link, $query);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);
		mysqli_stmt_bind_result($stmt, $db_status);
		if(mysqli_stmt_fetch($stmt)){
			$status = $db_status;
		}
		if($_SESSION['email']!='joemattleonard@gmail.com'){
			if($status=="down"){
				echo "down";
				exit;
			}
		}
		$query = "select abjuration, absorbCold, absorbFire, absorbLightning, absorbMagic, absorbPoison, agi, allResist, allSkills, allStats, alteration, armor, attack, castingHaste, cha, channeling, cold, coldDamage, conjuration, critChance, critDamage, damage, defense, delay, dex, dodge, doubleAttack, dualWield, enhanceAll, enhanceCold, enhanceFire, enhanceLightning, enhanceMagic, enhancePhysical, enhancePoison, enhancedArmor, enhancedDamage, evocation, expFind, fear, fireDamage, flavorText, globalHaste, goldFind, handtohand, haste, hp, hpKill, hpRegen, ias, intel, itemSlot, leech, lightRadius, lightningDamage, magMit, magicDamage, mp, mpKill, mpRegen, name, offense, oneHandBlunt, oneHandSlash, parry, phyMit, physicalDamage, piercing, poisonDamage, proc, quality, rarity, req, resistCold, resistFire, resistLightning, resistMagic, resistPoison, riposte, runSpeed, silence, sta, str, stun, thorns, twoHandBlunt, twoHandSlash, type, upgrade, weight, wis, wraith, xPos, yPos from item where email='".$_SESSION['email']."' and season=".$_SESSION['season']." and characterName=? and slotType='item' order by slot limit 24";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $_POST['name']);
		$stmt->execute();
		$stmt->bind_result($abjuration, $absorbCold, $absorbFire, $absorbLightning, $absorbMagic, 
		$absorbPoison, $agi, $allResist, $allSkills, $allStats, 
		$alteration, $armor, $attack, $castingHaste, $cha, 
		$channeling, $cold, $coldDamage, $conjuration, $critChance, 
		$critDamage, $damage, $defense, $delay, $dex, 
		$dodge, $doubleAttack, $dualWield, $enhanceAll, $enhanceCold, 
		$enhanceFire, $enhanceLightning, $enhanceMagic, $enhancePhysical, $enhancePoison, 
		$enhancedArmor, $enhancedDamage, $evocation, $expFind, $fear, 
		$fireDamage, $flavorText, $globalHaste, $goldFind, $handtohand, 
		$haste, $hp, $hpKill, $hpRegen, $ias, 
		$intel, $itemSlot, $leech, $lightRadius, $lightningDamage, 
		$magMit, $magicDamage, $mp, $mpKill, $mpRegen, 
		$name, $offense, $oneHandBlunt, $oneHandSlash, $parry, 
		$phyMit, $physicalDamage, $piercing, $poisonDamage, $proc, 
		$quality, $rarity, $req, $resistCold, $resistFire, 
		$resistLightning, $resistMagic, $resistPoison, $riposte, $runSpeed, 
		$silence, $sta, $str, $stun, $thorns, 
		$twoHandBlunt, $twoHandSlash, $type, $upgrade, $weight, 
		$wis, $wraith, $xPos, $yPos);
		$s = '';
		while($stmt->fetch()){
			$s.= $abjuration."|";
			$s.= $absorbCold."|";
			$s.= $absorbFire."|";
			$s.= $absorbLightning."|";
			$s.= $absorbMagic."|";
			$s.= $absorbPoison."|";
			$s.= $agi."|";
			$s.= $allResist."|";
			$s.= $allSkills."|";
			$s.= $allStats."|";
			$s.= $alteration."|";
			$s.= $armor."|";
			$s.= $attack."|";
			$s.= $castingHaste."|";
			$s.= $cha."|";
			$s.= $channeling."|";
			$s.= $cold."|";
			$s.= $coldDamage."|";
			$s.= $conjuration."|";
			$s.= $critChance."|";
			$s.= $critDamage."|";
			$s.= $damage."|";
			$s.= $defense."|";
			$s.= $delay."|";
			$s.= $dex."|";
			$s.= $dodge."|";
			$s.= $doubleAttack."|";
			$s.= $dualWield."|";
			$s.= $enhanceAll."|";
			$s.= $enhanceCold."|";
			$s.= $enhanceFire."|";
			$s.= $enhanceLightning."|";
			$s.= $enhanceMagic."|";
			$s.= $enhancePhysical."|";
			$s.= $enhancePoison."|";
			$s.= $enhancedArmor."|";
			$s.= $enhancedDamage."|";
			$s.= $evocation."|";
			$s.= $expFind."|";
			$s.= $fear."|";
			$s.= $fireDamage."|";
			$s.= $flavorText."|";
			$s.= $globalHaste."|";
			$s.= $goldFind."|";
			$s.= $handtohand."|";
			$s.= $haste."|";
			$s.= $hp."|";
			$s.= $hpKill."|";
			$s.= $hpRegen."|";
			$s.= $ias."|";
			$s.= $intel."|";
			$s.= $itemSlot."|";
			$s.= $leech."|";
			$s.= $lightRadius."|";
			$s.= $lightningDamage."|";
			$s.= $magMit."|";
			$s.= $magicDamage."|";
			$s.= $mp."|";
			$s.= $mpKill."|";
			$s.= $mpRegen."|";
			$s.= $name."|";
			$s.= $offense."|";
			$s.= $oneHandBlunt."|";
			$s.= $oneHandSlash."|";
			$s.= $parry."|";
			$s.= $phyMit."|";
			$s.= $physicalDamage."|";
			$s.= $piercing."|";
			$s.= $poisonDamage."|";
			$s.= $proc."|";
			$s.= $quality."|";
			$s.= $rarity."|";
			$s.= $req."|";
			$s.= $resistCold."|";
			$s.= $resistFire."|";
			$s.= $resistLightning."|";
			$s.= $resistMagic."|";
			$s.= $resistPoison."|";
			$s.= $riposte."|";
			$s.= $runSpeed."|";
			$s.= $silence."|";
			$s.= $sta."|";
			$s.= $str."|";
			$s.= $stun."|";
			$s.= $thorns."|";
			$s.= $twoHandBlunt."|";
			$s.= $twoHandSlash."|";
			$s.= $type."|";
			$s.= $upgrade."|";
			$s.= $weight."|";
			$s.= $wis."|";
			$s.= $wraith."|";
			$s.= $xPos."|";
			$s.= $yPos."|";
		}
		
		// more than 0? 
		if(php_uname('n')!="JOE-PC"){
			$query = "select email from ping where email=? and timestamp>date_sub(now(), interval 30 second)";
			$stmt = $link->prepare($query);
			$stmt->bind_param('s', $_SESSION['email']);
			$stmt->execute();
			$stmt->store_result();
			$count = $stmt->num_rows;
			if($count>0){
				echo 'false';
			}else{
				echo $s;
			}
		}else{
			echo $s;
		}
	}
	function loadBank(){
		global $link;
		// check crystal balance
		$mode = $_SESSION['hardcoreMode'];
		if($mode=='false'){
			$query = "select bankSlots from accounts where email=?";
		}else{
			$query = "select hcBankSlots from accounts where email=?";
		}
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $_SESSION['email']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($slots);
		while($stmt->fetch()){
			$totalBankSlots = $slots*1;
		}
		// check gold balance
		if($mode=='false'){
			$query = "select gold from accounts where email=?";
		}else{
			$query = "select hcgold from accounts where email=?";
		}
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $_SESSION['email']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($s);
		while($stmt->fetch()){
			$totalGold = $s*1;
		}
		$s = $totalGold."|".$totalBankSlots.'|';
		
		$query = "select abjuration, absorbCold, absorbFire, absorbLightning, absorbMagic, absorbPoison, agi, allResist, allSkills, allStats, alteration, armor, attack, castingHaste, cha, channeling, cold, coldDamage, conjuration, critChance, critDamage, damage, defense, delay, dex, dodge, doubleAttack, dualWield, enhanceAll, enhanceCold, enhanceFire, enhanceLightning, enhanceMagic, enhancePhysical, enhancePoison, enhancedArmor, enhancedDamage, evocation, expFind, fear, fireDamage, flavorText, globalHaste, goldFind, handtohand, haste, hp, hpKill, hpRegen, ias, intel, itemSlot, leech, lightRadius, lightningDamage, magMit, magicDamage, mp, mpKill, mpRegen, name, offense, oneHandBlunt, oneHandSlash, parry, phyMit, physicalDamage, piercing, poisonDamage, proc, quality, rarity, req, resistCold, resistFire, resistLightning, resistMagic, resistPoison, riposte, runSpeed, silence, sta, str, stun, thorns, twoHandBlunt, twoHandSlash, type, upgrade, weight, wis, wraith, xPos, yPos from item where email='".$_SESSION['email']."' and hardcoreMode='".$_SESSION['hardcoreMode']."' and season=".$_SESSION['season']." and slotType='bank' order by slot limit ".$totalBankSlots;
		$stmt = $link->prepare($query);
		$stmt->bind_result($abjuration, $absorbCold, $absorbFire, $absorbLightning, $absorbMagic, 
		$absorbPoison, $agi, $allResist, $allSkills, $allStats, 
		$alteration, $armor, $attack, $castingHaste, $cha, 
		$channeling, $cold, $coldDamage, $conjuration, $critChance, 
		$critDamage, $damage, $defense, $delay, $dex, 
		$dodge, $doubleAttack, $dualWield, $enhanceAll, $enhanceCold, 
		$enhanceFire, $enhanceLightning, $enhanceMagic, $enhancePhysical, $enhancePoison, 
		$enhancedArmor, $enhancedDamage, $evocation, $expFind, $fear, 
		$fireDamage, $flavorText, $globalHaste, $goldFind, $handtohand, 
		$haste, $hp, $hpKill, $hpRegen, $ias, 
		$intel, $itemSlot, $leech, $lightRadius, $lightningDamage, 
		$magMit, $magicDamage, $mp, $mpKill, $mpRegen, 
		$name, $offense, $oneHandBlunt, $oneHandSlash, $parry, 
		$phyMit, $physicalDamage, $piercing, $poisonDamage, $proc, 
		$quality, $rarity, $req, $resistCold, $resistFire, 
		$resistLightning, $resistMagic, $resistPoison, $riposte, $runSpeed, 
		$silence, $sta, $str, $stun, $thorns, 
		$twoHandBlunt, $twoHandSlash, $type, $upgrade, $weight, 
		$wis, $wraith, $xPos, $yPos);
		$stmt->execute();
		while($stmt->fetch()){
			$s.= $abjuration."|";
			$s.= $absorbCold."|";
			$s.= $absorbFire."|";
			$s.= $absorbLightning."|";
			$s.= $absorbMagic."|";
			$s.= $absorbPoison."|";
			$s.= $agi."|";
			$s.= $allResist."|";
			$s.= $allSkills."|";
			$s.= $allStats."|";
			$s.= $alteration."|";
			$s.= $armor."|";
			$s.= $attack."|";
			$s.= $castingHaste."|";
			$s.= $cha."|";
			$s.= $channeling."|";
			$s.= $cold."|";
			$s.= $coldDamage."|";
			$s.= $conjuration."|";
			$s.= $critChance."|";
			$s.= $critDamage."|";
			$s.= $damage."|";
			$s.= $defense."|";
			$s.= $delay."|";
			$s.= $dex."|";
			$s.= $dodge."|";
			$s.= $doubleAttack."|";
			$s.= $dualWield."|";
			$s.= $enhanceAll."|";
			$s.= $enhanceCold."|";
			$s.= $enhanceFire."|";
			$s.= $enhanceLightning."|";
			$s.= $enhanceMagic."|";
			$s.= $enhancePhysical."|";
			$s.= $enhancePoison."|";
			$s.= $enhancedArmor."|";
			$s.= $enhancedDamage."|";
			$s.= $evocation."|";
			$s.= $expFind."|";
			$s.= $fear."|";
			$s.= $fireDamage."|";
			$s.= $flavorText."|";
			$s.= $globalHaste."|";
			$s.= $goldFind."|";
			$s.= $handtohand."|";
			$s.= $haste."|";
			$s.= $hp."|";
			$s.= $hpKill."|";
			$s.= $hpRegen."|";
			$s.= $ias."|";
			$s.= $intel."|";
			$s.= $itemSlot."|";
			$s.= $leech."|";
			$s.= $lightRadius."|";
			$s.= $lightningDamage."|";
			$s.= $magMit."|";
			$s.= $magicDamage."|";
			$s.= $mp."|";
			$s.= $mpKill."|";
			$s.= $mpRegen."|";
			$s.= $name."|";
			$s.= $offense."|";
			$s.= $oneHandBlunt."|";
			$s.= $oneHandSlash."|";
			$s.= $parry."|";
			$s.= $phyMit."|";
			$s.= $physicalDamage."|";
			$s.= $piercing."|";
			$s.= $poisonDamage."|";
			$s.= $proc."|";
			$s.= $quality."|";
			$s.= $rarity."|";
			$s.= $req."|";
			$s.= $resistCold."|";
			$s.= $resistFire."|";
			$s.= $resistLightning."|";
			$s.= $resistMagic."|";
			$s.= $resistPoison."|";
			$s.= $riposte."|";
			$s.= $runSpeed."|";
			$s.= $silence."|";
			$s.= $sta."|";
			$s.= $str."|";
			$s.= $stun."|";
			$s.= $thorns."|";
			$s.= $twoHandBlunt."|";
			$s.= $twoHandSlash."|";
			$s.= $type."|";
			$s.= $upgrade."|";
			$s.= $weight."|";
			$s.= $wis."|";
			$s.= $wraith."|";
			$s.= $xPos."|";
			$s.= $yPos."|";
		}
		echo $s;
	}
	function loadEq(){
		global $link;
		// Nevergrounds uses this - use $ng to avoid use of $_SESSION!
		$query = "select abjuration, absorbCold, absorbFire, absorbLightning, absorbMagic, absorbPoison, agi, allResist, allSkills, allStats, alteration, armor, attack, castingHaste, cha, channeling, cold, coldDamage, conjuration, critChance, critDamage, damage, defense, delay, dex, dodge, doubleAttack, dualWield, enhanceAll, enhanceCold, enhanceFire, enhanceLightning, enhanceMagic, enhancePhysical, enhancePoison, enhancedArmor, enhancedDamage, evocation, expFind, fear, fireDamage, flavorText, globalHaste, goldFind, handtohand, haste, hp, hpKill, hpRegen, ias, intel, itemSlot, leech, lightRadius, lightningDamage, magMit, magicDamage, mp, mpKill, mpRegen, name, offense, oneHandBlunt, oneHandSlash, parry, phyMit, physicalDamage, piercing, poisonDamage, proc, quality, rarity, req, resistCold, resistFire, resistLightning, resistMagic, resistPoison, riposte, runSpeed, silence, sta, str, stun, thorns, twoHandBlunt, twoHandSlash, type, upgrade, weight, wis, wraith, xPos, yPos from item where characterName=? and slotType='eq' order by slot limit 15";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $_POST['name']);
		$stmt->execute();
		$stmt->bind_result($abjuration, $absorbCold, $absorbFire, $absorbLightning, $absorbMagic, 
		$absorbPoison, $agi, $allResist, $allSkills, $allStats, 
		$alteration, $armor, $attack, $castingHaste, $cha, 
		$channeling, $cold, $coldDamage, $conjuration, $critChance, 
		$critDamage, $damage, $defense, $delay, $dex, 
		$dodge, $doubleAttack, $dualWield, $enhanceAll, $enhanceCold, 
		$enhanceFire, $enhanceLightning, $enhanceMagic, $enhancePhysical, $enhancePoison, 
		$enhancedArmor, $enhancedDamage, $evocation, $expFind, $fear, 
		$fireDamage, $flavorText, $globalHaste, $goldFind, $handtohand, 
		$haste, $hp, $hpKill, $hpRegen, $ias, 
		$intel, $itemSlot, $leech, $lightRadius, $lightningDamage, 
		$magMit, $magicDamage, $mp, $mpKill, $mpRegen, 
		$name, $offense, $oneHandBlunt, $oneHandSlash, $parry, 
		$phyMit, $physicalDamage, $piercing, $poisonDamage, $proc, 
		$quality, $rarity, $req, $resistCold, $resistFire, 
		$resistLightning, $resistMagic, $resistPoison, $riposte, $runSpeed, 
		$silence, $sta, $str, $stun, $thorns, 
		$twoHandBlunt, $twoHandSlash, $type, $upgrade, $weight, 
		$wis, $wraith, $xPos, $yPos);
		$s = '';
		while($stmt->fetch()){
			$s.= $abjuration."|";
			$s.= $absorbCold."|";
			$s.= $absorbFire."|";
			$s.= $absorbLightning."|";
			$s.= $absorbMagic."|";
			$s.= $absorbPoison."|";
			$s.= $agi."|";
			$s.= $allResist."|";
			$s.= $allSkills."|";
			$s.= $allStats."|";
			$s.= $alteration."|";
			$s.= $armor."|";
			$s.= $attack."|";
			$s.= $castingHaste."|";
			$s.= $cha."|";
			$s.= $channeling."|";
			$s.= $cold."|";
			$s.= $coldDamage."|";
			$s.= $conjuration."|";
			$s.= $critChance."|";
			$s.= $critDamage."|";
			$s.= $damage."|";
			$s.= $defense."|";
			$s.= $delay."|";
			$s.= $dex."|";
			$s.= $dodge."|";
			$s.= $doubleAttack."|";
			$s.= $dualWield."|";
			$s.= $enhanceAll."|";
			$s.= $enhanceCold."|";
			$s.= $enhanceFire."|";
			$s.= $enhanceLightning."|";
			$s.= $enhanceMagic."|";
			$s.= $enhancePhysical."|";
			$s.= $enhancePoison."|";
			$s.= $enhancedArmor."|";
			$s.= $enhancedDamage."|";
			$s.= $evocation."|";
			$s.= $expFind."|";
			$s.= $fear."|";
			$s.= $fireDamage."|";
			$s.= $flavorText."|";
			$s.= $globalHaste."|";
			$s.= $goldFind."|";
			$s.= $handtohand."|";
			$s.= $haste."|";
			$s.= $hp."|";
			$s.= $hpKill."|";
			$s.= $hpRegen."|";
			$s.= $ias."|";
			$s.= $intel."|";
			$s.= $itemSlot."|";
			$s.= $leech."|";
			$s.= $lightRadius."|";
			$s.= $lightningDamage."|";
			$s.= $magMit."|";
			$s.= $magicDamage."|";
			$s.= $mp."|";
			$s.= $mpKill."|";
			$s.= $mpRegen."|";
			$s.= $name."|";
			$s.= $offense."|";
			$s.= $oneHandBlunt."|";
			$s.= $oneHandSlash."|";
			$s.= $parry."|";
			$s.= $phyMit."|";
			$s.= $physicalDamage."|";
			$s.= $piercing."|";
			$s.= $poisonDamage."|";
			$s.= $proc."|";
			$s.= $quality."|";
			$s.= $rarity."|";
			$s.= $req."|";
			$s.= $resistCold."|";
			$s.= $resistFire."|";
			$s.= $resistLightning."|";
			$s.= $resistMagic."|";
			$s.= $resistPoison."|";
			$s.= $riposte."|";
			$s.= $runSpeed."|";
			$s.= $silence."|";
			$s.= $sta."|";
			$s.= $str."|";
			$s.= $stun."|";
			$s.= $thorns."|";
			$s.= $twoHandBlunt."|";
			$s.= $twoHandSlash."|";
			$s.= $type."|";
			$s.= $upgrade."|";
			$s.= $weight."|";
			$s.= $wis."|";
			$s.= $wraith."|";
			$s.= $xPos."|";
			$s.= $yPos."|";
		}
		echo $s;
	}
	function loadQ(){
		global $link;
		$diff = $_POST['diff']*1;
		$name = $_POST['name'];
		if(strlen($_POST['name'])<1 && is_string($_POST['name'])){
			echo '';
			exit;
		}
		$query = "select bb1, bb2, bb3, bb4, befallen, bf1, bf2, bf3, bf4, blackburrow, castleMistmoore, cazicThule, cb1, cb2, cb3, cb4, cb5, cm1, cm2, cm3, cm4, cm5, cm6, crushbone, ct1, ct2, ct3, ct4, ct5, er1, er2, er3, er4, er5, estateOfUnrest, gf1, greaterFaydark, kedgeKeep, kk1, kk2, kk3, kk4, kk5, kk6, kk7, kk8, lesserFaydark, lf1, lf2, lg1, lg2, lg3, lg4, lg5, lg6, lowerGuk, nagafensLair, najena, nj1, nj2, nj3, nj4, nj5, nl1, nl2, nl3, nl4, nl5, nl6, nl7, nl8, nl9, nl10, nl11, nl12, northRo, nr1, nr2, permafrostKeep, pf1, pf2, pf3, pf4, pf5, pf6, pf7, pf8, pf9, pf10, pf11, pf12, pf13, pf14, pf15, pf16, pf17, pf18, pf19, pf20, pf21, pf22, ph1, ph2, ph3, ph4, ph5, ph6, ph7, ph8, ph9, ph10, ph11, ph12, ph13, pk1, pk2, pk3, pk4, pk5, pk6, pk7, pk8, pk9, planeOfFear, planeOfHate, repeatCB, repeatCm3, repeatCt3, repeatER, repeatKk3, repeatKk4, repeatLg3, repeatNl3, repeatNl4, repeatPk4, ug1, ug2, ug3, ug4, upperGuk from quests 
			where email='".$_SESSION['email']."' and season=".$_SESSION['season']." and name=? 
			order by difficulty";
		$stmt = $link->prepare($query);
		$stmt->bind_param('s', $name);
		$stmt->execute();
		$stmt->bind_result($bb1, $bb2, $bb3, $bb4, $befallen, 
		$bf1, $bf2, $bf3, $bf4, $blackburrow, 
		$castleMistmoore, $cazicThule, $cb1, $cb2, $cb3, 
		$cb4, $cb5, $cm1, $cm2, $cm3, 
		$cm4, $cm5, $cm6, $crushbone, $ct1, 
		$ct2, $ct3, $ct4, $ct5, $er1, 
		$er2, $er3, $er4, $er5, $estateOfUnrest, 
		$gf1, $greaterFaydark, $kedgeKeep, $kk1, $kk2, 
		$kk3, $kk4, $kk5, $kk6, $kk7, 
		$kk8, $lesserFaydark, $lf1, $lf2, $lg1, 
		$lg2, $lg3, $lg4, $lg5, $lg6, 
		$lowerGuk, $nagafensLair, $najena, $nj1, $nj2, 
		$nj3, $nj4, $nj5, $nl1, $nl2, 
		$nl3, $nl4, $nl5, $nl6, $nl7, 
		$nl8, $nl9, $nl10, $nl11, $nl12, 
		$northRo, $nr1, $nr2, $permafrostKeep, $pf1, 
		$pf2, $pf3, $pf4, $pf5, $pf6, 
		$pf7, $pf8, $pf9, $pf10, $pf11, 
		$pf12, $pf13, $pf14, $pf15, $pf16,
		$pf17, $pf18, $pf19, $pf20, $pf21,
		$pf22, $ph1, $ph2, $ph3, $ph4,
		$ph5, $ph6, $ph7, $ph8, $ph9,
		$ph10, $ph11, $ph12, $ph13, $pk1,
		$pk2, $pk3, $pk4, $pk5, $pk6,
		$pk7, $pk8, $pk9, $planeOfFear, $planeOfHate,
		$repeatCB, $repeatCm3, $repeatCt3, $repeatER, $repeatKk3,
		$repeatKk4, $repeatLg3, $repeatNl3, $repeatNl4, $repeatPk4,
		$ug1, $ug2, $ug3, $ug4, $upperGuk);
		$s = '';
		while($stmt->fetch()){
			$s.= $bb1."|";
			$s.= $bb2."|";
			$s.= $bb3."|";
			$s.= $bb4."|";
			$s.= $befallen."|";
			$s.= $bf1."|";
			$s.= $bf2."|";
			$s.= $bf3."|";
			$s.= $bf4."|";
			$s.= $blackburrow."|";
			$s.= $castleMistmoore."|";
			$s.= $cazicThule."|";
			$s.= $cb1."|";
			$s.= $cb2."|";
			$s.= $cb3."|";
			$s.= $cb4."|";
			$s.= $cb5."|";
			$s.= $cm1."|";
			$s.= $cm2."|";
			$s.= $cm3."|";
			$s.= $cm4."|";
			$s.= $cm5."|";
			$s.= $cm6."|";
			$s.= $crushbone."|";
			$s.= $ct1."|";
			$s.= $ct2."|";
			$s.= $ct3."|";
			$s.= $ct4."|";
			$s.= $ct5."|";
			$s.= $er1."|";
			$s.= $er2."|";
			$s.= $er3."|";
			$s.= $er4."|";
			$s.= $er5."|";
			$s.= $estateOfUnrest."|";
			$s.= $gf1."|";
			$s.= $greaterFaydark."|";
			$s.= $kedgeKeep."|";
			$s.= $kk1."|";
			$s.= $kk2."|";
			$s.= $kk3."|";
			$s.= $kk4."|";
			$s.= $kk5."|";
			$s.= $kk6."|";
			$s.= $kk7."|";
			$s.= $kk8."|";
			$s.= $lesserFaydark."|";
			$s.= $lf1."|";
			$s.= $lf2."|";
			$s.= $lg1."|";
			$s.= $lg2."|";
			$s.= $lg3."|";
			$s.= $lg4."|";
			$s.= $lg5."|";
			$s.= $lg6."|";
			$s.= $lowerGuk."|";
			$s.= $nagafensLair."|";
			$s.= $najena."|";
			$s.= $nj1."|";
			$s.= $nj2."|";
			$s.= $nj3."|";
			$s.= $nj4."|";
			$s.= $nj5."|";
			$s.= $nl1."|";
			$s.= $nl2."|";
			$s.= $nl3."|";
			$s.= $nl4."|";
			$s.= $nl5."|";
			$s.= $nl6."|";
			$s.= $nl7."|";
			$s.= $nl8."|";
			$s.= $nl9."|";
			$s.= $nl10."|";
			$s.= $nl11."|";
			$s.= $nl12."|";
			$s.= $northRo."|";
			$s.= $nr1."|";
			$s.= $nr2."|";
			$s.= $permafrostKeep."|";
			$s.= $pf1."|";
			$s.= $pf2."|";
			$s.= $pf3."|";
			$s.= $pf4."|";
			$s.= $pf5."|";
			$s.= $pf6."|";
			$s.= $pf7."|";
			$s.= $pf8."|";
			$s.= $pf9."|";
			$s.= $pf10."|";
			$s.= $pf11."|";
			$s.= $pf12."|";
			$s.= $pf13."|";
			$s.= $pf14."|";
			$s.= $pf15."|";
			$s.= $pf16."|";
			$s.= $pf17."|";
			$s.= $pf18."|";
			$s.= $pf19."|";
			$s.= $pf20."|";
			$s.= $pf21."|";
			$s.= $pf22."|";
			$s.= $ph1."|";
			$s.= $ph2."|";
			$s.= $ph3."|";
			$s.= $ph4."|";
			$s.= $ph5."|";
			$s.= $ph6."|";
			$s.= $ph7."|";
			$s.= $ph8."|";
			$s.= $ph9."|";
			$s.= $ph10."|";
			$s.= $ph11."|";
			$s.= $ph12."|";
			$s.= $ph13."|";
			$s.= $pk1."|";
			$s.= $pk2."|";
			$s.= $pk3."|";
			$s.= $pk4."|";
			$s.= $pk5."|";
			$s.= $pk6."|";
			$s.= $pk7."|";
			$s.= $pk8."|";
			$s.= $pk9."|";
			$s.= $planeOfFear."|";
			$s.= $planeOfHate."|";
			$s.= $repeatCB."|";
			$s.= $repeatCm3."|";
			$s.= $repeatCt3."|";
			$s.= $repeatER."|";
			$s.= $repeatKk3."|";
			$s.= $repeatKk4."|";
			$s.= $repeatLg3."|";
			$s.= $repeatNl3."|";
			$s.= $repeatNl4."|";
			$s.= $repeatPk4."|";
			$s.= $ug1."|";
			$s.= $ug2."|";
			$s.= $ug3."|";
			$s.= $ug4."|";
			$s.= $upperGuk."|";
		}
		echo $s;
		// reset repeatable quests
		$query = "update quests set repeatCB=0, repeatCm3=0, repeatCt3=0, repeatER=0, repeatKk3=0, repeatKk4=0, repeatLg3=0, repeatNl3=0, repeatNl4=0, repeatPk4=0 where email=? and name=? and season=1 and difficulty=?;";
		$stmt = $link->prepare($query);
		$stmt->bind_param('ssi', $_SESSION['email'], $name, $diff);
		$stmt->execute();
	}
	call_user_func($_POST['run']);	
?>