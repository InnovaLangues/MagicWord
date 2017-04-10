var combo = {
    add: function(){
        var combos = $('#combos');
        var combo = combos.data('prototype');
        combo = combo.replace(/__name__/g, $(".combo").length);
        combos.append(combo);
    },

    get: function(){
        if(editor.isFormValid("grid")){
            $('#helper-combos').modal('hide');
            wait.start("Récupération des combos");
            var url = Routing.generate('get_combos');
            var data = $("#grid").serializeArray();

            $.ajax({
                  type: 'POST',
                  url: url,
                  data: data,
              })
              .done(function(data) {
                  $("#possible-combos").html(data);
                  wait.stop();
                  $('#helper-combos').modal('show');
              });
        } else {
            info.display("La grille doit être entièrement remplie.");
        }
    }
}
