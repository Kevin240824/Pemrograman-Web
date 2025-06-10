<?php

$name = $_POST['nama'];
$email = $_POST['email'];
$pass = $_POST['password'];

$conn = new mysqli('localhost', 'root', '', 'cumbre_pack');

if ($conn->connect_error) {
    die('Connection failed:' .$conn->connect_error);
}else{
    $stmt = $conn->prepare("insert into sign_up(nama, email, password)
    values(?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $pass);
    $stmt->execute();
    echo "registration successfully";
    $stmt->close();
    $conn->close();
}
?>