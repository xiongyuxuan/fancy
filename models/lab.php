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
     * pre-condition: null
     * function: select and return an object (:mysqli_resllt) with a set of lab record
     * post-condition: same as function
     */
    public static function getAllLabs(){
        global $mysqli;
        $mysqli=connect();
        $query = 'select englishname, name, isnew, footer, id
                  from labpage;';

        $result = $mysqli->query($query);
        $mysqli->close();


        return $result;
    }


    /*
    * pre-condition: input lab id
    * function: select and return an object (:mysqli_resllt) of given lab
    * post-condition: same as function
    */
    public static function getLabById($labId){
        global $mysqli;
        $mysqli=connect();
        $query = 'select englishname, name, isnew, footer, id, price
                  from labpage
                  where id='.$labId.';';

        $result = $mysqli->query($query);
        $mysqli->close();


        return $result;
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

    /*
     * pre-condition: input labId,userid,usertype
     * function: check if the given user have right to access the page or not
     * post-condition: return true if have, return false if not.
     */
    public static function isAvailable($labId,$userId,$userType){
        $labIds=Lab::availableLabs($userId,$userType);
        if($labIds&&in_array($labId,$labIds)){
            //return $labIds;
            return true;
        }
        else
            return false;

    }

    /*
     * pre-condition: input userid,usertype
     * function: get all available lab pages that the given user have.(including free pages).
     * post-condition: return an array of page id or false if no matches.
     */
    public static function availableLabs($userId,$userType){
        global $mysqli;
        $mysqli=connect();

        $teacherLabs = 'select labpageid 
        from userlabpage
        where userid='.$userId.' and usertype=1
        union
        select id
        from labpage
        where price=0;';


        //student can share access of lab pages of his/her teacher
        $studentLabs='
        select labpageid 
        from userlabpage
        where userid='.$userId.' and usertype=0
        union
        select id
        from labpage
        where price=0
        union
        select userlabpage.labpageid
        from sc, courses, userlabpage
        where sc.studentid='.$userId.' and
              userlabpage.usertype=1 and
              courses.id=sc.courseid and
              courses.teacherid=userlabpage.userid;';

        $labs=$teacherLabs;
        if($userType==="student"){
            $labs=$studentLabs;
        }


        $result = $mysqli->query($labs);
        $mysqli->close();

        if($result->num_rows===0)
            return false;
        else{
            $labIds="";
            while($row=$result->fetch_row()){
                $labIds[]=$row[0];
            }
            return $labIds;
        }

    }


}

?>