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
include_once ('function.php');

$search = isset($_REQUEST['search']) ? trim($_REQUEST['search']) : '';
$doctor = isset($_REQUEST['doctor']) ? (int)$_REQUEST['doctor'] : 0;
$filter_status = isset($_REQUEST['status']) ? trim($_REQUEST['status']) : '';

$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
$limit = 30;
$startpoint = ($page * $limit) - $limit;

// To make pagination query
$where_clauses = array();
if ($search != '') {
    $where_clauses[] = "pid = '" . hms_uhid_pid($search) . "'";
}
if ($doctor > 0) {
    $where_clauses[] = "refer = '$doctor'";
}
if ($filter_status === 'admitted') {
    $where_clauses[] = "(discharge_status = 0 OR discharge_status IS NULL)";
} elseif ($filter_status === 'discharged') {
    $where_clauses[] = "discharge_status = 1";
}

if (!empty($where_clauses)) {
    $statement = "`patipd_mst` where " . implode(" and ", $where_clauses);
} else {
    $statement = "`patipd_mst`";
}

$docs = mysql_query("select * from doctor_mst order by doc_name asc");

// Count stats
$admitted_count_q = mysql_query("select count(*) as c from `patipd_mst` where discharge_status = 0 OR discharge_status IS NULL");
$total_admitted = ($admitted_count_q && ($ac = mysql_fetch_array($admitted_count_q))) ? (int)$ac['c'] : 0;

$discharged_count_q = mysql_query("select count(*) as c from `patipd_mst` where discharge_status = 1");
$total_discharged = ($discharged_count_q && ($dc = mysql_fetch_array($discharged_count_q))) ? (int)$dc['c'] : 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Patients IPD Management</title>

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
<style>
.ipd-action-btn {
    margin: 2px 1px;
    display: inline-block;
}
.ipd-badge-status {
    font-size: 11px;
    padding: 3px 6px;
    border-radius: 4px;
    display: inline-block;
}
</style>
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
                        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap;">
                            <h1 class="page-header" style="margin-bottom:10px;">
                                Patients IPD Management
                            </h1>
                            <div>
                                <a href="add-ipd1.php" class="btn btn-primary" style="font-weight:600;"><i class="fa fa-plus-circle"></i> Admit New Patient (IPD)</a>
                            </div>
                        </div>

                        <!-- Status filter pills -->
                        <div style="margin-bottom: 15px;">
                            <ul class="nav nav-pills" style="display:inline-block;">
                                <li class="<?php echo ($filter_status === '') ? 'active' : ''; ?>">
                                    <a href="show_ipd1.php">All Patients</a>
                                </li>
                                <li class="<?php echo ($filter_status === 'admitted') ? 'active' : ''; ?>">
                                    <a href="show_ipd1.php?status=admitted">Currently Admitted <span class="badge"><?php echo $total_admitted; ?></span></a>
                                </li>
                                <li class="<?php echo ($filter_status === 'discharged') ? 'active' : ''; ?>">
                                    <a href="show_ipd1.php?status=discharged">Discharged Patients <span class="badge"><?php echo $total_discharged; ?></span></a>
                                </li>
                            </ul>
                        </div>

                        <ol class="breadcrumb">
                            <li>
                              <div align="center">
                                <form method="get" action="show_ipd1.php" class="form-inline" style="display:inline-block;">
                                    <?php if($filter_status): ?>
                                    <input type="hidden" name="status" value="<?php echo htmlspecialchars($filter_status); ?>">
                                    <?php endif; ?>
                                    <strong>Search Patient : </strong>
                                    <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Enter UHID" class="form-control input-sm" style="width:180px;">
                                    &nbsp;&nbsp;OR Doctor : &nbsp;&nbsp;
                                    <select name="doctor" class="form-control input-sm">
                                        <option value="0">All Doctors</option>
                                        <?php while($doc = mysql_fetch_array($docs)): ?>                    
                                            <option value="<?php echo $doc['id']; ?>" <?php if($doc['id'] == $doctor) echo 'selected'; ?>><?php echo htmlspecialchars($doc['doc_name']); ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                    &nbsp;&nbsp;
                                    <button type="submit" class="btn btn-sm btn-info"><i class="fa fa-search"></i> Search</button>
                                    <?php if($search || $doctor): ?>
                                    &nbsp;<a href="show_ipd1.php<?php echo $filter_status ? '?status=' . $filter_status : ''; ?>" class="btn btn-sm btn-default">Reset</a>
                                    <?php endif; ?>
                                </form>
                              </div>
                              <br />
<?php if($_SESSION['user_login']['email'] == 'admin'): ?>
  			      <div align="center">
                    <form method="post" action="ipdseenstatusupdate.php" class="form-inline">
                        <strong>Change Status to Seen :</strong> 
                        <input type="text" name="statusdate" value="<?php echo date("Y-m-d"); ?>" class="form-control input-sm" style="width:120px;">
                        &nbsp;&nbsp;
                        <input type="submit" name="submit" value="Mark Seen" class="btn btn-sm btn-default">
                    </form>
                  </div>
<?php endif; ?>	       		       
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <?php if (isset($_GET['msg']) && $_GET['msg'] == 'inv_added'): ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="fa fa-check-circle"></i> <strong>Indoor Investigation added successfully for the admitted patient!</strong>
                </div>
                <?php endif; ?>
                
                <?php
                // Show records
                $query = mysql_query("SELECT * FROM {$statement} order by id desc LIMIT {$startpoint} , {$limit}");

                echo "<table class='rowstyle-alt colstyle-alt no-arrow' bgcolor='#FFFFFF' style='width:100%;'>";
                echo "<tr>";
                echo "<th class='sortable-text'>IPD ID</th>";
                echo "<th class='sortable-text'>UHID</th>";
                echo "<th class='sortable-text'>Patient Name</th>";
                echo "<th class='sortable-text'>Age / Sex</th>";
                echo "<th class='sortable-text'>Mobile</th>";
                echo "<th class='sortable-text'>Bed / IPD Type</th>";
                echo "<th class='sortable-text'>Charges</th>";
                echo "<th class='sortable-text'>Admission Date</th>";
                echo "<th class='sortable-text'>Discharge Status</th>";
                echo "<th class='sortable-text'>Indoor Inv.</th>";
                echo "<th class='sortable-text'>Doctor</th>";
                echo "<th class='sortable-text'>Seen</th>";
                echo "<th class='sortable-text' style='text-align:center;'>Actions</th>";
                if($_SESSION['user_login']['email'] == 'admin') {
                    echo "<th class='sortable-text'>Delete</th>";
                }
                echo "</tr>";

                while ($row = mysql_fetch_array($query)) {
                    $id = $row['id'];
                    $seen = $row['seen'];
                    $pid = $row['pid'];
				
                    $psq = mysql_query("select * from patient_mst where id = '$pid'");
                    $psq1 = mysql_fetch_array($psq);
                    $pat_name = $psq1['pat_name'];
                    $age = $psq1['age'];
                    $sex = $psq1['sex'];
                    $mobile_no = $psq1['mobile_no'];
                    $refer = $row['refer'] ?: $psq1['refer'];
				
                    $docs_list = mysql_query("select * from doctor_mst where id='$refer'");
                    $doc_name = mysql_fetch_array($docs_list);
                    $referby = $doc_name['doc_name'];

                    $l_uhid = hms_uhid($pid);
				
                    $did = $row['rid'];
                    $dsq = mysql_query("select * from ipd_mst where id = '$did'");
                    $psq1 = mysql_fetch_array($dsq);
                    $dep_name = $psq1['rep_name'];
                    $rep_charges = $psq1['rate'];

                    $created_date = $row['created_date'];
                    $cr_date = explode("-", $created_date);
                    $adm_formatted = $cr_date[2] . "-" . $cr_date[1] . "-" . $cr_date[0];

                    // Discharge info
                    $dis_status = (int)$row['discharge_status'];
                    $dis_date = $row['discharge_date'];
                    $dis_formatted = '';
                    if ($dis_date) {
                        $ds = explode("-", $dis_date);
                        $dis_formatted = $ds[2] . "-" . $ds[1] . "-" . $ds[0];
                    }

                    // Indoor investigation count
                    $inv_cnt_q = mysql_query("select count(*) as c from investigate_mst where (ipd_id = '$id' or (pid = '$pid' and inv_type = 'Indoor'))");
                    $inv_count = ($inv_cnt_q && ($ic = mysql_fetch_array($inv_cnt_q))) ? (int)$ic['c'] : 0;

                    echo "<tr>";
                    echo "<td><strong>#$id</strong></td>";
                    echo "<td><strong>$l_uhid</strong></td>";
                    echo "<td>" . htmlspecialchars($pat_name) . "</td>";
                    echo "<td>$age Y / $sex</td>";
                    echo "<td>" . htmlspecialchars($mobile_no) . "</td>";
                    echo "<td>" . htmlspecialchars($dep_name) . "</td>";
                    echo "<td>Rs. $rep_charges</td>";
                    echo "<td><i class='fa fa-calendar text-muted'></i> $adm_formatted</td>";

                    // Discharge Status Column
                    echo "<td>";
                    if ($dis_status == 1) {
                        echo "<span class='label label-default ipd-badge-status'><i class='fa fa-check'></i> Discharged</span><br>";
                        echo "<span style='font-size:11px; color:#555;'>$dis_formatted</span>";
                    } else {
                        echo "<span class='label label-success ipd-badge-status'><i class='fa fa-bed'></i> Admitted</span>";
                    }
                    echo "</td>";

                    // Indoor Investigation Column
                    echo "<td>";
                    echo "<span class='badge' style='background:#5bc0de;'>$inv_count Inv</span><br>";
                    echo "<a href='add-investigate.php?id=$l_uhid&ipd_id=$id&type=indoor' class='btn btn-xs btn-success ipd-action-btn' title='Add Indoor Investigation'><i class='fa fa-plus'></i> Add Inv</a>";
                    echo "</td>";

                    echo "<td>" . htmlspecialchars($referby) . "</td>";

                    // Seen status
                    echo "<td>";
                    if ($seen == '1') {
                        echo "<img src='images/Green_tick.png' title='Seen' />";
                    } else {
                        echo "<a href='ipd-seen.php?id=$id'><img src='images/red-tick.png' title='Mark as Seen' /></a>";
                    }
                    echo "</td>";

                    // Actions Column
                    echo "<td style='white-space:nowrap;'>";
                    if ($dis_status == 1) {
                        echo "<a href='discharge-patient.php?id=$id' class='btn btn-xs btn-info ipd-action-btn' title='Edit Discharge Info'><i class='fa fa-edit'></i> Edit Disch.</a>";
                    } else {
                        echo "<a href='discharge-patient.php?id=$id' class='btn btn-xs btn-warning ipd-action-btn' style='font-weight:bold;' title='Discharge Patient (Backdate)'><i class='fa fa-sign-out'></i> Discharge</a>";
                    }
                    echo "&nbsp;<a href='forms/discharge-summary.php?c=$pid&ipd_id=$id' target='_blank' class='btn btn-xs btn-primary ipd-action-btn' title='Print Discharge Summary'><i class='fa fa-print'></i> Summary</a>";
                    echo "&nbsp;<a href='edit-ipd1.php?id=$id' class='btn btn-xs btn-default ipd-action-btn' title='Edit Admission'><i class='fa fa-pencil'></i></a>";
                    echo "</td>";

                    if($_SESSION['user_login']['email'] == 'admin') {
                        echo "<td><a href='process/delete_Ipd.php?id=$id' onclick=\"return confirm('Delete this IPD admission?');\" class='btn btn-xs btn-danger'><i class='fa fa-trash'></i></a></td>";
                    }

                    echo "</tr>";
                }

                echo "</table>";
                ?>
				
                <div class="records round" align="center" style="margin-top:20px;">
                   <?php    
                    $page_url = "?search=" . urlencode($search) . "&doctor=" . $doctor . "&status=" . urlencode($filter_status) . "&";
                    echo pagination($statement, $limit, $page, $page_url);
                    ?>	
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
