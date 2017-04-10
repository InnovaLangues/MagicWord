var objectives = {
    remove: function(btn){
        btn.closest('li').remove();
    },

    save: function(){
        if(editor.isFormValid("objectives")){
            wait.start("Sauvegarde des objectifs");
            var url = Routing.generate('save_objectives', {id: $('#conquerId').val()});
            var data = $("#objectives").serializeArray();

            $.ajax({
                  type: 'POST',
                  url: url,
                  data: data,
              })
              .done(function(data) {
                  wait.stop();
              });
        } else {
            info.display("Un ou plusieurs objectifs ne sont correctement remplis");
        }
    }
}
