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
	include_once ('DLL/pro_function.php'); 

	

    //get the function

    include_once ('function.php');



    	$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);

    	$limit = 30;

    	$startpoint = ($page * $limit) - $limit;

        
$search = $_REQUEST['search'];

        //to make pagination
		
				if($search != '')
		{
		$statement = "`billing_mst` where bill_typenumber = '$search' or pat_id='$search'";
		}
        else
		{
        $statement = "`billing_mst`"; 
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

    <title>Manage Investigation of Patients</title>

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
                            All Bills
                            <small></small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                            <div align="center"><form method="post" name="form1" action=""><strong>Search Bills by OPD No. / IPD No. / Investigation No. / UHID : </strong> <input type="text" name="search">&nbsp;&nbsp;<input type="submit" name="submit" value="Search"></form></div>  		
                              </li>
                            
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                
                
                <?php

		

            //show records

            $query = mysql_query("SELECT * FROM {$statement} order by id desc LIMIT {$startpoint} , {$limit}");

			          

                //$sql=mysql_query("select * from news");

                echo "<table class='rowstyle-alt colstyle-alt no-arrow' bgcolor='#FFFFFF'>";

                echo "<tr>";
				
				

                echo "<th class='sortable-text'>ID</th><th class='sortable-text'>Bill No.</th><th class='sortable-text'>Bill Type</th><th class='sortable-text'>OPD/IPD/Investigation No.</th><th class='sortable-text'>Patient's Name</th><th class='sortable-text'>Amount</th><th class='sortable-text'>Created Date</th><th class='sortable-text'>Get Bill</th>";






                echo "</tr>";

            

        	   while ($row = mysql_fetch_array($query)) {

        			   $id = $row['id'];
$bill_no = $row['bill_id'];

					   $bill_type = $row['bill_type'];
					   $pat_id = $row['pat_id'];
					   $pat_name = getPatientName($pat_id);
					   $bill_typenumber = $row['bill_typenumber'];
					   $bill_amount = $row['bill_amount'];
					   $created_date = $row['created_date'];
					   
					    
                echo"<tr><td>$id</td><td>$bill_no</td><td>$bill_type</td><td>$bill_typenumber</td><td>$pat_name</td> <td>$bill_amount</td> <td>$created_date</td><td><a href='display-bill.php?c=$id' target='_blank'>Get Bill</a></td>

				  </tr>";

                    }
   
   
                echo"</table>";

				?>


				
<div class="records round" align="center">

                   
                   <?php    
                   
                    echo pagination($statement,$limit,$page);
                ?>
				

             

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
