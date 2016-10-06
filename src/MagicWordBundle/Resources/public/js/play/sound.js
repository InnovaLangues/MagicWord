var sound = {
    rightWord: null,
    waitingStart: null,
    wrongForm: null,
    init: function(){
        this.rightWord = new Howl({src: [assetsBaseDir+'/audio/41381__sandyrb__db-bell-shot-001.mp3']});
        this.waitingStart = new Howl({src: [assetsBaseDir+'/audio/49306__fossa11__drumroll.mp3']});
        this.wrongForm = new Howl({src: [assetsBaseDir+'/audio/142608__autistic-lucario__error.mp3']});
    },
};
