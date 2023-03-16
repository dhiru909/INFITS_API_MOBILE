<?php
// Database connection details
$server = "127.0.0.1:3307";
$username = "root";
$password = "";
$database = "infits";

// Create connection
$conn = mysqli_connect($server, $username, $password, $database);

// Check for errors
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get appointment details from form
$event_name = $_POST["event_name"];
$add_dietitian = $_POST["add_dietitian"];
$appointment_time = $_POST["appointment_time"];
$description = $_POST["description"];
$attachment = $_POST["attachment"];
$select_schedule = $_POST["select_schedule"];
$timing_slots = $_POST["timing_slots"];
$appointment_type = $_POST["appointment_type"];
$file_type = $_POST["file_type"];
$file_name = $_POST["file_name"];


// Save the file to disk

 // Otherwise, insert appointment into database
  $sql = "INSERT INTO appointment_booking (event_name, add_dietitian, description, attachment, select_schedule, timing_slots, appointment_type, appointment_time, file_type) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
 $stmt->bind_param("sssssssss", $event_name, $add_dietitian, $description, $file_name, $select_schedule, $timing_slots, $appointment_type, $appointment_time, $file_type);
  $stmt->execute();

  // Check for errors
  if ($stmt->errno) {
    $response = array("status" => "error", "message" => $stmt->error);
  } else {
    // If successful, return confirmation message
    if(file_put_contents("upload/Appointments/$file_name".".jpg",base64_decode($attachment))){
      $response = array("status" => "success");
    }
    else {
      echo "failure";
    }
  }
echo json_encode($response);

// Close connection
$stmt->close();
$conn->close();
?>

