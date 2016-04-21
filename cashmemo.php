<?php
/**
 * Created by PhpStorm.
 * User: Gaurav
 * Date: 03-01-2016
 * Time: 13:26
 */
$id=$_POST['id'];
global $payment_init;
global $name;
global $faculty;
global $program;
global $semester;
global $domicile_state;
$date=getdate();
$dday=$date['mday'];
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

$server="localhost";
$user="root";
$password="";
$db="users";
$connection=new mysqli($server,$user,$password,$db);
if($connection->connect_error){
    die();
}
$sql2="SELECT * FROM student WHERE id='".$id."'";
$result2=$connection->query($sql2);
$row2=$result2->num_rows;
if($row2<=0){
    $output["report"]=0;
    echo '<html><head><style>body{text-align:center;} h1{font-family:arial;font-size: 80px;}</style></head><body><h1>Spine</h1><br><br><strong>Sorry No Such Student Entry Was Found.<br>Please Check And Re-Enter</strong></body><br><br><br></html>';
}else{
    while($row2=$result2->fetch_assoc()){
        $name=$row2["name"];
        $faculty=$row2["faculty"];
        $semester=$row2["sem"];
        $program=$row2["course"];
        $domicile_state=$row2["state"];
    }
    $output["report"]=1;
    $sql="SELECT * FROM fee_log WHERE id='".$id."' AND payment_init='".$payment_init."'";
    $result=$connection->query($sql);
    $row=$result->num_rows;
    if($row<=0){
        $output["data"]=0;
        echo '<html><head><style>body{text-align:center;} h1{font-family:arial;font-size: 80px;}</style></head><body><h1>Spine</h1><br><br><strong>Sorry! This Student Have Not Paid Any Fee For The Current Semester Yet!</strong></body><br><br><br></html>';
    }else{
        $output["data"]=1;
        echo json_encode($output);
        while($row=$result->fetch_assoc()){
            $sum=$row["tution_fee"]+$row["bus_fare"]+$row["hostel_charge"]+$row["mess_fee"];
            echo "<html>";
            echo '<head onload="window.print()">';
            echo '<style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
            text-align: center;
        }
        table{
            width:100%;
        }
        #footer{
            text-align:center;
            font-size: 10px;
        }
    </style>
    </head>
<body>
<div style="border:1px solid black; border-radius: 8px; width:500px; height:600px; text-align: center">
    <br>
    <img src="/spine_images/icfailogo.png" style="height: 50px;width:55px;"><br><strong>The ICFAI University,Tripura <br> Kamalghat, Mohanpur, West Tripura - 799210 <br> Website: www.iutripura.edu.in</strong>
    <hr>
    <strong>Money Receipt</strong>
    <hr>';
            echo "Date:<b>".$dday."/".$dmonth."/".$dyear."</b><br>";
            echo "Name:<b>".$name."</b>&nbsp;&nbsp;ID No.:<b>".$id."</b>&nbsp;&nbsp;Program:<b>".$program."</b><br>";
            echo "Faculty:<b>".$faculty."</b>&nbsp;&nbsp;Semester:<b>".$semester."</b>&nbsp;&nbsp;Domicile State:<b>".$domicile_state."</b><br><br>";
            echo "<table>";
            echo '<tr>
            <th>Sl.No.</th>
            <th>Particular</th>
            <th colspan="2">Paid Amount</th>
        </tr>
        <tr>
            <td>1</td>
            <td>Tution Fee</td>
            <td>'.$row["tution_fee"].'</td>
            <td>00</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Bus Fare</td>
            <td>'.$row["bus_fare"].'</td>
            <td>00</td>
        </tr>
        <tr>
            <td>3</td>
            <td>Hostel Charge</td>
            <td>'.$row["hostel_charge"].'</td>
            <td>00</td>
        </tr>
        <tr>
            <td>4</td>
            <td>Mess Charge</td>
            <td>'.$row["mess_fee"].'</td>
            <td>00</td>
        </tr>
        <tr>
            <td colspan="2"><b>Total</b></td>
            <td>'.$sum.'</td>
            <td>00</td>
        </tr>
    </table>
    <br>
    <hr>
    *This is a computer generated cash memo need not to be signed.<br>
    *The cash memo for the current semester with the most recent date of print should be considered as a valid financial document.<br>
    <br>';
            echo '<strong style="float:right">By Order, <br>Department of Accounts,<br>The ICFAI University, Tripura</strong>';
            echo '</div><div id="footer"><br><span style="text-align:center">Data processed by IUDMS-ICFAI University Data Management System (SPINE)<br>&copy; Gourab Saha. All Rights Reserved.</span></div>
</body>
</html>';
    }
    }

}
$connection->close();
echo json_encode($output);


