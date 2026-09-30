<?php
include("../DLL//config.php");
if(isset($_POST['submit']))
{
$exp_type=$_POST['exp_type'];
$amount=$_POST['amount'];
$date = $_POST['date1'];
$sql = mysql_query("insert into expense_mst(exptype,amount,created_date) values ('$exp_type','$amount','$date')");
if($sql)
{
header("Location: ../show_expenses.php");
}
}
?>
