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
$attachment = $_FILES["attachment"]; 
$select_schedule = $_POST["select_schedule"];
$timing_slots = $_POST["timing_slots"];
$appointment_type = $_POST["appointment_type"];
$file_type = $_POST["file_type"];
$file_name = $_POST["file_name"];


// Save the file to disk
$path_filename_ext = '';
if ($_FILES['attachment']['error'] !== UPLOAD_ERR_OK) {
        // handle error
    switch ($_FILES['attachment']['error']) {
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            echo 'File size is too large.';
            break;
        case UPLOAD_ERR_PARTIAL:
            echo 'File upload was not completed.';
            break;
        case UPLOAD_ERR_NO_FILE:
            echo 'No file was selected for upload.';
            break;
        case UPLOAD_ERR_NO_TMP_DIR:
        case UPLOAD_ERR_CANT_WRITE:
        case UPLOAD_ERR_EXTENSION:
            echo 'File could not be uploaded due to a server error.';
            break;
        default:
            echo 'Unknown error occurred during file upload.';
    }
} else {
    $target_dir = "upload/";
    $file_name = $_FILES['attachment']['name'];
    $file_type = pathinfo($file_name, PATHINFO_EXTENSION);
    $path_info = pathinfo($file_name);
    $path_filename_ext = $target_dir . $path_info['filename'] . '.' . $file_type;
    if (move_uploaded_file($_FILES['attachment']['tmp_name'], $path_filename_ext)) {
        echo "File saved to: " . $path_filename_ext;
    } else {
        echo "File could not be saved to disk.";
    }
}


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
    $response = array("status" => "success");
  }
echo json_encode($response);

// Close connection
$stmt->close();
$conn->close();
?>

