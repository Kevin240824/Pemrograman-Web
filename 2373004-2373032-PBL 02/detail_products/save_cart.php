<?php
session_start();
include '../home/connect.php';

// Periksa apakah user sudah login
if (!isset($_SESSION['signup_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

try {
    // Dapatkan variasi_id berdasarkan size dan warna
    $sql = "SELECT variasi_id FROM variasi 
            WHERE produk_id = :produk_id 
            AND size_id = (SELECT size_id FROM size WHERE size_name = :size)
            AND warna_id = (SELECT warna_id FROM warna WHERE jenis_warna = :warna)";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':produk_id' => $data['produk_id'],
        ':size' => $data['size'],
        ':warna' => $data['warna']
    ]);
    
    $variasi = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$variasi) {
        throw new Exception('Variasi tidak ditemukan');
    }

    // Cek apakah item sudah ada di keranjang
    $checkSql = "SELECT * FROM keranjang 
                 WHERE signup_id = :signup_id 
                 AND variasi_id = :variasi_id";
    
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->execute([
        ':signup_id' => $_SESSION['signup_id'],
        ':variasi_id' => $variasi['variasi_id']
    ]);
    
    if ($checkStmt->rowCount() > 0) {
        // Update qty jika sudah ada
        $updateSql = "UPDATE keranjang SET qty = qty + :qty 
                      WHERE signup_id = :signup_id 
                      AND variasi_id = :variasi_id";
        
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->execute([
            ':qty' => $data['qty'],
            ':signup_id' => $_SESSION['signup_id'],
            ':variasi_id' => $variasi['variasi_id']
        ]);
    } else {
        // Tambahkan baru jika belum ada
        $insertSql = "INSERT INTO keranjang 
                     (signup_id, variasi_id, qty, created_at, harga_satuan) 
                     VALUES 
                     (:signup_id, :variasi_id, :qty, NOW(), :harga)";
        
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->execute([
            ':signup_id' => $_SESSION['signup_id'],
            ':variasi_id' => $variasi['variasi_id'],
            ':qty' => $data['qty'],
            ':harga' => $data['harga']
        ]);
    }

    echo json_encode(['status' => 'success']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}



// Ubah query menjadi:
$sql = "SELECT variasi_id FROM variasi 
        WHERE produk_id = :produk_id 
        AND size_id = :size_id
        AND warna_id = :warna_id";
?>