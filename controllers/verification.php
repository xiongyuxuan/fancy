<?php
session_start();
require '../models/student.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$email=$_POST["email"];
	$password=$_POST["password"];
	
	$result=checkIfExist($email,$password);
	if(!$result){
		header('Location: ../views/login.php?erro=no_such_user');
	}
	else{
		$_SESSION["username"] = $result->fetch_row()[1];
		$_SESSION["usertype"] = "student";
		header('Location: ../views/home.php');
		exit();
	}
	
}

?>