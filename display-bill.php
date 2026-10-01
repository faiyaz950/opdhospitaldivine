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
	include("functions.php"); 

$c = $_REQUEST['c'];
$sql = mysql_query("select * from billing_mst where id = '$c'");
$r = mysql_fetch_array($sql);
$bill_type = $r['bill_type'];
$bill_typenumber = $r['bill_typenumber'];
$bill_amount = $r['bill_amount'];
$created_date = $r['created_date'];
$date1 = explode(" ", $created_date);
if($bill_type == 'OPD')
{
$t = mysql_query("select * from opd_mst where id = '$bill_typenumber'");
$p = mysql_fetch_array($t);
$pid = $p['pid'];
$pinfo = getPatientDetails($pid);
$message = "We have recived Rs.".$bill_amount." as OPD Charges for ENT Department.";
}
elseif(($bill_type == 'IPD'))
{
$t = mysql_query("select * from patipd_mst where id = '$bill_typenumber'");
$p = mysql_fetch_array($t);
$pid = $p['pid'];
$pinfo = getPatientDetails($pid);
$message = "We have recived Rs.".$bill_amount." as IPD Charges for ENT Department.";
}
elseif(($bill_type == 'Investigation'))
{
$t = mysql_query("select * from investigate_mst where id = '$bill_typenumber'");
$p = mysql_fetch_array($t);
$pid = $p['pid'];
$pinfo = getPatientDetails($pid);
$message = "We have recived Rs.".$bill_amount." as Investigation Report Charges for ENT Department.";
}
?>

<html>
<head>
<title>Bill | DIVINE ENT CENTER</title>
<style type="text/css">
<!--
body { font-family: Arial; font-size: 17.5px }
.pos { position: absolute; z-index: 0; left: 0px; top: 0px }
-->
</style>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="css/print-doc.css?v=1" rel="stylesheet">
</head>
<body>
<table align="center">
<tr>
<td>

</td>
<td align="center"><span id="_24.1" style="font-weight:bold; font-family:Times New Roman; font-size:24.1px; color:#000000">DIVINE CENTRE</span><br />
<span id="_24.1" style="font-weight:bold; font-family:Times New Roman; font-size:24.1px; color:#000000">
1/65, Bhoosamandi, Kanpur Road, <br />
Fatehgarh, Farrukhabad - 209601 (U.P.)</span>

</div><br />
<span id="_12.1" style="font-weight:bold; font-family:Times New Roman; font-size:12.1px; color:#000000">
Phone : +91-9648506121</span>
</div>
</td>
</tr>
</table>
<hr color="#000000">

<div align="center" style="font-size:16px;"><u><strong>BILL</strong>&nbsp;<strong>Details</strong></u></div>
<br /><br />
<table border="1" cellpadding="10" cellspacing="0" width="100%" style="border-collapse:collapse;" align="center">

<tr>
<td width="20%" style="font-size:12px; font-weight:bold;">BILL NUMBER</td>
<td width="30%" style="font-size:12px;"><?php echo $r['id']; ?></td>
<td width="20%" style="font-size:12px; font-weight:bold;">BILL TYPE</td>
<td width="15%" style="font-size:12px;"><?php echo $bill_type; ?> - <?php echo $bill_typenumber; ?></td>

</tr>
<tr>
<td width="20%" style="font-size:12px; font-weight:bold;">UHID / PATIENT'S NAME</td>
<td width="15%" style="font-size:12px;"><?php echo hms_uhid($pid); ?> / <?php echo $pinfo['pat_name']; ?></td>
<td width="20%" style="font-size:12px; font-weight:bold;">BILL DATE</td>
<td width="30%" style="font-size:12px;"><?php echo $date1[0]; ?></td>
</tr>
<tr>
<td width="20%" style="font-size:12px; font-weight:bold;">ADDRESS</td>
<td width="15%" style="font-size:12px;"><?php echo $pinfo['address']; ?></td>
<td width="20%" style="font-size:12px; font-weight:bold;">AGE / SEX</td><td width="30%" style="font-size:12px;"><?php echo $pinfo['age']; ?>&nbsp;Years&nbsp;<?php if($pinfo['agemonths'] != '0') { ?> - <?php echo $pinfo['agemonths']; ?>&nbsp;Months <?php } ?>/&nbsp;<?php echo $pinfo['sex']; ?></td>
</tr>
</table>
<br />
<p><?php echo $message; ?></p>
<p align="right"><strong>Thanks</strong><br />
Divine Centre</p>
</body>
</html>
