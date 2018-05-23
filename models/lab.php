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

    /*
     * pre-condition: input lab id
     * function: select and return ordered message and relevant user information in given lab from table: messages and students and teachers
     * post-condition: same as funciton;
     */
    public static function getMessages($labId){
        global $mysqli;
        $mysqli=connect();

        $query =
            '(select teachers.firstname, messages.usertype, messages.postdate, messages.content
        from messages,teachers
        where messages.labpageid='.$labId.' and
        messages.usertype=1 and
        messages.userid=teachers.id)
        union
        (select students.firstname, messages.usertype, messages.postdate, messages.content
        from messages, students
        where messages.labpageid='.$labId.' and
        messages.usertype=0 and
        messages.userid=students.id)
        order by postdate asc;';




        $result = $mysqli->query($query);
        $mysqli->close();

        return $result;

    }


    /*
     * pre-condition: input labId,userid,usertype
     * function: insert a message into the database (Table: message)
     * post-condition: insert a record into table: message
     */
    public static function insertMessages($labId,$userId,$userType,$content){
        global $mysqli;
        $mysqli=connect();

        $query = 'insert into messages
            values('.$labId.','.$userId.','.$userType.',NOW(),"'.$content.'");';

        $result = $mysqli->query($query);
        $mysqli->close();

        return $result;

    }

}

?>