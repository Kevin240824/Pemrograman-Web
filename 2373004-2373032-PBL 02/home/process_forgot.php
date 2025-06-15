<?php
session_start();
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user'])) {
    $name = $_POST['nama'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $con_pass = $_POST['con_password'];

    // Validate passwords match
    if ($pass !== $con_pass) {
        die("Error: Passwords do not match");
    }

    // Check if user exists
    $check_stmt = $conn->prepare("SELECT signup_id FROM sign_up WHERE nama = ? AND email = ?");
    $check_stmt->bind_param("ss", $name, $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows === 0) {
        die("Error: User with this name and email not found");
    }

    // Update password (not delete user!)
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
    $update_stmt = $conn->prepare("UPDATE sign_up SET password = ? WHERE nama = ? AND email = ?");
    $update_stmt->bind_param("sss", $hashed_password, $name, $email);

    if ($update_stmt->execute()) {
        echo '<script>alert("Password updated successfully")</script>';
    } else {
        echo '<script>alert("Error updating password")</script>'  . $conn->error;
    }

      header("Location: homepage.php");

    $update_stmt->close();
    $check_stmt->close();
    $conn->close();
}
