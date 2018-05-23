<?php
/**
 * Created by PhpStorm.
 * User: xiong
 * Date: 22/05/2018
 * Time: 11:22 AM
 */
require_once("../models/course.php");

/*
 * role: controller level file, designed to handle requests from views/course.php
 *
 */

class CourseController
{

    /*
     * pre-condition: get course id
     * function: select and return all labs that the given course have, including free and paid courses
     * post-condition: same as function;
     */
    public static function showLabs($courseId){
        $teacherId=Course::getTeacherId($courseId)->fetch_row()[0];
        global $mysqli;
        $mysqli=connect();
        $labs=' select labpage.englishname, labpage.name, labpage.isnew, labpage.footer, labpage.id
        from labpage, userlabpage
        where (labpage.id=userlabpage.labpageid and
              userlabpage.usertype=1 and
              userlabpage.userid='.$teacherId.')
        union
        select labpage.englishname, labpage.name, labpage.isnew, labpage.footer, labpage.id
        from labpage
        where price=0;';

        $result = $mysqli->query($labs);
        $mysqli->close();

        return $result;

        /*
         select labpage.id, labpage.name
        from labpage, userlabpage
        where (labpage.id=userlabpage.labpageid and
              userlabpage.usertype=1 and
              userlabpage.userid=1)
        union
        select id, name
        from labpage
        where price=0;

         */

    }

}
?>
