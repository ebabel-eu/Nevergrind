(function(){
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
			if (events.mouseZoom >= 300){
				events.mouseZoom = 300;
			} else {
				events.mouseZoom += 5;
				TweenMax.to("#world", .5, {
					transformOrigin: events.mouseTransX + "% " + events.mouseTransY + "%",
					force3D: false,
					smoothOrigin: true,
					scale: events.mouseZoom / 100,
					ease: Power2.easeOut,
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
				TweenMax.to("#world", .5, {
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
		function setMousePosition(e){
			var x = ~~((e.offsetX / events.mapSizeX) * 100);
			var y = ~~((e.offsetY / events.mapSizeY) * 100);
			events.mouseTransX = x;
			events.mouseTransY = y;
		}
		if (!isFirefox){
			$("body").on("mousewheel", function(e){
				setMousePosition(e);
				worldMap[0].applyBounds();
			});
		} else {
			$("body").on("DOMMouseScroll", function(e){
				setMousePosition(e);
				worldMap[0].applyBounds();
			});
		}
		$("#world").on("mousemove", function(e){
			setMousePosition(e);
		});
		var worldMap = Draggable.create("#world", {
			type: "x,y",
			bounds: "#gameWrap",
			dragResistance: .2,
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
	}
	initMapEvents();
})();