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

	addToFoundWords: function(inflection, isCorrect, saveIt, displayIt){
		var $woot = $("#woot");
		this.foundWords.push(inflection);
		inflection = inflection.toUpperCase();
		var typedInflection = inflection;

		if (!isCorrect){
			typedInflection = "<s>"+inflection+"</s>";
			$woot.removeClass("right-form").addClass("wrong-form");
		} else {
			$woot.removeClass("wrong-form").addClass("right-form");
		}

		if (displayIt) {
			if (isCorrect) {
				var points = score.calculatePoints(inflection);
				var pointsTag = document.createElement("sup");
				pointsTag.innerHTML = "+"+points;
			}
			$woot.html(typedInflection);
			$woot.append(pointsTag || null);
		}

		if(isCorrect){
			if (saveIt) {
				activity.sendFoundWord(inflection);
				//sound.play(sound.rightWord);
			}

			var found = document.createElement("div");
			found.className = 'found-word';
			found.innerHTML = inflection;
			$("#inflections-found").prepend(found);
		} else {
			activity.sendWrongWord(inflection);
		}

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
