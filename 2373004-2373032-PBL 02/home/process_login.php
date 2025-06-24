<?php
session_start();
require_once 'connect.php';
require_once 'process_signup.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validasi input
    if (empty($email) || empty($password)) {
        $_SESSION['login_error'] = "Email dan password harus diisi";
        header("Location: homepage.php");
        exit();
    }

    // Cari user berdasarkan email
    $stmt = $conn->prepare("SELECT * FROM sign_up WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Login berhasil
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['signup_id'];
            $_SESSION['user_name'] = $user['nama'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['login_success'] = "Login berhasil! Selamat datang " . $user['nama'];

            // Setelah verifikasi login berhasil
            $_SESSION['logged_in'] = true;
            $_SESSION['signup_id'] = $user['signup_id']; // Sesuaikan dengan kolom di database
            $_SESSION['user_name'] = $user['nama'];

            $_SESSION['login_success'] = true;
            header("Location: homepage.php?login=success");
            exit();

        } else {
            $_SESSION['login_error'] = "Email atau password salah";
            header("Location: homepage.php?login=error");
            exit();
        }
    } else {
        $_SESSION['login_error'] = "Email atau password salah";
        header("Location: homepage.php?login=error");
        exit();
    }

  
}
?>