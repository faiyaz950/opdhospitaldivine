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
<title>CONSULTANT REFERRAL FORM (INTERNAL)</title>
<style type="text/css">
<!--
body { font-family: Arial; font-size: 24.7px }
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
<div align="center" style="font-size:16px;"><STRONG><u>CONSULTANT REFERRAL FORM (INTERNAL)</u></STRONG>
</div>
<div class="pos" id="_31:288" style="top:288;left:31">
<span id="_15.4" style=" font-family:Times New Roman; font-size:15.4px; color:#000000">
<b>Patient&#8217;s Name:</b>&nbsp;<?php echo $pat['pat_name']; ?></span>
</div>
<div class="pos" id="_499:288" style="top:288;left:499">
<span id="_16.3" style=" font-family:Times New Roman; font-size:16.3px; color:#000000">
<b>UHID:</b>&nbsp;<?php echo $l_uhid; ?><?php echo $pat['id']; ?></span>
</div>
<div class="pos" id="_31:327" style="top:327;left:31">
<span id="_16.3" style=" font-family:Times New Roman; font-size:16.3px; color:#000000">
<b>Age:</b>&nbsp;<?php echo $pat['age']; ?>&nbsp;Years</span>
</div>
<div class="pos" id="_499:327" style="top:327;left:499">
<span id="_16.3" style=" font-family:Times New Roman; font-size:16.3px; color:#000000">
<b>DOA:</b></span>
</div>
<div class="pos" id="_31:363" style="top:363;left:31">
<span id="_16.3" style=" font-family:Times New Roman; font-size:16.3px; color:#000000">
<b>Sex:</b>&nbsp;<?php echo $pat['sex']; ?></span>
</div>
<div class="pos" id="_499:363" style="top:363;left:499">
<span id="_16.3" style=" font-family:Times New Roman; font-size:16.3px; color:#000000">
<b>IPD:</b></span>
</div>
<div class="pos" id="_31:399" style="top:399;left:31">
<span id="_16.3" style=" font-family:Times New Roman; font-size:16.3px; color:#000000">
<b>Primary Consultant:</b></span>
</div>
<div class="pos" id="_499:399" style="top:399;left:499">
<span id="_16.3" style=" font-family:Times New Roman; font-size:16.3px; color:#000000">
<b>Date Referred:</b></span>
</div>
<div class="pos" id="_31:471" style="top:471;left:31">
<span id="_16.3" style=" font-family:Times New Roman; font-size:16.3px; color:#000000">
<b>Provisional Diagnosis:</b></span>
</div>
<div class="pos" id="_31:542" style="top:542;left:31">
<span id="_16.3" style=" font-family:Times New Roman; font-size:16.3px; color:#000000">
<b>Refer to Dr:</b></span>
</div>
<div class="pos" id="_31:578" style="top:578;left:31">
<span id="_16.3" style=" font-family:Times New Roman; font-size:16.3px; color:#000000">
<b>Reason for referral:</b></span>
</div>
<div class="pos" id="_244:654" style="top:654;left:244">
<span id="_19.1" style="font-weight:bold; font-family:Times New Roman; font-size:19.1px; color:#000000">
<b></b></span>
</div>
<div class="pos" id="_579:1017" style="top:800;left:579">
<span id="_16.3" style=" font-family:Times New Roman; font-size:16.3px; color:#000000">
<b>Date:</b></span>
</div>
<div class="pos" id="_576:1050" style="top:850;left:576">
<span id="_16.3" style=" font-family:Times New Roman; font-size:16.3px; color:#000000">
<b>Time:</b></span>
</div>
</nowrap></nobr>
</body>
</html>
