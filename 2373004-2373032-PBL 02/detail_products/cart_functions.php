<?php
// cart_functions.php
session_start();
include '../home/connect.php';

function addToCart($variasi_id, $qty, $conn) {
    if (!isset($_SESSION['signup_id'])) {
        return ['success' => false, 'message' => 'You must login to add items to cart'];
    }

    $signup_id = $_SESSION['signup_id'];
    
    $sql_harga = "SELECT harga FROM produk WHERE produk_id = (SELECT produk_id FROM variasi WHERE variasi_id = $variasi_id)";
    $result_harga = $conn->query($sql_harga);
    $row_harga = $result_harga->fetch_assoc();
    $harga_satuan = $row_harga['harga'];

    $sql = "INSERT INTO keranjang (signup_id, variasi_id, qty, harga_satuan) 
            VALUES ($signup_id, $variasi_id, $qty, $harga_satuan)";

    if ($conn->query($sql)) {
        $sql_count = "SELECT COUNT(*) AS count FROM keranjang WHERE signup_id = $signup_id";
        $result_count = $conn->query($sql_count);
        $row_count = $result_count->fetch_assoc();

        return [
            'success' => true,
            'cart_count' => $row_count['count']
        ];
    } else {
        return ['success' => false, 'message' => 'Error: ' . $conn->error];
    }
}
?>