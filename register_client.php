<?php
$server="127.0.0.1:3307";
$username="root";
$password="";
$database = "infits";
// Create connection
$conn=mysqli_connect($server,$username,$password,$database);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$user_password = $_POST['password']; // rename this variable
$userID = $_POST['userID'];
$name = $_POST['name'];
$mobile = $_POST['phone'];
$age = $_POST['age'];
$height = $_POST['height'];
$weight = $_POST['weight'];
$verification = $_POST['verification'];
$profilePhoto = file_get_contents("/opt/lampp/htdocs/profile/default/profile.png");
$profilePhoto = base64_encode($profilePhoto);

/*
$data = json_decode(file_get_contents('php://input'), true);

$email = $data['email'];
$password = $data['password'];
$userID = $data['userID'];
$name = $data['name'];
$mobile = $data['phone'];
$age = $data['age'];
$height = $data['height'];
$weight = $data['weight'];
$verification = $data['verification'];
$profilePhoto = file_get_contents("/opt/lampp/htdocs/profile/default/profile.png");
$profilePhoto = base64_encode($profilePhoto);
*/


echo $profilePhoto;

if (!empty($userID)) {
    $file_path = "/opt/lampp/htdocs/profile/".$userID.".png";
    if (!file_put_contents($file_path, base64_decode($profilePhoto))) {
        echo "Failed to save profile photo";
        print_r(error_get_last());
    } else {
        echo "Profile photo saved successfully";
    }
    echo "\n" . $file_path;

    $sql = "insert into client (clientuserID, password, name, email, mobile, profilePhoto, age, verification, height, weight) VALUES ('$userID','$password','$name','$email','$mobile','$file_path','$age','$verification','$height','$weight');";
    try {
        if($conn->query($sql)){
            echo "success";
        }
    } catch (mysqli_sql_exception $th) {
        echo "UserName already taken";
    }
} else {
    echo "User ID is empty";
}
?>

