<?php

$location = $_GET["location"];
$date = $_GET["date"];

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
echo "<p>This is an output test {$location} & {$date}.</p>";

?>
</body>
</html>