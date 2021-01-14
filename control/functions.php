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

function emptyInputHotel($name, $price, $checkin, $checkout, $location, $stars, $style, $amenities) {
    $result;
    if (empty($name) || empty($price) || empty($checkin) || empty($checkout) || empty($location) || empty($stars) || empty($style) || empty($amenities)) {
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

function termsEmpty($terms) {
    $result;
    if(empty($terms)) {
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

function addUser($conn, $email, $pword, $role) {
    $sql = "INSERT INTO users (email, password, role) VALUES (?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../register.php?op=dbError");
        exit();
    }

    $hashedPword = password_hash($pword, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssi", $email, $hashedPword, $role);
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

function insertHotel($conn, $name, $price, $checkin, $checkout, $location, $stars, $style, $amenities) {
    $sql = "INSERT INTO hotels (name, price, check_in, check_out, location_id, stars, style_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../dashboard.php?op=dbError");
        exit();
    }
    
    mysqli_stmt_bind_param($stmt, "siiiiii", $name, $price, $checkin, $checkout, $location, $stars, $style);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    $sql = "SELECT id, name FROM hotels WHERE name = '$name'";
    $matchResult = mysqli_query($conn,$sql);

    foreach ($matchResult as $r) {
        foreach ($amenities as $a) {
            $sql = "INSERT INTO amenity_hotel (amenity_id, hotel_id) VALUES ('$a', ".$r["id"].")";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("location: ../dashboard.php?op=dbError");
                exit();
            }
            mysqli_stmt_execute($stmt);
        }
        mysqli_stmt_close($stmt);  
        header("location: ../dashboard.php?op=success");
        exit();
    }
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
        $_SESSION["idRole"] = $uExists["role"];
        header('Location: ' . $_SESSION["page"] . '?op=success');
        exit();
    }
}

require_once 'connect.php';

if(isset($_POST["query"])){
    $qry = "SELECT * FROM locations WHERE location LIKE '%".$_POST["query"]."%'";
    $res = mysqli_query($conn, $qry);
    $out = '<ul class="auto-list">';
    if (mysqli_num_rows($res)>0){
        while($row = mysqli_fetch_array($res)){
            $out .= '<a href="#"><li id="auto-item">'.$row["location"].'</li></a>'; 
        }
    }
    $out .= '</ul>';
    echo $out;
}

?>