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
			$("#woot").hide().html(inflection).show(100).delay(1000).hide(100);
		}

		if(isCorrect){
			if (saveIt) {
				activity.sendFoundWord(inflection);
				sound.play(sound.rightWord);
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
				var inWordsToFound = findword.inWordsToFound(inflection);
				this.addToFoundWords(inflection.toLowerCase(), true, true, true);
				combo.handleNewInflection(inflection);
				if (roundJSON.type == "conquer") {
					objectiveConstraint.add(inflection);
				}
			} else {
				this.addToFoundWords(inflection.toLowerCase(), false, true, true);
				sound.wrongForm.play();
				combo.reset();
			}
		}
	},
};
