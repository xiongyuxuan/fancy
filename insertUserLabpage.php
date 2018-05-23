<?php
/**
 * Created by PhpStorm.
 * User: xiong
 * Date: 22/05/2018
 * Time: 11:46 AM
 */

require_once('connect.php');

$mysqli=connect();

//need to change the code if you want to insert something.
$userlabpage="select * from userlabpage";

if ($mysqli->multi_query($userlabpage)) {
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
    echo "All userlabpage are inserted successfully<br>";
}
else {
    echo "Error inserting userlabpage: " . $mysqli->error;
}

$mysqli->close();



?>