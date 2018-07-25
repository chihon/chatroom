<?php

require("../Final/config.php");
session_start();
function generateRandomString($length = 5) {
  return substr(str_shuffle(str_repeat($x='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}
if ($_SESSION['name'] != "admin") {
    echo '<script>alert("Permission Denied!"); location.href="../Final/index.php"; </script>';
    exit();
}
if($_GET['price'] == 'random')
  $price = rand(40,300);
else if($_GET['price'] == '')
  $price = 'random';
else
  $price = $_GET['price'];
if($_GET['num'] == 'random')
  $num = generateRandomString();
else if($_GET['num'] == '')
  $num = 'random';
else
  $num = $_GET['num'];
  $website = "add.php?num=$num";
?>

<html>
  <body>
    <form class="" action="record.php" method="get">
        價錢 : <input type="" name="price" value="<?php echo $price ?>" >
        序號 : <input type="" name="num" value="<?php echo $num ?>" ><br>
        <?php
          if($num != 'random' && $price != 'random'){
             $link = mysqli_connect($db_host, $db_user, $db_pass);
             mysqli_select_db($link,$db_name);
             $result = mysqli_query($link,"SELECT `num` FROM `sales` WHERE `num` = '$num'");
             if(mysqli_num_rows($result) != 0)
                echo '<font color="green">重複序號</font>';
              else {
                mysqli_query($link,"INSERT INTO `sales`(`num`, `price`, `valid`) VALUES ('$num','$price', b'0')");
              }
          }
        ?>
        <br>
        <button type="submit" class = "" name="button" >記錄</button>
    </form>
  </body>
</html>
