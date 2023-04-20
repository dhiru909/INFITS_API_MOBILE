<?php
$server = "127.0.0.1:3306";
$username = "root";
$password = "";
$database = "infits";
$conn = mysqli_connect($server, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$MealName=$_POST['Meal_Name'];
$sql="select fibre from food_info WHERE name='$MealName'";
$result=mysqli_query($conn,$sql);

$row =mysqli_fetch_assoc($result);

$clientID = $_POST['clientID'];
$caloriesconsumed=$_POST['caloriesconsumed'];
$time=$_POST['time'];
$carbs=$_POST['carbs'];
$fats=$_POST['fats'];
$protein=$_POST['protein'];
$fiber=implode(" ",$row);
$Quantity=$_POST['Quantity'];
$MealType=$_POST['Meal_Type'];
$Size=$_POST['Size'];


$sql1="INSERT INTO `calorietracker`(`Meal_Name`, `caloriesconsumed`, `time`, `carbs`, `fiber`, `protein`, `fat`, `MealType`, `Quantity`, `Size`, `clientID`) VALUES ('$MealName','$caloriesconsumed','$time','$carbs','$fiber','$protein','$fats','$MealType','$Quantity','$Size','$clientID')";

if (mysqli_query($conn,$sql1)) {
          echo "success";
}
else{
          echo "failed";
}
?>