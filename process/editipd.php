<?php
include("../DLL/config.php");
if(isset($_POST['submit']))
{
$id = $_REQUEST['id'];
$rep_name=$_POST['rep_name'];
$rate=$_POST['rate'];
$date = date("Y-m-d H:i:s");
$sql = mysql_query("update ipd_mst set rep_name = '$rep_name', rate='$rate', updated_date='$date' where id = '$id'");
if($sql)
{
header("Location: ../show_ipd.php");
}
}
?>
