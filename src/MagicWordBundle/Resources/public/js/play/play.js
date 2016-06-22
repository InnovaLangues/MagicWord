$(document).ready(function () {
	wait.start("Initialisation de la partie");
	activity.init(function(){
		grid.draw();
		clock.init();
		wait.stop();
		$("#game-container").show();
	});
});
