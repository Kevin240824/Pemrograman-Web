<?php
session_start();
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user'])) {
    $name = $_POST['nama'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    
    // Validasi input
    if (empty($name) || empty($email) || empty($pass)) {
        $_SESSION['signup_error'] = "Please fill all fields";
        header("Location: homepage.php");
        exit();
    }
    
    // Check if email already exists
    $check_stmt = $conn->prepare("SELECT email FROM sign_up WHERE email = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows > 0) {
        $_SESSION['signup_error'] = "Email already exists";
        header("Location: homepage.php");
        exit();
    }
    
    // Hash password
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
    
    // Insert new user
    $stmt = $conn->prepare("INSERT INTO sign_up(nama, email, password) VALUES(?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $hashed_password);
    
    if ($stmt->execute()) {
        // Set session variables after successful signup
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_email'] = $email;
        $_SESSION['logged_in'] = true;
        
        header("Location: homepage.php?signup=success");
        exit();
    } else {
        $_SESSION['signup_error'] = "Error creating account: " . $stmt->error;
        header("Location: homepage.php");
        exit();
    }
    
    $stmt->close();
    $check_stmt->close();
    $conn->close();
} else {
    header("Location: homepage.php");
    exit();
}
?>