<?php
include("../DLL/config.php");
if(isset($_POST['submit']))
{
$id = $_REQUEST['id'];
$dep_name=$_POST['dep_name'];
$date = date("Y-m-d h:m:s");
$sql = mysql_query("update department_mst set dep_name = '$dep_name', updated_date='$date' where id = '$id'");
if($sql)
{
header("Location: ../show_departments.php");
}
}
?>
