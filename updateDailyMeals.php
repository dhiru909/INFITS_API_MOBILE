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
$name = $_POST['name'];
$calorie = $_POST['calorie'];
$protein = $_POST['protein'];
$fibre = $_POST['fibre'];
$carb = $_POST['carb'];
$fat = $_POST['fat'];
$time = $_POST['time'];
$goal = $_POST['goal'];

$sql = "insert into daily_meals values('$clientID','$name','$calorie','$protein','$fibre','$carb','$fat','$time','$goal')";

$result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($connection));

if ($result) {
    echo "inserted";
}

?>
