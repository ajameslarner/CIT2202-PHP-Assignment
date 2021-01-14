<?php

//Filter queries

if (isset($_GET["location"])) {
    //Database Connection Details
    require_once 'connect.php';
    //Matched hotels by location filter (PDO Method)
    $stmt = $connPDO->prepare("SELECT hotels.id AS hotel, hotels.* FROM hotels INNER JOIN locations ON locations.id = hotels.location_id AND locations.location LIKE ?");
    $stmt->execute(["%".$_GET["location"]."%"]);
    $resultsHotels=$stmt->fetchAll();
    $connPDO=NULL;
}

if (isset($_GET["stars"])) {
    //Database Connection Details
    require_once 'connect.php';
    //Matched hotels by stars filter (PDO Method)
    $stmt = $connPDO->prepare("SELECT hotels.id AS hotel, hotels.* FROM hotels WHERE stars LIKE ?");
    $stmt->execute(["%".$_GET["stars"]."%"]);
    $resultsHotels=$stmt->fetchAll();
    $connPDO=NULL;
}

if (isset($_GET["style"])) {
    //Database Connection Details
    require_once 'connect.php';
    //Matched hotels by stlye filter (PDO Method)
    $stmt = $connPDO->prepare("SELECT hotels.id AS hotel, hotels.* FROM hotels INNER JOIN styles ON styles.id = hotels.style_id AND styles.name LIKE ?");
    $stmt->execute(["%".$_GET["style"]."%"]);
    $resultsHotels=$stmt->fetchAll();
    $connPDO=NULL;
}

?>