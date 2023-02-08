<?php

$server = "127.0.0.1:3307";
$username = "root";
$password = "";
$database = "infits";

$conn = mysqli_connect($server,$username,$password,$database);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "select plan_id from createplan ORDER BY plan_id DESC LIMIT 1";

$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

echo $row['plan_id'];

?>
