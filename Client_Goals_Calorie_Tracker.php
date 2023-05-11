<?php
$server = "127.0.0.1:3306";
$username = "root";
$password = "";
$database = "infits";
$conn = mysqli_connect($server, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$clientuserID = $_POST['clientID'];
$dietitianuserID=$_POST['dietitianuserID'];
$calorieConsumed=$_POST['calorieConsumed'];
$calorieBurnt=$_POST['calorieBurnt'];
$carbs=$_POST['carbs'];
$fats=$_POST['fats'];
$protein=$_POST['protein'];
$fiber=$_POST['fiber'];
$operationToDo=$_POST['operationToDo'];

// echo $dietitianuserID;

// $clientuserID = 'test';
// $dietitianuserID='test123';
// $carbs=15;
// $calorieConsumed=55;
// $calorieBurnt=55;
// $fats=55;
// $protein=25;
// $fiber=35;
// $operationToDo="get";
if($operationToDo=="add"){
          Add_Goals($clientuserID,$dietitianuserID,$calorieConsumed,$calorieBurnt,$carbs,$fats,$protein,$fiber,$conn);
}
else if($operationToDo=="get"){
    Get_Goals($clientuserID,$conn);

}
else{
    UpdateData($clientuserID,$dietitianuserID,$calorieConsumed,$calorieBurnt,$carbs,$fats,$protein,$fiber,$conn);

}
function Add_Goals($clientuserID,$dietitianuserID,$calorieConsumed,$calorieBurnt,$carbs,$fats,$protein,$fiber,$conn){
          $sql="INSERT INTO `goals_client`(`clientuserID`, `dietitianuserID`,`calorieConsumed`, `calorieBurnt`, `carbs`, `fats`, `protein`, `fiber`) VALUES ('$clientuserID','$dietitianuserID','$calorieConsumed','$calorieBurnt','$carbs','$fats','$protein','$fiber')";
          if (mysqli_query($conn,$sql)) {
                    echo "Add success";
          }
          else{
                    echo "Add failed";
          }
}
function Get_Goals($clientuserID,$conn){
          $sql = "select * from goals_client where clientuserID = '$clientuserID'";
          $result=mysqli_query($conn,$sql);
          $empArray = array();
        //   $msgArray=array();
          $responseArray = array();
          while($row =mysqli_fetch_assoc($result))
          {
              $empArray['clientuserID'] = $row['clientuserID'];
              $empArray['dietitianuserID'] = $row['dietitianuserID'];
              $empArray['calorieConsumed']=$row['calorieConsumed'];
              $empArray['calorieBurnt']=$row['calorieBurnt'];
              $empArray['Carbs'] = $row['Carbs'];
              $empArray['fats'] = $row['fats'];
              $empArray['Protein'] = $row['Protein'];
              $empArray['Fiber'] = $row['Fiber'];
              
          }
          if(empty($empArray)){
                    $responseArray['message']="values does exist";     
                    // $responseArray['values']=$empArray;
                    echo json_encode(['Goals' => $responseArray]); 
          }
          else{
                    $responseArray['message']="values  exist";   
                    // $responseArray['message']=$msgArray;  
                    $responseArray['values']=$empArray;
                    echo json_encode(['Goals' => $responseArray]);
          }          
}
function UpdateData($clientuserID,$dietitianuserID,$calorieConsumed,$calorieBurnt,$carbs,$fats,$protein,$fiber,$conn){
          $sql="UPDATE `goals_client` SET 
          `calorieConsumed`='$calorieConsumed',`calorieBurnt`='$calorieBurnt',
          `Carbs`='$carbs',`fats`='$fats',`Protein`='$protein',`Fiber`='$fiber' 
          WHERE clientuserID = '$clientuserID'";
          if (mysqli_query($conn,$sql)) {
                    echo "Update success";
          }
          else{
                    echo "Update failed";
          }
}
?>