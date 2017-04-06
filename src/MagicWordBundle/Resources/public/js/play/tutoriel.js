var tutoriel = {
  start: function(){
    var introguide = introJs();
    introguide.setOptions({
        steps: [
            {
              element: '#header-logo',
              intro: '<div class="core"><p>Bienvenue dans le mode <span class="hint">Rush</span> !</p></div>',
              position: 'right'
            },
            {
              element: '#header-logo',
              intro: '<div class="core"><p><span class="hint">Objectif :</span> former le plus en <span class="important">2 minutes</span> de mots pour gagner des points.</p></div>',
              position: 'right'
            },
            {
              element: '#header-logo',
              intro: '<div class="core"><p>Je prends de l\'avance</p></div>',
              position: 'right'
            },
            {
              element: '#header-logo',
              intro: '<div class="core"><p><span class="hint">Indice :</span> faire un  <span class="combo">combo</span> avec les mots de la même  <span class="combo">famille</span> rapporte des points rapidement.</p></div>',
              position: 'right'
            },
            {
              element: '#header-logo',
              intro: '<div class="core"><p>Commençons en premier par <span class="important">les bases</span> !</p></div>',
              position: 'right'
            },
            {
              element: '#squares',
              intro: '<div class="core"><p><span class="important">Clic</span> et <span class="important">glisse</span> sur les lettres pour former un mot.</p></div>',
              position: 'right'
            },
            {
              element: '#squares',
              intro: '<div class="core">Déplace-toi :<ul><li><span class="important">verticalement</span></li><li><span class="important">horizontalement</span></li><li><span class="important">en diagonale</span></li></ul></div>',
              position: 'right'
            },
            {
              element: '#woot-container',
              intro: '<div class="core"><p>Vérifie le mot <span class="important">en construction</span>.</p></div> ',
              position: 'right'
            },
            {
              element: '#woot',
              intro: '<div class="core"><p>Observe le nombre de <span class="important">point total</span> du mot et les <span class="combo">points combo</span> en cours.</p></div> ',
              position: 'right'
            },
            {
              element: '#inflections-found',
              intro: '<div class="core"><p>Note les <span class="important">mots déjà créés</span>.</p></div>',
              position: 'right'
            },
            {
              element: '#points-container',
              intro: '<div class="core"><p>Suis ton <span class="important">score</span> à tout moment.</p></div>',
              position: 'right'
            },
            {
              element: '#li-square-0-0',
              intro: '<h4>Chaque lettre ajoute un nombre de point fixe à ton score.</h4>',
              position: 'right'
            },
            {
              element: '#points-container',
              intro: '<div class="core"><p>Souviens toi des <span class="combo">combos</span> !</p></div>',
              position: 'right'
            },
            {
              element: '#current-combo-container',
              intro: 'Chaque mot que tu créé, augmente la jauge de puissance, de 1.',
              position: 'right'
            },
            {
              element: '#clock-wrapper',
              intro: 'N\'oublie pas, le temps est compté !',
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
