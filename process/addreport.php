<?php
include("../DLL//config.php");
if(isset($_POST['submit']))
{
$rep_name=$_POST['rep_name'];
$rate = $_POST['rate'];
$date = date("Y-m-d h:m:s");
$sql = mysql_query("insert into report_mst(rep_name,rate,created_date) values ('$rep_name','$rate','$date')");
if($sql)
{
header("Location: ../show_reports.php");
}
}
?>
