<?php

function emptyInput($email, $pword, $cpword) {
    $result;
    if (empty($email) || empty($pword) || empty($cpword)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidInput($email) {
    $result;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function inputMatching($pword, $cpword) {
    $result;
    if ($pword !== $cpword) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function inputExists($conn, $email) {
    $sql = "SELECT * FROM users WHERE email = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?op=dbError");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $res = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($res)) {
        //True return will be used to authenticate user during login
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function passwordValidation($pword) {
    $result;
    //The search algorithm to validate the password
    $pattern = "#.*^(?=.{8,30})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#";

    if (!preg_match($pattern, $pword)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function addUser($conn, $email, $pword) {
    $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?op=dbError");
        exit();
    }

    $hashedPword = password_hash($pword, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ss", $email, $hashedPword);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../register.php?op=success");
    exit();
}

function emptyLogin($email, $pword) {
    $result;
    if (empty($email) || empty($pword)) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function loginUser($conn, $email, $pword) {
    $uExists = inputExists($conn, $email);

    if ($uExists === false) {
        header('Location: ' . $_SESSION["page"] . '?op=incorrectEmail');
        exit();
    }

    $pwordhashed = $uExists["password"];
    $pwordcheck = password_verify($pword, $pwordhashed);

    if ($pwordcheck === false) {
        header('Location: ' . $_SESSION["page"] . '?op=incorrectPassword');
        exit();
    } else if ($pwordcheck === true) {
        session_start();

        $_SESSION["idSession"] = $uExists["id"];
        $_SESSION["emailSession"] = $uExists["email"];
        header('Location: ' . $_SESSION["page"] . '?op=success');
        exit();
    }





}

?>