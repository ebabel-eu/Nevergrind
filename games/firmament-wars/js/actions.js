// actions.js
var action = {
	attack: function(skip){
		if (my.production < 7){
			Msg("Not enough energy!", 1.5);
			my.clearHud();
			return;
		}
		if (game.tiles[my.tgt].units < 2){
			Msg("You need at least two armies to attack!", 1.5);
			my.clearHud();
			return;
		}
		if (my.player === game.tiles[my.tgt].player){
			my.attackOn = true;
			my.splitAttack = false;
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
	splitAttack: function(skip){
		if (my.production < 3){
			Msg("Not enough energy!", 1.5);
			my.clearHud();
			return;
		}
		if (game.tiles[my.tgt].units < 2){
			Msg("You need at least two armies to split attack!", 1.5);
			my.clearHud();
			return;
		}
		if (my.player === game.tiles[my.tgt].player){
			my.attackOn = true;
			my.splitAttack = true;
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
		var attacker = my.tgt;
		var defender = that.id.slice(4)*1;
		if (my.tgt === defender){
			return;
		}
		// can't move to maxed friendly tile
		if (game.tiles[defender].player === my.player){
			if (game.tiles[defender].units >= 255){
				Msg("That territory has the maximum number of units!", 1.5);
				my.clearHud();
				return;
			}
		}
		my.attackOn = false;
		if (game.tiles[my.tgt].units === 1){
			Msg("You need at least 2 armies to move/attack!", 1.5);
			my.clearHud();
			return;
		}
		if ((my.production < 7 && !my.splitAttack) ||
			(my.production < 3 && my.splitAttack)
		){
			Msg("Not enough energy!", 1.5);
			my.clearHud();
			return;
		}
		g.lock(true);
		// animate attack
		if (game.tiles[defender].player !== my.player){
			var e1 = document.getElementById('land' + defender),
				box = e1.getBBox();
			box.units = game.tiles[attacker].units;
			animate.explosion(box);
		}
		// send attack to server
		$.ajax({
			url: 'php/attackTile.php',
			data: {
				attacker: attacker,
				defender: defender,
				split: my.splitAttack ? 1 : 0
			}
		}).done(function(data) {
			console.info('attackTile', data);
			if (data.rewardMsg !== undefined){
				chat(data.rewardMsg);
			}
			if (data.production !== undefined){
				setProduction(data);
			}
		}).fail(function(e){
			// playAudio("failNoise");
			Msg('You can only attack adjacent territories.', 1.5);
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
			TweenMax.set('#manpower', {
			  color: '#fff'
			});
		}
	}
}

var animate = {
	explosion: function(box){
		var explosions = box.units !== undefined ?
			15 + ~~(box.units / 5) :
			20;
		function randomColor(){
			var x = ~~(Math.random()*7),
				c = '#ffffff';
			if (x === 0){
				c = '#ffffff';
			} else if (x === 1){
				c = '#ffff88';
			} else if (x === 2){
				c = '#ffff55';
			} else if (x === 3){
				c = '#ff8855';
			} else if (x === 4){
				c = '#ffbb55';
			} else if (x === 5){
				c = '#ff0000';
			} else {
				c = '#ffddbb';
			}
			return c;
		}
		for (var i=0; i<explosions; i++){
			(function(){
				var circ = document.createElementNS("http://www.w3.org/2000/svg","circle");
				var x = box.x + (Math.random() * (box.width * .8)) + box.width * .1;
				var y = box.y + (Math.random() * (box.height * .8)) + box.height * .1;
				circ.setAttributeNS(null,"cx",x);
				circ.setAttributeNS(null,"cy",y);
				circ.setAttributeNS(null,"r",.01);
				circ.setAttributeNS(null,"fill","none");
				circ.setAttributeNS(null,"stroke",randomColor());
				circ.setAttributeNS(null,"strokeWidth","0");
				document.getElementById("world").appendChild(circ);
				
				var tl = new TimelineMax({delay: Math.random()*.5}); 
				tl.to(circ, .1, {
				  strokeWidth: 15
				}).to(circ, .2, {
				  strokeWidth: 0,
				  attr: {
					r: 15
				  },
				  onComplete: function(){
					circ.parentNode.removeChild(circ);  
				  }
				});
			})();
		}
	}
}

$("#actions").on("mousedown", '#attack', function(){
	action.attack(true);
}).on('mousedown', '#deploy', function(){
	action.deploy();
}).on('mousedown', '#splitAttack', function(){
	action.splitAttack(true);
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
	console.info(x);
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
			} else if (x === 83){
				// s
				action.splitAttack();
			} else if (x === 13){
				// enter
				toggleChatMode();
			}
		}
	}
});