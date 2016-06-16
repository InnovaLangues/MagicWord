var activity = {

	init: function(callback){
        var roundId = roundJSON.id;
        var url = Routing.generate('init_activity', {id: roundId});
        $.ajax({
              type: 'POST',
              url: url,
              dataType: "json",
          })
          .done(function(data) {
              clock.delta = data.delta;
			  callback();
          });
	},

    sendFoundWord: function(inflection, points){
        var roundId = roundJSON.id;
        var inflection = inflection.toLowerCase();
		var foundableId = gridJSON.inflections[inflection].id;
		var url = Routing.generate('add_foundForm', {roundId: roundId, foundableId: foundableId});
        var ids = gridJSON.inflections[inflection].ids;

		$.ajax({
              type: 'POST',
              url: url,
              dataType: "json",
          });
	},

	end: function(time){
		var url = Routing.generate('round_end', {id: roundJSON.id});
		location.href= url;
	}
}
