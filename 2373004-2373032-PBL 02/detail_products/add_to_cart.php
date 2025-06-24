<?php
session_start();
include '../home/connect.php'; 

if (!isset($_SESSION['signup_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$required = ['variasi_id', 'qty', 'harga_satuan'];
foreach ($required as $field) {
    if (!isset($_POST[$field])) {
        echo json_encode(['success' => false, 'message' => 'Missing required data: ' . $field]);
        exit;
    }
}

$signup_id = $_SESSION['signup_id'];
$variasi_id = (int)$_POST['variasi_id'];
// tambah produk id
$qty = (int)$_POST['qty'];
$harga_satuan = (float)$_POST['harga_satuan'];

$stock_check = "SELECT qty_stock FROM variasi WHERE variasi_id = ?";
$stmt_stock = $conn->prepare($stock_check);
$stmt_stock->bind_param("i", $variasi_id);
$stmt_stock->execute();
$stock_result = $stmt_stock->get_result();

if ($stock_result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid product variation']);
    exit;
}

$stock_row = $stock_result->fetch_assoc();
$current_stock = $stock_row['qty_stock'];

if ($current_stock < $qty) {
    echo json_encode(['success' => false, 'message' => 'Not enough stock']);
    exit;
}

$cart_check = "SELECT keranjang_id, qty FROM keranjang 
               WHERE signup_id = ? AND variasi_id = ?";  
$stmt_check = $conn->prepare($cart_check);
$stmt_check->bind_param("ii", $signup_id, $variasi_id); 
$stmt_check->execute();
$cart_result = $stmt_check->get_result();

if ($cart_result->num_rows > 0) {
    $cart_row = $cart_result->fetch_assoc();
    $new_qty = $cart_row['qty'] + $qty;
    
    if ($current_stock < $new_qty) {
        echo json_encode(['success' => false, 'message' => 'Exceeds available stock']);
        exit;
    }
    
    $update_query = "UPDATE keranjang SET qty = ? 
                     WHERE keranjang_id = ?";
    $stmt_update = $conn->prepare($update_query);
    $stmt_update->bind_param("ii", $new_qty, $cart_row['keranjang_id']);
    $stmt_update->execute();
} else {
    $insert_query = "INSERT INTO keranjang (signup_id, variasi_id, qty, harga_satuan, created_at) 
                     VALUES (?, ?, ?, ?, NOW())";
    $stmt_insert = $conn->prepare($insert_query);
    $stmt_insert->bind_param("iiid", $signup_id, $variasi_id, $qty, $harga_satuan);
    $stmt_insert->execute();
}

$count_query = "SELECT COUNT(*) AS cart_count FROM keranjang WHERE signup_id = ?";
$stmt_count = $conn->prepare($count_query);
$stmt_count->bind_param("i", $signup_id);
$stmt_count->execute();
$count_result = $stmt_count->get_result()->fetch_assoc();

echo json_encode([
    'success' => true,
    'cart_count' => $count_result['cart_count'],
    'message' => 'Item added to cart successfully'
]);

$stmt_stock->close();
if (isset($stmt_check)) $stmt_check->close();
if (isset($stmt_update)) $stmt_update->close();
if (isset($stmt_insert)) $stmt_insert->close();
$stmt_count->close();
$conn->close();
?>