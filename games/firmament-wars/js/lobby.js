(function(){
	$("#mainWrap").on("click", "#cancelGame", function(){
		g.lock(1);
		$.ajax({
			type: "GET",
			url: 'php/exitGame.php'
		}).done(function(data) {
			g.view = "title";
			var tl = new TimelineMax();
			tl.to("#joinGameLobby", .5, {
				scale: 1.02,
				autoAlpha: 0,
				onComplete: function(){
					g.unlock(1);
				}
			}).to("#titleMain", .5, {
				scale: 1,
				autoAlpha: 1
			});
		}).fail(function(e){
			Msg(e.statusText);
			g.unlock(1);
		});
	});
})();