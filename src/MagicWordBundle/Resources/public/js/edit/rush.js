var rushEditor = {
    addword : function(){
        var wordList = document.getElementById("word-list");
        var wordTag = document.createElement("li");
        wordTag.className = "list-group-item";
        var input = document.createElement("input");
        input.type = "text";
        input.value = "";
        wordTag.appendChild(input);
        wordList.appendChild(wordTag);
    },

    generategrid: function(wordlist){
        $('#addword-modal').modal('toggle');
        wait.start("Génération de la grille");
        var wordlist = [];

        var ul = document.getElementById("word-list");
        var items = ul.getElementsByTagName("input");
        for (var i = 0; i < items.length; ++i) {
            var word = items[i].value;
            if (word.length != 0) {
                wordlist.push(word);
            }
        }

        var time = 1000;
        var generator = Generator();
        var best = new generator(4, wordlist, time).run();

        var x = 0;
        for (var i = best.grid.length - 1; i >= 0; i--) {
            for (var j = best.grid[i].length - 1; j >= 0; j--) {
                $("#square-"+x).val(best.grid[i][j]);
                x++;
            };
        };

        wait.stop();
    },

    savegrid: function(){
        if(editor.isFormValid("grid")){
            wait.start("Sauvegarde de la grille");
            var data = $("#grid").serializeArray();
            var url = Routing.generate('rush_save_grid', {id: $('#rushId').val()});
            $.ajax({
                  type: 'POST',
                  url: url,
                  data: data,
             })
             .done(function(data) {
                 wait.stop();
                 $("#foundables").html(data.foundables);
             });
         }
    },
};
