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
$l_uhid = hms_uhid($pat['id']);

?>
<html>
<head>
<title>Treatment Summary</title>
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
<div align="center" style="font-size:16px;"><STRONG><u>TREATMENT SUMMARY</u></STRONG>
</div>
<br />
<table border="1" cellpadding="10" cellspacing="0" width="100%" style="border-collapse:collapse;" align="center">

<tr>
<td width="8%" style="font-size:12px; font-weight:bold;">UHID</td><td width="15%" style="font-size:12px;"><?php echo $l_uhid; ?></td><td width="20%" style="font-size:12px; font-weight:bold;">NAME OF THE PATIENT</td><td width="30%" style="font-size:12px;"><?php echo $pat['pat_name']; ?><td width="8%" style="font-size:12px; font-weight:bold;">AGE</td><td width="15%" style="font-size:12px;"><?php echo $pat['age']; ?>&nbsp;Years</td>
</tr>
<tr>
<td width="8%" style="font-size:12px; font-weight:bold;">SEX</td><td width="15%" style="font-size:12px;"><?php echo $pat['sex']; ?><td width="20%" style="font-size:12px; font-weight:bold;">NAME OF DOCTOR</td><td width="30%"></td><td width="8%" style="font-size:12px; font-weight:bold;">Department</td><td width="15%" style="font-size:12px;"></td>
</tr>
<tr>
<td width="8%" style="font-size:12px; font-weight:bold;">IPD NO.</td><td width="15%" style="font-size:12px;"></td><td width="20%" style="font-size:12px; font-weight:bold;">DOA</td><td width="30%"></td><td width="8%" style="font-size:12px; font-weight:bold;">DOD</td><td width="15%" style="font-size:12px;"></td>
</tr>

</table>


<div class="pos" id="_62:362" style="top:350;left:62">
<span id="_14.6" style="font-weight:bold; font-family:Arial; font-size:14.6px; color:#000000">
<u>Final Diagnosis:</u></span>
</div>
<div class="pos" id="_62:403" style="top:430;left:62">
<span id="_14.6" style="font-weight:bold; font-family:Arial; font-size:14.6px; color:#000000">
<u>Course in the Hospital:</u></span>
</div>
<div class="pos" id="_62:565" style="top:540;left:62">
<span id="_14.6" style="font-weight:bold; font-family:Arial; font-size:14.6px; color:#000000">
<U>K</U><U>e</U><U>y</U><U> </U><U>I</U><U>n</U><U>v</U><U>e</U><U>s</U><U>t</U><U>i</U><U>g</U><U>a</U><U>t</U><U>i</U><U>o</U><U>n</U><U>s</U><U> </U><U>a</U><U>n</U><U>d</U><U> </U><U>F</U><U>i</U><U>n</U><U>d</U><U>i</U><U>n</U><U>g</U><U>s</U><U> </U><U>(</U><U>d</U><U>u</U><U>r</U><U>i</U><U>n</U><U>g</U><U> </U><U>s</U><U>t</U><U>a</U><U>y</U><U>)</U><U>:</U></span>
</div>
<div class="pos" id="_62:626" style="top:650;left:62">
<span id="_14.6" style="font-weight:bold; font-family:Arial; font-size:14.6px; color:#000000">
<U>Reason of Transfer</U></span>
</div>
<div class="pos" id="_62:667" style="top:740;left:62">
<span id="_14.6" style="font-weight:bold; font-family:Arial; font-size:14.6px; color:#000000">
<u>Condition at the time of Transfer:</u></span>
</div>
<div class="pos" id="_62:931" style="top:850;left:62">
<span id="_15.2" style="font-weight:bold; font-family:Arial; font-size:15.2px; color:#000000">
Name of Treating Doctor:</span>
</div>
<!--<div class="pos" id="_659:931" style="top:850;left:600">
<span id="_16.3" style="font-weight:bold; font-family:Arial; font-size:16.3px; color:#000000">
Date:</span>
</div>
--><div class="pos" id="_62:972" style="top:900;left:62">
<span id="_14.8" style="font-weight:bold; font-family:Arial; font-size:14.8px; color:#000000">
Signature:</span>
</div>
<!--<div class="pos" id="_662:972" style="top:900;left:600">
<span id="_16.3" style="font-weight:bold; font-family:Arial; font-size:16.3px; color:#000000">
Time:</span>
</div>
--><div class="pos" id="_62:972" style="top:950;left:62">
<span id="_14.8" style="font-weight:bold; font-family:Arial; font-size:14.8px; color:#000000">
Contact Number:</span>
</div>
</nowrap></nobr>
</body>
</html>
