var objectiveCombo = {
	combosToDo: roundJSON.combos.sort(this.compare),
	combosRealized: [],

	checkObjectives: function(length, last){
		for (var i = this.combosToDo.length; i--;) {
			var objective = this.combosToDo[i];
			if (length >= objective.length) {
				this.combosRealized.push(objective.id);
				objectives.updateProgress(objective.id);
				if (last == true) {
					combo.newIds = [];
					combo.previousIds = [];
					combo.currentComboLength = 0;
					combo.currentComboLemmas = [];
				}

				if (this.countByObjective(objective.id) == objective.number) {
					objectives.considerAsDone(objective.id);
					this.combosToDo.splice(i, 1);
					activity.sendObjectiveDone(objective.id);
					break;
				}
			}
		}
	},

	checkLastObjective: function(){
		if (objectiveCombo.combosToDo.length == 1) {
			objectiveCombo.checkObjectives(combo.currentComboLength, true);
		}
	},

	compare: function (a,b) {
		if (a.length < b.length)
			return -1;
		if (a.length > b.length)
			return 1;

		return 0;
  	},

	countByObjective: function(objectiveId){
		var count = 0;
		for(var i = 0; i < this.combosRealized.length; ++i){
		    if(this.combosRealized[i] == objectiveId){
		    	count++;
			}
		}

		return count;
	}
}
