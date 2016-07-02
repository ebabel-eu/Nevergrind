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
$(document).on('keyup', function(e) {
	var x = e.keyCode;
	console.info(x);
	if (g.view === 'game'){
		if (x === 65){
			// attack
			action.attack();
		} else if (x === 27){
			my.attackOn = false;
			my.clearHud();
		} else if (x === 68){
			action.deploy();
		}
	}
});