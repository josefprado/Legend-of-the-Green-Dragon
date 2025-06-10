<?php
// addnews ready
// translator ready
// mail ready
require_once("lib/errorhandling.php");
require_once("lib/datacache.php");

/**
 * Avaiable database drivers:
 *
 * - mysqli_sqlite:     The SQLite3 extension.
 * - mysqli_proc:       The MySQLi extension of PHP5.4+, procedural style.
 * - mysqli_oos:        The MySQLi extension of PHP5.4+, object oriented style
 * @todo Configure this in a commandline installer package instead of a weak
 *  web interface.
 */
define('DBTYPE', 'mysqli_proc');
$dbinfo['queriesthishit'] = 0;

require_once('lib/dbwrapper_' . DBTYPE . '.php');

function db_escape(string $string): string
{
    switch (DBTYPE) {
        case 'mysqli_proc':
        case 'mysqli_oos':
            global $mysqli_resource;
            if (!$mysqli_resource) {
                require_once('dbconnect.php');
                db_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
            }
            return mysqli_real_escape_string($mysqli_resource, $string);
        case 'mysqli_sqlite':
            return SQLite3::escapeString($string);
        default:
            return addslashes($string);
    }
}
