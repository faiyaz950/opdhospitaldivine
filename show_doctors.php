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
		
		if($search != '')
		{
		$statement = "`doctor_mst` where id like '%$search%' or doc_name like '%$search%' or city like '%$search%' or mobile_no like '%$search%'";
		}
		else
		{
		$statement = "`doctor_mst`";
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

    <title>Manage Doctors</title>

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
                            Doctor Master
                            <small><a href="add-doctor.php">Add New Doctor</a></small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                			 <form method="post" action=""><strong>Search Doctors by ID / Name / Address / Mobile No. :</strong> <input type="text" name="search" style="width:300px;">&nbsp;&nbsp;<input type="submit" name="submit" value="Search"></form>
                                             
                            </li>
                            <li class="active">
                               <!-- <i class="fa fa-file"></i>--> <!--Blank Page-->
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

                echo "<th class='sortable-text'>ID</th><th class='sortable-text'>Doctor Name</th><th class='sortable-text'>Sex</th><th class='sortable-text'>Age</th><th class='sortable-text'>Address</th><th class='sortable-text'>City</th><th class='sortable-text'>Mobile No.</th><th class='sortable-text'>Delete</th>";

                echo "</tr>";

            

        	   while ($row = mysql_fetch_array($query)) {

        

			    $id=$row['id'];
				
                $doc_name=$row['doc_name'];
				
				$f_name=$row['fat_name'];
				
				$sex=$row['sex'];
				
				$age=$row['age'];
				
				$address=$row['address'];
				
				$city=$row['city'];
				
				$mobile_no=$row['mobile_no'];               

				$created_date=$row['created_date'];

$time=$row['created_time'];

$cr_date = explode("-", $created_date);
$day = $cr_date[2];
$month = $cr_date[1];
$year = $cr_date[0];
				
				$updated_date=$row['updated_date'];
				
				
				$su = mysql_query("select * from param_mst where type='uid_pformat'");
				$su1 = mysql_fetch_array($su);
				$l_uhid = $su1['last_value'];
     

                echo"<tr><td>$id</td> <td>$doc_name</td><td>$sex</td> <td>$age</td> <td>$address</td><td>$city</td><td>$mobile_no</td><td><a href='process/delete_doctor.php?id=$id'>Delete</a></td>
 
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
