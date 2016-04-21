<?php
    
if(!isset($_GET['user'])){
    header('Refresh:3; url=index.html');
    echo "Sorry! Please Login First";
}
    //$name=$_GET['user'];
    //$priviledge=$_GET['priv'];
    //$urlstring="";
    $server="localhost";
  $user="root";
  $pass="";
  $database="users";
    $eid=$_GET['eid'];
    $connect=new mysqli($server,$user,$pass,$database);
    if($connect->connect_error){
        $urlstring="index.html";
        header('Refresh:5;url="'.$urlstring.'"');
        die();        
    }
    $sql="SELECT name,priviledge FROM user WHERE e_id='".$eid."'";
    $result=$connect->query($sql);
    $row=$result->num_rows;
    if($row<=0){
        $urlstring="index.html";
        $condition=0;
        header('Refresh:5;url="'.$urlstring.'"');
        
    }else{
        while($row=$result->fetch_assoc()){
        $urlstring="dashboard.php?e_id=".$eid."&priv=".$row['priviledge']."&name=".$row['name']."&cpass=1"; 
        header('Refresh:5;url="'.$urlstring.'"');   
        }
    }
    //$urlstring="dashboard.php?e_id=".$row['e_id']."&priv=".$row['priviledge']."&name=".$row['name']."&cpass=1"; 
               
    //header('Refresh:10; url="'.$urlstring.'"');
    

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>
    </head>
    <body>
        <h1 style="font-family: arial;text-align: center; font-size:80px;">Spinogen</h1>
        <center>This is a critical system. Please do not attemp to play with the website processing.<br>This may land you into serious trouble.<br>All your activities are tracked.</center>
         
    </body>
</html>
