<?php
include '../home/connect.php';
$variasi_id = (int)$_GET['variasi_id'];

$sql = "SELECT p.harga 
        FROM variasi v
        JOIN produk p ON v.produk_id = p.produk_id
        WHERE v.variasi_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $variasi_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo json_encode(['harga' => $row['harga']]);
?>