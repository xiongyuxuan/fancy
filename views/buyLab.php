<!DOCTYPE html>
<?php
/**
 * Created by PhpStorm.
 * User: xiong
 * Date: 23/05/2018
 * Time: 6:29 PM
 */
session_start();
if(empty($_SESSION["username"])){
    header("Location:login.php");
    exit;
}
$userId=$_SESSION["id"];
$userType=$_SESSION["usertype"];

require_once("../models/lab.php");
?>
<html lang="zh-cn">
<head>
    <meta charset="utf-8" />
    <title>购买实验</title>
    <link rel="shortcut icon" href="images/seed.ico" />
    <link href="css/type.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://at.alicdn.com/t/font_529261_yyh9wnvuf9cz0k9.css">
    <link href="css/showCourse.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/carousel.css">
    <link href="css/fancyInput.css" rel="stylesheet" />
    <style>
        body{
            background:url("images/bg_02.png");
        }
    </style>
</head>

<body>

<!-------------------网页头部------------------->
<div class="banner" style="margin-bottom: 30px">
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

            <li><a class="on" href="blank.html">购买实验</a></li>
            <li><a class="out" href="blank.html">练习题库</a></li>

        </ul>
    </div>
</div>



<!--网页主体-->
<?php

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $labId = $_GET["labid"];
    $lab = Lab::getLabById($labId);

    if (Lab::isAvailable($labId, $userId, $userType)) {
        header("Location:home.php");
        exit;
    }

    if ($lab = $lab->fetch_row()) {
        echo '
                <div class="jdgz1">
            	<a href="lab.php?labid=' . $lab[4] . '">';
        if ($lab[2])
            echo '<img class="new-ribbon" src="images/new.png" alt="new-ribbon">';
        echo '
                <img src="images/' . $lab[0] . '/cover.jpg" height="120" width="290px;"></a>
				<p><a href="lab.php?labid=' . $lab[4] . '">' . $lab[1] . '</a></p>
				<span style="color: red">'.$lab[3].'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp价格： '.$lab[5].'</span>
			</div>';
        } else {
        header("Location:home.php");
        exit;
        }
    }
?>
<form action="../controllers/buyLab.php" method="post">
    <input type="text" name="labid" value="<?php echo $labId ?>" hidden>
    <input type="submit" value="购买">
</form>


</body>
</html>
