<?php
$db_server = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'portfolio_website_db';


$conn = mysqli_connect($db_server, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    trigger_error('Database connection failed: ' . $conn->connect_error, E_USER_ERROR);
}


?>