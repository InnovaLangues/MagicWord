var wiktionnary = {
    currentLemma: "",
    getDef: function(lemma){
        this.currentLemma = lemma;
        var def = "";
        var language = "fr";
        var url = Routing.generate('wiktionnary', {lemma: lemma});

        $.ajax({
            type: "GET",
            url: url,
            success: function (html) {
                if (language == "fr") {
                    if(html.match(/<span[\s\S]+?id="fr"[\s\S]*?(<ol>[\s\S]*?<\/ol>)/)) {
                        page = RegExp.$1;
                    }
                } else {
                    if(html.match(/(<ol>[\s\S]*?<\/ol>)/)){
                        page = RegExp.$1;
                    }
                }
                $('#wiktionnary-title').html(wiktionnary.currentLemma);
                $('#wiktionnary-body').html(page);
                $('#wiktionnary').modal('show');
            }
        });

    }
}
