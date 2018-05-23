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
if(!isset($_GET["courseid"])){
    header("Location:showCourses.php");
    exit;
}
?>
<html lang="zh-cn">
<head>
    <title>
        Courses
    </title>
</head>
<body>
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
            echo '<span>课程代码: </span>' . $row[0] . '<br>';
            echo '<span>课程名: </span>' . $row[1] . '<br>';
            echo '<span>老师姓名: </span>' . $row[2] . '<br>';
            echo '<span>老师邮箱: </span>' . $row[3] . '<br>';
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
        echo '<table><tr><th>实验号</th><th>实验名</th><th></th></tr>';
        while ($row = $labs->fetch_row()) {
            echo '<tr>';
            foreach ($row as $_row)
                echo '<td>' . $_row . '</td>';
            echo '<td><a href="lab.php?labid='.$row[0].'">进入实验</a></td></tr>';
        }
        echo '</table><br>';
    }
    $labs->free();
}


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
            echo '<table><tr><th>学号</th><th>姓名</th><th>邮箱</th><th></th></tr>';
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
        while ($row = $chatmessages->fetch_row()) {
            $messageUserType="student";
            if($row[1]==="1")
                $messageUserType="teacher";
            echo '<p><span>'.$row[0].'</span><span>['. $messageUserType.' ]</span>&nbsp&nbsp&nbsp<span>'. $row[2] .'</span><br> <span>'. $row[3] .'</span></p>';
        }
    }
    $chatmessages->free();

    echo '<form action="../controllers/insertChatMessages.php" method="post">
    留言：<input type="text" name="content">
    <input type="text" name="courseid" value="'.$courseId.'" hidden>
    <input type="submit">
    </form>';
}

?>

</body>
</html>
