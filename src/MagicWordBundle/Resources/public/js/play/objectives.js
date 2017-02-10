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

        this.updateDone(type);
        sound.play(sound.objectiveProgress);
        this.done++;
        //objective.addClass("list-group-item-success");
        objective.hide();
        this.updateScore();
        this.checkCompletion();
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

    updateScore: function(){
        this.score += Math.round(300 / this.doable);
        $("#obj-score").html(this.score);
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
            objectives.disableAll();
            objectiveType.classList.add("active");
        }
    },

    disableAll: function(){
        var objs = document.getElementsByClassName('objectives');
        for (var i = 0; i < objs.length; ++i) {
            objs[i].classList.remove("active");
        }
    },
}
