var myGamePiece; //background imgage
var myBucket;    //bucket of the game
var mySlider;    //silder of the game
var myLine1;     //the first line
var myLine2;	 //the second line
var myLine3;     //the third line
var myStartBt;   //the start Button
var myPaperBt;

function startGame() {
    myGamePiece = new component(956, 537, "images/kineticEnergyLaw/bg.jpg", 10, 0, "image");
	myBucket=new component(30,48,"images/kineticEnergyLaw/bucket.jpg",646,220,"image");
	mySlider=new component(30,30,"rgb(0,50,9)",180,181);
	myLine1=new line(123,199,180,199);
	myLine2=new line(210,188,650,188);
	myLine3=new line(661,195,661,220);
	myStartBt=new component(60,30,"images/kineticEnergyLaw/startButton.jpg",850,20,"image");
	myPaperBt=new component(60,30,"images/kineticEnergyLaw/paperButton.jpg",850,60,"image");
    myGameArea.start();
	myBucket.gravity=(myBucket.weight-myGameArea.frictionFactor*mySlider.weight)/(myBucket.weight+mySlider.weight)*0.01;
}

var myGameArea = {
    canvas : document.createElement("canvas"),
    start : function() {
        this.canvas.width = 956;
        this.canvas.height = 537;
        this.context = this.canvas.getContext("2d");
        document.body.insertBefore(this.canvas, document.body.childNodes[0]);
        this.frameNo = 0;
		this.frictionFactor=0.4;
        this.interval = setInterval(updateGameArea, 20);
		/*window.addEventListener('mousedown', function (e) {
            myGameArea.x = e.pageX;
            myGameArea.y = e.pageY;
        })
        window.addEventListener('mouseup', function (e) {
            myGameArea.x = false;
            myGameArea.y = false;
        })
		*/
		window.addEventListener('click', function (e) {
            myGameArea.x = e.pageX;
            myGameArea.y = e.pageY;
			if(myStartBt.clicked()){
				myStartBt.isStart=!myStartBt.isStart;
			}
        })
        },
    clear : function() {
        this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
    },
    stop : function() {
        clearInterval(this.interval);
    },
	x:0,
	y:0
}
function line(x1,y1,x2,y2,color) {
	this.x1=x1;
	this.y1=y1;
	this.x2=x2;
	this.y2=y2;
	
	this.update= function(){
		ctx=myGameArea.context;
		ctx.fillStyle=color;
		ctx.beginPath();
		ctx.moveTo(this.x1,this.y1);
		ctx.lineTo(this.x2,this.y2);
		ctx.stroke();
	}
}

function component(width, height, color, x, y, type) {
    this.type = type;
    if (type == "image") {
        this.image = new Image();
        this.image.src = color;
    }
	this.weight=1;
    this.width = width;
    this.height = height;
    this.speedX = 0;
    this.speedY = 0;    
    this.x = x;
    this.y = y;  
	this.gravity=0.05;
	this.gravitySpeed=0;
	this.bounce=0.5;
	this.hitBottom=false;
	this.isSet=false;
	this.isStart=false;
    this.update = function() {
        ctx = myGameArea.context;
        if (type == "image") {
            ctx.drawImage(this.image, 
                this.x, 
                this.y,
                this.width, this.height);
        } else {
            ctx.fillStyle = color;
            ctx.fillRect(this.x, this.y, this.width, this.height);
        }
    }
	
	//to update the position of ONLY myBucket
    this.newPos = function() {
		this.gravitySpeed+=this.gravity;
        this.x += this.speedX;
        this.y += this.speedY+this.gravitySpeed; 
		
		//myBucket hit the canvas bottom
		if(this.y>=myGameArea.canvas.height-this.height+6){
			this.hitBottom=true;
			this.y=myGameArea.canvas.height-this.height+6;
			this.gravitySpeed=-this.bounce*this.gravitySpeed;
			//alert("the time used is: "+myGameArea.frameNo*20+" ms");
		}
    }
	this.clicked = function() {
        var myleft = this.x;
        var myright = this.x + (this.width);
        var mytop = this.y;
        var mybottom = this.y + (this.height);
        var clicked = true;
		if ((mybottom < myGameArea.y) || (mytop > myGameArea.y) || (myright < myGameArea.x) || (myleft > myGameArea.x)) {
            clicked = false;
        }
        return clicked;
    }
}

function updateGameArea() {
	
	//test
	/*if(myGameArea.frameNo%500==0){
		alert("gravity: "+myBucket.gravity+
		"\n myBucket.weight "+myBucket.weight+
	"\n myGameArea.frictionFactor "+myGameArea.frictionFactor+
	"\n mySlider.weight "+mySlider.weight+
	"\n "+(myBucket.weight-myGameArea.frictionFactor*mySlider.weight)/(myBucket.weight+mySlider.weight)*0.01+
	"\n "+(myBucket.weight-myGameArea.frictionFactor*mySlider.weight)+
	"\n "+(myBucket.weight+mySlider.weight)+
	"\n "+(mySlider.weight+1)+
	"\n ");	
	}
	*/
	
	if(myStartBt.isStart){ //the status of this button is start
		myStartBt.image.src="images/kineticEnergyLaw/pauseButton.jpg";
		myPaperBt.x-=5;
	}
	else{
		myStartBt.image.src="images/kineticEnergyLaw/startButton.jpg";
	}
	
	
	
	
	myGameArea.frameNo++;
    myGameArea.clear();
	
    myGamePiece.update();
	
	myBucket.newPos();
	myBucket.update();
	
	//update position of slider.
	if(!myBucket.hitBottom){
		mySlider.x+=myBucket.speedY+myBucket.gravitySpeed;	
	}
	else{
		//set the speedX of myBucket to speed of myBucket when it hit the bottom of canvas
		if(myBucket.isSet==false){
			myBucket.isSet=true;
			mySlider.speedX=-(myBucket.speedY+myBucket.gravitySpeed);
		}
		mySlider.x+=mySlider.speedX;
	}
	mySlider.update();
	
	myLine1.x2=mySlider.x;	//update position of line 1.
	myLine1.update();
	
	myLine2.x1=mySlider.x+mySlider.width;	//update position of line 2.
	myLine2.update();
	
	myLine3.y2=myBucket.y;	//update position of line 3.
	myLine3.update();
	
	myStartBt.update();
	myPaperBt.update();
}

function setWeight(){
	 myBucket.weight=Number(document.getElementById("bucket").value);
	 mySlider.weight=Number(document.getElementById("slider").value);
	 myGameArea.frictionFactor=Number(document.getElementById("frictionFactor").value);
	 myBucket.gravity=(myBucket.weight-myGameArea.frictionFactor*mySlider.weight)/(myBucket.weight+mySlider.weight)*0.01;
	// alert(myBucket.weight+" "+mySlider.weight+" "+myGameArea.fricitonFactor)
	
}

