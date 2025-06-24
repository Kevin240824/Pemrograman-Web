<?php
session_start();
include '../home/connect.php';

if (!isset($_SESSION['signup_id'])) {
    echo json_encode([]);
    exit;
}

$signup_id = $_SESSION['signup_id'];

$sql = "SELECT k.keranjang_id, k.qty, k.harga_satuan,
               p.nama_produk, p.gambar_produk,
               s.size_name, w.jenis_warna
        FROM keranjang k
        JOIN variasi v ON k.variasi_id = v.variasi_id
        JOIN produk p ON v.produk_id = p.produk_id
        JOIN size s ON v.size_id = s.size_id
        JOIN warna w ON v.warna_id = w.warna_id
        WHERE k.signup_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $signup_id);
$stmt->execute();
$result = $stmt->get_result();

$cartItems = [];
while ($row = $result->fetch_assoc()) {
    $cartItems[] = $row;
}

echo json_encode($cartItems);

$stmt->close();
$conn->close();
?>