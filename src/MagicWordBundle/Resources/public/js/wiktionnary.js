var wiktionnary = {
    getDef: function(lemma){
        var language = $("#language").val();
        var url = Routing.generate('wiktionnary', {lemma: lemma, language: language});
        $('#wiktionnary-body').empty();
        $('#wiktionnary-title').html(lemma);
        $.ajax({
            type: "GET",
            url: url,
            success: function (html) {
                var def = "";
                if (language == "fr") {
                    if(html.match(/<span[\s\S]+?id="fr"[\s\S]*?(<ol>[\s\S]*?<\/ol>)/)) {
                        def = RegExp.$1;
                    } else {
                        def = "Oups...";
                    }
                } 
                $('#wiktionnary-body').html(def);
                $('#wiktionnary').modal('show');
            }
        });

    }
}
