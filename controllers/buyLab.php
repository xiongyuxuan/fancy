<?php
/**
 * Created by PhpStorm.
 * User: xiong
 * Date: 23/05/2018
 * Time: 7:03 PM
 */
session_start();
if(empty($_SESSION["username"])){
    header("Location:login.php");
    exit;
}
require_once("../models/lab.php");

$userId=$_SESSION["id"];
$userType=$_SESSION["usertype"];
$labId="";
$userTypeNum=1;
if($userType==="student")
    $userTypeNum=0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $labId=$_POST["labid"];
    Lab::buyLab($labId,$userId,$userTypeNum);
    header('Location: ../views/myLabs.php');
    exit();
}


