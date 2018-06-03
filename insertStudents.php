<?php
require_once('connect.php');
$mysqli=connect();

/*
//student table
$tables='CREATE TABLE if not exists students (
id INT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
firstname VARCHAR(30) NOT NULL,
lastname VARCHAR(30) NOT NULL,
email VARCHAR(50),
regdate DATETIME
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
*/

$students='insert into 
students(id,firstname,lastname,email,regdate,password)
values(1,"Jacky","Chen","jacky@fancy.com",NOW(),PASSWORD("abcDE"));';

$students.='insert into 
students(firstname,lastname,email,regdate,password)
values("Bruce","Li","bruce@fancy.com",NOW(),PASSWORD("abcDE"));';

$students.='insert into 
students(firstname,lastname,email,regdate,password)
values("Yuxuan","Xiong","yuxuan@fancy.com",NOW(),PASSWORD("abcDE"));';




if ($mysqli->multi_query($students)) {
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
	echo "All students are inserted successfully<br>";
}
else {
    echo "Error inserting Students: " . $mysqli->error;
}

$mysqli->close();



?>