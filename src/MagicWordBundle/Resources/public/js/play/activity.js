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
			  	activity.populate(data.infos, data.combopoints);
			  }
			  callback();
          });
	},

	populate: function(infos, combopoints){
		for (var i = 0; i < infos.foundForms.length; i++) {
			var found = JSON.parse(infos.foundForms[i]);
			if(roundJSON.type != "conquer") score.calculatePoints(found.form);
			words.addToFoundWords(found.form, true);
		}

		if(combopoints != 0) score.updateTotal(combopoints);

		for (var i = 0; i < infos.objectivesDone.length; i++) {
			var objective = JSON.parse(infos.objectivesDone[i]);
			objectives.considerAsDone(objective.id);
		}
	},

    sendFoundWord: function(inflection){
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

	sendWrongWord: function(inflection){
		var roundId = roundJSON.id;
		var form = inflection.toLowerCase();
		var url = Routing.generate('add_wrongForm', {roundId: roundId, form: form});
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

	sendComboPoints: function(length){
        var roundId = roundJSON.id;
		var url = Routing.generate('add_combopoints', {roundId: roundId, length: length});

		$.ajax({
              type: 'POST',
              url: url,
              dataType: "json",
          })
		  .done(function(data) {
             score.updateTotal(data.points);
			 combo.displayPoints(data.points, length);
          });
	},

	sendComboFinished: function(length){
        var roundId = roundJSON.id;
		var url = Routing.generate('save_combo_finished', {roundId: roundId, length: length});

		$.ajax({
              type: 'POST',
              url: url,
              dataType: "json",
          });
	},

	end: function(time){
		combo.endCombo(combo.currentComboLength);
		wait.start("Fin de la manche");
		setTimeout(function(){
			var url = Routing.generate('round_end', {id: roundJSON.id});
			location.href= url;
		}, 1500);
	}
}
