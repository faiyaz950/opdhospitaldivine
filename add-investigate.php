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
$sq = mysql_query("select * from report_mst order by rep_name asc");

$id = isset($_REQUEST['id']) ? trim($_REQUEST['id']) : '';
$ipd_id = isset($_REQUEST['ipd_id']) ? (int)$_REQUEST['ipd_id'] : 0;
$type_req = isset($_REQUEST['type']) ? strtolower($_REQUEST['type']) : '';
$is_indoor = ($ipd_id > 0 || $type_req === 'indoor');

$ipd_row = null;
if ($ipd_id > 0) {
    $ipd_q = mysql_query("select * from patipd_mst where id = '$ipd_id'");
    $ipd_row = mysql_fetch_array($ipd_q);
}

if ($ipd_row) {
    $p_id1 = (int)$ipd_row['pid'];
    $id = hms_uhid($p_id1);
    $refer = $ipd_row['refer'];
    $def_date = $ipd_row['created_date'];
} elseif ($id != '') {
    $p_id1 = hms_uhid_pid($id);
    $def_date = date("Y-m-d");
} else {
    $p_id1 = 0;
    $def_date = date("Y-m-d");
}

$pat_name = '';
$referby = '';
if ($p_id1 > 0) {
    $psq = mysql_query("select * from patient_mst where id = '$p_id1'");
    if ($psq && ($psq1 = mysql_fetch_array($psq))) {
        $pat_name = $psq1['pat_name'];
        if (!$refer) {
            $refer = $psq1['refer'];
        }
    }
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

    <title><?php echo $is_indoor ? 'Add Indoor Investigation' : 'Manage Investigation of Patients'; ?></title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <link href="css/pagination.css" rel="stylesheet" type="text/css" />
    <link href="css/B_blue.css" rel="stylesheet" type="text/css" />
    <link href="css/table.css" rel="stylesheet" type="text/css" />

<?php include("theme-head.php"); ?>
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
           <?php include("header-topbar.php"); ?>
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <?php include("leftbar.php") ?>
            </div>
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?php if ($is_indoor): ?>
                                Add Indoor Investigation
                                <small>(IPD Admission #<?php echo $ipd_id ?: 'Indoor'; ?> - Backdate Supported)</small>
                            <?php else: ?>
                                Add New Investigation
                                <small>(Backdate Supported)</small>
                            <?php endif; ?>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <?php if($is_indoor): ?>
                                    <a href="show_ipd1.php"><i class="fa fa-hospital-o"></i> IPD Management</a>
                                <?php else: ?>
                                    <a href="show_investigate.php"><i class="fa fa-flask"></i> Investigation Management</a>
                                <?php endif; ?>
                            </li>
                            <li class="active">
                                Add Investigation
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                
                <form method="post" name="form1" action="process/addinvestigate.php">
                <input type="hidden" name="ipd_id" value="<?php echo $ipd_id; ?>">
                <table width="620" border="1" bordercolor="#00a2e8" cellpadding="6" cellspacing="2" style="line-height:30px; background:#fff;">

		   <tr><td colspan="2" style="background:<?php echo $is_indoor ? '#eefbf4' : '#e8f4f8'; ?>; font-weight:bold; color:<?php echo $is_indoor ? '#2b6f4e' : '#1b6d85'; ?>; padding:8px 12px;">
           <i class="fa fa-flask"></i> <?php echo $is_indoor ? 'Indoor Investigation for Admitted Patient' : 'Investigation Details'; ?> (You can select any back date)
           </td></tr>

<tr> <td class="style8" width="35%">Patient UHID :</td>
      <td width="65%"><input type="text" name="pat_id" style="width:250px;" value="<?php echo $id; ?>" required placeholder="e.g. DIV/26100001">
      </td>
</tr>
                  
<?php if($pat_name): ?>
<tr> <td class="style8">Patient Name :</td>
      <td><strong><?php echo htmlspecialchars($pat_name); ?></strong></td>
</tr>
<?php endif; ?>

<?php if($ipd_id > 0): ?>
<tr style="background:#fcf8e3;"> 
      <td class="style8">Linked IPD Admission :</td>
      <td><strong>IPD #<?php echo $ipd_id; ?></strong> (Admission Date: <?php echo $ipd_row['created_date']; ?>)</td>
</tr>
<?php endif; ?>

<tr> <td class="style8">Investigation Type :</td>
      <td>
        <select name="inv_type" style="width:250px;">
          <option value="Indoor" <?php if($is_indoor) echo 'selected'; ?>>Indoor Investigation (IPD)</option>
          <option value="Outdoor" <?php if(!$is_indoor) echo 'selected'; ?>>Outdoor Investigation (OPD)</option>
        </select>
      </td>
</tr>

<tr> <td class="style8">Doctor Name :</td>
      <td>
        <select name="refer" style="width:250px;">
          <?php while($doc = mysql_fetch_array($docs)): ?>
            <option value="<?php echo $doc['id']; ?>" <?php if($doc['id'] == $refer) echo 'selected'; ?>><?php echo htmlspecialchars($doc['doc_name']); ?></option>
          <?php endwhile; ?>
        </select>
      </td>
</tr>
                    
<tr> <td class="style8">Report / Investigation :</td>
      <td>
        <select name="report_id" style="width:250px;" required>
          <option value="" disabled selected>-- Select Test / Report --</option>
          <?php while($pq = mysql_fetch_array($sq)): ?>
            <option value="<?php echo $pq['id']; ?>"><?php echo htmlspecialchars($pq['rep_name']); ?> (Rs. <?php echo $pq['rate']; ?>)</option>
          <?php endwhile; ?>
        </select>
      </td>
</tr>

<tr style="background:#fff9e6;"> 
      <td class="style8"><strong><i class="fa fa-calendar"></i> Investigation Date :</strong></td>
      <td>
        <input type="date" name="investigation_date" id="investigation_date" value="<?php echo $def_date; ?>" required style="width:160px;">
        &nbsp;&nbsp;
        <strong>Time :</strong>
        <input type="time" name="investigation_time" id="investigation_time" value="<?php echo date("H:i"); ?>" required style="width:110px;">
        <br><span style="font-size:11px; color:#8a6d3b;">(Choose any back date &amp; time if report was done earlier)</span>
      </td>
</tr>

<tr>
    <td colspan="2">
        <div align="center" style="padding:10px 0;">        
            <input type="submit" name="submit" id="submit" value="Submit Investigation" class="btn btn-primary" style="padding:8px 24px; font-weight:bold;"/>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php if($is_indoor): ?>
            <a href="show_ipd1.php" class="btn btn-default" style="padding:8px 20px;">Back to IPD</a>
            <?php else: ?>
            <a href="show_investigate.php" class="btn btn-default" style="padding:8px 20px;">Cancel</a>
            <?php endif; ?>
        </div>
    </td>
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
