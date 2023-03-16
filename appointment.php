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
$attachment = $_POST["attachment"]; // assuming the attachment is a file upload
$select_schedule = $_POST["select_schedule"];
$morning_slots = $_POST["morning_slots"];
$evening_slots = $_POST["evening_slots"];
$appointment_type = $_POST["appointment_type"];

// Validate input fields (e.g., check if required fields are empty)

// Check for conflicts
$sql = "SELECT * FROM appointment_booking WHERE add_dietitian = ? AND appointment_time = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $add_dietitian, $appointment_time);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  // If there is a conflict, return error message
  echo "Error: Appointment time slot is already booked!";
} else {

// Otherwise, upload attachment and insert appointment into database
  $attachment = "";
  if (!empty($_FILES["attachment"]["name"])) {
    // If an attachment was uploaded, move it to a permanent location and get its filename
    $target_dir = "attachments/";
    $target_file = $target_dir . basename($_FILES["attachment"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["attachment"]["tmp_name"]);
    if($check !== false) {
      $uploadOk = 1;
    } else {
      echo "Error: File is not an image.";
      $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["attachment"]["size"] > 5000000) {
      echo "Error: File is too large.";
      $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      echo "Error: Only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }

    if ($uploadOk == 0) {
      echo "Error: File was not uploaded.";
    } else {
      if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $target_file)) {
        $attachment = basename($_FILES["attachment"]["name"]);
      } else {
        echo "Error: There was an error uploading the file.";
      }
    }
  }
  // Otherwise, insert appointment into database
  $sql = "INSERT INTO appointment_booking (event_name, add_dietitian, description, attachment, select_schedule, morning_slots, evening_slots, appointment_type, appointment_time) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
 $stmt->bind_param("sssssssss", $event_name, $add_dietitian, $description, $attachment, $select_schedule, $morning_slots, $evening_slots, $appointment_type, $appointment_time);
  $stmt->execute();

  // Check for errors
  if ($stmt->errno) {
    echo "Error: " . $stmt->error;
  } else {
    // If successful, return confirmation message
    echo "Appointment booked successfully!";
  }
}

// Close connection
$stmt->close();
$conn->close();
?>

