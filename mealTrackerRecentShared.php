<?php 
require "connect.php";
// Create connection
$conn = new mysqli($server, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['clientID'];
$date = $_POST['date'];

$sql = "SELECT * FROM mealtracker WHERE date = '$date' AND clientID like '$username'";
$result = $conn->query($sql);

// Check if any rows were found
if ($result->num_rows > 0) {
    // Create an array to hold the results
    $resultsArray = array();
    
    // Loop through each row and add it to the array
    while($row = $result->fetch_assoc()) {
        $resultsArray[] = $row;
    }
    
    // Encode the array as JSON and output it
    echo json_encode($resultsArray);
} else {
    echo "0 results";
}

?>