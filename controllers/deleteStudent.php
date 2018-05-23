<?php
/**
 * Created by PhpStorm.
 * User: xiong
 * Date: 22/05/2018
 * Time: 6:51 PM
 */
session_start();
require_once('../models/course.php');
require_once('../models/sc.php');

if(empty($_SESSION["username"])){
    header("Location:login.php");
    exit;
}
$courseId = "";
$studentId = "";
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $courseId = $_GET["courseid"];
    $studentId = $_GET["studentid"];
    $teacherId=Course::getTeacherId($courseId)->fetch_row()[0];//get the teacher's id of the given course
    echo $courseId."and student id: ".$studentId."teacher id should be: ".$teacherId;
    if($_SESSION["usertype"]==="teacher" && $_SESSION["id"]===$teacherId){
        SC::deleteStudent($studentId,$courseId);
    }
    header('Location: ../views/course.php?courseid='.$courseId);
    exit();


}