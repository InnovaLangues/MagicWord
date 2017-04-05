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
              element: '#header-logo',
              intro: '<h4><span style=\"color:blue;\">Objectif :</span> former des mots pour gagner des points.</h4><h4><span style=\"color:blue;\">Indice :</span> faire un  <span style=\"color:orange;\">combo</span> avec les mots de la même  <span style=\"color:orange;\">famille</span> rapporte des points rapidement.</h4>',
              position: 'right'
            },
            {
              element: '#squares',
              intro: '<h4><span style=\"color:red;\">Clic</span> et <span style=\"color:red;\">glisse</span> sur les lettres pour former un mot.</h4>',
              position: 'right'
            },
            {
              element: '#squares',
              intro: '<h4>Déplace-toi <span style=\"color:red;\">verticalement</span>, <span style=\"color:red;\">horizontalement</span> ou <span style=\"color:red;\">en diagonale</span>.</h4>',
              position: 'right'
            },
            {
              element: '#woot-container',
              intro: '<h4>Vérifie le mot <span style=\"color:red;\">en construction</span>.</h4> ',
              position: 'right'
            },
            {
              element: '#woot',
              intro: '<h4>Observe le nombre de <span style=\"color:red;\">point total</span> du mot et les <span style=\"color:orange;\">points combo</span> en cours.</h4> ',
              position: 'right'
            },
            {
              element: '#inflections-found',
              intro: '<h4>Note les <span style=\"color:red;\">mots déjà créés</span>.</h4>',
              position: 'right'
            },
            {
              element: '#points-container',
              intro: '<h4>Suis ton <span style=\"color:red;\">score</span> à tout moment.</h4>',
              position: 'right'
            },
            {
              element: '#li-square-0-0',
              intro: '<h4>Chaque lettre ajoute un nombre de point fixe à ton score.</h4>',
              position: 'right'
            },
            {
              element: '#points-container',
              intro: '<h4>Pour augmenter ton score rapidement, souviens toi des <span style=\"color:orange;\">combos</span> !</h4>',
              position: 'right'
            },
            {
              element: '#current-combo-container',
              intro: 'Chaque mot que tu créé, augmente la jauge de puissance, de 1.',
              position: 'right'
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
