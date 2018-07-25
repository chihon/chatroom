<?php
include 'utils.inc.php'
?>

<!DOCTYPE html style="height:100%">
<?php
	if(isset($_POST['bye'])){
		$delete = $db->prepare("DELETE FROM wannatalk WHERE id=:myid");
		$delete->execute(array(":myid"=>$_SESSION['id']));
		$delete = $db->prepare("DELETE FROM messages WHERE chatter_id=:myid");
		$delete->execute(array(":myid"=>$_SESSION['id']));
		//unset($_SESSION['id']);
		//unset($_SESSION['name']);
		header("Location: ../final_project/index.html");
		exit;
	}
?>


<head>
	<title>AnonymousTalk</title>
	<style type="text/css">
		* {
			-webkit-box-sizing: border-box;
			   -moz-box-sizing: border-box;
			        box-sizing: border-box;
		}
		body{
			height: 100%;
			background-color: white;
			background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTYVY-Bo2WOmNy9lMVYaINM8EYxbZc2UV_JTlF5TRmtneDS6r6yNw');
			overflow:hidden;
		}
		header, #context, footer {
			display: block;
			color: black;
			max-width: 90%;
			margin: 0 auto;
		}
		header, footer {
			text-align: center;
			margin: 0 auto; 
			padding-top: 5px;
			padding-bottom: 5px;
		}
		header{
			max-width: 90%;
			background-color: #b088ff;
			font-size: 36px;
			font-weight: bold;
			border-radius: 10px;
			margin-top: 0px;
			//opacity: 0.4;
			//border: 1px #b088ff solid;
		}
		#context{
			position: relative;
			background-color: #d1bbff;
			height: 80%;
			border: 1px #d1bbff solid;
			border-radius: 10px;
			//overflow-y: auto;
			overflow-y: scroll;
			padding-bottom: 20px;
		}
		footer{
			background-color: #b088ff;
			font-size: 10px;
			padding-top: 1px;
			padding-bottom: 1px;
			margin-bottom: 0;
		}
		#bottom{
			//position: absolute;
			//bottom: 0;
			//right: 0;
			//left: 0;
			text-align: center;
			max-width: 90%;
			margin: 0 auto;
		}
		#a{
			display: inline-block;
			position: inherit;
			max-width: 60px;
			margin-right: 1px;
			background-color: #CCDDFF;
		}
		#b{
			display: inline-block;
			//position: relative;
			width: 100%;
			//overflow: auto;
			background-color: #d1bbff;
			resize: none;
			font-size: 18px;
			border: 3px #b088ff outset;
			border-radius: 5px;
			white-space: nowrap;
		}
		div{
			display: block;
		}
		#ltext, #rtext, #ltime, #rtime{
			display: inline-block;
			word-break: break-all;
		}
		#ltext,#rtext{
			background-color: #B088FF;
			border: 1px #B088FF solid;
			border-radius: 5px;
			font-size: 18px;
			font-weight: bold;
			font-family: monospace;
			padding-right: 5px;
			padding-left: 5px;
			margin-left: 10px;
			margin-right: 10px;
			margin-bottom: 5px; 
			max-width: 50%;
			text-align: left;
		}
		#ltime, #rtime{
			font-size: 5px;
			vertical-align: bottom;
		}
		#rtext{
			float: right;
		}
		#rtime{
			text-align: right;
			float: right;
		}
		textarea{
			white-space: nowrap;
			overflow: hidden;
			resize: none;
		}
		#leave{
			color: blue;
			font-weight: bold;
			text-align: center;
		}
	</style>
</head>
<body>
	<form method="POST" action="chat.php">
		<input id="a" type="submit" name="bye" value="離開">
	</form>

	<?php
	//insert data of this nser
	$insert = $db->prepare("INSERT INTO wannatalk (id,idMatch,name) VALUES(:id,:idMatch,:name)");
	$insert->execute(array(":id"=>$_SESSION['id'],":idMatch"=>0,":name"=>$_SESSION['name']));

	//serch if somebody do not match yet
	$stmt = $db->prepare("SELECT * FROM wannatalk WHERE idMatch=:idMatch and id!=:id");
	$stmt->execute(array(":idMatch"=>0,":id"=>$_SESSION['id']));

	//check if someone connect to me
	$own = $db->prepare("SELECT * FROM wannatalk WHERE id=:id");
	$own->execute(array(":id"=>$_SESSION['id']));
	$row = $own->fetch(PDO::FETCH_ASSOC);

	$time_search=0;
	$which = 0;
	while(1){
		$time_search++;
		if($time_search>50){
			$delete = $db->prepare("DELETE FROM wannatalk WHERE id=:myid");
			$delete->execute(array(":myid"=>$_SESSION['id']));
			$error_mode=3;
            echo '<script>alert("Time out!)"; location.href="../final_project/index.html"; </script>';
			exit;
		}
		//someone connect to me
		if($row['idMatch']!=0){
			$which=1;
			break;
		}
		//there are some people can be connected
		else if($stmt->rowCount()!=0){
			$which=2;
			break;
		}
		usleep(200000);  //0.2 second
		$stmt = $db->prepare("SELECT * FROM wannatalk WHERE idMatch=:idMatch and id!=:id");
		$stmt->execute(array(":idMatch"=>0,":id"=>$_SESSION['id']));
		$own = $db->prepare("SELECT * FROM wannatalk WHERE id=:id");
		$own->execute(array(":id"=>$_SESSION['id']));
		$row = $own->fetch(PDO::FETCH_ASSOC);
	}
	if($which==1){  //then set her idmatch=myid
		$herId = $row['idMatch'];
	}else{
		$sel = rand(1,$stmt->rowCount());
		for($i=0;$i<$sel;$i++){
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
		}
		$herId = $row['id'];
	}
	$myId = $_SESSION['id'];
	$stmt = $db->prepare("UPDATE wannatalk SET idMatch=:idMatch WHERE id=:id");
	$stmt->execute(array(":idMatch"=>$myId,":id"=>$herId));
	?>

	<header>
		AnonymousTalk
	</header>
	<div id="context">
		<div>
			<center>
				<p style="opacity:10%;color:#999999">
					說些什麼吧~
				</p> 
			</center>
		</div>

		<div>
			<div id="messages"></div>
		</div>

	</div>
	<div id="bottom">
		<textarea id="b" rows="1" placeholder="Type on there"></textarea>
	</div>
	
	<footer>
		<p>
			cnlfinal5 &copy; 2018
		</p>
	</footer>


	<script type="text/javascript">
	setInterval(get_new_messages, 200);
	setInterval(her_leave, 200);

	document.getElementById('b').addEventListener("keypress",send_message);
	//document.getElementById('c').addEventListener("click",send_message_ckick)
	document.getElementById('context').addEventListener("wheel",stopUpdate);
	

	var leaved=0; //detected id another is leaved
	var newest_msg_id = 0;
	var div_messages = document.getElementById('messages');
	var inputByEnter = document.getElementById('b');
	var mai=document.getElementById('context');
	var update=1;
	//var inputBySubmit = document.getElementById('c');

	var myid = <?php echo $myId;?>;
	var herid = <?php echo $herId;?>;

	function get_new_messages(){
		if(leaved==0){
			if(window.XMLHttpRequest){
				var xhr = new XMLHttpRequest();
			}else{
				var shr = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xhr.onreadystatechange = function(){
				if(xhr.readyState==4 && xhr.status==200){
					var msgs = JSON.parse(xhr.responseText);
					msgs.forEach(function(cv,i,arr){
						if(cv['chatter_id']==myid){
							div_messages.innerHTML += 
								"<div><div id=\"rtext\">"+cv['message'] +
								"</div><div id=\"rtime\">"+ cv['date'] +"</div>" +
								"<div style=\"clear:both\"></div>";
						}else{
							div_messages.innerHTML += 
								"<div><div id=\"ltext\">"+cv['message'] +
								"</div><div id=\"ltime\">"+ cv['date'] +"</div>" +
								"<div style=\"clear:both\"></div>";
						}
						/*
						div_messages.innerHTML += 
							"<div>" + 
							cv['chatter_name'] + " : " +
							cv['message'] + " --- " +
							cv['date'] + "</div>";*/
					});
					if(msgs.length>0)
						newest_msg_id = msgs[msgs.length-1]['id'];
				}
			};

			if(update==1){
				mai.scrollTop=mai.scrollHeight;
			}

			xhr.open("POST","process.php",true);

			var fd = new FormData();
			fd.set("mode",1);
			fd.set("newest_msg_id",newest_msg_id);
			
			fd.set("myId",myid);
			fd.set("herId",herid);

			xhr.send(fd);

		}
	}

	function send_message(e){
		if(leaved==0){
			if(e.keyCode != 13) return;

			var xhr = new XMLHttpRequest();

			xhr.onreadystatechange = function () {};

			xhr.open("POST","process.php",true);

			var fd = new FormData();
			fd.set("mode", 2);
			fd.set("input_message",inputByEnter.value);

			xhr.send(fd);

			inputByEnter.value = '';

			if(update==0){
				update=1;
			}

		}else{
		    if (e.keyCode == 13) {
		        e.returnValue = false;
		        $('#message').val('').focus();
		        event.preventDefault();
		    }
		}
	}

	
	function her_leave(){
		if(leaved==0){
			if(window.XMLHttpRequest){
				var xhr = new XMLHttpRequest();
			}else{
				var shr = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xhr.onreadystatechange = function(){
				if(xhr.readyState==4 && xhr.status==200){
					var leave = JSON.parse(xhr.responseText);
					if(leave==0){
						leaved=1;
						div_messages.innerHTML += 
							"<br><br><br><br><br><div id=\"leave\"><big><big>He/She has leaved! Please leave and find another to talk.</big></big></div>";
						mai.scrollTop=mai.scrollHeight;
					}
				}
			};

			xhr.open("POST","process.php",true);

			var fd = new FormData();
			fd.set("mode",3);
			
			fd.set("herId",herid);

			xhr.send(fd);
		}
	}

	function stopUpdate(){
		update=0;
	}

	</script>

	
</body>
</html>




