<?php
session_start();
ini_set('display_errors', 1);

$mysqli = new mysqli("localhost", "root", "", "stok_barang_k");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>





