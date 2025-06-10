<?php
require_once 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    
    $query = "SELECT * FROM pengguna WHERE email = '$email'";
    $result = $conn->query($query);
    
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id_pengguna'];
            $_SESSION['user_name'] = $user['nama'];
            $_SESSION['user_email'] = $user['email'];
            
            if (isset($_POST['remember'])) {
                // Set cookie for 30 days
                setcookie('remember_user', $user['id_pengguna'], time() + (30 * 24 * 60 * 60), "/");
            }
            
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid email or password";
            header("Location: index.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Invalid email or password";
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}

// Jika form login disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = $_POST['loginEmail'];
    $password = $_POST['loginPassword'];
    
    $stmt = $conn->prepare("SELECT * FROM sign_up WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['logged_in'] = true;
        $_SESSION['user_email'] = $email;
        echo "<script>alert('Login successful!'); window.location.href='homepage.php';</script>";
    } else {
        echo "<script>alert('Invalid email or password!');</script>";
    }
}
?>