<!DOCTYPE html>
<?php
/**
 * Created by PhpStorm.
 * User: xiong
 * Date: 23/05/2018
 * Time: 6:42 PM
 */
session_start();
if(empty($_SESSION["username"])){
    header("Location:login.php");
    exit;
}
require_once("../models/lab.php");


$userId=$_SESSION["id"];
$userType=$_SESSION["usertype"];
$userTypeNum=1;
if($userType==="student")
    $userTypeNum=0;

//labs
echo "<h1>已购买的实验</h1>";
$labs=Lab::myLabs($userId,$userTypeNum);
if($labs){
    if($labs->num_rows===0)
        echo '<span>您还没有购买过实验</span>';
    else {
        $counter=0;
        while ($lab = $labs->fetch_row()) {
            echo '
                <div class="jdgz'.($counter%2+1).'">
            	<a href="lab.php?labid='.$lab[4].'">';
            if($lab[2])
                echo '<img class="new-ribbon" src="images/new.png" alt="new-ribbon">';
            echo '
                <img src="images/'.$lab[0].'/cover.jpg" height="120" width="290px;"></a>
				<p><a href="lab.php?labid='.$lab[4].'">'.$lab[1].'</a></p>
				<span>'.$lab[3].'&nbsp&nbsp&nbsp价格：'.$lab[5].'</span>
			</div>';
            $counter++;
        }
    }
    $labs->free();
}