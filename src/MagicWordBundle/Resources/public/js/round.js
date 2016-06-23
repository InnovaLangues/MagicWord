function saveMisc(){
    wait.start("Sauvegarde des infos");
    var url = Routing.generate('save_misc', {id: $('#roundId').val()});
    var data = $("#round-misc").serializeArray();

    $.ajax({
          type: 'POST',
          url: url,
          data: data,
      })
      .done(function(data) {
          wait.stop();
      });
}
