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
	$(".land").on("mouseenter", function(){
		TweenMax.set($(this).get(0), {
			fill: "#888800"
		});
	}).on("mouseleave", function(){
		TweenMax.to($(this).get(0), .25, {
			fill: "#002255"
		});
	}).on("click", function(e){
		console.info($(this).data("name"));
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
		
		console.info("CLICK: "+gameId);
	});
	
	$("#refreshGames").on("click", function(){
		refreshGames();
	}).trigger("click");
	
	$("#create").on("click", function(){
		var x = 
		"<div id='createGameWrap'>" +
			"<form class='form-horizontal'>" +
				"<div class='form-group'>" +
					'<label for="gameName" class="col-xs-3 control-label">Game Name:</label>' +
					"<div class='col-xs-9'>" +
						'<input id="gameName" class="form-control" type="text" maxlength="32" autocomplete="off" size="24">' +
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
				joinLobby();
				var e = document.getElementById("joinGameLobby");
				e.innerHTML = data;
			}).fail(function(e){
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
			joinLobby();
			var e = document.getElementById("joinGameLobby");
			e.innerHTML = data;
		}).fail(function(e){
			Msg(e.statusText);
		}).always(function(){
			g.unlock();
		});
	}
	
	(function(){
		g.lock();
		$.ajax({
			type: "GET",
			url: 'php/initGame.php'
		}).done(function(data) {
			console.info(data);
			if (data*1 > 0){
				joinLobby(0);
			} else {
				document.getElementById("titleMain").style.visibility = "visible";
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
		(function repeat(){
			if (g.view === "lobby"){
				$.ajax({
					type: "GET",
					url: "php/updateLobby.php"
				}).done(function(data){
					document.getElementById("joinGameLobby").innerHTML = data;
					if (g.view === "lobby"){
						setTimeout(repeat, 2000);
					}
					var e = $("#joinGameLobby");
					var h = e.height();
					var y = ~~((((768 - h) /2) / 768) * 100);
					TweenMax.set(e, {
						bottom: y + '%'
					});
				}).fail(function(data){
					serverError();
				});
			}
		})();
	}
	
	function animateNationName(){
		/*
		tl.to('#nationName', 1, {
			scrambleText: {
				text: nation.name,
				chars: "lowerCase",
				ease: Linear.easeNone
			}
		});
		*/
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
	// playMusic("WaitingBetweenWorlds");
	
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