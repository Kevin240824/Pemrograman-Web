<?php
session_start();
include '../home/connect.php';

$count = 0;
if (isset($_SESSION['signup_id'])) {
    $signup_id = $_SESSION['signup_id'];
    $sql = "SELECT COUNT(*) AS count FROM keranjang WHERE signup_id = $signup_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $count = $row['count'];
}

echo json_encode(['count' => $count]);
?>