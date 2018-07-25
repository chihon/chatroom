<?php
include 'utils.inc.php';
?>
<!DOCTYPE html>
<head>
	<title>
		Main page
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
			text-align: center;
			width: 10%;
			margin-bottom: 10px;
		}
		#word{
			font-weight: bold;
			color: red;
		}
	</style>
</head>
<body style="background-color: black">
	<header>
        <?php
            if(isset($_SESSION['id'])){
                echo "<h1>Confirm to Logout</h1>";
            } else {
                echo "<h1>Welcome</h1>";
            }
        ?>
	</header>
	<hr color=white>
	<?php
		if(isset($_GET['joined'])){
			echo "<center><p id=\"word\">join successfully, please login and start your tour!</p></center>";
		}
		if(isset($_SESSION['id'])){
			?>
			<a id="subm" href="logout.php">logout</a>
			<?php
		}
		else{
			?>
			<a id="subm" href="login.php">login</a>
			<a id="subm" href="join.php">join</a> 
			<?php
		}
		?>
</body>
