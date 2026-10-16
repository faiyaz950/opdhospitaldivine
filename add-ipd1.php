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
$sq = mysql_query("select * from ipd_mst order by rep_name asc");

$id = isset($_REQUEST['id']) ? trim($_REQUEST['id']) : '';
$pat_name = '';
$referby = '';
$refer_id = 0;
$p_id1 = 0;

if ($id != '') {
    $p_id1 = hms_uhid_pid($id);
    $psq = mysql_query("select * from patient_mst where id = '$p_id1'");
    if ($psq && ($psq1 = mysql_fetch_array($psq))) {
        $pat_name = $psq1['pat_name'];
        $refer_id = $psq1['refer'];
        
        $docs_list = mysql_query("select * from doctor_mst where id='$refer_id'");
        if ($docs_list && ($doc_name = mysql_fetch_array($docs_list))) {
            $referby = $doc_name['doc_name'];
        }
    }
}

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

    <title>Admit Patient (IPD)</title>

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
<script>
function toggleDischargeFields(show) {
    var sec = document.getElementById('discharge_section');
    if (sec) {
        sec.style.display = show ? '' : 'none';
    }
}
</script>
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
                            Admit Patient to IPD
                            <small>(Indoor Admission - Backdate Supported)</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <a href="show_ipd1.php"><i class="fa fa-hospital-o"></i> IPD Management</a>
                            </li>
                            <li class="active">
                                New IPD Admission
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                
                <form method="post" name="form1" action="process/addipd1.php">
                <table width="650" border="1" bordercolor="#00a2e8" cellpadding="6" cellspacing="2" style="line-height:30px; background:#fff;">

		   <tr><td colspan="2" style="background:#e8f4f8; font-weight:bold; color:#1b6d85; padding:8px 12px;"><i class="fa fa-info-circle"></i> Enter Admission Details (You can select a back date if admitting previously)</td></tr>

<tr> <td class="style8" width="35%">Patient UHID :</td>
      <td width="65%"><input type="text" name="pat_id" id="pat_id" style="width:250px;" value="<?php echo $id; ?>" required placeholder="e.g. DIV/26100001 or ID">
      <?php if(!$id): ?>
      <span style="font-size:12px; color:#666;">Enter UHID or Patient ID</span>
      <?php endif; ?>
      </td>
</tr>

<?php if($pat_name): ?>
<tr> <td class="style8">Patient Name :</td>
      <td><strong><?php echo htmlspecialchars($pat_name); ?></strong></td>
</tr>
<?php endif; ?>

<tr> <td class="style8">Doctor Name :</td>
      <td>
        <select name="refer" style="width:250px;">
          <?php while($d = mysql_fetch_array($all_docs)): ?>
            <option value="<?php echo $d['id']; ?>" <?php if($d['id'] == $refer_id) echo 'selected'; ?>><?php echo htmlspecialchars($d['doc_name']); ?></option>
          <?php endwhile; ?>
        </select>
      </td>
</tr>

<tr> <td class="style8">IPD Bed / Type :</td>
      <td>
        <select name="department" style="width:250px;">
        <?php while($pq = mysql_fetch_array($sq)): ?>
          <option value="<?php echo $pq['id']; ?>"><?php echo htmlspecialchars($pq['rep_name']); ?> (Rs. <?php echo $pq['rate']; ?>)</option>
        <?php endwhile; ?>
        </select>
      </td>
</tr>

<tr style="background:#fff9e6;"> 
      <td class="style8"><strong><i class="fa fa-calendar"></i> Admission Date :</strong></td>
      <td>
        <input type="date" name="admission_date" id="admission_date" value="<?php echo date("Y-m-d"); ?>" required style="width:160px;">
        &nbsp;&nbsp;
        <strong>Time :</strong>
        <input type="time" name="admission_time" id="admission_time" value="<?php echo date("H:i"); ?>" required style="width:110px;">
        <br><span style="font-size:11px; color:#8a6d3b;">(Choose any back date &amp; time if admitting for an earlier date)</span>
      </td>
</tr>

<tr>
      <td class="style8">Already Discharged? :</td>
      <td>
        <label style="font-weight:normal; cursor:pointer;">
          <input type="checkbox" name="is_discharged" id="is_discharged" value="1" onchange="toggleDischargeFields(this.checked)">
          Yes, patient was already discharged in backdate
        </label>
      </td>
</tr>

<tbody id="discharge_section" style="display:none; background:#f9f9f9;">
<tr style="background:#f2dede;">
      <td class="style8"><strong><i class="fa fa-sign-out"></i> Discharge Date :</strong></td>
      <td>
        <input type="date" name="discharge_date" id="discharge_date" value="<?php echo date("Y-m-d"); ?>" style="width:160px;">
        &nbsp;&nbsp;
        <strong>Time :</strong>
        <input type="time" name="discharge_time" id="discharge_time" value="<?php echo date("H:i"); ?>" style="width:110px;">
        <br><span style="font-size:11px; color:#a94442;">(Discharge backdate must be on or after admission date)</span>
      </td>
</tr>

<tr>
      <td class="style8">Condition at Discharge :</td>
      <td>
        <select name="discharge_condition" style="width:250px;">
          <option value="Recovered">Recovered</option>
          <option value="Improved" selected>Improved</option>
          <option value="Relieved">Relieved</option>
          <option value="Referred">Referred</option>
          <option value="LAMA">LAMA (Leave Against Medical Advice)</option>
          <option value="Expired">Expired</option>
        </select>
      </td>
</tr>

<tr>
      <td class="style8">Final Diagnosis :</td>
      <td>
        <input type="text" name="final_diagnosis" style="width:350px;" placeholder="e.g. Acute Appendicitis / CSOM">
      </td>
</tr>

<tr>
      <td class="style8">Discharge Medication / Advice :</td>
      <td>
        <textarea name="discharge_summary" rows="3" style="width:350px;" placeholder="Medications, precautions, and follow-up advice..."></textarea>
      </td>
</tr>
</tbody>

<tr>
    <td colspan="2">
        <div align="center" style="padding:10px 0;">        
            <input type="submit" name="submit" id="submit" value="Submit Admission" class="btn btn-primary" style="padding:8px 24px; font-weight:bold;"/>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="show_ipd1.php" class="btn btn-default" style="padding:8px 20px;">Cancel</a>
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
