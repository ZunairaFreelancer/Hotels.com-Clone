<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database Configuration
$servername = "localhost";
$username = "rsoa_rsoa278_4";
$password = "654321#";
$dbname = "rsoa_rsoa278_4";

// Function to get database connection
function getDB()
{
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// Initial connection check
$conn = getDB();
?>
