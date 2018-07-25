<?php

if(!isset($_POST['mode'])){
	echo "Error: Mode not set";
	exit;
}

include 'utils.inc.php';

$mode = $_POST['mode'];

if($mode == 1){
	$newest_msg_id = $_POST['newest_msg_id'];
	$myId = $_POST['myId'];
	$herId = $_POST['herId'];

	$stmt = $db->prepare("SELECT * FROM messages WHERE id>:id and (chatter_id=:myid or chatter_id=:herid)");
	$stmt->execute(array(":id"=>$newest_msg_id,":myid"=>$myId, ":herid"=>$herId));

	echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

}elseif($mode == 2){
	$input_message = $_POST['input_message'];
	$chatter_id = $_SESSION['id'];
	$chatter_name = $_SESSION['name'];

	if(strlen($input_message)>0 and $input_message!="\n" and $input_message!="\r\n"){
		$stmt = $db->prepare(
			"INSERT INTO messages 
				(chatter_id,chatter_name,message) 
			VALUES 
				(:cid,:cname,:msg)");
		$row_count = $stmt->execute(
			array(
				":cid"=>$chatter_id,
				":cname"=>$chatter_name,
				":msg"=>$input_message
			)
		);
	}

	echo $row_count;

}else if($mode == 3){
	$herId = $_POST['herId'];

	$stmt = $db->prepare("SELECT * FROM wannatalk WHERE id=:herid");
	$stmt->execute(array(":herid"=>$herId));

	echo json_encode($stmt->rowCount());

}else{
	echo "Error: $mode";
	exit;
}



?>