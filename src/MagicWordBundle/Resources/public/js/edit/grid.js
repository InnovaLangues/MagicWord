var gridHandler = {
    getLanguage: function(){
        return $("#gridLanguageId").val();
    },

    autofill: function(){
        wait.start("Remplissage automatique de la grille");
        var language = $('#languageId').val();
        var url = Routing.generate('get_letters', {
            id: language
        });
        $.ajax({
              type: 'POST',
              url: url,
         })
         .done(function(data) {
             var data = data;
             $("input[name='squares[]']").each(function( index ) {
                 if ($(this).val() == "" || $(this).val() == "-" || $(this).val() == "_") {
                     $(this).val(data[index]);
                 }
             });
             wait.stop();
         });
    },

    save: function(){
        if(editor.isFormValid("grid")){
            wait.start("Sauvegarde de la grille");
            var data = $("#grid").serializeArray();
            var url = Routing.generate('conquer_save_grid', {id: $('#conquerId').val()});
            $.ajax({
                  type: 'POST',
                  url: url,
                  data: data,
             })
             .done(function(data) {
                 $("#foundables").html(data.foundables);
                 $("#gridLanguageId").val(data.gridLanguage);
                 roundHandler.checkConsistency();
                 wait.stop();
             });
         } else {
             alert("La grille n'est pas remplie");
         }
    },

    generate: function(){
        if ($(".findWord").length > 0) {
            var word_list = [];
            $(".findWord").each(function( index ) {
                var inflection = $(this).find(findwords.inflectionSelector).val();
                if (inflection.indexOf("?") == -1) {
                    word_list.push(inflection);
                }
            });

            var time = 1000;
            var generator = Generator();
            var best = new generator(4, word_list, time).run();

            var x = 0;
            for (var i = best.grid.length - 1; i >= 0; i--) {
                for (var j = best.grid[i].length - 1; j >= 0; j--) {
                    $("#square-"+x).val(best.grid[i][j]);
                    x++;
                };
            };
            findwords.checkInsertedWords(best.insertedWords);
        } else {
            info.display("Au moins une forme doit être renseignée afin de générer la grille.");
        }
    }
};
