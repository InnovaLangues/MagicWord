var sound = {
    switchSelector: "input#mute-sound",
    rightWord: null,
    waitingStart: null,
    addLetter: null,
    wrongForm: null,
    notime: null,
    objectiveDone: null,
    objectiveProgress: null,
    removeLetter: null,
    disabled: true,

    init: function(play){
        this.rightWord = new Howl({src: [assetsBaseDir+'/audio/41381__sandyrb__db-bell-shot-001.mp3']});
        this.waitingStart = new Howl({src: [assetsBaseDir+'/audio/49306__fossa11__drumroll.mp3']});
        this.wrongForm = new Howl({src: [assetsBaseDir+'/audio/142608__autistic-lucario__error.mp3']});
        this.notime = new Howl({src: [assetsBaseDir+'/audio/82523__zgump__bulgarian-gong.mp3']});
        this.objectiveDone = new Howl({src: [assetsBaseDir+'/audio/165492__chripei__victory-cry-reverb-1.mp3']});
        this.objectiveProgress = new Howl({src: [assetsBaseDir+'/audio/320655__rhodesmas__level-up-01.mp3']});
        this.addLetter = new Howl({src: [assetsBaseDir+'/audio/212527__taira-komori__pushing-enter-key.mp3']});
        this.removeLetter = new Howl({src: [assetsBaseDir+'/audio/360602__cabled-mess__typewriter-snippet-02.mp3']});
    },

    play: function(s){
        s.play();
    }
};
