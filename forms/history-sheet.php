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
$l_uhid = hms_uhid_prefix($pat['id']);

?>

<html>
<head>
<title>HISTORY SHEET</title>
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

<div align="center" style="font-size:16px;"><STRONG><u>HISTORY SHEET</u></STRONG>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:14px;">Date</span>
</div>
<br />
<table border="1" cellpadding="10" cellspacing="0" width="100%" style="border-collapse:collapse;" align="center">

<tr>
<td width="8%" style="font-size:12px; font-weight:bold;">UHID</td><td width="15%" style="font-size:12px;"><?php echo $l_uhid; ?><?php echo $pat['id']; ?></td><td width="20%" style="font-size:12px; font-weight:bold;">NAME OF THE PATIENT</td><td width="30%" style="font-size:12px;"><?php echo $pat['pat_name']; ?></td>
</tr>
<tr>
<td width="8%" style="font-size:12px; font-weight:bold;">IPD NO.</td><td width="15%"></td><td width="20%" style="font-size:12px; font-weight:bold;">FATHER/HUSBAND's NAME</td><td width="30%" style="font-size:12px;"><?php echo $pat['fat_name']; ?></td>
</tr>
<tr>
<td width="20%" style="font-size:12px; font-weight:bold;">DEPARTMENT</td><td width="30%"></td><td width="8%" style="font-size:12px; font-weight:bold;">AGE / SEX</td><td width="15%" style="font-size:12px;"><?php echo $pat['age']; ?>&nbsp;Years&nbsp;/&nbsp;<?php echo $pat['sex']; ?></td>
</tr>
<tr>
<td width="8%" style="font-size:12px; font-weight:bold;">ADDRESS</td><td width="15%" style="font-size:12px;"><?php echo $pat['address']; ?>,&nbsp;<?php echo $pat['city']; ?></td><td width="20%" style="font-size:12px; font-weight:bold;">DOA / DOD</td><td width="30%"></td>
</tr>
</table>
<br />
<div class="pos" id="_62:362" style="top:350;left:62">
<span id="_14.6" style="font-weight:bold; font-family:Arial; font-size:14.6px; color:#000000">
<u>ALLERGY IF ANY:</u></span>
</div>
<div class="pos" id="_62:403" style="top:440;left:62">
<span id="_14.6" style="font-weight:bold; font-family:Arial; font-size:14.6px; color:#000000">
<u>PAIN ASSESMENT:</u></span><br /><br />
<span style="font-weight:bold; font-family:Arial; font-size:14px; color:#000000">Characteristic ----------------------------------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Site --------------------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Duration-------------</span>
</div>

<div class="pos" id="_62:565" style="top:540;left:62">
<span id="_14.6" style="font-weight:bold; font-family:Arial; font-size:14.6px; color:#000000"><u>CHIEF COMPLAINTS :</u></span>
</div>
<div class="pos" id="_62:626" style="top:670;left:62">
<span id="_14.6" style="font-weight:bold; font-family:Arial; font-size:14.6px; color:#000000"><U>PRESENT HISTORY:</U></span>
</div>
<div class="pos" id="_62:626" style="top:770;left:62">
<span id="_14.6" style="font-weight:bold; font-family:Arial; font-size:14.6px; color:#000000"><U>PAST HISTORY:</U></span>
</div>
<div class="pos" id="_62:626" style="top:870;left:62">
<span id="_14.6" style="font-weight:bold; font-family:Arial; font-size:14.6px; color:#000000"><U>PERSONAL HISTORY:</U></span>
</div>
<div class="pos" id="_62:626" style="top:970;left:62">
<span id="_14.6" style="font-weight:bold; font-family:Arial; font-size:14.6px; color:#000000"><U>FAMILY HISTORY:</U></span>
</div>
<div class="pos" id="_62:626" style="top:1070;left:62">
<span id="_14.6" style="font-weight:bold; font-family:Arial; font-size:14.6px; color:#000000"><U>DIET ASSESSMENT:</U></span>
</div>
<div class="pos" id="_62:626" style="top:1170;left:62">
<span id="_14.6" style="font-weight:bold; font-family:Arial; font-size:14.6px; color:#000000"><U>PHYSICIAL EXAMINATATION:</U></span>
</div>
<div class="pos" id="_62:626" style="top:1200;left:62">
<table border="1" cellpadding="10" cellspacing="0" width="100%" style="border-collapse:collapse;" align="center">

<tr>
<td width="8%" style="font-size:12px; font-weight:bold;">NADI</td><td width="15%" style="font-size:12px;"></td><td width="20%" style="font-size:12px; font-weight:bold;">SHABDA</td><td width="30%" style="font-size:12px;"></td>
</tr>
<tr>
<td width="8%" style="font-size:12px; font-weight:bold;">MUTRA</td><td width="15%"></td><td width="20%" style="font-size:12px; font-weight:bold;">SPARSHA</td><td width="30%" style="font-size:12px;"></td>
</tr>
<tr>
<td width="20%" style="font-size:12px; font-weight:bold;">MALA</td><td width="30%"></td><td width="8%" style="font-size:12px; font-weight:bold;">DRUK</td><td width="15%" style="font-size:12px;"></td>
</tr>
<tr>
<td width="8%" style="font-size:12px; font-weight:bold;">JIHVA</td><td width="15%" style="font-size:12px;"></td><td width="20%" style="font-size:12px; font-weight:bold;">AAKRUTI</td><td width="30%"></td>
</tr>
</table></div>
<div class="pos" id="_62:626" style="top:1370;left:62">
<span id="_14.6" style="font-weight:bold; font-family:Arial; font-size:14.6px; color:#000000"><U>LOCAL EXAMINATATION:</U></span>
</div>
<div class="pos" id="_62:626" style="top:1470;left:62">
<span id="_14.6" style="font-weight:bold; font-family:Arial; font-size:14.6px; color:#000000"><U>LABORATORY INVESTIGATIONS:</U></span>
</div>
<div class="pos" id="_62:626" style="top:1570;left:62">
<span id="_14.6" style="font-weight:bold; font-family:Arial; font-size:14.6px; color:#000000"><U>PROVISIONAL DIAGNOSIS:</U></span>
</div>
<div class="pos" id="_62:626" style="top:1670;left:62">
<span id="_14.6" style="font-weight:bold; font-family:Arial; font-size:14.6px; color:#000000"><U>PLAN OF CARE:</U></span>
</div>
<div class="pos" id="_62:931" style="top:1800;left:62">
<span id="_15.2" style="font-weight:bold; font-family:Arial; font-size:15.2px; color:#000000">
Name of Doctor:</span>
</div>
<div class="pos" id="_659:931" style="top:1800;left:600">
<span id="_16.3" style="font-weight:bold; font-family:Arial; font-size:16.3px; color:#000000">
Date:</span>
</div>
<div class="pos" id="_62:972" style="top:1830;left:62">
<span id="_14.8" style="font-weight:bold; font-family:Arial; font-size:14.8px; color:#000000">
Signature:</span>
</div>
<div class="pos" id="_662:972" style="top:1830;left:600">
<span id="_16.3" style="font-weight:bold; font-family:Arial; font-size:16.3px; color:#000000">
Time:</span>
</div>

</body>
</html>
