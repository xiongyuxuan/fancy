<?php
/**
 * Created by PhpStorm.
 * User: xiong
 * Date: 22/05/2018
 * Time: 11:08 AM
 */
require_once('connect.php');
$mysqli=connect();

$labs='insert into 
labpage(name,englishname,price)
values("动能定理","kineticEnergyLaw",0);';

$labs.='insert into 
labpage(name,englishname,price)
values("电场强度","electricField",0);';


if ($mysqli->multi_query($labs)) {
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
    echo "All labs are inserted successfully<br>";
}
else {
    echo "Error inserting labs: " . $mysqli->error;
}

$mysqli->close();



?>