<?php
error_reporting(0);
session_start();

if(!(isset($_SESSION['user_login'])))

{

	$_SESSION["error_msg"]="Please Login";

	header("Location: index.php");die;

}

    //connect to the database

    include_once ('../DLL/config.php'); 

$c = $_REQUEST['id'];
$sq = mysql_query("select * from opd_mst where id = '$c'");
$pat = mysql_fetch_array($sq);
$pid=$pat['pid'];

				
				$psq = mysql_query("select * from patient_mst where id = '$pid'");
				$psq1 = mysql_fetch_array($psq);
				$pat_name = $psq1['pat_name'];
				$age = $psq1['age'];
                                $agemonths = $psq1['agemonths'];
				$sex = $psq1['sex'];
				$m = strtoupper(substr(trim($sex), 0, 1));
				$city = $psq1['city'];
				$mobile_no = $psq1['mobile_no'];
				$address = $psq1['address'];
				$pmjay = $psq1['pmjay'];
				
				$l_uhid = hms_uhid($pid);
				
				$did=$row['did'];
                $dsq = mysql_query("select * from department_mst where id = '$did'");
				$psq1 = mysql_fetch_array($dsq);
				$dep_name = $psq1['dep_name'];
				
				$fee = $pat['opd_charges'];
				$created_date=$pat['created_date'];
				$cd = explode('-', $created_date);
				$valid_till = $pat['valid_till'];
				$dd = explode('-', $valid_till);
				
				
?>

<html>
<head>
<title>OPD REGISTRATION FORM </title>
<style type="text/css">
@page { size: A4; margin: 0; }
body { font-family: Arial; margin: 0; }
.slip { padding-top: 8cm; }
.slip table { width: 15cm; margin-left: 4cm; border-collapse: collapse; table-layout: fixed; }
.slip tr { height: 1.2cm; }
.nowrap { white-space: nowrap; }
.slip td { border: 1px solid #000; padding: 0 5px; font-size: 12px; vertical-align: middle; word-wrap: break-word; }
.slip td.lbl { font-weight: bold; }
</style>
</head>
<body>
<div class="slip">
<table>
<colgroup>
<col style="width:2cm"><col style="width:3cm">
<col style="width:2.2cm"><col style="width:2.6cm">
<col style="width:2.2cm"><col style="width:3cm">
</colgroup>
<tr>
<td class="lbl">UHID</td><td><?php echo $l_uhid; ?></td>
<td class="lbl">OPID</td><td><?php echo $pat['id']; ?></td>
<td class="lbl">PMJAY</td><td><?php echo $pmjay; ?></td>
</tr>
<tr>
<td class="lbl">NAME</td><td><?php echo $pat_name; ?></td>
<td class="lbl">AGE / SEX</td><td><?php echo (int) $age; ?> Yrs <?php echo (int) $agemonths; ?> Mts / <?php echo $m; ?></td>
<td class="lbl">ADDRESS</td><td><?php echo $address; ?></td>
</tr>
<tr>
<td class="lbl">VALIDITY</td><td><span class="nowrap"><?php echo $cd[2]; ?>-<?php echo $cd[1]; ?>-<?php echo $cd[0]; ?></span> to <span class="nowrap"><?php echo $dd[2]; ?>-<?php echo $dd[1]; ?>-<?php echo $dd[0]; ?></span></td>
<td class="lbl">WEIGHT / B.P.</td><td></td>
<td class="lbl">ADDICTION</td><td></td>
</tr>
</table>
</div>
</body>
</html>
