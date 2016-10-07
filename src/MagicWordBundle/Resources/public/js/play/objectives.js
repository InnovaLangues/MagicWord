var objectives = {
    done: 0,
    doable: Object.keys(roundJSON.findWords).length + Object.keys(roundJSON.combos).length + Object.keys(roundJSON.constraints).length,
    score:0,

    considerAsDone: function(objectiveId){
        sound.objectiveProgress.play();
        this.done++;
        $(".objective-"+objectiveId).addClass("list-group-item-success");
        this.updateScore();
        this.checkCompletion();
	},

    checkCompletion: function(){
        if(this.done == this.doable){
            sound.objectiveDone.play();
            activity.end(0);
        }
    },

    updateScore: function(){
        this.score += Math.round(300 / this.doable);
        $("#obj-score").html(this.score);
    },

    updateProgress: function(objectiveId){
        $(".objective-"+objectiveId).find(".objective-progress").append("*");
    }
}
