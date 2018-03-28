function DrivingHandler (game) {
  //Hacking the way around to add argument on line 56
  if (this.param1 !== undefined) {
    //if we have defined param1 then we came from driveCar and need to pass the game new from param1
    game = this.param1;
  } 
  //loads the next car
  if (BasicGame.GameCounter < BasicGame.ClicksToWin) {  
      //not enough right clicks, still in game
      var RandomVehicle = BasicGame.vehiclesList[Math.floor(Math.random() * BasicGame.vehiclesList.length)];
      driveCar(RandomVehicle, BasicGame.LetterToWin, game);
  } else {
      game.state.start("GameOver",true,false);
  }
}

function driveCar(actualCar, actualLetter, game) {
    //@input one car, one letter from array
    // drives car+letter across street
    // when out of world DrivingHandler is fired again and sprite gets killed

    //Add Car to Game and set anchor bottom left
    Car = game.add.sprite(BasicGame.windowWidth, BasicGame.streetHeight, actualCar);
    Car.anchor.setTo(0,1);
    var xMiddleOfCar = Car.width/2;
    var yMiddleOfCar = Car.height/2;
    //Add Letter to game and connect it with car, -y to center in middle instead of below
    var Letter = game.add.sprite(xMiddleOfCar, -yMiddleOfCar, actualLetter);
    Letter.anchor.setTo(0.5,0.5);
    //scale letter bit smaller
    Letter.width = Letter.width * 0.7;
    Letter.height = Letter.height * 0.7;    
    //attach letter to car
    Car.addChild(Letter);
    //Add physics
    game.physics.arcade.enable(Car);
    //Add animations
    Car.animations.add('run');
    Car.animations.play('run', 15, true);
    //Move Car to center
    CarMoving = game.add.tween(Car).to({x:game.world.centerX-xMiddleOfCar,y:BasicGame.streetHeight},3000);
    CarMoving.start();
    // start again when out of the game
    CarMoving.onComplete.add(function(){
        Car.animations.stop(null, true);
    });
    //add input listener
    Car.inputEnabled = true;   
    Car.events.onInputDown.add(ItemClicked, this);      
    //check if out of screen
    Car.checkWorldBounds = true;    
    //Car.events.onOutOfBounds.add(DrivingHandler, '');
    Car.events.onOutOfBounds.add(DrivingHandler, {param1: game});
    //destroy the car if out of World
    Car.outOfBoundsKill = true;
    
}

function ItemClicked (Car) {
  CarMoving.stop(); //stop tween
  BasicGame.GameCounter++;
  CounterText.setText(BasicGame.GameCounter); //update animation
  //let car drive of screen
  Car.animations.play('run', 15, true);
  Car.body.acceleration.x = -2000;
}