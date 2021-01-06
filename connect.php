<?php
try{
$conn = new PDO('mysql:host=localhost;dbname=kirklees-hotel', 'root', '');
$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}
catch (PDOException $exception)
{
	echo "Error connecting." . $exception->getMessage();
}
?>