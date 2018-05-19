<?php
/**
 * Created by PhpStorm.
 * User: xiong
 * Date: 19/05/2018
 * Time: 12:03 PM
 */

require_once('../connect.php');
class Course
{

    public static function checkIfExist($email, $password)
    {

    }


    /*
    * pre-condition: input courseName and teacher's id
     * function: insert a record into table: course
      * post-condition: -insert a record into table: course
     *              -return false if failed
   */
    public static function createCourse($courseName,$teacherId){
        global $mysqli;
        $mysqli=connect();
        $query = 'insert into 
courses(coursename,teacherid,regdate)
values("'.$courseName.'","'.$teacherId.'",CURDATE());';

        $result = $mysqli->query($query);
        $mysqli->close();

        return $result;
    }


    /*
    * pre-condition: input teacher's id
     * function: select and return course from table: course
      * post-condition: -return courses(: mysqli_result) that the teacher have
     *              -return false if failed
   */
    public static function showCourses($teacherId){
        global $mysqli;
        $mysqli=connect();
        $query = 'select coursename,regdate
        from courses
        where teacherid="'.$teacherId.'"';

        $result = $mysqli->query($query);
        $mysqli->close();

        return $result;
    }

}

?>