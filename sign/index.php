<!DOCTYPE html>
<?php
  session_start();
  require("../config.php");
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>登記頁面</title>
    <?php require_once "./bootstrap.html" ?>
  </head>
  <body>
    <div class="container">
      <div class ="row">
        <div class="col-md-4 col-md-offset-4" >
          <a href="../final_project/index.html">回首頁</a>
          <div style="float:right">
            <?php
              if (isset($_SESSION['name'])){
                echo '<a>#';
                echo $_SESSION["name"];
                echo ' </a><a href="../Final/index.php">登出</a>';
                $id = $_SESSION['id'];
                $link = mysqli_connect($db_host,$db_user,$db_pass);
                mysqli_select_db($link,$db_name);
                $result = mysqli_query($link,"SELECT account FROM player WHERE ID='$id'");
                $account = $result->fetch_row()[0];
              }
              else{
                echo '<script>alert("Please login first!"); location.href="../Final/index.php"; </script>';
                exit();
              }
            ?>
          </div>
        </div>
      </div>
      <div class="row">
       <div class="col-md-4 col-md-offset-4" >
         <div class="panel panel-primary">
           <div class="panel-heading">
             <b><h2>Receipt</h2></b>
           </div>
           <br>
          <form class="" action="add.php" method="post">
            <div class="input-group">
              帳號 : <?php echo $account ?>
            </div>
            <div class="input-group">
              序號 : <input type="text" name="num">
            </div>
            <?php if ($_GET['sig']!=''): ?>
              <font color="green"><?php echo $_GET['sig'] ?> </font>
            <?php endif; ?>
              <br>
             <input type="submit" class = "" name="button" >登記</button>
             <input type="hidden" name="sign" value="sign">
          </form>
        </div>
      </div>
    </div>
    </div>
  </body>
</html>
