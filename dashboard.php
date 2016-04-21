<?php
    //session_start();
/*if(!isset($_SESSION['spineuser'])){
    header('Refresh:3; url=index.html');
    echo "session not found  ".$_SESSION['spineuser'];
    exit();
}else{
    $name=$_SESSION['spineuser'];
    //Database Connection
    $connection=new sqli("localhost","root","","users");
    //Connection Check
    if($connection->connect_error){
        die("System went into error");
    }else{
        $sql="SELECT designation,priviledge,e_id FROM user WHERE name='".$name."'";
        $result=$connection->query($sql);
        while($output=$result->fetch_assoc){
            $priviledge=$output["priviledge"];
            $designation=$output["designation"];
            $id=$output["e_id"];
        }
    }
}*/
 $name=$_GET['name'];
 $priv=$_GET['priv'];
 $eid=$_GET['e_id'];
if(!isset($_GET['cpass'])){
    header('Refresh:2;url=index.html');
    echo "Login First";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="/processor.js"></script>
        <!--Jquery Library-->
        <script type="text/javascript" src="/jquery-1.11.3.min.js"></script>
        <!--Bootstrap Stylesheet-->
        <link rel="stylesheet" href="/bootstrap.min.css" media="screen">
        <!--Bootstrap Library-->
        <script type="text/javascript" src="/bootstrap.min.js"></script>
        <!--<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

        <!-- jQuery library -->
        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->

        <!-- Latest compiled JavaScript -->
        <!--<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>-->
        <script>
            function startTime() {
                var today = new Date();
                var day = "";
                switch (new Date().getDay()) {
    case 0:
        day = "Sunday";
        break;
    case 1:
        day = "Monday";
        break;
    case 2:
        day = "Tuesday";
        break;
    case 3:
        day = "Wednesday";
        break;
    case 4:
        day = "Thursday";
        break;
    case 5:
        day = "Friday";
        break;
    case 6:
        day = "Saturday";
        break;
}
                var date = today.getDate();
                var month = today.getMonth();
                var show_month
                if(month==12){
                   show_month=1;
                }else{
                   show_month=month+1;
                }
                var year = today.getFullYear();
                if(month==12){
                    year=year+1;
                }
                var h = today.getHours();
                var m = today.getMinutes();
                var s = today.getSeconds();
                m = checkTime(m);
                s = checkTime(s);
                document.getElementById('dashfooter').innerHTML = "Today is: " + day + ", " + date + "/" + show_month + "/" + year + "  " + h + ":" + m + ":" + s;
                var t = setTimeout(startTime, 500);
            }
            function checkTime(i) {
                if (i < 10) { i = "0" + i };  // add zero in front of numbers < 10
                return i;
            }
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                var location=window.location.search;
                //alert(location);
                var index1=location.search("&name");
                var index2=location.search("&cpass");
                index1+=6;
                var operator=location.slice(index1,index2);
                //alert(operator);
                var id="";
                var result="";
                var i;
                var batch="";
                var course="";
                var tution_fee="";
                var mess_charge="";
                var hostle_charge="";
                var bus_fare="";
                var domicile="";
                var result2="";
                var medium=0;
                var messmonth=0;
                var temp1 = $("#tution_fee").html();
                var temp2 = $("#mess_fee").html();
                var temp3 = $("#hostel_charge").html();
                var temp4 = $("#bus_fee").html();
                $("#feefooter").hide();
                $("#tutionfee").hide();
                $("#messcharge").hide();
                $("#busfare").hide();
                $("#hostelcharge").hide();
                $("#modal-close").click(function(){
                    $("#feefooter").hide();
                    $("#tutionfee").hide();
                    $("#messcharge").hide();
                    $("#busfare").hide();
                    $("#hostelcharge").hide();
                    $("#feenotice").show();
                    $("#student_board_view").html('Select Student Board <span class="caret"></span>');
                });
                $("#s_id_processor").click(function () {
                    i = $("#s_id").val().toUpperCase(); ;
                    if (i == "") {
                        alert("Please Insert A Valid Data");
                        $("#s_id").focus();
                    } else {
                        id = $("#s_id").val().toUpperCase();
                        var data = "s_id=" + id;
                        var url = "validate_student.php";
                        $.post(url, data, function (data) {
                            //alert(data);
                            result = JSON.parse(data);
                            if (result["valid"] == 0) {
                                alert("Sorry! No such record found.\n Please check and re-enter");
                                $("#s_id").focus();
                            } else {
                                //alert(data);
                                $("#name").html(result["name"]);
                                $("#faculty").html(result["faculty"]);
                                $("#course").html(result["course"]);
                                course=result["course"];
                                $("#branch").html(result["branch"]);
                                $("#batch").html(result["batch"]);
                                batch=result["batch"];
                                $("#year").html(result["year"]);
                                $("#mother_name").html(result["mother"]);
                                $("#father_name").html(result["father"]);
                                $("#sem").html(result["sem"]);
                                $("#state").html(result["state"]);
                                $("#enrollment").html(id);
                                $("#course_duration").html(result["course_span"]);
                                $("#tution_fee").html(parseInt(result["tution_fee"]));
                                tution_fee=result["tution_fee"];
                                $("#mess_fee").html(parseInt(result["mess_fee"]));
                                mess_charge=result["mess_fee"];
                                $("#hostel_charge").html(parseInt(result["hostel_charge"]));
                                hostle_charge=result["hostel_charge"];
                                if ((parseInt(result["sem"] + 1) / 2) == 0) {
                                    $("#bus_fee").html(parseInt(result["busfare1"]));
                                    bus_fare=result["busfare1"];
                                } else {
                                    $("#bus_fee").html(parseInt(result["busfare2"]));
                                    bus_fare=result["busfare2"];
                                }
                                domicile=result["domicile"];
                                $("#student_reg").modal('show');
                            }
                        });
                    }
                });

                $("#student_type1").click(function () {
                    var student_type = $(this).html();
                    $("#student_board_view").html(student_type + ' <span class="caret"></span>');
                    /*var temp1 = $("#tution_fee").html();
                     var temp2 = $("#mess_fee").html();
                     var temp3 = $("#hostel_charge").html();
                     var temp4 = $("#bus_fee").html();
                     $("#tution_fee").html('<ins>'+temp1+'</ins>');
                     $("#mess_fee").html('<ins>'+temp2+'</ins>');
                     $("#hostel_charge").html('<ins>'+temp3+'</ins>');
                     $("#bus_fee").html('<del>'+temp4+'</del>');*/
                    //$("#student_reg").css('height',"800px");
                    $("#feenotice").hide();
                    $("#busfare").hide();
                    $("#tutionfee").fadeIn();
                    $("#messcharge").fadeIn();
                    $("#hostelcharge").fadeIn();
                    $("#feefooter").fadeIn();

                });
                $("#student_type2").click(function () {
                    var student_type = $(this).html();
                    $("#student_board_view").html(student_type + ' <span class="caret"></span>');
                    //alert(student_type);
                    /*$("#tution_fee").html('<ins>'+temp1+'</ins>');
                     $("#mess_fee").html('<del>'+temp2+'</del>');
                     $("#hostel_charge").html('<del>'+temp3+'</del>');
                     $("#bus_fee").html('<ins>'+temp4+'</ins>');*/
                    $("#feenotice").hide();
                    $("#hostelcharge").hide();
                    $("#messcharge").hide();
                    $("#busfare").fadeIn();
                    $("#tutionfee").fadeIn();
                    $("#feefooter").fadeIn();
                });
                $("#january").click(function() {
                    $("#month_selector").html('January <span class="caret"></span>');
                    messmonth="January";
                });
                $("#february").click(function() {
                    $("#month_selector").html('February <span class="caret"></span>');
                    messmonth="February";
                });
                $("#march").click(function() {
                    $("#month_selector").html('March <span class="caret"></span>');
                    messmonth="March";
                });
                $("#april").click(function() {
                    $("#month_selector").html('April <span class="caret"></span>');
                    messmonth="April";
                });
                $("#may").click(function() {
                    $("#month_selector").html('May <span class="caret"></span>');
                    messmonth="May";
                });
                $("#june").click(function() {
                    $("#month_selector").html('June <span class="caret"></span>');
                    messmonth="June";
                });
                $("#july").click(function() {
                    $("#month_selector").html('July <span class="caret"></span>');
                    messmonth="July";
                });
                $("#august").click(function() {
                    $("#month_selector").html('August <span class="caret"></span>');
                    messmonth="August";
                });
                $("#september").click(function() {
                    $("#month_selector").html('September <span class="caret"></span>');
                    messmonth="September";
                });
                $("#october").click(function() {
                    $("#month_selector").html('October <span class="caret"></span>');
                    messmonth="October";
                });
                $("#november").click(function() {
                    $("#month_selector").html('November <span class="caret"></span>');
                    messmonth="November";
                });
                $("#december").click(function() {
                    $("#month_selector").html('December <span class="caret"></span>');
                    messmonth="December";
                });
                $("#previous_due").click(function() {
                    $("#month_selector").html('Previous Due <span class="caret"></span>');
                    messmonth="Due";
                });
                $("#cheque").click(function() {
                    medium=2;
                    $("#cheque_or_draft").html('Cheque <span class="caret"></span>');
                });
                $("#draft").click(function() {
                    medium=1;
                    $("#cheque_or_draft").html('Demand Draft <span class="caret"></span>');
                });
                $("#tutionfee").click(function(){
                   //tution_fee=result["purpose_fee"];
                   var data="id="+id+"&purpose=tution_fee&batch="+batch+"&domicile="+domicile+"&purpose_fee="+tution_fee+"&course="+course;
                    var url="fee_trial.php";
                    alert(data);
                    //window.location=data;
                    $.post(url,data,function(data){
                        alert(data);
                        result2=JSON.parse(data);
                        alert(result2["report"]);
                        if(result2["report"]==1){
                            $("#tution-fee").modal('show');
                        }else{
                            alert("Tution Fee Already Paid.");
                        }
                    });
                });
                $("#hostelcharge").click(function(){
                    //tution_fee=result["purpose_fee"];
                    var data="id="+id+"&purpose=hostel_charge&batch="+batch+"&domicile="+domicile+"&purpose_fee="+hostle_charge+"&course="+course;
                    var url="fee_trial.php";
                    alert(data);
                    //window.location=data;
                    $.post(url,data,function(data){
                        alert(data);
                        result2=JSON.parse(data);
                        alert(result2["report"]);
                        if(result2["report"]==1){
                            $("#hostel-charge").modal('show');
                        }else{
                            alert("Hostel Charge Already Paid");
                        }
                    });
                });
                $("#messcharge").click(function(){
                    //tution_fee=result["purpose_fee"];
                    var data="id="+id+"&purpose=mess_fee&batch="+batch+"&domicile="+domicile+"&purpose_fee="+mess_charge+"&course="+course;
                    var url="fee_trial.php";
                    alert(data);
                    //window.location=data;
                    $.post(url,data,function(data){
                        alert(data);
                        result2=JSON.parse(data);
                        alert(result2["report"]);
                        if(result2["report"]==1){
                            $("#mess_charge").modal('show');
                        }else{
                            alert("Mess Charge Already Paid");
                        }
                    });
                });
                $("#busfare").click(function(){
                    //tution_fee=result["purpose_fee"];
                    var data="id="+id+"&purpose=bus_fare&batch="+batch+"&domicile="+domicile+"&purpose_fee="+bus_fare+"&course="+result["course"];
                    var url="fee_trial.php";
                    alert(data);
                    //window.location=data;
                    $.post(url,data,function(data){
                        alert(data);
                        result2=JSON.parse(data);
                        alert(result2["report"]);
                        if(result2["report"]==1){
                            $("#bus_fare").modal('show');
                            alert(medium);
                        }else{
                            alert("Bus Fare Already Paid");
                        }
                    });
                });
                $("#busfare_submit").click(function(){
                    var amount=$("#bus-diposite-amount").val();
                    var number=$("#bus-diposite-number").val();
                    var bank=$("#bus-diposite-bank").val();
                    var dop=$("#bus-diposite-dop").val();
                    var data_string="id="+id+"&purpose=bus_fare&amount="+amount+"&medium="+medium+"&process_number="+number+"&bank="+bank+"&messmonth=0&operator="+operator+"&dop="+dop;
                    var url="fee_processing.php";
                    alert(data_string);
                    if(medium==0){
                        alert("Select Payment Method In The Drop Down Menu");
                    }else {
                        $.post(url, data_string, function (data) {
                            alert(data);
                            result = JSON.parse(data);
                            if (result["report"] == 1) {
                                $("#bus_fare").modal('hide');
                                alert("Transaction Complete!");
                            } else if (result["report"] == 0) {
                                alert("Failed To Make Connection With The Server Computer \n Please Check That You Are Have An Active Connection With The Server Computer \n Or Contact System Admin");
                            } else {
                                alert("Transaction Failed!\n Please Retry or Contact System Admin if problem persists.\n Inconvinience Is Regretted");
                            }
                        });
                    }
                });
                $("#tutionfee_submit").click(function(){
                    var number=$("#tf_d1").val()+";"+$("#tf_d2").val()+";"+$("#tf_d3").val();
                    var amount=$("#tf_a1").val()+";"+$("#tf_a2").val()+";"+$("#tf_a3").val();
                    /*if($("#tf_a1").val()==""){
                        var amount1=0;
                    }else{
                        var amount1=$("#tf_a1").val();
                    }
                    if($("#tf_a2").val()==""){
                        var amount2=0;
                    }else{
                        var amount2=$("#tf_a2").val();
                    }
                    if($("#tf_a3").val()==""){
                        var amount3=0;
                    }else{
                        var amount3=$("#tf_a3").val();
                    }*/
                    //var sumtotal=parseInt(amount1)+parseInt(amount2)+parseInt(amount3);
                    var bank=$("#tf_b1").val()+";"+$("#tf_b2").val()+";"+$("#tf_b3").val();
                    var dop=$("#tf_dop1").val()+";"+$("#tf_dop2").val()+";"+$("#tf_dop3").val();
                    var data="id="+id+"&purpose=tution_fee&amount="+amount+"&medium="+medium+"&process_number="+number+"&bank="+bank+"&messmonth=0&operator="+operator+"&dop="+dop;
                    var data_temp=data;
                    var url="fee_processing.php";
                    var url2="transactions.php";
                    alert(data);
                    $.post(url,data,function(data){
                        alert(data);
                        result=JSON.parse(data);
                        if(result["report"]==1){
                            alert(data_temp)
                            $.post(url2,data_temp,function(data){
                                alert(data);
                                result2=JSON.parse(data);
                                if(result2["report"]==1){
                                    $("#tution-fee").modal('hide');
                                    alert("Transaction Complete!");
                                }
                            });                            
                        }else if(result["report"]==0){
                            alert("Failed To Make Connection With The Server Computer \n Please Check That You Are Have An Active Connection With The Server Computer \n Or Contact System Admin");
                        }else{
                            alert("Transaction Failed!\n Please Retry or Contact System Admin if problem persists.\n Inconvinience Is Regretted");
                        }
                    });
                });
                $("#hostelfee_submit").click(function(){
                    var number=$("#hf_d1").val()+";"+$("#hf_d2").val()+";"+$("#hf_d3").val();
                    var amount=$("#hf_a1").val()+";"+$("#hf_a2").val()+";"+$("#hf_a3").val();
                    /*if($("#hf_a1").val()==""){
                        var amount1=0;
                    }else{
                        var amount1=$("#hf_a1").val();
                    }
                    if($("#hf_a2").val()==""){
                        var amount2=0;
                    }else{
                        var amount2=$("#hf_a2").val();
                    }
                    if($("#hf_a3").val()==""){
                        var amount3=0;
                    }else{
                        var amount3=$("#hf_a3").val();
                    }
                    var sumtotal=parseInt(amount1)+parseInt(amount2)+parseInt(amount3);*/
                    var bank=$("#hf_b1").val()+";"+$("#hf_b2").val()+";"+$("#hf_b3").val();
                    var dop=$("#hf_dop1").val()+";"+$("#hf_dop2").val()+";"+$("#hf_dop3").val();
                    var data="id="+id+"&purpose=hostel_fee&amount="+amount+"&medium="+medium+"&process_number="+number+"&bank="+bank+"&messmonth=0&operator="+operator+"&dop="+dop;
                    var url="fee_processing.php";
                    alert(data);
                    $.post(url,data,function(data){
                        alert(data);
                        result=JSON.parse(data);
                        if(result["report"]==1){
                            $("#tution-fee").modal('hide');
                            alert("Transaction Complete!");
                        }else if(result["report"]==0){
                            alert("Failed To Make Connection With The Server Computer \n Please Check That You Are Have An Active Connection With The Server Computer \n Or Contact System Admin");
                        }else{
                            alert("Transaction Failed!\n Please Retry or Contact System Admin if problem persists.\n Inconvinience Is Regretted");
                        }
                    });
                });
                $("#cash_memo_processor").click(function(){
                    var id=$("#chalan_id").val().toUpperCase();
                    if(id==""){
                        alert("Please Enter The Enrolment Number Of The Student");
                        $("#chalan_id").focus();
                    }else{
                        var url="cashmemo.php";
                        var data="id="+id;
                        $.post(url,data,function(html){
                            alert(html);
                            var output=html;
                            var popup=window.open('','_blank','width=520,height=700,location=0,fullscreen=0,status=0,scrollbars=1,toolbar=0,resizeable=0');
                            popup.document.open();
                            popup.document.write(output);
                            popup.document.close();
                        });
                    }
                });
                $("#mess_fee_submit").click(function(){
                    var amount=$("#mf_amount").val();
                    if(messmonth==""||amount==""){
                        alert("Please Enter Payment Details.");
                        $("#mf_amount").focus();
                    }else{
                        var url="fee_processing.php";
                        var data="id="+id+"&purpose=mess_fee&amount="+amount+"&medium=0&process_number=0&bank=0&messmonth="+messmonth+"&operator="+operator;
                        $.post(url,data,function(data){
                            alert(data);
                            result=JSON.parse(data);
                            if(result["report"]==1){
                                $("#mess_charge").modal('hide');
                                amount="";
                                messmonth=0;
                                alert("Transaction Complete!");
                            }else if(result["report"]==0){
                                alert("Failed To Make Connection With The Server Computer \n Please Check That You Are Have An Active Connection With The Server Computer \n Or Contact System Admin");
                            }else{
                                alert("Transaction Failed!\n Please Retry or Contact System Admin if problem persists.\n Inconvinience Is Regretted");
                            }
                        });
                    }
                });
                $("#new_reg_submit").click(function(){
                    var data="id="+$("#new_id").val()+"&name="+$("#new_name").val()+"&mother="+$("#new_mother").val()+"&father="+$("#new_father").val()+"&batch="+$("#new_batch").val()+"&year="+$("#new_year").val()+"&faculty="+$("#new_faculty").val()+"&branch="+$("#new_branch").val()+"&semester="+$("#new_sem").val()+"&program="+$("#new_program").val()+"&state="+$("#new_state").val()+"&span="+$("#new_span").val()+"&board="+$("#new_board").val()+"&status="+$("#new_status").val()+"&domicile="+$("#new_domicile").val();
                    var url="new_student.php";
                    alert(data);
                    $.post(url,data,function(data){
                        alert(data);
                        var temp=JSON.parse(data);
                        if(temp["report"]==1){
                            alert("Record Inserted Successfully!");
                            $("#new_student").modal('hide');
                        }else if(temp["report"]==0){
                            alert("Sorry! Something went wrong! \n Please retry or contact system administrator if required.");
                        }else{
                            alert("Similar record already exist!");
                        }
                    })
                });
                /*$("#datasheet_request").click(function(){
                    var data="source="+$("#data_source").val()+"&sem="+$("#data_sem").val();
                    var url3="datasheet.php";
                    alert(data);
                    $.post(url3,data,function(html){
                        alert(html);
                        var output=html;
                        var popup=window.open('','_blank','width=1120,height=700,location=0,fullscreen=0,status=0,scrollbars=1,toolbar=0,resizeable=0');
                            popup.document.open();
                            popup.document.write(output);
                            popup.document.close();
                    });
                });*/
            });
        </script>

    </head>
    <body style="background-color: #70db70;" onload="startTime()">
        <header style="top: 0px; width: 100%; height: 80px; background-color: #ff4d4d; position: fixed; text-align: center;">
            <span style="margin-left: 5px;color: white">      &nbsp;&nbsp;&nbsp;<b style="font-size: 60px; color: white; font-family: arial">Spinogen</b> &nbsp;<b>Beta</b> </span>

        </header>
        <div class="container">
            <div class="panel panel-primary" style="margin-top: 90px;">
                <div class="panel-heading" style="text-align:center;font-size: 40px;"> Welcome to DASHBOARD</div>
                <div class="panel-body" style="text-align: center; font-family: arial"><b style="font-size: 50px;">Hello!</b> <?php echo $name;?></div>
                <div class="panel-footer" id="dashfooter" style="text-align: center"></div>
            </div>
            <br>
            <hr>
            <h2 style="text-align: center; font-family: Arial;">Wokspace</h2>
            <br><br>
            <div class="jumbotron" style="box-shadow: 0 0 1px 1px gray; height: 200px; text-align: center" id="jumbotron1"><b style="font-size: 30px; text-align: center">New Semester Registration</b><hr><br>
                <div class="form-group has-feedback col-sm-10" style="text-align: center"><input type="text" class="form-control i1" id="s_id" placeholder="Please enter student's enrollment id" style=""></div><button type="button" class="btn btn-primary i1" id="s_id_processor" data-toggle="modal" data-target="">Go</button>
                <br><span id="notice"></span>
                <br>
                <br>
                <!--<button type="button" class="btn btn-info" data-toggle="modal" data-target="#hostel_charge">MODAL</button>-->
            </div>
            <br>
            <br>
            <br>
            <div class="row-fluid">
                <div class="jumbotron" style="box-shadow: 0 0 1px 1px gray; height:200px; width:45%; text-align:center;float:left" id="jumbotron2"><b style="font-size: 30px; text-align: center">New Student Registration</b><hr><br>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#new_student" id="student_registration">Input Details</button>
                </div>
                <div class="jumbotron" style="box-shadow: 0 0 1px 1px gray; height:200px; width:45%; text-align:center; float:right" id="jumbotron3"><b style="font-size: 30px; text-align: center">Cash Receipt</b><hr><br>
                    <div class="row-fluid"><div id="challan" class="form-group" style="margin-bottom: 10px;"><input type="text" id="chalan_id" class="form-control" placeholder="Enrolment Number" style="float: left;width:56%"><button class="btn btn-primary" id="cash_memo_processor" style="float:right">Redeem Cash Memo</button></div></div>
                </div>
            </div>
            <br>
            <br>
            <br>
            <!--<div class="row-fluid">
                <div class="jumbotron" style="box-shadow: 0 0 1px 1px gray; height:200px; width:45%; text-align:center;float:left" id="jumbotron4"><b style="font-size: 30px; text-align: center">Generate Spreadsheet</b><hr><br>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#datasheet" id="datashhet_button">Input Details</button>
                </div>
                <div class="jumbotron" style="box-shadow: 0 0 1px 1px gray; height:200px; width:45%; text-align:center; float:right" id="jumbotron5"><b style="font-size: 30px; text-align: center">Cash Receipt</b><hr><br>
                    <div class="row-fluid"><div id="challan" class="form-group" style="margin-bottom: 10px;"><input type="text" id="chalan_id" class="form-control" placeholder="Enrolment Number" style="float: left;width:56%"><button class="btn btn-primary" id="cash_memo_processor" style="float:right">Redeem Cash Memo</button></div></div>
                </div>
            </div>-->
            <br><br><br><br><br><br><br><br><br><br>
            <br>
            <br>
            <hr>
            <br>
        </div>
        <!-- Modal Student Registration-->
<div id="student_reg" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

        <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="text-align: center">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Information Window</h4>
      </div>
      <div class="modal-body" style="text-align: center">
          <h3>Student Information</h3>
          <hr>
          Name:<b id="name"></b> &nbsp; Domicile State:<b id="state"></b>&nbsp; Mother's Name:<b id="mother_name"></b> &nbsp; Father's Name:<b id="father_name"></b>
          <br>
          Faculty:<b id="faculty"></b> &nbsp; Course:<b id="course"></b> &nbsp; Branch:<b id="branch"></b> &nbsp; Batch of:<b id="batch"></b> &nbsp; Course Duration:<b id="course_duration"></b> (Years)
          <br>   
          Last Recorded Academic Year:<b id="year"></b>&nbsp; Last Recorded Semester:<b id="sem"></b> &nbsp; Enrollment No.:<b id="enrollment"></b>
          <h3>Fee Information</h3>       
          <hr>
          <div class="panel panel-info">
              <div class="panel-heading" style="text-align: center">Fee Information</div>
              <div class="panel-body" style="text-align: center">
                  Tution Fee: Rs.<b id="tution_fee"></b> &nbsp; Mess Charge: Rs.<b id="mess_fee"></b> &nbsp; Hostel Fee: Rs.<b id="hostel_charge"></b> &nbsp; Bus Fare: Rs.<b id="bus_fee"></b>
              </div>              
          </div>
          <div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" id="student_board_view">Select Student Board
  <span class="caret"></span></button>
  <ul class="dropdown-menu" style="text-align: center;margin-left: 350px;">
    <li><a href="#" data-value="hosteler" id="student_type1"value="hosteler">Hosteler</a></li>
    <li><a href="#" data-value="day_scholar" id="student_type2" value="day_scholar">Day Scholar</a></li>    
  </ul>
         </div>
          <br>
         <div class="panel panel-primary">
             <div class="panel-heading">Fee Collection</div>
             <div class="panel-body">
                 <strong id="feenotice">Select Student Boarding Type Above To Enter Fee Details</strong>
                 <div class="btn btn-primary" id="tutionfee" hidden>Tution Fee</div>  &nbsp;  <button class="btn btn-primary" id="hostelcharge">Hostel Charge</button> &nbsp; <div class="btn btn-primary" id="busfare" hidden>Bus Fare</div> &nbsp; <div class="btn btn-primary" id="messcharge" hidden>Mess Charge</div>
             </div>
             <div class="panel-footer"><strong id="feefooter">Select Each Fee Option To Pop Up Fill Up Menu</strong></div>
         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="modal-close">Close</button>
      </div>
    </div>

  </div>
</div>

        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Modal Header</h4>
                    </div>
                    <div class="modal-body">
                        <p>Some text in the jjjj.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>

        <!-- Modal Datasheet-->
        <div class="modal fade" id="datasheet" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><center>Input Requirement</center></h4>
                    </div>
                    <div class="modal-body">
                        <center>
                            <form id="datasheet_request_form">
                                <b>Source:</b> <select id="data_source"><option value="Draft">Demand Draft</option> <option value="cheque">Bank Cheque</option></select>
                                <br>
                                <br>
                                <br>
                                <b>Semester:</b> <select id="data_sem"><option value="Jan2016">January 2016</option></select>
                                <button class="btn btn-primary btn-lg" type="submit" onclick="return false" id="datasheet_request">Submit</button>
                            </form>                            
                        </center>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>

        <!-- Modal New Student Registration-->
        <div class="modal fade" id="new_student" role="dialog">
            <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" style="text-align:center;background-color: greenyellow;">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">New Student Registration</h4>
                    </div>
                    <div class="modal-body" style="text-align:center;background-color: rosybrown">
                        <div class="alert alert-info" style="text-align:center">
                            <b>Please Enter The Student's Details Correctly</b>
                        </div>
                            <br>
                            <form role="form" method="post" id="new_reg_form">
                                <div class="form-group form-inline">
                                    <label for="name">Name:</label>
                                    <input name="name" id="new_name" type="text" placeholder="Enter Full Name Of Student" class="form-control">&nbsp;&nbsp;
                                    <label for="id_no">ID No.:</label>
                                    <input name="id" id="new_id" type="text" placeholder="Enter Student's ID Number In Capital Letter" class="form-control">&nbsp;&nbsp;
                                    <label for="batch">Batch:</label>
                                    <input name="batch" id="new_batch" type="text" placeholder="Joining Batch" class="form-control">&nbsp;&nbsp;
                                </div>
                                <div class="form-group form-inline">
                                    <label for="mother_name">Mother's Name: </label>
                                    <input name="mother" id="new_mother" type="text" placeholder="Mother's Name" class="form-control">&nbsp;
                                    <label for="father_name">Father's Name: </label>
                                    <input name="father" id="new_father" type="text" placeholder="Father's Name" class="form-control"> &nbsp;
                                    <label for="state">State:</label>
                                    <input name="state" id="new_state" type="text" placeholder="Domicile State" class="form-control">
                                </div>
                                <div class="form-group form-inline">
                                    <label for="faculty1">Faculty: </label>
                                    <input name="faculty" id="new_faculty" type="text" placeholder="Faculty Of:" class="form-control">&nbsp;
                                    <label for="program">Program: </label>
                                    <input name="program" id="new_program" type="text" placeholder="Program" class="form-control"> &nbsp;
                                    <label for="Branch">Branch:</label>
                                    <input name="branch" id="new_branch" type="text" placeholder="Branch" class="form-control">
                                </div>
                                <div class="form-group form-inline">
                                    <label for="semester">Semester: </label>
                                    <input name="sem" id="new_sem" type="text" placeholder="Current Semester" class="form-control">&nbsp;
                                    <label for="year">Year: </label>
                                    <input name="year" id="new_year" type="text" placeholder="Current Acedemic Year" class="form-control"> &nbsp;
                                    <label for="course_span">Course Span:</label>
                                    <input name="course_span" id="new_span" type="text" placeholder="Course Span" class="form-control">
                                </div>
                                <div class="form-group form-inline">
                                    <label for="boarder">Boarder Type: </label>
                                    <input name="boarder" id="new_board" type="text" placeholder="Hosteler or Day Scholar" class="form-control">&nbsp;
                                    <label for="status">Status: </label>
                                    <input name="status" id="new_status" type="number" placeholder="Active:1; In-Active:0" class="form-control"> &nbsp;
                                    <label for="Domicile">Domicile:</label>
                                    <input name="domicile" id="new_domicile" type="number" placeholder="Active:1; In-Active:0" class="form-control">
                                </div>
                                <hr>
                                <button class="btn btn-primary btn-lg" type="submit" onclick="return false" id="new_reg_submit">Submit</button>


                            </form>

                    </div>
                    <div class="modal-footer" style="background-color: greenyellow">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>

        <!-- Modal Busfare-->
        <div class="modal fade" id="bus_fare" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" style="text-align:center;background-color: greenyellow;">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Enter Bus Fare</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" style="text-align:center;">In case of Demand Draft Check the following <br> In Favour of : <b>The ICFAI University, Tripura</b><br>Payble at: <b>Agartala</b></div>
                        <div class="container-fluid">
                        <div class="input-group">
                            <div class="input-group-btn">
                                <button id="cheque_or_draft" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Payment Medium <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li id="cheque"><a href="#">Cheque</a></li>
                                    <li id="draft"><a href="#">Demand Draft</a></li>
                                </ul>
                            </div><!-- /btn-group -->
                            <input type="text" class="form-control" aria-label="..." placeholder="Enter Cheque or Demand Draft Number" id="bus-diposite-number">
                        </div><!-- /input-group -->
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">&#8377;</span>
                            <input type="text" class="form-control" placeholder="Amount" aria-describedby="basic-addon1" id="bus-diposite-amount">
                        </div>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Date On Draft</span>
                                <input type="text" class="form-control" placeholder="Day/Month/Full Year (Leave It Blank Incase Of Cheque)" aria-describedby="basic-addon1" id="bus-diposite-dop">
                            </div>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">Issuing Bank</span>
                            <input type="text" class="form-control" placeholder="Issuing Bank" aria-describedby="basic-addon1" id="bus-diposite-bank">
                        </div>
                            <br>
                        <button class="btn btn-success" id="busfare_submit">Submit</button>
                        </div>
                    </div>
                    <div class="modal-footer" style="background-color:greenyellow;">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>



        <!-- Modal  Tution Fee-->
        <div class="modal fade" id="tution-fee" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" style="text-align:center;background-color: greenyellow;">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Enter Tution Fee Details</h4>
                    </div>
                    <div class="modal-body" style="background-color: #4000A0">
                        <div class="alert alert-danger" style="text-align:center">While Accepting Demand Draft Please Ensure <br> In Favour Of:  <b>The ICFAI University,Tripura - Fee Collection A/C</b> <br> Payable At: <b>Agartala</b></div>

                        <div class="container-fluid">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Draft 1</span>
                                <input type="text" class="form-control" placeholder="Enter Demand Draft Number" aria-describedby="basic-addon1" id="tf_d1">
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">&#8377;</span>
                                <input type="text" class="form-control" placeholder="Amount" aria-describedby="basic-addon1" id="tf_a1">
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Date On Draft</span>
                                <input type="text" class="form-control" placeholder="Date/Month/Full Year" aria-describedby="basic-addon1" id="tf_dop1">
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Issuing Bank</span>
                                <input type="text" class="form-control" placeholder="Issuing Bank for the First Draft" aria-describedby="basic-addon1" id="tf_b1">
                            </div>
                            <br>
                            <br>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Draft 2</span>
                                <input type="text" class="form-control" placeholder="Enter Demand Draft Number" aria-describedby="basic-addon1" id="tf_d2">
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">&#8377;</span>
                                <input type="text" class="form-control" placeholder="Amount" aria-describedby="basic-addon1" id="tf_a2">
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Date On Draft</span>
                                <input type="text" class="form-control" placeholder="Date/Month/Full Year" aria-describedby="basic-addon1" id="tf_dop2">
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Issuing Bank</span>
                                <input type="text" class="form-control" placeholder="Issuing Bank for the Second Draft" aria-describedby="basic-addon1" id="tf_b2">
                            </div>
                            <br>
                            <br>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Draft 3</span>
                                <input type="text" class="form-control" placeholder="Enter Demand Draft number" aria-describedby="basic-addon1" id="tf_d3">
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">&#8377;</span>
                                <input type="text" class="form-control" placeholder="Amount" aria-describedby="basic-addon1" id="tf_a3">
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Date On Draft</span>
                                <input type="text" class="form-control" placeholder="Date/Month/Full Year" aria-describedby="basic-addon1" id="tf_dop3">
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Issuing Bank</span>
                                <input type="text" class="form-control" placeholder="Issuing Bank for the Third Draft" aria-describedby="basic-addon1" id="tf_b3">
                            </div>
                            <br>
                            <button class="btn btn-success" type="submit" id="tutionfee_submit" align="center">Submit</button>
                        </div>

                    </div>

                    <div class="modal-footer" style="background-color:greenyellow;">
                        <b style="float:left">Incase more demand draft entries are required submit this first then again click on "Tution Fee" to popup this window</b><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>



            </div>
        </div>

        <!-- Modal Hostel Fee-->
        <div class="modal fade" id="hostel-charge" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" style="text-align:center;background-color:greenyellow;">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Modal Header</h4>
                    </div>
                    <div class="modal-body" style="background-color: #4000A0">
                        <div class="alert alert-danger" style="text-align:center">While Accepting Demand Draft Please Ensure <br> In Favour Of:  <b>The ICFAI University,Tripura - Fee Collection A/C</b> <br> Payable At: <b>Agartala</b></div>

                        <div class="container-fluid">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Draft 1</span>
                                <input type="text" class="form-control" placeholder="Enter Demand Draft Number" aria-describedby="basic-addon1" id="hf_d1">
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">&#8377;</span>
                                <input type="text" class="form-control" placeholder="Amount" aria-describedby="basic-addon1" id="hf_a1">
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Date On Draft</span>
                                <input type="text" class="form-control" placeholder="Date/Month/Full Year" aria-describedby="basic-addon1" id="hf_dop1">
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Issuing Bank</span>
                                <input type="text" class="form-control" placeholder="Issuing Bank for the First Draft" aria-describedby="basic-addon1" id="hf_b1">
                            </div>
                            <br>
                            <br>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Draft 2</span>
                                <input type="text" class="form-control" placeholder="Enter Demand Draft Number" aria-describedby="basic-addon1" id="hf_d2">
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">&#8377;</span>
                                <input type="text" class="form-control" placeholder="Amount" aria-describedby="basic-addon1" id="hf_a2">
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Date On Draft</span>
                                <input type="text" class="form-control" placeholder="Date/Month/Full Year" aria-describedby="basic-addon1" id="hf_dop2">
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Issuing Bank</span>
                                <input type="text" class="form-control" placeholder="Issuing Bank for the Second Draft" aria-describedby="basic-addon1" id="hf_b2">
                            </div>
                            <br>
                            <br>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Draft 3</span>
                                <input type="text" class="form-control" placeholder="Enter Demand Draft number" aria-describedby="basic-addon1" id="hf_d3">
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">&#8377;</span>
                                <input type="text" class="form-control" placeholder="Amount" aria-describedby="basic-addon1" id="hf_a3">
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Date On Draft</span>
                                <input type="text" class="form-control" placeholder="Date/Month/Full Year" aria-describedby="basic-addon1" id="hf_dop3">
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">Issuing Bank</span>
                                <input type="text" class="form-control" placeholder="Issuing Bank for the Third Draft" aria-describedby="basic-addon1" id="hf_b3">
                            </div>
                            <br>
                            <button class="btn btn-success" type="submit" id="hostelfee_submit" align="center" id="hf_submit">Submit</button>
                    </div>
                        </div>
                    <div class="modal-footer" style="background-color:greenyellow;">
                        <b style="float:left">Incase more demand draft entries are required submit this first then again click on "Tution Fee" to popup this window</b>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>

        <!-- Modal Mess Charge-->
        <div class="modal fade" id="mess_charge" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" style="text-align:center;background-color:greenyellow;">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Mess Charge</h4>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="alert alert-info">
                                <span>Enter the amount and select the month from the right side drop down menu.</span>
                            </div>
                            <br>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">&#8377;</button>
                                </span>
                                <input type="text" class="form-control" placeholder="Amount" id="mf_amount">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="month_selector">Select Month <span class="caret"></span></button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li id="january"><a href="#">January</a></li>
                                        <li id="february"><a href="#">February</a></li>
                                        <li id="march"><a href="#">March</a></li>
                                        <li id="april"><a href="#">April</a></li>
                                        <li id="may"><a href="#">May</a></li>
                                        <li id="june"><a href="#">June</a></li>
                                        <li id="july"><a href="#">July</a></li>
                                        <li id="august"><a href="#">August</a></li>
                                        <li id="september"><a href="#">September</a></li>
                                        <li id="october"><a href="#">October</a></li>
                                        <li id="november"><a href="#">November</a></li>
                                        <li id="december"><a href="#">December</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li id="previous_due"><a href="#">Previous Due</a></li>
                                    </ul>
                                </div>
                            </div><!-- /input-group -->
                            <br>
                            <button class="btn btn-success" id="mess_fee_submit">Submit</button>
                        </div>
                    </div>
                    <div class="modal-footer" style="background-color:greenyellow;">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>


        <footer style="position: fixed; height: 50px; text-align: center; color: white; background-color: #09d2d2; width: 100%; bottom:0px;"><br><b>&copy;  Gourab Saha. Under Section(o) of Copyright Act 1957. Republic of India</b></footer>
    </body>
</html>
