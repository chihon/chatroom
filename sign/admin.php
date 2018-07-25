<?php
require("../config.php");
session_start();
if ($_SESSION['name'] != 'admin') {
    echo '<script>alert("Permission Denied!"); location.href="../Final/index.php"; </script>';
    exit();
}
$db = new mysqli($db_host, $db_user, $db_pass, $db_name);

$query = "SELECT * FROM sales ORDER BY valid DESC";
if ( !($result = $db->query($query)) ) {
    echo "Connection Failed";
}
?>

<html>
<head>
<title>發票管理後台</title>
</head>

<body>
    <div id="top">
        <div id="title"><b>發票管理後台</b></div>
    </div>

    <div id="container">
    <form action="delete.php" method="POST">
    <table border="3" style="font-family:Consolas;">
    <?php
    echo '<tr><td>ID</td>' . '<td>序號</td>' . '<td>價錢</td>' . '<td>已使用</td>' . '<td>刪除</td></tr>';
    while ($row = $result->fetch_array()) {
        echo '<tr><td>' . $row['ID'] . '</td>';
        echo '<td>' . $row['num'] . '</td>';
        echo '<td>' . $row['price'] . '</td>';
        echo '<td>' . ($row['valid']?'Y':'N') . '</td>';
        echo '<td><input type="checkbox" name="deleteID[]" value="' . $row['ID'] . '" ></td></tr>';
    }
    ?>
    </table>
    <input type="submit" value="刪除勾選">
    <input type="hidden" name="del" value="del">
    </form>
    </div>

    <form action="add_receipt.php" method="GET">
        序號：<input type="text" name="num"><br>
        價錢：<input type="text" name="price"><br>
        <input type="checkbox" name="random" value="random">隨機產生<br>
        <br><br>
        <input type="submit" value="登錄">
        <input type="hidden" name="add" value="add">
    </form>
    </div>
</body>

</html>
