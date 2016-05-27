$( document ).on( "blur", ".word", function(){
    checkExistence($(this));
});

$( document ).on( "click", ".word-remove", function(){
    removeWord($(this));
});

function addRequiredWord()
{
    var words = document.getElementById('words');
    var word = '<li class="list-group-item">'
            + '<input required type="text" class="word" pattern="[A-Za-z]+" value="" />'
            + '<input required type="text" class="def" value="" />'
            + '<span class="pull-right">'
            + '<span class="btn btn-default">'
            + '<i class="fa fa-wikipedia-w" aria-hidden="true"></i>'
            + '</span> '
            + '<span class="btn btn-danger word-remove">'
            + '<i class="fa fa-times" aria-hidden="true"></i>'
            + '</span>'
            + '</span>'
            + '</li>';
    words.insertAdjacentHTML('beforeend', word);
}

function removeWord(word)
{
    word.closest('li').remove();
}

function checkExistence(input)
{
    var inflection = input.val();

    if(inflection != ""){
        var language = $('#languageId').val();
        var url = Routing.generate('check_existence', {
            id: language
        });

        $.ajax({
              type: 'POST',
              url: url,
              dataType: "json",
              data: { inflection: inflection }
          })
          .done(function(data) {
              if (data.id) {
                input.val(data.cleanedContent);
              } else {
                input.val(input.val()+" ??");
              }
          });
      }
}

function getInflections()
{
    $("#inflections-icon").addClass("fa-spin");
    var url = Routing.generate('get_inflections');
    var data = $("#grid").serializeArray();

    $.ajax({
          type: 'POST',
          url: url,
          data: data,
      })
      .done(function(data) {
          $("#inflections").html(data);
          $("#inflections-icon").removeClass("fa-spin");
      });
}

function generate()
{
    var words = document.querySelectorAll(".word");
    var word_list = [];
    for (var i = words.length - 1; i >= 0; i--) {
        word_list.push(words[i].value);
    };

    var time = 1000;
    var generator = Generator();
    var best = new generator(4, word_list, time).run();

    var x = 0;
    for (var i = best.grid.length - 1; i >= 0; i--) {
        for (var j = best.grid[i].length - 1; j >= 0; j--) {
            $("#square-"+x).val(best.grid[i][j]);
            x++;
        };
    };

    return;
}


function save(){
    var data = $("#grid").serializeArray();
    var url = Routing.generate('conquer_save_grid', {id: $('#conquerId').val()});
    $.ajax({
          type: 'POST',
          url: url,
          data: data,
     })
     .done(function(data) {
         $("#inflections").html(data);
     });
}
