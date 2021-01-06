<?php
//Include connection request
include 'connect.php';

//Allocate form input variables
//$location = $_GET["location"];
$date = $_GET["date"];

//prepared statement
$stmt = $conn->prepare("SELECT * FROM hotels INNER JOIN locations ON locations.id = hotels.location_id AND locations.location LIKE ?");
$stmt->execute([
    "%".$_GET["location"]."%"
]);
$res=$stmt->fetchAll();
$conn=NULL;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>location.php</title>
</head>
<body>
<?php
if(isset($_GET["location"])) {
    if (count($res)>0) {
        foreach ($res as $r) {
            printf("
            <p>This is a test out</p> <br>
            <p>Hotel name: {$r['name']}</p> <br>
            <p>Hotel stars:  {$r['stars']}</p> <br>
            <p>Hotel price: {$r['price']}</p> <br>
            <p>Hotel location: {$r['location']}</p> <br>
            ");
        }
    } else {
        echo "<p>No results found!</p>";
    }
}
?>
</body>
</html>