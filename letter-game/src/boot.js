BasicGame = {
  windowWidth : 800,
  windowHeight : 500,
  Counterposition : 800-50,
  GameCounter : 0,
  ClicksToWin : 7,
  vehiclesList : ['policecar', 'ambulance', 'fireengine'],
  LetterToWin : 'alif',
  streetposition : 500/100*7,
  streetHeight : 500 - (500/100*7)
};

var boot = function(game){
  
};
  
boot.prototype = {
	preload: function(){
    this.game.load.image("loading","images/items/loading.png"); 
	},
  create: function(){
		this.scale.scaleMode = Phaser.ScaleManager.SHOW_ALL;
    var resizeGame = this._fitScreen = function() {
        game.scale.pageAlignVertically = true;
        game.scale.pageAlignHorizontally = true;
        game.scale.setShowAll();
        game.scale.refresh();
    };    
		this.game.state.start("Preload");
	}
}