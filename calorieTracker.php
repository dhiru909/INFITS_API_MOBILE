<?php

$server="127.0.0.1:3306";
$username="root";
$password="";
$database = "infits";

$conn=mysqli_connect($server,$username,$password,$database);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

date_default_timezone_set("Asia/Calcutta");
$today = date('Y-m-d');
$from1 = date('Y-m-d', strtotime('-0 days', strtotime($today)));

$date = date('Y-m-d H:i:s');
$from = date('Y-m-d 00:00:00', strtotime('-0 days', strtotime($date)));

$clientuserID = $_POST['clientID'];
// $clientuserID = 'test';


$sql = "select sum(caloriesconsumed),sum(carbs),sum(fiber),sum(protein),sum(fat) from calorietracker where clientID = '$clientuserID' and time between '$from' and '$date'";

$sql1 = "select * from goals_client where clientuserID = '$clientuserID'";

$sql2 = "select sum(calorie_burnt) from calories_burnt where client_id = '$clientuserID' and date between '$from1' and '$today'";

$result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($connection));

$result1 = mysqli_query($conn, $sql1) or die("Error in Selecting " . mysqli_error($connection));

$result2 = mysqli_query($conn, $sql2) or die("Error in Selecting " . mysqli_error($connection));

$empArray1 = array();
$responseArray = array();
while($row =mysqli_fetch_assoc($result1))
{
          $empArray1['CarbsGoal'] = $row['Carbs'];
          $empArray1['fatsGoal'] = $row['fats'];
          $empArray1['ProteinGoal'] = $row['Protein'];
          $empArray1['FiberGoal'] = $row['Fiber'];   
}
$responseArray["Goals"]=$empArray1;

$calorieBurnt=mysqli_fetch_assoc($result2);
$responseArray["CalorieBurnt"]=$calorieBurnt['sum(calorie_burnt)'];
// echo implode("",$calorieBurnt);

$emparray = array();

$full=array();
while($row =mysqli_fetch_assoc($result))
{
          if($row['sum(caloriesconsumed)']==null){
                    $emparray['caloriesconsumed'] = "0";
          }
          else{
                    $emparray['caloriesconsumed'] = $row['sum(caloriesconsumed)'];
          }



          if($row['sum(caloriesconsumed)']==null){
                    $emparray['caloriesconsumed'] = "0";
          }
          else{
                    $emparray['caloriesconsumed'] = $row['sum(caloriesconsumed)'];
          }



          if($row['sum(carbs)']==null){
                    $emparray['carbs'] = "0";
          }
          else{
                    $emparray['carbs'] = $row['sum(carbs)'];
          }


          if($row['sum(fiber)']==null){
                    $emparray['fiber'] = "0";
          }
          else{
                    $emparray['fiber'] = $row['sum(fiber)'];
          }

          
          if($row['sum(protein)']==null){
                    $emparray['protein'] = "0";
          }
          else{
                    $emparray['protein'] = $row['sum(protein)'];
          }


          if($row['sum(fat)']==null){
                    $emparray['fat'] = "0";
          }
          else{
                    $emparray['fat'] = $row['sum(fat)'];
          }
}
$responseArray["Values"]=$emparray;
echo json_encode(['Data' => $responseArray]);
?>