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
$userId=$_SESSION["id"];
$userType=$_SESSION["usertype"];
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $labId = $_GET["labid"];
    $labEnglishName=Lab::getLabEnglishName($labId);
    $labName=Lab::getLabName($labId);
}

//if the lab is not available for this user, page will redirect to buy lab page
if(!Lab::isAvailable($labId,$userId,$userType)){
    header("Location:buyLab.php?labid=$labId");
    exit;
}


?>
<html>
<head>
<title>
<?php echo $labName; ?>
</title>
</head>
<style>
    body{
        background:url("images/bg_02.png");
    }
    span {
        font-size: 20px;
    }
    .white-pink {
        margin-left:auto;
        margin-right:auto;
        max-width: 900px;
        background: # FFF;
        padding: 30px 30px 20px 30px;
        box-shadow: rgba(187, 187, 187, 1) 0 0px 20px -1px;
        -webkit-box-shadow: rgba(187, 187, 187, 1) 0 0px 20px -1px;
        font: 12px Arial, Helvetica, sans-serif;
        color: # 666;
        border-radius: 10px;
        -webkit-border-radius: 10px;
    }
    .white-pink h1 {
        font: 24px "Trebuchet MS", Arial, Helvetica, sans-serif;
        padding: 0px 0px 10px 40px;
        display: block;
        border-bottom: 1px solid # F5F5F5;
        margin: -10px -30px 10px -30px;
        color: # 969696;
    }
    .white-pink h1>span {
        display: block;
        font-size: 11px;
        color: # C4C2C2;
    }
    .white-pink label {
        display: block;
        margin: 0px 0px 5px;
    }
    .white-pink label>span {
        float: left;
        width: 20%;
        text-align: right;
        padding-right: 10px;
        margin-top: 10px;
        color: # 969696;
    }
    .white-pink input[type="text"], .white-pink input[type="email"], .white-pink textarea,.white-pink select{
        color: # 555;
        width: 70%;
        padding: 3px 0px 3px 5px;
        margin-top: 2px;
        margin-right: 6px;
        margin-bottom: 16px;
        border: 1px solid # e5e5e5;
        background: # fbfbfb;
        height: 25px;
        line-height:15px;
        outline: 0;
        -webkit-box-shadow: inset 1px 1px 2px rgba(200,200,200,0.2);
        box-shadow: inset 1px 1px 2px rgba(200,200,200,0.2);
    }
    .white-pink textarea{
        height:100px;
        padding: 5px 0px 0px 5px;
        width: 70%;
    }
    .white-pink .button {
        -moz-box-shadow:inset 0px 1px 0px 0px # fbafe3;
        -webkit-box-shadow:inset 0px 1px 0px 0px # fbafe3;
        box-shadow:inset 0px 1px 0px 0px # fbafe3;
        background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, # ff5bb0), color-stop(1, # ef027d) );
        background:-moz-linear-gradient( center top, # ff5bb0 5%, # ef027d 100% );
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='# ff5bb0', endColorstr='# ef027d');
        background-color:# ff5bb0;
        border-radius:9px;
        -webkit-border-radius:9px;
        -moz-border-border-radius:9px;
        border:1px solid # ee1eb5;
        display:inline-block;
        color:# ffffff;
        font-family:Arial;
        font-size:15px;
        font-weight:bold;
        font-style:normal;
        height: 40px;
        line-height: 30px;
        width:100px;
        text-decoration:none;
        text-align:center;
        text-shadow:1px 1px 0px # c70067;
    }
    .white-pink .button:hover {
        background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, # ef027d), color-stop(1, # ff5bb0) );
        background:-moz-linear-gradient( center top, # ef027d 5%, # ff5bb0 100% );
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='# ef027d', endColorstr='# ff5bb0');
        background-color:# ef027d;
    }
    .white-pink .button:active {
        position:relative;
        top:1px;
    }

</style>
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
        echo "<div class='white-pink'>";
    while ($row = $messages->fetch_row()) {
    $messageUserType="student";
    if($row[1]==="1")
    $messageUserType="teacher";
    echo '<p class="white-pink"><span style="color:red">'.$row[0].'</span><span>['. $messageUserType.' ]</span>&nbsp&nbsp&nbsp<span>'. $row[2] .'</span><br> <span>'. $row[3] .'</span></p>';
    }
        echo "</div>";
    }
        $messages->free();

    echo '<form action="../controllers/insertMessage.php" method="post" class="white-pink">
        <input type="submit" value="留言" ><br>
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
