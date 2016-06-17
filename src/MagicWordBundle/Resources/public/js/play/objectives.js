var objectives = {
    done: 0,
    doable: 0,

    considerAsDone: function(objectiveId){
        this.done++;
        $(".objective-"+objectiveId).addClass("list-group-item-success");
	},
}
