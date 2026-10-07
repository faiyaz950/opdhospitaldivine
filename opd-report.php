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


$sq = mysql_query("select * from doctor_mst order by id asc");
        

        //to make pagination
		
		
			if($search != '')
		{
		$statement = "`opd_mst` where pid = '" . hms_uhid_pid($search) . "'";
		}
        else
		{
        $statement = "`opd_mst`";
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
                            Datewise OPD Reports
                              </h1>
                        <ol class="breadcrumb">
                            <li>
                              <div align="center"><form method="post" action="opd-report1.php"><strong>From Date : </strong> <input type="text" name="from_date" value="<?php echo date("Y-m-d"); ?>">&nbsp;&nbsp;<strong>To Date : </strong> <input type="text" name="to_date" value="<?php echo date("Y-m-d"); ?>">&nbsp;&nbsp;<strong>From Time : </strong> <input type="time" name="from_time" value="00:00">&nbsp;&nbsp;<strong>To Time : </strong> <input type="time" name="to_time" value="23:59">&nbsp;&nbsp;<strong>Doctor : </strong><select name="report">
               <option value="0">All Doctors</option>
			  <?php
			  while($pq = mysql_fetch_array($sq))
			  {
			  ?>                    
                 <option value="<?php echo $pq['id']; ?>"><?php echo $pq['doc_name']; ?></option>
                 <?php
				 }
                 ?>
                 </select>&nbsp;&nbsp;<input type="submit" name="submit" value="Search"></form></div>  			       
                            </li>
                            <li class="active">
                               <!-- <i class="fa fa-file"></i>--> <!--Blank Page-->
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                
                
               
             

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
