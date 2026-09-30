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
<title>General Consent Form</title>
<style type="text/css">
<!--
body { font-family: Arial; font-size: 22.6px }
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

<div align="center" style="font-size:16px;"><STRONG><u>PATIENT REGISTRATION FORM</u></STRONG>
</div>
<div class="pos" id="_100:276" style="top:220;left:50">
<span id="_14.8" style=" font-family:Times New Roman; font-size:14.8px; color:#000000">
<b>DATE :</b> <?php echo date("d-m-Y"); ?></span>
</div>
<div class="pos" id="_100:311" style="top:300;left:50">
<span id="_14.8" style=" font-family:Times New Roman; font-size:14.8px; color:#000000">
<b>UHID :</b> <?php echo $l_uhid; ?><?php echo $pat['id']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>NAME :</b> Mr./Mrs./Miss <?php echo $pat['pat_name']; ?></span>
</div>
<div class="pos" id="_100:346" style="top:335;left:50">
<span id="_14.8" style=" font-family:Times New Roman; font-size:14.8px; color:#000000">
<b>Father&#8217;s Name/Husband&#8217;s Name : </b><?php echo $pat['fat_name']; ?></span>
</div>
<div class="pos" id="_100:381" style="top:370;left:50">
<span id="_14.8" style=" font-family:Times New Roman; font-size:14.8px; color:#000000">
<b>Date Of Birth : </b>----------------------,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Age : </b><?php echo $pat['age']; ?>&nbsp;Years,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Sex : </b><?php echo $pat['sex']; ?></span>
</div>
<div class="pos" id="_100:416" style="top:405;left:50">
<span id="_14.8" style=" font-family:Times New Roman; font-size:14.8px; color:#000000">
<b>Residential Address : </b><?php echo $pat['address']; ?></span>
</div>
<div class="pos" id="_100:451" style="top:440;left:50">
<span id="_15.2" style=" font-family:Times New Roman; font-size:15.2px; color:#000000">
<b>Area : </b>--------------------------------<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong><b>District : </b><?php echo $pat['city']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
</div>
<div class="pos" id="_100:486" style="top:475;left:50">
<span id="_15.2" style=" font-family:Times New Roman; font-size:15.2px; color:#000000">
 <b>State :</b>-----------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Country : </b>----------------&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Pin Code : </b>----------</span>
</div>
<div class="pos" id="_100:522" style="top:511;left:50">
<span id="_15.2" style=" font-family:Times New Roman; font-size:15.2px; color:#000000">
<b>Tel.No.(R) : </b>------------------ &nbsp;&nbsp;&nbsp;<b>(O) : </b>---------------------&nbsp;&nbsp;&nbsp;<b>Mobile No :</b>---------------</span>
</div>
<div class="pos" id="_100:557" style="top:546;left:50">
<span id="_15.2" style=" font-family:Times New Roman; font-size:15.2px; color:#000000">
In Emergency person to be notified <b>Mr./Mrs./Miss : </b>----------------------------<b>Mob No :</b>--------------</span>
</div>
<div class="pos" id="_335:632" style="top:615;left:335">
<div align="center" style="font-size:16px;"><STRONG><u>GENERAL CONSENT</u></STRONG>
</div>
</div>
<div class="pos" id="_100:694" style="top:650;left:50">
<span id="_16.2" style=" font-family:Times New Roman; font-size:16.2px; color:#000000">
The undersigned patient and/or responsible relative or person here by consent to and authorize</span>
</div>
<div class="pos" id="_100:716" style="top:670;left:50">
<span id="_17.5" style="font-weight:bold; font-family:Times New Roman; font-size:17.5px; color:#000000">
SBSJSAMC Hospital&#8217;s<span id="_16.2" style="font-weight:normal; font-size:16.2px"> physicians</span><span id="_16.2" style="font-weight:normal; font-size:16.2px"> and</span><span id="_16.2" style="font-weight:normal; font-size:16.2px"> medical</span><span id="_16.2" style="font-weight:normal; font-size:16.2px"> professionals</span><span id="_16.2" style="font-weight:normal; font-size:16.2px"> to</span><span id="_16.2" style="font-weight:normal; font-size:16.2px"> administer</span><span id="_16.2" style="font-weight:normal; font-size:16.2px"> and</span><span id="_16.2" style="font-weight:normal; font-size:16.2px"> perform</span></span>
</div>
<div class="pos" id="_100:740" style="top:690;left:50">
<span id="_16.2" style=" font-family:Times New Roman; font-size:16.2px; color:#000000">
Medical examination, routine investigations, medical treatments, out patient procedures, general</span>
</div>
<div class="pos" id="_100:762" style="top:710;left:50">
<span id="_16.2" style=" font-family:Times New Roman; font-size:16.2px; color:#000000">
Nursing care, diet and physiotherapy assessment during the patient&#8217;s care as an out patient,</span>
</div>
<div class="pos" id="_100:784" style="top:730;left:50">
<span id="_16.2" style=" font-family:Times New Roman; font-size:16.2px; color:#000000">
indoor admission be deemed visible or necessary.</span>
</div>
<div class="pos" id="_100:806" style="top:760;left:50">
<span id="_16.2" style=" font-family:Times New Roman; font-size:16.2px; color:#000000">
The undersigned also consent to the hospital to use of medical information for insurance</span>
</div>
<div class="pos" id="_100:828" style="top:780;left:50">
<span id="_16.2" style=" font-family:Times New Roman; font-size:16.2px; color:#000000">
coverage and contacting him or her by telephone if needed regarding appointments and follow-</span>
</div>
<div class="pos" id="_100:850" style="top:800;left:50">
<span id="_16.2" style=" font-family:Times New Roman; font-size:16.2px; color:#000000">
up needs.</span>
</div>
<div class="pos" id="_100:894" style="top:840;left:50">
<span id="_16.2" style=" font-family:Times New Roman; font-size:16.2px; color:#000000">
<b>DATE :</b></span>
</div>
<div class="pos" id="_100:916" style="top:860;left:50">
<span id="_16.2" style=" font-family:Times New Roman; font-size:16.2px; color:#000000">
<b>TIME :</b></span>
</div>
<div class="pos" id="_378:916" style="top:840;left:378">
<span id="_16.2" style="font-weight:bold; font-family:Times New Roman; font-size:16.2px; color:#000000">
SIGNATURE OF PATIENT/ATTENDANT</span>
</div>
<div class="pos" id="_391:1048" style="top:900;left:391">
<span id="_16.2" style="font-weight:bold; font-family:Times New Roman; font-size:16.2px; color:#000000">
SIGNATURE OF ATTENDING STAFF</span>
</div>
</nowrap></nobr>
</body>
</html>
