function addToWordbox(lemmaId)
{
    var url = Routing.generate('add-to-wordbox-js', {id: lemmaId});
    $.ajax({
          type: 'POST',
          url: url,
      });
}
