<?php
session_start();
include '../home/connect.php';

if (!isset($_SESSION['signup_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

if (!isset($_POST['keranjang_id'])) {
    echo json_encode(['success' => false, 'message' => 'Missing cart item ID']);
    exit;
}

$keranjang_id = (int)$_POST['keranjang_id'];
$signup_id = $_SESSION['signup_id'];

// Pastikan item keranjang milik user yang login
$delete_sql = "DELETE FROM keranjang WHERE keranjang_id = ? AND signup_id = ?";
$stmt = $conn->prepare($delete_sql);
$stmt->bind_param("ii", $keranjang_id, $signup_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Item not found or already removed']);
}

$stmt->close();
$conn->close();
?>