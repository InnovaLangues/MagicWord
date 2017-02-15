var words = {
	word: '',
	foundWords: [],
	correctWords: 0,

	inInflections: function(inflection){
		var inInflections = gridJSON.inflections.hasOwnProperty(inflection.toLowerCase())
			? true
			: false;

		return inInflections;
	},

	alreadyFound: function(inflection){
		var found = $.inArray(inflection.toLowerCase(), this.foundWords) == -1
			? false
			: true;

		return found;
	},

	addToFoundWords: function(inflection, isCorrect, saveIt, woot){
		var points = "";
		this.foundWords.push(inflection);
		inflection = inflection.toUpperCase();
		var typedInflection = inflection;

		if (!isCorrect){
			typedInflection = "<s>"+inflection+"</s>";
			$("#woot").removeClass("right-form").addClass("wrong-form");
		} else {
			$("#woot").removeClass("wrong-form").addClass("right-form");
		}

		if (woot) {
			$("#woot").html(inflection);
		}

		if(isCorrect){
			if (saveIt) {
				activity.sendFoundWord(inflection);
				//sound.play(sound.rightWord);
			}
			this.correctWords++;
			$("#correctWords-found").html(this.correctWords);
			points = score.calculatePoints(inflection);
		} else {
			activity.sendWrongWord(inflection);
		}

		$("#inflections-found").prepend("<li class='list-group-item'>"+typedInflection+"<span class='pull-right'>"+points+"</span></li>");
	},

	checkWord: function(){
		var inflection = grid.foundWord;

		if (!this.alreadyFound(inflection)) {
			if (this.inInflections(inflection)){
				this.addToFoundWords(inflection.toLowerCase(), true, true, true);
				if (roundJSON.type == "conquer") {
					findword.inWordsToFound(inflection);
					objectiveConstraint.add(inflection);
				}
				combo.handleNewInflection(inflection);
			} else {
				combo.reset();
				this.addToFoundWords(inflection.toLowerCase(), false, true, true);
				//sound.play(sound.wrongForm);
			}
		}
	},
};
