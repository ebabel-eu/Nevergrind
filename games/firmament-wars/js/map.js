(function(){
	(function repeat(){
		// delayed to allow svg to load
		if ($("#world").length > 0){
			try {
				worldMap = Draggable.create("#world", {
					type: "left,top",
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
	function initMapEvents(){
		var events = {
			mouseZoom: 100,
			mouseTransX: 50,
			mouseTransY: 50,
			mapSizeX: 2000,
			mapSizeY: 1001
		}
		// map zooming and scrolling
		function mouseZoomIn(e){
			if (events.mouseZoom >= 150){
				events.mouseZoom = 150;
			} else {
				events.mouseZoom += 5;
				TweenMax.to("#world", .5, {
					transformOrigin: events.mouseTransX + "% " + events.mouseTransY + "%",
					force3D: false,
					smoothOrigin: true,
					scale: events.mouseZoom / 100,
					onUpdate: function(){
						worldMap[0].applyBounds();
					}, 
					onComplete: function(){
						worldMap[0].applyBounds();
					}
				});
			}
		}
		
		function mouseZoomOut(e){
			if (events.mouseZoom <= 100){
				events.mouseZoom = 100;
			} else {
				events.mouseZoom -= 5;
				TweenMax.to("#world", .25, {
					force3D: false,
					smoothOrigin: true,
					transformOrigin: events.mouseTransX + "% " + events.mouseTransY + "%",
					scale: events.mouseZoom / 100,
					onUpdate: function(){
						worldMap[0].applyBounds();
					}, 
					onComplete: function(){
						worldMap[0].applyBounds();
					}
				});
			}
			worldMap[0].applyBounds();
		}
		
		if (!isFirefox){
			$("#world").on("mousewheel", function(e){
				e.originalEvent.wheelDelta > 0 ? mouseZoomIn(e) : mouseZoomOut(e);
				worldMap[0].applyBounds();
			});
		} else {
			$("#world").on("DOMMouseScroll", function(e){
				e.originalEvent.detail > 0 ? mouseZoomOut(e) : mouseZoomIn(e);
				worldMap[0].applyBounds();
			});
		}
		function setMousePosition(X, Y){
			var x = ~~((X / events.mapSizeX) * 100);
			var y = ~~((Y / events.mapSizeY) * 100);
			events.mouseTransX = x;
			events.mouseTransY = y;
		}
		if (!isFirefox){
			$("body").on("mousewheel", function(e){
				setMousePosition(e.offsetX, e.offsetY);
				worldMap[0].applyBounds();
			});
		} else {
			$("body").on("DOMMouseScroll", function(e){
				setMousePosition(e.originalEvent.layerX, e.originalEvent.layerY);
				worldMap[0].applyBounds();
			});
		}
		
		$("#world").on("mousemove", function(e){
			if (isFirefox){
				setMousePosition(e.originalEvent.layerX, e.originalEvent.layerY);
			} else {
				setMousePosition(e.offsetX, e.offsetY);
			}
		});
	}
	initMapEvents();
	
	$("#quitGame").on("click", function(){
		console.info("quitGame!");
		exitGame();
	});
	$("#game-ui").on("click", function(){
		console.info("UI!");
	});
	$("#battle").on("click", function(){
		console.info("battle!");
	});
})();