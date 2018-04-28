var deviation=8;//coordinate of canvas' left top point is (8,8)
var bg; //background 
var scale;  //scale of the pixel to meter, that is: 1px=scale meter
var compasses=[];  //array of compasses
var controlPanel;//the yellow rectangle
var originElectricCharge;//user create electric charge from this eletric charge
var electricCharges=[];// array of electric charges
var originChargeAmount=-2;//initial charge amount of origin electric charge
var k=9e9; //Coulomb constant
var sensor;//sensor of the system

function startGame() {
	scale=0.05;
    bg = new component(956, 537, "black", 0, 0);
	controlPnal=new component(240,60,"yellow",358,477);	
	originElectricCharge=new electricCharge(440,510,20,0,"blue");
	sensor=new electricCharge(390,510,10,0,"rgb(153, 0, 204)",true);
	var i=0;
	for(i=0;i<350;i++){
		compasses.push(new compass((20+i*40)%1000,20+Math.floor(i/25)*40,15,"green","yellow"));
	}
    myGameArea.start();
	
}

var myGameArea = {
    canvas : document.createElement("canvas"),
    start : function() {
        this.canvas.width = 956;
        this.canvas.height = 537;
		this.frameNo=0;
        this.context = this.canvas.getContext("2d");
        document.body.insertBefore(this.canvas, document.body.childNodes[0]);
		
		if (window.addEventListener) {
			window.addEventListener('mousedown',clickHandler);
		} else if (window.attachEvent) {
			window.attachEvent('mousedown', clickHandler);
		}
		
		if (window.addEventListener) {
			window.addEventListener('mouseup',mouseUpHandler);
		} else if (window.attachEvent) {
			window.attachEvent('mouseup', mouseUpHandler);
		}
		
		if (window.addEventListener) {
			window.addEventListener('mousemove',mouseMoveHandler);
		} else if (window.attachEvent) {
			window.attachEvent('mousemove', mouseMoveHandler);
		}
		
		this.interval = setInterval(updateGameArea, 20);
        },
    clear : function() {
        this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
    },
    stop : function() {
        clearInterval(this.interval);
    },
	x:0,
	y:0,
	isMouseDown:false
}

function compass(x1,y1,r,color1,color2) {
	this.x1=x1;
	this.y1=y1;
	this.color1=color1;
	this.color2=color2;
	this.Ex=1;
	this.Ey=-1;
	this.x2=this.x1+r*(this.Ex/Math.sqrt(Math.pow(this.Ex,2)+Math.pow(this.Ey,2)));
	this.y2=this.y1+r*(this.Ey/Math.sqrt(Math.pow(this.Ex,2)+Math.pow(this.Ey,2)));
	
	this.update= function(){
		ctx=myGameArea.context;

		ctx.beginPath();
		ctx.lineWidth=1;
		ctx.fillStyle=this.color1;
		ctx.moveTo(this.x1,this.y1);
		ctx.lineTo(this.x2,this.y2);
		ctx.strokeStyle = color1;
		ctx.stroke();
		
		ctx.arc(this.x1-1,this.y1+9,0,Math.PI,2*Math.PI);
		ctx.moveTo(this.x1,this.y1);
		ctx.lineTo(this.x2,this.y2);
		ctx.arc(this.x1-7,this.y1+1,0,0,2*Math.PI);
		ctx.fill();
		
		ctx.beginPath();
		ctx.fillStyle=this.color2;
		ctx.moveTo(this.x1,this.y1);
		ctx.lineTo(2*this.x1-this.x2,2*this.y1-this.y2);
		ctx.strokeStyle = color2;
		ctx.stroke();
	}

	//to update the position of compass line
    this.newPos = function() {
		this.Ex=0;
		this.Ey=0;
		for(i=0;i<electricCharges.length;i++){
			var x=electricCharges[i].x1-this.x1;
			x*=scale;
			var y=electricCharges[i].y1-this.y1;
			y*=scale;
			var z=Math.sqrt(Math.pow(x,2)+Math.pow(y,2));
			this.Ex+=(-k*electricCharges[i].chargeAmount*(x/z))/Math.pow(z,2);
			this.Ey+=(-k*electricCharges[i].chargeAmount*(y/z))/Math.pow(z,2);
		}
		
		this.x2=this.x1+r*(this.Ex/Math.sqrt(Math.pow(this.Ex,2)+Math.pow(this.Ey,2)));
		this.y2=this.y1+r*(this.Ey/Math.sqrt(Math.pow(this.Ex,2)+Math.pow(this.Ey,2)));
	
    }
}
function electricCharge(x1,y1,r,chargeAmount,color,isSensor) {
	this.x1=x1;
	this.y1=y1;
	this.x2;//just for sensor
	this.y2;//just for sensor
	this.Ex;//just for sensor
	this.Ey;//just for sensor
	this.E=0;//just for sensor
	this.isShowArrow=false//just for sensor
	this.r=r;
	this.chargeAmount=chargeAmount;
	this.color=color;
	this.onControl=false;
	this.isSensor=isSensor;
	this.update= function(){
		var gradient = ctx.createRadialGradient(this.x1, this.y1, 1/5*r, this.x1, this.y1, 3/2*r);
		gradient.addColorStop(0, this.color);
		gradient.addColorStop(1, "white");
		
		ctx=myGameArea.context;
		ctx.beginPath();
		ctx.fillStyle=gradient;
		//ctx.fillStyle=this.color;
		ctx.arc(this.x1,this.y1,r,0,2*Math.PI);
		if(this.chargeAmount!=0)
			ctx.fillText("q= "+this.chargeAmount+" mC",this.x1-30,this.y1+30);
		ctx.fill();
		
		//draw the arrow if it is sensor
		if(this.isSensor){
			ctx.beginPath();
			ctx.lineWidth=3;
			ctx.moveTo(this.x1,this.y1);
			ctx.lineTo(this.x2,this.y2);
			ctx.strokeStyle = this.color;
			ctx.stroke();
		}
	}
	
	//check if it is clicked by user;
	this.clicked = function() {
        var myleft = this.x1-this.r;
        var myright = this.x1 + this.r;
        var mytop = this.y1-this.r;
        var mybottom = this.y1 + this.r;
        var clicked = true;
		if ((mybottom < myGameArea.y) || (mytop > myGameArea.y) || (myright < myGameArea.x) || (myleft > myGameArea.x)) {
            clicked = false;
        }
        return clicked;
    }
	
	this.isAbandon = function() {
		var abandon=true;
		var left=controlPnal.x;
		var right=controlPnal.x+controlPnal.width;
		var top=controlPnal.y;
		var bottom=controlPnal.y+controlPnal.height;
		if((this.x1<left)||(this.x1>right)||(this.y1<top)||(this.y1>bottom))
			abandon=false;
		return abandon;
	}
	
	//to update the position of compass line
    this.newPos = function() {
		this.x1=myGameArea.x;
		this.y1=myGameArea.y;
    }
	this.countE=function(){
		//similar as those in compass;
			if(this.isShowArrow){
			this.Ex=0;
			this.Ey=0;
			for(i=0;i<electricCharges.length;i++){
				var x=electricCharges[i].x1-this.x1;
				x*=scale;
				var y=electricCharges[i].y1-this.y1;
				y*=scale;
				var z=Math.sqrt(Math.pow(x,2)+Math.pow(y,2));
				this.Ex+=(-k*electricCharges[i].chargeAmount*(x/z))/Math.pow(z,2);
				this.Ey+=(-k*electricCharges[i].chargeAmount*(y/z))/Math.pow(z,2);
			}
			
			this.E=1e-3*Math.sqrt(Math.pow(this.Ex,2)+Math.pow(this.Ey,2));
			this.x2=this.x1+1e-6*this.Ex;
			this.y2=this.y1+1e-6*this.Ey;
			
			}
			else{
				this.x1=390;//the original position
				this.y1=510;
				this.x2=this.x1;
				this.y2=this.y1;
			}
	}
}

function component(width, height, color, x, y, type) {
    this.type = type;
	this.width = width;
    this.height = height; 
    this.x = x;
    this.y = y; 
	this.color=color;
    if (type == "image") {
        this.image = new Image();
        this.image.src = color;
    }
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
	
}

function updateGameArea() {
	myGameArea.frameNo++;
    myGameArea.clear();

    bg.update();
	
	//draw the compasses;
	for(i=0;i<350;i++){
		compasses[i].update();
	}
	

	
	//draw the control panel;
	controlPnal.update();
	originElectricCharge.update();	
		ctx.beginPath();
		ctx=myGameArea.context;
		ctx.fillStyle="black";
		ctx.font = "20px Arial";
		ctx.fillText("Q="+originChargeAmount+" mC",470,516);
		ctx.fillText("sensor",360,535);
		
	for(i=0;i<electricCharges.length;i++)
		electricCharges[i].update();
	
	sensor.update();
	document.getElementById("sensor1").innerHTML=sensor.E;
	document.getElementById("sensor2").innerHTML=sensor.E/k+"*k";
}

function clickHandler(e){
			myGameArea.x = e.pageX-deviation;
            myGameArea.y = e.pageY-deviation;
			myGameArea.isMouseDown=true;
			
			//create a electric charge when user drag the orgin electric charge;
			if(originElectricCharge.clicked()){
				if(originChargeAmount<=0){//create a electric charge with nagetive value;
					electricCharges.push(new electricCharge(myGameArea.x,myGameArea.y,10,originChargeAmount,"blue"));
				}
				else{
					electricCharges.push(new electricCharge(myGameArea.x,myGameArea.y,10,originChargeAmount,"red"));
				}	
			}	
			
			//check if the electricCharge is on control by mouse or not.
			for(i=0;i<electricCharges.length;i++){
				if(electricCharges[i].clicked()){
					electricCharges[i].onControl=true;
				}
			}
			
			if(sensor.clicked()){
				sensor.onControl=true;
				sensor.isShowArrow=true;
			}
}

function mouseMoveHandler(e){
		myGameArea.x = e.pageX-deviation;
        myGameArea.y = e.pageY-deviation;
		if(myGameArea.isMouseDown==true){//only when user press the mouse will js handle the event
			for(i=0;i<electricCharges.length;i++){
				if(electricCharges[i].clicked()||electricCharges[i].onControl){//if delete ||electricCharges[i].onControl, electric charge will not chage position when user move mouse too fast;
					electricCharges[i].newPos();
					for(j=0;j<350;j++)
						compasses[j].newPos();
					sensor.countE();
					
				}
			}
			
			if(sensor.clicked()||sensor.onControl){//update the position of sensor;
				sensor.newPos();
				sensor.countE();
			}
		}
		
		var showX=Math.round(myGameArea.x*scale*Math.pow(10,2))/Math.pow(10,2);
		var showY=Math.round(myGameArea.y*scale*Math.pow(10,2))/Math.pow(10,2);
		
		document.getElementById("time").innerHTML="("+showX+"m, "+showY+"m)";
}

function mouseUpHandler(e){
		myGameArea.isMouseDown=false;
		for(i=0;i<electricCharges.length;i++){
			electricCharges[i].onControl=false;
			if(electricCharges[i].isAbandon()){
				electricCharges.splice(i, 1);//delete the electric charge
				
				for(j=0;j<350;j++)//renew the position of compass;
						compasses[j].newPos();
			}
		}
		
		sensor.onControl=false;
		if(sensor.isAbandon()){
			sensor.isShowArrow=false;
			sensor.countE();
			sensor.update();
		}
}

function setQ(){
	originChargeAmount=Number(document.getElementById("q").value);
	originChargeAmount=Math.round(originChargeAmount*Math.pow(10,4))/Math.pow(10,4);
	
	if(originChargeAmount<=0)
		originElectricCharge.color="blue";
	else
		originElectricCharge.color="red";
}
