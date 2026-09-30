<?php
error_reporting(0);
session_start();

if(!(isset($_SESSION['user_login'])))

{

	$_SESSION["error_msg"]="Please Login";

	header("Location: index.php");die;

}

    //connect to the database

    include_once ('DLL/config.php'); 

$uhid = $_POST['pat_id'];
if($uhid == '')
{
header("Location: formsbyuhid.php");die;
}
else
{
$pat_id=$_POST['pat_id'];
$pa_id = explode('-', $pat_id);
$p_id = hms_uhid_pid($pat_id);
$sq = mysql_query("select * from patient_mst where id = '$p_id'");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Manage Patient Forms</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <link href="css/pagination.css" rel="stylesheet" type="text/css" />
    <link href="css/B_blue.css" rel="stylesheet" type="text/css" />
    <link href="css/table.css" rel="stylesheet" type="text/css" />


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
     <style type="text/css">
<!--
.myButton {
	-moz-box-shadow: 0px 10px 14px -7px #276873;
	-webkit-box-shadow: 0px 10px 14px -7px #276873;
	box-shadow: 0px 10px 14px -7px #276873;
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #599bb3), color-stop(1, #408c99));
	background:-moz-linear-gradient(top, #599bb3 5%, #408c99 100%);
	background:-webkit-linear-gradient(top, #599bb3 5%, #408c99 100%);
	background:-o-linear-gradient(top, #599bb3 5%, #408c99 100%);
	background:-ms-linear-gradient(top, #599bb3 5%, #408c99 100%);
	background:linear-gradient(to bottom, #599bb3 5%, #408c99 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#599bb3', endColorstr='#408c99',GradientType=0);
	background-color:#599bb3;
	-moz-border-radius:8px;
	-webkit-border-radius:8px;
	border-radius:8px;
	display:inline-block;
	cursor:pointer;
	color:#ffffff;
	font-family:Arial;
	font-size:16px;
	font-weight:bold;
	padding:13px 32px;
	text-decoration:none;
	text-shadow:0px 1px 0px #3d768a;
}
.myButton:hover {
	background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #408c99), color-stop(1, #599bb3));
	background:-moz-linear-gradient(top, #408c99 5%, #599bb3 100%);
	background:-webkit-linear-gradient(top, #408c99 5%, #599bb3 100%);
	background:-o-linear-gradient(top, #408c99 5%, #599bb3 100%);
	background:-ms-linear-gradient(top, #408c99 5%, #599bb3 100%);
	background:linear-gradient(to bottom, #408c99 5%, #599bb3 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#408c99', endColorstr='#599bb3',GradientType=0);
	background-color:#408c99;
}
.myButton:active {
	position:relative;
	top:1px;
}

      
-->
    </style>


<?php include("theme-head.php"); ?>
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
           
           <?php include("header-topbar.php"); ?>
           
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <?php include("leftbar.php") ?>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Download Forms
                            <small></small>
                        </h1
                        ><ol class="breadcrumb">
                            <li>
                                			 
                                             
                            </li>
                            <li class="active">
                               <!-- <i class="fa fa-file"></i>--> <!--Blank Page-->
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
<?php                
                               echo "<table class='rowstyle-alt colstyle-alt no-arrow' bgcolor='#FFFFFF'>";

                echo "<tr>";

                echo "<th class='sortable-text'>UHID</th><th class='sortable-text'>Patient Name</th><th class='sortable-text'>Father / Husband Name</th><th class='sortable-text'>Sex</th><th class='sortable-text'>Age</th><th class='sortable-text'>Address</th><th class='sortable-text'>City</th><th class='sortable-text'>Mobile No.</th><th class='sortable-text'>Created Date</th> <th>Edit</th> <th>Delete</th>";

                echo "</tr>";

            

        	   while ($row = mysql_fetch_array($sq)) {

        

			    $id=$row['id'];
				
                $p_name=$row['pat_name'];
				
				$f_name=$row['fat_name'];
				
				$sex=$row['sex'];
				
				$age=$row['age'];
				
				$address=$row['address'];
				
				$city=$row['city'];
				
				$mobile_no=$row['mobile_no'];               

				$created_date=$row['created_date'];
				
				$updated_date=$row['updated_date'];
				
				
				$l_uhid = hms_uhid_prefix($id);
				
                                

                echo"<tr><td>$l_uhid$id</td> <td>$p_name</td><td>$f_name</td><td>$sex</td> <td>$age</td> <td>$address</td><td>$city</td><td>$mobile_no</td>   <td>$created_date</td><td><a href='edit-patient.php?id=$id'>Edit</a></td><td><a href='process/delete_patient.php?id=$id'>Delete</a></td>

				  </tr>";

				

                }

                echo"</table>";

				?>
<br /><br />


<div align="center"><a href="forms/cost-estimation.php?c=<?php echo $id; ?>" class="myButton" target="_blank">Cost Estimatation Form</a>&nbsp;&nbsp;<a href="forms/general-consent.php?c=<?php echo $id; ?>" class="myButton" target="_blank">General Consent Form</a>&nbsp;&nbsp;<a href="forms/history-sheet.php?c=<?php echo $id; ?>" class="myButton" target="_blank">History Sheet</a>&nbsp;&nbsp;<a href="forms/pain-assessment.php?c=<?php echo $id; ?>" class="myButton" target="_blank">Pain Assessment Form</a></div>
<br /><br />

<div align="center"><a href="forms/medication-record.php?c=<?php echo $id; ?>" class="myButton" target="_blank">Medication Administration Record</a>&nbsp;&nbsp;<a href="forms/treatment-summary.php?c=<?php echo $id; ?>" class="myButton" target="_blank">Treatment Summary</a>&nbsp;&nbsp;<a href="forms/discharge-summary.php?c=<?php echo $id; ?>" class="myButton" target="_blank">Discharge Summary</a>&nbsp;&nbsp;</div>
<br /><br />



<div align="center"><a href="forms/consultant-referral.php?c=<?php echo $id; ?>" class="myButton" target="_blank">Consultant Referral Form (Internal)</a>&nbsp;&nbsp;<a href="forms/parasurgical-consent.php?c=<?php echo $id; ?>" class="myButton" target="_blank">Parasurgical Consent Form</a>&nbsp;&nbsp;<a href="forms/safety-check-list.php?c=<?php echo $id; ?>" class="myButton" target="_blank">Surgical Safety Checklist</a></div>
<br /><br />



            <!-- /.container-fluid -->
<br />
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
