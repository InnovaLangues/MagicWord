var findword = {
    inWordsToFound: function(inflection){
        if (roundJSON.findWords.hasOwnProperty(inflection.toLowerCase())){
            var objectiveId = roundJSON.findWords[inflection.toLowerCase()].id;

            objectives.considerAsDone(objectiveId);
            this.appendWord(objectiveId, inflection);
            activity.sendObjectiveDone(objectiveId);
            return true;
        }

        return false;
    },

    appendWord: function(objectiveId, inflection){
        var str = ' ('+ inflection +')';
        $(".objective-"+objectiveId).append(str.toUpperCase());
    }
}
