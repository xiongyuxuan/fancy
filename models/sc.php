<?php
/**
 * Created by PhpStorm.
 * User: xiong
 * Date: 19/05/2018
 * Time: 2:52 PM
 */
require_once("../connect.php");

class SC{

    /*
     * pre-condition: input studentId
     * function: select courseId, courseName, teacherName, teacherEmail that the student have via join query table: sc,course and teacher;
     * post-condition: -same as function if success
     *                 -return false if failed
     */
    public static function showCourses($studentId){
        global $mysqli;
        $mysqli=connect();
        $query = 'select courses.id, courses.coursename, teachers.firstname, teachers.email
        from courses, sc, teachers
        where sc.studentid='.$studentId.' and
        courses.id=sc.studentid and
        courses.teacherid=teachers.id;';

        /*
         select courses.id, courses.coursename, teachers.firstname, teachers.email
        from courses, sc, teachers
        where sc.studentid=1 and
        courses.id=sc.studentid and
        courses.teacherid=teachers.id;

         */

        $result = $mysqli->query($query);
        $mysqli->close();

        return $result;

    }


}

?>