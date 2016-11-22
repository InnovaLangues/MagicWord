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
                $('#wiktionnary-body').html(html);
                $('#wiktionnary').modal('show');
            }
        });
    }
}
