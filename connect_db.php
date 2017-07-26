<?php
/**
 * Created by PhpStorm.
 * User: LSA
 * Date: 14/7/2017
 * Time: 3:56 PM
 */
$ini = parse_ini_file('config.ini');

$conn = mysqli_connect($ini['server_db'], $ini['user_db'], $ini['password_db'], $ini['db_name']);

if (!$conn) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
?>