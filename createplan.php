<?php

require "connect.php";

$conn = mysqli_connect($server,$username,$password,$database);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$profile = $_POST['profile'];
$name = $_POST['name'];
$tags = $_POST['tags'];
$duration = $_POST['duration'];
$description = $_POST['description'];
$price = $_POST['price'];

// $profile = "profile";
// $name = "name";
// $tags = "tags";
// $duration = "duration";
// $description = "description";
// $price = "price";

$sql = "insert into createplan values(NULL,'$profile','$name','$tags','$duration','$description','$price')";

if(mysqli_query($conn,$sql)) {
    echo "success";
} else {
    echo "failure";
}

?>
