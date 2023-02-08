<?php

$server = "127.0.0.1:3306";
$username = "root";
$password = "";
$database = "infits";

$conn = mysqli_connect($server, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$clientID = $_POST['clientID'];
$referralCode = $_POST['referralCode'];
$activeUsers = $_POST['activeUsers'];

if($activeUsers != "none") {
    // update already existing record
    $sql = "select * from referral_table where referralCode = '$referralCode'";

    $result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($conn));

    $row = mysqli_fetch_assoc($result);
    $newActiveUsers;

    if($row['activeUsers'] == 'none') {
        $newActiveUsers = $activeUsers;
    } else {
        $newActiveUsers = $row['activeUsers'].", ".$activeUsers;
    }

    $sql = "update referral_table set activeUsers = '$newActiveUsers' where referralCode = '$referralCode'";

    $result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($conn));

    if ($result) {
        echo "updated";
    } else {
        echo "failed";
    }
} else {
    // add a new entry
    $sql = "insert into referral_table values('$clientID', '$referralCode', '$activeUsers')";

    $result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($conn));

    if ($result) {
        echo "inserted";
    }
}

?>
