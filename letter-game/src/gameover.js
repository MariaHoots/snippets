var gameOver = function(game){}

gameOver.prototype = {
	init: function(){

	},
  create: function(){
    this.game.stage.backgroundColor = '#4d75a0';
  	var gameOverTitle = this.game.add.sprite(BasicGame.windowWidth/2,BasicGame.windowHeight/2,"youwin");
		gameOverTitle.anchor.setTo(0.5,0.5);
		var playButton = this.game.add.button(BasicGame.windowWidth/2,BasicGame.windowHeight/1.5,"playagain",this.playTheGame,this);
		playButton.anchor.setTo(0.5,0.5);
	},
	playTheGame: function(){
    //reset Counter
    BasicGame.GameCounter = 0;
		this.game.state.start("TheGame");
	}
}