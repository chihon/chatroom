<?php
     ini_set("display_errors","On");
     require("../Final/config.php");
     session_start();
     //$link = mysqli_connect("localhost","root","12345678");
     $link2 = mysqli_connect($db_host, $db_user, $db_pass);
     //mysqli_select_db($link,"record");
     mysqli_select_db($link2,$db_name);
     mysqli_query($link2, 'SET CHARACTER SET utf8');
     mysqli_query($link2,  "SET collation_connection = 'utf8_general_ci'");

     if(isset($_POST['num']))
        $num = $_POST['num'];
     else
        $num = $_GET['num'];

     /*
     if (isset($_POST['mail']))
        $mail = $_POST['mail'];
     else if (isset($_SESSION['id'])){
        $id = $_SESSION['id'];
        $result = mysqli_query($link2,"SELECT `email` FROM `fbmember` WHERE `id` = '$id'");
        $mail = $result->fetch_row()[0];
     }
     */

     if (!isset($_SESSION['id'])) {
        echo '<script>alert("Please login first!"); location.href="../Final/index.php"; </script>';
        exit();
     }
     else{
       $playerID = $_SESSION['id'];
       $result = mysqli_query($link2,"SELECT price FROM sales WHERE num = '$num'");
       $res = mysqli_query($link2,"SELECT valid FROM sales WHERE num = '$num'");
       if (mysqli_num_rows($result) == 0 || $res->fetch_row()[0] == 1){
         header("location:./index.php?sig=登記失敗");
       }
       else{
         $price = $result->fetch_row()[0];
         $res = mysqli_query($link2,"SELECT hunger FROM player WHERE ID='$playerID'");
         $hunger = $res->fetch_row()[0] + $price/2;
         mysqli_query($link2,"UPDATE player SET hunger='$hunger' WHERE ID='$playerID'");
         mysqli_query($link2,"UPDATE sales SET valid=b'1' WHERE num='$num'");
         header("location:./index.php?sig=登記成功");
       }
       mysql_close($link2);
     }
?>
