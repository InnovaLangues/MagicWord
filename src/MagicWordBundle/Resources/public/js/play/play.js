$(document).ready(function () {
	sound.init();
	wait.start("Initialisation de la partie");
	activity.init(function(){
		grid.draw();
		clock.init();
		wait.stop();
		$("#game-container").show();
		grid.resize();
	});

	$('#fullscreen').click(function () {
		screenfull.toggle(window[0]);
	});
});

window.addEventListener("resize", function(e) {
	grid.resize();
});
