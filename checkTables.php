<?php
require 'connect.php';


$check='select * 
from students;';

$check.='select * 
from teachers;';

$check.='select * 
from courses;';

$check.='select * 
from messages;';

$check.='select * 
from chatmessages;';

$check.='select * 
from labpage;';

$check.='select * 
from sc;';

$check.='select * 
from scores;';

$check.='select * 
from testpapers;';

$check.='select * 
from userlabpage;';

$check.='select * 
from questions;';


if ($mysqli->multi_query($check)) {
    do {
        /* store first result set */
        if ($result = $mysqli->store_result()) {
			echo '<table style="border: 1px solid red">';
            while ($row = $result->fetch_row()) {
                echo '<tr>';
				foreach($row as $_row)
					echo '<td style="padding:3px; border: 1px solid red; text-align:center;">'.$_row.'</td>';
				echo '</tr>';
            }
			echo '</table><br>';
            $result->free();
        }
        /* print divider */
        if ($mysqli->more_results()) {
            printf("-----------------<br>");
        }
		else
			break;
    } while ($mysqli->next_result());
	echo "The end of the page.";
} 
else {
    echo "Error checking table: " . $mysqli->error;
}

$mysqli->close();



?>