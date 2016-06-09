var words = {
	word: '',
	foundWords: [],

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

	addToFoundWords : function(inflection, inObjective, isCorrect){
		this.foundWords.push(inflection);
		inflection = inflection.toUpperCase();
		var typedInflection = (!isCorrect) ? "<s>"+inflection+"</s>" : inflection;
		$("#inflections-found").prepend("<li class='list-group-item'>"+typedInflection+"</li>");


		if(isCorrect){
			activity.sendFoundWord(inflection, 0);
			localstor.add(inflection);
		}

	},

	checkWord: function(){
		var inflection = grid.foundWord;

		if (!this.alreadyFound(inflection)) {
			if (this.inInflections(inflection)){
				var inWordsToFound = findword.inWordsToFound(inflection);
				this.addToFoundWords(inflection.toLowerCase(), inWordsToFound, true);
				combo.handleNewInflection(inflection);
			} else {
				this.addToFoundWords(inflection.toLowerCase(), false);
			}
		}
	},

};
