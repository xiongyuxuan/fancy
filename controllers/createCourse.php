<?php
/**
 * Created by PhpStorm.
 * User: xiong
 * Date: 16/05/2018
 * Time: 5:21 PM
 *
 * role: cotroller level file for creating a course
 * pre-condition: get post request from views/createCourse.php
 * function: insert a course record into table: courses
 * post-condition: -same as function, then call views/showCourses.php with success signal if success
 *                 -call views/createCourse.php with error signal if fail.
 */
session_start();
require_once('../models/course.php');
require_once('../tool.php');
?>
<html>
<head>
</head>
<body>
<?php
// the user is not a teacher
if($_SESSION["usertype"]!=="teacher") {
    echo "对不起，只有老师才能创建课程！";
    exit;
}
?>
</body>
</html>

    <?php
    $courseName="";
    $teacherId=$_SESSION["id"];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $courseName = $_POST["coursename"];
        $courseName=Tool::test_input($courseName);

        //input empty
        if (empty($courseName)) {
            header("Location: ../views/createCourse.php?error=1");
            exit;
        } else {
            $result=Course::createCourse($courseName,$teacherId);
            if($result===false){
                header('Location: ../views/showCourses.php?error=1');
                exit();
            }
            else{
                header('Location: ../views/showCourses.php?success=1');
                exit();
            }
        }

    }

    ?>