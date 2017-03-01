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
	squareSelector: 'ul#squares li p',

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

		$('body').on("mousedown touchstart", "#grid-container", function(e){
			e.preventDefault();
		});

		$('body').on("mousedown touchstart", this.squareSelector, function(e){
			if(this.id){
				grid.first_letter(this.id);
			}
			e.preventDefault();
		});

		$('body').on("touchend mouseup", function(){
			grid.last_letter();
		});

		$('body').on("mouseover", this.squareSelector, function(){
			if(this.id){
				grid.select_letter(this.id);
			}
		});

		$('body').on("touchmove", this.squareSelector, function(e){
			if(this.id){
				var touch = e.originalEvent.touches[0];
				if(id = grid.getHoveredObject(touch.clientX, touch.clientY)){
					grid.select_letter(id);
				}
			}
			e.preventDefault();
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
		if ( position === false ){
			return false;
		}

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
		sound.play(sound.addLetter);
		this.selectedSquares.push(id);
		this.foundWord += letter;
		$("#woot").html(this.foundWord);
		this.getAllowedSquare(id);
	},

	deleteLetter: function() {
		/* On supprime le dernier élément du tableau des cases */
		this.selectedSquares.pop();
		/* on enlève à la chaine de caractère du mot trouvé la dernière lettre et on retourne false */
		var lastLetter = this.foundWord.length - 1;
		this.foundWord = this.foundWord.substring(0,lastLetter);
		$("#woot").html(this.foundWord);
		this.allowedSquares = [];
		sound.play(sound.removeLetter);
		if ( this.selectedSquares.length > 0 ) {
			var prevId = this.selectedSquares[this.selectedSquares.length - 1];
			this.getAllowedSquare(prevId);
		}
	},

	first_letter: function(firstSquare){
		this.firstLetterSelected = true;
		this.lastLetterSelected = false;

		this.addLetter(firstSquare);
		$("#woot").removeClass("wrong-form").addClass("right-form");
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
	},

	getHoveredObject: function(x, y) {
		var $x = $.touching({x: x, y: y}, grid.squareSelector);
		var id = $x.attr("id");

		return id;
	},

	resize: function() {
		var grid = $("#grid-container");
		var squares = $("ul#squares li");

		grid.height(grid.width());
		squares.fitText(0.65);

		return;
	}
};
