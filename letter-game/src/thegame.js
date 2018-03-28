var theGame = function(game){

}

theGame.prototype = {
  create: function(){  
    //Basic settings
    this.game.physics.startSystem(Phaser.Physics.ARCADE);
    var background = this.game.add.sprite(0, 0, 'background');
    background.width = BasicGame.windowWidth;
    background.height = BasicGame.windowHeight;    
    //Counter
    this.game.add.sprite(BasicGame.Counterposition-27, 12, 'circle');
    CounterText = this.game.add.text(BasicGame.Counterposition,30, BasicGame.GameCounter, {
        font: "35px Times New Roman",
        fill: "#fff",
        align: "right"
    });
    CounterText.setText('0');
    //start DrivingHandler to get the cars going
    DrivingHandler(this);  	
	}
}