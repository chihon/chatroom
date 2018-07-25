<?php
require("../config.php");
function randomString($length = 8) {
	$str = "";
	$characters = range('0','9');
	$max = count($characters) - 1;
	for ($i = 0; $i < $length; $i++) {
		$rand = mt_rand(0, $max);
		$str .= $characters[$rand];
	}
	return $str;
}
if ($_GET['add'] == add) {
    $db = new mysqli($db_host, $db_user, $db_pass, $db_name); 
    if ($_GET['random'] == "random") {
        $num = randomString(8);
        $price = rand(40, 300);
    } else {
        $num = $_GET['num'];
        $price = $_GET['price'];
        if (!is_numeric($num) || !is_numeric($price)) {
            echo '<script>alert("Invalid Data Type!"); location.href="coupon_admin.php"; </script>';
            exit();
        }
    }

    $query = "INSERT INTO sales (num, price) VALUES ('$num', '$price')"; 
    $db->query($query);
    header("Location: admin.php");
    exit();
}

?>
