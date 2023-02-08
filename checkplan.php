<?php

require "connect.php";

$conn = mysqli_connect($server,$username,$password,$database);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "select * from createplan";

$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result) > 0) {
    echo "1";
} else {
    echo "0";
}

?>