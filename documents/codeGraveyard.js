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