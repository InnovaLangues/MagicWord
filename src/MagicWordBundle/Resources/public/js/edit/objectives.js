var objectives = {
    remove: function(btn){
        btn.closest('li').remove();
    },

    save: function(callback){
        if(editor.isFormValid("objectives")){
            wait.start("Sauvegarde des objectifs");
            var url = Routing.generate('save_objectives', {id: $('#conquerId').val()});
            var data = $("#objectives").serializeArray();

            $.ajax({
                  type: 'POST',
                  url: url,
                  data: data,
              })
              .done(function() {
                  if (typeof callback === "function") {
                      callback();
                  } else {
                       wait.stop();
                  }
              });
        } else {
            alert("Un ou plusieurs objectifs ne sont correctement remplis");
            if (typeof callback === "function") {
                callback();
            }
        }
    }
}
