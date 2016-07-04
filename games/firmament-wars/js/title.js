// title.js
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

$("#logout").on('click', function() {
	logout();
});
$(".btn-head").on("click", function(){
	$(".btn-head").removeClass("active");
	$(this).addClass("active");
});
var gameId = 0;

$("#menu").on("click", ".wars", function(){

	$(".wars").removeClass("selected");
	$(this).addClass("selected");
	gameId = $(this).data("id");
	
});

$("#refreshGames").on("click", function(){
	refreshGames();
}).trigger("click");

$("#create").on("click", function(){
	var x = 
	"<div id='createGameWrap'>" +
		"<form class='form-horizontal'>" +
			"<div class='form-group'>" +
				'<label id="gameNameLabel" for="gameName" class="col-xs-3 control-label">Game Name:</label>' +
				"<div class='col-xs-9'>" +
					'<input id="gameName" class="form-control" type="text" maxlength="32" autocomplete="off" size="20">' +
				"</div>" +
			"</div>" +
			"<div class='form-group'>" +
				"<label for='gamePlayers' class='col-xs-8 control-label'>Maximum Number of Players:</label>" +
				"<div class='col-xs-4'>" +
					"<input type='number' class='form-control' id='gamePlayers' value='4' min='2' max='8'>" +
				"</div>" +
			"</div>" +
			"<div class='form-group '>" +
				"<div class='col-xs-12'>" +
					"<button id='createGame' type='button' class='btn btn-md btn-info btn-responsive pull-right shadow3'>Create Game Lobby</button>" +
				"</div>" +
			"</div>" +
		"</form>" +
	"</div>";
	$("#menuContent").html(x);
	$("#gameName").focus();
});

$("#menu").on("click", "#createGame", function(){
	var name = $("#gameName").val();
	var players = $("#gamePlayers").val()*1;
	if (name.length < 1 || name.length > 32){
		Msg("Game name must be at least 4-32 characters.");
	} else if (players < 2 || players > 8 || players % 1 !== 0){
		Msg("Game must have 2-8 players.");
	} else {
		g.lock(1);
		$.ajax({
			url: 'php/createGame.php',
			data: {
				name: name,
				players: players
			}
		}).done(function(data) {
			console.info("Creating: ", data);
			joinLobby(); // create
		}).fail(function(e){
			console.info(e.responseText);
			Msg(e.statusText);
			g.unlock(1);
		});
	}
});

function joinGame(){
	g.lock();
	$.ajax({
		url: 'php/joinGame.php',
		data: {
			gameId: gameId
		}
	}).done(function(data) {
		joinLobby(); // normal join
	}).fail(function(e){
		Msg(e.statusText);
	}).always(function(){
		g.unlock();
	});
}

function setResources(d){
	TweenMax.to(my, .5, {
		food: d.food,
		production: d.production,
		culture: d.culture,
		onUpdate: function(){
			DOM.food.textContent = ~~my.food;
			DOM.production.textContent = ~~my.production;
			DOM.culture.textContent = ~~my.culture;
		},
		ease: Linear.easeNone
	});
	if (my.manpower !== d.manpower){
		if (d.manpower > my.manpower && game.initialized){
			TweenMax.fromTo('#manpower', 2, {
			  color: '#ffff00'
			}, {
			  color: '#fff',
			  ease: Quad.easeIn
			});
			TweenMax.to(my, .5, {
				manpower: d.manpower,
				onUpdate: function(){
					DOM.manpower.textContent = ~~my.manpower;
				}
			});
		} else {
			DOM.manpower.textContent = d.manpower;
			my.manpower = d.manpower;
		}
	}
	DOM.foodMax.textContent = d.foodMax;
	if (d.sumFood){
		DOM.sumFood.textContent = d.sumFood;
		DOM.sumProduction.textContent = d.sumProduction;
		DOM.sumCulture.textContent = d.sumCulture;
	} else {
		DOM.sumFood.textContent = 0;
		DOM.sumProduction.textContent = 0;
		DOM.sumCulture.textContent = 0;
	}
}

(function(){
	// init 
	var s = "<option value='Default' selected='selected'>Default</option>";
	var flagData = {
		Africa: {
			group: "Africa",
			name: ['Algeria', 'Botswana', 'Cameroon', 'Cape Verde', 'Ivory Coast', 'Egypt', 'Ghana', 'Kenya', 'Liberia', 'Morocco', 'Mozambique', 'Namibia', 'Nigeria', 'South Africa', 'Uganda']
		},
		Asia: {
			group: "Asia",
			name: ['Bangladesh', 'Cambodia', 'China', 'Hong Kong', 'India', 'Indonesia', 'Iran', 'Ireland', 'Japan', 'Malaysia', 'Mongolia', 'Myanmar', 'Nepal', 'North Korea', 'Pakistan', 'Philippines', 'Singapore', 'South Korea', 'Sri Lanka', 'Suriname', 'Taiwan', 'Thailand', 'Vietnam']
		},
		Europe: {
			group: "Europe",
			name: ['Albania', 'Austria', 'Belgium', 'Bosnia and Herzegovina', 'Bulgaria', 'Croatia', 'Czech Republic', 'Denmark', 'England', 'Estonia', 'Finland', 'France', 'Germany', 'Greece', 'Hungary', 'Iceland', 'Italy', 'Kosovo', 'Latvia', 'Lithuania', 'Macedonia', 'Montenegro', 'Netherlands', 'Norway', 'Poland', 'Portugal', 'Romania', 'Russia', 'Scotland', 'Serbia', 'Slovakia', 'Slovenia', 'Spain', 'Sweden', 'Switzerland', 'Ukraine', 'United Kingdom', 'United States']
		},
		Eurasia: {
			group: "Eurasia",
			name: ['Armenia', 'Azerbaijan', 'Georgia', 'Kazakhstan', 'Uzbekistan']
		},
		Historic: {
			group: "Historic",
			name: ['Confederate Flag', 'Flanders', 'Gadsden Flag', 'Isle of Man', 'Rising Sun Flag', 'NSDAP Flag', 'Shahanshahi', 'USSR', 'Welsh']
		},
		MiddleEast: {
			group: "Middle East",
			name: ['Israel', 'Jordan', 'Kurdistan', 'Lebanon', 'Palestine', 'Qatar', 'Saudi Arabia', 'Syria', 'Turkey']
		},
		NorthAmerica: {
			group: "North America",
			name: ['Bahamas', 'Barbados', 'Canada', 'Costa Rica', 'Cuba', 'Haiti', 'Honduras', 'Mexico', 'Saint Lucia', 'Trinidad and Tobago']
		},
		Oceania: {
			group: "Oceania",
			name: ['Australia', 'New Zealand']
		},
		Miscellaneous: {
			group: "Miscellaneous",
			name: ['Anarcho-Capitalist', 'European Union', 'High Energy', 'ISIS', 'Northwest Front', 'Pan-African Flag', 'Rainbow Flag', 'United Nations']
		},
		SouthAmerica: {
			group: "South America",
			name: ['Argentina', 'Bolivia', 'Brazil', 'Chile', 'Colombia', 'Ecuador', 'Paraguay', 'Peru', 'Uruguay', 'Venezuela']
		},
	}
	for (x in flagData){
		s += "<optgroup label='" + flagData[x].group + "'>";
		flagData[x].name.forEach(function(e){
			s += "<option value='" + e + "'>" + e + "</option>";
		});
		s += "</optgroup>";
	}
	document.getElementById("flagDropdown").innerHTML = s;
	g.lock();
	$.ajax({
		type: "GET",
		url: 'php/initGame.php' // check if already in a game
	}).done(function(data) {
		console.info(data);
		if (data.gameId > 0){
			console.info("Auto joined game:" + (data.gameId));
			// join lobby in progress
			joinLobby(0); // autojoin
			setResources(data);
		} else {
			// show title screen
			document.getElementById("titleMain").style.visibility = "visible";
			// hide everything title screen for game map testing
			// document.getElementById("mainWrap").style.display = "none";
		}
	}).fail(function(e){
		Msg("Failed to contact server");
	}).always(function(){
		g.unlock();
	});
})();

// cached values on client to reduce DB load
function Nation(){
	return {
		account: "",
		nation: "",
		flag: ""
	}
}
function showTarget(e, hover){
	if (typeof e === 'object'){
		var tileId = e.id.slice(4)*1;
		console.info(tileId);
		// console.info('tileId: ', tileId);
		var d = game.tiles[tileId];
		if (!hover){
			my.tgt = tileId;
		}
		var t = game.tiles[tileId];
		var flag = "",
			nation = "",
			account = "";
		if (t.player === 0){
			flag = "Player0.jpg";
			if (t.units > 0){
				nation = "Barbarian Tribe";
			} else {
				nation = "Uninhabited Territory";
			}
		} else {
			if (t.flag === "Default.jpg"){
				flag = "Player" + t.player + ".jpg";
			} else {
				flag = t.flag;
			}
			nation = t.nation;
			account = t.account;
		}
		
		var str = '<img src="images/flags/' + flag + '" class="player' + t.player + ' p' + t.player + 'b w100 block center">' +
			'<div id="nation-ui">' + nation + '</div>';
		document.getElementById("target").innerHTML = str;
		// actions panel
		var str = '<div id="tileInfo" class="no-select text-center">'+
					'<div id="tile-ui">' + t.name + '</div>' +
					'<div>' +
						'<i class="manpower fa fa-angle-double-up"></i> <span id="tileArmies">' + t.units + '</span>' +
						'&emsp;<i class="food fa fa-user-plus"></i> ' + t.food + 
						'&emsp;<i class="production fa fa-gavel"></i> ' + t.production + 
						'&emsp;<i class="culture fa fa-flag"></i> ' + t.culture + 
					'</div>' +
				'</div>' +
				'<div id="tileActions" class="shadow4">';
					// action buttons
					if (my.player === t.player){
						str += '<button id="attack" type="button" class="btn btn-info btn-responsive btn-md shadow4">Attack</button>' +
						'<button id="deploy" type="button" class="btn btn-info btn-responsive btn-md shadow4">Deploy</button>';;
					}
				str += '<div>';
		document.getElementById("actions").innerHTML = str;
	} else {
		my.attackOn = false;
	}
}

$("#menu").on("click", "#joinGame", function(){
	console.info("JOINING: "+gameId);
	joinGame();
});

function joinLobby(d){
	if (d === undefined){
		d = .5;
	}
	g.view = "lobby";
	TweenMax.to("#titleMain", d, {
		autoAlpha: 0,
		onComplete: function(){
			g.unlock(1);
			TweenMax.fromTo('#joinGameLobby', .5, {
				autoAlpha: 0
			}, {
				autoAlpha: 1
			});
		}
	});
	
	var lobby = {
		gameWindowSet: false,
		data: "",
		startClassOn: "btn btn-info btn-md btn-block btn-responsive shadow3",
		startClassOff: "btn btn-default btn-md btn-block btn-responsive shadow3"
	};
	
	(function repeat(lobby){
		if (g.view === "lobby"){
			$.ajax({
				type: "GET",
				url: "php/updateLobby.php"
			}).done(function(x){
				console.info(x.delay);
				if (!lobby.gameWindowSet){
					lobby.gameWindowSet = true;
					document.getElementById("lobbyGameName").innerHTML = x.name;
					document.getElementById("lobbyGameMax").innerHTML = x.max;
					document.getElementById("lobbyGameMap").innerHTML = x.map;
					var z = x.player === 1 ? "block" : "none";
					document.getElementById("startGame").style.display = z;
				}
				
				if (lobby.data !== x.lobbyData){
					lobby.data = x.lobbyData;
					if (g.view === "lobby"){
						document.getElementById("lobbyPlayers").innerHTML = x.lobbyData;
						// console.info("Lobby: ", x.hostFound, x.gameStarted);
					}
					if (x.player === 1){
						var e = document.getElementById("startGame");
						if (x.totalPlayers === 1){
							e.className = lobby.startClassOff;
						} else {
							e.className = lobby.startClassOn;
						}
					}
				}
				if (x.gameStarted){
					joinStartedGame();
				} else if (!x.hostFound){
					Msg("The host has left the lobby.");
					setTimeout(function(){
						exitGame(true);
					}, 500);
					// TODO: remove game when done testing
				} else if (g.view === "lobby"){
					setTimeout(repeat, 1000, lobby);
				}
			}).fail(function(data){
				serverError();
			});
		}
	})(lobby);
}
function startGame(d){
	if ($(".lobbyNationName").length > 1){
		document.getElementById("startGame").style.display = "none";
		g.lock(1);
		var e1 = document.getElementById("mainWrap");
		TweenMax.to(e1, .5, {
			alpha: 0
		});
		$.ajax({
			type: "GET",
			url: "php/startGame.php"
		}).done(function(data){
			console.info(data);
			$("#mainWrap").remove();
			g.unlock();
			g.view = "game";
			var e = document.getElementById("gameWrap");
			TweenMax.fromTo(e, 1, {
				autoAlpha: 0
			}, {
				autoAlpha: 1
			});
			joinStartedGame();
		}).fail(function(data){
			serverError();
		}).always(function(){
			g.unlock();
		});
	} else {
		
	}
}

function joinStartedGame(){
	g.lock(1);
	console.info("Joining started game");
	var e1 = document.getElementById("mainWrap");
	if (e1 !== null){
		TweenMax.to(e1, .5, {
			alpha: 0
		});
	}
	$.ajax({
		type: "GET",
		url: "php/initGameState.php"
	}).done(function(data){
		var focusTile = 0;
		my.player = data.player;
		my.flag = data.flag;
		my.nation = data.nation;
		var e = document.getElementById('manpowerFlag');
		e.src = my.flag === "Default.jpg" ? 'images/flags/Player' + my.player + '.jpg' : 'images/flags/' + my.flag;
		e.className = 'player' + my.player +' p' + my.player + 'b w100 block center';
		console.info(data);
		// initialize player data
		game.initialized = true;
		for (var z=0, len=game.player.length; z<len; z++){
			game.player[z] = new Nation();
		}
		console.info(game.player);
		// initialize client data
		for (var i=0, len=data.tiles.length; i<len; i++){
			var d = data.tiles[i];
			game.tiles[i] = {
				name: d.tileName,
				account: d.account,
				player: d.player,
				nation: d.nation,
				flag: d.flag,
				units: d.units,
				food: d.food,
				production: d.production,
				culture: d.culture
			}
			if (d.nation){
				if (!game.player[d.player].nation){
					game.player[d.player].nation = d.nation;
					game.player[d.player].flag = d.flag;
					game.player[d.player].account = d.account;
				}
			}
			document.getElementById('unit' + i).textContent = d.units === 0 ? "" : d.units;
			if (data.tiles[i].player){
				TweenMax.set(document.getElementById('land' + i), {
					fill: color[d.player]
				});
			}
			if (my.player === d.player){
				focusTile = i;
			}
		}
		// SVG mouse events
		$(".land").on("click", function(){
			if (my.attackOn){
				action.attackTile(this);
			} else {
				showTarget(this);
			}
		}).on("mouseenter", function(){
			if (my.attackOn){
				showTarget(this, true);
			} else {
				TweenMax.set(this, {
					// fill: "#ff0000"
					fill: "hsl(+=0%, +=30%, +=15%)"
				});
			}
		}).on("mouseleave", function(){
			var land = this.id.slice(4)*1;
			if (game.tiles.length > 0){
				var player = game.tiles[land].player;
				TweenMax.to(this, .25, {
					fill: color[player]
				});
			}
		});
		// focus on player home
		var e = document.getElementById("land" + focusTile);
		var box = e.getBBox();
		// init map position & check max/min values
		var x = (-box.x + 512);
		if (x > 0){ x = 0; }
		var xMin = (g.mouse.mapSizeX - 1024) * -1;
		if (x < xMin){ x = xMin; }
		
		var y = (-box.y + 384);
		if (y > 0){ y = 0; }
		var yMin = (g.mouse.mapSizeY - 768) * -1;
		if (y < yMin){ y = yMin; } 
		TweenMax.set("#worldWrap", {
			x: x * g.resizeX,
			y: y * g.resizeY
		});
		$(e).trigger("click");
		
		$("#mainWrap").remove();
		g.unlock();
		g.view = "game";
		var e = document.getElementById("gameWrap");
		TweenMax.fromTo(e, 1, {
			autoAlpha: 0
		}, {
			autoAlpha: 1
		});
		getGameState();
	}).fail(function(data){
		serverError();
	}).always(function(){
		g.unlock();
	});
}
function setTileUnits(i, unitColor){
	var e = document.getElementById('unit' + i);
	e.textContent = game.tiles[i].units === 0 ? "" : game.tiles[i].units;
	TweenMax.fromTo(e, .5, {
		transformOrigin: (game.tiles[i].units.length * 3) + ' 12',
		scale: 2,
		fill: unitColor
	}, {
		scale: 1,
		fill: "#ffffff"
	});
}

function getGameState(){
	// add function to get player data list?
	function updateTilePlayer(i, d){
		game.tiles[i].player = d.player;
		game.tiles[i].account = game.player[d.player].account;
		game.tiles[i].nation = game.player[d.player].nation;
		game.tiles[i].flag = game.player[d.player].flag;
	}
	(function repeat(){
		var lag = Date.now();
		var repeatDelay = 2500;
		$.ajax({
			type: "GET",
			url: "php/getGameState.php"
		}).done(function(data){
			console.info('lag: ' + (Date.now() - lag), data);
			repeatDelay = data.timeout;
			var tiles = data.tiles;
			// get tile data
			for (var i=0, len=data.tiles.length; i<len; i++){
				var d = data.tiles[i],
					updateTargetStatus = false;
				// check player value
				
				if (d.player !== game.tiles[i].player){
					// only update client data if there's a difference
					updateTilePlayer(i, d);
					var e1 = document.getElementById('land' + i);
					if (my.tgt === i){
						// attacker won 
						updateTargetStatus = true;
					}
					TweenMax.to(e1, .5, {
						fill: color[d.player]
					});
				}
				// check unit value
				if (d.units !== game.tiles[i].units){
					var unitColor = d.units > game.tiles[i].units ? '#00ff00' : '#ff0000';
					game.tiles[i].units = d.units;
					if (my.tgt === i){
						// defender won
						updateTargetStatus = true;
					}
					setTileUnits(i, unitColor);
				}
				if (updateTargetStatus){
					showTarget(document.getElementById('land' + i));
				}
			}
			var len = data.chat.length;
			if (len > 0){
				for (var i=0; i<len; i++){
					chat(data.chat[i].message);
				}
			}
		}).fail(function(data){
			console.info(data.responseText);
			serverError();
		}).always(function(data){
			setTimeout(repeat, repeatDelay);
		});
	})();
	
	(function(){
		setInterval(function(){
			$.ajax({
				type: "GET",
				url: "php/updateResources.php"
			}).done(function(data){
				console.info('resource: ', data);
				console.info('get: ', data.get);
				setResources(data);
			}).fail(function(data){
				serverError();
			});
		}, 5000);
	})();
}

$("#mainWrap").on("click", "#cancelGame", function(){
	exitGame();
}).on("click", "#startGame", function(){
	startGame();
});

function animateNationName(){
	var tl = new TimelineMax();
	var split = new SplitText("#nationName", {
		type: "words,chars"
	});
	var chars = split.chars;
	tl.staggerFromTo(chars, .05, {
		immediateRender: true,
		alpha: 0
	}, {
		delay: .25,
		alpha: 1
	}, .025);
}
$("#toggleNation").on("click", function(){
	var e = document.getElementById("configureNation");
	var s = e.style.visibility;
	e.style.visibility = s === "hidden" || !s ? "visible" : "hidden";
	TweenMax.fromTo("#configureNation", .5, {
		scale: .8,
		alpha: 0
	}, {
		scale: 1,
		z: 0,
		alpha: 1
	});
	
	animateNationName();
});

$("#flagDropdown").on("change", function(e){
	$(".flagPurchaseStatus").css("display", "none");
	var z = $(this).val();
	var x = z === "Nepal" ? "Nepal.png" : z + ".jpg";
	$("#updateNationFlag").attr("src", "images/flags/" + x)
		.css("display", "block");
	g.lock(1);
	$.ajax({
		url: 'php/updateFlag.php',
		data: {
			flag: x
		}
	}).done(function(data) {
		$("#offerFlag").css("display", "none");
		$("#nationFlag").attr("src", "images/flags/" + x);
		$("#flagPurchased").css("display", "block");
		Msg("Your nation's flag is now: " + z);
	}).fail(function(e){
		$("#flagPurchased").css("display", "none");
		$("#offerFlag").css("display", "block");
	}).always(function(){
		g.unlock(1);
		TweenMax.fromTo("#updateNationFlag", 1, {
			alpha: .25,
			scale: .9
		}, {
			alpha: 1,
			scale: 1
		});
	});
});

$("#submitNationName").on("click", function(e){
	var x = $("#updateNationName").val();
	g.lock();
	$.ajax({
		url: 'php/updateNationName.php',
		data: {
			name: x
		}
	}).done(function(data) {
		$("#nationName").text(data);
		Msg("Your nation shall now be known as: " + data);
		animateNationName();
	}).fail(function(e){
		Msg(e.statusText);
	}).always(function(){
		g.unlock();
	});
});


$("#updateNationName").on("focus", function(){
	g.focusUpdateNationName = true;
}).on("blur", function(){
	g.focusUpdateNationName = false;
});
$("#menuContent").on("focus", "#gameName", function(){
	g.focusGameName = true;
})
$("#menuContent").on("blur", "#gameName", function(){
	g.focusGameName = false;
});

$("#buyFlag").on("click", function(){
	var e = $("#flagDropdown").val();
	var x = e === "Nepal" ? "Nepal.png" : e + ".jpg";
	g.lock();
	$.ajax({
		url: 'php/buyFlag.php',
		data: {
			flag: x
		}
	}).done(function(data) {
		$("#crystalCount").text(data);
		$("#flagPurchased").css("display", "block");
		$("#offerFlag").css("display", "none");
		$("#nationFlag").attr("src", "images/flags/" + x);
		Msg("Your nation's flag is now: " + e);
	}).fail(function(e){
		// not enough money
		Msg(e.statusText);
	}).always(function(){
		g.unlock();
	});
});
/*
// findShapeIndex("#US", "#CA");
TweenMax.fromTo("#US", 5, { 
	morphSVG: '#US'
}, {
	morphSVG: {
		shape: "#CA",
		shapeIndex: 258
	}
}); 

*/
if (isChrome){
	// playMusic("WaitingBetweenWorlds");
}

$("#Msg").on("click", ".msg", function(){
	var e = this;
	TweenMax.killTweensOf(e);
	e.parentNode.removeChild(e);
});