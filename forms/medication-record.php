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
<title>Medication Administration Record</title>
<style type="text/css">
<!--
body { font-family: Arial; font-size: 23.7px }
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
<br />
<div align="center" style="font-size:16px;"><STRONG><u>MEDICATION ADMINISTRATION RECORD</u></STRONG>
</div>
<br />
<table border="1" cellpadding="10" cellspacing="0" width="100%" style="border-collapse:collapse;" align="center">

<tr>
<td width="8%" style="font-size:12px; font-weight:bold;">UHID</td><td width="15%" style="font-size:12px;"><?php echo $l_uhid; ?><?php echo $pat['id']; ?></td><td width="20%" style="font-size:12px; font-weight:bold;">NAME OF THE PATIENT</td><td width="30%" style="font-size:12px;"><?php echo $pat['pat_name']; ?><td width="8%" style="font-size:12px; font-weight:bold;">AGE</td><td width="15%" style="font-size:12px;"><?php echo $pat['age']; ?>&nbsp;Years</td>
</tr>
<tr>
<td width="8%" style="font-size:12px; font-weight:bold;">SEX</td><td width="15%" style="font-size:12px;"><?php echo $pat['sex']; ?><td width="20%" style="font-size:12px; font-weight:bold;">DATE</td><td width="30%"></td><td width="8%" style="font-size:12px; font-weight:bold;">TIME</td><td width="15%" style="font-size:12px;"></td>
</tr>
</table>


<div class="pos" id="_62:362" style="top:350;">
<img src="medication-1.jpg" /><br /><img src="medication-2.jpg" />
</div>
<div class="pos" id="_62:931" style="top:1350;left:62">
<span id="_15.2" style="font-weight:bold; font-family:Arial; font-size:15.2px; color:#000000">
Name of Doctor / Nurse:</span>
</div>
<div class="pos" id="_62:972" style="top:1400;left:62">
<span id="_14.8" style="font-weight:bold; font-family:Arial; font-size:14.8px; color:#000000">
Signature:</span>
</div>

</nowrap></nobr>
</body>
</html>
