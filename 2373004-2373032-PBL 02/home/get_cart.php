<?php
session_start();
include '../home/connect.php'; // Sesuaikan path

$cartItems = [];
if (isset($_SESSION['signup_id'])) {
    $signup_id = $_SESSION['signup_id'];
    $sql = "SELECT 
                k.keranjang_id,
                k.variasi_id,
                k.qty,
                k.harga_satuan,
                p.nama AS nama_produk,
                v.size_name,
                w.jenis_warna,
                g.gambar_url
            FROM keranjang k
            JOIN variasi v ON k.variasi_id = v.variasi_id
            JOIN produk p ON v.produk_id = p.produk_id
            JOIN warna w ON v.warna_id = w.warna_id
            LEFT JOIN (
                SELECT produk_id, MIN(gambar_url) AS gambar_url 
                FROM gambar 
                GROUP BY produk_id
            ) g ON p.produk_id = g.produk_id
            WHERE k.signup_id = ?
            ORDER BY k.created_at DESC";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $signup_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $cartItems[] = $row;
    }
}

echo json_encode($cartItems);
?>