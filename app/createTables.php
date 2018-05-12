<?php
require 'connect.php';

//student table
$tables='CREATE TABLE if not exists students (
id INT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
firstname VARCHAR(30) NOT NULL,
lastname VARCHAR(30) NOT NULL,
email VARCHAR(50),
regdate DATETIME
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';


//teacher table
$tables.='CREATE TABLE if not exists  teachers (
id INT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
firstname VARCHAR(30) NOT NULL,
lastname VARCHAR(30) NOT NULL,
email VARCHAR(50),
regdate DATETIME
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';


//courses table
$tables.='CREATE TABLE if not exists courses (
id INT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
coursename VARCHAR(30) NOT NULL,
teacherid INT(20) UNSIGNED,
regdate DATETIME,
foreign key (teacherid) references teachers(id)
on delete cascade
on update cascade
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';

//student&courses table
$tables.='CREATE TABLE if not exists sc (
studentid INT(20) UNSIGNED,
courseid INT(5) UNSIGNED,
primary key(studentid,courseid),
foreign key (studentid) references students(id)
on delete cascade
on update cascade,
foreign key (courseid) references courses(id)
on delete cascade
on update cascade
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';


//labpage table
$tables.='CREATE TABLE if not exists labpage (
id INT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
price INT(5) default 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';


//user&labpage table
$tables.='CREATE TABLE if not exists userlabpage (
userid INT(20),
labpageid INT(5) UNSIGNED,
usertype tinyint default 1,
primary key(userid,labpageid,usertype),
foreign key(labpageid) references labpage(id)
on delete cascade
on update cascade
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';


//chat message table : message in the course, which are for communicate inner one course
$tables.='CREATE TABLE if not exists chatmessages (
courseid INT(5) UNSIGNED,
userid INT(20),
usertype tinyint default 0,
postdate DATETIME,
content text,
primary key(courseid,userid,usertype,postdate),
foreign key(courseid) references courses(id)
on delete cascade
on update cascade
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';


//messages table : message for one specific lab page instead inner course.
$tables.='CREATE TABLE if not exists messages (
labpageid INT(5) UNSIGNED,
userid INT(20),
usertype tinyint default 0,
postdate DATETIME,
content text,
primary key(labpageid,userid,usertype,postdate),
foreign key(labpageid) references labpage(id)
on delete cascade
on update cascade
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';


//testpapers table 
$tables.='CREATE TABLE if not exists testpapers (
id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
courseid INT(5) UNSIGNED,
questionids text,
postdate DATETIME,
foreign key(courseid) references courses(id)
on delete cascade
on update cascade
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';


//scores table 
$tables.='CREATE TABLE if not exists scores (
testpaperid INT(10) UNSIGNED,
studentid INT(20) UNSIGNED,
chances INT(2) default 1,
score int(3),
postdate DATETIME,
primary key(testpaperid,studentid),
foreign key(testpaperid) references testpapers(id)
on delete cascade
on update cascade,
foreign key(studentid) references students(id)
on delete cascade
on update cascade
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';


//questions table 
$tables.='CREATE TABLE if not exists questions (
id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
content text,
answersoptions text,
answer varchar(5),
labpageid INT(5) UNSIGNED,
foreign key(labpageid) references labpage(id)
on delete cascade
on update cascade
) ENGINE=InnoDB DEFAULT CHARSET=utf8;';



if ($mysqli->multi_query($tables)) {
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
	echo "All tables are created successfully";
} 
else {
    echo "Error creating table: " . $mysqli->error;
}

$mysqli->close();



?>