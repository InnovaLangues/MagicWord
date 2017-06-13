var modalHandler = {
    createModale: function(id, title, content){
        if (document.getElementById(id) === null) {
            var html = '<div class="modal fade" id="'+ id +'" tabindex="-1" role="dialog">';
            html += '<div class="modal-dialog modal-lg">';
            html += '<div class="modal-content">';
            html += '<div class="modal-header">';
            html += '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
            html += '<h4 class="modal-title"></h4>';
            html += '</div>';
            html += '<div class="modal-body">';
            html += '</div>';
            html += '<div class="modal-footer">';
            html += '<button type="button" class="btn btn-default" data-dismiss="modal">'+ Translator.trans('close'); +'</button>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';

            $("body").append(html);
        }

        $("#"+id).find(".modal-title").html(Translator.trans(title));
        $("#"+id).find(".modal-body").html(content);
        $('#'+id).modal('show');

        return;
    },
}
