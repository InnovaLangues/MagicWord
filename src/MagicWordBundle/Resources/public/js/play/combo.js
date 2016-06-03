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

	checkCurrentCombos: function(){
		for (var i = 0; i < this.currentCombos.length; i++) {
			var currentCombo = this.currentCombos[i];
			if ($.inArray(currentCombo, this.newIds) == -1) {
				// le combo est fini.
				// voire pour le stocker ou pas.
			}

		}

		/*
		for (var i = 0; i < roundJSON.combos.length; i++) {


			var comboToCheck = roundJSON.combos[i];
			var length = comboToCheck.length;
			var number = comboToCheck.number;
			var found = 0;

			for (var i = 0; i < this.currentCombos.length; i++) {
				var currentCombo = this.currentCombos[i];
				if (currentCombo.count >= length) {
					found++;
				}
			}

			if (found >= number) {


		}
		*/
	},

	delete: function(){

	},

	createOrIncrementCombo: function(){
		console.log(this.newIds);
		for (var i = 0; i < this.newIds.length; i++) {
			var newId = this.newIds[i];
			console.log("traitement de "+newId );
			var found = false;
			for (var j = 0; j < this.currentCombos.length; j++) {
				var currentCombo = this.currentCombos[j];
				if (currentCombo.lemmaId == newId) {
					currentCombo.count++;
					console.log("increment combo pour lemma "+newId+" : "+currentCombo.count);
					found = true;
				}
			}
			if(!found){
				console.log("creation combo pour lemma "+newId+" : 1");
				this.currentCombos.push({lemmaId:newId, count:1});
			}
		}
	},

	handleNewInflection: function(inflection){
		var ids = gridJSON.inflections[inflection.toLowerCase()].lemmaIds;
		this.newIds = ids;

		this.createOrIncrementCombo();

		this.checkCurrentCombos();

		return;
	}
}
