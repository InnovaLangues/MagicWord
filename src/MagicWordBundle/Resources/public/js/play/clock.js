var clock = {
	start: roundJSON.type == "conquer" ? 0 : 120,
	countdown: roundJSON.type == "conquer" ? false : true,

	init: function(){
		var testClock = $('#clock').FlipClock( clock.start, {
			countdown: clock.countdown,
			clockFace: 'MinuteCounter',
			language : 'french',
			callbacks: {
		        stop: function () {
		        //var time = testClock.getTime().time;
		        }
			}
		});
	}
}
