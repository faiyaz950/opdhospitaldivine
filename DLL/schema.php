<?php
/**
 * Auto-migration helper for HMS database schema.
 * Ensures required columns exist in tables without breaking existing installations.
 */
function hms_ensure_schema()
{
    static $checked = false;
    if ($checked) {
        return;
    }
    $checked = true;

    // 1. Ensure discharge columns in patipd_mst
    $ipd_columns = array(
        'discharge_date'     => "ALTER TABLE `patipd_mst` ADD `discharge_date` DATE NULL DEFAULT NULL",
        'discharge_time'     => "ALTER TABLE `patipd_mst` ADD `discharge_time` TIME NULL DEFAULT NULL",
        'discharge_datetime' => "ALTER TABLE `patipd_mst` ADD `discharge_datetime` DATETIME NULL DEFAULT NULL",
        'discharge_status'   => "ALTER TABLE `patipd_mst` ADD `discharge_status` TINYINT(1) NOT NULL DEFAULT 0",
        'discharge_condition'=> "ALTER TABLE `patipd_mst` ADD `discharge_condition` VARCHAR(255) NULL DEFAULT NULL",
        'discharge_summary'  => "ALTER TABLE `patipd_mst` ADD `discharge_summary` TEXT NULL DEFAULT NULL",
        'final_diagnosis'    => "ALTER TABLE `patipd_mst` ADD `final_diagnosis` TEXT NULL DEFAULT NULL",
        'discharge_doctor'   => "ALTER TABLE `patipd_mst` ADD `discharge_doctor` INT(11) NULL DEFAULT NULL",
    );

    foreach ($ipd_columns as $col => $alter_sql) {
        $res = mysql_query("SHOW COLUMNS FROM `patipd_mst` LIKE '$col'");
        if ($res && mysql_num_rows($res) == 0) {
            mysql_query($alter_sql);
        }
    }

    // 2. Ensure indoor investigation columns in investigate_mst
    $inv_columns = array(
        'inv_type' => "ALTER TABLE `investigate_mst` ADD `inv_type` VARCHAR(50) NOT NULL DEFAULT 'Outdoor'",
        'ipd_id'   => "ALTER TABLE `investigate_mst` ADD `ipd_id` INT(11) NOT NULL DEFAULT 0",
    );

    foreach ($inv_columns as $col => $alter_sql) {
        $res = mysql_query("SHOW COLUMNS FROM `investigate_mst` LIKE '$col'");
        if ($res && mysql_num_rows($res) == 0) {
            mysql_query($alter_sql);
        }
    }
}
