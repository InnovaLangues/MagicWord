var findword = {
    inWordsToFound: function(inflection){
        if (roundJSON.findWords.hasOwnProperty(inflection.toLowerCase())){
            var findWordId = roundJSON.findWords[inflection.toLowerCase()].id;
            $("#objective-findword-"+findWordId).addClass("list-group-item-success").append(' ('+ inflection +')');

            return true;
        }

        return false;
    },
}
