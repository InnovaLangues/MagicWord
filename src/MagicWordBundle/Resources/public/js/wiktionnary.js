var wiktionnary = {
    modaleGenerated: false,
    getDef: function(lemma, language){
        var url = Routing.generate('wiktionnary', {lemma: lemma, language: language});
        $('#wiktionnary-body').empty();
        $.ajax({
            type: "GET",
            url: url,
            success: function (html) {
                wiktionnary.displayDef(html, lemma);
            }
        });
    },

    displayDef: function(def, lemma){
        if (this.modaleGenerated == false) {
            wiktionnary.createModale();
        }
        $('#wiktionnary-title').html(lemma);
        $('#wiktionnary-body').html(def);
        $('#wiktionnary').modal('show');
    },

    createModale: function(){
        var html = '<div class="modal fade" id="wiktionnary" tabindex="-1" role="dialog">';
        html += '<div class="modal-dialog">';
        html += '<div class="modal-content">';
        html += '<div class="modal-header">';
        html += '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        html += '<h4 class="modal-title">'+ Translator.trans('definition') +' <strong id="wiktionnary-title"></strong></h4>';
        html += '</div>';
        html += '<div id="wiktionnary-body"  class="modal-body">';
        html += '</div>';
        html += '<div class="modal-footer">';
        html += '<button type="button" class="btn btn-default" data-dismiss="modal">'+ Translator.trans('close'); +'</button>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';

        wiktionnary.modaleGenerated == true;
        $("body").append(html);

        return;
    }
}
