<?php
session_start();
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Validasi input
    if (empty($email) || empty($password)) {
        $_SESSION['login_error'] = "Please fill all fields";
        header("Location: homepage.php");
        exit();
    }
    
    // Cek user di database
    $stmt = $conn->prepare("SELECT * FROM sign_up WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        $_SESSION['login_error'] = "Email not found";
        header("Location: homepage.php");
        exit();
    }
    
    $user = $result->fetch_assoc();
    
    // Verifikasi password
    if (password_verify($password, $user['password'])) {
        // Set session
        $_SESSION['user_id'] = $user['signup_id'];
        $_SESSION['user_name'] = $user['nama'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['logged_in'] = true;
        
        header("Location: homepage.php");
        exit();
    } else {
        $_SESSION['login_error'] = "Incorrect password";
        header("Location: homepage.php");
        exit();
    }
    
    $stmt->close();
    $conn->close();
} else {
    header("Location: homepage.php");
    exit();
}
?>