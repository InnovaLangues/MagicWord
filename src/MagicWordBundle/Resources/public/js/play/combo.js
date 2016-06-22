var combo = {
	newIds: [],
	previousIds: [],
	currentComboLength: 0,
	currentComboLemmas: [],

	handleNewIds: function(callback){
		var increment = false;
		if (this.currentComboLemmas.length === 0) {
			//ajout des nouveaux lemmes dans currentcombos
			for (var i = this.newIds.length; i--;) {
				this.currentComboLemmas.push(this.newIds[i]);
			}
			this.currentComboLength = 1;
			increment = true;
		} else {
			// suppression dans current combos des lemmes qui ne font pas partie des nouveaux lemmes.
			for (var i = this.currentComboLemmas.length; i--;) {
				if ($.inArray(this.currentComboLemmas[i],this.newIds) == -1) {
					this.currentComboLemmas.splice(i,1);
				} else if (!increment) {
					increment = true;
					this.currentComboLength++;
				}
			}
		}

		if(!increment){
			// combo terminé
			if (this.currentComboLength > 1) {
				$("#combo").hide("explode", {pieces: 16 }, 300);
				objectiveCombo.checkObjectives(this.currentComboLength);
			}

			this.currentComboLength = 0;

			//ptete un nouveau combo est commencé
			for (var i = this.previousIds.length; i--;) {
				if ($.inArray(this.previousIds[i],this.newIds) != -1) {
					increment = true;
					this.currentComboLength = 2;
				}
			}
		}

		// ajout des nouveaux lemmes dans currentcombos
		for (var i = this.newIds.length; i--;) {
			if ($.inArray(this.newIds[i], this.currentComboLemmas) == -1) {
				this.currentComboLemmas.push(this.newIds[i]);
				if (!increment) {
					this.currentComboLength = 1;
				}
			}
		}

		this.showCombo();
	},

	handleNewInflection: function(inflection){
		this.previousIds = this.newIds;
		this.newIds = gridJSON.inflections[inflection.toLowerCase()].lemmaIds;
		this.handleNewIds();

		return;
	},

	showCombo: function(){
		if (this.currentComboLength > 1) {
			$("#combo").show();
			$("#combo-count").html(this.currentComboLength).show();
		} else {
			$("#combo").hide();
		}
	}


}
