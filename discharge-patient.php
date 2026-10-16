<?php
error_reporting(0);
session_start();

if(!(isset($_SESSION['user_login'])))
{
	$_SESSION["error_msg"]="Please Login";
	header("Location: index.php");die;
}

include_once ('DLL/config.php'); 
include_once ('DLL/pro_function.php');

$ipd_id = (int)$_REQUEST['id'];
$sq = mysql_query("select * from patipd_mst where id = '$ipd_id'");
$ipd = mysql_fetch_array($sq);
if (!$ipd) {
    header("Location: show_ipd1.php");
    exit;
}

$pid = $ipd['pid'];
$psq = mysql_query("select * from patient_mst where id = '$pid'");
$pat = mysql_fetch_array($psq);
$l_uhid = hms_uhid($pid);

// Doctor
$refer_id = $ipd['refer'] ?: $pat['refer'];
$docs_list = mysql_query("select * from doctor_mst where id='$refer_id'");
$doc_name = mysql_fetch_array($docs_list);
$referby = $doc_name['doc_name'];

// IPD Master type
$rid = $ipd['rid'];
$dsq = mysql_query("select * from ipd_mst where id = '$rid'");
$dep = mysql_fetch_array($dsq);

// Default dates
$adm_date = $ipd['created_date'];
$adm_datetime = $ipd['created_datetime'];

$dis_date = $ipd['discharge_date'] ? $ipd['discharge_date'] : date("Y-m-d");
$dis_time = $ipd['discharge_time'] ? substr($ipd['discharge_time'], 0, 5) : date("H:i");
$dis_status = isset($ipd['discharge_status']) ? (int)$ipd['discharge_status'] : 0;
$dis_cond = $ipd['discharge_condition'] ?: 'Improved';
$final_diag = $ipd['final_diagnosis'] ?: '';
$dis_summary = $ipd['discharge_summary'] ?: '';

$all_docs = mysql_query("select * from doctor_mst order by doc_name asc");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Discharge Patient (Backdate Supported)</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
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
                            Patient Discharge Management
                            <small>(Backdate Discharge Supported)</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <a href="show_ipd1.php"><i class="fa fa-hospital-o"></i> IPD Management</a>
                            </li>
                            <li class="active">
                                Discharge Patient #<?php echo $ipd_id; ?>
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <?php if (isset($_GET['msg']) && $_GET['msg'] == 'saved'): ?>
                <div class="alert alert-success alert-dismissable" style="max-width:700px;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="fa fa-check-circle"></i> <strong>Discharge details updated successfully!</strong>
                    &nbsp;&nbsp;
                    <a href="forms/discharge-summary.php?c=<?php echo $pid; ?>&ipd_id=<?php echo $ipd_id; ?>" target="_blank" class="btn btn-xs btn-primary"><i class="fa fa-print"></i> Print Discharge Summary</a>
                </div>
                <?php endif; ?>
                
                <form method="post" name="form1" action="process/dischargepatient.php">
                <input type="hidden" name="ipd_id" value="<?php echo $ipd_id; ?>">
                <table width="680" border="1" bordercolor="#00a2e8" cellpadding="6" cellspacing="2" style="line-height:30px; background:#fff;">

		   <tr><td colspan="2" style="background:#e8f4f8; font-weight:bold; color:#1b6d85; padding:8px 12px;"><i class="fa fa-user"></i> Patient &amp; Admission Info</td></tr>

<tr> <td class="style8" width="35%">IPD ID :</td>
      <td width="65%"><strong>#<?php echo $ipd_id; ?></strong></td>
</tr>

<tr> <td class="style8">Patient UHID :</td>
      <td><strong><?php echo $l_uhid; ?></strong></td>
</tr>

<tr> <td class="style8">Patient Name :</td>
      <td><strong><?php echo htmlspecialchars($pat['pat_name']); ?></strong> (<?php echo $pat['age']; ?> Yrs / <?php echo $pat['sex']; ?>)</td>
</tr>

<tr> <td class="style8">Doctor :</td>
      <td><?php echo htmlspecialchars($referby); ?></td>
</tr>

<tr> <td class="style8">Bed / IPD Type :</td>
      <td><?php echo htmlspecialchars($dep['rep_name']); ?></td>
</tr>

<tr style="background:#fcf8e3;"> 
      <td class="style8"><strong>Admission Date &amp; Time (DOA) :</strong></td>
      <td>
        <strong><?php echo date('d-m-Y H:i', strtotime($adm_datetime ?: $adm_date)); ?></strong>
        <span style="font-size:11px; color:#8a6d3b;">(Admitted on <?php echo $adm_date; ?>)</span>
      </td>
</tr>

		   <tr><td colspan="2" style="background:#f2dede; font-weight:bold; color:#a94442; padding:8px 12px;"><i class="fa fa-sign-out"></i> Discharge Details (Select Any Back Date)</td></tr>

<tr>
      <td class="style8">Discharge Status :</td>
      <td>
        <select name="discharge_status" style="width:250px;">
          <option value="1" <?php if($dis_status == 1 || $dis_status == 0) echo 'selected'; ?>>Discharged</option>
          <option value="0" <?php if($dis_status === 0 && isset($_GET['undo'])) echo 'selected'; ?>>Still Admitted (Cancel Discharge)</option>
        </select>
      </td>
</tr>

<tr style="background:#fff3f3;"> 
      <td class="style8"><strong><i class="fa fa-calendar"></i> Discharge Date (DOD) :</strong></td>
      <td>
        <input type="date" name="discharge_date" id="discharge_date" value="<?php echo $dis_date; ?>" required style="width:160px;">
        &nbsp;&nbsp;
        <strong>Time :</strong>
        <input type="time" name="discharge_time" id="discharge_time" value="<?php echo $dis_time; ?>" required style="width:110px;">
        <br><span style="font-size:11px; color:#a94442;">(You can choose any back date on or after the admission date)</span>
      </td>
</tr>

<tr>
      <td class="style8">Condition at Discharge :</td>
      <td>
        <select name="discharge_condition" style="width:250px;">
          <option value="Recovered" <?php if($dis_cond=='Recovered') echo 'selected'; ?>>Recovered</option>
          <option value="Improved" <?php if($dis_cond=='Improved') echo 'selected'; ?>>Improved</option>
          <option value="Relieved" <?php if($dis_cond=='Relieved') echo 'selected'; ?>>Relieved</option>
          <option value="Referred" <?php if($dis_cond=='Referred') echo 'selected'; ?>>Referred</option>
          <option value="LAMA" <?php if($dis_cond=='LAMA') echo 'selected'; ?>>LAMA (Leave Against Medical Advice)</option>
          <option value="Expired" <?php if($dis_cond=='Expired') echo 'selected'; ?>>Expired</option>
        </select>
      </td>
</tr>

<tr>
      <td class="style8">Final Diagnosis :</td>
      <td>
        <input type="text" name="final_diagnosis" value="<?php echo htmlspecialchars($final_diag); ?>" style="width:360px;" placeholder="e.g. Acute Suppurative Otitis Media">
      </td>
</tr>

<tr>
      <td class="style8">Discharge Medication / Advice :</td>
      <td>
        <textarea name="discharge_summary" rows="4" style="width:360px;" placeholder="Medications, post-discharge instructions, follow-up date..."><?php echo htmlspecialchars($dis_summary); ?></textarea>
      </td>
</tr>

<tr>
    <td colspan="2">
        <div align="center" style="padding:10px 0;">        
            <input type="submit" name="submit" id="submit" value="Save Discharge" class="btn btn-danger" style="padding:8px 24px; font-weight:bold;"/>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="forms/discharge-summary.php?c=<?php echo $pid; ?>&ipd_id=<?php echo $ipd_id; ?>" target="_blank" class="btn btn-primary" style="padding:8px 18px;"><i class="fa fa-print"></i> View Discharge Summary</a>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="show_ipd1.php" class="btn btn-default" style="padding:8px 20px;">Back to IPD List</a>
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
