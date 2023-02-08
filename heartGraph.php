<?php
function date_compare($a, $b)
{
    $t1 = $a['date'];
    $t2 = $b['date'];
    return $t1 - $t2;
}

require "connect.php";

$conn=mysqli_connect($server,$username,$password,$database);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


$clientID = $_POST['clientuserID'];

// $clientID = 'Azarudeen';

$from = date('Y-m-d', strtotime("-6 day"));

$to = date('Y-m-d');

$end = date('Y-m-d',strtotime("1 day"));


$sql = "select cast(date as time),cast(date as date),maximum from heartrate where clientID='$clientID' AND cast(date as date) between '$from' and '$to' AND cast(date as time) IN (
  SELECT MAX(cast(date as time)) 
  FROM heartrate
      
  GROUP BY DATE(cast(date as date))
  );";

$full = array();

$dateArr = array();

$dateArray = array();

$result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($connection));

    $emparray = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $emparray['date'] = date('d',strtotime($row['cast(date as date)']));
        $a = json_decode($row['maximum']);
        $average = array_sum($a)/count($a);
        $emparray['avg'] = $average;
        $dateArray[] = date('d',strtotime($row['cast(date as date)']));
        $full[] = $emparray;
    }
    // echo json_encode(['heart' => $full]);

    $missingDates = array();

    $dateStart = date_create($from);
    $dateEnd   = date_create($end);

    $interval  = new DateInterval('P1D');
    $period    = new DatePeriod($dateStart, $interval, $dateEnd);

    foreach($period as $day) {
      $formatted = $day->format("d");
      // echo gettype($formatted);
      if(!in_array($formatted, $dateArray)) {
        $missingDates['date'] = $formatted;
        $missingDates['avg'] = '0';
        $full[] = $missingDates;
    }}

    usort($full, 'date_compare');

    echo json_encode(['heart' => $full]);
?>
