<?php
$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
    
$host = $_SERVER['HTTP_HOST'];
$script = $_SERVER['SCRIPT_NAME'];

session_start();
$_SESSION["page"] = $protocol . '://' . $host . $script;


if (!isset($_SESSION["idSession"])){
    header('Location: index.php');
}


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
                <li><a href="#">About</a></li>
                <?php
                if (isset($_SESSION["idSession"]) && $_SESSION["idRole"] === 2){
                    echo '<li><a href="dashboard.php">Listings</a></li>';
                    echo '</ul>';
                    echo '</div>';
                }
                if (isset($_SESSION["idSession"])) {
                    echo '<div class="welcome-login">'; 
                    echo '<p>Welcome, '.$_SESSION["emailSession"].'(<a href="control/logout.php">Logout</a>)</p>';
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
                    echo '<a href="register.php">Create account</a>';
                    echo '<a href="#">Forgot your password?</a>'; 
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
                <?php

                if (isset($_SESSION["idSession"])) {
                    echo '<form action="results.php" method="GET">';
                    echo '<p>Search for hotels in the Kirklees area today!</p>';
                    echo '<input type="text" name="location" id="location" placeholder="Search by location..." autocomplete="off" required>';
                    echo '<input type="submit" class="search-btn" id="submit" value="Go!">';
                    echo '<div id="location-list" onclick="document.getElementById("location").focus(); return false;">';
                    echo '</div>';
                    echo '</form>';
                }
                ?>
        </div>
        <div class="nav-second">
            <ul>
                <a href="#"><li>Amenities</li></a>
                <a href="#"><li>Hotel Styles</li></a>
                <a href="#"><li>Locations</li></a>
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
    <div class="grid-content">
    <div class="insert-form">
                    <h4>Advanced Search Form</h4>
                    <form action="results.php" method="GET">      
                    <select name="location" id="location">
                        <option value="" disabled selected>Hotel Location</option>
                        <option value="Batley">Batley</option> 
                        <option value="Colne Valley">Colne Valley</option> 
                        <option value="Denby Dale">Denby Dale</option> 
                        <option value="Holme Valley">Holme Valley</option> 
                        <option value="Huddersfield East">Huddersfield East</option>
                        <option value="Huddersfield West">Huddersfield West</option> 
                        <option value="Kirkburton">Kirkburton</option> 
                        <option value="Mirfield">Mirfield</option> 
                        <option value="Spen Valley and Heckmondwike">Spen Valley and Heckmondwike</option> 
                    </select>
                    <input type="submit" class="submit-btn" name="submit" id="submit" value="Search">
                    </form>
                    <form action="results.php" method="GET"> 
                    <select name="stars" id="stars">
                        <option value="" disabled selected>Hotel Stars</option>
                        <option value="1">1</option> 
                        <option value="2">2</option> 
                        <option value="3">3</option> 
                        <option value="4">4</option> 
                        <option value="5">5</option>
                    </select>
                    <input type="submit" class="submit-btn" name="submit" id="submit" value="Search">
                    </form>
                    <form action="POST">
                    <select name="style" id="style">
                        <option value="" disabled selected>Hotel Style</option>
                        <option value="1">Boutique</option> 
                        <option value="2">Budget</option> 
                        <option value="3">Business</option> 
                        <option value="4">Historic</option> 
                        <option value="5">Luxury</option>
                    </select>
                    <input type="submit" class="submit-btn" name="submit" id="submit" value="Search">
                    </form>
                    <form action="">
                    <br>
                    <h3>Select your hotels Amenities</h3><br>
                    <input type="checkbox" name="amen[]" id="wifi" class="hidden" value="1" ><label for="wifi" id="wifitoggle" class="amenity-inactive" onclick="toggle('wifitoggle')"><span title="Free WiFI"><i class="fas fa-wifi"></i></span></label>
                    <input type="checkbox" name="amen[]" id="pool" class="hidden" value="2"><label for="pool" id="pooltoggle" class="amenity-inactive" onclick="toggle('pooltoggle')"><span title="Swimming Pool"><i class="fas fa-swimming-pool"></i></span></label>
                    <input type="checkbox" name="amen[]" id="spa" class="hidden" value="3"><label for="spa" id="spatoggle" class="amenity-inactive" onclick="toggle('spatoggle')"><span title="Spa"><i class="fas fa-spa"></i></span></label>
                    <input type="checkbox" name="amen[]" id="park" class="hidden" value="4"><label for="park" id="parktoggle" class="amenity-inactive" onclick="toggle('parktoggle')"><span title="Parking"><i class="fas fa-parking"></i></span></label>
                    <input type="checkbox" name="amen[]" id="gym" class="hidden" value="5"><label for="gym" id="gymtoggle" class="amenity-inactive" onclick="toggle('gymtoggle')"><span title="Gym"><i class="fas fa-dumbbell"></i></span></label>
                    <input type="checkbox" name="amen[]" id="ac" class="hidden" value="6"><label for="ac" id="actoggle" class="amenity-inactive" onclick="toggle('actoggle')"><span title="A/C"><i class="fas fa-wind"></i></span></label>
                    <input type="checkbox" name="amen[]" id="food" class="hidden" value="7"><label for="food" id="foodtoggle" class="amenity-inactive" onclick="toggle('foodtoggle')"><span title="Restaurant"><i class="fas fa-utensils"></i></span></label>
                    <input type="checkbox" name="amen[]" id="tv" class="hidden" value="8"><label for="tv" id="tvtoggle" class="amenity-inactive" onclick="toggle('tvtoggle')"><span title="TV"><i class="fas fa-tv"></i></span></label>
                    <input type="checkbox" name="amen[]" id="pets" class="hidden" value="9"><label for="pets" id="petstoggle" class="amenity-inactive" onclick="toggle('petstoggle')"><span title="Pets"><i class="fas fa-paw"></i></span></label>
                    <input type="checkbox" name="amen[]" id="hour" class="hidden" value="10"><label for="hour" id="hourtoggle" class="amenity-inactive" onclick="toggle('hourtoggle')"><span title="24-hour Reception"><i class="fas fa-concierge-bell"></i></span></label>
                    <br><br><br>
                    <input type="submit" class="submit-btn" name="submit" id="submit" value="Search"><br><br>
                    <div class="error-handler">
                    <?php
                    if (isset($_GET["op"])) {
                        if ($_GET["op"] == "emptyInputHotel") {
                            echo '<span class="error-message-add">Please fill in all the fields!</span>';
                        } else if ($_GET["op"] == "success") {
                            echo '<span class="error-message-add">You hotel has been successfully added!</span>';
                        } else if ($_GET["op"] == "dbError") {
                            echo '<span class="error-message-add">Something went wrong! Please try again.</span>';
                        }
                    }
                    ?>
                    </div>
                    </form>
            </div>
    </div>
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
                    url:"control/functions.php",
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

function toggle(ID) {
    var element = document.getElementById(ID);
        if (element.classList.contains('amenity-inactive')) {
            element.classList.remove('amenity-inactive');
            element.classList.add('amenity-active');
        } else if (element.classList.contains('amenity-active')) {
            element.classList.remove('amenity-active');
            element.classList.add('amenity-inactive');
        }
};
$(document).ready(function() {
    $('label[for=wifi]').on('click', function(){});
    $('label[for=pool]').on('click', function(){});
    $('label[for=spa]').on('click', function(){});
    $('label[for=park]').on('click', function(){});
    $('label[for=gym]').on('click', function(){});
    $('label[for=ac]').on('click', function(){});
    $('label[for=food]').on('click', function(){});
    $('label[for=tv]').on('click', function(){});
    $('label[for=pets]').on('click', function(){});
    $('label[for=hour]').on('click', function(){});
});
    </script>
    </html>