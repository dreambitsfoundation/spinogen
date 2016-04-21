<?php

$server="localhost";
$user="root";
$password="";
$db="users";
$batch=$_GET['batch'];
$domicile=$_GET['domicile'];
$course=$_GET['course'];
$output="";
$connection=new mysqli($server,$user,$password,$db);
if($connection->connect_errno){
    die();
}
$sql="SELECT tution_fee,bus_fare1,bus_fare2,mess_fee,hostel_charge FROM student_statistic WHERE course='".$course."' AND batch='".$batch."' AND domicile='".$domicile."'";
$result=$connection->query($sql);
$row=$result->num_rows;
echo "Number of Rows:".$row;
if($row<0){
    echo "Nothing Found";
}else{
    while($row=$result->fetch_assoc()){
        $output["tution_fee"]=$row["tution_fee"];
        $output["mess_fee"]=$row["mess_fee"];
        $output["hostel_charge"]=$row["hostel_charge"];
        $output["busfare1"]=$row["bus_fare1"];
        $output["busfare2"]=$row["bus_fare2"];
    }
}
$connection->close();
echo json_encode($output);