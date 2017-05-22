$(document).ready(function () {
	game.displayModal();
	game.initEvent();
	sound.init();
	grid.draw();
	if(roundJSON.type == "conquer") objectives.displayDone();
});


var game = {
	displayModal: function(){
		$('#game-start-summary').modal('show');
	},
	start: function(){
		activity.init(function(){
			clock.init();
			$("#game-container").show();
			grid.resize();
		});
	},
	initEvent: function(){
		$('body').on("click touchstart", "#game-start", function(e){
			$('#game-start-summary').modal('hide');
				if (deviceSize.get() == 'xs') {
					screenfull.toggle(window[0]);
				}
				game.start();
		});
	}
}
