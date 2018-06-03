<?php
/**
 * Created by PhpStorm.
 * User: xiong
 * Date: 22/05/2018
 * Time: 4:42 PM
 */

/*
 * this page has NOT been completed!!!!!!
 * Full of ERRORS!!!
 */
require_once('connect.php');

$_question1=array("如图所示是小徐同学做“探究做功与速度变化的关系”的实验装置．他将光电门固定在直轨道上的O点，用同一重物通过细线拉同一小车，每次小车都从不同位置由静止释放，问
（1）该实验是否需要测量重物的重力:（填“是”或“否”）；
（2）该实验是否必须平衡摩擦力:（填“是”或“否”）；
",base64_encode(file_get_contents('question_img/1_1.png', FILE_USE_INCLUDE_PATH)),"",json_encode(array("是","是")),1)
;

$question2=array("某实验小组采用如图所示的装置探究力对物体做功速度变化的关系，由重物通过滑轮牵引小车．下列实验操作正确的是（　　）","",json_encode(array("小车的质量应比重物大很多，木板应水平放置","小车的质量应比重物大很多，木板应略微倾斜放置","小车的质量应等于重物的质量，木板应水平放置","小车的质量应等于重物的质量，木板应略微倾斜放置")),"B",1)
;

$mysqli=connect();

$questions="insert into 
sc(content,img,answersoptions,answer,labpageid)
values('$_question1[0]','$_question1[1]','$_question1[2]',$_question1[3],$_question1[4]);";


if ($mysqli->multi_query($questions)) {
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
    echo "All questions are inserted successfully<br>";
}
else {
    echo "Error inserting questions: " . $mysqli->error;
}

$mysqli->close();



?>