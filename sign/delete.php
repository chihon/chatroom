<?php
require("../config.php");
if ($_POST['del'] == del) {
    $db = new mysqli($db_host, $db_user, $db_pass, $db_name);
    $IDs = $_POST['deleteID'];
    foreach($IDs as $ID) {
        $query = "DELETE FROM sales WHERE ID=$ID";
        $db->query($query);
    }
    header("Location: admin.php");
    exit();
}
?>
