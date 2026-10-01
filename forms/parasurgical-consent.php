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
<title>CONSENT FOR PARASURGICAL PROCEDURE</title>
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
<div align="center" style="font-size:16px;"><STRONG><u>CONSENT FOR PARASURGICAL PROCEDURE</u></STRONG>
</div>
<br />
<table border="1" cellpadding="10" cellspacing="0" width="100%" style="border-collapse:collapse;" align="center">

<tr>
<td width="8%" style="font-size:12px; font-weight:bold;">UHID</td><td width="15%" style="font-size:12px;"><?php echo $l_uhid; ?></td><td width="20%" style="font-size:12px; font-weight:bold;">NAME OF THE PATIENT</td><td width="30%" style="font-size:12px;"><?php echo $pat['pat_name']; ?><td width="8%" style="font-size:12px; font-weight:bold;">AGE / SEX</td><td width="15%" style="font-size:12px;"><?php echo $pat['age']; ?>&nbsp;Years / <?php echo $pat['sex']; ?></td>
</tr>
<tr>
<td width="8%" style="font-size:12px; font-weight:bold;">IPD NO.</td><td width="15%" style="font-size:12px;"></td><td width="20%" style="font-size:12px; font-weight:bold;">FATHER / HUSBAND's NAME</td><td width="30%" colspan="3" style="font-size:12px;"><?php echo $pat['fat_name']; ?></td>
</tr>

</table>

<div class="pos" id="_62:403" style="top:350;left:40">
<img src="para-consent.jpg" /><br /><img src="para-consent-2.jpg" /></div>
</div>

</body>
</html>
