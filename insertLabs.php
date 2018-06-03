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
labpage(name,englishname,price,footer)
values("如何验证动能定理？","kineticEnergyLaw",0,"打点计时器");';

$labs.='insert into 
labpage(name,englishname,price,footer)
values("体验电场强度","electricField",0,"E=k*Q/r");';

$labs.='insert into 
labpage(name,englishname,price,footer)
values("透镜成像","lens_experiment",5,"透镜的奥妙");';


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