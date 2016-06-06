var combo = {
	lemmaIds: [],
	newIds: [],
	currentCombos: [],
	savedCombos: [],
	minLengthTosave: 0,

	init: function(){
		for (var i = 0; i < roundJSON.combos.length; i++) {
            if (this.minLengthTosave == 0 || this.minLengthTosave > roundJSON.combos[i].length) {
                this.minLengthTosave = roundJSON.combos[i].length;
            }
		}
	},

	saveOrDestroy: function(callback){
		var i = this.currentCombos.length;
		while (i--) {
			var currentCombo = this.currentCombos[i];
			// cas où le lemme du combo n'est pas dans les lemmes courants
			if ($.inArray(currentCombo.lemmaId, this.newIds) == -1) {
				// si il a la taille requise on le sauvegarde
				if(currentCombo.count >= this.minLengthTosave){
					this.savedCombos.push(currentCombo);
				}
				// et dans tous les cas on l'enlève des combo courants
				var j = this.currentCombos.length;
				while (j--) {
					if( this.currentCombos[j].lemmaId == currentCombo.lemmaId) {

						this.currentCombos.splice(j,1);
					}
				}
			}
		}

		callback();
	},

	createOrIncrement: function(callback){
		for (var i = 0; i < this.newIds.length; i++) {
			var newId = this.newIds[i];
			var found = false;
			for (var j = 0; j < this.currentCombos.length; j++) {
				var currentCombo = this.currentCombos[j];
				if (currentCombo.lemmaId == newId) {
					currentCombo.count++;
					found = true;
				}
			}
			if(!found){
				this.currentCombos.push({lemmaId:newId, count:1, used:false});
			}
		}
		callback();
	},

	checkObjectives: function(){
		var combos = this.currentCombos.slice();
		var comboSaved = this.savedCombos.slice();

		for (var i = 0; i < roundJSON.combos.length; i++) {
            var objective = roundJSON.combos[i];
			var effectiveCount = 0;

			for (var j = 0; j < combos.length; j++) {
				var currentCombo = combos[j];
				if (currentCombo.count >= objective.length) {
					currentCombo.used = true;
					effectiveCount++;
				}
			}

			for (var j = 0; j < comboSaved.length; j++) {
				var currentCombo = comboSaved[j];
				if (currentCombo.count >= objective.length && !currentCombo.used) {
					effectiveCount++;
					currentCombo.used = true;
				}
			}

			if (effectiveCount >= objective.number){
				$("#objective-combo-"+objective.id).addClass("list-group-item-success");
				$("#objective-combo-"+objective.id).append(" +");
			}
		}
	},

	handleNewInflection: function(inflection){
		this.newIds = gridJSON.inflections[inflection.toLowerCase()].lemmaIds;
		this.createOrIncrement(function(){
			combo.saveOrDestroy(function(){
				combo.checkObjectives();
			});
		});

		return;
	}
}
