<?php

/**
 * Database connection.
 *
 * No credentials are hardcoded here. This file loads them in two possible
 * ways, so it works both on hosts that support environment variables and
 * on typical shared PHP hosting that doesn't:
 *
 *   1. config.local.php -- copy config.local.example.php to
 *      config.local.php in this same folder and fill in your real values.
 *      config.local.php is git-ignored and is never committed.
 *   2. Environment variables -- DB_HOST / DB_NAME / DB_USER / DB_PASSWORD,
 *      used as a fallback if config.local.php doesn't exist.
 *
 * See backend/README.md and .env.example for details.
 */

$local = __DIR__ . "/config.local.php";
if (file_exists($local)) {
    require $local;
}

$host     = $host     ?? (getenv("DB_HOST") ?: "localhost");
$dbname   = $dbname   ?? (getenv("DB_NAME") ?: "");
$username = $username ?? (getenv("DB_USER") ?: "");
$password = $password ?? (getenv("DB_PASSWORD") ?: "");

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection Failed");
}

$conn->set_charset("utf8");