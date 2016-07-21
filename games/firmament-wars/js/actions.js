// actions.js
var action = {
	attack: function(skip){
		if (game.tiles[my.tgt].units < 2){
			Msg("You need at least two armies to attack!", 1.5);
			my.clearHud();
			return;
		}
		if (my.player === game.tiles[my.tgt].player){
			my.attackOn = true;
			my.hud(game.tiles[my.tgt].name + ": Select Target");
			$DOM.head.append('<style>.land{ cursor: crosshair; }</style>');
			
			var e = document.getElementById('unit' + my.tgt);
			my.targetLine[0] = e.getAttribute('x')*1;
			my.targetLine[1] = e.getAttribute('y')*1;
			if(!skip){
				showTarget(my.lastTarget, true);
			}
		}
	},
	attackTile: function(that){
		console.info('production: ', my.production);
		var attacker = my.tgt;
		var defender = that.id.slice(4)*1;
		if (my.tgt === defender){
			return;
		}
		if (game.tiles[defender].units >= 255){
			Msg("That territory has the maximum number of units!", 1.5);
			my.clearHud();
			return;
		}
		my.attackOn = false;
		if (game.tiles[my.tgt].units === 1){
			Msg("You need at least 2 armies to move/attack!", 1.5);
			my.clearHud();
			return;
		}
		if (my.production < 7){
			Msg("Not enough energy!", 1.5);
			my.clearHud();
			return;
		}
		g.lock(true);
		// send attack to server
		$.ajax({
			url: 'php/attackTile.php',
			data: {
				attacker: attacker,
				defender: defender
			}
		}).done(function(data) {
			if ('rewardMsg' in data){
				chat(data.rewardMsg);
			}
			if ('production' in data){
				setProduction(data);
			}
		}).fail(function(e){
			// playAudio("failNoise");
			Msg('You can only move/attack adjacent territories.', 1.5);
		}).always(function(){
			g.unlock();
		});
		// update mouse
		showTarget(that);
		// report attack message
		
		// report battle results
		my.clearHud();
	},
	deploy: function(){
		if (my.production < 20){
			Msg("Not enough energy!", 1.5);
			my.clearHud();
			return;
		}
		if (my.player === game.tiles[my.tgt].player && 
			my.manpower && 
			game.tiles[my.tgt].units <= 254){
			// determine number
			var deployedUnits = my.manpower < 12 ? my.manpower : 12;
			var rem = 0;
			if (game.tiles[my.tgt].units + deployedUnits > 255){
				rem = ~~((game.tiles[my.tgt].units + deployedUnits) - 255);
				deployedUnits = ~~(255 - game.tiles[my.tgt].units);
			} else {
				rem = my.manpower - deployedUnits;
			}
			game.tiles[my.tgt].units += deployedUnits;
			my.manpower = ~~rem;
			// do it
			DOM.manpower.textContent = my.manpower;
			setTileUnits(my.tgt, '#00ff00');
			g.lock(true);
			$.ajax({
				url: 'php/deploy.php',
				data: {
					deployedUnits: deployedUnits,
					target: my.tgt
				}
			}).done(function(data) {
				console.info("deploy: ", data);
				if ('production' in data){
					setProduction(data);
				}
			}).fail(function(e){
				// playAudio("failNoise");
			}).always(function(){
				g.unlock();
			});
		}
	}
}

$("#actions").on("mousedown", '#attack', function(){
	action.attack(true);
}).on('mousedown', '#deploy', function(){
	action.deploy();
});
// key bindings
function toggleChatMode(send){
		g.chatOn = g.chatOn ? false : true;
		console.info('CHAT', g.chatOn);
		if (g.chatOn){
			$DOM.chatInput.focus();
			DOM.chatInput.className = 'fw-text noselect nobg chatOn';
		} else {
			var message = $DOM.chatInput.val();
			if (send && message){
				// send ajax chat msg
				$.ajax({
					url: 'php/insertChat.php',
					data: {
						message: message
					}
				}).done(function(data) {
					console.info("data: ", data);
				});
			}
			$DOM.chatInput.val('').blur();
			DOM.chatInput.className = 'fw-text noselect nobg';
		}
		
}
$(document).on('keyup', function(e) {
	var x = e.keyCode;
	// console.info(x);
	if (g.view === 'title'){
		if (x === 13){
			if (g.focusUpdateNationName){
				$("#submitNationName").trigger("click");
			} else if (g.focusGameName){
				$("#createGame").trigger("click");
			}
		}
	} else if (g.view === 'game'){
		if (g.chatOn){
			if (x === 13){
				// enter - sends chat
				toggleChatMode(true);
			} else if (x === 27){
				// esc
				toggleChatMode(true);
			}
		} else {
			if (x === 65){
				// a
				action.attack();
			} else if (x === 27){
				// esc
				my.attackOn = false;
				my.clearHud();
				if (g.chatOn){
					toggleChatMode();
				}
			} else if (x === 68){
				// d
				action.deploy();
			} else if (x === 13){
				// enter
				toggleChatMode();
			}
		}
	}
});