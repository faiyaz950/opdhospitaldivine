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

$i = $_REQUEST['id'];
$sql = mysql_query("select * from admin where id='$i'");
$r = mysql_fetch_array($sql);

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Manage Admin</title>

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
                            Edit Admin Details
                            <small></small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                			 
                                             
                            </li>
                            <li class="active">
                               <!-- <i class="fa fa-file"></i>--> <!--Blank Page-->
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                
                <form  method="post" name="form1" action="process/editadmin.php">
                <table width="580" height="150" border="1" bordercolor="#00a2e8" cellpadding="1" cellspacing="1" style="line-height:30px;">

		   <tr><td colspan="3" style="color:#FF0000; font-weight:bold;">Please fill all the fields</td></tr>

<tr> <td class="style8" width="40%"> Login ID:</td>

            <td width="60%"><input type="text" name="email" style="width:250px;" value="<?php echo $r['email']; ?>">
			  </select>
			   </td>
				  </tr>

<tr> <td class="style8">Password :</td>

              <td><input type="password" name="password" style="width:250px;" value="<?php echo $r['password']; ?>">
			  
			   </td>
				  </tr>
                    
			<tr><td colspan="2"><input type="hidden" name="id" value="<?php echo $i ?>"></td></tr>
                    <tr>

					    <td colspan="3"><div align="center">        

                    <input type="submit" name="submit" id="submit" value="Update"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                 

				    </div>    </td>

             
                    </tr>

					 

				  </table>

				</form>

             

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
