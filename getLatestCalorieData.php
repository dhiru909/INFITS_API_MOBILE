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

$sql = "select sum(calorie), goal from daily_meals where clientID = '$clientID'";

$result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($connection));

$emparray = array();
$full = array();

while ($row = mysqli_fetch_assoc($result)) {
    $emparray['calorie'] = $row['sum(calorie)'];
    $emparray['goal'] = $row['goal'];

    $full[] = $emparray;
}
echo json_encode(['food' => $full]);

?>
