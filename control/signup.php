<?php

if (isset($_POST["submit"])) {

    $email = $_POST["email"];
    $pword = $_POST["pword"];
    $cpword = $_POST["cpword"];
    $terms = $_POST["terms"];
    
    $role = 1;

    require_once 'connect.php';
    require_once 'functions.php';

    if (emptyInput($email, $pword, $cpword) !== false) {
        header("location: ../register.php?op=emptyInput");
        exit();
    }
    if (invalidInput($email) !== false) {
        header("location: ../register.php?op=invalidInput");
        exit();
    }
    if (inputMatching($pword, $cpword) !== false) {
        header("location: ../register.php?op=inputMatching");
        exit();
    }
    if (inputExists($conn, $email) !== false) {
        header("location: ../register.php?op=inputExists");
        exit();
    }
    if (passwordValidation($pword) !== false) {
        header("location: ../register.php?op=passwordValidation");
        exit();
    }
    if (termsEmpty($terms) !== false) {
        header("location: ../register.php?op=termsEmpty");
        exit();
    }

    addUser($conn, $email, $pword, $role);

} else {
    header("location: ../register.php");
}
?>