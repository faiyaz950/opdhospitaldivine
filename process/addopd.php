<?php
include("../DLL/config.php");
if(isset($_POST['submit']))
{
$pat_id=$_POST['pat_id'];
$pa_id = explode('/', $pat_id);
$p_id = hms_uhid_pid($pat_id);

//DOCTOR DETAILS
$sq = mysql_query("select * from patient_mst where id = '$p_id'");
$pq = mysql_fetch_array($sq);
$refer_id = $pq['refer'];

$date = $_POST['dated'];
$dep_id = $_POST['department'];
$opd_charges = $_POST['opd_charges'];
$datetime = date("Y-m-d h:m:s");
$time = date("H:i:s", time());
$date1 = date("Y-m-d");
$valid_till = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + 4, date('Y')));
$sql = mysql_query("insert into opd_mst(pid,did,opd_charges,created_date,created_time,valid_till,refer,created_datetime) values ('$p_id','$dep_id','$opd_charges','$date','$time','$valid_till','$refer_id','$datetime')");
$opd_id = mysql_insert_id();
$check = mysql_query("select * from billing_mst where pat_id='$p_id' and create_date='$date1'");
$count = mysql_num_rows($check);
if($count < 1)
{
$last_bill = mysql_query("select * from param_mst where id='3'");
$rbill = mysql_fetch_array($last_bill);
$last_bill_no = $rbill['last_value'];
$bill_no = $last_bill_no + 1;
$sql1 = mysql_query("insert into billing_mst(bill_id, bill_type, bill_typenumber, pat_id, bill_amount, created_date, create_date) values ('$bill_no', 'OPD','$opd_id', '$p_id', '$opd_charges', '$datetime', '$date1')");
$now = mysql_query("update param_mst set last_value='$bill_no' where id='3'");
}
else
{
$check1 = mysql_query("select * from billing_mst where pat_id='$p_id' and create_date='$date1'");
$pr = mysql_fetch_array($check1);
$bill_no =  $pr['bill_id'];
$sql1 = mysql_query("insert into billing_mst(bill_id, bill_type, bill_typenumber, pat_id, bill_amount, created_date, create_date) values ('$bill_no', 'OPD','$opd_id', '$p_id', '$opd_charges', '$datetime', '$date1')");
}
if($sql1)
{
header("Location: ../show_opd.php");
}
}
?>
