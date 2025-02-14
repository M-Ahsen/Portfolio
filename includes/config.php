<?php
// Database configuration
// define('DB_SERVER', 'localhost');
// define('DB_USERNAME', 'root');
// define('DB_PASSWORD', '');
// define('DB_NAME', 'portfolio_website_db');

define('DB_SERVER', 'sql103.infinityfree.com');
define('DB_USERNAME', 'if0_37973056');
define('DB_PASSWORD', 'hIrhHuS8EnlDUD');
define('DB_NAME', 'if0_37973056_portfolio_website_db');

// Create a connection
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check the connection
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

// Set charset to utf8mb4 for better security and compatibility
$conn->set_charset('utf8mb4');
?>
