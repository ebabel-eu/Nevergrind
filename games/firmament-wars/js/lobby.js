
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
	if (my.foodMax !== d.foodMax){
		DOM.foodMax.textContent = d.foodMax;
	}
	if (my.cultureMax !== d.cultureMax){
		DOM.cultureMax.textContent = d.cultureMax;
	}
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

function Nation(){
	return {
		account: "",
		nation: "",
		flag: ""
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
		// console.info(data);
		my.player = data.player;
		my.flag = data.flag;
		my.nation = data.nation;
		my.foodMax = data.foodMax;
		my.cultureMax = data.cultureMax;
		// initialize player data
		game.initialized = true;
		for (var z=0, len=game.player.length; z<len; z++){
			// initialize diplomacy-ui
			game.player[z] = new Nation();
		}
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
					game.player[d.player].player = d.player;
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
				my.focusTile = i;
			}
		}
		var str = '';
		// init diplomacyPlayers
		for (var i=0, len=game.player.length; i<len; i++){
			var p = game.player[i];
			if (p.flag){
				// console.info(game.player[i]);
				if (p.flag === 'Default.jpg'){
					str += 
					'<div class="diplomacyPlayers">' +
						'<div class="diploWrap">' +
							'<div class="diplomacySquare player' + p.player + '"></div>' +
							'<img src="images/flags/Player' + p.player + '" class="player' + p.player + ' inlineFlag" data-placement="top" data-toggle="tooltip" title="'+ p.account + '">' + p.nation;
				} else {
					str += 
					'<div class="diplomacyPlayers">' +
						'<div class="diploWrap">' +
							'<div class="diplomacySquare player' + p.player + '"></div>' +
							'<img src="images/flags/' + p.flag + '" class="inlineFlag" data-placement="top" data-toggle="tooltip" title="'+ p.account + '">' + p.nation;
				}
				if (my.player === p.player){
					str += ' <i id="quitGame" class="fa fa-flag pointer" data-placement="top" data-toggle="tooltip" title="Surrender"></i></div></div>';
				} else {
					str += '</div></div>';
				}
			}
		}
		
		document.getElementById('diplomacyPlayers').innerHTML = str;
		$(function () {
			$('[data-toggle="tooltip"]').tooltip();
		});
		// SVG mouse events
		$(".land").on("mousedown", function(){
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
		
		(function repeat(){
			// delayed to allow svg to load
			if ($("#world").length > 0){
				try {
					worldMap = Draggable.create("#worldWrap", {
						bounds: "#gameWrap",
						throwProps: true,
						onRelease: function(){
							(function go(c){
								if (c < 30){
										worldMap[0].applyBounds();
									setTimeout(function(){
										go(++c);
									}, 50);
								}
							})(0);
						},
						onThrowComplete : function(){
								worldMap[0].applyBounds();
						}
					});
				} catch (err){
					setTimeout(repeat, 100);
				}
			} else {
				setTimeout(repeat, 100);
			}
		})();
		// focus on player home
		var e = document.getElementById("land" + my.focusTile);
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
		console.info('worldMap ', worldMap[0]);
		TweenMax.to('#worldWrap', .5, {
			x: x * g.resizeX,
			y: y * g.resizeY
		});
		$(e).trigger("mousedown");
	}).fail(function(data){
		serverError();
	}).always(function(){
		g.unlock();
	});
}
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
		startClassOn: "btn btn-info btn-md btn-block btn-responsive shadow4",
		startClassOff: "btn btn-default btn-md btn-block btn-responsive shadow4"
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
					if (!x.gameStarted){
						document.getElementById('mainWrap').style.display = "block";
					}
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

