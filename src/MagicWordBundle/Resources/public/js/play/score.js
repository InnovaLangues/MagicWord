var score = {
    totalSelector: "#score-total",
    total : 0,
    calculatePoints: function(inflection){
        var points = gridJSON.inflections[inflection.toLowerCase()].points;
        this.updateTotal(points);

		return points;
	},

    updateTotal: function(points){
        this.total += points;
        $(this.totalSelector).html(this.total);
    }
}
