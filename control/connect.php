<?php

$serverName = "localhost";
$dBUser = "root";
$dBPass = "";
$dBName = "kirklees-hotel";

$conn = mysqli_connect($serverName, $dBUser, $dBPass, $dBName);

if (!$conn) {
	die("Connection Error: " . mysqli_connect_error());
}

try {
	$conn2 = new PDO('mysql:host=localhost;dbname=kirklees-hotel', 'root', '');
	$conn2->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}
catch (PDOException $exception)
{
	echo "Error connecting." . $exception->getMessage();
}
?>