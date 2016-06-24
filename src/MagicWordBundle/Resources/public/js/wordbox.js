function addToWordbox(lemmaId, btn)
{
    btn.remove();
    wait.start("Ajout dans la wordbox");
    var url = Routing.generate('add-to-wordbox-js', {id: lemmaId});
    $.ajax({
        type: 'POST',
        url: url,
     }).done(function(data) {
         wait.stop();
     });;
}
