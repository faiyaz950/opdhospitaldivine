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
$doctor =  $_REQUEST['doctor'];	
	

    //get the function

    include_once ('function.php');



    	$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);

    	$limit = 30;

    	$startpoint = ($page * $limit) - $limit;

        

        //to make pagination
		
		
			if($search != '')
		{
		$statement = "`investigate_mst` where refer=1 and pid = '$search'";
		}
        else
		{
        $statement = "`investigate_mst` where refer=1";
        }	

        
$docs = mysql_query("select * from doctor_mst order by doc_name asc");
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
                            Patients Investigation Management
                            <!--<small><a href="add-investigate.php">Add New Investigation</a></small>-->
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                              <div align="center"><form method="post" action=""><strong>Search Patients by UHID : </strong> <input type="text" name="search">&nbsp;&nbsp;<input type="submit" name="submit" value="Search"></form></div> <br />
<?php
if($_SESSION['user_login']['email'] == 'admin')
{
?>
  			      <div align="center"><form method="post" action="investigateseenstatusupdate.php"><strong>Change Status :</strong> <input type="text" name="statusdate" value="<?php echo date("Y-m-d"); ?>">&nbsp;&nbsp;<input type="submit" name="submit" value="Seen"></form></div> 	<?php
}
?>		       
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
				
				if($_SESSION['user_login']['email'] == 'admin')
{


                echo "<th class='sortable-text'>ID</th><th class='sortable-text'>UHID</th><th class='sortable-text'>Patient Name</th><th class='sortable-text'>Age</th><th class='sortable-text'>Address</th><th>Report Name</th><th class='sortable-text'>Charges</th><th class='sortable-text'>Date</th><th class='sortable-text'>Time</th><th class='sortable-text'>Doctor</th><th class='sortable-text'>Status</th><th class='sortable-text'>Delete</th>";
}

else
{
echo "<th class='sortable-text'>ID</th><th class='sortable-text'>UHID</th><th class='sortable-text'>Patient Name</th><th class='sortable-text'>Age</th><th class='sortable-text'>Address</th><th>Report Name</th><th class='sortable-text'>Charges</th><th class='sortable-text'>Date</th><th class='sortable-text'>Time</th><th class='sortable-text'>Doctor</th>";
}




                echo "</tr>";

            

        	   while ($row = mysql_fetch_array($query)) {

        			   $id = $row['id'];
					   $seen = $row['seen'];
					   
					    $pid=$row['pid'];
				
				$psq = mysql_query("select * from patient_mst where id = '$pid'");
				$psq1 = mysql_fetch_array($psq);
				$pat_name = $psq1['pat_name'];
				$age = $psq1['age'];
				$address = $psq1['address'];
				$mobile_no = $psq1['mobile_no'];
				$refer = $psq1['refer'];
				
			    $docs_list = mysql_query("select * from doctor_mst where id='$refer'");
                $doc_name = mysql_fetch_array($docs_list);
                $referby = $doc_name['doc_name'];

				
				$l_uhid = hms_uhid_prefix($pid);
				
				$did=$row['rid'];
                $dsq = mysql_query("select * from report_mst where id = '$did'");
				$psq1 = mysql_fetch_array($dsq);
				$dep_name = $psq1['rep_name'];
				$rep_charges = $psq1['rate'];
				$created_date=$row['created_date'];
$created_datetime=$row['created_datetime'];
$created_time=$row['created_time'];
			$cr_date = explode("-", $created_date);
$day = $cr_date[2];
$month = $cr_date[1];
$year = $cr_date[0];	

$cr_time = explode(" ", $created_datetime);
$time1 = $cr_time[1];

if($created_time == '00:00:00')
{
$time = $time1;
}
else
{
$time = $created_time;
}

                      

if($_SESSION['user_login']['email'] == 'admin')
{

				
				if($seen == '1')
                 {               

                echo"<tr><td>$id</td><td>$l_uhid$pid</td><td>$pat_name</td><td>$age</td> <td>$address</td> <td>$dep_name</td><td>$rep_charges</td>   <td>$day-$month-$year</td><td>$time</td><td>$referby</td><td><img src='images/Green_tick.png' /></td><td><a href='process/delete_investigate1.php?id=$id'>Delete</a></td>

				  </tr>";

                 }
				 else
				 {
echo"<tr><td>$id</td><td>$l_uhid$pid</td><td>$pat_name</td><td>$age</td> <td>$address</td><td>$dep_name</td><td>$rep_charges</td>   <td>$day-$month-$year</td><td>$time</td><td>$referby</td><td><a href='investigate-seen1.php?id=$id'><img src='images/red-tick.png' /></a></td><td><a href='process/delete_investigate1.php?id=$id'>Delete</a></td>

				  </tr>";
				 
				 }
   }
   
   
if($_SESSION['user_login']['email'] != 'admin')
{
				
				if($seen == '1')
                 {               

                echo"<tr><td>$id</td><td>$l_uhid$pid</td><td>$pat_name</td><td>$age</td> <td>$address</td><td>$dep_name</td><td>$rep_charges</td>   <td>$day-$month-$year</td><td>$time</td><td>$referby</td>

				  </tr>";

                 }
				 else
				 {
echo"<tr><td>$id</td><td>$l_uhid$pid</td><td>$pat_name</td><td>$age</td> <td>$address</td><td>$dep_name</td><td>$rep_charges</td>   <td>$day-$month-$year</td><td>$time</td><td>$referby</td>

				  </tr>";
				 
				 }

}
   
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
