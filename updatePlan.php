<?php

$server = "127.0.0.1:3306";
$username = "root";
$password = "";
$database = "infits";

$conn = mysqli_connect($server,$username,$password,$database);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$plan_id = $_POST['plan_id'];
$tags = $_POST['tags'];

$sql = "update createplan set tags = '$tags' where plan_id = '$plan_id'";

if (mysqli_query($conn, $sql)) {
    echo "success";
} else {
    echo "failure";
}
