<!DOCTYPE html>
<?php
/**
 * Created by PhpStorm.
 * User: xiong
 * Date: 3/06/2018
 * Time: 7:29 PM
 */
session_start();
require_once('../models/course.php');
require_once('../models/sc.php');
if(empty($_SESSION["username"])){
    header("Location:login.php");
    exit;
}
$userType=$_SESSION["usertype"];
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>我的课程</title>
    <link rel="shortcut icon" href="images/seed.ico" />
    <link href="css/showCourse.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/carousel.css">
    <link href="css/fancyInput.css" rel="stylesheet" />
    <script>
        window.onload=function(){
            change();
            C1Change();
        }
    </script>
    <style>
        h1{
            margin-left: 50px;
        }
    </style>
</head>
<body background="images/bg_02.png">
<!-------------------网页头部------------------->
<div class="banner">
    <div class="banner1">
        <div class="ban_top w">
            <a href="home.php"><img src="images/logo.jpg" height="80" width="150" /></a>
        </div>
        <ul class="ban_list w">
            <li><a class="out" href="home.php">首页</a></li>
            <li><a class="out" href="showCourses.php">我的课程</a></li>
            <?php
            if($userType=="teacher")
                echo '<li><a class="out" href="createCourse.php" >创建课程</a></li>';
            else
                echo '<li><a class="out" href="showCourses.php" >加入课程</a></li>';
            ?>
            <li><a class="out" href="myLabs.php">我的实验</a></li>

            <li><a class="on" href="buyLab_fake.php">购买实验</a></li>
            <li><a class="out" href="blank.html">练习题库</a></li>
        </ul>
    </div>
</div>
<h1 style="color:red">请到具体的实验页面下进行购买   ^_^</h1>
</body>
</html>