var myGamePiece; //background imgage
var myBucket;    //bucket of the game
var mySlider;    //silder of the game
var myLine1;     //the first line
var myLine2;	 //the second line
var myLine3;     //the third line
var myStartBt;   //the start Button
var myRestartBt;	 //restart the game
var myPaperBt;
var left; 		//the left button when the paper shows up
var righ;

var output={	 //parameters that will be output to the screen;
	time:0,
	g:9.8,		 // gravity acceleration
	a:0,   		 //acceleration of slider and bucket
	v:0,		 //speed of slider and bucket
	s:0,		//displacement of slider and bucket
	bucketE:0,	//kinetic energy of bucket
	bucketWg:0,	//work of bucket's gravity 
	sliderE:0,
	q:0,		//work of friction force
	base:10		//the base cordinate of paper
}

function startGame() {
    myGamePiece = new component(956, 537, "images/kineticEnergyLaw/bg.jpg", 10, 0, "image");
	myBucket=new component(30,48,"images/kineticEnergyLaw/bucket.jpg",646,220,"image");
	mySlider=new component(30,30,"rgb(0,50,9)",180,181);
	left=new component(478,229,"rgb(255, 255, 0,0.3)",0, 308);
	right=new component(478,229,"rgb(204, 255, 51,0.3)",478, 308);
	myLine1=new line(123,199,180,199);
	myLine2=new line(210,188,650,188);
	myLine3=new line(661,195,661,220);
	myStartBt=new component(60,30,"images/kineticEnergyLaw/startButton.jpg",850,20,"image");
	myRestartBt=new component(60,30,"images/kineticEnergyLaw/restartButton.jpg",850,60,"image");
	myPaperBt=new component(60,30,"images/kineticEnergyLaw/paperButton.jpg",850,100,"image");
    myGameArea.start();
	mySlider.gravity=myGameArea.frictionFactor*0.03;
	myBucket.gravity=(myBucket.weight-myGameArea.frictionFactor*mySlider.weight)/(myBucket.weight+mySlider.weight)*0.03;
	output.a=(myBucket.weight-myGameArea.frictionFactor*mySlider.weight)/(myBucket.weight+mySlider.weight)*output.g;
	//the animation will run very fast if myBucket.gravity==output.a
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
        //this.interval = setInterval(updateGameArea, 20);
		/*window.addEventListener('mousedown', function (e) {
            myGameArea.x = e.pageX;
            myGameArea.y = e.pageY;
        })
        window.addEventListener('mouseup', function (e) {
            myGameArea.x = false;
            myGameArea.y = false;
        })
		*/
		if (window.addEventListener) {
			window.addEventListener('click',clickHandler);
		} else if (window.attachEvent) {
			window.attachEvent('click', clickHandler);
		}
		
		
		firstUpdate();
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
	myGameArea.frameNo++;
    myGameArea.clear();
	
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

    myGamePiece.update();
	
	myBucket.newPos();
	myBucket.update();
	
	//count & print the output parameters and update position of slider when the bucket has not hit bottom
	if(!myBucket.hitBottom){
			output.time=myGameArea.frameNo*0.02;
	output.v=output.a*output.time;
	output.bucketE=(1/2)*myBucket.weight*Math.pow(output.v,2);
	output.s=(1/2)*output.a*Math.pow(output.time,2);
	output.Wg=myBucket.weight*output.g*output.s;
	output.sliderE=(1/2)*mySlider.weight*Math.pow(output.v,2);
	output.q=myGameArea.frictionFactor*mySlider.weight*output.g*output.s;
	
	document.getElementById("time").innerHTML=myGameArea.frameNo*0.02;
	document.getElementById("bucketA").innerHTML=output.a;
	document.getElementById("bucketV").innerHTML=output.v;
	document.getElementById("bucketE").innerHTML=output.bucketE;
	document.getElementById("bucketWg").innerHTML=output.Wg;
	document.getElementById("sliderA").innerHTML=output.a;
	document.getElementById("sliderV").innerHTML=output.v;
	document.getElementById("sliderE").innerHTML=output.sliderE;
	document.getElementById("sliderS").innerHTML=output.s;
	document.getElementById("Q").innerHTML=output.q;
		mySlider.x+=myBucket.speedY+myBucket.gravitySpeed;	
	}
	else{
		//set the speedX of myBucket to speed of myBucket when it hit the bottom of canvas for the first time
		if(myBucket.isSet==false){
			myBucket.isSet=true;
			mySlider.speedX=-(myBucket.speedY+myBucket.gravitySpeed);
		}
		mySlider.gravitySpeed+=mySlider.gravity;
		if(mySlider.speedX<=mySlider.gravitySpeed)
			mySlider.gravitySpeed=mySlider.speedX;
		mySlider.x+=mySlider.speedX-mySlider.gravitySpeed;
		if(mySlider.x>=605){
			mySlider.x=605;
			alert("小心点同学，别把滑轮给撞坏了 :-)");
			setWeight();
		}
		
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
	myRestartBt.update();
}

function firstUpdate(){
	
	 myGameArea.clear();
	 
	 ctx = myGameArea.context;
	 
	 myGamePiece.image.onload=function(){
			//draw myGamePiece the background
            ctx.drawImage(myGamePiece.image, myGamePiece.x, myGamePiece.y, myGamePiece.width, myGamePiece.height);
			
			//draw slider for the first time.
			mySlider.update();
	
			//draw line1 for the first time;
			myLine1.update();
	
			//draw line2 for the first time;
			myLine2.update();
	
			//draw line3 for the first time;
			myLine3.update();
	};

	//draw the bucket for the first time;
	myBucket.newPos();
	myBucket.image.onload=function(){
            ctx.drawImage(myBucket.image, myBucket.x, myBucket.y, myBucket.width, myBucket.height);};
	
	myStartBt.image.onload=function(){
            ctx.drawImage(myStartBt.image, myStartBt.x, myStartBt.y, myStartBt.width, myStartBt.height);};
			
	myPaperBt.image.onload=function(){
            ctx.drawImage(myPaperBt.image, myPaperBt.x, myPaperBt.y, myPaperBt.width, myPaperBt.height);};
	
	myRestartBt.image.onload=function(){
            ctx.drawImage(myRestartBt.image, myRestartBt.x, myRestartBt.y, myRestartBt.width, myRestartBt.height);};
}

//reset weight and friction factor and then restart game
function setWeight(){
	 //remove the old event listenner;
	 if (window.removeEventListener) {
			window.removeEventListener('click',clickHandler);
	 }	
	 else if (window.detachEvent) {
			window.detachEvent('click',clickHandler);
	 }
	
	 //restart the game;
	 if(myStartBt.isStart)
		myGameArea.stop();
	 startGame();
	 
	 myBucket.weight=Number(document.getElementById("bucket").value);
	 mySlider.weight=Number(document.getElementById("slider").value);
	 myGameArea.frictionFactor=Number(document.getElementById("frictionFactor").value);
	 mySlider.gravity=myGameArea.frictionFactor*0.03;
	 myBucket.gravity=(myBucket.weight-myGameArea.frictionFactor*mySlider.weight)/(myBucket.weight+mySlider.weight)*0.05;
	 output.a=(myBucket.weight-myGameArea.frictionFactor*mySlider.weight)/(myBucket.weight+mySlider.weight)*output.g;
	 //the animation will run very fast if myBucket.gravity==output.a
	// alert(myBucket.weight+" "+mySlider.weight+" "+myGameArea.fricitonFactor)
}

function clickHandler(e){
	myGameArea.x = e.pageX;
            myGameArea.y = e.pageY;
			if(myStartBt.clicked()){
				myStartBt.isStart=!myStartBt.isStart;
				if(myStartBt.isStart){ //the status of this button is start
					myStartBt.image.src="images/kineticEnergyLaw/pauseButton.jpg";
					myGameArea.interval = setInterval(updateGameArea, 20);
				}
				else{
					myStartBt.image.src="images/kineticEnergyLaw/startButton.jpg";
					myGameArea.stop();
				}
			}
			else if(myRestartBt.clicked()){
				setWeight();
			}
			else if(myPaperBt.clicked()){
				showPaper();
				//alert("you clicked paper button");
			}
			else if(left.clicked()){
				if(myPaperBt.isSet)
					output.base-=600;
				showPaper();
			}
			else if(right.clicked()){
				if(myPaperBt.isSet)
					output.base+=600;
				showPaper();
			}
			
}

function showPaper(){
	//pause the game;
	//output.base=10;
	myPaperBt.isSet=true;  //myPaperBt has been clicked
	var x=output.base;
	var s=0;
	var max=output.s*100;
	var times=0;
	myStartBt.isStart=false;
	myStartBt.image.src="images/kineticEnergyLaw/startButton.jpg";
	myGameArea.stop();
	
	ctx = myGameArea.context;
	
	var bg=new component(956, 537,"rgb(0, 0, 0,0.2)",0, 0);//draw background shade
	bg.update();     
	
	//draw the left contral button
	left.update();

	//draw the right contral button
	right.update();
	
	ctx.font = "40px Arial";
	ctx.fillStyle="rgb(0,0,0)";
	ctx.strokeText("左移",210,420);
	ctx.strokeText("右移",688,420);
	
	
	myPaper=new component(956,70,"rgb(204, 102, 0)",0,238);//draw myPaper
	myPaper.update();		
	

	
	ctx.font = "15px Arial";
	ctx.fillStyle="rgb(0,0,0)";
	
	
	ctx.beginPath();
	
	while(s<=max){
		s=(1/2)*output.a*Math.pow(times*0.02,2)*100;
		x=output.base+(1/2)*output.a*Math.pow(times*0.02,2)*5000;
		ctx.arc(x,273,3,0,2*Math.PI);
		s=Math.round(s*Math.pow(10,2))/Math.pow(10,2);
		if(times%2==0)
			ctx.fillText(s+"cm",x-5,300);
		else
			ctx.fillText(s+"cm",x-5,267);
		times++;
		//x+=10;
	}
	
	//var number= Math.round(num*Math.pow(10,n));
//  return number/Math.pow(10,n);
	
	
	ctx.stroke();
	
}







