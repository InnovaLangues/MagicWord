$(document).ready(function () {
	wait.start("Initialisation de la partie");
	activity.init(function(){
		combo.init();
		grid.draw();
		clock.init();
		wait.stop();
		$("#game-container").show();
	});
});
