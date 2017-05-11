var clock = {
	start: roundJSON.type == "conquer" ? 0 : 120,
	countdown: roundJSON.type == "conquer" ? false : true,
	delta:0,

	init: function(){

		var startTime = roundJSON.type == "conquer"
			? this.start + this.delta
			: this.start - this.delta;


		if (startTime > 0 || roundJSON.type == "conquer") {
			var testClock = $('#clock').FlipClock( startTime, {
				countdown: clock.countdown,
				clockFace: 'MinuteCounter',
				language : 'french',
				callbacks: {
			        stop: function () {
				        activity.end(testClock.getTime().time);
			        }
				}
			});
		} else {
			activity.end(startTime);
		}
	}
}
