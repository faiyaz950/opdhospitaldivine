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
<title>PAIN ASSESSMENT AND RE ASSESSMENT FORM</title>
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
<div align="center" style="font-size:16px;"><STRONG><u>PAIN ASSESSMENT AND RE ASSESSMENT FORM</u></STRONG>
</div>
<br />
<table border="1" cellpadding="10" cellspacing="0" width="100%" style="border-collapse:collapse;" align="center">

<tr>
<td width="8%" style="font-size:12px; font-weight:bold;">UHID</td><td width="15%" style="font-size:12px;"><?php echo $l_uhid; ?><?php echo $pat['id']; ?></td><td width="20%" style="font-size:12px; font-weight:bold;">NAME OF THE PATIENT</td><td width="30%" style="font-size:12px;"><?php echo $pat['pat_name']; ?><td width="8%" style="font-size:12px; font-weight:bold;">AGE / SEX</td><td width="15%" style="font-size:12px;"><?php echo $pat['age']; ?>&nbsp;Years / <?php echo $pat['sex']; ?></td>
</tr>
<tr>
<td width="8%" style="font-size:12px; font-weight:bold;">IPD NO.</td><td width="15%" style="font-size:12px;"></td><td width="20%" style="font-size:12px; font-weight:bold;">DIAGNOSIS</td><td width="30%" colspan="3"></td>
</tr>

</table>


<div class="pos" id="_62:362" style="top:350;left:62">
<span id="_14.6" style="font-weight:bold; font-family:Arial; font-size:14.6px; color:#000000">
<u>PAIN SCALE:</u></span>
</div>

<div class="pos" id="_62:403" style="top:390;left:62">
<img src="pain-scale.jpg" /></div>
<div class="pos" id="_62:565" style="top:540;left:40">
<table border="1" cellpadding="5" cellspacing="0" width="100%" style="border-collapse:collapse;" align="center">
<tr>
<td width="10%" style="font-size:12px; font-weight:bold;">S.No.</td><td width="15%" style="font-size:12px; font-weight:bold;">Date</td><td width="15%" style="font-size:12px; font-weight:bold;">M / E / N</td><td width="15%" style="font-size:12px; font-weight:bold;">Pain Score</td><td width="15%" style="font-size:12px; font-weight:bold;">Remarks(If any)</td><td width="15%" style="font-size:12px; font-weight:bold;">Signature</td>
</tr>
<tr>
<td width="10%" style="font-size:12px;">1</td><td width="20%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td>
</tr>
<tr>
<td width="10%" style="font-size:12px;">2</td><td width="20%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td>
</tr>
<tr>
<td width="10%" style="font-size:12px;">3</td><td width="20%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td>
</tr>
<tr>
<td width="10%" style="font-size:12px;">4</td><td width="20%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td>
</tr>
<tr>
<td width="10%" style="font-size:12px;">5</td><td width="20%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td>
</tr>
<tr>
<td width="10%" style="font-size:12px;">6</td><td width="20%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td>
</tr>
<tr>
<td width="10%" style="font-size:12px;">7</td><td width="20%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td>
</tr>
<tr>
<td width="10%" style="font-size:12px;">8</td><td width="20%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td>
</tr>
<tr>
<td width="10%" style="font-size:12px;">9</td><td width="20%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td>
</tr>
<tr>
<td width="10%" style="font-size:12px;">10</td><td width="20%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td>
</tr>
<tr>
<td width="10%" style="font-size:12px;">11</td><td width="20%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td>
</tr>
<tr>
<td width="10%" style="font-size:12px;">12</td><td width="20%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td>
</tr>
<tr>
<td width="10%" style="font-size:12px;">13</td><td width="20%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td>
</tr>
<tr>
<td width="10%" style="font-size:12px;">14</td><td width="20%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td>
</tr>
<tr>
<td width="10%" style="font-size:12px;">15</td><td width="20%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td><td width="15%" style="font-size:12px;"></td>
</tr>

</table>
</div>

</body>
</html>
