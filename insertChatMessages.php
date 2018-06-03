<?php
/**
 * Created by PhpStorm.
 * User: xiong
 * Date: 22/05/2018
 * Time: 7:27 PM
 */

require_once('connect.php');
$mysqli=connect();

$courses='insert into 
chatmessages(courseid,userid,usertype,postdate,content)
values(1,1,0,DATE_ADD(NOW(),INTERVAL 1 SECOND),"老师，最大静摩擦力可以大于滑动摩擦力吗？");';

$courses.='insert into 
chatmessages(courseid,userid,usertype,postdate,content)
values(1,2,0,DATE_ADD(NOW(),INTERVAL 59 SECOND),"不行吧，应该~");';

$courses.='insert into 
chatmessages(courseid,userid,usertype,postdate,content)
values(1,1,1,DATE_ADD(NOW(),INTERVAL 1 DAY),"可以的，最大静摩擦力会比滑动摩擦力大一点点。");';

$courses.='insert into 
chatmessages(courseid,userid,usertype,postdate,content)
values(2,1,0,DATE_ADD(NOW(),INTERVAL 7 SECOND),"一库伦的电荷常见吗？");';

$courses.='insert into 
chatmessages(courseid,userid,usertype,postdate,content)
values(2,2,0,DATE_ADD(NOW(),INTERVAL 9 SECOND),"常见");';

$courses.='insert into 
chatmessages(courseid,userid,usertype,postdate,content)
values(2,1,1,DATE_ADD(NOW(),INTERVAL 13 SECOND),"挺常见的，但库伦是很大的单位了，一般雷电通过的电量也只有几十库伦而已。");';


if ($mysqli->multi_query($courses)) {
    do {
        /* store first result set */
        if ($result = $mysqli->store_result()) {
            while ($row = $result->fetch_row()) {
                printf("%s\n", $row[0]);
            }
            $result->free();
        }
        /* print divider */
        if ($mysqli->more_results()) {
            printf("-----------------<br>");
        }
        else
            break;
    } while ($mysqli->next_result());
    echo "All chatMessages are inserted successfully<br>";
}
else {
    echo "Error inserting chatMessages: " . $mysqli->error;
}

$mysqli->close();



?>