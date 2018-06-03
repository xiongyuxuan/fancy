<!DOCTYPE html>
<?php
/**
 * Created by PhpStorm.
 * User: xiong
 * Date: 16/05/2018
 * Time: 5:13 PM
 *
 * role: view level file for creating a course
 * pre-condition: input courseName
 * function: insert a course record into table: courses
 * post-condition: -same as function if success
 *                 -show this page again with error message if fail.
 */
session_start();
$error="";
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if(isset($_GET["error"]))  $error="课程号不能为空";
    }


if(empty($_SESSION["username"])){
    header("Location:login.php");
    exit;
}
?>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>创建课程</title>
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
            <li><a class="on" href="createCourse.php" >创建课程</a></li>
            <li><a class="out" href="myLabs.php">我的实验</a></li>
            <li><a class="out" href="showCourses.php">我的课程</a></li>
            <li><a class="out" href="blank.html"">已购买实验</a></li>
            <li><a class="out" href="blank.html">练习题库</a></li>

        </ul>
    </div>
</div>
<!-------------------网页主体------------------->
<form action="../controllers/createCourse.php" method="post">
    <div class="panel">
        <div class="wrap">
            <input type="text" name="coursename" placeholder="请输入课程名">
            <button type="submit">提交</button>
        </div>
    </div>
    <div style="text-align:center;clear:both">
        <script src="/gg_bd_ad_720x90.js" type="text/javascript"></script>
        <script src="/follow.js" type="text/javascript"></script>
    </div>

</form>
<h2 class="error" style="color:#ff3428;text-align:center"><?php echo $error; ?></h2>

</body>
</html>