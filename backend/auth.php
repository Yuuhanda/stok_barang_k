<?php

include('../database/config.php'); //session is in config.php

$email = $_POST['email'];
$password = $_POST['password'];

// Hash the password correctly
$hashedPassword = hash('sha256', $password);  // Hash the password using SHA-256
$hashedPassword = substr($hashedPassword, 0, 60);  // Take the first 60 characters of the hashed password

// Query the database
$query_admin = $mysqli->query("SELECT * FROM user WHERE email='$email' AND password='$hashedPassword'");

if ($query_admin->num_rows == 1) {
    // Fetch the user's data
    $data = $query_admin->fetch_object();
    $ban_status = $data->ban_status;  // Accessing the ban_status from fetched data

    // Set session variables
    $_SESSION['id_user'] = $data->id_user;
    $_SESSION['level'] = $data->level;

    // Check the user's ban status
    if ($ban_status == 0) {
        header('Location: ../admin/dashboard.php');
        exit();  // Ensure the script stops after a redirect
    } elseif ($ban_status == 1) {
        header("Location: ../index.php?alert=1");
        exit();
    } else {
        echo "fail";
    }
} else {
    // If the user is not found or password doesn't match, redirect or show an error
    header("Location: ../index.php?id=1");
    exit();
}
?>
