<?php

$server = "127.0.0.1:3307";
$username = "root";
$password = "";
$database = "infits";

$conn = mysqli_connect($server, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$clientID = $_POST['clientID'];

$sql = "select * from in_app_notifications where clientID = '$clientID'";

$result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($connection));

$emparray = array();
$full = array();

while ($row = mysqli_fetch_assoc($result)) {
    $emparray['date'] = date("d-m-Y", strtotime($row['date']));
    $emparray['time'] = date("g:i A", strtotime($row['date']));
    $emparray['type'] = $row['type'];
    $emparray['text'] = $row['text'];

    $full[] = $emparray;
}
echo json_encode(['inApp' => $full]);

?>
