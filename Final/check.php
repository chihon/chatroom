<?php
include "utils.inc.php";
require "../config.php";

$account = $_POST['name'];
$password = $_POST['password'];
$table = "player";
$error_mode=0;

$stmt = $db->prepare("SELECT * FROM player WHERE account=:account AND password=:password");

$stmt->execute(array(":account"=>$account, ":password"=>$password));

if($stmt->rowCount() <= 0){
	$error_mode = 1;
	 header("Location: login.php?error_mode=$error_mode");
	 exit;
}

$row = $stmt->fetch(PDO::FETCH_ASSOC);

$db = new mysqli($db_host, $db_user, $db_pass, $db_name);
$db->query("UPDATE player SET login_time=UNIX_TIMESTAMP() WHERE account='$account'");
$_SESSION['id'] = $row['ID'];
$_SESSION['name']=$row['account'];

header("Location: ../final_project/index.html");
exit;

?>
