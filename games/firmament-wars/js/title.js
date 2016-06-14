// events
(function(){
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
	$(".land").on("click", function(e){
		console.info(this.id, e.offsetX, e.offsetY);
	}).on("mouseenter", function(){
		TweenMax.set(this, {
			fill: "#ff0000"
		});
	}).on("mouseleave", function(){
		var land = this.id.slice(4)*1;
		var player = game.tiles[land].player;
		TweenMax.to(this, .25, {
			fill: color[player]
		});
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
					"<label for='gamePlayers' class='col-xs-9 control-label'>Maximum Number of Players:</label>" +
					"<div class='col-xs-3'>" +
						"<input type='number' class='form-control' id='gamePlayers' value='4' min='2' max='8'>" +
					"</div>" +
				"</div>" +
				"<div class='form-group '>" +
					"<div class='col-xs-12'>" +
						"<button id='createGame' type='button' class='btn btn-md btn-info pull-right shadow3'>Create Game Lobby</button>" +
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
			if ((data*1) > 0){
				console.info("Auto joined game:" + (data*1));
				// join lobby in progress
				joinLobby(0); // autojoin
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
			scale: 1.02,
			autoAlpha: 0,
			onComplete: function(){
				g.unlock(1);
				TweenMax.fromTo('#joinGameLobby', .5, {
					scale: 1.02,
					autoAlpha: 0
				}, {
					scale: 1,
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
					if (!x.hostFound){
						Msg("The host has left the game.");
						setTimeout(function(){
							exitGame();
						}, 1000);
						// TODO: remove game when done testing
					} else if (x.gameStarted){
						joinStartedGame();
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
			console.info("Start game");
			var e1 = document.getElementById("mainWrap");
			TweenMax.to(e1, .5, {
				alpha: 0
			});
			$.ajax({
				type: "GET",
				url: "php/startGame.php"
			}).done(function(data){
				document.getElementById('serverData').innerHTML = data;
				console.info(data);
				$("#mainWrap").remove();
				g.unlock();
				g.view = "game";
				var e = document.getElementById("gameWrap");
				TweenMax.fromTo(e, 1, {
					autoAlpha: 0,
					scale: 1.02
				}, {
					autoAlpha: 1,
					scale: 1
				});
				getGameState();
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
		TweenMax.to(e1, .5, {
			alpha: 0
		});
		$.ajax({
			type: "GET",
			url: "php/getGameState.php"
		}).done(function(data){
			console.info(data);
			$("#mainWrap").remove();
			g.unlock();
			g.view = "game";
			var e = document.getElementById("gameWrap");
			TweenMax.fromTo(e, 1, {
				autoAlpha: 0,
				scale: 1.02
			}, {
				autoAlpha: 1,
				scale: 1
			});
			getGameState();
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
		}).fail(function(data){
			serverError();
		}).always(function(){
			g.unlock();
		});
	}
	
	game = {
		tiles: [],
		playerTiles: [0,0,0,0,0,0,0,0,0],
		tileDataInitialized: false,
		players: []
	}
	function Nation(){
		return {
			nation: "",
			flag: "",
			units: 0
		}
	}
	
	function getGameState(){
		// add function to get player data list?
		(function repeat(){
			$.ajax({
				type: "GET",
				url: "php/getGameState.php"
			}).done(function(data){
				// console.info(data);
				var start = new Date();
				var i=0,
					len=data.tiles.length,
					tiles = data.tiles;
				// get tile data
				if (game.tileDataInitialized){
					for (; i<9; i++){
						game.playerTiles[i] = 0;
					}
					for (var i=0; i<len; i++){
						var d = data.tiles[i];
						if (d.player !== game.tiles[i].player){
							// only update client data if there's a difference
							game.tiles[i].player = d.player;
							game.tiles[i].units = d.units;
							TweenMax.to(document.getElementById('land' + i), .5, {
								fill: color[d.player]
							});
						}
						if (d.units !== game.tiles[i].units){
							var unitColor = d.units > game.tiles[i].units ? '#00dd00' : '#cc0000';
							game.tiles[i].units = d.units;
							var e = document.getElementById('unit' + i);
							e.textContent = game.tiles[i].units;
							var x = game.tiles[i].units.length * 3;
							console.info(unitColor);
							TweenMax.fromTo(e, .25, {
								scale: 2,
								fill: unitColor,
								transformOrigin: x + ' 10'
							}, {
								scale: 1,
								fill: '#ffffff'
							});
							
						}
						// count total units for each player
						game.playerTiles[d.player] += d.units;
						
						// set player data
						var units = [0,0,0,0,0,0,0,0,0];
						for (var i=0, len=tiles.length; i<len; i++){
							var t = tiles[i],
								p = t.player;
							units[p] += t.units;
						}
						for (var i=0, len=units.length; i<len; i++){
							game.players[i].units = units[i];
						}
						// console.info(game.players[1], game.players[2]);
					}
				} else {
					// initialize client data
					for (; i<len; i++){
						var d = data.tiles[i];
						game.tiles[i] = {
							player: d.player,
							units: d.units
						}
						document.getElementById('unit' + i).textContent = d.units;
						if (data.tiles[i].player){
							TweenMax.set(document.getElementById('land' + i), {
								fill: color[d.player]
							});
						}
					}
					game.tileDataInitialized = true;
					// set player data
					for (var i=0, len=game.playerTiles.length; i<len; i++){
						game.players[i] = new Nation();
					}
					for (var i=0, len=tiles.length; i<len; i++){
						var t = tiles[i],
							p = t.player;
						if (game.players[p].nation){
							game.players[p].units += t.units;
						} else {
							game.players[p] = {
								nation: t.nation,
								flag: t.flag,
								units: t.units
							}
						}
					}
					// console.info(game.players[1], game.players[2]);
				}
				console.info(Date.now() - start);
				// get player data
			}).fail(function(data){
				serverError();
			}).always(function(){
				setTimeout(repeat, 1000);
			});
		})();
			/*
			(function repeat(count){
				var foo = color[(~~(Math.random()*8) + 1)];
				var bar = "#land" + ((count % 101) + 1);
				TweenMax.to(bar, 1, {
				  fill: foo
				});
				setTimeout(function(){
					repeat(++count);
				}, 100);
			})(0);
			*/
			/*
			TweenMax.set("#land62", {
			  fill: "#008800"
			});
			*/
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
	
})();
/*
	var source = new EventSource('php/stream.php');

	source.addEventListener('message', function(e) {
		console.info(e.data);
	}, false);

	source.addEventListener('error', function(e) {
		if (e.readyState == EventSource.CLOSED) {
			console.error("ERROR");
		}
	}, false);
*/