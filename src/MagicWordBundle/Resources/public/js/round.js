var roundHandler = {
    init: function(){
        this.checkConsistency();
    },
    getLanguage: function(){
        return $("#languageId").val();
    },
    saveMisc: function(){
        wait.start("Sauvegarde des infos");
        var url = Routing.generate('save_misc', {id: $('#roundId').val()});
        var data = $("#round-misc").serializeArray();

        $.ajax({
              type: 'POST',
              url: url,
              data: data,
          })
          .done(function(data) {
              $("#round-title").html(data.title);
              $("#round-description").html(data.descr);
              $("#languageId").val(data.language);

              roundHandler.checkConsistency();
              wait.stop();
         });
    },
    checkConsistency: function(){
        var roundLanguage = this.getLanguage();
        var gridLanguage = gridHandler.getLanguage();

        if (gridLanguage !== "" && gridLanguage != roundLanguage) {
            $('#language-inconsistency').show();
        } else {
            $('#language-inconsistency').hide();
        }
    }
}

$(function() {
    roundHandler.init();
});
