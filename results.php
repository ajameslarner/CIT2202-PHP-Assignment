<?php

if (isset($_GET["location"])){
//Include connection request
include 'control/connect.php';
//Allocate form input variables
//$location = $_GET["location"];
$date = $_GET["date"];

//SELECT * FROM hotels left Join amenity_hotel on amenity_hotel.hotel_id = hotels.id left join amenities on amenities.id = amenity_hotel.amenity_id WHERE hotels.id = 1

//NOTES FOR TOMORROW

// query complete below to output hotel id for us to identify which amenities are associated with that hotel id

// query above gives us the amenities associated with the hotel id

// use the result from the query below to output which ammenities are associated with that result.

//prepared statement
$stmt = $conn2->prepare("SELECT hotels.id AS hotel, hotels.* FROM hotels INNER JOIN locations ON locations.id = hotels.location_id AND locations.location LIKE ?");
$stmt->execute([
    "%".$_GET["location"]."%"
]);
$res=$stmt->fetchAll();
$conn2=NULL;
}
$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
    
$host = $_SERVER['HTTP_HOST'];
$script = $_SERVER['SCRIPT_NAME'];

session_start();
$_SESSION["page"] = $protocol . '://' . $host . $script;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="Description" content="Enter your description here" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/7eeeb655ee.js" crossorigin="anonymous"></script>
    <script src="scripts/actions.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <title>CIT2202 PHP Assignment</title>
</head>
<body>
<section class="nav-content">
        <div class="logo-container">
            <a href="index.php"><img src="img/logo.png" alt="Kirklees Hotels Logo"></a>
        </div>
        <div class="nav-first">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <?php
                if (isset($_SESSION["idSession"])){
                    echo '<li><a href="dashboard.php">Profile</a></li>';
                    echo '<li><a href="control/logout.php">Logout</a></li>';
                    echo '</ul>';
                    echo '</div>';
                    echo '<div class="welcome-login">';
                    echo '<p>Welcome, '.$_SESSION["emailSession"].'</p>';
                    echo '</div>';
                } else {
                    echo '<li><a href="register.php">Register</a></li>';
                    echo '</ul>';
                    echo '</div>';
                    echo '<div class="login-form">';
                    echo '<form action="control/login.php" method="POST">';
                    echo '<input type="text" name="email" placeholder="email">';
                    echo '<input type="password" name="password" placeholder="password">';
                    echo '<input type="submit" class="submit-btn" name="submit" id="submit" value="Login"><br>';
                    echo '<a href="pw-reset.html">Forgot your password?</a>';
                    echo '<a href="pw-reset.html">Create account</a>';
                    echo '<div class="error-handler">';
                    if (isset($_GET["op"])) {
                        if ($_GET["op"] == "emptyLogin") {
                            echo '<span class="error-message">You have missed a field!</span>';
                        } else if ($_GET["op"] == "incorrectEmail") {
                            echo '<span class="error-message">You have entered an invalid email address!</span>';
                        } else if ($_GET["op"] == "incorrectPassword") {
                            echo '<span class="error-message">You have entered an invalid password!</span>';
                        }
                    }
                    echo '</div>';
                    echo '</form>';
                    echo '</div>';
                }
                ?>
        </div>
        <div class="search-form">
            <form action="results.php" method="GET">
                <p>Search for hotels in the Kirklees area today!</p>
                <input type="text" name="location" id="location" placeholder="Search for hotels in your area..." autocomplete="off" required>
                <div id="location-list" onclick="document.getElementById('location').focus(); return false;">
                </div>
        </div>
        <div class="search-form">
            <p>Choose a start date!</p>
            <input type="date" name="date" id="date">
            <input type="submit" class="submit-btn" id="submit" value="Go!">
        </div>
            </form>
        <div class="nav-second">
            <ul>
                <a href="details.php"><li>Amenities</li></a>
                <a href="details.php"><li>Hotel Styles</li></a>
                <a href="details.php"><li>Locations</li></a>
            </ul>
        </div>
        <div class="nav-third">
            <ul>
                <a href="#"><li><i class="fab fa-twitter-square"></i></li></a>
                <a href="#"><li><i class="fab fa-facebook-square"></i></li></a>
                <a href="#"><li><i class="fab fa-instagram-square"></i></li></a>
            </ul>
        </div>
    </section>
    <section class="primary-content">
        <?php
        echo '<div class="results-list">';
        if(isset($_GET["location"])) {
            echo '<div class="grid-item-header">';
            echo '<h1>Search Results for "'.$_GET["location"].'"</h1>';
            echo '</div>';
            if (count($res)>0) {
                foreach ($res as $r) {
                    echo '<div class="result-content">';
                    $conn = mysqli_connect('localhost','root','','kirklees-hotel');
                    $sql = "SELECT * FROM hotels left Join amenity_hotel on amenity_hotel.hotel_id = hotels.id left join amenities on amenities.id = amenity_hotel.amenity_id WHERE hotels.id = ".$r["hotel"]."";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        echo '<div class="amen">';
                        echo '<ul>';
                        while($row = mysqli_fetch_assoc($result)) {
                            if ($row["id"] == 1 ){
                                echo '<li><span title="Free WiFI"><i class="fas fa-wifi"></i></span></li>';
                            } else if ($row["id"] == 2 ){
                                echo '<li><span title="Swimming Pool"><i class="fas fa-swimming-pool"></i></li>';
                            } else if ($row["id"] == 3 ){
                                echo '<li><span title="Health Spa"><i class="fas fa-spa"></i></li>';
                            } else if ($row["id"] == 4 ){
                                echo '<li><span title="Free Parking"><i class="fas fa-parking"></i></li>';
                            } else if ($row["id"] == 5 ){
                                echo '<li><span title="Gym"><i class="fas fa-dumbbell"></i></li>';
                            } else if ($row["id"] == 6 ){
                                echo '<li><span title="Air Conditioning"><i class="fas fa-wind"></i></li>';
                            } else if ($row["id"] == 7 ){
                                echo '<li><span title="Restaurant"><i class="fas fa-utensils"></i></li>';
                            } else if ($row["id"] == 8 ){
                                echo '<li><span title="TV"><i class="fas fa-tv"></i></li>';
                            } else if ($row["id"] == 9 ){
                                echo '<li><span title="Pets Allowed"><i class="fas fa-paw"></i></li>';
                            } else if ($row["id"] == 10 ){
                                echo '<li><span title="24-hour Reception"><i class="fas fa-concierge-bell"></i></li>';
                            };
                        };
                        echo '</ul>';
                        echo '</div>';
                    };
                    mysqli_close($conn);
                    echo '<div class="stars">';
                    echo '<ul>';
                    if ($r["stars"] == 1 ){
                        echo '<li><i class="far fa-star"></i></li>';
                        echo '<li><i class="far fa-star"></i></li>';
                        echo '<li><i class="far fa-star"></i></li>';
                        echo '<li><i class="far fa-star"></i></li>';
                        echo '<li><i class="fas fa-star"></i></li>';
                    } else if ($r["stars"] == 2 ){
                        echo '<li><i class="far fa-star"></i></li>';
                        echo '<li><i class="far fa-star"></i></li>';
                        echo '<li><i class="far fa-star"></i></li>';
                        echo '<li><i class="fas fa-star"></i></li>';
                        echo '<li><i class="fas fa-star"></i></li>';
                    } else if ($r["stars"] == 3 ){
                        echo '<li><i class="far fa-star"></i></li>';
                        echo '<li><i class="far fa-star"></i></li>';
                        echo '<li><i class="fas fa-star"></i></li>';
                        echo '<li><i class="fas fa-star"></i></li>';
                        echo '<li><i class="fas fa-star"></i></li>';
                    } else if ($r["stars"] == 4 ){
                        echo '<li><i class="far fa-star"></i></li>';
                        echo '<li><i class="fas fa-star"></i></li>';
                        echo '<li><i class="fas fa-star"></i></li>';
                        echo '<li><i class="fas fa-star"></i></li>';
                        echo '<li><i class="fas fa-star"></i></li>';
                    } else if ($r["stars"] == 5 ){
                        echo '<li><i class="fas fa-star"></i></li>';
                        echo '<li><i class="fas fa-star"></i></li>';
                        echo '<li><i class="fas fa-star"></i></li>';
                        echo '<li><i class="fas fa-star"></i></li>';
                        echo '<li><i class="fas fa-star"></i></li>';
                    };
                    echo '</ul>';
                    echo '</div>';
                    echo '<div class="hotel-img">';
                    echo '<a href="#"><img src="img/hotel-'.$r["id"].'.jpg" alt=""></a>';
                    echo '</div>';
                    echo '<div class="desc">';
                    echo '<h2>'.$r["name"].'</h2><br>';
                    echo '<h4>£'.$r['price'].'</h4><br>';
                    echo '<p>Check-in: '.$r['check_in'].' Check-out: '.$r['check_out'].'</p><br>';
                    echo '<div class="results-btn">';
                    echo '<input type="submit" value="See Details">';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                };
            } else {
                echo '<div class="result-content">';
                echo "<p>No results found!</p>";
                echo '</div>';
            };
        } else {
            echo '<div class="result-content">';
            echo "<p>Please enter a search term above</p>";
            echo '</div>';
            echo '</div>';
        };
        ?>
    </section>
        <section class="tertiary-content">
            <div class="grid-footer">
                <div class="footer-content">
                    <p>Site links</p>
                </div>
                <div class="footer-content">
                    <p>Social links</p>
                </div>
                <div class="footer-content">
                    <p>Contact links</p>
                </div>
            </div>
        </section>
        <div class="footer">
            <p>Copyright © 2020 Kirklees Hotels | Development: Anthony James Larner</p>
        </div>
    </body>
    <script>
    $(document).ready(function() {
        $('#location').keyup(function() {
            var query = $(this).val();
            if (query != '') {
                $.ajax({
                    url:"control/search.php",
                    method: "POST",
                    data: {query:query},
                    success: function(data){
                        $('#location-list').fadeIn();
                        $('#location-list').html(data);
                    }
                });
            } else {
                $('#location-list').fadeOut();
            }
        });
        $(document).on('click', '#location-list li', function(){
           $('#location').val($(this).text());
           $('#location-list').fadeOut();
        })
    });
    </script>
    </html>
