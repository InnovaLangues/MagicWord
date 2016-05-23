$( document ).on( "blur", ".word", function() {
  checkExistence($(this));
});

function addword() {
    document.getElementById('words').insertAdjacentHTML('beforeend', '<input required type="text" class="word" pattern="[A-Za-z]+" value="" />');
}

function checkExistence(input) {
    var inflection = input.val();
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
            input.val(input.val()+" ?? ");
          }
      });
}

function generate() {
    var words = document.querySelectorAll(".word");
    var word_list = [];
    for (var i = words.length - 1; i >= 0; i--) {
        word_list.push(words[i].value);
    };
    var results = "";
    var time = document.getElementById("time").value;
    var generator = Generator();
    var best = new generator(4, word_list, time).run();
    results += "<table>";
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
    results += "<button class='btn btn-default' type='submit'>Create</button>";

    results += "<br/>";
    results += best.total;
    results += " mots/";
    results += word_list.length;

    results += "<br/>";
    results += best.candidateCount + " générations de grille en " + time + " ms";

    document.getElementById('result').innerHTML = results;
}
