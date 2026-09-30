<?php
/**
 * Shim for removed ext/mysql (PHP 7+). Maps legacy mysql_* calls to mysqli.
 */
// Legacy code relies on PHP 5 behaviour: notices hidden and failed queries returning false.
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
mysqli_report(MYSQLI_REPORT_OFF);

if (!function_exists('mysql_connect')) {

    function mysql_get_link(): ?mysqli
    {
        global $con;
        return isset($con) && $con instanceof mysqli ? $con : null;
    }

    function mysql_connect(
        ?string $server = null,
        ?string $username = null,
        ?string $password = null,
        bool $new_link = false,
        int $client_flags = 0
    ) {
        global $con;
        $server = $server ?: 'localhost';
        $mysqli = mysqli_init();
        if (!$mysqli) {
            return false;
        }
        $port = ini_get('mysqli.default_port');
        $socket = ini_get('mysqli.default_socket');
        if (!@mysqli_real_connect($mysqli, $server, $username, $password, '', (int) $port, $socket, $client_flags)) {
            return false;
        }
        // Queries insert '' into integer columns, which only non-strict mode accepts.
        mysqli_query($mysqli, "SET SESSION sql_mode = 'NO_ENGINE_SUBSTITUTION'");
        $con = $mysqli;
        return $mysqli;
    }

    function mysql_select_db(string $database_name, $link_identifier = null): bool
    {
        $link = $link_identifier ?: mysql_get_link();
        if (!$link instanceof mysqli) {
            return false;
        }
        return mysqli_select_db($link, $database_name);
    }

    function mysql_set_charset(string $charset, $link_identifier = null): bool
    {
        $link = $link_identifier ?: mysql_get_link();
        if (!$link instanceof mysqli) {
            return false;
        }
        return mysqli_set_charset($link, $charset);
    }

    function mysql_query(string $query, $link_identifier = null)
    {
        $link = $link_identifier ?: mysql_get_link();
        if (!$link instanceof mysqli) {
            return false;
        }
        return mysqli_query($link, $query);
    }

    function mysql_fetch_array($result, int $result_type = MYSQLI_BOTH)
    {
        if ($result === false || $result === null) {
            return false;
        }
        if (!$result instanceof mysqli_result) {
            return false;
        }
        return mysqli_fetch_array($result, $result_type);
    }

    function mysql_num_rows($result)
    {
        if ($result === false || $result === null || !$result instanceof mysqli_result) {
            return false;
        }
        return mysqli_num_rows($result);
    }

    function mysql_insert_id($link_identifier = null)
    {
        $link = $link_identifier ?: mysql_get_link();
        if (!$link instanceof mysqli) {
            return 0;
        }
        return (int) mysqli_insert_id($link);
    }

    function mysql_error($link_identifier = null): string
    {
        $link = $link_identifier ?: mysql_get_link();
        if (!$link instanceof mysqli) {
            return '';
        }
        return mysqli_error($link);
    }

    function mysql_close($link_identifier = null): bool
    {
        $link = $link_identifier ?: mysql_get_link();
        if (!$link instanceof mysqli) {
            return false;
        }
        return mysqli_close($link);
    }
}
