var findwords = {
    inflectionSelector: "input[data-field='inflection']",

    checkInsertedWords: function(insertedWords){
        $(".findWord").removeClass("list-group-item-danger list-group-item-success");
        $(".findWord").each(function( index ) {
            var inflection = $(this).find(findwords.inflectionSelector).val();
            var className = jQuery.inArray(inflection, insertedWords) != -1
                ? "list-group-item-success"
                : "list-group-item-danger";

             $(this).addClass(className);
         });
    },

    addWord: function(){
        var words = $('#words');
        var objective = words.data('prototype');
        var length = $(".findWord").length;
        objective = objective.replace(/__name__/g, length);
        words.append(objective);

        return length;
    },

    addInflection: function(inflection){
        var length = findwords.addWord();
        $("#round_findWords_"+ length +"_inflection").val(inflection);
    },

    checkExistence: function(input){
        var inflection = input.val();
        if(inflection != ""){
            var language = $('#languageId').val();
            var url = Routing.generate('check_existence', {
                id: language
            });

            $.ajax({
                  type: 'POST',
                  url: url,
                  dataType: "json",
                  data: { inflection: inflection }
              })
              .done(function(data) {
                  if (data.id) {
                    input.val(data.cleanedContent);
                  } else {
                    input.val(inflection +" ??");
                  }
              });
        }
    }
};

$(document).on( "blur", findwords.inflectionSelector, function(){
    findwords.checkExistence($(this));
});
