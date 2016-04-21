<?php
  session_start();
  if(isset($_SESSION['spineuser'])){
      session_unset();
  }
  
  $id=$_POST["employer_id"];
  $password=$_POST["password"];
  
  $server="localhost";
  $user="root";
  $pass="";
  $database="users";

  //Connection
  $connect=new mysqli($server,$user,$pass,$database);
  
  //Connection Check
  if($connect->connect_error){
      echo("Fail");
      die();
  }else{
      
      $sql="SELECT name,priviledge FROM user WHERE e_id='".$id."' AND e_pass='".$password."'";
      $result=$connect->query($sql);
      $row=$result->num_rows;
      if($row<=0){
          $return["report"]=0;
          $return["name"]="nil";
          $return["e_id"]="nil";
          $return["privilegde"]="nil";
      }else{
          while($row=$result->fetch_assoc()){
          //$_SESSION['spineuser']=$row["name"];
          $return["report"]=1;
          $return["name"]=$row["name"];
          $return["e_id"]=$id;
          $return["priviledge"]=$row["priviledge"];
          }
      }

      $connect->close();
      echo json_encode($return);
      /*if($return["report"]==1){
          global $url="controller.php?user=".$return["name"]."&eid=".$id."&priv=".$return["priviledge"];
      }else{
          global $url="index.html";
      }
      header('Refresh:2;url="'.$url.'"');*/
  }
?>



