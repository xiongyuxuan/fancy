<?php
session_start();
/*
 * role: cotroller level file for login
 * pre-condition: get post request from views/login.php
 * function: validate the student/teacher's email and password against table: student/teacher
 * post-condition: -set sessions about students/teacher's information and call views/home.php if matches
 *                 -call call itself with error signal if no record matches.
*/
require_once('../models/student.php');
require_once('../models/teacher.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$email=$_POST["email"];
	$password=$_POST["password"];
	
	$result=Student::checkIfExist($email,$password);
	if($result->num_rows===0){
        $result=Teacher::checkIfExist($email,$password);
        if($result->num_rows===0) {
            header('Location: ../views/login.php?error=1');
            exit();
        }
        else{
            $user=$result->fetch_row();
            $_SESSION["usertype"] = "teacher";
            $_SESSION["id"]=$user[0];
            $_SESSION["firstname"] = $user[1];
            $_SESSION["lastname"] = $user[2];
            $_SESSION["email"] = $user[3];
            $_SESSION["username"]=$_SESSION["firstname"]." ".$_SESSION["lastname"];
           header('Location: ../views/home.php');
           exit();
        }
	}
	else{
        $user=$result->fetch_row();
		$_SESSION["usertype"] = "student";
        $_SESSION["id"]=$user[0];
        $_SESSION["firstname"] = $user[1];
        $_SESSION["lastname"] = $user[2];
        $_SESSION["email"] = $user[3];
        $_SESSION["username"]=$_SESSION["firstname"]." ".$_SESSION["lastname"];
		header('Location: ../views/home.php');
		exit();
	}
	
}

?>