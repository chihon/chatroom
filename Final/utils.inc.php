<?php

session_start();

$options = array(
	PDO::ATTR_EMULATE_PREPARES => false, 
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
$db = new PDO(
		'mysql:host=localhost;dbname=radius;charset=utf8', 
		'root', 'root', $options);

?>
