<?php

require "connect.php";


$today = date('Y-m-d');

$from = date('Y-m-d', strtotime('-8 days', strtotime($today)));

$to = date('Y-m-d', strtotime('1 days', strtotime($today)));


// $clientID = $_POST['clientID'];

$clientID = 'Azarudeen';

$sql = "select steps,dateandtime from steptracker where clientID = '$clientID' and dateandtime between '$from' and '$to';";

$result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($connection));

    $emparray = array();
    while($row =mysqli_fetch_assoc($result))
    {
      $emparray['date'] = date("d-m-Y",strtotime($row['dateandtime']));
      $emparray['steps'] = $row['steps'];
      $full[] = $emparray;
    }
    echo json_encode(['steps' => $full]);
?>
