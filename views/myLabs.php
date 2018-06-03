<html lang="zh-cn">
<?php

/**
 * Created by PhpStorm.
 * User: xiong
 * Date: 23/05/2018
 * Time: 6:42 PM
 */
session_start();
if(empty($_SESSION["username"])){
    header("Location:login.php");
    exit;
}
require_once("../models/lab.php");


$userId=$_SESSION["id"];
$userType=$_SESSION["usertype"];
$userTypeNum=1;
if($userType==="student")
    $userTypeNum=0;
?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>我的课程</title>
    <link rel="shortcut icon" href="images/seed.ico" />
    <link href="css/type.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://at.alicdn.com/t/font_529261_yyh9wnvuf9cz0k9.css">
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
            <li><a class="out" href="showCourses.php">我的课程</a></li>
            <?php
            if($userType=="teacher")
                echo '<li><a class="out" href="createCourse.php" >创建课程</a></li>';
            else
                echo '<li><a class="out" href="showCourses.php" >加入课程</a></li>';
            ?>
            <li><a class="on" href="myLabs.php">我的实验</a></li>

            <li><a class="out" href="buyLab_fake.php">购买实验</a></li>
            <li><a class="out" href="blank.html">练习题库</a></li>

        </ul>
    </div>
</div>
<!-------------------网页主体------------------->

<?php
//labs
echo "<h1 style='margin-left: 60px'>已购买的实验</h1>";
$labs=Lab::myLabs($userId,$userTypeNum);
if($labs){
if($labs->num_rows===0)
echo '<h2 style="margin:auto auto; color:red">您还没有购买过实验</h2>';
else {
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
    <span>'.$lab[3].'&nbsp&nbsp&nbsp价格：'.$lab[5].'</span>
</div>';
$counter++;
}
}
$labs->free();
}
?>



</body>
</html>