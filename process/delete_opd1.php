<?php
session_start();
if(!(isset($_SESSION["user_login"])))
{
	$_SESSION["error_msg"]="Please Login";
	header("Location: index.php");die;
}
   $id = $_REQUEST['id'];
//connect to the database
    include_once ('../DLL/config.php'); 
    $query = mysql_query("delete from opd_mst where id='$id'");
	if($query)
	{
	header("location: ../show_opd1.php");
	}	

?>
