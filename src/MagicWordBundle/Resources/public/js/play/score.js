var score = {
    totalSelector: "#score-total",
    total : 0,
    calculatePoints: function(inflection){
		var points = 0;
		// point des lettres
		var letters = inflection.toLowerCase().split("");
		for (var i = 0; i < letters.length; i++) {
			points += letterPoints[letters[i]];
		}
		//point des mots
		if (wordLengthPoints[letters.length] !== undefined) {
			points += wordLengthPoints[letters.length];
		} else {
			points += wordLengthPoints[wordLengthPoints.length - 1];
		}

        this.updateTotal(points);

		return points;
	},

    updateTotal: function(points){
        this.total += points;
        $(this.totalSelector).html(this.total);
    }
}
