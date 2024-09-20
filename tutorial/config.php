<?php 
$server = "localhost";
$db = "tutorial";
$user = "root";
$pass = "";

$con = mysqli_connect($server, $user, $pass, $db);

if ($con == false) {
    echo "Connection failed";
} 

?>
