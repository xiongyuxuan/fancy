<!DOCTYPE html>
<?php
session_start();
require_once('../models/lab.php');
if(empty($_SESSION["username"])){
header("Location:login.php");
exit;
}

$labId="";
$labEnglishName="";
$labName="";
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $labId = $_GET["labid"];
    $labEnglishName=Lab::getLabEnglishName($labId);
    $labName=Lab::getLabName($labId);
}
?>
<html>
<head>
<title>
<?php echo $labName; ?>
</title>
</head>
<body>

<!--the original simulation page; -->
<?php
echo '<iframe src="'.$labEnglishName.'.html" width="100%" height="600px" style="border:none;" scrolling="no"></iframe>';
?>

<div>
<h1>用户留言: </h1><br>
</div>
<?php
//further codes need to be added to fetch data from databases;

?>

</body>
</html>
