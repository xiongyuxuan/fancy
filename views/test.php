<!DOCTYPE html>
<html>
<head>
<title>
<?php echo $_GET["labName"]; ?>
</title>
</head>
<body>

<!--the original simulation page; -->
<?php
echo '<iframe src="'.$_GET["labName"].'.html" width="100%" height="600px" style="border:none;" scrolling="no"></iframe>';
?>

<div>
<h1>试卷: </h1><br>
</div>
<?php
//further codes need to be added to fetch data from databases;

?>

</body>
</html>
