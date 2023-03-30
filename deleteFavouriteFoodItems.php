<?php
$server = "127.0.0.1:3306";
$username = "root";
$password = "";
$database = "infits";
$conn = mysqli_connect($server, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$clientuserID = $_POST['clientuserID'];
$FavouriteFoodName=$_POST['FavouriteFoodName'];
// $clientuserID="test";
// $FavouriteFoodName="poha";

$sql="DELETE FROM `favourite_food_items` WHERE clientID='$clientuserID' and nameofFoodItem='$FavouriteFoodName'";
if (mysqli_query($conn,$sql)) {
    echo "success";
  }
  else{
    echo "failed";
  }
?>