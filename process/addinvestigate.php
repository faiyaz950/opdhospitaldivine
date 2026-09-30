<?php
include("../DLL/config.php");
include("../functions.php");
if(isset($_POST['submit']))
{
$pat_id=$_POST['pat_id'];
$pa_id = explode('/', $pat_id);
$p_id = hms_uhid_pid($pat_id);

//DOCTOR DETAILS
$sq = mysql_query("select * from patient_mst where id = '$p_id'");
$pq = mysql_fetch_array($sq);
$refer_id = $pq['refer'];

$rep_id = $_POST['report_id'];
$date = date("Y-m-d");
$time = date("H:i:s", time());
$datetime = date("Y-m-d h:m:s");
$sql = mysql_query("insert into investigate_mst(pid,rid,created_date,created_time,created_datetime,refer) values ('$p_id','$rep_id','$date','$time','$datetime','$refer_id')");
$inv_id = mysql_insert_id();
$rate = getInvestigationRate($rep_id);
$check = mysql_query("select * from billing_mst where pat_id='$p_id' and create_date='$date'");
$count = mysql_num_rows($check);
if($count < 1)
{
$last_bill = mysql_query("select * from param_mst where id='3'");
$rbill = mysql_fetch_array($last_bill);
$last_bill_no = $rbill['last_value'];
$bill_no = $last_bill_no + 1;
$sql1 = mysql_query("insert into billing_mst(bill_id, bill_type, bill_typenumber, pat_id, bill_amount, created_date, create_date) values ('$bill_no', 'Investigation','$inv_id', '$p_id', '$rate', '$datetime', '$date')");
$now = mysql_query("update param_mst set last_value='$bill_no' where id='3'");
}
else
{
$check1 = mysql_query("select * from billing_mst where pat_id='$p_id' and create_date='$date'");
$pr = mysql_fetch_array($check1);
$bill_no =  $pr['bill_id'];
$sql1 = mysql_query("insert into billing_mst(bill_id, bill_type, bill_typenumber, pat_id, bill_amount, created_date, create_date) values ('$bill_no', 'Investigation','$inv_id', '$p_id', '$rate', '$datetime', '$date')");
}
if($sql1)
{
header("Location: ../show_investigate.php");
}
}
?>
