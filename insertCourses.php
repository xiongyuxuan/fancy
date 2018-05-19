<?php
/**
 * Created by PhpStorm.
 * User: xiong
 * Date: 19/05/2018
 * Time: 3:54 PM
 */

require_once('connect.php');
$mysqli=connect();

$courses='insert into 
courses(coursename,teacherid,regdate)
values("西大物理3班",1,CURDATE());';


if ($mysqli->multi_query($courses)) {
    do {
        /* store first result set */
        if ($result = $mysqli->store_result()) {
            while ($row = $result->fetch_row()) {
                printf("%s\n", $row[0]);
            }
            $result->free();
        }
        /* print divider */
        if ($mysqli->more_results()) {
            printf("-----------------<br>");
        }
        else
            break;
    } while ($mysqli->next_result());
    echo "All courses are inserted successfully<br>";
}
else {
    echo "Error inserting courses: " . $mysqli->error;
}

$mysqli->close();



?>