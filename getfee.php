<?php
$batch=$_POST["batch"];
$server="localhost";
$user="root";
$password="";
$db="users";
$connection=new mysqli($server,$user,$password,$db);
$sql="SELECT tution_fee,mess_fee,hostel_charge,bus_fare1 ";

?>

