<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>The Nevergrounds | Character Profiles, Items, and More</title>
	<meta charset="UTF-8">
	<meta name="keywords" content="browser, indie, rpg, game, player, profiles">
	<meta name="description" content="The Nevergrounds is where you can share character profiles and game data about Nevergrind.">
	<meta name="author" content="Joe Leonard">
	<meta name="referrer" content="always">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<meta name="viewport" content="width=1044,user-scalable=no">
	<meta name="twitter:widgets:csp" content="on">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="mobile-web-app-capable" content="yes">
	<link rel='stylesheet' type='text/css' href="css/style9.css">
	<link rel="shortcut icon" href="//nevergrind.com/images1/favicon.ico">
</head>

<body>
	<div id="wrap">
		<header>
			<h1 class='titleOutline'>
				<a href='//nevergrind.com/nevergrounds/'>The Nevergrounds</a>
			</h1>
			<a href="//nevergrind.com" title="Play Nevergrind">
				<img id="nevergrind" src="//d3t6yj0r8qins4.cloudfront.net/ng_logo_532x428.png" title="Nevergrind">
			</a>
			<nav id='menu'>
				<a class='links' href="//nevergrind.com" title="Play Nevergrind">Play Nevergrind</a>
				<a class='links' href="//nevergrind.com/leaderboards" title="Nevergrind Leaderboards">Leaderboards</a>
				<a class='links' href="//nevergrind.com/forums" title="Forums">Forums</a>
				<a class='links' href="//nevergrind.com/wiki" title="Nevergrind Wiki">Wiki</a>
				<a class='links' href="//nevergrind.com/blog" title="Nevergrind Blog">Blog</a>
			</nav>
		</header>
		<div id='main'>
			<div id='adHead'>
				<table width="100%"><tr><td valign="middle" align="center">
					<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Leaderboard 728x90 2 -->
<?php
	if(php_uname('n')!="JOE-PC"){
	echo '<ins class="adsbygoogle"
		 style="display:inline-block;width:728px;height:90px"
		 data-ad-client="ca-pub-8697751823759563"
		 data-ad-slot="3445329387"></ins>';
	}
?>
<script>
if(location.host!=='localhost'){
	(adsbygoogle = window.adsbygoogle || []).push({});
}
</script>
</td></tr></table>
</div>
<div class='content'>
	<div id="ttItem" class="strongShadow">
		<div id="ttItemName"></div>
		<div id="ttItemMsg"></div>
	</div>
	<div id='searchWrap'>
		<input type="search" maxlength="200" alt="Search for characters, items, and more" id="search" placeholder="Search for characters">
		<input type='submit' value id='searchButton'>
	</div>
	<div id="result">
		<?php
			if(php_uname('n')=="JOE-PC"){
				$link = mysqli_connect("localhost:3306","root","2M@elsw6","nevergrind");
			}else{
				$link = mysqli_connect("localhost", "nevergri_ng", "!M6a1e8l2f4y6n", "nevergri_ngLocal");
			}
			if (!$link) {
				die('Could not connect: ' . mysqli_error('Could not connect'));
			}
			function convertHC($str){
				if($str=='false'){
					return "Normal";
				}else{
					return "Hardcore";
				}
			}
			echo '<div id="characterWrap">';
			if(isset($_GET['search'])||
			isset($_GET['character'])||
			isset($_GET['item'])){
				// check that email does not exist
				$query = "select row from characters where name=?";
				$stmt = $link->prepare($query);
				$stmt->bind_param('s', $_GET['character']);
				$stmt->execute();
				$stmt->store_result();
				$count = $stmt->num_rows;
				if($count>0){
					$query = "select views from characters where name=?";
					$stmt = $link->prepare($query);
					$stmt->bind_param('s', $_GET['character']);
					$stmt->execute();
					$stmt->store_result();
					$stmt->bind_result($db_views);
					while($stmt->fetch()){
						$views = $db_views*1;
					}
					$views = $views + 1;
					
					$query = "update characters set views=$views where name=?";
					$stmt = $link->prepare($query);
					$stmt->bind_param('s', $_GET['character']);
					$stmt->execute();
					// render empty view with links to items
					$s = "<div id='profile-views'>Profile Views: 0</div>"
						."<div id='name'>&nbsp;</div>"
						."<div id='head-level'>&nbsp;</div>"
						."<div id='head-title'>&nbsp;</div>"
						."<div id='head-title'>&nbsp;</div>"
						."<div id='head-gender'>&nbsp;</div>".
						// column 1
						"<div class='stat-column'>".
							"<div class='stat-column-section'>".
								"<h4>General</h4>".
								"<ul>".
									"<li><span class='fields'>Health: </span><span class='data'>0 / 0 </span></li>".
									"<li><span class='fields'>Mana Points:</span><span class='data'>0 / 0</span></li>".
									"<li><span class='fields'>Experience: </span><span class='data'>0</span></li>".
								"</ul>".
							"</div>". // stat-column-section
				
				"<div class='stat-column-section'>".
					"<h4>Attributes</h4>".
					"<ul>".
						"<li><span class='fields'>Strength: </span><span class='data'>0</span></li>".
						"<li><span class='fields'>Stamina: </span><span class='data'>0</span></li>".
						"<li><span class='fields'>Agility: </span><span class='data'>0</span></li>".
						"<li><span class='fields'>Dexterity: </span><span class='data'>0</span></li>".
						"<li><span class='fields'>Wisdom: </span><span class='data'>0</span></li>".
						"<li><span class='fields'>Intelligence: </span><span class='data'>0</span></li>".
						"<li><span class='fields'>Charisma: </span><span class='data'>0</span></li>".
					"</ul>".
				"</div>". // stat-column-section
				
				"<div class='stat-column-section'>".
					"<h4>Offensive Statistics</h4>".
					"<ul>".
						"<li><span class='fields'>Hit Chance: </span><span class='data'>0%</span></li>".
						"<li><span class='fields'>Attack Haste: </span><span class='data'>0%</span></li>".
						"<li><span class='fields'>Skill Haste: </span><span class='data'>0%</span></li>".
						"<li><span class='fields'>Casting Haste:</span><span class='data'>0%</span></li>".
						"<li><span class='fields'>Critical Chance: </span><span class='data'>0%</span></li>".
						"<li><span class='fields'>Critical Damage: </span><span class='data'>0%</span></li>".
						"<li><span class='fields'>Thorns: </span><span class='data'>0</span></li>".
					"</ul>".
				"</div>". // stat-column-section
				
				"<div class='stat-column-section'>".
					"<h4>Enhanced Damage</h4>".
					"<ul>".
						"<li><span class='fields'>Physical: </span><span class='data'>0</span></li>".
						"<li><span class='fields'>Poison: </span><span class='data'>0</span></li>".
						"<li><span class='fields'>Arcane: </span><span class='data'>0</span></li>".
						"<li><span class='fields'>Lightning:</span><span class='data'>0</span></li>".
						"<li><span class='fields'>Cold: </span><span class='data'>0</span></li>".
						"<li><span class='fields'>Fire: </span><span class='data'>0</span></li>".
					"</ul>".
				"</div>". // stat-column-section
				
				"<div class='stat-column-section'>".
					"<h4>Resists</h4>".
					"<ul>".
						"<li><span class='fields'>Resist Poison: </span><span class='data'>0</span></li>".
						"<li><span class='fields'>Resist Arcane:</span><span class='data'>0</span></li>".
						"<li><span class='fields'>Resist Lightning: </span><span class='data'>0</span></li>".
						"<li><span class='fields'>Resist Cold: </span><span class='data'>0</span></li>".
						"<li><span class='fields'>Resist Fire: </span><span class='data'>0</span></li>".
					"</ul>".
				"</div>". // stat-column-section
				
				"<div class='stat-column-section'>".
					"<h4>Absorption:</h4>".
					"<ul>".
						"<li><span class='fields'>Poison: </span><span class='data'>0%</span></li>".
						"<li><span class='fields'>Arcane:</span><span class='data'>0%</span></li>".
						"<li><span class='fields'>Lightning: </span><span class='data'>0%</span></li>".
						"<li><span class='fields'>Cold: </span><span class='data'>0%</span></li>".
						"<li><span class='fields'>Fire: </span><span class='data'>0%</span></li>".
					"</ul>".
				"</div>". // stat-column-section
				
				"<div class='stat-column-section'>".
					"<h4>Conquests</h4>".
					"<ul>".
						"<li><span class='fields'>Play Time: </span><span class='data'>0 Days, 0 Hours</span></li>".
						"<li><span class='fields'>Kills: </span><span class='data'>0</span></li>".
						"<li><span class='fields'>Deaths: </span><span class='data'>0</span></li>".
						"<li><span class='fields'>Champion Kills:</span><span class='data'>0</span></li>".
						"<li><span class='fields'>Rare Kills: </span><span class='data'>0</span></li>".
						"<li><span class='fields'>Boss Kills: </span><span class='data'>0</span></li>".
						"<li><span class='fields'>Escapes: </span><span class='data'>0</span></li>".
						"<li><span class='fields'>Magic Items Found: </span><span class='data'>0</span></li>".
						"<li><span class='fields'>Rare Items Found: </span><span class='data'>0</span></li>".
						"<li><span class='fields'>Unique Items Found: </span><span class='data'>0</span></li>".
						"<li><span class='fields'>Set Items Found: </span><span class='data'>0</span></li>".
						"<li><span class='fields'>Best Combo Rating: </span><span class='data'>0</span></li>".
						"<li><span class='fields'>Quests Completed: </span><span class='data'>0</span></li>".
					"</ul>".
				"</div>"; // stat-column-section
				
				$query = "select race from characters where name=?";
				$stmt = $link->prepare($query);
				$stmt->bind_param('s', $_GET['character']);
				$stmt->execute();
				$stmt->bind_result($race);
				while($stmt->fetch()){
					$race = $race;
				}
				// get related characters
				$val = rand(0,64);
				$query = "select level, job, name from characters where race=? and name!=? order by RAND() desc limit {$val},18";
				$stmt = $link->prepare($query);
				$stmt->bind_param('ss', $race, $_GET['character']);
				$stmt->execute();
				$stmt->bind_result($level, $job, $name);
				$stmt->store_result();
				if($race==="High Elf"){
					$race = "High Elve";
				}
				if($race==="Half Elf"){
					$race = "Half Elve";
				}
				if($race==="Wood Elf"){
					$race = "Wood Elve";
				}
				$s.= "<div class='stat-column-section' id='related-characters'>".
					"<h4>Other {$race}s</h4>".
					"<ul>";
				while($stmt->fetch()){
					$urlName = urlencode($name);
					$s.= "<li><a href='//nevergrind.com/nevergrounds/?character={$urlName}'>{$level} {$job} - {$name}</a></li>";
				}
				$s.= "</ul>".
				"</div>"; // stat-column-section
				
				$s.= "</div>". // COLUMN 1
				
				"<div class='stat-column'>".
					"<div class='stat-column-section'>".
						"<h4>Skills</h4>".
						"<ul>".
							"<li><span class='fields'>One-hand Slashing: </span><span class='data'>0</span></li>".
							"<li><span class='fields'>Two-hand Slashing:</span><span class='data'>0</span></li>".
							"<li><span class='fields'>One-hand Blunt: </span><span class='data'>0</span></li>".
							"<li><span class='fields'>Two-hand Blunt: </span><span class='data'>0</span></li>".
							"<li><span class='fields'>Piercing: </span><span class='data'>0</span></li>".
							"<li><span class='fields'>Hand to Hand: </span><span class='data'>0</span></li>".
							"<li><span class='fields'>Offense: </span><span class='data'>0</span></li>".
							"<li><span class='fields'>Dual Wield: </span><span class='data'>0</span></li>".
							"<li><span class='fields'>Double Attack: </span><span class='data'>0</span></li>".
							"<li><span class='fields'>Defense: </span><span class='data'>0</span></li>".
							"<li><span class='fields'>Dodge: </span><span class='data'>0</span></li>".
							"<li><span class='fields'>Parry: </span><span class='data'>0</span></li>".
							"<li><span class='fields'>Riposte: </span><span class='data'>0</span></li>".
							"<li><span class='fields'>Alteration: </span><span class='data'>0</span></li>".
							"<li><span class='fields'>Evocation: </span><span class='data'>0</span></li>".
							"<li><span class='fields'>Conjuration: </span><span class='data'>0</span></li>".
							"<li><span class='fields'>Abjuration: </span><span class='data'>0</span></li>".
							"<li><span class='fields'>Channeling: </span><span class='data'>0</span></li>".
						"</ul>".
					"</div>". // stat-column-section
					
					"<div class='stat-column-section'>".
						"<h4>Swordsmanship</h4>".
						"<ul>".
							"<li><span class='fields'>Dual Wield Chance: </span><span class='data'>0%</span></li>".
							"<li><span class='fields'>Double Attack Chance: </span><span class='data'>0%</span></li>".
							"<li><span class='fields'>Parry Chance: </span><span class='data'>0%</span></li>".
							"<li><span class='fields'>Riposte Chance:</span><span class='data'>0%</span></li>".
						"</ul>".
					"</div>". // stat-column-section
					
					"<div class='stat-column-section'>".
						"<h4>Added Melee Damage</h4>".
						"<ul>".
							"<li><span class='fields'>Physical Damage: </span><span class='data'>0</span></li>".
							"<li><span class='fields'>Poison Damage: </span><span class='data'>0</span></li>".
							"<li><span class='fields'>Arcane Damage: </span><span class='data'>0</span></li>".
							"<li><span class='fields'>Lightning Damage:</span><span class='data'>0</span></li>".
							"<li><span class='fields'>Cold Damage: </span><span class='data'>0</span></li>".
							"<li><span class='fields'>Fire Damage: </span><span class='data'>0</span></li>".
						"</ul>".
					"</div>". // stat-column-section
					
					"<div class='stat-column-section'>".
						"<h4>Defensive Stats:</h4>".
						"<ul>".
							"<li><span class='fields'>Shield Block Chance: </span><span class='data'>0%</span></li>".
							"<li><span class='fields'>Dodge Chance: </span><span class='data'>0%</span></li>".
							"<li><span class='fields'>Physical Reduction:</span><span class='data'>0</span></li>".
							"<li><span class='fields'>Magical Reduction: </span><span class='data'>0</span></li>".
							"<li><span class='fields'>Life Leech Rating: </span><span class='data'>0</span></li>".
							"<li><span class='fields'>Mana Leech Rating: </span><span class='data'>0</span></li>".
							"<li><span class='fields'>Health Per Kill: </span><span class='data'>0</span></li>".
							"<li><span class='fields'>Mana Per Kill: </span><span class='data'>0</span></li>".
							"<li><span class='fields'>Health Regeneration: </span><span class='data'>0</span></li>".
							"<li><span class='fields'>Mana Regeneration: </span><span class='data'>0</span></li>".
							"<li><span class='fields'>Run Speed: </span><span class='data'>0%</span></li>".
							"<li><span class='fields'>Fear Reduction: </span><span class='data'>0%</span></li>".
							"<li><span class='fields'>Stun Reduction: </span><span class='data'>0%</span></li>".
							"<li><span class='fields'>Chill Reduction: </span><span class='data'>0%</span></li>".
							"<li><span class='fields'>Silence Reduction: </span><span class='data'>0%</span></li>".
						"</ul>".
					"</div>". // stat-column-section
					
					"<div class='stat-column-section'>".
						"<h4>Providence</h4>".
						"<ul>".
							"<li><span class='fields'>Gold Gain: </span><span class='data'>0%</span></li>".
							"<li><span class='fields'>Exp Gain: </span><span class='data'>0%</span></li>".
							"<li><span class='fields'>Magic Find: </span><span class='data'>0</span></li>".
						"</ul>".
					"</div>"; // stat-column-section
				
					$query = "select job from characters where name=?";
					$stmt = $link->prepare($query);
					$stmt->bind_param('s', $_GET['character']);
					$stmt->execute();
					$stmt->bind_result($job);
					while($stmt->fetch()){
						$job = $job;
					}
					// get related characters
					$val = rand(0,50);
					$query = "select level, race, name from characters where job=? and name!=? order by RAND() desc limit {$val},24";
					$stmt = $link->prepare($query);
					$stmt->bind_param('ss', $job, $_GET['character']);
					$stmt->execute();
					$stmt->bind_result($level, $race, $name);
					$stmt->store_result();
					$s.= "<div class='stat-column-section' id='related-jobs'>".
						"<h4>Other {$job}s</h4>".
						"<ul>";
					while($stmt->fetch()){
						$urlName = urlencode($name);
						$s.= "<li><a href='//nevergrind.com/nevergrounds/?character={$urlName}'>{$level} {$race} - {$name}</a></li>";
					}
					$s.= "</ul>".
					"</div>"; // stat-column-section
					
				$s.= "</div>"; // COLUMN 2 
				
				
				//load eq
				
				$query = "select name, xPos, yPos, rarity from item where characterName=? and slotType='eq' order by slot limit 15";
				$stmt = $link->prepare($query);
				$stmt->bind_param('s', $_GET['character']);
				$stmt->execute();
				$stmt->bind_result($name, $xPos, $yPos, $rarity);
				$P = new STDClass();
				$P->eq = array();
				$i = 0;
				while($stmt->fetch()){
					$P->eq[$i] = new STDClass();
					$P->eq[$i]->name = $name;
					$P->eq[$i]->xPos = $xPos;
					$P->eq[$i]->yPos = $yPos;
					$P->eq[$i]->rarity = $rarity;
					$i++;
				}
			
				function itemColor($Slot){
					global $P;
					$I = $P->eq[$Slot];
					$c = 'normal';
					if($I->rarity===1){
						$c = 'magical';
					}else if($I->rarity===2){
						$c = 'rare';
					}else if($I->rarity===3){
						$c = 'unique';
					}else if($I->rarity===4){
						$c = 'set';
					}else if($I->rarity===5){
						$c = 'legendary';
					}
					return $c;
				}
				// COLUMN 3
				$s.= "<div id='column3' class='stat-column'>".
					
					"<div class='stat-column-section'>".
						"<h4>Equipment</h4>".
						"<table id='equipTable'>";
							for($i=0;$i<=14;$i++){
								$s.= "<tr><td>".
										"<div class='itemImgBg'>";
											if($P->eq[$i]->rarity>=3){
												$z = $P->eq[$i]->name; 
												$z = str_replace(" ", "_", $z);
												$z = str_replace("'", "%27", $z);
												$s.= '<a title="'.$P->eq[$i]->name.'" alt="'.$P->eq[$i]->name.'" href="https://nevergrind.com/wiki/?title='.$z.'">';
											}
											$s.= "<img class='itemImg' src='../images1/item-ng.png' style='left:".$P->eq[$i]->xPos."px;top:".$P->eq[$i]->yPos."px'>";
											if($P->eq[$i]->rarity>=3){
												$s.= "</a>";
											}
										$s.= "</div>".
									"</td>".
									"<td class='data items ".itemColor($i)."'>";
										if($P->eq[$i]->name===''){
											if($i===12||$i===13){
												$s.= "Fists";
											}else{
												$s.= "Empty";
											}
										}else{
											$s.= $P->eq[$i]->name;
										}
										$s.= "<span class='valign'></span>".
									"</td></tr>";
							}
						$s.= "</table>".
					"</div>". // stat-column-section
					
					"<div class='stat-column-section'>".
						"<h4>Talents</h4>".
						
						
						"<table id='talentTable'>";
							for($i=1;$i<=12;$i++){
								$s.= "<tr><td class='talentWrap'>".
										"<div class='talentImgBg'></div>".
										"<div class='talentNum strongShadow'></div>".
									"</td>".
									"<td class='talent'></td></tr>";
							}
						$s.= "</table>".
					"</div>". // stat-column-section
					
					"</div>". // COLUMN 3 
			
					"<div class='clearLeft'></div>".
					
					"</div>"; // end characterWrap
					echo $s; 
				}
			}else{
				// DEFAULT VIEW
				$host = 'https://nevergrind.com/';
				if(php_uname('n')=="JOE-PC"){
					$host = 'https://localhost/ng/';
				}
				$query = "SELECT title, name, lastName, level, exp, job, race, hardcoreMode from characters ORDER BY exp DESC, row asc LIMIT 500";

				$result = mysqli_query($link, $query);
				echo "<table id='result-table'>";
				echo "<th>Rank</th><th>Name</th><th>Level</th><th>Experience</th><th>Class</th><th>Race</th><th>Mode</th>";
				$count = 1;
				while($row = mysqli_fetch_assoc($result)){
					echo "<tr>";
					echo "<td>$count</td>";
					echo "<td><a href='".$host."nevergrounds/index.php?character=".urlencode($row["name"])."'>".$row['title']." ".$row['name']." ".$row['lastName']."</a></td>";
					echo "<td>".$row['level']."</td>";
					echo "<td>".$row['exp']."</td>";
					echo "<td>".$row['job']."</td>";
					echo "<td>".$row['race']."</td>";
					echo "<td>".convertHC($row['hardcoreMode'])."</td>";
					echo "</tr>";
					$count++;
				}
				echo "</table>";
				echo "</div>";
			}
		?>
	</div>
</div>
<footer>
	<table width="100%"><tr><td valign="middle" align="center">
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Leaderboard 728x90 2 -->
<?php
	if(php_uname('n')!="JOE-PC"){
	echo '<ins class="adsbygoogle"
		 style="display:inline-block;width:728px;height:90px"
		 data-ad-client="ca-pub-8697751823759563"
		 data-ad-slot="3445329387"></ins>';
	}
?>
<script>
if(location.host!=='localhost'){
	(adsbygoogle = window.adsbygoogle || []).push({});
}
</script>
				</td></tr></table>
			</footer>
			<img class='hide' src="//d3t6yj0r8qins4.cloudfront.net/classPlate.png">
		</div>
	</div>
			
	<script src="//cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
	<script>
		g = {};
		P = {};
		P.eq = [];
	</script>
	<script src="../scripts/functions4.js"></script>
	<script src="scripts/nevergrounds19.js"></script>
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