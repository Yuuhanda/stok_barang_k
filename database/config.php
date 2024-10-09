<?php
session_start();
ini_set('display_errors', 1);

$mysqli = new mysqli("localhost", "root", "", "stok_barang_k");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}


// Database configuration
$host = 'localhost';
$dbname = 'stok_barang_k';
$username = 'root';
$password = '';

try {
    // Create a new PDO instance and store it in $pdo
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Set PDO to throw exceptions in case of error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle any connection errors
    die("Database connection failed: " . $e->getMessage());
}

?>





