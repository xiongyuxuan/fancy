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
    <link rel="stylesheet" href="css/type.css">
    <title>createCourses</title>
</head>
<form action="../controllers/createCourse.php" method="post">
    课程名：<input type="text" name="coursename"></input>
        <input type="submit">
</form>
<span class="error"><?php echo $error; ?></span>

</body>
</html>