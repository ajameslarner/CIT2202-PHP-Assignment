<?php
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
                <li><a href="#">About</a></li>
                <?php
                if (isset($_SESSION["idSession"])){
                    echo '<li><a href="dashboard.php">Listing</a></li>';
                    echo '</ul>';
                    echo '</div>';
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
            <form action="results.php" method="GET">
                <p>Search for hotels in the Kirklees area today!</p>
                <input type="text" name="location" id="location" placeholder="Search by location..." autocomplete="off" required>
                <input type="submit" class="search-btn" id="submit" value="Go!">
                <div id="location-list" onclick="document.getElementById('location').focus(); return false;">
                </div>
            </form>
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
        <div class="grid-item-header">
            <h1>Create <span>your</span> account</h1>
            <p>Welcome to Kirklees Hotels</p>
        </div>
        <div class="grid-content">
            <div class="register-img">
                <img src="img/register-promo.jpg" alt="">
            </div>
            <div class="register-form">
                <form action="control/signup.php" method="POST">
                    <h4>Account Registration Form</h4>          
                    <input type="email" name="email" id="email" placeholder="Email address..." required><br> 
                    <input type="password" name="pword" id="pword" placeholder="Password..." required><br>
                    <input type="password" name="cpword" id="cpword" placeholder="Confirm password..." required><br>
                    <input type="checkbox" name="terms" id="terms"><span id="small-text">I accept the <a href="#">Terms of Use</a> & <a href="#">Privacy Policy.</a></span><br> <br>
                    <input type="submit" class="submit-btn" name="submit" id="submit" value="Create your Account"><br>
                    <div class="error-handler">
                    <?php
                    if (isset($_GET["op"])) {
                        if ($_GET["op"] == "emptyInput") {
                            echo '<span class="error-message">You have missed a field!</span>';
                        } else if ($_GET["op"] == "invalidInput") {
                            echo '<span class="error-message">You have entered an invalid email address!</span>';
                        } else if ($_GET["op"] == "inputMatching") {
                            echo '<span class="error-message">Your passwords do not match!</span>';
                        } else if ($_GET["op"] == "inputExists") {
                            echo '<span class="error-message">This user already exists!</span>';
                        } else if ($_GET["op"] == "passwordValidation") {
                            echo '<span class="error-message">Your password must contain at least 1 uppercase letter, 1 number, 1 special character and be at least 8 characters in length.</p>';
                        } else if ($_GET["op"] == "success") {
                            echo '<span class="error-message">You account has been registered!</span>';
                        } else if ($_GET["op"] == "dbError") {
                            echo '<span class="error-message">Something went wrong! Please try again.</span>';
                        } else if ($_GET["op"] == "termsEmpty") {
                            echo '<span class="error-message">Please accept the terms.</span>';
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