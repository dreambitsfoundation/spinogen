<?php
$id=$_POST['id'];
$purpose=$_POST['purpose'];
$amount=$_POST['amount'];
$process=$_POST['medium'];
$operator=$_POST['operator'];
$number=$_POST['process_number'];
$dop=$_POST['dop'];
$bank=$_POST['bank'];
$mess_month=$_POST['messmonth'];
$server="localhost";
$user="root";
$password="";
$db="users";
$date=getdate();
$dmonth=$date['month'];
$dyear=$date['year'];
global $name;
global $domicile;
global $programme;
switch($dmonth){
    case "January":
        $payment_init="Jan".$dyear;
        $semester_update=0;
        break;
    case "February":
        $payment_init="Jan".$dyear;
        $semester_update=0;
        break;
    case "March":
        $payment_init="Jan".$dyear;
        $semester_update=0;
        break;
    case "April":
        $payment_init="Jan".$dyear;
        $semester_update=0;
        break;
    case "May":
        $payment_init="Jan".$dyear;
        $semester_update=0;
        break;
    case "June":
        $payment_init="Aug".$dyear;
        $semester_update=1;
        break;
    case "July":
        $payment_init="Aug".$dyear;
        $semester_update=1;
        break;
    case "August":
        $payment_init="Aug".$dyear;
        $semester_update=1;
        break;
    case "September":
        $payment_init="Aug".$dyear;
        $semester_update=1;
        break;
    case "October":
        $payment_init="Aug".$dyear;
        $semester_update=1;
        break;
    case "November":
        $payment_init="Aug".$dyear;
        $semester_update=1;
        break;
    case "December":
        $payment_init="Aug".$dyear;
        $semester_update=1;
        break;
}

//INITIALIZING TRANSACTION

//CREATING CONNECTION
$connection=new mysqli($server,$user,$password,$db);
if($connection->connect_error){
    $output["report"]=0;
    echo json_encode($output);
    die();
}

// STUDENT QUERY
$query="SELECT * FROM student WHERE id='".$id."'";
$result2=$connection->query($query);
while($row2=$result2->fetch_assoc()){
    $name=$row2["name"];
    $domicile=$row2["domicile"];
    $batch=$row2["batch"];
    $semester=$row2["sem"];
    $course_span=$row2["course_span"];
    $programme=$row2["course"];

}
//COLLECTING INDIVIDUAL NUMBER, BANK, AMOUNT, DATE OF PAYMENT
$num_info=explode(";",$number);
$count_number=count($num_info);
$bank_info=explode(";",$bank);
$count_bank=count($bank_info);
$dop_info=explode(";",$dop);
$count_dop=count($dop_info);
$amount_info=explode(";",$amount);
$count_amount=count($amount_info);

//Creating Reason For Payment
global $reason;
switch($purpose){
    case "tution_fee":
        $reason="Tution Fee";
        break;
    case "hostel_fee":
        $reason="Hostel Fee";
        break;
    case "bus_fare":
        $reason="Bus Fare";
        break;
    case "mess_fee":
        $reason="Mess Charge";
        break;
}

//Selecting Last Row Id
global $new_id;
$test_query="SELECT * FROM transactions";
    $response_back=$connection->query($test_query);
    $last_id=$response_back->num_rows;
    $new_id=$last_id;


        $new_id+=1;
        if($new_id<10){
            $t_id="00".$new_id;
        }elseif($new_id<100){
            $t_id="0".$new_id;
        }
        $transaction_id="IUT/Accts/M.R/".$t_id;
        $tquery="INSERT INTO transactions (id,Name,payment_init,particular,payment_mode,paying_bank,amount,dop,t_id,Programme,operator,number) VALUES ('".$id."','".$name."','".$payment_init."','Demand Draft','".$bank_info[0]."','".$amount_info[0]."','".$dop_info[0]."','".$transaction_id."','".$operator."')";
        $connection->query($tquery);         
    


//$output["report"]=1;//transaction successful
echo json_encode($output);
?>