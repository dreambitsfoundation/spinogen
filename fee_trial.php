<?php
/**
 * Created by PhpStorm.
 * User: Gaurav
 * Date: 29-12-2015
 * Time: 10:24
 */
$purpose=$_POST['purpose'];
$id=$_POST['id'];
$batch=$_POST['batch'];
$course=$_POST['course'];
$domicile=$_POST['domicile'];
$purpose_fee=$_POST['purpose_fee'];
$output="";
$sql="";
$server="localhost";
$user="root";
$password="";
$db="users";
$date=getdate();
$dmonth=$date['month'];
$dyear=$date['year'];
//$payment_init="";
switch($dmonth){
    case "January":
        $payment_init="Jan".$dyear;
        break;
    case "February":
        $payment_init="Jan".$dyear;
        break;
    case "March":
        $payment_init="Jan".$dyear;
        break;
    case "April":
        $payment_init="Jan".$dyear;
        break;
    case "May":
        $payment_init="Jan".$dyear;
        break;
    case "June":
        $payment_init="Aug".$dyear;
        break;
    case "July":
        $payment_init="Aug".$dyear;
        break;
    case "August":
        $payment_init="Aug".$dyear;
        break;
    case "September":
        $payment_init="Aug".$dyear;
        break;
    case "October":
        $payment_init="Aug".$dyear;
        break;
    case "November":
        $payment_init="Aug".$dyear;
        break;
    case "December":
        $payment_init="Aug".$dyear;
        break;
}

$connection=new mysqli($server,$user,$password,$db);
if($connection->connect_error){
    die();
}
switch($purpose){
    case "tution_fee":
        $sql="SELECT tution_fee FROM fee_log WHERE id='".$id."' AND payment_init='".$payment_init."'";
        $result=$connection->query($sql);
        $row=$result->num_rows;
        if($row<=0){
            $output["report"]=1;
        }else{
            while($row=$result->fetch_assoc()){
                $temp1=$row["tution_fee"];
                if($temp1>=$purpose_fee){
                    $output["report"]=0;
                }else{
                    $output["report"]=1;
                }
    }
        }
        break;
    case "mess_fee":
        $sql="SELECT mess_fee FROM fee_log WHERE id='".$id."' AND payment_init='".$payment_init."'";
        $result=$connection->query($sql);
        $row=$result->num_rows;
        if($row<=0){
            $output["report"]=1;
        }else{
            while($row=$result->fetch_assoc()){
                $temp1=$row["mess_fee"];
                if($temp1>=$purpose_fee){
                    $output["report"]=0;
                }else{
                    $output["report"]=1;
                }
            }
        }
        break;
    case "hostel_charge":
        $sql="SELECT hostel_charge FROM fee_log WHERE id='".$id."' AND payment_init='".$payment_init."'";
        $result=$connection->query($sql);
        $row=$result->num_rows;
        if($row<=0){
            $output["report"]=1;
        }else{
            while($row=$result->fetch_assoc()){
                $temp1=$row["hostel_charge"];
                if($temp1>=$purpose_fee){
                    $output["report"]=0;
                }else{
                    $output["report"]=1;
                }
            }
        }
        break;
    case "bus_fare":
        $sql="SELECT bus_fare FROM fee_log WHERE id='".$id."' AND payment_init='".$payment_init."'";
        $result=$connection->query($sql);
        $row=$result->num_rows;
        if($row<=0){
            $output["report"]=1;
        }else{
            while($row=$result->fetch_assoc()){
                $temp1=$row["bus_fare"];
                if($temp1>=$purpose_fee){
                    $output["report"]=0;
                }else{
                    $output["report"]=1;
                }
            }
        }
        break;
    default:
        $output["report"]=0;
}
$connection->close();
echo json_encode($output);
?>
