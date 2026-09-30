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

$c = $_REQUEST['c'];
$sq = mysql_query("select * from patient_mst where id = '$c'");
$pat = mysql_fetch_array($sq);
$su = mysql_query("select * from param_mst where type='uid_pformat'");
$su1 = mysql_fetch_array($su);
$l_uhid = $su1['last_value'];

?>

<html>
<head>
<title>COST ESTIMATE FORM </title>
<style type="text/css">
<!--
body { font-family: Arial; font-size: 17.5px }
.pos { position: absolute; z-index: 0; left: 0px; top: 0px }
-->
</style>
</head>
<body>
<table>
<tr>
<td>
<img src="logo.png" />
</td>
<td align="center"><span id="_24.1" style="font-weight:bold; font-family:Times New Roman; font-size:24.1px; color:#000000">SHRI BABU SINGH JAY SINGH AYURVEDIC</span><br />
<span id="_24.1" style="font-weight:bold; font-family:Times New Roman; font-size:24.1px; color:#000000">
MEDICAL COLLEGE & HOSPITAL</span>
</div><br />
<span id="_12.1" style="font-weight:bold; font-family:Times New Roman; font-size:12.1px; color:#000000">
BHAUPUR, BEWAR ROAD FATEHGARH ,FARRUKHABAD-(U.P.) 209602</span>
</div>
</td>
</tr>
</table>
<hr color="#000000">

<div align="center" style="font-size:16px;"><STRONG><u>COST ESTIMATE FORM</u></STRONG>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:14px;">Date</span>
</div>
<br />
<table border="1" cellpadding="10" cellspacing="0" width="100%" style="border-collapse:collapse;" align="center">

<tr>
<td width="8%" style="font-size:12px; font-weight:bold;">UHID</td><td width="15%" style="font-size:12px;"><?php echo $l_uhid; ?><?php echo $pat['id']; ?></td><td width="20%" style="font-size:12px; font-weight:bold;">NAME OF THE PATIENT</td><td width="30%" style="font-size:12px;"><?php echo $pat['pat_name']; ?></td>
</tr>
<tr>
<td width="8%" style="font-size:12px; font-weight:bold;">IPD NO.</td><td width="15%"></td><td width="20%" style="font-size:12px; font-weight:bold;">NAME OF CONSULTANT</td><td width="30%"></td>
</tr>
<tr>
<td width="8%" style="font-size:12px; font-weight:bold;">AGE</td><td width="15%" style="font-size:12px;"><?php echo $pat['age']; ?>&nbsp;Years</td><td width="20%" style="font-size:12px; font-weight:bold;">REMARKS OF CONSULTANT (IF ANY)</td><td width="30%"></td>
</tr>
<tr>
<td width="8%" style="font-size:12px; font-weight:bold;">SEX</td><td width="15%" style="font-size:12px;"><?php echo $pat['sex']; ?></td><td width="20%" style="font-size:12px; font-weight:bold;">NAME OF THE ATTENDANT</td><td width="30%"></td>
</tr>
</table>
<br />
<div align="center" style="font-size:14px;"><STRONG><u>ESTIMATED COST OF TREATMENT:-</u></STRONG>
</div>
<br />
<table border="1" cellpadding="5" cellspacing="0" width="100%" style="border-collapse:collapse;" align="center">
<tr>
<td width="10%" style="font-size:12px; font-weight:bold;">S.No.</td><td width="20%" style="font-size:12px; font-weight:bold;">Name of Services</td><td width="70%" style="font-size:12px; font-weight:bold;">Charges</td>
</tr>
<tr>
<td width="10%" style="font-size:12px;">1</td><td width="20%" style="font-size:12px;">Bed Charges</td><td width="70%" style="font-size:12px;"></td>
</tr>
<tr>
<td width="10%" style="font-size:12px;">2</td><td width="20%" style="font-size:12px;">Nursing Charges</td><td width="70%" style="font-size:12px;"></td>
</tr>
<tr>
<td width="10%" style="font-size:12px;">3</td><td width="20%" style="font-size:12px;">Procedures</td><td width="70%" style="font-size:12px;"></td>
</tr>
<tr>
<td width="10%" style="font-size:12px;">4</td><td width="20%" style="font-size:12px;">Consultancy Charges</td><td width="70%" style="font-size:12px;"></td>
</tr>
<tr>
<td width="10%" style="font-size:12px;">5</td><td width="20%" style="font-size:12px;">Cross Consultation Charges</td><td width="70%" style="font-size:12px;"></td>
</tr>
<tr>
<td width="10%" style="font-size:12px;">6</td><td width="20%" style="font-size:12px;">Para Surgical Charges</td><td width="70%" style="font-size:12px;"></td>
</tr>
<tr>
<td width="10%" style="font-size:12px;">7</td><td width="20%" style="font-size:12px;">Panchkarma </td><td width="70%" style="font-size:12px;"></td>
</tr>
<tr>
<td width="10%" style="font-size:12px;">8</td><td width="20%" style="font-size:12px;">Misc.</td><td width="70%" style="font-size:12px;"></td>
</tr>
<tr>
<td width="10%" style="font-size:12px;">9</td><td width="20%" style="font-size:12px;">Total Estimated Cost </td><td width="70%" style="font-size:12px;"></td>
</tr>


</table>

<div class="pos" id="_57:759" style="top:660;">
<span id="_11.0" style=" font-family:Arial; font-size:11.0px; color:#000000">
* ABOVE MENTIONED CHARGES ARE ONLY ESTIMATED AND ACTUAL BILL MAY DIFFER AND MAY BE IN PLUS OR MINUS SIDE OF THE ESTIMATED COST.</span>
</div>
<div class="pos" id="_57:759" style="top:690;left:45%">
<span id="_10.8" style="font-weight:bold; font-family:Arial; font-size:10.8px; color:#000000">
COUNSELOR'S</span>
</div>
<div class="pos" id="_305:821" style="top:720;left:40%">
<span id="_10.8" style="font-weight:bold; font-family:Arial; font-size:10.8px; color:#000000">
<u>SIGNATUREPATIENT'S/ATTENDANT'S DECLARATION</u></span>
</div>
<div class="pos" id="_56:852" style="top:740;">
<span id="_11.4" style="font-weight:bold; font-family:Arial; font-size:11.4px; color:#000000">
I&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;&#8230;...................................................... HEREBY DECLARE THAT I WILL BE LIABLE TO PAY THE TOTAL CHARGES FOR TOTAL STAY, AS ESTIMATED ABOVE AMICABLY TO THE HOSPITAL. I ALSO AGREE & UNDERSTAND THAT THE ABOVE MENTIONED CHARGES ARE ONLY ESTIMATED AND ACTUAL BILL MAY DIFFER AND MAY BEIN PLUS OR MINUS SIDE OF THE ESTIMATION.</span>
</div>
<div class="pos" id="_598:928" style="top:800;left:80%">
<span id="_10.9" style="font-weight:bold; font-family:Arial; font-size:10.9px; color:#000000">
ATTENDANT'S SIGNATURE</span>
</div>
<br>
<div class="pos" id="_598:928" style="top:830;">
<table border="1" cellpadding="10" cellspacing="0" width="100%" style="border-collapse:collapse;" align="center">
<tr>
<td width="20%" style="font-size:12px; font-weight:bold;">BILLING INCHARGE:</td><td width="40%"></td><td width="20%" style="font-size:12px; font-weight:bold;">ADVANCE AMOUNT:</td><td width="40%"></td>
</tr>
<tr>
<td width="20%" style="font-size:12px; font-weight:bold;">REMARKS IF ANY:</td><td width="80%" colspan="3"></td>
</tr>
<tr>
<td width="20%" style="font-size:12px; font-weight:bold;">SIGNATURE OF BILLING HEAD:</td><td width="40%"></td><td width="20%" style="font-size:12px; font-weight:bold;">DATE:</td><td width="40%"></td>
</tr>

</table>
</div>
</body>
</html>
