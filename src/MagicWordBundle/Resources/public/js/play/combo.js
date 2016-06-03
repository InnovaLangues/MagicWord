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

		for (var i = 0; i < this.currentCombos.length; i++) {
			var currentCombo = this.currentCombos[i];

			// cas où le lemme du combo n'est pas dans les lemmes courants
			if ($.inArray(currentCombo.lemmaId, this.newIds) == -1) {
				// si il a la taille requise on le sauvegarde
				if(currentCombo.count >= this.minLengthTosave){
					this.savedCombos.push(currentCombo);
				}
				// et dans tous les cas on l'enlève des combo courants
				for( j=this.currentCombos.length-1; j>=0; j--) {
    				if( this.currentCombos[j].lemmaId == currentCombo.lemmaId) this.currentCombos.splice(j,1);
				}
				console.log("still a removing pb of current combos");
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
				this.currentCombos.push({lemmaId:newId, count:1});
			}
		}
		callback();
	},

	checkObjectives: function(){
		for (var i = 0; i < roundJSON.combos.length; i++) {
            var objective = roundJSON.combos[i];
			var effectiveCount = 0;
			for (var j = 0; j < this.currentCombos.length; j++) {
				var currentCombo = this.currentCombos[j];
				if (currentCombo.count >= objective.length) {
					effectiveCount++;
				}
			}

			for (var j = 0; j < this.savedCombos.length; j++) {
				var currentCombo = this.savedCombos[j];
				if (currentCombo.count >= objective.length) {
					effectiveCount++;
				}
			}

			if (effectiveCount >= objective.number){
				$("#objective-combo-"+objective.id).addClass("list-group-item-success");
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
