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

	saveOrDestroy: function(){
		for (var i = 0; i < this.currentCombos.length; i++) {
			var currentCombo = this.currentCombos[i];
			// cas où le lemme du combo n'est pas dans les lemmes courants
			if ($.inArray(currentCombo.lemmaId, this.newIds) == -1) {
				// si il a la taille requise on le sauvegarde
				if(currentCombo.count >= this.minLengthTosave){
					this.savedCombos.push(currentCombo);
				}
				// et dans tous les cas on l'enlève des combo courants
				this.currentCombos.splice(i, 1);
			}
		}
	},

	createOrIncrement: function(){
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
				this.currentCombos.push({lemmaId:newId, count:1});
			}
		}
	},

	handleNewInflection: function(inflection){
		var ids = gridJSON.inflections[inflection.toLowerCase()].lemmaIds;
		this.newIds = ids;
		this.createOrIncrement();
		this.saveOrDestroy();

		return;
	}
}
