<?php
include("../DLL/config.php");
include("../functions.php");
if(isset($_POST['submit']))
{
$pat_id=$_POST['pat_id'];$pa_id = explode('/', $pat_id);
$p_id = hms_uhid_pid($pat_id);

//DOCTOR DETAILS
$sq = mysql_query("select * from patient_mst where id = '$p_id'");
$pq = mysql_fetch_array($sq);
$refer_id = $pq['refer'];

$rep_id = $_POST['department'];
$date = date("Y-m-d");
$time = date("H:i:s", time());
$datetime = date("Y-m-d H:i:s");
$sql = mysql_query("insert into outinvestigate_mst(pid,rid,created_date,created_time,created_datetime,refer) values ('$p_id','$rep_id','$date','$time','$datetime','$refer_id')");
if($sql)
{
header("Location: ../show_outinvestigate.php");
}
}
?>
