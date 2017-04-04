var tutoriel = {
  start: function(){
    var introguide = introJs();
    introguide.setOptions({
        steps: [
            {
              element: '#clock-wrapper',
              intro: 'This guided tour will explain the Hongkiat demo page interface.<br><br>Use the arrow keys for navigation or hit ESC to exit the tour immediately.',
              position: 'right'
            },
            {
              element: '#current-combo-container',
              intro: 'This guided tour will explain the Hongkiat demo page interface.<br><br>Use the arrow keys for navigation or hit ESC to exit the tour immediately.',
              position: 'bottom'
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
