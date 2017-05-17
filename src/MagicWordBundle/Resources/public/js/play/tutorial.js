$(document).ready(function () {
	game.displayModal();
	game.initEvent();
	sound.init();
	grid.draw();
	if(roundJSON.type == "conquer") objectives.displayDone();
});


var game = {
	displayModal: function(){
		$('#game-start-summary').modal('show');
	},
	start: function(){
			clock.init();
			$("#game-container").show();
			grid.resize();
      tutoriel.start();
	},
	initEvent: function(){
		$('body').on("click touchstart", "#game-start", function(e){
			$('#game-start-summary').modal('hide');
			if (deviceSize.get() == 'xs') {
				screenfull.toggle(window[0]);
			}
			game.start();
		});
	}
}

var tutoriel = {
  start: function(){
    var introguide = introJs();
    introguide.setOptions({
        exitOnEsc: false,
        exitOnOverlayClick: false,
        steps: [
            {
              element: '#header-logo',
              intro: '<div class="core"><p><span class="hint">Selon le mode de jeu, l\'objectif est soit de</span> marquer le maximum de points en <span class="important">2 minutes</span> (mode Rush) en trouvant des mots et en enchainant les combos soit en remplissant les objectifs en un minimum de temps (mode Conquer)</p></div>',
              position: 'right'
            },
            {
              element: '#squares',
              intro: '<div class="core"><p><span class="important">Clique</span> et <span class="important">glisse</span> sur les lettres pour former un mot.</p></div>',
              position: 'right'
            },
            {
              element: '#squares',
              intro: '<div class="core">Déplace-toi :<ul><li><span class="important">verticalement</span></li><li><span class="important">horizontalement</span></li><li><span class="important">en diagonale</span></li></ul> et ce de gauche à droite, droite à gauche, de haut en bas et de bas en haut.</div>',
              position: 'right'
            },
            {
              element: '#woot-container',
              intro: '<div class="core"><p>Vérifie le mot <span class="important">en construction</span>. Tu peux revenir en arrière si tu le souhaites.</p></div> ',
              position: 'right'
            },
            {
              element: '#woot',
              intro: '<div class="core"><p>Observe le nombre de <span class="important">points total</span> du mot et les <span class="combo">points combo</span> en cours.</p></div> ',
              position: 'right'
            },
            {
              element: '#inflections-found',
              intro: '<div class="core"><p>Note les <span class="important">mots déjà créés</span>.En mode Conquer, cette zone liste les objectifs.</p></div>',
              position: 'right'
            },
            {
              element: '#points-container',
              intro: '<div class="core"><p>Suis ton <span class="important">score</span> à tout moment. En mode Conquer, cette zone permet de suivre ta progression sur les objectifs.</p></div>',
              position: 'right'
            },
            {
              element: '#current-combo-container',
              intro: '<div class="core"><p>Souviens toi des <span class="combo">combos</span> ! Cette barre se charge si tu enchaines les mots issus d\'un même lemme. Cela permet, en mode Rush, de gagner beaucoup de points en plus. En mode Conquer, faire des combos peut faire partie des objectifs.</p></div>',
              position: 'right'
            },
            {
              element: '#clock-wrapper',
              intro: 'N\'oublie pas, le temps est compté !',
              position: 'right'
            },
            {
              element: '#header-logo',
              intro: 'Bonne chance !',
              position: 'right'
            }
        ]
    });

    introguide.start();
  }
};
