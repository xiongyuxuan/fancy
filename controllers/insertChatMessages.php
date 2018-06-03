<?php
/**
 * Created by PhpStorm.
 * User: xiong
 * Date: 22/05/2018
 * Time: 8:42 PM
 *
 *
 * role: control level file for  inserting a charmessage
 * pre-condition: login,get request from views/course.php,require courseid,content
 * funciton: insert a chatmessage into database
 * post-condition: a record is inserted into Table: chatmessages
 *
 */

session_start();
require_once('../models/sc.php');
require_once('../models/chatmessage.php');
require_once('../tool.php');
if(empty($_SESSION["username"])){
    header("Location:login.php");
    exit;
}
$courseId = "";
$userId =$_SESSION["id"];
$content="";
$userType=0;

if($_SESSION["usertype"]==="teacher")
    $userType=1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $courseId = $_POST["courseid"];
    $content= $_POST["content"];
    $content=Tool::test_input($content);
   // echo "course: $courseId student: $userId";
    if(SC::isInCourse($userId,$courseId)||$userType===1) {
        if(!empty($content))
            ChatMessage::insertChatMessages($courseId,$userId,$userType,$content);
        header('Location: ../views/course.php?courseid=' . $courseId);
        exit();
    }

}


