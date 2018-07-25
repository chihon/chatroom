<?php
require('config.php');

$db = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
$sql = "SELECT ID, account, point FROM player ORDER BY point DESC";
if ( $result = $db->query($sql) ) { 
} else {
    echo "Connection Failed.";
}

?>

<html>
<head>
<meta http-equiv="refresh" content="60">
<title>排行榜</title>
</head>
<body>
    <table border="3" style="font-family:Consolas;">
    <?php $i=1;
    echo '<tr><td>ID</td>' . '<td>account</td>' . '<td>point</td></tr>';
    while ($row = $result->fetch_array()) {
        echo '<tr><td>' . $row['ID'] . '</td>';
        echo '<td>' . $row['account'] . '</td>';
        echo '<td>' . $row['point'] . '</td>';
    } 
    ?>
    </table>
</body>
</html>
