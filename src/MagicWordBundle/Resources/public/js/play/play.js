$(document).ready(function () {
	sound.init();
	wait.start("Initialisation de la partie");
	activity.init(function(){
		grid.draw();
		if(roundJSON.type == "conquer") objectives.displayDone();
		clock.init();
		wait.stop();
		$("#game-container").show();
		grid.resize();
	});
});
