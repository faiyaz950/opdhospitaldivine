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

$c = (int)$_REQUEST['c'];
$req_ipd_id = isset($_REQUEST['ipd_id']) ? (int)$_REQUEST['ipd_id'] : 0;

$sq = mysql_query("select * from patient_mst where id = '$c'");
$pat = mysql_fetch_array($sq);
if (!$pat && $req_ipd_id > 0) {
    $temp_ipd = mysql_fetch_array(mysql_query("select * from patipd_mst where id = '$req_ipd_id'"));
    if ($temp_ipd) {
        $c = (int)$temp_ipd['pid'];
        $sq = mysql_query("select * from patient_mst where id = '$c'");
        $pat = mysql_fetch_array($sq);
    }
}
$l_uhid = hms_uhid($pat['id']);

// IPD Details
$ipd_row = null;
if ($req_ipd_id > 0) {
    $ipd_q = mysql_query("select * from patipd_mst where id = '$req_ipd_id'");
    $ipd_row = mysql_fetch_array($ipd_q);
}
if (!$ipd_row && $c > 0) {
    $ipd_q = mysql_query("select * from patipd_mst where pid = '$c' order by id desc limit 1");
    $ipd_row = mysql_fetch_array($ipd_q);
}

$ipd_number = $ipd_row ? $ipd_row['id'] : '';
$doa = ($ipd_row && $ipd_row['created_date']) ? date('d-m-Y', strtotime($ipd_row['created_date'])) : '';
$dod = ($ipd_row && $ipd_row['discharge_date']) ? date('d-m-Y', strtotime($ipd_row['discharge_date'])) : '';

$refer_id = ($ipd_row && $ipd_row['refer']) ? $ipd_row['refer'] : $pat['refer'];
$docs_list = mysql_query("select * from doctor_mst where id='$refer_id'");
$doc_name = mysql_fetch_array($docs_list);
$referby = $doc_name['doc_name'] ?: '';

$dep_name = '';
if ($ipd_row && $ipd_row['rid']) {
    $did = $ipd_row['rid'];
    $dsq = mysql_query("select * from ipd_mst where id = '$did'");
    $dp = mysql_fetch_array($dsq);
    $dep_name = $dp['rep_name'] ?: '';
}

// Investigations during stay
$inv_list = array();
if ($ipd_row) {
    $ipd_cur_id = $ipd_row['id'];
    $inv_q = mysql_query("select i.*, r.rep_name from investigate_mst i left join report_mst r on i.rid = r.id where (i.ipd_id = '$ipd_cur_id' or (i.pid = '$c' and i.inv_type = 'Indoor')) order by i.id asc");
    while ($inv_q && ($inv_r = mysql_fetch_array($inv_q))) {
        $inv_date_fmt = date('d-m-Y', strtotime($inv_r['created_date']));
        $inv_list[] = htmlspecialchars($inv_r['rep_name']) . " (" . $inv_date_fmt . ")";
    }
}
?>
<html>
<head>
<title>Discharge Summary - <?php echo $pat['pat_name']; ?></title>
<style type="text/css">
body { font-family: Arial, sans-serif; font-size: 13px; color: #111; margin: 20px; }
table { border-collapse: collapse; width: 100%; }
.meta-table td { padding: 6px 8px; font-size: 12px; }
.section-title { font-weight: bold; font-size: 13px; text-decoration: underline; margin-top: 14px; margin-bottom: 4px; color: #000; }
.section-content { font-size: 13px; padding-left: 10px; min-height: 20px; line-height: 1.5; }
@media print {
    .no-print { display: none; }
}
</style>
</head>
<body>

<div class="no-print" style="margin-bottom:15px; text-align:right;">
    <button onclick="window.print();" style="padding:6px 16px; font-size:14px; cursor:pointer; background:#00a2e8; color:#fff; border:none; border-radius:4px; font-weight:bold;">Print Discharge Summary</button>
</div>

<table align="center">
<tr>
<td width="15%" align="left">
<img src="logo.png" style="max-height:80px;" />
</td>
<td align="center">
<span style="font-weight:bold; font-family:'Times New Roman', serif; font-size:22px; color:#000000">SHRI BABU SINGH JAY SINGH AYURVEDIC</span><br />
<span style="font-weight:bold; font-family:'Times New Roman', serif; font-size:22px; color:#000000">MEDICAL COLLEGE &amp; HOSPITAL</span><br />
<span style="font-weight:bold; font-family:'Times New Roman', serif; font-size:12px; color:#000000">BHAUPUR, BEWAR ROAD FATEHGARH, FARRUKHABAD-(U.P.) 209602</span>
</td>
</tr>
</table>

<hr color="#000000" style="margin: 8px 0 12px 0;">

<div align="center" style="font-size:16px; margin-bottom:10px;"><STRONG><u>DISCHARGE SUMMARY</u></STRONG></div>

<table border="1" cellpadding="6" cellspacing="0" class="meta-table">
<tr>
<td width="10%" style="font-weight:bold;">UHID</td>
<td width="15%"><?php echo $l_uhid; ?></td>
<td width="20%" style="font-weight:bold;">NAME OF THE PATIENT</td>
<td width="30%"><?php echo htmlspecialchars($pat['pat_name']); ?></td>
<td width="10%" style="font-weight:bold;">AGE</td>
<td width="15%"><?php echo $pat['age']; ?> Years</td>
</tr>
<tr>
<td style="font-weight:bold;">SEX</td>
<td><?php echo htmlspecialchars($pat['sex']); ?></td>
<td style="font-weight:bold;">NAME OF DOCTOR</td>
<td><?php echo htmlspecialchars($referby); ?></td>
<td style="font-weight:bold;">Department</td>
<td><?php echo htmlspecialchars($dep_name); ?></td>
</tr>
<tr>
<td style="font-weight:bold;">IPD NO.</td>
<td><?php echo $ipd_number ? '#' . $ipd_number : ''; ?></td>
<td style="font-weight:bold;">DOA (Admission Date)</td>
<td><strong><?php echo $doa; ?></strong></td>
<td style="font-weight:bold;">DOD (Discharge Date)</td>
<td><strong><?php echo $dod; ?></strong></td>
</tr>
</table>

<div class="section-title">Final Diagnosis:</div>
<div class="section-content">
    <?php echo $ipd_row['final_diagnosis'] ? htmlspecialchars($ipd_row['final_diagnosis']) : '......................................................................................................................................................'; ?>
</div>

<div class="section-title">Course in the Hospital:</div>
<div class="section-content">
    Patient was admitted on <?php echo $doa ?: '..........'; ?> and managed conservatively with indoor care and regular observation.
</div>

<div class="section-title">Key Investigations and Findings (during stay):</div>
<div class="section-content">
    <?php 
    if (!empty($inv_list)) {
        echo implode(", &nbsp;", $inv_list);
    } else {
        echo 'Routine indoor investigations completed as per protocol.';
    }
    ?>
</div>

<div class="section-title">Condition at the time of Discharge:</div>
<div class="section-content">
    <?php echo $ipd_row['discharge_condition'] ? htmlspecialchars($ipd_row['discharge_condition']) : 'Satisfactory / Improved'; ?>
</div>

<div class="section-title">Discharge Medications:</div>
<div class="section-content" style="min-height:50px;">
    <?php echo $ipd_row['discharge_summary'] ? nl2br(htmlspecialchars($ipd_row['discharge_summary'])) : 'As prescribed in treatment sheet.'; ?>
</div>

<div class="section-title">Follow-up Advice and Instructions:</div>
<div class="section-content" style="min-height:30px;">
    Review in OPD after 7 days or SOS in case of emergency.
</div>

<br><br>
<table style="width:100%; border:none; margin-top:20px;">
<tr>
<td width="50%" align="left" style="font-size:13px; line-height:1.8;">
    <strong>Name of Doctor:</strong> <?php echo htmlspecialchars($referby); ?><br>
    <strong>Signature:</strong> _______________________<br>
    <br>
    <small><u>In case of any emergency, contact Hospital: (05692-2324579)</u></small>
</td>
<td width="50%" align="right" style="font-size:13px; line-height:1.8;">
    <strong>Date of Discharge:</strong> <?php echo $dod ?: date('d-m-Y'); ?><br>
    <strong>Time:</strong> <?php echo ($ipd_row && $ipd_row['discharge_time']) ? substr($ipd_row['discharge_time'], 0, 5) : date('H:i'); ?><br>
</td>
</tr>
</table>

</body>
</html>
