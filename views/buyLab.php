<?php
/**
 * Created by PhpStorm.
 * User: xiong
 * Date: 23/05/2018
 * Time: 6:29 PM
 */
require_once("../models/lab.php");
?>
<html lang="zh-cn">
<head>
    <meta charset="utf-8" />
    <title>Fancy</title>
    <link rel="shortcut icon" href="images/seed.ico" />
    <link href="css/type.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://at.alicdn.com/t/font_529261_yyh9wnvuf9cz0k9.css">
    <link rel="stylesheet" href="css/carousel.css">
</head>

<body>
<?php

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $labId=$_GET["labid"];
    $lab=Lab::getLabById($labId);
    echo '
                <div class="jdgz' . ($counter % 2 + 1) . '">
            	<a href="lab.php?labid=' . $lab[4] . '">';
    if ($lab[2])
        echo '<img class="new-ribbon" src="images/new.png" alt="new-ribbon">';
    echo '
                <img src="images/' . $lab[0] . '/cover.jpg" height="120" width="290px;"></a>
				<p><a href="lab.php?labid=' . $lab[4] . '">' . $lab[1] . '</a></p>
				<span>' . $lab[3] . '</span>
			</div>';
}
?>
<form action="../models/buyLab.php" method="post">
    <input type="submit" value="购买">
</form>


</body>
</html>
