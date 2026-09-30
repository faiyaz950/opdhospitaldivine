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

$search = $_REQUEST['search'];
	

    //get the function

    include_once ('function.php');



    	$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);

    	$limit = 30;

    	$startpoint = ($page * $limit) - $limit;

        

        //to make pagination
		
		
		$from_date = $_POST['from_date'];
		$to_date = $_POST['to_date'];
		$report = $_POST['report'];
		
        if($report == '0')
		{
		$statement = "`income_mst` where created_date >= '$from_date' and created_date <= '$to_date'";
		}
		else
		{
		$statement = "`income_mst` where created_date >= '$from_date' and created_date <= '$to_date' and incometype='$report'";
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

    <title>Datewise Expense Report</title>

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
                            Income Report (From Date : <?php echo $from_date; ?> to <?php echo $to_date; ?>)
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
			 

			          

                //$sql=mysql_query("select * from news");

                echo "<table class='rowstyle-alt colstyle-alt no-arrow' bgcolor='#FFFFFF'>";

                echo "<tr>";

                echo "<th class='sortable-text'>ID</th><th class='sortable-text'>Income Type</th><th class='sortable-text'>Amount</th><th class='sortable-text'>Created Date</th>";

                echo "</tr>";

            $total = 0;

        	   while ($row = mysql_fetch_array($query)) {

        			   $id = $row['id'];
					   
					    $incometype=$row['incometype'];
						$expname = getIncomeName($incometype);
						$amount = $row['amount'];
						$created_date = $row['created_date'];
				
				
				
				
                 $total = $total + $amount;         

                echo"<tr><td>$id</td><td>$expname</td><td>$amount</td> <td>$created_date</td> 

				  </tr>";



                }

                echo"</table>";

				?>

				
 <div class="records round" align="center">

                  <strong>Total Number of Incomes : <?php echo $count; ?> | Total Amount : <?php echo $total; ?></strong>
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
