<?php
/**
 * Created by PhpStorm.
 * User: xiong
 * Date: 22/05/2018
 * Time: 10:47 AM
 */

require_once('../connect.php');
class Lab
{
    /*
     * pre-condition: input lab id
     * function: get English name of the given lab
     * post-condition: return English name of the given lab(:string)
     */
    public static function getLabEnglishName($labId){
        global $mysqli;
        $mysqli=connect();
        $query = 'select englishname
                  from labpage
                  where id='.$labId;

        $result = $mysqli->query($query);
        $mysqli->close();

        if(!empty($_result=$result->fetch_row()))
            $labEnglishName=$_result[0];
        $result->close();

        return $labEnglishName;
    }


    /*
     * pre-condition: input lab id
     * function: get name of the given lab
     * post-condition: return name of the given lab(:string)
     */
    public static function getLabName($labId){
        global $mysqli;
        $mysqli=connect();
        $query = 'select name
                  from labpage
                  where id='.$labId;

        $result = $mysqli->query($query);
        $mysqli->close();

        if(!empty($_result=$result->fetch_row()))
            $labName=$_result[0];
        $result->close();

        return $labName;
    }

}

?>