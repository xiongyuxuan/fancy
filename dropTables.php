<?php
require 'connect.php';

//delete all tables in the connected database
$delete='drop tables chatmessages,messages,questions,sc,scores,students,testpapers,userlabpage,labpage,courses,teachers;';

if ($mysqli->query($delete)===true) {
   echo "All tables are deleted successfully";
} 
else {
    echo "Error droping table: " . $mysqli->error;
}

$mysqli->close();



?>