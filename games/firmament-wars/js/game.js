// game.js
function showTarget(e, hover){
	if (typeof e === 'object'){
		var tileId = e.id.slice(4)*1;
		// console.info('tileId: ', tileId);
		var d = game.tiles[tileId];
		if (!hover){
			my.tgt = tileId;
		}
		if (hover && tileId !== my.tgt){
			// animate targetLine
			var e = document.getElementById('unit' + tileId);
			my.targetLine[4] = e.getAttribute('x')*1;
			my.targetLine[5] = e.getAttribute('y')*1;
			my.targetLine[2] = (my.targetLine[0] + my.targetLine[4]) / 2;
			my.targetLine[3] = ((my.targetLine[1] + my.targetLine[5]) / 2) - 100;
			TweenMax.set(DOM.targetLineShadow, {
				visibility: 'visible',
				attr: {
					d: "M " + my.targetLine[0] +","+ my.targetLine[1] + " "
							// " Q " + my.targetLine[2] +" "+ (my.targetLine[3] + 150) + " " 
							+ my.targetLine[4] +","+ my.targetLine[5]
				}
			});
			TweenMax.set(DOM.targetLine, {
				visibility: 'visible',
				attr: {
					d: "M " + my.targetLine[0] +","+ my.targetLine[1] + 
						" Q " + my.targetLine[2] +" "+ my.targetLine[3] + " " 
						+ my.targetLine[4] +" "+ my.targetLine[5]
				}
			});
			
			TweenMax.fromTo([DOM.targetLine, DOM.targetLineShadow], .2, {
				strokeDashoffset: 0
			}, {
				strokeDashoffset: -24,
				repeat: -1,
				ease: Linear.easeNone
			});
			// crosshair
			TweenMax.set(DOM.targetCrosshair, {
				fill: game.tiles[tileId].player === my.player ? '#aa0000' : '#00cc00',
				visibility: 'visible',
				x: my.targetLine[4] - 255,
				y: my.targetLine[5] - 257,
				transformOrigin: '50% 50%'
			})
			TweenMax.fromTo(DOM.targetCrosshair, .2, {
				scale: .1
			}, {
				repeat: -1,
				yoyo: true,
				scale: .08
			});
		}
		// tile data
		var t = game.tiles[tileId];
		var flag = "",
			nation = "",
			account = "";
		if (t.player === 0){
			flag = "Player0.jpg";
			if (t.units > 0){
				nation = "Barbarian Tribe";
			} else {
				nation = "Uninhabited";
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
		
		var str = 
			'<div id="tileInfo" class="shadow4">';
			if (t.capital){
				str += 
				'<span id="tile-name" class="no-select text-center shadow4 fwTooltip" data-toggle="tooltip" title="Capitals have a 30% defense bonus">\
					<i class="fa fa-fort-awesome text-warning shadow4"></i>\
				</span> ';
			}
			str += 
				'<span class="fwTooltip" data-toggle="tooltip" title="' + t.food + ' food in ' + t.name + '"> <i class="food glyphicon glyphicon-apple" ></i> ' + t.food + '</span> \
				<span class="fwTooltip" data-toggle="tooltip" title="' + t.culture + ' culture in ' + t.name + '"><i class="culture fa fa-flag" data-toggle="tooltip"></i> ' + t.culture + '</span>\
			</div>'+
			'<img src="images/flags/' + flag + '" class="p' + t.player + 'b w100 block center">'+
			'<div id="nation-ui" class="shadow4">' + nation + '</div>';
		DOM.target.innerHTML = str;
		// actions panel
		setActionButtons(t);
	} else {
		my.attackOn = false;
	}
}
function setActionButtons(t){
	function checkEnergy(val){
		return val <= my.production ? 'text-success' : 'text-danger';
	}
	var str = '<div id="tile-name" class="no-select text-center shadow4">' + t.name + '</div>';
	// start tileActions table
		str += '<div id="tileActions" class="table-responsive ">\
					<table class="table borderless">';
			// action buttons
			if (my.player === t.player){
				str += 
				'<tr id="attack" class="actionButtons shadow4 stagBlue2 nowrap">\
					<td style="width: 8%"><i class="fa fa-check ' + checkEnergy(7) + ' text-center pointer"></i></td>\
					<td style="width: 66%">Attack</td>\
					<td style="width: 8%"><i class="fa fa-bolt production pointer"></i></td>\
					<td style="width: 18%" class="text-right">7</td>\
				</tr>\
				<tr id="splitAttack" class="actionButtons shadow4 stagBlue2 nowrap">\
					<td><i class="fa fa-check ' + checkEnergy(3) + ' text-center pointer"></i></td>\
					<td>Split Attack</td>\
					<td><i class="fa fa-bolt production pointer"></td>\
					<td class="text-right">3</td>\
				</tr>\
				<tr id="deploy" class="actionButtons shadow4 stagBlue2 nowrap">\
					<td><i class="fa fa-check ' + checkEnergy(20) + ' text-center pointer"></i></td>\
					<td>Deploy</td>\
					<td><i class="fa fa-bolt production pointer"></td>\
					<td class="text-right">20</td>\
				</tr>';
			}
		str += '</table><div>';
	DOM.actions.innerHTML = str;
	$('.fwTooltip').tooltip({
		delay: {
			show: 0,
			hide: 0
		}
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
		if (!g.over){
			$.ajax({
				type: "GET",
				url: "php/getGameState.php"
			}).done(function(data){
				// console.info('server lag: ' + (Date.now() - lag), data.delay, data);
				var start = Date.now();
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
						// animate other players' attacks
						if (d.player !== my.player){
							var box = e1.getBBox();
							box.units = d.units;
							animate.explosion(box);
						}
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
				// report chat messages
				var len = data.chat.length;
				if (len > 0){
					for (var i=0; i<len; i++){
						chat(data.chat[i].message);
					}
				}
				// check eliminated players; remove from panel
				(function(p, len){
					for (var i=0; i<len; i++){
						if (p[i].account){
							if (!data.player[i]){
								game.player[i].account = '';
								console.info('players: ', $(".diplomacyPlayers").length);
								if ($(".alive").length > 1){
									$("#diplomacyPlayer" + i).removeClass('alive');
									TweenMax.to('#diplomacyPlayer' + i, 1, {
										autoAlpha: 0
									});
								}
							}
						}
					}
				})(game.player, game.player.length);
				// remove dead players
				(function(count){
					// game over?
					for (var i=0, len=data.player.length; i<len; i++){
						if (i){
							if (data.player[i]){
								count++;
							}
						}
					}
					if (!g.over){
						if (!data.player[my.player]){
							gameDefeat();
						} else if (count === 1){
							gameVictory();
						}
					}
				})(0);
				// console.info('client lag: ', Date.now() - start);
			}).fail(function(data){
				console.info(data.responseText);
				serverError();
			}).always(function(data){
				setTimeout(repeat, repeatDelay);
			});
		}
	})();
	
	(function(){
		var start = Date.now();
		setInterval(function(){
			if (!g.over){
				$.ajax({
					type: "GET",
					url: "php/updateResources.php"
				}).done(function(data){
					console.info('resource: ', (Date.now() - start), data.get, data);
					setResources(data);
					if (data.cultureMsg !== undefined){
						if (data.cultureMsg){
							chat(data.cultureMsg);
						}
					}
				}).fail(function(data){
					console.info(data.responseText);
					serverError();
				});
			}
		}, 5000);
	})();
}
function gameDefeat(){
	$.ajax({
		type: "GET",
		url: "php/gameDefeat.php"
	}).done(function(data){
		if (data.gameDone){
			var msg = 
			'<p>Defeat!</p>'+
			'<div>Your campaign for world domination has failed!</div>'+
			'<div id="endWar">'+
				'<div class="modalBtnChild">Concede Defeat</div>'+
			'</div>';
			triggerEndGame(msg);
			// playAudio('defeat');
		}
	}).fail(function(data){
		serverError();
	});
}

function gameVictory(){
	$.ajax({
		type: "GET",
		url: "php/gameVictory.php"
	}).done(function(data){
		if (data.gameAbandoned){
			var msg = 
			'<p>Armistice!</p>'+
			'<div>The campaign has been suspended!</div>'+
			'<div id="endWar">'+
				'<div class="modalBtnChild">End War</div>'+
			'</div>';
			triggerEndGame(msg);
			// playAudio('victory');
		} else if (data.gameDone){
			var msg = 
			'<p>Congratulations!</p>'+
			'<div>Your campaign for global domination has succeeded!</div>'+
			'<div id="endWar">'+
				'<div class="modalBtnChild">End War</div>'+
			'</div>';
			triggerEndGame(msg);
			// playAudio('victory');
		}
	}).fail(function(data){
		serverError();
	});
}
function triggerEndGame(msg){
	$("*").off('click mousedown keydown keup, keypress')
	g.over = 1;
	setTimeout(function(){
		var e = document.getElementById('victoryScreen');
		e.innerHTML = msg;
		e.style.display = 'block';
		$("#endWar").on('mousedown', function(){
			location.reload();
		});
	}, 2500);
}