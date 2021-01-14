<?php

if (isset($_POST["submit"])){

    $name = $_POST["name"];
    $price = $_POST["price"];
    $checkin = $_POST["checkin"];
    $checkout = $_POST["checkout"];
    $location = $_POST["location"];
    $stars = $_POST["stars"];
    $style = $_POST["style"];
    $amenities = $_POST["amen"];

    require_once 'connect.php';
    require_once 'functions.php';

    if (emptyInputHotel($name, $price, $checkin, $checkout, $location, $stars, $style, $amenities) !== false) {
        header("location: ../dashboard.php?op=emptyInputHotel");
        exit();
    }

    insertHotel($conn, $name, $price, $checkin, $checkout, $location, $stars, $style, $amenities);
}


?>