<?php
include("../DLL//config.php");
if(isset($_POST['submit']))
{
$id = $_REQUEST['id'];
$email=$_POST['email'];
$password=$_POST['password'];
$sql = mysql_query("update admin set email='$email', password='$password' where id='$id'");
if($sql)
{
header("Location: ../show_admin.php");
}
}
?>
