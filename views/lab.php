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
<?php
    // messages in lab page
    $messages =Lab::getMessages($labId);
    if ($messages) {
    if ($messages->num_rows === 0)
    echo '<span>还没有人留言，赶紧来抢沙发吧！</span>';
    else {
    while ($row = $messages->fetch_row()) {
    $messageUserType="student";
    if($row[1]==="1")
    $messageUserType="teacher";
    echo '<p><span>'.$row[0].'</span><span>['. $messageUserType.' ]</span>&nbsp&nbsp&nbsp<span>'. $row[2] .'</span><br> <span>'. $row[3] .'</span></p>';
    }
    }
        $messages->free();

    echo '<form action="../controllers/insertMessage.php" method="post">
        留言：&nbsp&nbsp&nbsp&nbsp&nbsp<input type="submit"><br>
        <textarea name="content" rows="10" cols="50" placeholder="说些什么吧..."></textarea>
        <input type="text" name="labid" value="'.$labId.'" hidden>

    </form>';
    }
?>
</div>
<?php
//further codes need to be added to fetch data from databases;

?>

</body>
</html>
