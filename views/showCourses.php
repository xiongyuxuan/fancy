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
?>
<html lang="zh-cn">
<head>
<title>
showCourses
</title>
    <link href="css/type.css" rel="stylesheet">
</head>
<body>
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
    echo '<span>'.$message.'</span>';
    if($courses){
        if($courses->num_rows===0)
            echo '<span>您还没有课程</span><a href="createCourse.php"> 创建课程</a>';
        else {
            echo '<table><tr><th>课程代码</th><th>课程名</th><th>创建时间</th><th></th></tr>';
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
    echo ' <h1>加入课程: </h1><br>
    <form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="post">
        <span class="error">'.$course_message.'</span>
       请输入课程号：<input type="number" name="courseid">
        <input type="submit">
    </form>';



    //show courses
    $courses=SC::showCourses($userId);
    //print the table of courses
    if($courses){
        if($courses->num_rows===0)
            echo '<span class="error">您还没有课程</span>';
        else {
            echo '<h1>您的课程：</h1><br>';
            echo '<table><tr><th>课程代码</th><th>课程名</th><th>老师姓名</th><th>老师邮箱</th><th></th></tr>';
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
