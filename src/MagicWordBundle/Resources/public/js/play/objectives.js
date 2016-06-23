var objectives = {
    done: 0,
    doable: Object.keys(roundJSON.findWords).length + Object.keys(roundJSON.combos).length,
    score:0,

    considerAsDone: function(objectiveId){
        this.done++;
        $(".objective-"+objectiveId).addClass("list-group-item-success");
        this.updateScore();
        this.checkCompletion();
	},

    checkCompletion: function(){
        if(this.done == this.doable){
            activity.end(0);
        }
    },

    updateScore: function(){
        this.score += 300 / this.doable;
        $("#obj-score").html(this.score);
    }
}
