<!DOCTYPE html>
<html lang="en">
<head>
	<title>Nevergrind Leaderboards | Hardcore Mode</title>
	<meta name="keywords" content="html5, indie, online, browser, free, game, rpg">
	<meta name="description" content="The Nevergrind leaderboards shows this season's leaders in experience and combos.">
	<meta name="viewport" content="width=1280,user-scalable=no">
	<link rel='stylesheet' type='text/css' href="../css/style4.css">
	<?php
		include($_SERVER['DOCUMENT_ROOT'] . "/includes/head.html");
	?>
</head>

<body>
	<div id="leaderboards" class="strongShadow">
		<div id="leaderboardHeader">
			<center>
			<!-- Leaderboard 728x90 2 -->
			<?php
			$hardcoreMode = (!strpos(strtolower($_SERVER['REQUEST_URI']), 'hardcore'));
			$hardcoreURL = '';
			if($hardcoreMode===false){
				$hardcoreMode = 'true';
				$hardcoreURL = "hardcore/";
			}else{
				$hardcoreMode = 'false';
			}
			if(php_uname('n')!="JOE-PC"){
				echo '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>';
				echo '<ins class="adsbygoogle"
				 style="display:inline-block;width:728px;height:90px"
				 data-ad-client="ca-pub-8697751823759563"
				 data-ad-slot="3445329387"></ins>';
				echo '<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
				</script>';
			}
			?>
			</center>
			<div id="leaderboardTitle">
				<h1>Nevergrind Leaderboards</h1>
				<h2>Season 1 | Hardcore Mode</h2>
				<nav class="links">
					<a href="https://nevergrind.com/" title="Play Nevergrind">Play</a>&nbsp;| 
					<a href="https://nevergrind.com/forums" title="Forums">Forums</a>&nbsp;| 
					<a href="https://nevergrind.com/wiki" title="Wiki">Wiki</a>&nbsp;| 
					<a href="https://nevergrind.com/blog" title="Nevergrind Blog">Blog</a>
				</nav>
			</div>
			<?php
				
				if(!isset($_GET['board'])){
					$_GET['board'] = "exp";
				}
				if(!isset($_GET['class'])){
					$_GET['class'] = "overall";
				}
				function urlBoard(){
					$x = '';
					if(isset($_GET['board'])){
						$x = "?board={$_GET['board']}";
					}
					return $x;
				}
				function urlClass(){
					$x = '';
					if(isset($_GET['class'])){
						$x = "&class={$_GET['class']}";
					}
					return $x;
				}
				$url1 = urlBoard();
				$url3 = urlClass();
				$path = '/leaderboards/';
				
				if($_GET['board']==='exp'){
					echo "<a id='expFilter' class='modeFilterActive' href='{$path}{$hardcoreURL}?board=exp{$url3}'>EXP</a>";
					echo "<a id='comboFilter' class='modeFilterDisabled' href='{$path}{$hardcoreURL}?board=combos{$url3}'>COMBOS</a>";
				}else{
					echo "<a id='expFilter' class='modeFilterDisabled' href='{$path}{$hardcoreURL}?board=exp{$url3}'>EXP</a>";
					echo "<a id='comboFilter' class='modeFilterActive' href='{$path}{$hardcoreURL}?board=combos{$url3}'>COMBOS</a>";
				}
				 echo "<a id='normalFilter' class='modeFilterDisabled' href='{$path}{$url1}{$url3}'>NORMAL</a>";
				 echo "<a id='hardcoreFilter' class='modeFilterActive' href='{$path}{$hardcoreURL}{$url1}{$url3}'>HARDCORE</a>";
			?>
		</div>
		<nav id="leaderboardsClasses">
		<?php
		if($_GET['class']==='overall'){
			echo "<a id='overallJob' class='leaderClassActive classFilters' href='{$path}{$hardcoreURL}{$url1}&class=overall'>OVERALL</a>";
		}else{
			echo "<a id='overallJob' class='leaderClassDisabled classFilters' href='{$path}{$hardcoreURL}{$url1}&class=overall'>OVERALL</a>";
		}
		if($_GET['class']==='warrior'){
			echo "<a id='warriorJob' class='leaderClassActive classFilters' href='{$path}{$hardcoreURL}{$url1}&class=warrior'>WAR</a>";
		}else{
			echo "<a id='warriorJob' class='leaderClassDisabled classFilters' href='{$path}{$hardcoreURL}{$url1}&class=warrior'>WAR</a>";
		}
		if($_GET['class']==='monk'){
			echo "<a id='monkJob' class='leaderClassActive classFilters' href='{$path}{$hardcoreURL}{$url1}&class=monk'>MNK</a>";
		}else{
			echo "<a id='monkJob' class='leaderClassDisabled classFilters' href='{$path}{$hardcoreURL}{$url1}&class=monk'>MNK</a>";
		}
		if($_GET['class']==='rogue'){
			echo "<a id='rogueJob' class='leaderClassActive classFilters' href='{$path}{$hardcoreURL}{$url1}&class=rogue'>ROG</a>";
		}else{
			echo "<a id='rogueJob' class='leaderClassDisabled classFilters' href='{$path}{$hardcoreURL}{$url1}&class=rogue'>ROG</a>";
		}
		if($_GET['class']==='paladin'){
			echo "<a id='paladinJob' class='leaderClassActive classFilters' href='{$path}{$hardcoreURL}{$url1}&class=paladin'>PAL</a>";
		}else{
			echo "<a id='paladinJob' class='leaderClassDisabled classFilters' href='{$path}{$hardcoreURL}{$url1}&class=paladin'>PAL</a>";
		}
		if($_GET['class']==='shadow knight'){
			echo "<a id='shadowknightJob' class='leaderClassActive classFilters' href='{$path}{$hardcoreURL}{$url1}&class=shadow knight'>SK</a>";
		}else{
			echo "<a id='shadowknightJob' class='leaderClassDisabled classFilters' href='{$path}{$hardcoreURL}{$url1}&class=shadow knight'>SK</a>";
		}
		if($_GET['class']==='ranger'){
			echo "<a id='rangerJob' class='leaderClassActive classFilters' href='{$path}{$hardcoreURL}{$url1}&class=ranger'>RNG</a>";
		}else{
			echo "<a id='rangerJob' class='leaderClassDisabled classFilters' href='{$path}{$hardcoreURL}{$url1}&class=ranger'>RNG</a>";
		}
		if($_GET['class']==='bard'){
			echo "<a id='bardJob' class='leaderClassActive classFilters' href='{$path}{$hardcoreURL}{$url1}&class=bard'>BRD</a>";
		}else{
			echo "<a id='bardJob' class='leaderClassDisabled classFilters' href='{$path}{$hardcoreURL}{$url1}&class=bard'>BRD</a>";
		}
		if($_GET['class']==='druid'){
			echo "<a id='druidJob' class='leaderClassActive classFilters' href='{$path}{$hardcoreURL}{$url1}&class=druid'>DRU</a>";
		}else{
			echo "<a id='druidJob' class='leaderClassDisabled classFilters' href='{$path}{$hardcoreURL}{$url1}&class=druid'>DRU</a>";
		}
		if($_GET['class']==='cleric'){
			echo "<a id='clericJob' class='leaderClassActive classFilters' href='{$path}{$hardcoreURL}{$url1}&class=cleric'>CLR</a>";
		}else{
			echo "<a id='clericJob' class='leaderClassDisabled classFilters' href='{$path}{$hardcoreURL}{$url1}&class=cleric'>CLR</a>";
		}
		if($_GET['class']==='shaman'){
			echo "<a id='shamanJob' class='leaderClassActive classFilters' href='{$path}{$hardcoreURL}{$url1}&class=shaman'>SHM</a>";
		}else{
			echo "<a id='shamanJob' class='leaderClassDisabled classFilters' href='{$path}{$hardcoreURL}{$url1}&class=shaman'>SHM</a>";
		}
		if($_GET['class']==='necromancer'){
			echo "<a id='necromancerJob' class='leaderClassActive classFilters' href='{$path}{$hardcoreURL}{$url1}&class=necromancer'>NEC</a>";
		}else{
			echo "<a id='necromancerJob' class='leaderClassDisabled classFilters' href='{$path}{$hardcoreURL}{$url1}&class=necromancer'>NEC</a>";
		}
		if($_GET['class']==='enchanter'){
			echo "<a id='enchanterJob' class='leaderClassActive classFilters' href='{$path}{$hardcoreURL}{$url1}&class=enchanter'>ENC</a>";
		}else{
			echo "<a id='enchanterJob' class='leaderClassDisabled classFilters' href='{$path}{$hardcoreURL}{$url1}&class=enchanter'>ENC</a>";
		}
		if($_GET['class']==='magician'){
			echo "<a id='magicianJob' class='leaderClassActive classFilters' href='{$path}{$hardcoreURL}{$url1}&class=magician'>MAG</a>";
		}else{
			echo "<a id='magicianJob' class='leaderClassDisabled classFilters' href='{$path}{$hardcoreURL}{$url1}&class=magician'>MAG</a>";
		}
		if($_GET['class']==='wizard'){
			echo "<a id='wizardJob' class='leaderClassActive classFilters' href='{$path}{$hardcoreURL}{$url1}&class=wizard'>WIZ</a>";
		}else{
			echo "<a id='wizardJob' class='leaderClassDisabled classFilters' href='{$path}{$hardcoreURL}{$url1}&class=wizard'>WIZ</a>";
		}
		?>
		</nav>
		<div id="leaderboardContainer">
			<table id="leaderboardResults" class="strongShadow">
			<?php
				require('../../php/connect_plain.php');
				$limit = 100;
				if($_GET['class']==='overall'){
					$limit = 300;
				}
				$mode = "true";
				$dbField = "exp";
				$dbHeader = "Experience";
				if($_GET['board']==='combos'){
					$dbField = "comboOverall";
					$dbHeader = "Rating";
				}
				if($_GET['class']==='overall'){
					$query = "select title, name, lastName, level, $dbField, job, race, deaths from characters where hardcoreMode=? order by $dbField desc, row asc limit ?";
					$stmt = $link->prepare($query);
					$stmt->bind_param('si', $hardcoreMode, $limit);
				}else{
					$query = "select title, name, lastName, level, $dbField, job, race, deaths from characters where hardcoreMode=? and job=? order by $dbField desc, row asc limit ?";
					$stmt = $link->prepare($query);
					$stmt->bind_param('ssi', $hardcoreMode, $_GET['class'], $limit);
				}
				$stmt->execute();
				$stmt->bind_result($title, $name, $lastName, $level, $score, $job, $race, $deaths);
				$s = "<tr>".
					"<th width='80px'>Rank</th>".
					"<th width='400px'>Name</th>".
					"<th width='120px'>Level</th>".
					"<th width='140px'>$dbHeader</th>".
					"<th width='180px'>Class</th>".
					"<th width='100px'>Race</th>".
				"</tr>";
				$row = 1;
				while($stmt->fetch()){
					if($deaths>0){
						$s .="<tr class='dead'><td>$row</td><td>";
					}else{
						$s .="<tr><td>$row</td><td>";
					}
					$s .="<a href='https://nevergrind.com/nevergrounds/index.php?character=".urlencode($name)."'>";
					$finalName = '';
					if($title!=''){
						$finalName = $title.' '.$name;
					}
					if($lastName!=''){
						$finalName .= ' '.$lastName;
					}
					$s .= "$title $name $lastName</a></td><td>$level</td><td>$score</td><td>$job</td><td>$race</td></tr>";
					$row++;
				}
				$s .= "<tr><td>&nbsp;</td></tr>";
				echo $s;
			?>
			</table>
		</div>
		<div id="leaderboardFooter">
			<center>
			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<!-- Leaderboard 728x90 2 -->
			<?php
			if(php_uname('n')!="JOE-PC"){
				echo '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>';
				echo '<ins class="adsbygoogle"
				 style="display:inline-block;width:728px;height:90px"
				 data-ad-client="ca-pub-8697751823759563"
				 data-ad-slot="3445329387"></ins>';
				echo '<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
				</script>';
			}
			?>
			</center>
		</div>
	</div>
	<script>
		if(location.hostname!=="localhost"){
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
			ga('create', 'UA-35167620-1', 'auto');
			ga('send', 'pageview');
		}
	</script>
</body>
</html>
