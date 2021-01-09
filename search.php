<?php
$conn = mysqli_connect("localhost","root","","kirklees-hotel");
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



<!--  ---- backup qry -->