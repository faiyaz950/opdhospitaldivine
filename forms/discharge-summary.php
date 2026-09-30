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
<title>Discharge Summary</title>
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
<div align="center" style="font-size:16px;"><STRONG><u>DISCHARGE SUMMARY</u></STRONG>
</div>
<br />
<table border="1" cellpadding="10" cellspacing="0" width="100%" style="border-collapse:collapse;" align="center">

<tr>
<td width="8%" style="font-size:12px; font-weight:bold;">UHID</td><td width="15%" style="font-size:12px;"><?php echo $l_uhid; ?><?php echo $pat['id']; ?></td><td width="20%" style="font-size:12px; font-weight:bold;">NAME OF THE PATIENT</td><td width="30%" style="font-size:12px;"><?php echo $pat['pat_name']; ?><td width="8%" style="font-size:12px; font-weight:bold;">AGE</td><td width="15%" style="font-size:12px;"><?php echo $pat['age']; ?>&nbsp;Years</td>
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
<div class="pos" id="_62:403" style="top:390;left:62">
<span id="_14.6" style="font-weight:bold; font-family:Arial; font-size:14.6px; color:#000000">
<u>Course in the Hospital:</u></span>
</div>
<div class="pos" id="_62:565" style="top:540;left:62">
<span id="_14.6" style="font-weight:bold; font-family:Arial; font-size:14.6px; color:#000000">
<U>K</U><U>e</U><U>y</U><U> </U><U>I</U><U>n</U><U>v</U><U>e</U><U>s</U><U>t</U><U>i</U><U>g</U><U>a</U><U>t</U><U>i</U><U>o</U><U>n</U><U>s</U><U> </U><U>a</U><U>n</U><U>d</U><U> </U><U>F</U><U>i</U><U>n</U><U>d</U><U>i</U><U>n</U><U>g</U><U>s</U><U> </U><U>(</U><U>d</U><U>u</U><U>r</U><U>i</U><U>n</U><U>g</U><U> </U><U>s</U><U>t</U><U>a</U><U>y</U><U>)</U><U>:</U></span>
</div>
<div class="pos" id="_62:626" style="top:610;left:62">
<span id="_14.6" style="font-weight:bold; font-family:Arial; font-size:14.6px; color:#000000">
<U>C</U><U>o</U><U>n</U><U>d</U><U>i</U><U>t</U><U>i</U><U>o</U><U>n</U><U> </U><U>a</U><U>t</U><U> </U><U>t</U><U>h</U><U>e</U><U> </U><U>t</U><U>i</U><U>m</U><U>e</U><U> </U><U>D</U><U>i</U><U>s</U><U>c</U><U>h</U><U>a</U><U>r</U><U>g</U><U>e</U><U>:</U></span>
</div>
<div class="pos" id="_62:667" style="top:650;left:62">
<span id="_14.6" style="font-weight:bold; font-family:Arial; font-size:14.6px; color:#000000">
<u>Discharge Medications:</u></span>
</div>
<div class="pos" id="_62:850" style="top:750;left:62">
<span id="_14.6" style="font-weight:bold; font-family:Arial; font-size:14.6px; color:#000000">
<u>Follow-up Advice and Instructions:</u></span>
</div>
<div class="pos" id="_62:931" style="top:850;left:62">
<span id="_15.2" style="font-weight:bold; font-family:Arial; font-size:15.2px; color:#000000">
Name of Doctor:</span>
</div>
<div class="pos" id="_659:931" style="top:850;left:600">
<span id="_16.3" style="font-weight:bold; font-family:Arial; font-size:16.3px; color:#000000">
Date:</span>
</div>
<div class="pos" id="_62:972" style="top:900;left:62">
<span id="_14.8" style="font-weight:bold; font-family:Arial; font-size:14.8px; color:#000000">
Signature:</span>
</div>
<div class="pos" id="_662:972" style="top:900;left:600">
<span id="_16.3" style="font-weight:bold; font-family:Arial; font-size:16.3px; color:#000000">
Time:</span>
</div>
<div class="pos" id="_62:1033" style="top:950;left:62">
<span id="_15.1" style="font-weight:bold; font-family:Arial; font-size:15.1px; color:#000000">
<U>I</U><U>n</U><U> </U><U>c</U><U>a</U><U>s</U><U>e</U><U> </U><U>o</U><U>f</U><U> </U><U>a</U><U>n</U><U>y</U><U> </U><U>e</U><U>m</U><U>e</U><U>r</U><U>g</U><U>e</U><U>n</U><U>c</U><U>y</U><U>,</U><U> </U><U>c</U><U>o</U><U>n</U><U>t</U><U>a</U><U>c</U><U>t</U><U> </U><U>N</U><U>u</U><U>m</U><U>b</U><U>e</U><U>r</U><U> </U><U>o</U><U>f</U><U> </U><U>H</U><U>o</U><U>s</U><U>p</U><U>i</U><U>t</U><U>a</U><U>l</U><U> </U><U>(</U><U>0</U><U>5</U><U>6</U><U>9</U><U>2</U><U>-</U><U>2</U><U>3</U><U>2</U><U>4</U><U>5</U><U>7</U><U>9</U><U>)</U></span>
</div>
</nowrap></nobr>
</body>
</html>
