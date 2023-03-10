<?php

require "connect.php";

$conn=mysqli_connect($server,$username,$password,$database);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// $clientID = $_POST['clientID'];

$clientID = "Azarudeen";

$sql = "select cast(date as time),cast(date as date),value from heartrate where clientID='$clientID' AND cast(date as date) = '2022-12-28'";

$full = NULL;


$result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($connection));

    $emparray = array();
    $value = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $emparray['date'] = $row['cast(date as date)'];
        $emparray['value'] = $row['value'];
        $emparray['time'] = date('H:i',strtotime($row['cast(date as time)']));
        $full[] = $emparray;
    }
    echo json_encode(['heart' => $full]);
?>