<?php
require_once('connect.php');
$mysqli=connect();

//delete all tables in the connected database
$delete='drop tables if exists chatmessages,messages,questions,sc,scores,students,testpapers,userlabpage,labpage,courses,teachers;';

if ($mysqli->query($delete)===true) {
   echo "All tables are deleted successfully<br>";
} 
else {
    echo "Error droping table: " . $mysqli->error;
}

$mysqli->close();



?>