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

	addToFoundWords: function(inflection, isCorrect, saveIt){
		var points = "";
		this.foundWords.push(inflection);
		inflection = inflection.toUpperCase();
		var typedInflection = (!isCorrect) ? "<s>"+inflection+"</s>" : inflection;

		if(isCorrect){
			points = score.calculatePoints(inflection);
			if (saveIt) {
				activity.sendFoundWord(inflection, points);
			}
			this.correctWords++;
			$("#correctWords-found").html(this.correctWords);
			//localstor.add(inflection);
		}

		$("#inflections-found").prepend("<li class='list-group-item'>"+typedInflection+"<span class='pull-right'>"+points+"</span></li>");
	},

	checkWord: function(){
		var inflection = grid.foundWord;

		if (!this.alreadyFound(inflection)) {
			if (this.inInflections(inflection)){
				var inWordsToFound = findword.inWordsToFound(inflection);
				this.addToFoundWords(inflection.toLowerCase(), true, true);
				combo.handleNewInflection(inflection);
			} else {
				this.addToFoundWords(inflection.toLowerCase(), false, true);
			}
		}
	},
};
