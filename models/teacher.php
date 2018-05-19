<?php
/**
 * Created by PhpStorm.
 * User: xiong
 * Date: 16/05/2018
 * Time: 2:39 PM
 */

require_once('../connect.php');

class Teacher
{
    /*
* pre-condition: input teacher's email and password
 * function: validate if the teacher with certain password exist or not
  * post-condition: -return true if a record in table: teachers matchs the input.
 *              -return false if no record matches.
*/
   public static function checkIfExist($email, $password)
    {
        global $mysqli;
        $mysqli=connect();
        $query = 'select * from teachers
	where email="' . $email . '" and password=PASSWORD("' . $password . '");';


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
        $result = $mysqli->query($query);
        $mysqli->close();
        return $result;
    }

}
?>