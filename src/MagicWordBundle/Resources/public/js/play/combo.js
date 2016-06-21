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
			$("#combo-count").html(this.currentComboLength);
			increment = true;
		} else {
			// suppression dans current combos des lemmes qui ne font pas partie des nouveaux lemmes.
			for (var i = this.currentComboLemmas.length; i--;) {
				if ($.inArray(this.currentComboLemmas[i],this.newIds) == -1) {
					this.currentComboLemmas.splice(i,1);
				} else if (!increment) {
					increment = true;
					this.currentComboLength++;
					$("#combo-count").html(this.currentComboLength);
				}
			}
		}

		if(!increment){
			// combo terminé
			if (this.currentComboLength > 1) {
				$("#combo-count").hide("explode", {pieces: 16 }, 300);
				objectiveCombo.checkObjectives(this.currentComboLength);
			}

			$("#combo-count").show("explode").html(0);
			this.currentComboLength = 0;

			//ptete un nouveau combo est commencé
			for (var i = this.previousIds.length; i--;) {
				if ($.inArray(this.previousIds[i],this.newIds) != -1) {
					increment = true;
					this.currentComboLength = 2;
					$("#combo-count").show().html(this.currentComboLength);
				}
			}
		}

		// ajout des nouveaux lemmes dans currentcombos
		for (var i = this.newIds.length; i--;) {
			if ($.inArray(this.newIds[i], this.currentComboLemmas) == -1) {
				this.currentComboLemmas.push(this.newIds[i]);
				if (!increment) {
					this.currentComboLength = 1;
					$("#combo-count").show().html(this.currentComboLength);
				}
			}
		}

		$("#combo-count").show().html(this.currentComboLength);
		/*

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
		*/
	},

	handleNewInflection: function(inflection){
		this.previousIds = this.newIds;
		this.newIds = gridJSON.inflections[inflection.toLowerCase()].lemmaIds;
		this.handleNewIds();

		return;
	}
}
