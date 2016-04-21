<?php
$id=$_POST['id'];
$name=$_POST['name'];
$batch=$_POST['batch'];
$mother=$_POST['mother'];
$father=$_POST['father'];
$state=$_POST['state'];
$faculty=$_POST['faculty'];
$program=$_POST['program'];
$branch=$_POST['branch'];
$year=$_POST['year'];
$span=$_POST['span'];
$semester=$_POST['semester'];
$board=$_POST['board'];
$status=$_POST['status'];
$domicile=$_POST['domicile'];
$host="localhost";
$user="root";
$password="";
$db="users";
global $output;
$connection=new mysqli($host,$user,$password,$db);
$sql2="SELECT * FROM student WHERE id='".$id."'";
$result=$connection->query($sql2);
$rows=$result->num_rows;
if($rows>0){
	$output["report"]="2";
}else{
$sql="INSERT INTO student (id,name,batch,faculty,branch,year,sem,course_span,father,mother,state,course,joining,boarder_type,status,domicile,primarykey) VALUES('".$id."','".$name."','".$joining."','".$faculty."','".$branch."','".$year."','".$semester."','".$span."','".$father."','".$mother."','".$state."','".$program."','".$batch."','".$board."','".$status."','".$domicile."',1)";
if($connection->query($sql)===TRUE){
	$output["report"]=1;
}else{
	$output["report"]=0;
}
}
echo json_encode($output);

?>