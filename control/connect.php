<?php

//MySQLI Method
$serverName = "localhost";
$dBUser = "root";
$dBPass = "";
$dBName = "kirklees-hotel";

$conn = mysqli_connect($serverName, $dBUser, $dBPass, $dBName);

if (!$conn) {
	die("Connection Error: " . mysqli_connect_error());
}

//PDO Method 
try {
	$connPDO = new PDO('mysql:host=localhost;dbname=kirklees-hotel', 'root', '');
	$connPDO->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}
catch (PDOException $exception)
{
	echo "Error connecting." . $exception->getMessage();
}
?>