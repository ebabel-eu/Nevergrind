// core.js
$.ajaxSetup({
    type: 'POST',
    url: 'php/master1.php'
});
TweenMax.defaultEase = Quad.easeOut;

var g = {
	focusUpdateNationName: false,
	focusGameName: false,
	view: "title",
	resizeX: 1,
	resizeY: 1,
	chatOn: false,
	overlay: document.getElementById("overlay"),
	over: 0,
	lock: function(clear){
		g.overlay.style.display = "block";
		clear ? g.overlay.style.opacity = 0 : g.overlay.style.opacity = 1;
	},
	unlock: function(clear){
		g.overlay.style.display = "none";
		clear ? g.overlay.style.opacity = 0 : g.overlay.style.opacity = 1;
	},
	TDC: function(){
		return new TweenMax.delayedCall(0, '');
	},
	mouse: {
		mouseZoom: 100,
		mouseTransX: 50,
		mouseTransY: 50,
		mapSizeX: 2000,
		mapSizeY: 1150
	}
}
var game = {
	tiles: [],
	initialized: false,
	player: [0,0,0,0,0,0,0,0,0], // cached values on client to reduce DB load
	
}
var my = {
	player: 1,
	tgt: 1,
	lastTarget: {},
	units: 0,
	food: 0,
	production: 10,
	culture: 0,
	oBonus: -1,
	dBonus: -1,
	turnBonus: -1,
	foodBonus: -1,
	cultureBonus: -1,
	turnProduction: 10,
	foodMax: 25,
	cultureMax: 400,
	manpower: 0,
	focusTile: 0,
	sumFood: 0,
	sumProduction: 0,
	sumCulture: 0,
	flag: "",
	targetLine: [0,0,0,0,0,0],
	attackOn: false,
	hud: function(msg, d){
		timer.hud.kill();
		DOM.hud.style.visibility = 'visible';
		DOM.hud.textContent = msg;
		if (d){
			timer.hud = TweenMax.to(DOM.hud, 5, {
				onComplete: function(){
					DOM.hud.style.visibility = 'hidden';
				}
			});
		}
	},
	clearHud: function(){
		timer.hud.kill();
		DOM.hud.style.visibility = 'hidden';
		TweenMax.set([DOM.targetLine, DOM.targetLineShadow, DOM.targetCrosshair], {
			visibility: 'hidden',
			strokeDashoffset: 0
		});
		$DOM.head.append('<style>.land{ cursor: pointer; }</style>');
	}
}
var timer = {
	hud: g.TDC()
}

var DOM = {
	food: document.getElementById('food'),
	production: document.getElementById('production'),
	culture: document.getElementById('culture'),
	hud: document.getElementById("hud"),
	sumFood: document.getElementById("sumFood"),
	foodMax: document.getElementById("foodMax"),
	cultureMax: document.getElementById("cultureMax"),
	manpower: document.getElementById("manpower"),
	sumProduction: document.getElementById("sumProduction"),
	sumCulture: document.getElementById("sumCulture"),
	chatContent: document.getElementById("chat-content"),
	chatInput: document.getElementById("chat-input"),
	targetLine: document.getElementById('targetLine'),
	targetLineShadow: document.getElementById('targetLineShadow'),
	targetCrosshair: document.getElementById('targetCrosshair'),
	target: document.getElementById('target'),
	actions: document.getElementById('actions'),
	oBonus: document.getElementById('oBonus'),
	dBonus: document.getElementById('dBonus'),
	turnBonus: document.getElementById('turnBonus'),
	foodBonus: document.getElementById('foodBonus'),
	cultureBonus: document.getElementById('cultureBonus')
}
var $DOM = {
	head: $("#head"),
	chatInput: $("#chat-input")
}
var color = [
	"#00003a",
	"#700000",
	"#0000d0",
	"#b0b000",
	"#006000",
	"#b06000",
	"#1177aa",
	"#b050b0",
	"#5500aa"
]
var GLB = {
    musicStatus: 100,
    soundStatus: 100,
    videoSetting: "High",
    showCombatLog: "On",
    debugMode: "Off"
}
var worldMap = [];
function checkMobile(){
	var x = false;
	if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
    || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) x = true;
	return x;
}
var isXbox = /Xbox/i.test(navigator.userAgent),
    isPlaystation = navigator.userAgent.toLowerCase().indexOf("playstation") >= 0,
    isNintendo = /Nintendo/i.test(navigator.userAgent),
    isMobile = checkMobile(),
    isOpera = !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0,
    isFirefox = typeof InstallTrigger !== 'undefined',
    isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0,
    isChrome = !!window.chrome && !isOpera,
    isMSIE = /*@cc_on!@*/ false,
    isMSIE11 = !!navigator.userAgent.match(/Trident\/7\./),
	dev = location.host === "localhost" ? true : false,
	chatDragStatus = false,
	dom = {};
// browser dependent
if (isMSIE || isMSIE11){
	$("head").append('<style> text { fill: #ffffff; stroke-width: 0; } </style>');
} else if (isSafari){
	$("head").append('<style> text { fill: #ffffff; stroke: #ffffff; stroke-width: 1.75px; } </style>');
}
if (isMobile){
	$("head").append('<style> *{ box-shadow: none !important; } </style>');
}

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
	/* various responsive options
		// e.style.marginTop = (-h / 2) + 'px';
		// e.style.marginLeft = (-w / 2) + 'px';
		x: 0,
		y: 0,
		xPercent: -50,
		yPercent: -50,
		left: '50%',
		top: '50%'
	*/
	if (isFirefox){
		TweenMax.set("body", {
			left: '50%',
			top: '50%',
			marginLeft: ~~(-w / 2),
			marginTop: ~~(-h / 2),
			opacity: 1,
			force3D: true
		});
	} else {
		TweenMax.set("body", {
			x: ~~(w/2 + ((window.innerWidth - w) / 2)),
			y: ~~(h/2 + ((window.innerHeight - h) / 2)),
			opacity: 1,
			yPercent: -50,
			xPercent: -50,
			force3D: true
		});
	}
	e.style.visibility = "visible";
	if (typeof worldMap[0] !== 'undefined'){
		worldMap[0].applyBounds();
	}
	g.resizeX = w / 1024;
	g.resizeY = h / 768;
}


function chat(msg) {
    var z = document.createElement('div');
    z.innerHTML = msg;
    DOM.chatContent.appendChild(z);
	// playAudio('chat');
	setTimeout(function(){
		TweenMax.to(z, .5, {
			alpha: 0,
			onComplete: function(){
				z.parentNode.removeChild(z);
			}
		});
	}, 10000);
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
                var kek = (Math.round(((.5 * (GLB.soundStatus / 100)) * volAdj) * 100) / 100);
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
function Msg(msg, d) {
    var e = document.createElement('div');
	e.className = "msg";
    e.innerHTML = msg;
    document.getElementById("Msg").appendChild(e);
	if (d === undefined){
		d = 5;
	}
    TweenMax.to(e, d, {
		onComplete: function(){
			this.target.parentNode.removeChild(e);
		}
    });
	var tl = new TimelineMax();
	var split = new SplitText(e, {
		type: "words,chars"
	});
	var chars = split.chars;
	tl.staggerFromTo(chars, .01, {
		immediateRender: true,
		alpha: 0
	}, {
		delay: .1,
		alpha: 1
	}, .01);
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

function logout() {
    g.lockScreen();
    $('#logout').html("Logging Out");
    Msg("Logging out...");
    $.ajax({
        data: {
            run: "logout"
        }
    }).done(function(data) {
        Msg("Logout successful");
        for (var i = 1; i < 16; i++) {
            $('#characterslot' + i).css('display', "none");
        }
        $("#createcharacter, #deletecharacter").remove();
        $('#enterWorldWrap').css('display', "none");
        $('#logout').html('');
        $("#loginPassword").val('');
        location.reload();
    }).fail(function() {
        Msg("Logout failed.");
        $('#logout').html("[ " + GLB.account.split("")[0].toUpperCase() + GLB.account.slice(1) + "&nbsp;Logout&nbsp;]");
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
        serverError();
    });
}


function serverLogout(){
	window.onbeforeunload = null;
	location.reload();
}
function serverError() {
    Msg("Server Error: Cannot contact the server");
    setTimeout(function() {
        serverLogout();
    }, 5000);
}

function glow(e, color, amount) {
    e.shadow = new C.Shadow(color, 5, 5, amount);
    var bounds = e.getBounds();
    e.setBounds(bounds.x, bounds.y, bounds.width, bounds.height);
}

function blurBmp(Slot, amount) {
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

function logout(){
    g.lock();
    $.ajax({
		type: 'GET',
		url: 'php/logout.php'
    }).done(function(data) {
        location.reload();
    }).fail(function() {
        Msg("Logout failed.");
    });
}


(function repeat(){
	if (g.view === 'title'){
		$.ajax({
			type: "GET",
			url: "php/keepAlive.php"
		}).always(function(){
			setTimeout(function(){
				repeat();
			}, 180000);
		});
	}
})();
function refreshGames(){
	g.lock();
	$.ajax({
		type: 'GET',
		url: 'php/refreshGames.php'
	}).done(function(data) {
		$("#menuContent").html(data);
		$(".wars").filter(":first").trigger("click");
	}).fail(function(e){
		Msg("Server error.");
	}).always(function(){
		g.unlock();
	});
}

function exitGame(bypass){
	
	if (g.view === 'game'){
		var r = confirm("Are you sure you want to surrender?");
	}
	if (r || bypass || g.view !== 'game'){
		g.lock(1);
		$.ajax({
			type: "GET",
			url: 'php/exitGame.php'
		}).done(function(data) {
			location.reload();
		}).fail(function(e){
			Msg(e.statusText);
			g.unlock(1);
		});
	}
}


$(window).on('resize orientationchange', function() {
	resizeWindow();
}).on('load', function(){
	resizeWindow();
	// background map
	TweenMax.set("#worldTitle", {
		x: -200,
		y: -800
	});
	TweenMax.fromTo("#worldTitle", 316, {
		rotation: -360
	}, {
		rotation: 0,
		repeat: -1,
		ease: Linear.easeNone
	});
});