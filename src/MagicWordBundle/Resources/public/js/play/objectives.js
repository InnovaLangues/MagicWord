var objectives = {
    done: 0,
    doable: Object.keys(roundJSON.findWords).length + Object.keys(roundJSON.combos).length + Object.keys(roundJSON.constraints).length,
    score: 0,
    doneByType: {
        'combo':0,
        'findword':0,
        'constraint':0
    },
    toDoByType: {
        'combo': Object.keys(roundJSON.combos).length,
        'findword': Object.keys(roundJSON.findWords).length,
        'constraint': Object.keys(roundJSON.constraints).length
    },

    considerAsDone: function(objectiveId){
        var objective = $(".objective-"+objectiveId);
        var type = objective.data("type");

        if (objectives.doneByType[type] < objectives.toDoByType[type]) {
            this.updateDone(type);
            sound.play(sound.objectiveProgress);
            this.done++;
            objective.hide();
            this.checkCompletion();
            this.checkTypeCompletion(type);
        }

        document.getElementById("points").innerHTML = this.done + "/" + this.doable;
	},

    checkCompletion: function(){
        if(this.done == this.doable){
            sound.play(sound.objectiveDone);
            activity.end(0);
        }
    },

    updateDone:function(type){
        objectives.doneByType[type]++;
        document.getElementById(type+"-done").innerHTML = objectives.doneByType[type];
    },

    updateProgress: function(objectiveId){
        $(".objective-"+objectiveId).find(".objective-progress").append("*");
    },

    click: function(objectiveType){
        if (objectiveType.classList.contains("disabled")) {
            return;
        }

        if (objectiveType.classList.contains("active")) {
            return;
        } else {
            objectives.deactivateAll();
            objectiveType.classList.add("active");
        }
    },

    checkTypeCompletion: function(type){
        if (objectives.doneByType[type] >= objectives.toDoByType[type]) {
            objectives.disable(type);
            objectives.findActivable(type);
        }
    },

    deactivateAll: function(){
        $('.objectives').removeClass("active");
    },

    disable: function(type){
        $("[data-type='"+type+"']").addClass("disabled").removeClass("active");
    },

    findActivable: function(type){
        if (!$("[data-type='"+type+"']").hasClass("active")) {
            $(".objectives").not(".disabled").first().addClass("active");
        }

        return;
    }
}
