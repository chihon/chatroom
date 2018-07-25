<!doctype html>

<?php
require("../Final/config.php");
session_start();
?>
<html>

<head>
<meta http-equiv="refresh" content="5">
<meta charset="utf-8">
<title>養成</title>
<style>
body {
    margin: 0;
}

ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    width: 25%;
    background-color: #f1f1f1;
    position: fixed;
    height: 100%;
    overflow: auto;
}

li a {
    display: block;
    color: #000;
    padding: 8px 16px;
    text-decoration: none;
}

li a.active {
    background-color: #4CAF50;
    color: white;
}

li a:hover:not(.active) {
    background-color: #555;
    color: white;
}
</style>

</head>

<body bgcolor="#4CAF50">

<ul>
  	<li><a class="active" href="../final_project/index.html">Home</a></li>
	<li><a href="../Final/chat.php">Chatroom</a></li>
  	<li><a href="../coupon/coupon.php">Prizes</a></li>
  	<li><a href="../sign/index.php">Receipt</a></li>
  	<li><a href="../users.php">Ranking</a></li>
</ul>
<div style="margin-left:25%;padding:1px 16px;height:1000px;">
	<strong style="color: #FFFFFF; font-family: Arimo, sans-serif; font-size: xx-large;">My little pet</strong>
<table width="764" height="467" border="0">
  <tbody>
    <tr>
      <td width="61" style="font-size: large; color: #FFFFFF;">Level </td>
      <td width="85">
		  
		<?php 
		  if(isset($_SESSION['id'])){
             $playerID = $_SESSION['id'];			  
		
              $db = new mysqli($db_host, $db_user, $db_pass, $db_name);
              $query = "SELECT * FROM player where ID='$playerID'";
              $result = $db->query($query);
              $row = $result->fetch_array();
              // row['ID'], row['account'], row['point'], row['hunger'], row['login_time']
			  
			  
			  
			  
			  $exp = (time() - $row['login_time'])/60;			  
			  $row['hunger2'] -= $exp*2;
			  $row['hunger2'] += $row['hunger']; //hunger為消費金額
			  $row['hunger'] = 0;    //將消費金額歸0
			  
			  if($row['hunger2'] > 100) {$row['hunger2'] = 100;}
			  else if($row['hunger2'] < 0) {$row['hunger2'] = 0;} //把hunger 限制在0和100間
			  
			  if($row['hunger2'] != 0) {$row['lv'] += $exp;} //hunger = 0 時lv不能提升
			  
			  $lvs = $row['lv']*5 + 10;
			  
			 // update db
			  
			 // 幫我把 $row['hunger2'],$row['hunger'],row['lv'] update到db
              $new_h2 = $row['hunger2'];
              $new_h = $row['hunger'];
              $new_lv = $row['lv'];
              $query = "UPDATE player SET hunger2='$new_h2', hunger='$new_h', lv='$new_lv' WHERE ID='$playerID'";
              $db->query($query);
			   
          }
          else {
             header('Location: ../Final/index.php');
             exit();
          }
		  echo number_format($row['lv'], 0) ;
		  ?> 
		
		
		
		</td>
		
      <td width="596" rowspan="2" align="center">
		  <?php
		  if($row['hunger2']>40)
		  	{echo "<img src=slime1.gif width=$lvs height=$lvs />";}
		  else 
		  	{echo "<img src=slime2.gif width=$lvs height=$lvs />";}
		  ?> </td>
    </tr>
    <tr>
      <td style="color: #FFFFFF; font-size: large;">Fullness </td>
      <td>		
		  <?php 
		  
			  echo number_format($row['hunger2'], 0) ."%";
		  ?> 
		</td>
      </tr>
  </tbody>
</table>

</div>







</body>
</html>
