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

	addToFoundWords: function(inflection, isCorrect){
		this.foundWords.push(inflection);

		if (isCorrect){
			var inflections = document.getElementById("inflections-found");
			var found = document.createElement("div");
			found.className = 'found-word';
			found.innerHTML = inflection.toUpperCase();
			inflections.insertBefore(found, inflections.firstChild);
		}

		return;
	},

	checkWord: function(){
		var inflection = grid.foundWord;
		var alreadyFound = this.alreadyFound(inflection);
		var isCorrect = this.inInflections(inflection);
		var points = 0;


		if (!this.alreadyFound(inflection)) {
			if (isCorrect){
				sound.play(sound.rightWord);
				points = score.calculatePoints(inflection);
				this.addToFoundWords(inflection.toLowerCase(), true);
				activity.sendFoundWord(inflection);

				if (roundJSON.type == "conquer") {
					findword.inWordsToFound(inflection);
					objectiveConstraint.add(inflection);
				}
				combo.handleNewInflection(inflection);
			} else {
				combo.reset();
				this.addToFoundWords(inflection.toLowerCase(), false);
				activity.sendWrongWord(inflection);
				sound.play(sound.wrongForm);
			}
		}
		this.displayFound(inflection, alreadyFound, isCorrect, points);

		return;
	},

	displayFound: function(inflection, alreadyFound, isCorrect, points){
		var toDisplay = document.getElementById("woot");
		toDisplay.innerHTML = inflection;
		toDisplay.className = (!isCorrect) ? "wrong-form" : "right-form";
		toDisplay.className += (alreadyFound) ? " alreadyfound-form" : "";

		if (isCorrect && !alreadyFound) {
			var pointsTag = document.createElement("sup");
			pointsTag.innerHTML = "+"+points;
			toDisplay.appendChild(pointsTag);
		}

		return;
	}
};
