<?php

function getArr($from,$to,$clientID){
$server="127.0.0.1:3307";
$username="root";
$password="";
$database = "infits"; 

$conn=mysqli_connect($server,$username,$password,$database);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "select cast(date as time),cast(date as date),maximum from heartrate where clientID='$clientID' AND cast(date as date) between '$from' and '$to' AND cast(date as time) IN (
    SELECT MAX(cast(date as time)) 
    FROM heartrate
        
    GROUP BY DATE(cast(date as date))
    );";

    $result = mysqli_query($conn, $sql) or die("Error in Selecting " . mysqli_error($connection));
    
        $emparray = array();
        $mon = array();
        while($row =mysqli_fetch_assoc($result))
        {
            $emparray['date'] = date('d',strtotime($row['cast(date as date)']));
            $a = json_decode($row['maximum']);
            $average = array_sum($a)/count($a);
            $emparray['avg'] = $average;
            $full[] = $emparray;
            $mon[] = $average;
        }
        
        $sig = 0;
        for ($i=0; $i < count($mon) ; $i++) { 
            $sig = $sig + $mon[$i];
        }
        if(count($mon) != 0){
            return $sig/count($mon);
        }
        else {
            return 0;
        }
}

$mons = ['jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec'];

for ($i=0; $i <12 ; $i++) { 
    $from[] = date('Y-m-d',strtotime("first day of $mons[$i]"));
    $to[] = date('Y-m-d',strtotime("last day of $mons[$i]"));
}



// $from = array("2022-01-01","2022-02-01","2022-03-01","2022-04-01","2022-05-01","2022-06-01","2022-07-01","2022-08-01","2022-09-01","2022-10-01","2022-11-01","2022-12-01");
// $to = array("2022-01-31","2022-02-28","2022-03-31","2022-04-30","2022-05-31","2022-06-30","2022-07-31","2022-08-30","2022-09-31","2022-10-30","2022-11-31","2022-12-30");
$clientID = $_POST['userID'];
// $clientID = "Azarudeen";
    $avgArr = array();
    for ($i=0; $i < 12 ; $i++) { 
        $avgArr['av'] = getArr($from[$i],$to[$i],$clientID);
        $avgJson[] = $avgArr;
    }
    echo json_encode(['heart'=>$avgJson]);
?>
