var inflectionSelector = "input[data-field='inflection']";

$( document ).on( "blur", inflectionSelector, function(){
    checkExistence($(this));
});

$( document ).on( "click", ".word-remove", function(){
    removeWord($(this));
});

function addWord(){
    var words = $('#words');
    var objective = words.data('prototype');
    var length = $(".findWord").length;
    objective = objective.replace(/__name__/g, length);
    words.append(objective);

    return length;
}

function addInflection(inflection){
    var length = addWord();
    $("#round_findWords_"+ length +"_inflection").val(inflection);
}

function addCombo(){
    var combos = $('#combos');
    var combo = combos.data('prototype');
    combo = combo.replace(/__name__/g, $(".combo").length);
    combos.append(combo);
}


function removeWord(word){
    word.closest('li').remove();
}

function checkExistence(input){
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

function saveObjectives(){
    if(isFormValid("objectives")){
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

function getInflections(){
    if(isFormValid("grid")){
        wait.start("Récupération des formes");
        var url = Routing.generate('get_inflections');
        var data = $("#grid").serializeArray();

        $.ajax({
              type: 'POST',
              url: url,
              data: data,
          })
          .done(function(data) {
              wait.stop();
              $("#inflections").html(data);
          });
    } else {
        info.display("La grille doit être entièrement remplie.");
    }
}

function getCombos(){
    if(isFormValid("grid")){
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

function isFormValid(formId){

    return document.getElementById(formId).checkValidity();
}

function generate(){
    if ($(".findWord").length > 0) {
        wait.start("Génération de la grille");
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
        wait.stop();
    } else {
        info.display("Au moins une forme doit être renseignée afin de générer la grille.");
    }
}

function save(){
    if(isFormValid("grid")){
        wait.start("Sauvegarde de la grille");
        var data = $("#grid").serializeArray();
        var url = Routing.generate('conquer_save_grid', {id: $('#conquerId').val()});
        $.ajax({
              type: 'POST',
              url: url,
              data: data,
         })
         .done(function(data) {
             $("#foundables").html(data);
             wait.stop();
         });
     }
}

function checkInsertedWords(insertedWords){
    reiniatilize()
    $(".findWord").each(function( index ) {
        var inflection = $(this).find(inflectionSelector).val();
        var className = jQuery.inArray(inflection, insertedWords) != -1
            ? "list-group-item-success"
            : "list-group-item-danger";

         $(this).addClass(className);
     });
}

function reiniatilize(){
    $(".findWord").removeClass("list-group-item-danger list-group-item-success");
}


var gridHandler = {
    autofill: function(){
        wait.start("Remplissage automatique de la grille");
        var language = $('#languageId').val();
        var url = Routing.generate('get_letters', {
            id: language
        });
        $.ajax({
              type: 'POST',
              url: url,
         })
         .done(function(data) {
             var data = data;
             $("input[name='squares[]']").each(function( index ) {
                 if ($(this).val() == "-" || $(this).val() == "_") {
                     $(this).val(data[index]);
                 }
             });
             wait.stop();
         });
    }
}


/* Constraints */
var constraints = {
    add: function(){
        var constraints = $('#constraints');
        var constraint = constraints.data('prototype');
        constraint = constraint.replace(/__name__/g, $(".constraint-objective").length);
        constraints.append(constraint);
    },
    checkAll: function(){
        $( "#constraints-tab select" ).each(function() {
            constraints.checkOne($(this));
        });
    },
    checkOne: function(constraint){
        var span = constraint.parent("span");
        if (constraint.val() != "") {
            span.addClass("notempty");
        } else{
            span.removeClass("notempty");
        }
    }
}

$( "#constraints-tab" ).on( "change", "select", function(){
    constraints.checkOne($(this));
});

$( "#constraints-tab" ).ready(function() {
    constraints.checkAll();
});
