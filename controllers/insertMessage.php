<?php
/**
 * Created by PhpStorm.
 * User: xiong
 * Date: 23/05/2018
 * Time: 1:36 PM
 *
 * role: control level file for  inserting a message
 * pre-condition: login,get request from views/course.php,require labid,content
 * funciton: insert a message into database
 * post-condition: a record is inserted into Table: messages
 *
 */

session_start();
require_once('../models/lab.php');
require_once('../tool.php');

if(empty($_SESSION["username"])){
    header("Location:login.php");
    exit;
}
$labId = "";
$userId =$_SESSION["id"];
$content="";
$userType=0;

if($_SESSION["usertype"]==="teacher")
    $userType=1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $labId  = $_POST["labid"];
    $content= $_POST["content"];
    $content=Tool::test_input($content);
    if(!empty($content))
        Lab::insertMessages($labId ,$userId,$userType,$content);
    header('Location: ../views/lab.php?labid=' . $labId );
    exit();


}
