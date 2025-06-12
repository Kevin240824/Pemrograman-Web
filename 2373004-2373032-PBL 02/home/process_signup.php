<?php
session_start();
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user'])) {
    $name = $_POST['nama'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    
    // Validasi
    if (empty($name) || empty($email) || empty($pass)) {
        $_SESSION['signup_error'] = "Please fill all fields";
        header("Location: homepage.php");
        exit();
    }
    
    // Validasi format email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['signup_error'] = "Invalid email format";
        header("Location: homepage.php");
        exit();
    }
    
    // Check if email exists
    $check_stmt = $conn->prepare("SELECT email FROM sign_up WHERE email = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows > 0) {
        $_SESSION['signup_error'] = "Email already registered. Please use another email.";
        header("Location: homepage.php");
        exit();
    }
    
    // Hash password
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
    
    // Insert user
    $stmt = $conn->prepare("INSERT INTO sign_up(nama, email, password) VALUES(?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $hashed_password);
    
    if ($stmt->execute()) {
        $_SESSION['signup_success'] = true;
        header("Location: homepage.php?signup=success");
        exit();
    } else {
        $_SESSION['signup_error'] = "Error creating account. Please try again.";
        header("Location: homepage.php");
        exit();
    }
}
?>