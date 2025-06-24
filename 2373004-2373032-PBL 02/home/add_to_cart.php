<?php
session_start();
include '../home/connect.php'; // Sesuaikan path

if (!isset($_SESSION['signup_id'])) {
    echo json_encode(['success' => false, 'message' => 'You must login to add items to cart']);
    exit;
}

$signup_id = $_SESSION['signup_id'];
$variasi_id = (int) $_POST['variasi_id'];
$qty = (int) $_POST['qty'];

// Ambil harga produk berdasarkan variasi_id
$sql = "SELECT p.harga 
        FROM produk p
        JOIN variasi v ON p.produk_id = v.produk_id
        WHERE v.variasi_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $variasi_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo json_encode(['success' => false, 'message' => 'Product variation not found']);
    exit;
}

$row = $result->fetch_assoc();
$harga_satuan = $row['harga'];

// Masukkan ke database
$sql = "INSERT INTO keranjang (signup_id, variasi_id, qty, harga_satuan) 
        VALUES (?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE qty = qty + VALUES(qty)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiid", $signup_id, $variasi_id, $qty, $harga_satuan);

if ($stmt->execute()) {
    // Get updated cart count
    $sql_count = "SELECT COUNT(*) AS count FROM keranjang WHERE signup_id = ?";
    $stmt_count = $conn->prepare($sql_count);
    $stmt_count->bind_param("i", $signup_id);
    $stmt_count->execute();
    $result_count = $stmt_count->get_result();
    $row_count = $result_count->fetch_assoc();
    
    echo json_encode([
        'success' => true,
        'cart_count' => $row_count['count']
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
}
?>