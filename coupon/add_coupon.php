<?php
require("config.php");
function randomString($length = 16) {
	$str = "";
	$characters = array_merge(range('A','Z'), range('0','9'));
	$max = count($characters) - 1;
	for ($i = 0; $i < $length; $i++) {
		$rand = mt_rand(0, $max);
		$str .= $characters[$rand];
	}
	return $str;
}
if ($_GET['add'] == add) {
    $db = new mysqli($db_host, $db_user, $db_pass, $db_name); 
    $number = $_GET['number'];
    $discount = $_GET['discount'];
    echo $number . "<br>";
    echo $discount . "<br>";
    if (!is_numeric($number) || !is_numeric($discount)) {
        echo '<script>alert("數量及點數必須是整數！"); location.href="coupon_admin.php"; </script>';
        exit();
        // echo '<script>alert("Must be Integer!"); location.href="coupon_admin.php"; </script>';
    }

    while($number > 0) {
        $sequence = randomString(16);
        echo $sequence . "<br>";
        $query = "INSERT INTO coupon (sequence, discount) VALUES ('$sequence', '$discount')"; 
        $db->query($query);
        $number = $number - 1;
    }
    header("Location: coupon_admin.php");
    exit();
}

?>
