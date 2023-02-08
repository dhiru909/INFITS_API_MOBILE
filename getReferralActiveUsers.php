<?php

$server = "127.0.0.1:3306";
$username = "root";
$password = "";
$database = "infits";

$conn = mysqli_connect($server, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$clientID = $_POST['clientID'];

$sql = "select * from referral_table where clientID = '$clientID'";

$result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($conn));

echo mysqli_fetch_assoc($result)['activeUsers'];

?>
