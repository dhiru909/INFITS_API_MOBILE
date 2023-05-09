<?php
require "connect.php";
// Create connection
$conn = new mysqli($server, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['clientID'];

// $name = $_POST['name'];

$date = $_POST['date'];

$time = $_POST['time'];

// $meal = $_POST['timeMeal'];

$description = $_POST['description'];

// $image = $_POST['image'];
// $image = 'img';
// $postion = $_POST['position'];

$jsonArray = $_POST['jsonArray'];

$data = json_decode($jsonArray, true);
$res = "true";

foreach ($data as $entry) {
  $name = $entry['mealName'];
  $calorieValue = $entry['calorieValue'];
  $image = $entry['image'];
  $meal = $entry['Meal_Type'];
  $carbsValue = $entry['carbsValue'];
  $fatValue = $entry['fatValue'];
  $proteinValue = $entry['proteinValue'];

  // echo $name;
  
  // insert the entry into your database
  $sql="select fibre from food_info WHERE name='$name'";
  $result=mysqli_query($conn,$sql);

  $row =mysqli_fetch_assoc($result);

  $fiberValue=implode(" ",$row);

  $imagePath = "upload/mealTracker/$name"."$date"."$time".".jpg";


  $sql = "INSERT INTO `mealtracker` (`name`, `description`, `image`, `date`, `time`, `meal`, `clientID`, `position`, `Calories`, `carbs`, `fiber`, `protein`, `fat`)
   VALUES ('$name', '$description', '$imagePath', '$date', '$time', '$meal', '$username', '$postion', '$calorieValue', '$carbsValue', '$fiberValue', '$proteinValue', '$fatValue');";
   if (mysqli_query($conn,$sql)) {
    file_put_contents("upload/mealTracker/$name"."$date"."$time".".jpg",base64_decode($image));
}
else{
  $res = "false";
  break;
}

  // ...
}

// if($res)  echo 'updated';
echo "$res";

// $username = "Azar";

// $name = 'Dosa';

// $date = '22-09-2022';

// $time = '11-54 pm';

// $meal = 'Breakfast';

// $description = 'With Ghee';

// $image = 'image';


// echo $meal;

// $sql = "insert into mealtracker value('$name','$description','$name$date$time','$date','$time','$meal','$username',$postion);";

// if (mysqli_query($conn,$sql)) {
//     echo 'updated';
//     file_put_contents("upload/mealTracker/$name"."$date"."$time".".jpg",base64_decode($image));
// }

// echo $jsonArray;

?>
