<?php
$id=$_POST["s_id"];
$server="localhost";
$user="root";
$password="";
$db="users";
$connection=new mysqli($server,$user,$password,$db);
if($connection->connect_error){
    die();
}
$sql1="SELECT name,batch,faculty,branch,year,sem,course_span,father,mother,state,course,domicile FROM student WHERE id='".$id."'";
//$sql2="SELECT tution_fee,hostel_charge,mess_fee,bus_fare1,bus_fare2 FROM student_statistic WHERE batch='".$output["batch"]."',course='".$output["course"]."' AND domicile='".$output["domicile"]."'";
$result=$connection->query($sql1);

//echo $result;
$row=$result->num_rows;
//echo "Number of Rows: ".$row;
if($row<=0){
    $output["valid"]=0;
    $output["name"]='nil';
    $output["course"]='nil';
}else{
    while($row=$result->fetch_assoc()){
        $output["valid"]=1;
        $output["name"]=$row["name"];
        $output["batch"]=$row["batch"];
        $foreign_key=$row["batch"];
        $output["faculty"]=$row["faculty"];
        $output["branch"]=$row["branch"];
        $output["year"]=$row["year"];
        $output["sem"]=$row["sem"];
        $output["course_span"]=$row["course_span"];
        $output["father"]=$row["father"];
        $output["mother"]=$row["mother"];
        $output["course"]=$row["course"];
        $course=$row["course"];
        $output["state"]=$row["state"];
        $output["domicile"]=$row["domicile"];
        $domicile=$row["domicile"];
        $sql2="SELECT tution_fee,bus_fare1,bus_fare2,mess_fee,hostel_charge FROM student_statistic WHERE course='".$course."' AND batch='".$foreign_key."' AND domicile='".$domicile."'";
        $result2=$connection->query($sql2);
        $row2=$result2->num_rows;
        //echo "Number of Rows:".$row;
        if($row2<0){
            //echo "Nothing Found";
        }else{
            while($row2=$result2->fetch_assoc()){
                $output["tution_fee"]=$row2["tution_fee"];
                $output["mess_fee"]=$row2["mess_fee"];
                $output["hostel_charge"]=$row2["hostel_charge"];
                $output["busfare1"]=$row2["bus_fare1"];
                $output["busfare2"]=$row2["bus_fare2"];
            }
        }
    }

}
$connection->close();
echo json_encode($output);
?>

