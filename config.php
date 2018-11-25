<?php
/**
 * Configuration for database connection
 *
 */
$host       = $IP;
$username   = getenv('C9_USER');
$password   = "";
$dbname     = "c9";
$dsn        = "mysql:host=$host;dbname=$dbname";
$options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );
$db = new mysqli($host, $username, $password, $dbname, $dbport);
