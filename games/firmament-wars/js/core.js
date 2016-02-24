$.ajaxSetup({
    type: 'POST',
    url: '/php/master1.php'
});
TweenMax.defaultEase = Quad.easeOut;

var GLB = {
    musicStatus: 100,
    soundStatus: 100,
    videoSetting: "High",
    showCombatLog: "On",
    debugMode: "Off"
}
var isXbox = /Xbox/i.test(navigator.userAgent),
    isPlaystation = navigator.userAgent.toLowerCase().indexOf("playstation") >= 0,
    isNintendo = /Nintendo/i.test(navigator.userAgent),
    isMobile = /Silk|Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent),
    isOpera = !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0,
    isFirefox = typeof InstallTrigger !== 'undefined',
    isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0,
    isChrome = !!window.chrome && !isOpera,
    isMSIE = /*@cc_on!@*/ false,
    isMSIE11 = !!navigator.userAgent.match(/Trident\/7\./),
	dev = location.host === "localhost" ? true : false,
	chatDragStatus = false,
	dom = {};

function resizeWindow() {
    var e = document.getElementById('body');
    // game ratio
    var widthToHeight = 1024/768;
    // current window size
    var w = window.innerWidth > 1024 ? 1024 : window.innerWidth;
    var h = window.innerHeight > 768 ? 768 : window.innerHeight;
    if(w / h > widthToHeight){
    	// too tall
    	w = h * widthToHeight;
    	e.style.height = h + 'px';
    	e.style.width = w + 'px';
    }else{
    	// too wide
    	h = w / widthToHeight;
    	e.style.width = w + 'px';
    	e.style.height = h + 'px';
    }
    e.style.marginTop = (-h / 2) + 'px';
    e.style.marginLeft = (-w / 2) + 'px';
}


function Chat(entry, fg) {
	var e = document.getElementById("chat");
	if (e.childNodes.length > 100) {
		e.removeChild(e.firstChild);
	}
    var color;
    if (fg !== undefined) {
		if (fg === 0) {
            color = "white";
        } else if (fg === 1) {
            color = "red";
        } else if (fg === 2) {
            color = "yellow";
        } else if (fg === 3) {
            color = "blue1";
        } else if (fg === 4) {
            color = "blue2";
        } else if (fg === 5) {
            color = "darkgreen";
        } else if (fg === 6) {
            color = "green3";
        }  else if (fg === 7) {
            color = "purple";
        } else if (fg === 8){
			color = "yellow2";
		} else {
            color = "grey";
        }
    }
    var z = document.createElement('div');
    if (color!==undefined) {
        z.className = color;
    }
    z.innerHTML = entry;
    e.appendChild(z);
	if(!chatDragStatus){
		NG.combatLog.scrollTop = NG.combatLog.scrollHeight;
	}
}

// sound functions
var browserOgg = (isOpera || isFirefox || isChrome) ? true : false,
    browserMp3 = (isMSIE || isMSIE11 || isSafari) ? true : false,
    audioExt = browserMp3 ? 'mp3' : 'ogg';

function fadeMusic() {
    if (!!document.createElement('audio').canPlayType) { // modern browser?
        if ((browserOgg || browserMp3) && GLB.musicStatus > 0) { // FF,Chrome,Opera
            var baz = document.getElementById("bgmusic");
            var count = 50;
            var kek = (((count / 100) * (GLB.musicStatus / 100)) * 1);
            baz.volume = kek;

            function doit() {
                if (count <= 0) {
                    return;
                }
                count -= 5;
                baz.volume = (((count / 100) * (GLB.musicStatus / 100)) * 1);
                T.delayedCall(.4, doit);
            }
            doit();
        }
    }
}
function loadAudio(sound){
    var found = false;
    for(var i=0, len=audioAssets.length; i<len; i++){
		if(audioAssets[i].nodeName==="AUDIO"){
			if(audioAssets[i].src.indexOf(sound) !== -1){
				found = true; // found it - don't load it
				continue;
			}
		}
    }
    if(found===false){ // didn't find it - load using next audio slot
		var x = audioNum();
		audioAssets[x]=D.createElement('audio');
		audioAssets[x].src=soundLocation+sound+"."+audioExt;
    }
}

function initMusic() {
    musicAssets = [];
    musicStrings = [];
    musicAssetsNumber = 0;
    for (var i = 0; i <= 9; i++) {
        musicAssets[i] = '';
        musicStrings[i] = '';
    }
}

function musicNum() {
    if (musicAssetsNumber > 9) {
        musicAssetsNumber = 0;
    }
    return musicAssetsNumber++;
}

function loadMusic(sound) {
    var found = false;
    for (var i = 0, len = musicAssets.length; i < len; i++) {
        if (musicStrings[i].indexOf(sound) !== -1) {
            found = true; // found it - don't load it
            continue;
        }
    }
    if (found === false) { // didn't find it - load using next audio slot
        var x = musicNum();
        musicStrings[x] = sound;
        musicAssets[x] = document.createElement('audio');
        musicAssets[x].src = "music/" + sound + "." + audioExt;
    }
}
initMusic();

function playMusic(foo) {
    if (isMobile === false) {
        if (audioEnabled === true) {
            if ((browserOgg === true || browserMp3 === true)) {
                loadMusic(foo);
                var x = document.getElementById("bgmusic");
                x.setAttribute('type', 'audio/' + audioExt);
                x.src = "music/" + foo + "." + audioExt;
                var kek = ((.5 * (GLB.musicStatus / 100)) * 1);
                x.volume = kek;
                x.play();
            }
        }
    }
}

function playAmbient(foo) {
    if (isMobile === false) {
        if (foo === "blankAudio") {
            return;
        }
        if (audioEnabled === true) {
            if ((browserOgg === true || browserMp3 === true)) {
                var x = document.getElementById("bgamb1");
                x.setAttribute('type', 'audio/' + audioExt);
                x.src = "music/" + foo + "." + audioExt;
                var kek = ((.2 * (GLB.musicStatus / 100)) * 1);
                x.volume = kek;
                x.play();
                setTimeout(function() {
                    var x = document.getElementById("bgamb2");
                    x.setAttribute('type', 'audio/' + audioExt);
                    x.src = "music/" + foo + "." + audioExt;
                    var kek = ((.2 * (GLB.musicStatus / 100)) * 1);
                    x.volume = kek;
                    x.play();
                }, 4000);
            }
        }
    }
}
var audioEnabled = !!document.createElement('audio').canPlayType;

function playAudio(foo, multi, fade, volAdj) {
    if (isMobile === false) {
        if (foo === "blankAudio") {
            return;
        }
        if (audioEnabled === true) { // modern browser?
            if ((browserOgg === true || browserMp3 === true)) { // FF,Chrome,Opera
                var baz = new Audio("sound/" + foo + "." + audioExt);
                baz.setAttribute('type', 'audio/' + audioExt);
                baz.src = "sound/" + foo + "." + audioExt;
                if (!volAdj) {
                    volAdj = 1;
                }
                var kek = (M.round(((.5 * (GLB.soundStatus / 100)) * volAdj) * 100) / 100);
                baz.volume = kek;
                baz.play();
                // fade this effect after fade duration?
                if (fade > 0) {
                    if (GLB.soundStatus > 0) {
                        function doit(count) {
                            var zag = (kek * 100) * (1 - (count * .2));
                            if (zag < 0) {
                                zag = 0;
                            }
                            baz.volume = zag / 100;
                            count++;
                            if (zag > 0) {
                                T.delayedCall(.1, doit, [count]);
                            }
                        }
                        T.delayedCall(fade / 1000, doit, [0]);
                    }
                }
            }
        }
    }
}
function testAjax() {
    $.ajax({
        data: {
            run: "testAjax"
        }
    }).done(function(data) {
        console.info(data);
		x = JSON.parse(data);
    });
}

function checkSessionActive() {
	$.ajax({
		data: {
			run: "checkSessionActive"
		}
	}).done(function(data) {
		if (!data) {
			// is your session still active? If not boot! 
			// perform upon login and window focus
			if (g.view !== "Main") {
				Error("Your session has timed out.");
				setTimeout(function() {
					serverLogout();
				}, 5000);
			}
		}
	});
}

function keepSessionAlive() {
    $.ajax({
        url: "/php/ping.php",
        data: {
            my: my,
			zone: myZone()
        }
    }).done(function(data) {
        var count = data * 1;

        function do1(foo) {
            if (g.view !== "Main") {
                if (foo === 2222) {
                    Error("The server is going down for maintenance.");
                } else {
                    Error("You have been disconnected from the server. Logging out.");
                }
                setTimeout(function() {
					window.onbeforeunload = null;
                    logout();
                }, 5000);
            }
        }
        if (isNaN(data)) {
            // no db
            do1();
        } else if (count === 1111) {
            // lost session
            do1();
        } else if (count === 2222) {
            // server table says down
            do1(2222);
        } else {
            if (count >= 3) {
                Error("Multiple logins detected. Logging out.");
                setTimeout(function() {
                    logout();
                }, 5000);
            }
        }
        setTimeout(function() {
            keepSessionAlive();
        }, 20000);
    }).fail(function() {
        failToCommunicate();
    });
}


function serverLogout(){
	$.ajax({
		url: '/php/game1.php',
		data: {
			run: "camp"
		}
	}).done(function(data) {
		window.onbeforeunload = null;
		location.reload();
	});
}
function failToCommunicate() {
    Chat("SERVER ERROR: Cannot contact the server", 1);
    TweenMax.pauseAll();
    setTimeout(function() {
        serverLogout();
    }, 5000);
}

function glow(e, color, amount) {
    e.shadow = new C.Shadow(color, 5, 5, amount);
    var bounds = e.getBounds();
    e.setBounds(bounds.x, bounds.y, bounds.width, bounds.height);
}

function blur(Slot, amount) {
    if (isFirefox === true || isOpera === true || isChrome === true) {
        if (amount === undefined) {
            amount = 1;
        }
        var bb = bmp[Slot].getBounds();
        var bbx = bb.x;
        var bby = bb.y;
        var bbWidth = bb.width;
        var bbHeight = bb.height;
        var blurFilter = new C.BlurFilter(amount, amount, 1);
        bmp[Slot].filters = [blurFilter];
        var bounds = blurFilter.getBounds();
        bmp[Slot].cache((bbx + bounds.x), (bby + bounds.y), (bbWidth + bounds.width), (bbHeight + bounds.height));
    }
}

function initBmpTint(Slot, mType, d) {
    var i = "#0f0";
    if (mType === "magic") {
        i = "#f0f"
    } else if (mType === "lightning") {
        i = "#fff"
    } else if (mType === "fire") {
        i = "#f80"
    } else if (mType === "cold") {
        i = "#0ff"
    }
    bmpTint[Slot][mType].name = mob[Slot].image;
    T.set(bmpTint[Slot][mType], {
        easel: {
            tint: i,
            tintAmount: .5
        }
    });
    tint(Slot, mType, d);
}

function tint(Slot, mType, d) {
    if (mType === 'physical' || !mType) {
        return;
    }
    if (isFirefox === true || isChrome === true || isOpera === true) {
        if (GLB.videoSetting === "High") {
            if (bmpTint[Slot][mType].name !== mob[Slot].image) {
                initBmpTint(Slot, mType, d)
            } else {
                tintTimer[Slot][mType].kill();
                bmpTint[Slot][mType].alpha = 1;
                tintTimer[Slot][mType] = T.delayedCall(d, function() {
                    bmpTint[Slot][mType].alpha = 0;
                });
            }
        }
    }
}
function cRem(target, e){
	stage[target].removeChild(e);
}
function cacheAdd(s2, target, x, y, scaleX, scaleY, regCenter, first){
	var e = new C.Bitmap(s2)
	if(scaleX===undefined){ scaleX = 1; }
	if(scaleY===undefined){ scaleY = 1; }
	if(regCenter===true){
		var halfW = e.image.width/2;
		var halfH = e.image.height/2;
		e.set({x:x+halfW, y:y+halfH, scaleX:scaleX, scaleY:scaleY, regX:halfW, regY:halfH});
	}else{
		e.set({x:x, y:y, scaleX:scaleX, scaleY:scaleY});
	}
	if(first===true){
		stage[target].addChildAt(e, 0);
	}else{
		stage[target].addChild(e);
	}
	return e;
}
function img(img, w, h){
    if(w===undefined){ w = 25; }
    if(h===undefined){ h = 25; }
    s1 = new C.Bitmap("/images1/"+img+".png");
    s1.cache(0, 0, w, h);
    return s1.cacheCanvas;
}
function can(img, target, x, y, w, h, regCenter, first){ 
	var e = new C.Bitmap("/images1/"+img+".png");
	var imgW = e.image.width;
	var imgH = e.image.height;
	var scaleX = w/imgW;
	var scaleY = h/imgH;
	if(regCenter===undefined){ 
		e.setTransform(x, y, scaleX, scaleY, 0, 0, 0, 0, 0);
	}else{
		var halfW = imgW/2;
		var halfH = imgH/2;
		e.setTransform(x+halfW, y+halfH, scaleX, scaleY, 0, 0, 0, halfW, halfH);
	}
	if(!first){
		stage[target].addChild(e);
	}else{
		stage[target].addChildAt(e, 0);
	}
	return e;
}
// events
$(document).ready(function() {
	$(window).on('load resize orientationchange', function() {
		resizeWindow();
	});
	$("#bgmusic").on('ended', function() {
		var x = document.getElementById('bgmusic');
		x.currentTime = 0;
		x.play();
	});
	$("#bgamb1").on('ended', function() {
		var x = document.getElementById('bgamb1');
		x.currentTime = 0;
		x.play();
	});
	$("#bgamb2").on('ended', function() {
		var x = document.getElementById('bgamb2');
		x.currentTime = 0;
		x.play();
	});
	$("#gameView").on('dragstart', 'img', function(e) {
		e.preventDefault();
	});
    $("img").on('dragstart', function(event) {
        event.preventDefault();
    });
	// SVG
	$(".land").on("mouseenter", function(){
		console.info($(this).data("name"));
		TweenMax.set($(this).get(0), {
			fill: "#880000"
		});
	}).on("mouseleave", function(){
		TweenMax.to($(this).get(0), .25, {
			fill: "#002255"
		});
	}).on("click", function(e){
		console.info($(this).data("name"));
	});;
	// startup game
	// playMusic("WaitingBetweenWorlds");
	// draw map
	/*
	var e = $(".land");
	TweenMax.fromTo(e, 2, {
		drawSVG: 0,
		strokeOpacity: 1
	}, {
		drawSVG: "102%",
		ease: Linear.easeNone
	});
	TweenMax.staggerFromTo(e, 1, {
		fillOpacity: 0,
	}, {
		fillOpacity: 1,
		delay: 6,
		ease: Linear.easeNone
	}, .033);
	*/
	
	Draggable.create("#world", {
		type: "x,y",
		bounds: "#game",
		overshootTolerance: 0,
		throwProps: true
	});
	
});