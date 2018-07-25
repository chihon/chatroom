<?php

include "utils.inc.php";

$account = $_POST['name'];
$password = $_POST['password'];
$password2 = $_POST['password2'];
$email = $_POST['email'];

if($password!=$password2){
	$error_mode=1;
	header("Location: join.php?error_mode=$error_mode");
	exit;
}

$stmt = $db->prepare("SELECT * FROM player
			WHERE account=:account");
$stmt->execute(array("account"=>$account));
if($stmt->rowCount()!=0){
	$error_mode=2;
	header("Location: join.php?error_mode=$error_mode");
	exit;
}

$stmt = $db->prepare("INSERT INTO player
			(account, password, email)
			VALUES(:account,:password,:email)");

$stmt->execute(
	array(
		":account"=>$account,
		":password"=>$password,
		":email"=>$email
		)
	);

$joined=1;
header("Location: index.php?joined=$joined");
exit;


?>
