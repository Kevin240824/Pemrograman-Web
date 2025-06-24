<?php
session_start();
include '../home/connect.php';

// Pastikan user sudah login
if (!isset($_SESSION['signup_id'])) {
    header("Location: ../home/homepage.php");
    exit();
}

// Ambil data dari form
$payment_method = $_POST['payment_method'];
$total_amount = $_POST['total_amount'];
$signup_id = $_POST['signup_id'];

// Inisialisasi variabel untuk data pembayaran
$card_number = '';
$card_name = '';
$expiry_date = '';
$cvv = '';
$phone_number = '';
$save_card = isset($_POST['save_card']) ? 1 : 0;

// Ambil data sesuai metode pembayaran
if ($payment_method === 'credit_card') {
    $card_number = $_POST['card_number'] ?? '';
    $card_name = $_POST['card_name'] ?? '';
    $expiry_date = $_POST['expiry_date'] ?? '';
    $cvv = $_POST['cvv'] ?? '';
} elseif ($payment_method === 'paypal') {
    $phone_number = $_POST['phone_number'] ?? '';
}

// Simpan ke tabel pembayaran
$sql = "INSERT INTO pembayaran (
    signup_id, 
    metode_pembayaran, 
    total, 
    card_number, 
    card_name, 
    expiry_date, 
    cvv, 
    phone_number, 
    save_card
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "isssssssi", 
    $signup_id, 
    $payment_method, 
    $total_amount, 
    $card_number, 
    $card_name, 
    $expiry_date, 
    $cvv, 
    $phone_number, 
    $save_card
);

if ($stmt->execute()) {
    // Kosongkan keranjang setelah pembayaran berhasil
    $delete_sql = "DELETE FROM keranjang WHERE signup_id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("i", $signup_id);
    $delete_stmt->execute();
    
    // Simpan ID pembayaran untuk halaman konfirmasi
    $_SESSION['pembayaran_id'] = $stmt->insert_id;
    
    // Redirect ke halaman konfirmasi
    header("Location: confirmation.php");
    exit();
} else {
    // Tangani error
    $_SESSION['payment_error'] = "Error: " . $stmt->error;
    header("Location: payment.php");
    exit();
}

$stmt->close();
$conn->close();
?>