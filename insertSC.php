<?php
/**
 * Created by PhpStorm.
 * User: xiong
 * Date: 19/05/2018
 * Time: 4:00 PM
 */

require_once('connect.php');
$mysqli=connect();

$sc='insert into 
sc(studentid,courseid)
values(1,3);';

$sc.='insert into 
sc(studentid,courseid)
values(2,1);';

$sc.='insert into 
sc(studentid,courseid)
values(3,1);';




if ($mysqli->multi_query($sc)) {
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
    echo "All sc are inserted successfully<br>";
}
else {
    echo "Error inserting sc: " . $mysqli->error;
}

$mysqli->close();



?>