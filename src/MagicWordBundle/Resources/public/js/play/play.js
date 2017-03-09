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
});

window.addEventListener("resize", function(e) {
	grid.resize();
});

$(function () {
	if (!screenfull.enabled) {
		return false;
	}

	$('#fullscreen').click(function () {
		screenfull.toggle(window[0]);
	});


	function fullscreenchange() {
		var elem = screenfull.element;

		$('#status').text('Is fullscreen: ' + screenfull.isFullscreen);

		if (elem) {
			$('#element').text('Element: ' + elem.localName + (elem.id ? '#' + elem.id : ''));
		}

		if (!screenfull.isFullscreen) {
			$('#external-iframe').remove();
			document.body.style.overflow = 'auto';
		}
	}

	document.addEventListener(screenfull.raw.fullscreenchange, fullscreenchange);

	// set the initial values
	fullscreenchange();
});
