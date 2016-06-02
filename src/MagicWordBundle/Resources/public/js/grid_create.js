var inflectionSelector = "input[data-field='inflection']";

$( document ).on( "blur", inflectionSelector, function(){
    checkExistence($(this));
});

$( document ).on( "click", ".word-remove", function(){
    removeWord($(this));
});

function addWord()
{
    var words = $('#words');
    var objective = words.data('prototype');
    objective = objective.replace(/__name__/g, $(".findWord").length);
    words.append(objective);
}

function addCombo()
{
    var combos = $('#combos');
    var combo = combos.data('prototype');
    combo = combo.replace(/__name__/g, $(".combo").length);
    combos.append(combo);
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
                input.val(inflection +" ??");
              }
          });
      }
}

function saveObjectives()
{
    var url = Routing.generate('save_objectives', {id: $('#conquerId').val()});
    var data = $("#objectives").serializeArray();

    $.ajax({
          type: 'POST',
          url: url,
          data: data,
      })
      .done(function(data) {
      });
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

function getCombos()
{
    $("#combos-icon").addClass("fa-spin");
    var url = Routing.generate('get_combos');
    var data = $("#grid").serializeArray();

    $.ajax({
          type: 'POST',
          url: url,
          data: data,
      })
      .done(function(data) {
          $("#possible-combos").html(data);
          $("#combos-icon").removeClass("fa-spin");
      });
}


function generate()
{
    var word_list = [];
    $(".findWord").each(function( index ) {
        var inflection = $(this).find(inflectionSelector).val();
        if (inflection.indexOf("?") == -1) {
            word_list.push(inflection);
        }
    });

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
    checkInsertedWords(best.insertedWords);

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

function checkInsertedWords(insertedWords)
{
    reiniatilize()
    $(".findWord").each(function( index ) {
        var inflection = $(this).find(inflectionSelector).val();
        var className = jQuery.inArray(inflection, insertedWords) != -1
            ? "list-group-item-success"
            : "list-group-item-danger";

         $(this).addClass(className);
     });
}

function reiniatilize()
{
    $(".findWord").removeClass("list-group-item-danger list-group-item-success");
}
