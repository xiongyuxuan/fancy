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

    /*
     * pre-condition: input course id
     * funciton: select and return students record(:mysqli_result) that the given course have from table: students and sc
     * post-condition: same as funciton;
     */
    public static function showStudents($courseId){
        global $mysqli;
        $mysqli=connect();
        $query = 'select students.id, students.firstname, students.email
        from students, sc
        where sc.courseid='.$courseId.' and
        sc.studentid=students.id ;';

        $result = $mysqli->query($query);
        $mysqli->close();

        return $result;
    }

    /*
     * pre-condition: input student id
     * function: delete record of the given student in the given course ;
     * post-condition: record of given student and course is deleted in Table: sc
     */
    public static function deleteStudent($studentId,$courseId){
        global $mysqli;
        $mysqli=connect();
        $query = 'delete from sc
        where courseid='.$courseId.' and studentid='.$studentId.';';

        $result = $mysqli->query($query);
        $mysqli->close();

        return $result;
    }

    /*
     * pre-condition: input student id and course id
     * function: check if the given student is in the given course or not
     * post-condition: return true if in course, false is not in.
     */

    public static function isInCourse($studentId,$courseId){
        global $mysqli;
        $mysqli=connect();
        $query = 'select * from sc
                where studentid='.$studentId.' and courseid='.$courseId.';';

        $result = $mysqli->query($query);
        $mysqli->close();

        if($result->num_rows===0) {
            $result->close();
            return false;
        }
        else {
            $result->close();
            return true;
        }


    }



}

?>