var objectiveConstraint = {
    properties: ["category", "number", "gender", "person", "mood", "tense"],
    constraintRealized: [],
    add: function(inflection){
        var infos = gridJSON.inflections[inflection.toLowerCase()].infos;
        var incrementedObjs = [];
        for (var i = 0; i < infos.length; i++) {
            currentInflectionInfos = infos[i];
            for (var j = 0; j < roundJSON.constraints.length; j++) {
                var objective = roundJSON.constraints[j];
                if(this.isPertinent(objective, currentInflectionInfos)){
                    if ($.inArray(objective.id, incrementedObjs) == -1) {
                        objectives.updateProgress(objective.id);
                        this.constraintRealized.push(objective.id);
                        incrementedObjs.push(objective.id);
                        if(this.checkCompletion(objective)){
                            objectives.considerAsDone(objective.id);
                            activity.sendObjectiveDone(objective.id);
                        }
                    }

                }
            }
        }
    },

    countByObjective: function(objectiveId){
		var count = 0;
		for(var i = 0; i < this.constraintRealized.length; ++i){
		    if(this.constraintRealized[i] == objectiveId){
		    	count++;
			}
		}

		return count;
	},

    isPertinent: function(objective, infos){
        for (var i = 0; i < this.properties.length; i++) {
            var property = this.properties[i];
            if (objective[property] != null && objective[property] != infos[property]) {
                return false;
            };

        }

        return true;
    },

    checkCompletion: function(objective){
        if(this.countByObjective(objective.id) == objective.numberToFind){
            return true;
        }

        return false;
    }
}
