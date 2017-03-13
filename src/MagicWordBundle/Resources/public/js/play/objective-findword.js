var findword = {
    inWordsToFound: function(inflection){
        var inflectionLower = inflection.toLowerCase();
        if (roundJSON.findWords.hasOwnProperty(inflectionLower)){
            this.found(roundJSON.findWords[inflectionLower], inflection);
            return true;
        } else {
            var lemmaIds = gridJSON.inflections[inflectionLower].lemmaIds;
            for (var i = 0; i < lemmaIds.length; i++) {
                for (var key in roundJSON.findWords) {
                    if (!roundJSON.findWords.hasOwnProperty(key)) continue;
                    var findword = roundJSON.findWords[key];
                    if($.inArray(lemmaIds[i],findword.lemmaIds) != -1 ){
                        this.found(findword, inflection);
                        break;
                    }
                }
            }
        }

        return false;
    },

    found: function(objective, inflection){
        objectives.considerAsDone(objective.id);
        activity.sendObjectiveDone(objective.id);
    }
}
