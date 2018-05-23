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
        $query = 'select id,coursename,regdate
        from courses
        where teacherid="'.$teacherId.'"';

        $result = $mysqli->query($query);
        $mysqli->close();

        return $result;
    }

    /*
       * pre-condition: input course id
        * function: select and return teachers id from table: course
         * post-condition: -return teachers id(:string) who created the given course
        *              -return false if failed
      */
    public static function getTeacherId($courseId){
        global $mysqli;
        $mysqli=connect();
        $query = 'select id
        from courses
        where id='.$courseId.'';

        $result = $mysqli->query($query);
        $mysqli->close();

        return $result;
    }

    /*
     * pre-condition: get course id
     * function: select and return course information(:mysqli_result) from talbe: course and teacher
     * post-condition: same as function
     */
    public static function getCourseInformation($courseId){
        global $mysqli;
        $mysqli=connect();
        $query = 'select courses.id, courses.coursename, teachers.firstname, teachers.email
        from courses, teachers
        where courses.teacherid=teachers.id and 
                courses.id='.$courseId.';';

        $result = $mysqli->query($query);
        $mysqli->close();

        return $result;
    }
}

?>