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
			  if (data.delta != 0) {
			  	activity.populate(data.infos);
			  }
			  callback();
          });
	},

	populate: function(infos){
		for (var i = 0; i < infos.foundForms.length; i++) {
			var found = JSON.parse(infos.foundForms[i]);
			words.addToFoundWords(found.form, true, false);
		}

		for (var i = 0; i < infos.objectivesDone.length; i++) {
			var objective = JSON.parse(infos.objectivesDone[i]);
			switch (objective.type) {
				case "findword":
					findword.appendWord(objective.id, objective.content.inflection);
					break;
				case "combo":
					break;
				default:

			}
			objectives.considerAsDone(objective.id);
		}
	},

    sendFoundWord: function(inflection, points){
        var roundId = roundJSON.id;
        var inflection = inflection.toLowerCase();
		var foundableId = gridJSON.inflections[inflection].id;
		var url = Routing.generate('add_foundForm', {roundId: roundId, foundableId: foundableId});

		$.ajax({
              type: 'POST',
              url: url,
              dataType: "json",
          });
	},

	sendObjectiveDone: function(objectiveId){
        var roundId = roundJSON.id;
		var url = Routing.generate('add_objectiveDone', {roundId: roundId, objectiveId: objectiveId});

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
