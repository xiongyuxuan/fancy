<?php
require '../connect.php';

function checkIfExist($email,$password){
	global $mysqli;
	$query='select * from students
	where email="'.$email.'" and password=PASSWORD("'.$password.'");';
	
	/*if ($result = $mysqli->query($query)) {
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
	*/
	
	$result=$mysqli->query($query);
	$mysqli->close();
	
	return $result;
}


?>