
	class Tile { 
		public $aMemberVar = 'aMemberVar Member Variable'; 
		public $aFuncName = 'aMemberFunc'; 
		
		
		function aMemberFunc() { 
			print 'Inside `aMemberFunc()`'; 
		} 
	} 

// flag code

		/*
		tl.to('#nationName', 1, {
			scrambleText: {
				text: nation.name,
				chars: "lowerCase",
				ease: Linear.easeNone
			}
		});
		*/

		TweenMax.fromTo("#nationFlag", 2, {
			rotationY: 35,
			transformPerspective: 400,
			skewY: 1,
			transformOrigin: "0% 50%"
		}, {
			rotationY: 0,
			skewY: -1,
			onComplete: function(){
				TweenMax.fromTo("#nationFlag", 2, {
					rotationY: 0,
				}, {
					rotationY: -1.5,
					ease: SlowMo.ease.config(0.7, 0.7, false),
					repeat: -1,
					yoyo: true
				});
				TweenMax.fromTo("#nationFlag", 3.33, {
					scale: 1,
				}, {
					scale: 1.02,
					ease: SlowMo.ease.config(0.7, 0.7, false),
					repeat: -1,
					yoyo: true
				});
				TweenMax.fromTo("#nationFlag", 7, {
					skewY: -1,
				}, {
					skewY: 1,
					ease: RoughEase.ease.config({ 
						template: Power0.easeNone, 
						strength: 1, 
						points: 20, 
						taper: "none", 
						randomize: true, 
						clamp: false
					}),
					repeat: -1,
					yoyo: true
				});
			}
		});


Warning: require(/includes/ga.php): failed to open stream: No such file or directory in C:\xampp\htdocs\games\firmament-wars\index.php on line 112

Fatal error: require(): Failed opening required '/includes/ga.php' (include_path='.;C:\xampp\php\PEAR') in C:\xampp\htdocs\games\firmament-wars\index.php on line 112

data = {
    framerate:20,
    images: ['/images1/spriteTest.png'],
    frames: {
        width:64,
        height:64
    },
    animations:{
        flash:{
            frames: [
                0,1,2,3,4,5,6,7,8,9
            ],
            speed:.1
        }
    }
};
spriteSheet = new createjs.SpriteSheet(data);
sprite = new createjs.Sprite(spriteSheet, 'flash');
stage.addChild(sprite);

sprite.gotoAndStop(8);
sprite.currentFrame;
		/*	canvas shit
	// cache (img, w, h) default image size
	var c1 = cache(color+"particle50");
	// in loop (e, stageNum, x, y, scaleX, scaleY)
		var e1 = cacheAdd(c1, 5, x, 0);
		or
		var e1 = cacheAdd(c1, 5, ranX, ranY, 1, 1, true);
		var e1 = cacheAdd(c1, 5, ranX, ranY, 1, 1, true, true); ADD TO FIRST INDEX
		
		(img, target, x, y, w, h, regCenter?)
		var e1 = can('redparticle50', 5, 0, 0, 25, 25);
		// position image with center on mob center then scale
		var e1 = can('redparticle50', 5, 0, 0, 25, 25, true);
		tricky: target must scale to end width difference
		
	
			,
			scaleX:0,
			scaleY:0,
			onComplete:function(){
				cRem(5, e1);
			}

			create shape/graphics:
			
		var s = new createjs.Shape();
		s.graphics.beginFill("#ffa")
		  .setStrokeStyle(1)
		  .beginStroke("#111")
		  .drawPolyStar(0, 0, 10, 5, .5, 0);
		stage[5].addChild(s);
		___________________________
		
		
		particleBurst(Slot, 'orange', 0, 50);
			
// create shape and cache
var s1 = new createjs.Shape();
s1.graphics.beginFill("#ff8");
    .setStrokeStyle(1)
    .drawPolyStar(0,0,25,5,.6,-90);
s1.cache(-25, -25, 50, 50);
var s2 = s1.cacheCanvas;

/*
	
	used apache, php 
	html -> apache
	graphic editing
	layout work
	schema work
	schema design
	
	
*/
/*
	
	
/* EASEL NOTES
	bmp[0].shadow = new createjs.Shadow("#ffff00", 0, 0, 5);
	tint: "#fff"
	tintAmount: 0 to 1
	exposure: underexposed to normal to overexposed 0 to 2
	brightness: under, normal, over 0 to 2

	saturation:0 to 255 B&W to crazy colors
	hue: 0 to 500??? valid values?
	contrast: 0 to 2? 1 normal. Goes up to ?
	colorize: ?
	colorizeAmount: ? 
*/
	
	cWin[0] = new createjs.Bitmap("/images1/redparticle50.png");
	cWin[0].image.onload = function(){
		cWin[0].setTransform(100, 300, 1, 1, 0, 0, 0, 12.5, 12.5);
		var b = cWin[0].getBounds();
		cWin[0].cache(b.x, b.y, b.width, b.height);
		stage[5].addChild(cWin[0])
	}
	
	bmp[2].image.src = "/images1/an imp.png";
	
	// x, y, scaleX, scaleY, rotation, skewX, skewY, regX, regY
	
	bmp[x] = new createjs.Bitmap("/images1/"+Mimg+".png");
	bmp[x].image.onload = function(){
	// image values
		var bounds = bmp[x].getBounds();
		var halfWidth = bmp[x].image.width/2;
		var halfHeight = bmp[x].image.height/2;
		var w2 = Mwidth/2;
		var h2 = mobHeight/2;
		bmp[x].setTransform(w2, h2, Xdiff, Xdiff, 0, 0, 0, halfWidth, halfHeight);
		
		// set cache 
		bmp[x].cache(bounds.x, bounds.y, bounds.width, bounds.height);
		// and add children
		stage[x].addChild(bmp[x]);
	}

*/


	//var bounds = e.getBounds();
	//e.cache(bounds.x, bounds.y, bounds.width, bounds.height);

		text[i] = new createjs.Text("", "24px Roboto", "#fff");
		text[i].textAlign = "center";
		text[i].shadow = new createjs.Shadow("#000", 1, 1, 0);
		stage[5].addChild(text[i]);
		
		/* tabled double login for now
		- Account already logged in??? status column? Heartbeat table?
		On window change, send a javascript variable to ensure it matches the current session js variable.

		
		Disallow php scripts if $_SESSION['email'] not set:
		return code to call run(), camp();

		On login set session variable using javascript variable
		$query = "select sessionid from accounts where email='".$_SESSION['email']."' limit 1";
		$result = $link->query($query);
		while($row = $result->fetch_assoc()){
			$a = $row['sessionid'];
		}
		if($a!=session_id()){
			echo "destroy";
			// if it doesn't match most recently logged in session, 
			// it will trash the most recent session
			session_destroy();
			session_id($a);
			session_start();
			$_SESSION = array();
			session_destroy();
			session_start();
			$_SESSION['email'] = $email;
			// update session_id
			$a = session_id();
		}
		$query = "update accounts set sessionid=? where email=?";
		$stmt = $link->prepare($query);
		$stmt->bind_param('ss', $a, $_SESSION['email']);
		$stmt->execute();
		*/

(function(){
  var selector = '';
  function f(a, b){
    // selector function
    if(a){
      selector = document.getElementById(a);
    }
    return this;
  }
  f.prototype.add = function(a, b){
    return a+b;
  }
  f.prototype.add = function(a, b){
    return a+b;
  }
  f.prototype.text = function(a, b){
    selector.textContent = a;
    return this;
  }
  function g(a, b){
    return new f(a, b);
  };
  g.firstName = "Bob";
  g.strength = 85;
  g.dexterity = 103;
  g.attackPower = function(){
    var atk = this.strength;
    atk += ~~(this.dexterity/2);
    return atk;
  };
  window.g = g;
})();
		/*
		if($stmt = mysqli_prepare($link, $query)){
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $stmtSalt, $stmtPassword, $stmtStatus);
			if(mysqli_stmt_fetch($stmt)){
				$dbSalt = $stmtSalt;
				$dbPassword = $stmtPassword;
				$dbStatus = $stmtStatus;
			}
		}
		*/

<script type="text/javascript">
	//window.jQuery.ui || document.write('<script type="text/javascript" src="//www.nevergrind.com/scripts/jquery-ui-1.10.0.custom.min.js"><\/script>')
</script>
	/* glowing orbs on mob hands
	var x8 = x1+12;
	var y8 = y1+12;
	var wor=D.createElement('img');
	wor.style.position='absolute';
	wor.style.width='0px';
	wor.style.height='0px';
	wor.style.left=x8+'px';
	wor.style.top=y8+'px';
	wor.src="/images1/whiteLight3.png";
	NG.eWin.appendChild(wor);
	TweenMax.to(wor, .1, {
		width:70,
		height:70,
		left:x8-35,
		top:y8-35
	});
	function clearLeft(Slot){
		if(mob[Slot].castingStatus===true){
			setTimeout(function(){
				clearLeft(Slot);
			},100);
		}else{
			TweenMax.to(wor, .1, {
				width:0,
				height:0,
				left:x8,
				top:y8
			});
		}
	}
	clearLeft(Slot);
	var x9 = x2+12;
	var y9 = y2+12;
	var wor2=D.createElement('img');
	wor2.style.position='absolute';
	wor2.style.width='0px';
	wor2.style.height='0px';
	wor2.style.left=x9+'px';
	wor2.style.top=y9+'px';
	wor2.src="/images1/whiteLight3.png";
	NG.eWin.appendChild(wor2);
	TweenMax.to(wor2, .1, {
		width:70,
		height:70,
		left:x9-35,
		top:y9-35
	});
	function clearRight(Slot){
		if(mob[Slot].castingStatus===true){
			setTimeout(function(){
				clearRight(Slot);
			},100);
		}else{
			TweenMax.to(wor2, .1, {
				width:0,
				height:0,
				left:x9,
				top:y9
			});
		}
	}
	clearRight(Slot);
	*/
	
	
			<!--
			<div id="mapUnits" class="shadow4">
				<div style='left: 481px; top:298px' class='unit' id='unit0'>0</div>
				<div style='left: 1339px; top:380px' class='unit' id='unit1'>0</div>
				<div style='left: 1071px; top:688px' class='unit' id='unit2'>0</div>
				<div style='left: 1089px; top:590px' class='unit' id='unit3'>0</div>
				<div style='left: 1084px; top:298px' class='unit' id='unit4'>0</div>
				<div style='left: 1291px; top:441px' class='unit' id='unit5'>0</div>
				<div style='left: 622px; top:864px' class='unit' id='unit6'>0</div>
				<div style='left: 631px; top:768px' class='unit' id='unit7'>0</div>
				<div style='left: 1157px; top:330px' class='unit' id='unit8'>0</div>
				<div style='left: 1735px; top:776px' class='unit' id='unit9'>0</div>
				<div style='left: 1637px; top:759px' class='unit' id='unit10'>0</div>
				<div style='left: 1682px; top:713px' class='unit' id='unit11'>0</div>
				<div style='left: 1756px; top:720px' class='unit' id='unit12'>0</div>
				<div style='left: 1024px; top:256px' class='unit' id='unit13'>0</div>
				<div style='left: 1266px; top:373px' class='unit' id='unit14'>0</div>
				<div style='left: 1175px; top:606px' class='unit' id='unit15'>0</div>
				<div style='left: 989px; top:284px' class='unit' id='unit16'>0</div>
				<div style='left: 1034px; top:301px' class='unit' id='unit17'>0</div>
				<div style='left: 944px; top:511px' class='unit' id='unit18'>0</div>
				<div style='left: 1405px; top:475px' class='unit' id='unit19'>0</div>
				<div style='left: 1425px; top:420px' class='unit' id='unit20'>0</div>
				<div style='left: 541px; top:240px' class='unit' id='unit21'>0</div>
				<div style='left: 1101px; top:237px' class='unit' id='unit22'>0</div>
				<div style='left: 471px; top:474px' class='unit' id='unit23'>0</div>
				<div style='left: 625px; top:690px' class='unit' id='unit24'>0</div>
				<div style='left: 740px; top:649px' class='unit' id='unit25'>0</div>
				<div style='left: 697px; top:716px' class='unit' id='unit26'>0</div>
				<div style='left: 655px; top:602px' class='unit' id='unit27'>0</div>
				<div style='left: 1411px; top:325px' class='unit' id='unit28'>0</div>
				<div style='left: 1144px; top:691px' class='unit' id='unit29'>0</div>
				<div style='left: 1115px; top:766px' class='unit' id='unit30'>0</div>
				<div style='left: 1119px; top:500px' class='unit' id='unit31'>0</div>
				<div style='left: 648px; top:232px' class='unit' id='unit32'>0</div>
				<div style='left: 429px; top:234px' class='unit' id='unit33'>0</div>
				<div style='left: 551px; top:170px' class='unit' id='unit34'>0</div>
				<div style='left: 416px; top:175px' class='unit' id='unit35'>0</div>
				<div style='left: 1579px; top:397px' class='unit' id='unit36'>0</div>
				<div style='left: 1482px; top:354px' class='unit' id='unit37'>0</div>
				<div style='left: 1599px; top:305px' class='unit' id='unit38'>0</div>
				<div style='left: 584px; top:541px' class='unit' id='unit39'>0</div>
				<div style='left: 583px; top:460px' class='unit' id='unit40'>0</div>
				<div style='left: 1067px; top:255px' class='unit' id='unit41'>0</div>
				<div style='left: 1210px; top:532px' class='unit' id='unit42'>0</div>
				<div style='left: 996px; top:392px' class='unit' id='unit43'>0</div>
				<div style='left: 559px; top:629px' class='unit' id='unit44'>0</div>
				<div style='left: 1139px; top:408px' class='unit' id='unit45'>0</div>
				<div style='left: 1038px; top:193px' class='unit' id='unit46'>0</div>
				<div style='left: 968px; top:243px' class='unit' id='unit47'>0</div>
				<div style='left: 814px; top:129px' class='unit' id='unit48'>0</div>
				<div style='left: 1242px; top:480px' class='unit' id='unit49'>0</div>
				<div style='left: 1196px; top:363px' class='unit' id='unit50'>0</div>
				<div style='left: 894px; top:174px' class='unit' id='unit51'>0</div>
				<div style='left: 1708px; top:347px' class='unit' id='unit52'>0</div>
				<div style='left: 1307px; top:291px' class='unit' id='unit53'>0</div>
				<div style='left: 1537px; top:470px' class='unit' id='unit54'>0</div>
				<div style='left: 1072px; top:409px' class='unit' id='unit55'>0</div>
				<div style='left: 917px; top:441px' class='unit' id='unit56'>0</div>
				<div style='left: 1131px; top:270px' class='unit' id='unit57'>0</div>
				<div style='left: 1231px; top:713px' class='unit' id='unit58'>0</div>
				<div style='left: 407px; top:411px' class='unit' id='unit59'>0</div>
				<div style='left: 1491px; top:286px' class='unit' id='unit60'>0</div>
				<div style='left: 1026px; top:496px' class='unit' id='unit61'>0</div>
				<div style='left: 1040px; top:103px' class='unit' id='unit62'>0</div>
				<div style='left: 1860px; top:845px' class='unit' id='unit63'>0</div>
				<div style='left: 1668px; top:510px' class='unit' id='unit64'>0</div>
				<div style='left: 1617px; top:575px' class='unit' id='unit65'>0</div>
				<div style='left: 330px; top:170px' class='unit' id='unit66'>0</div>
				<div style='left: 1785px; top:619px' class='unit' id='unit67'>0</div>
				<div style='left: 954px; top:325px' class='unit' id='unit68'>0</div>
				<div style='left: 1220px; top:426px' class='unit' id='unit69'>0</div>
				<div style='left: 1350px; top:136px' class='unit' id='unit70'>0</div>
				<div style='left: 1349px; top:204px' class='unit' id='unit71'>0</div>
				<div style='left: 1147px; top:197px' class='unit' id='unit72'>0</div>
				<div style='left: 1167px; top:245px' class='unit' id='unit73'>0</div>
				<div style='left: 1241px; top:195px' class='unit' id='unit74'>0</div>
				<div style='left: 1568px; top:193px' class='unit' id='unit75'>0</div>
				<div style='left: 1671px; top:176px' class='unit' id='unit76'>0</div>
				<div style='left: 1456px; top:236px' class='unit' id='unit77'>0</div>
				<div style='left: 1469px; top:163px' class='unit' id='unit78'>0</div>
				<div style='left: 378px; top:322px' class='unit' id='unit79'>0</div>
				<div style='left: 578px; top:319px' class='unit' id='unit80'>0</div>
				<div style='left: 542px; top:359px' class='unit' id='unit81'>0</div>
				<div style='left: 459px; top: 361px' class='unit' id='unit82'>0</div>
			</div>
		</div>
		-->
		
		
		
		Ribbon ideas:

- Confirmed email address
- 5 Account referrals
- Beat Nevergrind
- Kickstarter backer
- Purchased a flag
- Purchased a dictator
- Launched an ICBM
- Launched a missile
- Received a Great General
- Received a Great Artist
- Received a Great Humanitarian
- Received a Great Explorer
- Received a Great Scientist

Great People:

Great Humanitarian: Double population of highest tile
Great Artist: Steal largest enemy army
Great General: +1 attack and defense to all armies
Great Leader: Boost all unit production
Great Explorer: Boost all gold production
Great Builder: Builds a wall 
Great Scientist: Builds a nuclear weapon (reduces tile to 1 and destroys all structures)

Produce:
10 Army
35 Trench +1 defense
75 +1 defense
90 +1 offense


80 Fortress +2 defense




200 Wall +3 defense
500 Nuke

(function(Math){
	function battle(x, y){
		var oBonus = 0,
			dBonus = 0;
		
		while (y && x > 1){
			var diceX = x > 2 ? 3 : 2,
				diceY = y > 1 ? 2 : 1,
				xRoll = [],
				yRoll = [];
			
			x -= diceX;
			y -= diceY;
			
			for (var i=0; i<diceX; i++){
				xRoll.push( ~~(Math.random() * (6 + oBonus)) + 1);
			}
			
			for (var i=0; i<diceY; i++){
				yRoll.push( ~~(Math.random() * (6 + dBonus)) + 1);
			}
			
			xRoll.sort().reverse();
			yRoll.sort().reverse();
			
			while( (x && xRoll.length || !x && xRoll.length > 1) && yRoll.length){
				xRoll[0] > yRoll[0] ? diceY-=1 : diceX-=1;
				xRoll = xRoll.slice(1);
				yRoll = yRoll.slice(1);
			}
			x += diceX;
			y += diceY;
		}
		
		return x > y ? true : false;
	}
	var wins = 0,
		battles = 1000,
		team = [10, 10],
		i = 0;
		
	for (; i<battles; i++){
		wins = battles(team[0], team[1]) ? wins+=1 : wins;
	}
	console.info('victory ratio: ', ((wins/battles) * 100).toFixed(1) + "%");
})(Math);

$.getJSON('http://freegeoip.net/json/', function(result) {
    alert(result.country_code);
  });
  
  
  
  
  
  
var currentPlayers = game.countPlayers();
// set player list
var str = '';
for (var i=1; i<=currentPlayers; i++){
	var p = game.player[i];
	console.info(currentPlayers, i, p);
	str += "<div class='row lobbyRow'>" +
		"<div class='col-xs-3'>";
		if (p.flag !== "Default.jpg"){
			str += "<img src='images/flags/" + p.flag + "' class='player" + i + " w100 block center'>";
		} else {
			str += "<img src='images/flags/Player" + i + ".jpg' class='player" + i + " w100 block center'>";
		}
		str += "</div>" +
		"<div class='col-xs-9 lobbyNationInfo'>" +
			"<div class='gameNationName'>" + p.nation + "&nbsp;" + p.units + "</div>" +
		"</div>" +
	"</div>";
						console.info('loop: ', i, 'total: ', currentPlayers);
					}
					document.getElementById('players').innerHTML = str;

					
					
					
					
			/*
			// output approximate text nodes for a map
			function addText(p){
				var s = '';
				if (typeof p === 'object'){
					var t = document.createElementNS("Use http://www.w3.org/2000/svg", "text");
					var id = p.getAttribute("id");
					var b = p.getBBox();
					var x = ~~((b.x + b.width/2) + 10);
					var y = ~~(b.y + b.height/2);
					id = id.replace(/land/g, "");
					s += "<text transform='translate(" + x + " " + y + ")' class='unit' id='unit"+ id + "'>0</text>";
					p.parentNode.appendChild(t);
				} else {
					console.info("FAIL: ", typeof p, p);
				}
				return s;
			}
			var paths = document.getElementsByClassName("land");
			var str = '';
			for (var p in paths){
				str += addText(paths[p]);
			}
			console.info(str);
			*/
			
			
			
			$.ajax({
				type: "GET",
				url: "php/getGameState.php"
			}).done(function(data){
				console.info(data);
			}).fail(function(data){
				serverError();
			}).always(function(){
				setTimeout(repeat, 1000);
			});