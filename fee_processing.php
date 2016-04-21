<?php
/**
 * Created by PhpStorm.
 * User: Gaurav
 * Date: 29-12-2015
 * Time: 10:16
 */
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
global $semester;
global $semester_update;
global $year_update;
global $domicile;
global $batch;
global $programme;
global $tution_fee;
global $hostel_charge;
global $mess_fee;
global $cheque_number;
global $cheque_bank;
global $draft_number;
global $draft_bank;
global $bus_fare;
global $messmonth;
global $cheque_bank_update;
global $cheque_number_update;
global $draft_bank_update;
global $draft_number_update;
global $course_span;
global $name;
global $total_amount;
global $new_id;
global $payment_init;
//global $output;
$dmonth=$date['month'];
$dyear=$date['year'];
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
$connection=new mysqli($server,$user,$password,$db);
if($connection->connect_error){
    $output["report"]=0;
    echo json_encode($output);
    die();
}

// STUDENT QUERY
$query="SELECT * FROM student WHERE id='".$id."'";
$result2=$connection->query($query);
//$row2=$result->num_rows;
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
$total_amount=0;
//echo $amount_info;
foreach($amount_info as $data){
    $total_amount+=$data;
}
//echo $total_amount;
$a=2;
//echo "Amount Info".$amount_info[$a];
//CHECKING DATA FOR NUMBER OF INPUTS

//CREATING SEMESTER UPDATE VARIABLE
$semester_update=(($dyear-$batch)*2)+$semester_update;
$year_update=$dyear-$batch;
//echo "Semester Latest: ".$semester_update;
//echo "\nDyear: ".$dyear." Batch: ".$batch." Semester Update: ".$semester_update;

$sql="SELECT * FROM fee_log WHERE id='".$id."' AND payment_init='".$payment_init."'";
$result=$connection->query($sql);
$row=$result->num_rows;
if($row<=0){
    $test_query="SELECT * FROM transactions";
    $response_back=$connection->query($test_query);
    $last_id=$response_back->num_rows;
    $new_id=$last_id;
    //echo "Last ID: ".$new_id;

    switch($purpose){
        case "tution_fee":
            $connection->begin_transaction();
            if($payment_init=="Aug2015" && $year_update<$course_span){
                $connection->query("INSERT INTO fee_log (id,domicile,batch,sem,payment_init,tution_fee,draft_no,draft_bank) VALUES ('".$id."','".$domicile."','".$batch."','".$semester_update."','".$payment_init."','".$total_amount."','".$number."','".$bank."')");
                $connection->query("UPDATE student SET sem='".$semester_update."',year='".$year_update."' WHERE id='".$id."'");
                $connection->query("INSERT INTO transactions (payment_init,particular,paying_bank,amount,dop,t_id) VALUES ('Jan2016','Draft','State Bank Of India','6000','10/1/2016','IUT/ACCTS/MR/0001')");
                //Creating Transaction Information Entry
                
            }else{
                $connection->query("INSERT INTO fee_log (id,domicile,batch,sem,payment_init,tution_fee,draft_no,draft_bank) VALUES ('".$id."','".$domicile."','".$batch."','".$semester_update."','".$payment_init."','".$total_amount."','".$number."','".$bank."')");
                $connection->query("UPDATE student SET sem='".$semester_update."' WHERE id='".$id."'");
                $connection->query("INSERT INTO transactions (payment_init,particular,paying_bank,amount,dop,t_id) VALUES ('Jan2016','Draft','State Bank Of India','6000','10/1/2016','IUT/ACCTS/MR/0001')");
                
            }
            if($connection->commit()===TRUE){
                for($x=0;$x<3;$x++){
                    if($bank_info[$x]!=""){
                        $new_id+=1;
                    if($new_id<10){
                        $t_id="00".$new_id;
                    }elseif($new_id<100){
                        $t_id="0".$new_id;
                    }
                    $transaction_id="IUT/Accts/M.R/".$t_id;
                    $sql3="INSERT INTO transactions (id,Name,payment_init,particular,payment_mode,paying_bank,amount,dop,t_id,Programme,operator,number) VALUES ('".$id."','".$name."','".$payment_init."','Demand Draft','".$bank_info[$x]."','".$amount_info[$x]."','".$dop_info[$x]."','".$transaction_id."','".$operator."')";
                        if($connection->query($sql3)===TRUE){
                           // echo "Transaction Updated";
                        }
                    }                    
                }
                $output["report"]=1;
                echo json_encode($output);
            }else{
                $connection->rollback();
                $output["report"]=2;//transaction failed
                echo json_encode($output);
                //echo "Error: ".$connection->error;
            }
            break;
        case "hostel_fee":
            $connection->begin_transaction();
            $connection->query("INSERT INTO fee_log (id,domicile,batch,sem,payment_init,hostel_charge,draft_no,draft_bank) VALUES ('".$id."','".$domicile."','".$batch."','".$semester."','".$payment_init."','".$amount."','".$number."','".$bank."')");
            for($x=0;$x<=$count_amount-1;$x++){
                $new_id+=1;
                if($new_id<10){
                    $t_id="00".$new_id;
                }elseif($new_id<100){
                    $t_id="0".$new_id;
                }
                $transaction_id="IUT/Accts/M.R/".$t_id;
                $connection->query("INSERT INTO transactions (id,Name,payment_init,particular,payment_mode,paying_bank,amount,dop,t_id,Programme,operator,number) VALUES ('".$id."','".$name."','".$payment_init."','Hostel Fee','Demand Draft','".$bank_info[$x]."','".$amount_info[$x]."','".$dop_info[$x]."','".$transaction_id."','".$operator."','".$num_info[$x]."')");
            }
            if($connection->commit()===TRUE){
                $output["report"]=1;//transaction successful
            }else{
                $connection->rollback();
                $output["report"]=2;//transaction failed
                //echo "Error:".$connection->error;
            }
            break;
        case "bus_fare":
            if($process==1){ //Draft
                $connection->begin_transaction();
                $connection->query("INSERT INTO fee_log (id,domicile,batch,sem,payment_init,bus_fare,draft_no,draft_bank) VALUES ('".$id."','".$domicile."','".$batch."','".$semester."','".$payment_init."','".$amount."','".$number."','".$bank."')");
                //for($x=0;$x<=$count_amount-1;$x++){
                    $new_id+=1;
                    if($new_id<10){
                        $t_id="00".$new_id;
                    }elseif($new_id<100){
                        $t_id="0".$new_id;
                    }
                    $transaction_id="IUT/Accts/M.R/".$t_id;
                    $connection->query("INSERT INTO transactions (id,Name,payment_init,particular,payment_mode,paying_bank,amount,dop,t_id,Programme,operator,number) VALUES ('".$id."','".$name."','".$payment_init."','Bus Fare','Demand Draft','".$bank."','".$amount."','".$dop."','".$transaction_id."','".$operator."','".$number."')");
                //}
                if($connection->commit()===TRUE){
                    $output["report"]=1;//transaction successful
                    echo json_encode($output);
                }else{
                    $connection->rollback();
                    $output["report"]=2;//transaction failed
                    echo json_encode($output);
                    //echo "Error:".$connection->error;
                }
                break;
            }elseif($process==2){// Cheque
                $connection->begin_transaction();
                $connection->query("INSERT INTO fee_log (id,domicile,batch,sem,payment_init,bus_fare,cheque_no,cheque_bank) VALUES ('".$id."','".$domicile."','".$batch."','".$semester."','".$payment_init."','".$amount."','".$number."','".$bank."')");
                //for($x=0;$x<=$count_amount-1;$x++){
                    $new_id+=1;
                    if($new_id<10){
                        $t_id="00".$new_id;
                    }elseif($new_id<100){
                        $t_id="0".$new_id;
                    }
                    $transaction_id="IUT/Accts/M.R/".$t_id;
                    $connection->query("INSERT INTO transactions (id,Name,payment_init,particular,payment_mode,paying_bank,amount,dop,t_id,Programme,operator,number) VALUES ('".$id."','".$name."','".$payment_init."','Bus Fare','Cheque','".$bank."','".$amount."','".$dop."','".$transaction_id."','".$operator."','".$number."')");
                //}
                if($connection->commit()===TRUE){
                    $output["report"]=1;//transaction successful
                    echo json_encode($output);
                }else{
                    $connection->rollback();
                    $output["report"]=2;//transaction failed
                    echo json_encode($output);
                    //echo "Error:".$connection->error;
                }
                break;
            }
            break;
        case "mess_fee":
            $connection->begin_transaction();
            $connection->query("INSERT INTO fee_log (id,domicile,batch,sem,payment_init,mess_fee,mess_month) VALUES ('".$id."','".$domicile."','".$batch."','".$semester."','".$payment_init."','".$amount."','".$mess_month."')");
            //for($x=0;$x<=$count_amount-1;$x++){
                $new_id+=1;
                if($new_id<10){
                    $t_id="00".$new_id;
                }elseif($new_id<100){
                    $t_id="0".$new_id;
                }
                $transaction_id="IUT/Accts/M.R/".$t_id;
                $connection->query("INSERT INTO transactions (id,Name,payment_init,particular,payment_mode,amount,t_id,Programme,operator,number) VALUES ('".$id."','".$name."','".$payment_init."','Cash','".$amount."','".$transaction_id."','".$programme."','".$operator."')");
            //}
            if($connection->commit()===TRUE){
                $output["report"]=1;//transaction successful
                echo json_encode($output);
            }else{
                $connection->rollback();
                $output["report"]=2;//transaction failed
                echo json_encode($output);
                //echo "Error:".$connection->error;
            }
            break;
    }
}else{
    while($row=$result->fetch_assoc()){
        $tution_fee=$row["tution_fee"];
        $mess_fee=$row["mess_fee"];
        $hostel_charge=$row["hostel_charge"];
        $bus_fare=$row["bus_fare"];
        $cheque_number=$row["cheque_no"];
        $cheque_bank=$row["cheque_bank"];
        $draft_number=$row["draft_no"];
        $draft_bank=$row["draft_bank"];
        $messmonth=$row["mess_month"];
    }
    $sql2="SELECT * FROM student WHERE id='".$id."'";
    $result2=$connection->query($sql2);
    $row2=$result2->num_rows;
    while($row2=$result2->fetch_assoc()){
        $semester=$row2["sem"];
    }

    $test_query="SELECT * FROM transactions";
    $response_back=$connection->query($test_query);
    $last_id=$response_back->num_rows;
    $new_id=$last_id;
    //echo "Last ID: ".$new_id;
    //echo "Draft Number: ".$draft_number;
    //echo "Draft Bank: ".$draft_bank;
    $draft_number_update=$draft_number.";".$number;
    $draft_bank_update=$draft_bank.";".$bank;
    //echo "Updated Draft Number: ".$draft_number_update;
    //echo "Updated Draft Bank: ".$draft_bank_update;
    switch($purpose){
        case "tution_fee":
            $total_amount+=$tution_fee;
            $connection->begin_transaction();
            if($payment_init=="Aug2015" && $year_update<$course_span){
                $connection->query("UPDATE fee_log SET tution_fee='".$total_amount."',sem='".$semester_update."',draft_no='".$draft_number_update."',draft_bank='".$draft_bank_update."' WHERE id='".$id."' AND payment_init='".$payment_init."'");
                $connection->query("UPDATE student SET sem='".$semester_update."',year='".$year_update."' WHERE id='".$id."'");
                /*$x=0;
                foreach($amount_info as $data){
                    $new_id+=1;
                    if($new_id<10){
                        $t_id="00".$new_id;
                    }elseif($new_id<100){
                        $t_id="0".$new_id;
                    }
                    $transaction_id="IUT/Accts/M.R/".$t_id;
                    $connection->query("INSERT INTO transactions (id,Name,payment_init,particular,payment_mode,paying_bank,amount,dop,t_id,Programme,operator,number) VALUES ('".$id."','".$name."','".$payment_init."','Tuition Fee','Demand Draft','".$bank_info[$x]."','".$data[$x]."','".$dop_info[$x]."','".$transaction_id."','".$operator."')");
                    $x+=1;
                }*/
                for($x=0;$x<=$count_amount-1;$x++){
                    $new_id+=1;
                    if($new_id<10){
                        $t_id="00".$new_id;
                    }elseif($new_id<100){
                        $t_id="0".$new_id;
                    }
                    $transaction_id="IUT/Accts/M.R/".$t_id;
                    $connection->query("INSERT INTO transactions (id,Name,payment_init,particular,payment_mode,paying_bank,amount,dop,t_id,Programme,operator,number) VALUES ('".$id."','".$name."','".$payment_init."','Demand Draft','".$bank_info[$x]."','".$amount_info[$x]."','".$dop_info[$x]."','".$transaction_id."','".$operator."')");
                }
            }else{
                $connection->query("UPDATE fee_log SET tution_fee='".$total_amount."',sem='".$semester_update."',draft_no='".$draft_number_update."',draft_bank='".$draft_bank_update."' WHERE id='".$id."' AND payment_init='".$payment_init."'");
                $connection->query("UPDATE student SET sem='".$semester_update."' WHERE id='".$id."'");
                /*for($x=0;$x<=$count_amount-1;$x++){
                    $new_id+=1;
                    if($new_id<10){
                        $t_id="00".$new_id;
                    }elseif($new_id<100){
                        $t_id="0".$new_id;
                    }
                    $transaction_id="IUT/Accts/M.R/".$t_id;
                    $connection->query("INSERT INTO transactions (id,Name,payment_init,particular,payment_mode,paying_bank,amount,dop,t_id,Programme,operator,number) VALUES ('".$id."','".$name."','".$payment_init."','Tuition Fee','Demand Draft','".$bank_info[$x]."','".$amount_info[$x]."','".$dop_info[$x]."','".$transaction_id."','".$operator."')");
                }*/
            }
            if($connection->commit()===TRUE){
                for($x=0;$x<=$count_amount-1;$x++){
                    $new_id+=1;
                    if($new_id<10){
                        $t_id="00".$new_id;
                    }elseif($new_id<100){
                        $t_id="0".$new_id;
                    }
                    $transaction_id="IUT/Accts/M.R/".$t_id;
                    //echo $transaction_id;
                    //echo "Amount ".$x.":".$amount_info[$x];
                    //echo "Bank ".$x.":".$bank_info[$x];
                    //echo "DOP ".$x.":".$dop_info[$x];
                    $connection->begin_transaction();
                    $connection->query("INSERT INTO transactions (id,Name,payment_init,particular,payment_mode,paying_bank,amount,dop,t_id,Programme,operator,number) VALUES ('".$id."','".$name."','".$payment_init."','Demand Draft','".$bank_info[$x]."','".$amount_info[$x]."','".$dop_info[$x]."','".$transaction_id."','".$operator."')");
                    $connection->commit();
                }
                $output["report"]=1;//transaction successful
                echo json_encode($output);
            }else{
                $connection->rollback();
                $output["report"]=2;//transaction failed
                echo json_encode($output);
            }
            break;
        case "hostel_fee":
            $total_amount+=$hostel_charge;
            $connection->begin_transaction();
            $connection->query("UPDATE fee_log SET hostel_charge='".$total_amount."',draft_no='".$draft_number_update."',draft_bank='".$draft_bank_update."' WHERE id='".$id."' AND payment_init='".$payment_init."'");
            for($x=0;$x<=$count_amount-1;$x++){
                $new_id+=1;
                if($new_id<10){
                    $t_id="00".$new_id;
                }elseif($new_id<100){
                    $t_id="0".$new_id;
                }
                $transaction_id="IUT/Accts/M.R/".$t_id;
                $connection->query("INSERT INTO transactions (id,Name,payment_init,particular,payment_mode,paying_bank,amount,dop,t_id,Programme,operator,number) VALUES ('".$id."','".$name."','".$payment_init."','Hostel Fee','Demand Draft','".$bank_info[$x]."','".$amount_info[$x]."','".$dop_info[$x]."','".$transaction_id."','".$operator."')");
            }
            if($connection->commit()===TRUE){
                $output["report"]=1;//transaction successful
                echo json_encode($output);
            }else{
                $connection->rollback();
                $output["report"]=2;//transaction failed
                echo json_encode($output);
            }
            break;
        case "mess_fee":
            $total_amount+=$mess_fee;
            $mess_month_update=$messmonth.";".$mess_month;
            $connection->begin_transaction();
            $connection->query("UPDATE fee_log SET mess_fee='".$amount."',mess_month='".$mess_month_update."' WHERE id='".$id."' AND payment_init='".$payment_init."'");
                $new_id+=1;
                if($new_id<10){
                    $t_id="00".$new_id;
                }elseif($new_id<100){
                    $t_id="0".$new_id;
                }
                $transaction_id="IUT/Accts/M.R/".$t_id;
                $connection->query("INSERT INTO transactions (id,Name,payment_init,particular,payment_mode,amount,t_id,Programme,operator) VALUES ('".$id."','".$name."','".$payment_init."','Mess Charge','Cash','".$amount."','".$transaction_id."','".$programme."','".$operator."')");

            if($connection->commit()===TRUE){
                $output["report"]=1;//transaction successful
                echo json_encode($output);
            }else{
                $connection->rollback();
                $output["report"]=2;//transaction failed
                echo json_encode($output);
            }
            break;
        case "bus_fare":
            $total_amount+=$bus_fare;
            $cheque_number_update=$cheque_number.";".$number;
            $cheque_bank_update=$cheque_bank.";".$bank;
            switch($process){
                case 1:
                    $connection->begin_transaction();
                    $connection->query("UPDATE fee_log SET bus_fare='".$amount."',draft_no='".$draft_number_update."',draft_bank='".$draft_bank_update."' WHERE id='".$id."' AND payment_init='".$payment_init."'");
                    //for($x=0;$x<=$count_amount-1;$x++){
                        
                    //}
                    if($connection->commit()===TRUE){
                        $new_id+=1;
                        if($new_id<10){
                            $t_id="00".$new_id;
                        }elseif($new_id<100){
                            $t_id="0".$new_id;
                        }
                        $transaction_id="IUT/Accts/M.R/".$t_id;
                        $connection->query("INSERT INTO transactions (id,Name,payment_init,particular,payment_mode,paying_bank,amount,dop,t_id,Programme,operator,number) VALUES ('".$id."','".$name."','".$payment_init."','Bus Fare','Demand Draft','".$bank_info[$x]."','".$amount_info[$x]."','".$dop_info[$x]."','".$transaction_id."','".$operator."','".$number."')");
                        $output["report"]=1;//transaction successful
                        echo json_encode($output);
                    }else{
                        $connection->rollback();
                        $output["report"]=2;//transaction failed
                        echo json_encode($output);
                    }
                    break;
                case 2:
                    $connection->begin_transaction();
                    $connection->query("UPDATE fee_log SET bus_fare='".$amount."',cheque_no='".$cheque_number_update."',cheque_bank='".$cheque_bank_update."' WHERE id='".$id."' AND payment_init='".$payment_init."'");
                    //for($x=0;$x<=$count_amount-1;$x++){
                        $new_id+=1;
                        if($new_id<10){
                            $t_id="00".$new_id;
                        }elseif($new_id<100){
                            $t_id="0".$new_id;
                        }
                        $transaction_id="IUT/Accts/M.R/".$t_id;
                        $connection->query("INSERT INTO transactions (id,Name,payment_init,particular,payment_mode,paying_bank,amount,dop,t_id,Programme,operator,number) VALUES ('".$id."','".$name."','".$payment_init."','Bus Fare','Cheque','".$bank_info[$x]."','".$amount_info[$x]."','".$dop_info[$x]."','".$transaction_id."','".$operator."','".$num_info[$x]."')");
                    //}
                    if($connection->commit()===TRUE){
                        $output["report"]=1;//transaction successful
                        echo json_encode($output);
                    }else{
                        $connection->rollback();
                        $output["report"]=2;//transaction failed
                        echo json_encode($output);
                    }
                    break;
            }
    }

}
$connection->close();
//echo json_encode($output);
