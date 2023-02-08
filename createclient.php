<?php

require "connect.php";

$conn = mysqli_connect($server,$username,$password,$database);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$dietitianID = $_POST['dietitianID'];
$profile = $_POST['profile'];
$name = $_POST['name'];
$gender = $_POST['gender'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$age = $_POST['age'];
$height = $_POST['height'];
$weight = $_POST['weight'];
$about = $_POST['about'];
$planID = $_POST['plan_id'];

$sql = "insert into addclient values('$dietitianID',NULL,'$profile','$name','$gender','$email','$phone','$age','$height','$weight','$about','$planID')";

if (mysqli_query($conn, $sql)) {
  echo "success";
} else {
  echo "failure";
}

?>
