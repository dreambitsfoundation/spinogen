<?php
$sem=$_POST['sem'];
$source=$_POST['source'];
global $output;
global $result;
global $rows;
global $counter;
$counter=0;
process($sem,$source);
function process($semester,$medium){
	$connection=new mysqli("localhost","root","","users");
	switch($medium){
		case "Draft":
		    $sql="SELECT * FROM fee_log WHERE payment_init='".$semester."'";
		    $result=$connection->query($sql);
		    $rows=$result->num_rows;
		    if($rows<1){
		    	$output["report"]=0;
		    	echo '<!DOCTYPE html><html><head></head><body><center><br><br><h1>Spinogen</h1><br><br>Sorry No Such Record Exist!</center></body></html>';
		    }else{
		    	$output["report"]=1;
                echo "<html>";
                echo "<head><style>";
                echo "table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
            text-align: center;
        }</style></head>";
                echo "<body>";
                echo '<div style="border:1px solid black; border-radius: 8px; width:1100px;  text-align: center">
                
                <br>
    <img src="/spine_images/icfailogo.png" style="height: 50px;width:55px;"><br><strong>The ICFAI University,Tripura <br> Kamalghat, Mohanpur, West Tripura - 799210 <br> Website: www.iutripura.edu.in</strong>
    <br>
    <hr>
    <strong>Account Statement</strong>
    <hr>
    <br>
    <b><u>Demand Draft Details</u></b><br>
    <br>
    <b>Name of Bank: </b>
    <br>
    <b>Account Name:</b> The ICFAI University, Tripura - Fee Collection A/C
    <br>
    <b>Account Number: </b>
    <br>
    <b>Deposit Date: </b>
    <br>
    <b>Programme: </b>
    <br><br>
    <table style="width:100%">
        <tr>
            <th>Sl. No.</th>
            <th>ID</th>      
            <th>DD No.</th>
            <th>DD Date</th>
            <th>DD Bank</th>
        </tr>';
        while($rows=$result->fetch_assoc()){
            
            foreach($rows as $data){
                $ddno=$data['draft_no'];
                $temp_ddno=explode(";",$ddno);
                $numbers=count($temp_ddno);
                $temp_ddbank=explode(";",$data['draft_bank']);
                for($x=0;$x<$numbers;$x++){
                    if($temp_ddno[$x]!=""){
                        $counter+=1;
                        echo "<tr>";
                        echo "<td>".$data['id']."</td>";
                        echo '<td>'.$counter.'</td>';
                        echo '<td>'.$temp_ddno[$x].'</td>';
                        echo '<td>'.$temp_ddbank[$x].'</td>';
                        echo "</tr>";
                    }
                }
            }
        }
            echo '<table><br>
    <hr>
    *This is a computer generated Accounts Statement Information need not to be signed.<br>
    *The generation of this document is controlled by The ICFAI University, Tripura<br>
    <br>
    <strong style="">By Order, <br>Department of Accounts,<br>The ICFAI University, Tripura</strong></div></body><html>';
		    }	
		    
	}
}
?>