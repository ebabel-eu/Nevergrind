function initResources(d){
	my.food = d.food;
	my.production = d.production;
	my.culture = d.culture;
	// current
	DOM.production.textContent = d.production;
	DOM.food.textContent = d.food;
	DOM.culture.textContent = d.culture;
	// turn
	// max
	DOM.manpower.textContent = my.manpower;
	my.manpower = d.manpower;
	DOM.foodMax.textContent = d.foodMax;
	DOM.cultureMax.textContent = d.cultureMax;
	// sum
	DOM.sumFood.textContent = d.sumFood;
	DOM.sumProduction.textContent = d.turnProduction;
	DOM.sumCulture.textContent = d.sumCulture;
	// bonus values
	DOM.oBonus.textContent = d.oBonus;
	DOM.dBonus.textContent = d.dBonus;
	DOM.turnBonus.textContent = d.turnBonus;
	DOM.foodBonus.textContent = d.foodBonus;
	DOM.cultureBonus.textContent = d.cultureBonus;
	setBars(d);
}
function setProduction(d){
	TweenMax.to(my, .3, {
		production: d.production,
		ease: Quad.easeIn,
		onUpdate: function(){
			DOM.production.textContent = ~~my.production;
		},
		onComplete: function(){
			if (game.tiles[my.tgt].player === my.player){
				setActionButtons(game.tiles[my.tgt]);
			}
		}
	});
}
function setResources(d){
	setProduction(d);
	TweenMax.to(my, .3, {
		food: d.food,
		culture: d.culture,
		ease: Quad.easeIn,
		onUpdate: function(){
			DOM.food.textContent = ~~my.food;
			DOM.culture.textContent = ~~my.culture;
		}, 
		onComplete: function(){
			if (game.tiles[my.tgt].player === my.player){
				setActionButtons(game.tiles[my.tgt]);
			}
		}
	});
	if (d.manpower > my.manpower){
		TweenMax.fromTo('#manpower', .5, {
			color: '#ffaa33'
		}, {
			color: '#ffff00',
			repeat: -1,
			yoyo: true
			
		});
		TweenMax.to(my, .5, {
			manpower: d.manpower,
			onUpdate: function(){
				DOM.manpower.textContent = ~~my.manpower;
			}
		});
	}
	if (d.foodMax !== undefined){
		if (d.foodMax > my.foodMax){
			DOM.foodMax.textContent = d.foodMax;
			my.foodMax = d.foodMax;
		}
			
		if (d.cultureMax > my.cultureMax){
			DOM.cultureMax.textContent = d.cultureMax;
			my.cultureMax = d.cultureMax;
		}
	}
	if (d.sumFood !== undefined){
		if (d.sumFood !== my.sumFood){
			DOM.sumFood.textContent = d.sumFood;
			my.sumFood = d.sumFood;
		}
		if (d.sumProduction !== my.sumProduction){
			DOM.sumProduction.textContent = d.sumProduction;
			my.sumProduction = d.sumProduction;
		}
		if (d.sumCulture !== my.sumCulture){
			DOM.sumCulture.textContent = d.sumCulture;
			my.sumCulture = d.sumCulture;
		}
	}
	// bonus values
	if (d.oBonus !== undefined){
		if (my.oBonus !== d.oBonus){
			DOM.oBonus.textContent = d.oBonus;
			my.oBonus = d.oBonus;
		}
		if (my.dBonus !== d.dBonus){
			DOM.dBonus.textContent = d.dBonus;
			my.dBonus = d.dBonus;
		}
		if (my.turnBonus !== d.turnBonus){
			DOM.turnBonus.textContent = d.turnBonus;
			my.turnBonus = d.turnBonus;
		}
		if (my.foodBonus !== d.foodBonus){
			DOM.foodBonus.textContent = d.foodBonus;
			my.foodBonus = d.foodBonus;
		}
		if (my.cultureBonus !== d.cultureBonus){
			DOM.cultureBonus.textContent = d.cultureBonus;
			my.cultureBonus = d.cultureBonus;
		}
	}
	setBars(d);
}
function setBars(d){
	// animate bars
	TweenMax.to(DOM.foodBar, .3, {
		width: ((d.food / d.foodMax) * 100) + '%'
	});
	TweenMax.to(DOM.cultureBar, .3, {
		width: ((d.culture / d.cultureMax) * 100) + '%'
	});
}

function Nation(){
	this.account = "";
	this.nation = "";
	this.flag = "";
	return this;
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
		console.info('initGameState ', data);
		my.player = data.player;
		TweenMax.set(DOM.targetLine, {
			stroke: color[my.player]
		});
		TweenMax.set(DOM.targetLine, {
			stroke: "hsl(+=0%, +=80%, +=25%)"
		});
		
		
		my.flag = data.flag;
		my.nation = data.nation;
		my.foodMax = data.foodMax;
		my.production = data.production;
		my.turnProduction = data.turnProduction;
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
				capital: data.capitalTiles.indexOf(i) > -1 && d.flag ? true : false,
				units: d.units,
				food: d.food,
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
					'<div id="diplomacyPlayer' + p.player + '" class="diplomacyPlayers alive">';
							if (my.player === p.player){
								str += '<i id="surrender" class="fa fa-flag pointer" data-placement="right" data-toggle="tooltip" title="Surrender"></i>';
							} else {
								str += '<i class="fa fa-flag surrender"></i>';
							}
							str += '<i class="fa fa-stop diplomacySquare player' + p.player + ' data-toggle="tooltip" title="Player Color""></i>' +
							'<img src="images/flags/Player' + p.player + '.jpg" class="player' + p.player + ' inlineFlag diploFlag" data-toggle="tooltip" title="'+ p.account + '"><span class="diploNames" data-toggle="tooltip" title="'+ p.nation + '">' + p.nation + '</span>';
				} else {
					str += 
					'<div id="diplomacyPlayer' + p.player + '" class="diplomacyPlayers alive">';
							if (my.player === p.player){
								str += '<i id="surrender" class="fa fa-flag pointer"  data-placement="right" data-toggle="tooltip" title="Surrender"></i>';
							} else {
								str += '<i class="fa fa-flag surrender"></i>';
							}
							str += '<i class="fa fa-stop diplomacySquare player' + p.player + '" data-toggle="tooltip" title="Player Color"></i>' +
							'<img src="images/flags/' + p.flag + '" class="inlineFlag diploFlag" data-toggle="tooltip" title="'+ p.account + '"><span class="diploNames" data-toggle="tooltip" title="'+ p.nation + '">' + p.nation + '</span>';
				}
				str += '</div>';
			}
		}
		
		document.getElementById('diplomacy-ui').innerHTML = str;
		$('[data-toggle="tooltip"]').tooltip({
			delay: {
				show: 0,
				hide: 0
			}
		});
		// SVG mouse events
		if (isMSIE || isMSIE11){
			$(".land").on("click", function(){
				if (my.attackOn){
					action.attackTile(this);
				} else {
					showTarget(this);
				}
			});
		} else {
			$(".land").on("mousedown", function(){
				console.info(this.id);
				if (my.attackOn){
					action.attackTile(this);
				} else {
					showTarget(this);
				}
			});
		}
		$(".land").on("mouseenter", function(){
			my.lastTarget = this;
			if (my.attackOn){
				showTarget(this, true);
			}
			TweenMax.set(this, {
				fill: "hsl(+=0%, +=30%, +=15%)"
			});
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
		TweenMax.to('#worldWrap', .5, {
			force3D: false,
			x: x * g.resizeX,
			y: y * g.resizeY
		});
		initResources(data); // setResources(data);
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
					lobbyCountdown();
				} else if (!x.hostFound){
					Msg("The host has left the lobby.");
					setTimeout(function(){
						exitGame(true);
					}, 500);
					// TODO: remove game when done testing
				} else if (g.view === "lobby"){
					if (!g.over){
						setTimeout(repeat, 1000, lobby);
					}
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
		$.ajax({
			type: "GET",
			url: "php/startGame.php"
		}).done(function(data){
			console.info(data);
			g.unlock();
			lobbyCountdown();
		}).fail(function(data){
			serverError();
		}).always(function(){
			g.unlock();
		});
	} else {
		
	}
}
function lobbyCountdown(){
	var loadTime = Date.now() - g.startTime; 
	if (loadTime < 1000){
		joinStartedGame(); // page refresh
	} else {
		// normal countdown
		var e = document.getElementById('countdown');
		e.style.display = 'block';
		(function repeat(secondsToStart){
			e.textContent = "Starting game in " + secondsToStart--;
			if (secondsToStart >= 0){
				setTimeout(repeat, 1000, secondsToStart);
			}
			if (secondsToStart === 1){
				TweenMax.to('#mainWrap', 2.5, {
					alpha: 0,
					ease: Power3.easeIn,
					onComplete: function(){
						joinStartedGame();
					}
				});
			}
		})(5);
	}
}