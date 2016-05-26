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
        var language = $('#language-select').val();
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
              if (data.id ) {
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
    var results = "";
    //var time = document.getElementById("time").value;
    var time = 1000;
    var generator = Generator();
    var best = new generator(4, word_list, time).run();
    results += "<table class='table table-bordered'>";
    for (var i = best.grid.length - 1; i >= 0; i--) {
        results += "<tr>";
        for (var j = best.grid[i].length - 1; j >= 0; j--) {
            results += "<td>";
            results += '<input type="text" name="squares[]" size="1" maxlength="1" value="' + best.grid[i][j] + '" pattern="[A-Za-z]"/>';
            results += "</td>";
        };
        results += "</tr>";
    };
    results += "</table>";
    results += "<button class='btn btn-primary' type='submit'>Save the grid</button>";

    results += "<br/>";
    results += best.total;
    results += " mots/";
    results += word_list.length;

    results += "<br/>";
    results += best.candidateCount + " générations de grille en " + time + " ms";

    document.getElementById('result').innerHTML = results;
}
