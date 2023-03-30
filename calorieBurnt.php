<?php 
    // Database connection details
    $server = "127.0.0.1:3306";
    $username = "root";
    $password = "";
    $database = "infits";

    // Create connection
    $conn = mysqli_connect($server, $username, $password, $database);

    $result = array();

    // Check for errors
    if ($conn->connect_error) {
        $result['error'] = "true";
        $result['message'] =  $conn->connect_error;
    die("Connection failed: " . $conn->connect_error);
    }

    // if(isset($_POST['dietitianID']))

    // $dieticianID = $_POST['dieticianID'];

    $clientID = $_POST['clientID'];

    $date = $_POST['date'];

    // $activity_name = $_POST['activity_name'];

    // $calorie_burnt = $_POST['calorie_burnt'];

    // $duration = $_POST['duration'];

    // $stmt = $conn->prepare("INSERT INTO `calories_burnt` (`client_id`, `dietician_id`, `activity_name`, `calorie_burnt`,`duration`, `date`, `time`)
    //              VALUES (?, ?, ?, ?, ?, curdate(), curtime());");
    // $stmt->bind_param("sssss",$clientID,$dieticianID,$activity_name,$calorie_burnt,$duration);

    // if($_POST['for'] == "day")
    //     $stmnt = $conn -> prepare("SELECT * FROM `calories_burnt` WHERE `client_id` LIKE ? AND `date` = ?");
    // else if($_POST['for'] == "week")
    //     $stmnt = $conn -> prepare("SELECT * FROM calories_burnt WHERE date BETWEEN DATE_SUB(curdate(), INTERVAL 1 WEEK) AND curdate() ORDER BY `calories_burnt`.`date` DESC");
    // $stmnt->bind_param("ss",$clientID,$date);

    switch ($_POST['for']) {
    case 'day':
        $stmnt = $conn->prepare("SELECT * FROM `calories_burnt` WHERE `client_id` LIKE ? AND `date` = ?");
        $stmnt->bind_param("ss",$clientID,$date);
        break;
    case 'week':
        $stmnt = $conn->prepare("SELECT * FROM `calories_burnt` WHERE `client_id` LIKE ? AND `date` BETWEEN DATE_SUB(curdate(), INTERVAL 1 WEEK) AND curdate() ORDER BY `calories_burnt`.`date` DESC");
        $stmnt->bind_param("s",$clientID);
        break;
    case 'year':
        $stmnt = $conn->prepare("SELECT *
        FROM `calories_burnt`
        WHERE `client_id` LIKE ? 
          AND `date` BETWEEN DATE_SUB(curdate(), INTERVAL 1 WEEK) AND curdate() 
          AND YEAR(`date`) = YEAR(CURDATE())
        ORDER BY `date` DESC
        ");
        $stmnt->bind_param("s",$clientID);
        break;
    default:
        $result['error'] = "true";
        $result['message'] =  "for Values not provided";
        break;
}

    // $stmnt->execute();

    if($stmnt->execute()){
        // echo "success";
        $result['error'] = "false";
        $result['message'] =  "Values entered sucessfully";
        $row = $stmnt->get_result();

// Loop through all rows in the result set and print the data
    while ($temp = $row->fetch_assoc()) {
            $result[] = $temp;
        }
        echo json_encode($result);
    }
    else{
        $result['error'] = "true";
        $result['message'] =  "Values not entered";
        echo json_encode($result);
    }


    
  
?>