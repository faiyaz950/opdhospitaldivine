<?php
/**
 * UHID format: <prefix>/<mm>/<yy>/<patient id>, where mm/yy come from the
 * patient's registration date and <prefix> is param_mst.uid_pformat.
 */

function hms_uhid_prefix($pid)
{
    static $prefix = null;
    static $dates = array();

    if ($prefix === null) {
        $row = mysql_fetch_array(mysql_query("select `last_value` from param_mst where type='uid_pformat'"));
        $prefix = rtrim($row ? $row['last_value'] : '', '/');
    }

    $pid = (int) $pid;
    if (!array_key_exists($pid, $dates)) {
        $row = mysql_fetch_array(mysql_query("select created_date from patient_mst where id='$pid'"));
        $dates[$pid] = $row ? strtotime($row['created_date']) : false;
    }

    return $prefix . '/' . date('m/y', $dates[$pid] ?: time()) . '/';
}

function hms_uhid($pid)
{
    return hms_uhid_prefix($pid) . (int) $pid;
}

/** Accepts a full UHID (old or new format) or a bare patient id. */
function hms_uhid_pid($uhid)
{
    $parts = preg_split('#[/-]#', trim((string) $uhid));
    return (int) end($parts);
}
