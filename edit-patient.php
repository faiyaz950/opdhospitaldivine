<?php
session_start();
if(!(isset($_SESSION["user_login"])))
{
	$_SESSION["error_msg"]="Please Login";
	header("Location: index.php");die;
}
$c = $_REQUEST['id'];
include("DLL/config.php");
include("DLL/pro_function.php");
$sq = mysql_query("select * from patient_mst where id = '$c'");
$pq = mysql_fetch_array($sq);
$refer_id = $pq['refer'];
$refer_name = getReferDocName($refer_id);


				$l_uhid = hms_uhid($c);
				
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

    <title>Manage Patients</title>

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
                            Update Patient Information
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
                
                <form  method="post" name="form1" action="process/editpatient.php">
                <table width="580" height="150" border="1" bordercolor="#00a2e8" cellpadding="1" cellspacing="1" style="line-height:30px;">

		   <tr><td colspan="3" style="color:#FF0000; font-weight:bold;">Please fill all the fields</td></tr>

<!--
            <tr> <td width="279"><div align="center" class="style8"> Category :</div></td>

              <td width="288"><div align="center">

                    

                        <input type="text" name="category" id="category" style="width:250px;" onblur="return blankvalidate(this.value,'name');"/>

                

                  </div><div id="error_pagetitle" style="display:none; color:#FF0000;">Please enter category name</div> </td>

                </tr>
-->
<tr> <td class="style8" width="40%">UHID :</td>

              <td width="60%" class="style8"><?php echo $l_uhid ?>
			  
			   </td>
				  </tr>


<tr> <td class="style8" width="40%">Patient Name :</td>

              <td width="60%"><input type="text" name="pat_name" style="width:250px;" value="<?php echo $pq['pat_name']; ?>">
			  
			   </td>
				  </tr>

<tr> <td class="style8">Father / Husband's Name :</td>

              <td><input type="text" name="fat_name" style="width:250px;" value="<?php echo $pq['fat_name']; ?>">
			  
			   </td>
				  </tr>
                    
				 <tr> <td class="style8">Gender :</td>
              <td>                    
                 <select name="gender"><option value="<?php echo $pq['sex']; ?>"><?php echo $pq['sex']; ?></option><option value="Male">Male</option><option value="Female">Female</option></select>
				  </td></tr>
                  
                  <tr> <td class="style8">Address :</td>
              <td>                    
                 <input type="text" name="address" style="width:250px;" value="<?php echo $pq['address']; ?>">
				  </td></tr>
                  

		   <tr> <td class="style8">Mobile Number :</td>
              <td>                    
                 <input type="text" name="mobile_no" style="width:250px;" value="<?php echo $pq['mobile_no']; ?>">
				  </td></tr>

<tr> <td class="style8">Age :</td>
              <td>                    
                 <input type="text" name="age" style="width:25px;" value="<?php echo $pq['age']; ?>"><span class="style8">Years&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="agemonths" style="width:25px;" value="<?php echo $pq['agemonths']; ?>">&nbsp;&nbsp;<span class="style8">Months</span>
				  </td></tr>

                  <tr> <td class="style8">PMJAY :</td>
              <td>
                 <select name="pmjay" required><option value="" disabled<?php if ($pq['pmjay'] != 'Yes' && $pq['pmjay'] != 'No') echo ' selected'; ?>>-- Select --</option><option value="Yes"<?php if ($pq['pmjay'] == 'Yes') echo ' selected'; ?>>Yes</option><option value="No"<?php if ($pq['pmjay'] == 'No') echo ' selected'; ?>>No</option></select>
				  </td></tr>

 <tr> <td class="style8">Remarks :</td>
              <td>                    
                 <textarea name="remarks" rows="5" cols="30"><?php echo $pq['remarks']; ?></textarea>
				  </td></tr>
                  
                  <tr> <td class="style8">Doctor :</td>
              <td>
                <select name="refer">
                <option value="<?php echo $refer_id; ?>"><?php echo $refer_name; ?></option>
               
				  </td></tr>




<tr> <td colspan="2"><input type="hidden" name="c" value="<?php echo $pq['id']; ?>">
				  </td></tr>
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
