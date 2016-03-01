var events = {
	mouseZoom: 100,
	mouseTransX: 50,
	mouseTransY: 50,
	mapSizeX: 1868,
	mapSizeY: 931
};
// events
(function(){
	$(window).on('load resize orientationchange', function() {
		resizeWindow();
	});
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
			fill: "#880000"
		});
	}).on("mouseleave", function(){
		TweenMax.to($(this).get(0), .25, {
			fill: "#002255"
		});
	}).on("click", function(e){
		console.info($(this).data("name"));
	});
	// map zooming and scrolling
	function mouseZoomIn(e){
		if (events.mouseZoom >= 300){
			events.mouseZoom = 300;
		} else {
			events.mouseZoom += 10;
			TweenMax.to("#world", 1, {
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
		var x = events.mouseTransX;
		if (events.mouseZoom <= 80){
			events.mouseZoom = 80;
		} else {
			events.mouseZoom -= 5;
			TweenMax.set("#world", {
				force3D: false,
				smoothOrigin: true,
				transformOrigin: events.mouseTransX + "% " + events.mouseTransY + "%",
				scale: events.mouseZoom / 100
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
	
	if (!isFirefox){
		$("body").on("mousewheel", function(){
			worldMap[0].applyBounds();
		});
	} else {
		$("body").on("DOMMouseScroll", function(){
			worldMap[0].applyBounds();
		});
	}
	$("#world").on("mousemove", function(e){
		var x = ~~((e.offsetX / events.mapSizeX) * 100);
		var y = ~~((e.offsetY / events.mapSizeY) * 100);
		events.mouseTransX = x;
		events.mouseTransY = y;
	});
	var worldMap = Draggable.create("#world", {
		type: "x,y",
		bounds: "#game",
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
	$("#logout").on('click', function() {
		logout();
	});
	$("#toggleNation").on("click", function(){
		var e = document.getElementById("configureNation");
		var s = e.style.visibility;
		e.style.visibility = s === "hidden" || !s ? "visible" : "hidden";
	});
	$("#flagDropdown").on("change", function(e){
		var x = $(this).val() === "Nepal" ? "nepal.png" : $(this).val().toLowerCase() + ".jpg";
		$("#updateNationFlag").attr("src", "images/flags/" + x)
			.css("display", "block");
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
	$(".wars").on("click", function(){
		console.info($(this).data("id"));
	});
})();