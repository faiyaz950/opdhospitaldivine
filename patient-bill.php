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
	
	$pat_id = $_POST['pat_id'];

	$su = mysql_query("select * from param_mst where type='uid_pformat'");
	$su1 = mysql_fetch_array($su);
	$l_uhid = $su1['last_value'];
	
					$psq = mysql_query("select * from patient_mst where id = '$pat_id'");
				$psq1 = mysql_fetch_array($psq);
				$pat_name = $psq1['pat_name'];
				$age = $psq1['age'];
				$address = $psq1['address'];
				$mobile_no = $psq1['mobile_no'];
				$refer = $psq1['refer'];
				
				$docs_list = mysql_query("select * from doctor_mst where id='$refer'");
                $doc_name = mysql_fetch_array($docs_list);
                $referby = $doc_name['doc_name'];

	
	
    $date1 = $_POST['date1'];	

$sql = mysql_query("select * from billing_mst where pat_id = '$pat_id' and create_date='$date1'");
$sql1 = mysql_query("select * from patient_mst where id = '$pat_id'");
$r1 = mysql_fetch_array($sql1);
$t1 = mysql_query("select * from billing_mst where pat_id = '$pat_id' and create_date='$date1' limit 0,1");
$t2 = mysql_fetch_array($t1);
?>

<html>
<head>
<title>Patient Bill | DIVINE HEALTH CARE</title>
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

<div align="center" style="font-size:16px;"><u><strong>BILL Details</strong></u></div>
<br />
<div align="right"><strong>Bill Number :</strong> <?php echo $t2['bill_id']; ?>&nbsp;&nbsp;|&nbsp;&nbsp;<strong>Date :</strong> <?php echo $date1; ?></div>
<br />
<table border="1" cellpadding="10" cellspacing="0" width="100%" style="border-collapse:collapse;" align="center">


<tr>
<td width="20%" style="font-size:12px; font-weight:bold;">UHID / PATIENT'S NAME</td>
<td width="15%" style="font-size:12px;"><?php echo $l_uhid.$pat_id; ?> / <?php echo $r1['pat_name']; ?></td>
<td width="20%" style="font-size:12px; font-weight:bold;">AGE</td><td width="30%" style="font-size:12px;"><?php echo $r1['age']; ?>&nbsp;Years&nbsp;<?php if($r1['agemonths'] != '0') { ?> - <?php echo $r1['agemonths']; ?>&nbsp;Months <?php } ?></td>
</tr>
<tr>
<td width="20%" style="font-size:12px; font-weight:bold;">ADDRESS</td>
<td width="15%" style="font-size:12px;"><?php echo $r1['address']; ?></td>
<td width="20%" style="font-size:12px; font-weight:bold;">SEX</td><td width="30%" style="font-size:12px;"><?php echo $r1['sex']; ?></td>
</tr>
</table>

<br />

<table border="1" cellpadding="10" cellspacing="0" width="100%" style="border-collapse:collapse;" align="center">
<tr><th align="left" style="font-size:12px;">Sr. No.</th><th align="left" style="font-size:12px;">Details</th><th align="left" style="font-size:12px;">Amount</th></tr>
<?php
$i = 1;
$total_amount = 0;
while($r=mysql_fetch_array($sql))
{
$bill_type = $r['bill_type'];
$bill_number = $r['bill_typenumber'];
$amount= $r['bill_amount'];
if($bill_type == 'OPD')
{
?>
<tr><td style="font-size:12px;"><?php echo $i; ?></td><td style="font-size:12px;">OPD - ENT Department</td><td style="font-size:12px;"><?php echo $amount; ?></td></tr>
<?php
}
elseif($bill_type == 'IPD')
{
$t = mysql_query("select * from patipd_mst where id = '$bill_number'");
$u = mysql_fetch_array($t);
$report_id = $u['rid'];
$v = mysql_query("select * from ipd_mst where id = '$report_id'");
$w = mysql_fetch_array($v);
$report_name = $w['rep_name'];
?>
<tr><td style="font-size:12px;"><?php echo $i; ?></td><td style="font-size:12px;"><?php echo $report_name; ?></td><td style="font-size:12px;"><?php echo $amount; ?></td></tr>
<?php
}
elseif($bill_type == 'Investigation')
{
$t = mysql_query("select * from investigate_mst where id = '$bill_number'");
$u = mysql_fetch_array($t);
$report_id = $u['rid'];
$v = mysql_query("select * from report_mst where id = '$report_id'");
$w = mysql_fetch_array($v);
$report_name = $w['rep_name'];
?>
<tr><td style="font-size:12px;"><?php echo $i; ?></td><td style="font-size:12px;"><?php echo $report_name; ?></td><td style="font-size:12px;"><?php echo $amount; ?></td></tr>
<?php
}
$i = $i+1;
$total_amount = $total_amount + $amount; 
}
?>
<tr><td colspan="5" align="center"><strong>Total Amount :</strong> Rs. <?php echo $total_amount; ?></td></tr>
</table>
<p><?php echo $message; ?></p>
<p align="right"><strong>Thanks</strong><br />
Divine Centre</p>
</body>
</html>
