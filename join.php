
<?php
require('config.php');

if($_GET['join']==join){
	$account = $_GET['account'];
	$password = $_GET['password'];
	$db = new mysqli($db_host, $db_user, $db_pass, $db_name);
	if ($db->connect_error) {
		die("Connection failed: " . $db->connect_error);
	} 
	$insert_to_radcheck = "INSERT INTO radcheck (username, attribute, op, value) VALUES('$account','User-Password',':=','$password')";
    $insert_to_radusergroup = "INSERT INTO radusergroup (username, groupname) VALUES('$account', 'user')";
	if ($db->query($insert_to_radcheck) && $db->query($insert_to_radusergroup)) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $db->error;
	}
	header("Location: hotspotlogin.php? res=notyet");
	exit;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
	#index{
		display: inline-block;
		float:right;
		width:100px;
		margin:5px;
	}
	#a{
		color:#FF8800;
		font-size: 20px;
		text-decoration: none;
		background: white;
	}
	#a:hover{
		text-decoration: underline;
	}
	#top{
		width:100%;
		height:100px;
		display: inline-block;
	}
	#head_word{
		margin-left: 40%;
		display: inline-block;
		font-family: cursive;
		font-size: 50px;
		color:#ff00ff;
		text-align: center;
		padding:15px;
		font-family: 微軟正黑體;
	}
	#container{
		width: 230px;
		/*height: 300px;*/
		margin: 0 auto;
		color:#ff00ff;
		text-align: left;
		padding:15px;
		font-family: 微軟正黑體;
	}
	</style>
</head>
<body>
<div id="top">
	<div id="head_word"><b>&nbsp會員註冊</b></div>
	<div id="index">
		<a id="a" href="hotspotlogin.php? res=notyet"><b>回首頁</b></a>
	</div>
</div>
<div id="container">
	<form action="join.php" method="GET">
		帳號：<input type="text" name="account"><br>
		密碼：<input type="password" name="password"><br>
		<br><br>
		<input type="submit" value="加入會員">
		<input type="hidden" name="join" value="join">
	</form>
</div>
</body>
</html>
