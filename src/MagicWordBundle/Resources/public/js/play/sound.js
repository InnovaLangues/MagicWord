var sound = {
    rightWord: null,
    waitingStart: null,
    wrongForm: null,
    notime: null,
    objectiveDone: null,
    objectiveProgress: null,
    init: function(){
        this.rightWord = new Howl({src: [assetsBaseDir+'/audio/41381__sandyrb__db-bell-shot-001.mp3']});
        this.waitingStart = new Howl({src: [assetsBaseDir+'/audio/49306__fossa11__drumroll.mp3']});
        this.wrongForm = new Howl({src: [assetsBaseDir+'/audio/142608__autistic-lucario__error.mp3']});
        this.notime = new Howl({src: [assetsBaseDir+'/audio/82523__zgump__bulgarian-gong.mp3']});
        this.objectiveDone = new Howl({src: [assetsBaseDir+'/audio/165492__chripei__victory-cry-reverb-1.mp3']});
        this.objectiveProgress = new Howl({src: [assetsBaseDir+'/audio/320655__rhodesmas__level-up-01.mp3']});
    },
};
