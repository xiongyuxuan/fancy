<?php
/**
 * Created by PhpStorm.
 * User: xiong
 * Date: 16/05/2018
 * Time: 2:21 PM
 */
require_once('connect.php');
$mysqli=connect();

$teachers='insert into 
teachers(id,firstname,lastname,email,regdate,password)
values(1,"Bill","Gates","bill@fancy.com",CURDATE(),PASSWORD("abcDE"));';

$teachers.='insert into 
teachers(firstname,lastname,email,regdate,password)
values("Zarkberger","Mark","zarkberger@fancy.com",CURDATE(),PASSWORD("abcDE"));';

$teachers.='insert into 
teachers(firstname,lastname,email,regdate,password)
values("Jun","Lei","jun@fancy.com",CURDATE(),PASSWORD("abcDE"));';





if ($mysqli->multi_query($teachers)) {
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
    echo "All teachers are inserted successfully<br>";
}
else {
    echo "Error creating table: " . $mysqli->error;
}

$mysqli->close();



?>