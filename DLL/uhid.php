<?php
/**
 * UHID format: <prefix>/<yy><mm><series>, e.g. DIV/26100001, where yy/mm come
 * from the patient's registration date, <series> is a 4-digit counter that
 * restarts every month (patient_mst.uhid_series) and <prefix> is
 * param_mst.uid_pformat.
 */

function hms_uhid_prefix_value()
{
    static $prefix = null;
    if ($prefix === null) {
        $row = mysql_fetch_array(mysql_query("select `last_value` from param_mst where type='uid_pformat'"));
        $prefix = rtrim($row ? $row['last_value'] : '', '/');
    }
    return $prefix;
}

function hms_uhid_ensure_column()
{
    static $checked = false;
    if (!$checked) {
        $checked = true;
        if (!mysql_num_rows(mysql_query("show columns from patient_mst like 'uhid_series'"))) {
            mysql_query("alter table patient_mst add `uhid_series` int(11) NOT NULL DEFAULT 0, add index `uhid_series` (`uhid_series`)");
        }
    }
}

/** Numbers every patient that has no series yet, in registration (id) order. */
function hms_uhid_assign_series()
{
    hms_uhid_ensure_column();

    $pending = mysql_query("select id, created_date from patient_mst where uhid_series = 0 order by id");
    while ($pending && ($row = mysql_fetch_array($pending))) {
        $id = (int) $row['id'];
        $ym = date('ym', strtotime($row['created_date']) ?: time());
        $max = mysql_fetch_array(mysql_query("select max(uhid_series) as m from patient_mst where date_format(created_date, '%y%m') = '$ym'"));
        $next = ($max ? (int) $max['m'] : 0) + 1;
        mysql_query("update patient_mst set uhid_series = '$next' where id = '$id' and uhid_series = 0");
    }
}

function hms_uhid($pid)
{
    static $cache = array();

    $pid = (int) $pid;
    if (!array_key_exists($pid, $cache)) {
        hms_uhid_ensure_column();
        $sql = "select created_date, uhid_series from patient_mst where id='$pid'";
        $row = mysql_fetch_array(mysql_query($sql));
        if ($row && !(int) $row['uhid_series']) {
            hms_uhid_assign_series();
            $row = mysql_fetch_array(mysql_query($sql));
        }

        $time = $row ? strtotime($row['created_date']) : false;
        $series = $row ? (int) $row['uhid_series'] : 0;
        $cache[$pid] = hms_uhid_prefix_value() . '/' . date('ym', $time ?: time())
            . str_pad($series ?: $pid, 4, '0', STR_PAD_LEFT);
    }

    return $cache[$pid];
}

/** Accepts a full UHID (new or old format) or a bare patient id. */
function hms_uhid_pid($uhid)
{
    $parts = preg_split('#[/-]#', trim((string) $uhid));
    $last = end($parts);

    if (preg_match('/^(\d{4})(\d{4,})$/', $last, $m)) {
        hms_uhid_ensure_column();
        $series = (int) $m[2];
        $row = mysql_fetch_array(mysql_query("select id from patient_mst where uhid_series = '$series' and date_format(created_date, '%y%m') = '$m[1]' limit 1"));
        if ($row) {
            return (int) $row['id'];
        }
    }

    return (int) $last;
}
