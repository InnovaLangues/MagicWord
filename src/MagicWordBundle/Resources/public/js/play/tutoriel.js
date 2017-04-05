var tutoriel = {
  start: function(){
    var introguide = introJs();
    introguide.setOptions({
        steps: [
            {
              element: '#header-logo',
              intro: '<h2>Bienvenue dans <span style=\"color:blue;\">Magic</span><span style=\"color:yellow;\">Word</span> !</h2>',
              position: 'right'
            },
            {
              element: '#squares',
              intro: '<h3>Objectif</h3><h4>Former des mots pour gagner des points.</h4><span style=\"color:blue;\">Indice :</span><br> faire un  <span style=\"color:red;\">combo</span> apporte des points rapidement.',
              position: 'left'
            },
            {
              element: '#squares',
              intro: '<h3>Règles de bases</h3><h4><span style=\"color:red;\">Clic</span> et <span style=\"color:red;\">glisse</span> sur les lettres pour former un mot.</h4>',
              position: 'right'
            },
            {
              element: '#squares',
              intro: '<h3>Règles de bases</h3><h4>Tu peux te déplacer <span style=\"color:red;\">verticalement</span>, <span style=\"color:red;\">horizontalement</span> et <span style=\"color:red;\">en diagonale</span>.</h4>',
              position: 'right'
            },
            {
              element: '#woot-container',
              intro: '<h3>Bravo !</h3> Le mot que tu formes s’affiche ici.',
              position: 'right'
            },
            {
              element: '#inflections-found',
              intro: 'Tous les mots que tu as créés, sont stocker ici.',
              position: 'right'
            },
            {
              element: '#li-square-0-0',
              intro: 'Chaque lettre donne un nombre de point fixe.',
              position: 'right'
            },
            {
              element: '#points-container',
              intro: 'Ici, s\'affiche ton score',
              position: 'left'
            },
            {
              element: '#current-combo-container',
              intro: 'Chaque mot que tu créé, augmente la jauge de puissance, de 1.',
              position: 'right'
            },
            {
              element: '#squares',
              intro: 'Pour augmenter la jauge de puissance, rappelles toi des <span style=\"color:red;\">combos</span> !',
              position: 'left'
            },
        ]
    });
    /*
    introJs().setOptions({
      steps:[
        {
          element: '#squares',
          intro: 'This guided tour will explain the Hongkiat demo page interface.<br><br>Use the arrow keys for navigation or hit ESC to exit the tour immediately.',
          position: 'bottom'
        },
        {
          element: '#clock-wrapper',
          intro: 'Click this main logo to view a list of all Hongkiat demos.',
          position: 'bottom'
        },
      ]
    });
    */
    introguide.start();
  }
};
