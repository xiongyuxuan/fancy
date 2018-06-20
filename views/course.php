<!DOCTYPE html>
<?php
/**
 * Created by PhpStorm.
 * User: xiong
 * Date: 22/05/2018
 * Time: 10:09 AM
 */

/* role:view level file for show detail information of a certain course information, including message in course and test papers
** pre-condition: get course id from views/showCourses.php
 * function: show course info and offer a platform for message and test papers.
 * post-condition: same as function
*/

session_start();
require_once('../models/course.php');
require_once('../models/lab.php');
require_once('../controllers/course.php');
require_once('../models/sc.php');
require_once('../models/chatmessage.php');
if(empty($_SESSION["username"])){
    header("Location:login.php");
    exit;
}
$userType=$_SESSION['usertype'];
if(!isset($_GET["courseid"])){
    header("Location:showCourses.php");
    exit;
}
?>
<head>
    <meta charset="utf-8" />
    <title>课程</title>
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
    <style>
        body{
            background:url("images/bg_02.png");
        }
        span, h1{
            margin-left: 50px;
        }
        span {
            font-size: 20px;
        }
        .white-pink {
            margin-left:auto;
            margin-right:auto;
            max-width: 900px;
            background: # FFF;
            padding: 30px 30px 20px 30px;
            box-shadow: rgba(187, 187, 187, 1) 0 0px 20px -1px;
            -webkit-box-shadow: rgba(187, 187, 187, 1) 0 0px 20px -1px;
            font: 12px Arial, Helvetica, sans-serif;
            color: # 666;
            border-radius: 10px;
            -webkit-border-radius: 10px;
        }
        .white-pink h1 {
            font: 24px "Trebuchet MS", Arial, Helvetica, sans-serif;
            padding: 0px 0px 10px 40px;
            display: block;
            border-bottom: 1px solid # F5F5F5;
            margin: -10px -30px 10px -30px;
            color: # 969696;
        }
        .white-pink h1>span {
            display: block;
            font-size: 11px;
            color: # C4C2C2;
        }
        .white-pink label {
            display: block;
            margin: 0px 0px 5px;
        }
        .white-pink label>span {
            float: left;
            width: 20%;
            text-align: right;
            padding-right: 10px;
            margin-top: 10px;
            color: # 969696;
        }
        .white-pink input[type="text"], .white-pink input[type="email"], .white-pink textarea,.white-pink select{
            color: # 555;
            width: 70%;
            padding: 3px 0px 3px 5px;
            margin-top: 2px;
            margin-right: 6px;
            margin-bottom: 16px;
            border: 1px solid # e5e5e5;
            background: # fbfbfb;
            height: 25px;
            line-height:15px;
            outline: 0;
            -webkit-box-shadow: inset 1px 1px 2px rgba(200,200,200,0.2);
            box-shadow: inset 1px 1px 2px rgba(200,200,200,0.2);
        }
        .white-pink textarea{
            height:100px;
            padding: 5px 0px 0px 5px;
            width: 70%;
        }
        .white-pink .button {
            -moz-box-shadow:inset 0px 1px 0px 0px # fbafe3;
            -webkit-box-shadow:inset 0px 1px 0px 0px # fbafe3;
            box-shadow:inset 0px 1px 0px 0px # fbafe3;
            background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, # ff5bb0), color-stop(1, # ef027d) );
            background:-moz-linear-gradient( center top, # ff5bb0 5%, # ef027d 100% );
            filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='# ff5bb0', endColorstr='# ef027d');
            background-color:# ff5bb0;
            border-radius:9px;
            -webkit-border-radius:9px;
            -moz-border-border-radius:9px;
            border:1px solid # ee1eb5;
            display:inline-block;
            color:# ffffff;
            font-family:Arial;
            font-size:15px;
            font-weight:bold;
            font-style:normal;
            height: 40px;
            line-height: 30px;
            width:100px;
            text-decoration:none;
            text-align:center;
            text-shadow:1px 1px 0px # c70067;
        }
        .white-pink .button:hover {
            background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, # ef027d), color-stop(1, # ff5bb0) );
            background:-moz-linear-gradient( center top, # ef027d 5%, # ff5bb0 100% );
            filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='# ef027d', endColorstr='# ff5bb0');
            background-color:# ef027d;
        }
        .white-pink .button:active {
            position:relative;
            top:1px;
        }
        .white-pink select {
            background: url('down-arrow.png') no-repeat right, -moz-linear-gradient(top, # FBFBFB 0%, # E9E9E9 100%);
            background: url('down-arrow.png') no-repeat right, -webkit-gradient(linear, left top, left bottom, color-stop(0%,# FBFBFB), color-stop(100%,# E9E9E9));
            appearance:none;
            -webkit-appearance:none;
            -moz-appearance: none;
            text-indent: 0.01px;
            text-overflow: '';
            width: 70%;
            line-height: 15px;
            height: 30px;
        }

    </style>
</head>

<body background="images/bg_02.png">
<div class="banner">
    <div class="banner1">
        <div class="ban_top w">
            <a href="home.php"><img src="images/logo.jpg" height="80" width="150" /></a>
        </div>
        <ul class="ban_list w">
            <li><a class="out" href="home.php">首页</a></li>
            <li><a class="on" href="showCourses.php">我的课程</a></li>
            <?php
            if($userType=="teacher")
                echo '<li><a class="out" href="createCourse.php" >创建课程</a></li>';
            else
                echo '<li><a class="out" href="showCourses.php" >加入课程</a></li>';
            ?>
            <li><a class="out" href="myLabs.php">我的实验</a></li>

            <li><a class="out" href="blank.html">购买实验</a></li>
            <li><a class="out" href="blank.html">练习题库</a></li>

        </ul>
    </div>
</div>
<?php
$userId=$_SESSION["id"];
$userNmae=$_SESSION["username"];
$userType=$_SESSION["usertype"];

$courseId="";
$teacherId="";
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $courseId=$_GET["courseid"];
}
//course info
echo '<h1>课程信息</h1>';
$course=Course::getCourseInformation($courseId);
//print the table of courses
if($course){
    if($course->num_rows===0)
        echo '<span>课程信息查询出错，请联系管理员解决</span>';
    else {
        echo '</th><th></th><th></th><th></th><th>';
        while ($row = $course->fetch_row()) {
            echo '<span>课程代码:' . $row[0] . '</span><br>';
            echo '<span>课程名:' . $row[1] . '</span><br>';
            echo '<span>老师姓名:' . $row[2] . '</span><br>';
            echo '<span>老师邮箱:' . $row[3] . '</span><br>';
        }
    }
    $course->free();
}


//labs
echo "<h1>仿真实验</h1>";
$labs=CourseController::showLabs($courseId);
if($labs){
    if($labs->num_rows===0)
        echo '<span>此课程还没有可用实验，可邀请老师购买课程，则所有同学可以使用</span>';
    else {
        $counter=0;
        echo '<div style="margin-left:30px">';
        while ($lab = $labs->fetch_row()) {

            echo '
                <div class="jdgz'.($counter%2+1).'">
            	<a href="lab.php?labid='.$lab[4].'">';
            if($lab[2])
                echo '<img class="new-ribbon" src="images/new.png" alt="new-ribbon">';
            echo '
                <img src="images/'.$lab[0].'/cover.jpg" height="120" width="290px;"></a>
				<p><a href="lab.php?labid='.$lab[4].'">'.$lab[1].'</a></p>
				<span>'.$lab[3].'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp价格： '.$lab[5].'&nbsp&nbsp&nbsp&nbsp&nbsp实验类型：'.$lab[6].'</span>
			</div>';
            $counter++;
        }
        echo "</div>";
    }
    $labs->free();
}
?>
<div style="clear:both;"></div>

<?php


//papers
    //echo "<h1>试卷</h1>";

//student information
if($userType==="teacher") {
    //studentid, studentname,student
    echo '<h1>学生信息</h1>';


    $students = SC::showStudents($courseId);
    if ($students) {
        if ($students->num_rows === 0)
            echo '<span>您还没有学生</span>';
        else {
            echo '<table ID="table-4" style="margin: 100px auto"><tr><th>学号</th><th>姓名</th><th>邮箱</th><th></th></tr>';
            while ($row = $students->fetch_row()) {
                echo '<tr>';
                foreach ($row as $_row)
                    echo '<td>' . $_row . '</td>';
                echo '<td><a href="../controllers/deleteStudent.php?courseid=' . $courseId . '&studentid=' . $row[0] . '">删除学生</a></td></tr>';
            }
            echo '</table><br>';
        }
        $students->free();
    }
}

//inner course messages
echo '<h1>留言</h1>';
$chatmessages =ChatMessage::getChatMessages($courseId);
if ($chatmessages) {
    if ($chatmessages->num_rows === 0)
        echo '<span>还没有人留言，赶紧来抢沙发吧！</span>';
    else {
        echo '<div class="white-pink">';
        while ($row = $chatmessages->fetch_row()) {
            $messageUserType="student";
            if($row[1]==="1")
                $messageUserType="teacher";
            echo '<p class="white-pink" ><span style="color:red ">'.$row[0].'</span><span>['. $messageUserType.' ]</span>&nbsp&nbsp&nbsp<span>'. $row[2] .'</span><br> <span>'. $row[3] .'</span></p>';
        }
        echo "</div>";
    }
    $chatmessages->free();

    echo '<form action="../controllers/insertChatMessages.php" method="post" class="white-pink">
    <input type="submit" value="留言"><br>
     <textarea name="content" rows="10" cols="80" placeholder="说些什么吧..."></textarea>
    <input type="text" name="courseid" value="'.$courseId.'" hidden>
    
    </form>';
}

?>
</body>
</html>
