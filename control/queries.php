<?php

//Database Connection Details
require_once 'connect.php';

//Matched Hotels by Location Search (PDO Method)
$stmt = $connPDO->prepare("SELECT hotels.id AS hotel, hotels.* FROM hotels INNER JOIN locations ON locations.id = hotels.location_id AND locations.location LIKE ?");
$stmt->execute(["%".$_GET["location"]."%"]);
$resultsHotels=$stmt->fetchAll();
$connPDO=NULL;

//Database Connection Details
require_once 'connect.php';

//Matched Hotels by Location Search (PDO Method)
$stmt = $connPDO->prepare("SELECT hotels.id AS hotel, hotels.* FROM hotels WHERE stars LIKE ?");
$stmt->execute(["%".$_GET["stars"]."%"]);
$resultsHotels=$stmt->fetchAll();
$connPDO=NULL;


?>