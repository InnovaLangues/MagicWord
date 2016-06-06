var words = {
	word: '',
	foundWords: [],

	inWordsToFound: function(inflection){
		if (roundJSON.findWords.hasOwnProperty(inflection.toLowerCase())){
		 	var findWordId = roundJSON.findWords[inflection.toLowerCase()].id;
			$("#objective-findword-"+findWordId).addClass("list-group-item-success").append(' ('+ inflection +')');

			return true;
		}

		return false;
	},

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
			localstor.add(inflection);
		}

	},

	checkWord: function(){
		var inflection = grid.foundWord;

		if (!this.alreadyFound(inflection)) {
			if (this.inInflections(inflection)){
				var inWordsToFound = this.inWordsToFound(inflection);
				this.addToFoundWords(inflection.toLowerCase(), inWordsToFound, true);
				combo.handleNewInflection(inflection);
			} else {
				this.addToFoundWords(inflection.toLowerCase(), false);
			}
		}
	},

};
