var clock = {
	start: round.type == "conquer" ? 0 : 120,
	countdown: round.type == "conquer" ? false : true,

	init: function(){
		var testClock = $('#clock').FlipClock( clock.start, {
			countdown: clock.countdown,
			clockFace: 'MinuteCounter',
			language : 'french',
			callbacks: {
		        stop: function () {
		        //var time = testClock.getTime().time;
		        }
			}
		});
	}
}

var words = {
	countWords: 0,
	word: '',
	correct: true,
	exists: false,
	bonus: 0,
	bonusPoints: [],
	foundWords: [],

	countAllWords: function(){
		var countWords = 0;
		countWords  = grid.all_words.length;
		//$('p#number-of-words').html(countWords + ' <?php echo $lang['words_to_find'];?>');
	},

	inObjectives: function(inflection){
		if (round.objectives.hasOwnProperty(inflection.toLowerCase())){
		 	var objectiveId = round.objectives[inflection.toLowerCase()].id;
			$("#objective-"+objectiveId).addClass("list-group-item-success").append(' ('+ inflection +')');

			return true;
		}

		return false;
	},

	inInflections: function(inflection){
		var inInflections = gridJSON.inflections.hasOwnProperty(inflection.toLowerCase())
			? true
			: false;

		return inInflections;
	},

	alreadyFound: function(inflection){
		var found = $.inArray(inflection.toLowerCase(), this.foundWords) == -1
			? false
			: true;

		return found;
	},

	addToFoundWords : function(inflection, inObjective, isCorrect){
		this.foundWords.push(inflection);
		inflection = inflection.toUpperCase();
		var typedInflection = (!isCorrect) ? "<s>"+inflection+"</s>" : inflection;
		$("#inflections-found").prepend("<li class='list-group-item'>"+typedInflection+"</li>");
	},

	checkWord: function(){
		var inflection = grid.foundWord;
		/*
		this.searchDico();
		if( this.exists ){
			this.getBonusWordPoints();
			this.getWordPoints();
			this.getNumberOfWords();
		}
		this.displayFoundWords();
		*/
		if (!this.alreadyFound(inflection)) {
			if (this.inInflections(inflection)){
				var inObjectives = this.inObjectives(inflection);
				this.addToFoundWords(inflection.toLowerCase(), inObjectives, true);
			} else {
				this.addToFoundWords(inflection.toLowerCase(), false);
			}
		}
	},

	searchFoundWords: function(){
		var wordCorrect = true;
		var wordLi = '';
		$('ul#wordlist').find('li').each(function(idx, li){
			wordLi = $(li).text();
			if ( grid.foundWord  == wordLi ){
				wordCorrect = false;
			}
		});
		this.correct = wordCorrect;
	},

	searchDico: function(){
		this.exists = false;
		for (i = 0; i < grid.all_words.length; i++ ){
			if( this.word == grid.all_words[i] ){
				this.exists = true;
			}
		}
	},

	getBonusWordPoints: function(){
		this.bonusPoints = 0;
		var wordLength = 0;
		wordLength = this.word.length;
		switch(grid.gametype){
			case 2:
				this.bonusPoints = [0, 0, 5, 10, 25, 30, 40, 50, 60];
				if( wordLength >= 8 ){
					this.bonus = this.bonusPoints[8];
				} else {
					this.bonus = this.bonusPoints[wordLength];
				}
			break;
			case 3:
				this.bonusPoints = [0, 0, 1, 2, 8, 50, 90, 120, 150];
				if( wordLength >= 8 ){
					this.bonus = this.bonusPoints[8];
				} else {
				this.bonus = this.bonusPoints[wordLength];
				}
			break;
			case 4:
				var str = this.word;
				var reg = str.match(/^CI.*$/);
				if(	this.word == reg ){
					this.bonus = this.word.length * 5;
				}
			break;
		}
	},

	getWordPoints: function(){
		grid.wordPoints = 0;
		for (i = 0; i < grid.all_words.length; i++ ){
			if( this.word == grid.all_words[i] ){
				grid.wordPoints = grid.all_points[i];
			}
		}
		grid.score += grid.wordPoints;
		if (grid.score <= 1 ){
			//$('p#countPoints').html(grid.score + ' <?php echo $lang['point']; ?>');
			return;
		}
		//$('p#countPoints').html(grid.score + ' <?php echo $lang['points']; ?>');
	},

	displayFoundWords: function(){
		var li = $('<li />');
		li.addClass(this.exists == true ? 'wordlist-words' : 'wordlist-mistake');
		li.html(this.word);
		li.appendTo('ul#wordlist');
		this.sendFoundWord();

		var li = $('<li class="pointlist-points" />');
		li.html(this.exists === true ? grid.wordPoints : '&nbsp;');
		li.appendTo('ul#pointlist');
	},

	getNumberOfWords: function(){
		this.countWords++;
		if (this.countWords <= 1 ){
			//$('p#countWords').html(this.countWords + ' <?php echo $lang['word']; ?>');
			return;
		}
		//$('p#countWords').html(this.countWords + ' <?php echo $lang['word']; ?>');
	},

	sendFoundWord: function(){
		/*
		$.get('?mode=game.word', {
			gameid: grid.gameid,
			gridid: grid.gridid,
			word: this.word,
			wordexists: this.exists === true ? 1 : 0,
			wordpoints: this.exists === true ? grid.wordPoints : 0
		});
		*/
	}
};

var grid = {
	gameid: 0,
	gridid: 0,
	gametype: 0,
	grid: [],
	all_words: [],
	all_points: [],
	points: {},
	wordPoints: 0,
	score: 0,
	firstLetterSelected: false,
	lastLetterSelected: false,
	foundWord: '',
	selectedSquares: [],
	allowedSquares: [],

	set: function(data){
		this.gameid = data.gameid;
		this.gridid = data.gridid;
		this.gametype = data.gametype;
		this.grid = data.grid;
		this.all_words = data.all_words;
		this.all_points = data.all_points;
		this.points = data.points;
		this.instruction = data.instruction;
		this.all_words = $.map(this.all_words, function (word, i){
			return word.toUpperCase();
		});
	},

	draw: function(){
		this.setListener();
	},

	setListener: function(){
		$('ul#squares li p').mousedown(function(){
			if(this.id){
				grid.first_letter(this.id);
			}
		});
		$('ul#squares li p').mouseover(function(){
			if(this.id){
				grid.select_letter(this.id);
			}
		});
		$('body').mouseup(function(){
			grid.last_letter();
		});
	},

	restartGrid: function(){
		this.firstLetterSelected = false;
		this.lastLetterSelected = true;
		this.foundWord = '';
		this.selectedSquare = '';
		this.selectedSquares = [];
		$('ul#squares li').removeClass('selected');
	},

	get_x_y: function(id){
		var reg = new RegExp('square-([0-9])-([0-9])$');
		var match = false;
		if ( match = id.match(reg) )
		{
			return {
				x: parseInt(match[2]),
				y: parseInt(match[1])
			};
		}
		return false;
	},

	getLetter: function(id){
		var position = this.get_x_y(id);
		if ( position === false )
		{
			return false;
		}
		//return this.grid[position.y][position.x];
		return $("#"+id).data("value");
	},

	getAllowedSquare: function(id){
		var position = this.get_x_y(id);
		var x = position.x;
		var y = position.y;
		var xx = 0;
		var yy = 0;
		var square = '';
		this.allowedSquares = [];
		if( position === false ){
			return false;
		}
		if( y > 0 ){
			yy = y - 1;
			xx = x - 1;
			if( x > 0 ){
				square = 'square-' + yy + '-' + xx;
				this.allowedSquares.push(square);
			}
			xx = x;
				square = 'square-' + yy + '-' + xx;
				this.allowedSquares.push(square);
			xx = x + 1;
			if( x < 3 ){
				square = 'square-' + yy + '-' + xx;
				this.allowedSquares.push(square);
			}
		}
		if( y < 3 ){
			yy = y + 1;
			xx = x - 1;
			if( x > 0 ){
				square = 'square-' + yy + '-' + xx;
				this.allowedSquares.push(square);
			}
			xx = x;
			square = 'square-' + yy + '-' + xx;
			this.allowedSquares.push(square);
			xx = x + 1;
			if( x < 3 ){
				square = 'square-' + yy + '-' + xx;
				this.allowedSquares.push(square);
			}
		}
		yy = y;
		xx = x - 1;
		if( x > 0 ){
			square = 'square-' + yy + '-' + xx;
			this.allowedSquares.push(square);
		}
		xx = x + 1;
		if( x < 3 ){
			square = 'square-' + yy + '-' + xx;
			this.allowedSquares.push(square);
		}
	},

	checkAllowedSquare: function(id){
		var ok = false;
		var i = 0;
		for (i = 0; i < this.allowedSquares.length; i++ ){
			if ( id == this.allowedSquares[i]){
				ok = true;
			}
		}
		if ( !ok ){
			return false;
		}
		for (i = 0; i < this.selectedSquares.length; i++ ){
			if ( id == this.selectedSquares[i]){
				return false;
			}
		}
		return true;
	},

	addLetter: function(id) {
		var letter = this.getLetter(id);
		if ( !letter ) {
			return false;
		}
		this.selectedSquares.push(id);
		this.foundWord += letter;
		this.getAllowedSquare(id);
	},

	deleteLetter: function() {
		/* On supprime le dernier élément du tableau des cases */
		this.selectedSquares.pop();
		/* on enlève à la chaine de caractère du mot trouvé la dernière lettre et on retourne false */
		var lastLetter = this.foundWord.length - 1;
		this.foundWord = this.foundWord.substring(0,lastLetter);
		this.allowedSquares = [];
		if ( this.selectedSquares.length > 0 ) {
			var prevId = this.selectedSquares[this.selectedSquares.length - 1];
			this.getAllowedSquare(prevId);
		}
	},

	first_letter: function(firstSquare){
		this.firstLetterSelected = true;
		this.lastLetterSelected = false;

		this.addLetter(firstSquare);
		$('#li-' + firstSquare).addClass('selected');
	},

	select_letter: function(selectSquare){
		/* On vérifie que une première lettre a déjà été sélectionnée,
			et que nous n'avons pas encore de dernière lettre */
		if ( (this.firstLetterSelected === false) || (this.lastLetterSelected === true) ){
			return false;
		}
		/* On vérifie qu'on annule la dernière lettre */
		if ( this.selectedSquares.length > 1 ) {
			var lastSquare = this.selectedSquares[this.selectedSquares.length - 1];
			var prevSquare = this.selectedSquares[this.selectedSquares.length - 2];
			if ( prevSquare == selectSquare ) {
				$('#li-' + lastSquare).removeClass('selected');
				this.deleteLetter();
				return false;
			}
		}
		/* On vérifie que la case est autorisée */
		var allowedLetter = this.checkAllowedSquare(selectSquare);
		if ( allowedLetter ){
			this.addLetter(selectSquare);
			$('#li-' + selectSquare).addClass('selected');
			return false;
		}
	},

	last_letter: function(){
		if( this.lastLetterSelected === true ){
			return false;
		}
		this.lastLetterSelected = true;
		if ( this.foundWord.length > 1 ) {
			words.checkWord();
		}
		grid.restartGrid();
	}
};

$(document).ready(function () {
	grid.draw();
	clock.init();
});
