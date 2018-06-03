<?php
/**
 * Created by PhpStorm.
 * User: xiong
 * Date: 23/05/2018
 * Time: 1:18 PM
 */
require_once('connect.php');
$mysqli=connect();

$messages='insert into 
messages(labpageid,userid,usertype,postdate,content)
values(1,1,0,DATE_ADD(NOW(),INTERVAL 1 SECOND),"哇，如果把摩擦系数设置很大，然后沙桶质量设置很大，会有好玩的事情发生哦，hhh");';

$messages.='insert into 
messages(labpageid,userid,usertype,postdate,content)
values(1,3,0,DATE_ADD(NOW(),INTERVAL 19 SECOND),"emmm，，，你，，，，醉了 -_-||");';

$messages.='insert into 
messages(labpageid,userid,usertype,postdate,content)
values(1,2,1,DATE_ADD(NOW(),INTERVAL 39 SECOND),"叫你们好好学习，你们在干嘛呢！");';

$messages.='insert into 
messages(labpageid,userid,usertype,postdate,content)
values(2,1,0,DATE_ADD(NOW(),INTERVAL 5 SECOND),"怎么玩啊，这东西");';

$messages.='insert into 
messages(labpageid,userid,usertype,postdate,content)
values(2,2,0,DATE_ADD(NOW(),INTERVAL 8 SECOND),"拖拽电荷就行，还可以设置正负和大小");';


if ($mysqli->multi_query($messages)) {
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
    echo "All messages are inserted successfully<br>";
}
else {
    echo "Error inserting messages: " . $mysqli->error;
}

$mysqli->close();



?>