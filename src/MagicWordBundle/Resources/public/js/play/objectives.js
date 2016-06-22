var objectives = {
    done: 0,
    doable: Object.keys(roundJSON.findWords).length + Object.keys(roundJSON.combos).length,

    considerAsDone: function(objectiveId){
        this.done++;
        $(".objective-"+objectiveId).addClass("list-group-item-success");
        this.checkCompletion();
	},

    checkCompletion: function(){
        if(this.done == this.doable){
            activity.end(0);
        }
    }
}
