
<!DOCTYPE html>
<?php
$error="";
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if(isset($_GET["error"]))  $error="邮箱或密码错误！";
}
?>
<html lang="en" class="no-js">

    <head>

        <meta charset="utf-8">
        <title>Login</title>
        <link rel="shortcut icon" href="images/seed.ico" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- CSS -->
        <link rel="stylesheet" href="css/reset.css">
        <link rel="stylesheet" href="css/supersized.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/type.css">

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

    </head>

    <body oncontextmenu="return false">

        <div class="page-container">

            <table style="border: 1px solid red; text-align:center;width: 40%;">
                <tr>
                    <th>Test Accounts</th><th>Student</th><th>Teacher</th>
                </tr>
                <tr>
                    <th>Username</th><td>jacky@fancy.com</td><td>bill@fancy.com</td>
                </tr>
                <tr>
                    <th>Password</th><td>abcDE</td><td>abcDE</td>
                </tr>
            </table>


            <h1>Login</h1>
            <form action="../controllers/verification.php" method="post">
				<div>
					<input type="text" name="email" class="email" placeholder="Email" value="jacky@fancy.com" autocomplete="off" />
				</div>
                <div>
					<input type="password" name="password" class="password" placeholder="Password" oncontextmenu="return false" value="abcDE" onpaste="return false" />
                </div>
                <span class="error"><?php echo "<br>".$error; ?></span>
                <button id="submit" type="submit">登陆</button>
            </form>
            <div class="connect">
                <p>Fancy education: find more interesting learning approaches.</p>
				<p style="margin-top:20px;">凡思教育：发现更多有趣的学习方法。</p>
            </div>
        </div>
		<div class="alert" style="display:none">
			<h2>消息</h2>
			<div class="alert_con">
				<p id="ts"></p>
				<p style="line-height:70px"><a class="btn">确定</a></p>
			</div>
		</div>

        <!-- Javascript -->
		<script src="http://apps.bdimg.com/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
        <script src="js/supersized.3.2.7.min.js"></script>
        <script src="js/supersized-init.js"></script>
		<script>
		$(".btn").click(function(){
			is_hide();
		})
		var u = $("input[name=username]");
		var p = $("input[name=password]");
		$("#submit").live('click',function(){
			if(u.val() == '' || p.val() =='')
			{
				$("#ts").html("用户名或密码不能为空~");
				is_show();
				return false;
			}
			else{
				var reg = /^[0-9A-Za-z]+$/;
				if(!reg.exec(u.val()))
				{
					$("#ts").html("用户名错误");
					is_show();
					return false;
				}
			}
		});
		window.onload = function()
		{
			$(".connect p").eq(0).animate({"left":"0%"}, 600);
			$(".connect p").eq(1).animate({"left":"0%"}, 400);
		}
		function is_hide(){ $(".alert").animate({"top":"-40%"}, 300) }
		function is_show(){ $(".alert").show().animate({"top":"45%"}, 300) }
		</script>
    </body>

</html>

