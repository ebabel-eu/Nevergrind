// actions.js
var action = {
	attack: function(){
		console.info('match? ', my.player, game.tiles[my.tgt].player);
		if (my.player === game.tiles[my.tgt].player){
			my.attackOn = true;
			my.hud(game.tiles[my.tgt].name + ": Select Target");
		$DOM.head.append('<style>.land{ cursor: crosshair; }</style>');
		}
	},
	attackTile: function(that){
		var attacker = my.tgt;
		var defender = that.id.slice(4);
		my.attackOn = false;
		// send attack to server
		console.info('Attacking: ', attacker, 'vs', defender);
		$.ajax({
			url: 'php/attackTile.php',
			data: {
				attacker: attacker,
				defender: defender
			}
		}).done(function(data) {
			console.info("data: ", data);
		}).fail(function(e){
			console.info("fail! ", e);
		});
		// update mouse
		showTarget(that);
		// report attack message
		
		// report battle results
		my.clearHud();
	},
	deploy: function(){
		if (my.player === game.tiles[my.tgt].player && my.manpower && game.tiles[my.tgt].units <= 254){
			my.manpower--;
			DOM.manpower.textContent = my.manpower;
			game.tiles[my.tgt].units++;
			setTileUnits(my.tgt, '#00ff00');
			showTarget(document.getElementById('land' + my.tgt));
			$.ajax({
				url: 'php/deploy.php',
				data: {
					target: my.tgt
				}
			}).done(function(data) {
				console.info("data: ", data);
			}).fail(function(e){
				console.info("fail! ", e);
			});
		}
	}
}

$("#actions").on("mousedown", '#attack', function(){
	action.attack();
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
				}).fail(function(e){
					console.info("fail! ", e);
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
			} else if (x === 13){
				// enter
				toggleChatMode();
			}
		}
	}
});