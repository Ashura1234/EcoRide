<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once(dirname(__FILE__) . "/config.php");


try {
    $dbh = new PDO("mysql:host={$config['DB_HOST']};dbname=ecoride", $config['DB_USER'], $config['DB_PASS']);
    // Connection successful, do nothing
} catch (PDOException $e) {
    // Handle the error silently or take necessary action
    // For example, you could log it or send an alert email
    file_put_contents('db_connection.log', date('Y-m-d H:i:s') . " - Erreur!: " . $e->getMessage() . "\n", FILE_APPEND);
    die();
}
