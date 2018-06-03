<!DOCTYPE html>
<?php
/**
 * Created by PhpStorm.
 * User: xiong
 * Date: 16/05/2018
 * Time: 5:12 PM
 *
 * role: view level file for showing courses that a user have.
 * pre-condition: input student/teacher's id
 * function: print courses that the student/teacher have
 * post-condition: a table of courses that the student/teacher have.
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
            <li><a class="on" href="showCourses.php">我的课程</a></li>
            <?php
            if($userType=="teacher")
                echo '<li><a class="out" href="createCourse.php" >创建课程</a></li>';
            else
                echo '<li><a class="out" href="showCourses.php" >加入课程</a></li>';
            ?>
            <li><a class="out" href="myLabs.php">我的实验</a></li>

            <li><a class="out" href="buyLab_fake.php">购买实验</a></li>
            <li><a class="out" href="blank.html">练习题库</a></li>
        </ul>
    </div>
</div>
<!-------------------网页主体------------------->


<?php
$userId=$_SESSION["id"];
$usertype=$_SESSION["usertype"];
$course_message="";

if($usertype==="teacher"){
    $message="";
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if(isset($_GET["error"]))
            $message="课程创建失败！";
        elseif(isset($_GET["success"]))
            $message="课程创建成功！";
    }

    $courses=Course::showCourses($userId);
    //print the table of courses
    echo '<span style="color:red;font-size: 20px">'.$message.'</span>';
    if($courses){
        if($courses->num_rows===0)
            echo '<span>您还没有课程</span><a href="createCourse.php"> 创建课程</a>';
        else {
            echo '<table style="margin: 100px auto" id="table-4"><tr><th>课程代码</th><th>课程名</th><th>创建时间</th><th></th></tr>';
            while ($row = $courses->fetch_row()) {
                echo '<tr>';
                foreach ($row as $_row)
                    echo '<td>' . $_row . '</td>';
                echo '<td><a href="course.php?courseid='.$row[0].'">进入课程 </a></td></tr>';
            }
            echo '</table><br>';
        }
        $courses->free();
    }

}
elseif($usertype==="student"){
    //handle 'join class'
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $courseId=$_POST["courseid"];
        if(SC::enrollStudent($userId,$courseId)) {
            $course=Course::getCourseInformation($courseId);
            $course_message = "成功加入课程: " .$course->fetch_row()[1]."<br>";
        }
        else{
            $course_message ="没有此课程或您已加入此课程.<br>";
        }
    }

    //join class
    echo '<div style="height:300px">
    <h1>加入课程: </h1><br>
    <form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">
   
         <span class="error" style="color:red">'.$course_message.'</span>
    <div class="panel">
        <div class="wrap">
            <input type="number" name="courseid" placeholder="请输入课程号">
            <button type="submit">提交</button>
        </div>
    </div>
    <div style="text-align:center;clear:both">
        <script src="/gg_bd_ad_720x90.js" type="text/javascript"></script>
        <script src="/follow.js" type="text/javascript"></script>
    </div>
</form>
</div>';


    //show courses
    $courses=SC::showCourses($userId);
    //print the table of courses
    if($courses){
        if($courses->num_rows===0)
            echo '<span class="error">您还没有课程</span>';
        else {
            echo '<h1 style="margin-top:50px">您的课程：</h1><br>';
            echo '<table ID="table-4" style="margin: 100px auto" ><tr><th>课程代码</th><th>课程名</th><th>老师姓名</th><th>老师邮箱</th><th></th></tr>';
            while ($row = $courses->fetch_row()) {
                echo '<tr>';
                foreach ($row as $_row)
                    echo '<td>' . $_row . '</td>';
                echo '<td><a href="course.php?courseid='.$row[0].'">进入课程</a></td></tr>';
            }
            echo '</table><br>';
        }
        $courses->free();
    }


}
?>


</body>
</html>
