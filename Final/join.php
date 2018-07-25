<?php
include 'utils.inc.php';
?>
<!DOCTYPE html>
<head>
	<title>
		join us
	</title>
	<style type="text/css">
		
		header, #subm{
			margin-right: auto;
			margin-left: auto;
			display: block;
		}
		header{
			color:white;
			text-align: center;
		}
		#subm{
			font-size: 12px;
			padding: 5px;
			font-weight: bold;
			background-color: #DDDDDD;
			border:3px white outset;
			border-radius: 5px;
			cursor: pointer;
		}
		#name{
			font-size: 20px;
			max-width: 500px;
			margin-bottom:10px;
			background-color: #CCDDFF;
			padding: 5px;
			border:0 none;
			border-radius: 5px;
		}
		#word{
			font-weight: bold;
			color: white;
		}
		#word2{
			font-weight: bold;
			color: red;
		}
		#back{
			text-align: left;
			font-size: 12px;
			font-weight: bold;
			background-color: #DDDDDD;
			border:3px white outset;
			border-radius: 5px;
			cursor: pointer;
		}
		#table{
			text-align: center;
		}
	</style>
</head>
<body style="background-color: black">
	<a id="back" href="index.php">back to main page</a>
	<header>
		<h1>Join</h1>
	</header>
	<hr color=white>
	<?php
		if(isset($_GET['error_mode'])){
			if($_GET['error_mode']==1){
				echo "<center><p id=\"word2\">password confirm filled !</p></center>";
			}
			else if($_GET['error_mode']==2){
				echo "<center><p id=\"word2\">account name has been used !</p></center>";
			}
		}
	?>
	<form id="table" method="POST" action="addmen.php">
		<div>
			<p id="word">Account</p>
			<input id="name" type="text" name="name" placeholder="Fill your account in" required>
		</div><br>
		<div>
			<p id="word"> Password</p>
		<input id="name" type="password" name="password" required>
		</div><br>
		<div>
			<p id="word"> Password comfirm</p>
		<input id="name" type="password" name="password2" required>
		</div><br>
		<div>
			<p id="word"> Email</p>
		<input id="name" type="text" name="email" required>
		</div><br><br>
		<input id="subm" type="submit" value="OK">
	</form> 
</body>