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
                                if($sex == 'Male')
                                {
                                $m = 'M';
                                }
                                elseif($sex == 'Female')
                                {
                                $m = 'F';
                                }
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
<!--
body { font-family: Arial; font-size: 17.5px }
.pos { position: absolute; z-index: 0; left: 0px; top: 0px }
-->
</style>
</head>
<body>
<div style="padding-top:270px; padding-left:200px;">
<table border="1" cellpadding="10" cellspacing="0" style="border-collapse:collapse; width:630px;">

<tr>
<td width="8%" style="font-size:14px; font-weight:bold;">UHID</td><td width="15%" style="font-size:14px;"><?php echo $l_uhid; ?></td><td width="20%" style="font-size:14px; font-weight:bold;">NAME OF THE PATIENT</td><td width="30%" style="font-size:14px;"><?php echo $pat_name; ?></td>
</tr>
<tr>
<td width="8%" style="font-size:14px; font-weight:bold;">OPID</td><td width="15%" style="font-size:14px;"><?php echo $pat['id']; ?></td><td width="20%" style="font-size:14px; font-weight:bold;">ADDRESS</td><td width="30%" style="font-size:14px;"><?php echo $address; ?></td>
</tr>
<tr>
<td width="8%" style="font-size:14px; font-weight:bold;">AGE</td><td width="15%" style="font-size:14px;"><?php echo (int) $age; ?>&nbsp;Yrs <?php echo (int) $agemonths; ?>&nbsp;Mts</td><td width="20%" style="font-size:14px; font-weight:bold;">VALIDITY </td><td width="30%" style="font-size:14px;"><?php echo $cd[2]; ?>-<?php echo $cd[1]; ?>-<?php echo $cd[0]; ?> &nbsp;&nbsp;&nbsp;&nbsp;<b>To</b>&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $dd[2]; ?>-<?php echo $dd[1]; ?>-<?php echo $dd[0]; ?> </td>
</tr>
<tr>
<td width="8%" style="font-size:14px; font-weight:bold;">WEIGHT</td><td width="15%" style="font-size:14px;"></td><td width="20%" style="font-size:14px; font-weight:bold;">BP</td><td width="30%" style="font-size:14px;"></td>
</tr>
<tr>
<td width="8%" style="font-size:14px; font-weight:bold;">PMJAY</td><td colspan="3" style="font-size:14px;"><?php echo $pmjay; ?></td>
</tr>
</table>
</div>
<br />
</body>
</html>
