<?php

if (isset($_POST["submit"])) {

    session_start();
   
    $email = $_POST["email"];
    $pword = $_POST["password"];

    require_once 'connect.php';
    require_once 'functions.php';

    if (emptyLogin($email, $pword) !== false) {
        header('Location: ' . $_SESSION["page"] . '?op=emptyLogin');
        unset($_SESSION["page"]);
        exit();
    }

    loginUser($conn, $email, $pword);

} else {
    header('Location: ' . $_SESSION["page"] . '?op=error');
    unset($_SESSION["page"]);
    exit();
}

?>