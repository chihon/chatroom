<?php
require('config.php');

$db = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
// $sql = "SELECT 'radacctid', 'acctstarttime', 'acctstoptime', 'acctsessiontime', 'acctinputoctets', 'acctoutputoctets','callingstationid', 'framedipaddress' FROM 'radacct' ORDER BY 'radacctid' DESC LIMIT 10";
$sql = "SELECT ID, account, point, lv FROM player ORDER BY lv DESC";
if ( $result = $db->query($sql) ) { 
/*
    while ($row = $result->fetch_assoc()) {
        // echo $row['radacctid'] . "\t" . $row['acctstarttime'] . "\t" . $row['acctinputoctets'] . "\t" . $row['acctoutputoctets'];
        print_r($row);
        echo "<br />";
    }
*/
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
    echo '<tr><td>Ranking</td>' . '<td>Account</td>' . '<td>Point</td>' . '<td>Level</td></tr>';
    while ($row = $result->fetch_array()) {
        echo '<tr><td>' . $i . '</td>';
        echo '<td>' . $row['account'] . '</td>';
        echo '<td>' . $row['point'] . '</td>';
        echo '<td>' . $row['lv'] . '</td></tr>';
        $i++;
    } 
    ?>
    </table>
</body>
</html>
