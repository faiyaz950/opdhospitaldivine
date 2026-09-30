<?php
function getInvestigationRate($p)
{
$sql = mysql_query("select rate from report_mst where id='$p'");
$r = mysql_fetch_array($sql);
$rate  = $r['rate'];
return $rate;
}
function getIPDRate($p)
{
$sql = mysql_query("select rate from ipd_mst where id='$p'");
$r = mysql_fetch_array($sql);
$rate  = $r['rate'];
return $rate;
}
function getPatientDetails($p)
{
$sql = mysql_query("select * from patient_mst where id='$p'");
$r = mysql_fetch_array($sql);
return $r;
}
?>