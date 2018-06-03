<?php
/**
 * Created by PhpStorm.
 * User: xiong
 * Date: 22/05/2018
 * Time: 7:51 PM
 */

require_once('../connect.php');
class ChatMessage
{
    /*
     * pre-condition: input courseId
     * function: select and return ordered message and relevant user information in given course from table: chatmessages and students and teachers
     * post-condition: same as funciton;
     */
    public static function getChatMessages($courseId){
        global $mysqli;
        $mysqli=connect();

        $query =
        '(select teachers.firstname, chatmessages.usertype, chatmessages.postdate, chatmessages.content
        from chatmessages,teachers
        where chatmessages.courseid='.$courseId.' and
        chatmessages.usertype=1 and
        chatmessages.userid=teachers.id)
        union
        (select students.firstname, chatmessages.usertype, chatmessages.postdate, chatmessages.content
        from chatmessages, students
        where chatmessages.courseid='.$courseId.' and
        chatmessages.usertype=0 and
        chatmessages.userid=students.id)
        order by postdate asc;';


        
        
        $result = $mysqli->query($query);
        $mysqli->close();

        return $result;

    }


    /*
     * pre-condition: input courseId,userid,usertype
     * function: insert a chatmessage into the database (Table: chatmessage)
     * post-condition: insert a record into table: chatmessage
     */
    public static function insertChatMessages($courseId,$userId,$userType,$content){
        global $mysqli;
        $mysqli=connect();

        $query = 'insert into chatmessages
            values('.$courseId.','.$userId.','.$userType.',NOW(),"'.$content.'");';

        $result = $mysqli->query($query);
        $mysqli->close();

        return $result;

    }

}

?>