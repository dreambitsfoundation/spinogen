<?php
    $server="localhost";
    $user="root";
    $pass="";
    $database="users";
$connection=new mysqli($server,$user,$pass,$database);
if($connection->connect_error){
    echo "Fail";
    die();
}else{
    
}
?>
