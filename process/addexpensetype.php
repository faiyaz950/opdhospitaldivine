<?php
include("../DLL//config.php");
if(isset($_POST['submit']))
{
$exptype_name=$_POST['exptype_name'];
$sql = mysql_query("insert into expense_heads(exptype_name) values ('$exptype_name')");
if($sql)
{
header("Location: ../show_exptype.php");
}
}
?>
