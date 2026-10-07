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

$search = $_REQUEST['search'];
	

    //get the function

    include_once ('function.php');



    	$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);

    	$limit = 30;

    	$startpoint = ($page * $limit) - $limit;

        

        //to make pagination
		
		$from_date = $_POST['from_date'];
		$to_date = $_POST['to_date'];
		$from_time = preg_match('/^\d{2}:\d{2}$/', $_POST['from_time']) ? $_POST['from_time'] : '00:00';
		$to_time = preg_match('/^\d{2}:\d{2}$/', $_POST['to_time']) ? $_POST['to_time'] : '23:59';
		$range = "created_datetime >= '$from_date $from_time:00' and created_datetime <= '$to_date $to_time:59'";
                $report = $_POST['report'];


		if($report == '0')
		{
                  $statement = "`opd_mst` where $range";
                }
                else
               {
                  $statement = "`opd_mst` where $range and refer='$report'";
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

    <title>Datewise OPD Reports</title>

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

<?php include("theme-head.php"); ?>
</head>

<body bgcolor="#FFFFFF">
<hr color="#000000">

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
                            OPD Report (From : <?php echo $from_date . ' ' . $from_time; ?> hrs to <?php echo $to_date . ' ' . $to_time; ?> hrs)
                            </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                               <!-- <i class="fa fa-file"></i>--> <!--Blank Page-->
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                
                
                <?php

		

            //show records

            $query = mysql_query("SELECT * FROM {$statement} order by id desc");
             $count = mysql_num_rows($query);
			 
			 $op_charges = mysql_query("SELECT sum(opd_charges) as total FROM {$statement}");
			 $op_charges1 = mysql_fetch_array($op_charges);          

                //$sql=mysql_query("select * from news");

                echo "<table class='rowstyle-alt colstyle-alt no-arrow' bgcolor='#FFFFFF'>";

                echo "<tr>";

                echo "<th class='sortable-text'>OPD No.</th><th class='sortable-text'>UHID</th><th class='sortable-text'>Patient Name</th><th class='sortable-text'>Age</th><th class='sortable-text'>Address</th><th>Doctor Name</th><th class='sortable-text'>Fee Received</th><th class='sortable-text'>Visited Date</th>";

                echo "</tr>";

            

        	   while ($row = mysql_fetch_array($query)) {

        			   $id = $row['id'];
					   
					    $pid=$row['pid'];
				
				$psq = mysql_query("select * from patient_mst where id = '$pid'");
				$psq1 = mysql_fetch_array($psq);
				$pat_name = $psq1['pat_name'];
				$age = $psq1['age'];
				$address = $psq1['address'];
				$city = $psq1['city'];
				
				$mobile_no = $psq1['mobile_no'];
				
				$refer = $psq1['refer'];
				
				$docs_list = mysql_query("select * from doctor_mst where id='$refer'");
                $doc_name = mysql_fetch_array($docs_list);
                $referby = $doc_name['doc_name'];
				
				
				$l_uhid = hms_uhid($pid);
				
				$op = mysql_query("select * from param_mst where type='opd'");
				$op1 = mysql_fetch_array($op);
				$opp = $op1['last_value'];
				
				$did=$row['did'];
                $dsq = mysql_query("select * from department_mst where id = '$did'");
				$psq1 = mysql_fetch_array($dsq);
				$dep_name = $psq1['dep_name'];
				
				$fee = $row['opd_charges'];
				$created_date=$row['created_datetime'];
				
				
                                

                echo"<tr><td>$opp$id</td><td>$l_uhid</td><td>$pat_name</td><td>$age</td> <td>$address</td><td>$referby</td><td>$fee</td>   <td>$created_date</td> 

				  </tr>";



                }

                echo"</table>";

				?>

				
<div class="records round" align="center">

                   <strong>Total Number of OPD : <?php echo $count; ?> | Total Amount : <?php echo $op_charges1['total']; ?></strong>
                   


        </div>
             

            </div>
            <!-- /.container-fluid -->

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
