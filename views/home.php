<html lang="zh-cn">
<?php 
session_start();		

		if(empty($_SESSION["username"])){
				header("Location:login.php"); 
				exit;
		}
require_once("../models/lab.php");
?>
<head>
<meta charset="utf-8" />
<title>Fancy</title>
<link rel="shortcut icon" href="images/seed.ico" />
<link href="css/type.css" rel="stylesheet">
<link href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://at.alicdn.com/t/font_529261_yyh9wnvuf9cz0k9.css">
<link rel="stylesheet" href="css/carousel.css">
</head>

<body>
<!------------------------------网页头部-------------------------->
	<div style="width:100%; height:135px; margin:0px auto;">
	<div class="banner W">
    	<img src="images/logo.jpg" height="100" width="200">
        <div class="ban_right">
        	<span>
			<?php
			echo "hello,".$_SESSION['username'];
			?>
			<!--<a href="login.html">登陆</a>
			
			<a href=" ">注册</a>   -->
			
			</span>
            <div style="clear:right;"></div>
            <div class="ban_right2">
        		<input type="text" id="search">
            	<div class="search">
                	<a href="#"><img src="images/search.png"></a>
                </div>
            </div>
        </div>
    </div>
    </div>
<!------------------------------网页主体-------------------------->
	<div style="width:996px; height:40px; margin:0px auto";>
      <ul class="menu W">
          <li style="margin-left:15px;"><a href="index.html" target="_blank">首页</a></li>
          <li onMouseOver="show('nav_1','a1');" onMouseOut="hide('nav_1','a1')" style=" position:relative;"><a href=" " id='a1'>高中生 <i class="fa fa-chevron-down"></i></a>
          		<ul id="nav_1" style="position:absolute;">
                	<li><a href=" ">高中数学</a></li>
                	<li><a href=" ">高中物理</a></li>
                	<li><a href=" ">高中化学</a></li>
                	<li><a href=" ">高中生物</a></li>
                </ul>
          </li>
          <li onMouseOver="show('nav_2','a2');" onMouseOut="hide('nav_2','a2')" style=" position:relative;"><a href=" " id="a2">初中生 <i class="fa fa-chevron-down"></i></a>
          		<ul id="nav_2" style="position:absolute;">
                	<li><a href=" ">初中数学</a></li>
                	<li><a href=" ">初中物理</a></li>
                	<li><a href=" ">初中化学</a></li>
                	<li><a href=" ">初中生物</a></li>
                </ul>
          </li>
          <li onMouseOver="show('nav_3','a3');" onMouseOut="hide('nav_3','a3')" style=" position:relative;"><a href=" " id="a3">小学生 <i class="fa fa-chevron-down"></i></a>
          		<ul id="nav_3" style="position:absolute;">
                	<li><a href=" ">小学数学</a></li>
                </ul>
          </li>
          <li onMouseOver="show('nav_4','a4');" onMouseOut="hide('nav_4','a4')" style=" position:relative;"><a href=" " id="a4">高中教学 <i class="fa fa-chevron-down"></i></a>
          		<ul id="nav_4" style="position:absolute;">
                	<li><a href=" ">高中数学教学</a></li>
                	<li><a href=" ">高中物理教学</a></li>
                	<li><a href=" ">高中化学教学</a></li>
                	<li><a href=" ">高中生物教学</a></li>
                </ul>
          </li>
          <li onMouseOver="show('nav_5','a5');" onMouseOut="hide('nav_5','a5')" style=" position:relative;"><a href=" " id="a5">初中教学 <i class="fa fa-chevron-down"></i></a>
          		<ul id="nav_5" style="position:absolute;">
                	<li><a href=" ">初中数学教学</a></li>
                	<li><a href=" ">初中物理教学</a></li>
                	<li><a href=" ">初中化学教学</a></li>
					<li><a href=" ">初中生物教学</a></li>
                </ul>
          </li>
          
          <li onMouseOver="show('nav_6','a6');" onMouseOut="hide('nav_6','a6')" style=" position:relative;"><a href=" " id="a6">小学教学 <i class="fa fa-chevron-down"></i></a>
          		<ul id="nav_6" style="position:absolute;">
                	<li><a href=" ">小学数学教学</a></li>
                </ul>
          </li>
		  <li style="margin-left:15px;"><a href="index.html" target="_blank">练习题库</a></li>
		  <li style="margin-left:15px;"><a href="index.html" target="_blank">留言&在线答疑</a></li>
      </ul>
<script type="text/javascript">
 	function show(id,a){
        document.getElementById(id).style.display='block';
		document.getElementById(a).style.color="#fff";
    }
    function hide(id,a){
        document.getElementById(id).style.display='none';
		document.getElementById(a).style.color="#000";
    }
</script>

<div id="carousel" class="carousel" @mouseover="isCarousel=true" @mouseout="isCarousel=false">
			<div class="carousel-inner">
				<transition name="carousel-animates"
							enter-class="carousel-animate-enter"
							leave-class="carousel-animate-leave"
							:leave-active-class="leaveToClass">
					<template>
						<div class="item" :key="active" >
							<a :href="carousel[active].url" :title="carousel[active].title">
								<img :src="carousel[active].image" alt="">
							</a>
						</div>
					</template>
				</transition>
			</div>
			<ol class="carousel-indicators">
				<li @click="move(active>index?-1:1,index)" v-for="(item,index) in carousel" :key="index" :class="index===active?'item active':'item'">{{index+1}}</li>
			</ol>
			<a @click="move(-1)" class="left carousel-control"><i class="iconfont icon-zuo"></i></a>
			<a @click="move(1)" class="right carousel-control"><i class="iconfont icon-you"></i></a>
		</div>
		<script src="https://cdn.jsdelivr.net/npm/vue@2.5.13/dist/vue.js"></script>
		<script src="js/carousel.js"></script>

		<div class="content W">
    	<ul class="xw">
        	<li class="xw_top">
            <h2>学习素材</h2>
            </li>
        	<li class="xw1">
				<p><i class="fa fa-book"></i>
				<span>2018.02</span>
				</p>
            </li>
        	<li class="xw2">
            <h3><a href=" ">如何清晰掌握牛顿三大定律！</a></h3>
			<span>具体目标：  1.理解牛顿第一定律的内容和意义 2.知道什么是惯性，会正确解释有关现象 3.正确理解力和运动的关系 4.掌握牛顿第二定律的内容，理解公式中各物理量的意义及相互关系。</span>
            </li>
        	<li class="xw1">
				<p><i class="fa fa-book"></i>
				<span>2018.01</span>
			</p>
            </li>
        	<li class="xw2">
            	<h3><a href=" ">如何验证机械能守恒定理？</a></h3>
				<span>实验原理：只有在重力做功的自由落体运动中，物体的重力势能和动能可以互相转化，但总的机械能守恒。如果忽略空气阻力，这时物体的机械能守恒，即重力势能的减少等于动能的增加。</span>
            </li>
        	<li class="xw1">
				<p><i class="fa fa-book"></i>
					<span>2018.03</span>
				</p>
            </li>
        	<li class="xw2">
            	<h3><a href="qhxw.html">验证动量守恒定理</a></h3>
				<span>实验原理：在一维碰撞中，测出物体的质量m和碰撞前后物体的速度v、v′，找出碰撞前的动量p＝m1v1＋m2v2及碰撞后的动量p′＝m1v1′＋m2v2′，看碰撞前后动量是否守恒。</span>
            </li>
        </ul>
        <div class="jdgz">
        	<div class="jdgz_top">
            	<h2>示范实验</h2>
            </div>


            <!--show all the labs which is stored in the database;-->
            <?php
            $labs=Lab::getAllLabs();
            $counter=0;
            while ($lab = $labs->fetch_row()) {
                echo '
                <div class="jdgz'.($counter%2+1).'">
            	<a href="lab.php?labid='.$lab[4].'">';
                if($lab[2])
				    echo '<img class="new-ribbon" src="images/new.png" alt="new-ribbon">';
				echo '
                <img src="images/'.$lab[0].'/cover.jpg" height="120" width="290px;"></a>
				<p><a href="lab.php?labid='.$lab[4].'">'.$lab[1].'</a></p>
				<span>'.$lab[3].'</span>
			</div>';
				$counter++;
            }

            ?>


            <!--show fake labs-->
			<div class="jdgz1">
				<a href="blank.html"><img src="images/cover.jpg" height="120" width="290px;"></a>
				<p><a href="blank.html">如何验证杠杆原理？</a></p>
				<span>杠杆原理巴拉巴拉</span>
			</div>
        	<div class="jdgz2">
            <a href="blank.html"><img src="images/cover.jpg" height="120" width="290px;"></a>
				<p><a href="blank.html">如何计算加速度？</a></p>
				<span>加速度巴拉巴拉</span>
			</div>
			<div class="jdgz1">
				<a href="blank.html"><img src="images/cover.jpg" height="120" width="290px;"></a>
				<p><a href="blank.html">如何验证杠杆原理？</a></p>
				<span>杠杆原理巴拉巴拉</span>
			</div>
			<div class="jdgz2">
				<a href="blank.html"><img src="images/cover.jpg" height="120" width="290px;"></a>
				<p><a href="blank.html">如何验证牛顿第二定律</a></p>
				<span>牛顿第二定理吧啦吧啦</span></div>




        <div style="clear:both;"></div>
        <div class="link">
        	<div class="link1_left">
            	<div class="link1_top">
                	常用链接
                </div>
                <ul class="ul2">
                	<li style="margin-right:85px;"><a href="index.html">高中学习资料 ></a></li>
                	<li style="margin-right:95px;"><a href="index.html">初中学习资料 ></a></li>
                	<li style="margin-right:35px;"><a href="index.html">小学学习资料 ></a></li>
                </ul>
            </div>
            
            <div class="link1_right">
            	<a href=" "><img src="images/link1.jpg" height="105" width="245"></a>
                <a href=" "><img src="images/link2.jpg" height="105" width="115"></a>
                <a href=" "><img src="images/link3.jpg" height="105" width="115"></a>
            </div>
        </div>
<!------------------------网页底部------------------------------->
        <div class="bottom W">
        	<span style="display:block; float:left; margin-top:25px;">联系电话：15687848022&nbsp;&nbsp;&nbsp;&nbsp;管理员信箱：2752682181@qq.com&nbsp;&nbsp;&nbsp;&nbsp;地址：重庆市西南大学</span>
        </div>
          </div>
		</div>
	</div>
</body>
</html>
