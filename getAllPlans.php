<?php

$server = "127.0.0.1:3306";
$username = "root";
$password = "";
$database = "infits";

$conn = mysqli_connect($server,$username,$password,$database);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "select * from createplan";

$result = mysqli_query($conn, $sql);

$temp = array();

while($row = mysqli_fetch_assoc($result)) {
    $temp['plan_id'] = $row['plan_id'];
    $temp['profile'] = $row['profile'];
    $temp['name'] = $row['name'];
    $temp['tags'] = $row['tags'];
    $temp['duration'] = $row['duration'];
    $temp['description'] = $row['description'];
    $temp['price'] = $row['price'];

    $full[] = $temp;
}

echo json_encode(['plans' => $full]);

?>
