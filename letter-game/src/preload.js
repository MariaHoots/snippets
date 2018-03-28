var preload = function(game){}

preload.prototype = {
	preload: function(){ 
    this.game.stage.backgroundColor = '#000';
    var loadingBar = this.add.sprite(this.game.world.centerX,this.game.world.centerY,"loading");
    loadingBar.anchor.setTo(0.5,0.5);
    this.load.setPreloadSprite(loadingBar);
    
    //background
    this.game.load.image('background', 'images/backgrounds/bg_g1a.png');
    this.game.load.image('circle', 'images/backgrounds/circle.png');
    //letters
    this.game.load.image('alif', 'images/letters/alif.png');
    //load items according to vehiclesList
    this.game.load.atlasJSONHash('policecar', 'images/items/policecar.png', 'images/items/policecar.json');
    this.game.load.atlasJSONHash('ambulance', 'images/items/ambulance.png', 'images/items/ambulance.json');
    this.game.load.atlasJSONHash('fireengine', 'images/items/fireengine.png', 'images/items/fireengine.json');  
    //items
    this.game.load.image('youwin', 'images/items/winmessage.png');
    this.game.load.image('playagain', 'images/items/playagain.png');
	},
  create: function(){
		this.game.state.start("TheGame");
	}
}