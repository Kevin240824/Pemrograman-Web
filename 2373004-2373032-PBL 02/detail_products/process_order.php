<?php
// Aktifkan error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include '../home/connect.php';

// Cek koneksi database
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pastikan user sudah login
    if (!isset($_SESSION['signup_id'])) {
        header('Location: ../home/homepage.php');
        exit;
    }

    $signup_id = $_SESSION['signup_id'];

    // Validasi data yang diperlukan
    $required_fields = ['email', 'fullName', 'address', 'country', 'state', 'zip', 'phone', 'shipping_option', 'cart_items'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            die("Missing required field: $field");
        }
    }

    // Ambil data dari form
    $email = $_POST['email'];
    $nama = $_POST['fullName'];
    $alamat = $_POST['address'];
    $negara = $_POST['country'];
    $provinsi = $_POST['state'];
    $kode_zip = $_POST['zip'];
    $no_telp = $_POST['phone'];
    $opsi_pengiriman_id = (int)$_POST['shipping_option'];
    $cart_items = $_POST['cart_items'];

    // Loop melalui setiap item di keranjang
    foreach ($cart_items as $keranjang_id) {
        $keranjang_id = (int)$keranjang_id;
        
        // Query untuk mendapatkan item keranjang
        $sql = "SELECT k.variasi_id, k.qty, k.harga_satuan, v.produk_id 
                FROM keranjang k 
                JOIN variasi v ON k.variasi_id = v.variasi_id 
                WHERE k.keranjang_id = ?";
        
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }
        
        $stmt->bind_param("i", $keranjang_id);
        if (!$stmt->execute()) {
            die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        }
        
        $result = $stmt->get_result();
        $item = $result->fetch_assoc();

        if ($item) {
            // Query insert pesanan
            $insert_sql = "INSERT INTO pesanan (
                signup_id, 
                produk_id, 
                variasi_id,
                qty,
                harga_satuan,
                opsi_pengiriman_id, 
                email, 
                nama, 
                alamat, 
                negara, 
                provinsi, 
                kode_zip, 
                no_telp
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $insert_stmt = $conn->prepare($insert_sql);
            if (!$insert_stmt) {
                die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
            }
            
            // Format binding: 5 integer, 1 double, 7 string
            $bind_result = $insert_stmt->bind_param(
                "iiiidssssssss", 
                $signup_id,
                $item['produk_id'],
                $item['variasi_id'],
                $item['qty'],
                $item['harga_satuan'],
                $opsi_pengiriman_id,
                $email,
                $nama,
                $alamat,
                $negara,
                $provinsi,
                $kode_zip,
                $no_telp
            );
            
            if (!$bind_result) {
                die("Binding parameters failed: (" . $insert_stmt->errno . ") " . $insert_stmt->error);
            }
            
            if (!$insert_stmt->execute()) {
                die("Execute failed: (" . $insert_stmt->errno . ") " . $insert_stmt->error);
            }

            // Hapus item dari keranjang
            $delete_sql = "DELETE FROM keranjang WHERE keranjang_id = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("i", $keranjang_id);
            if (!$delete_stmt->execute()) {
                die("Delete failed: (" . $delete_stmt->errno . ") " . $delete_stmt->error);
            }
        }
    }

    // Redirect ke halaman payment
    header('Location: payment.php');
    exit;
} else {
    header('Location: order.php');
    exit;
}
?>