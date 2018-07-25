<?php
require("../config.php");
session_start();
if (!isset($_SESSION['id'])) {
    echo '<script>alert("Please login first!"); location.href="../Final/index.php"; </script>';
    exit();
}
?>
<html>
    <div id="top">
        <a href="../final_project/index.html">回首頁</a>
    </div>
    <div id="container">
    <form action="coupon.php" method="POST">
        帳號：<?php echo $_SESSION['name']; ?><br>
        序號：<input type="text" name="sequence"><br>
        <br><br>
        <input type="submit" value="提交">
        <input type="hidden" name="coupon" value="coupon">

    </form>
    </div>
</html>
<?php
if ($_POST['coupon'] == coupon) {
    $db = new mysqli($db_host, $db_user, $db_pass, $db_name);
    $account = $_SESSION['name'];
    $sequence = $_POST['sequence'];
    $query = "SELECT account, point, ID FROM player WHERE account='$account'";
    if (!($result = $db->query($query)) ) {
        echo '<script>alert("account not found!"); location.href="coupon.php"; </script>';
    }
    $array = $result->fetch_array();
    $point = $array['point'];
    $query = "SELECT sequence, discount, available FROM coupon where sequence='$sequence'";
    if (!($result = $db->query($query)) ) {
        echo '<script>alert("coupon is not found!"); location.href="coupon.php"; </script>';
    }
    $array = $result->fetch_array();
    if ($array['available'] == 0) {
        echo '<script>alert("coupon is invalid!"); location.href="coupon.php"; </script>';
    }

    $point = $point + $array['discount'];
    $query = "UPDATE player SET point='$point' WHERE account='$account'";
    $db->query($query);

    $query = "UPDATE coupon SET available=b'0', used_account='$account' WHERE sequence='$sequence'";
    $db->query($query);

    header("Location: ../users.php");
    exit();
}
?>
