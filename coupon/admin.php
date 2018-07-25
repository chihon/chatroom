<?php
require("../config.php");
session_start();
if ($_SESSION['name'] != 'admin') {
    echo '<script>alert("Permission Denied!"); location.href="../Final/index.php"; </script>';
    exit();
}
$db = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$query = "SELECT * FROM coupon ORDER BY available DESC";
if ( !($result = $db->query($query)) ) {
    echo "Connection Failed";
}
?>

<html>
<head>
<title>兌獎券管理後台</title>
</head>

<body>
    <div id="top">
        <div id="title"><b>兌獎券管理後台</b></div>
    </div>

    <div id="container">
    <form action="delete_coupon.php" method="POST">
    <table border="3" style="font-family:Consolas;">
    <?php
    echo '<tr><td>ID</td>' . '<td>序號</td>' . '<td>點數</td>' . '<td>可兌換</td>' . '<td>使用帳戶</td>' . '<td>刪除</td></tr>';
    while ($row = $result->fetch_array()) {
        echo '<tr><td>' . $row['ID'] . '</td>';
        echo '<td>' . $row['sequence'] . '</td>';
        echo '<td>' . $row['discount'] . '</td>';
        echo '<td>' . $row['available'] . '</td>';
        echo '<td>' . $row['used_account'] . '</td>';
        if ($row['available'] == 1) { 
            echo '<td><input type="checkbox" name="deleteID[]" value="' . $row['ID'] . '" ></td></tr>';
        } else {
            echo '<td></td></tr>';
        }
    }
    ?>
    </table>
    <input type="submit" value="刪除勾選">
    <input type="hidden" name="del" value="del">
    </form>
    </div>

    <form action="add_coupon.php" method="GET">
        點數：<input type="text" name="discount"><br>
        數量：<input type="text" name="number"><br>
        <br><br>
        <input type="submit" value="產生兌換券">
        <input type="hidden" name="add" value="add">
    </form>
    </div>
</body>

</html>
