<!DOCTYPE html>
<html>
<head>
    <title>Proses Login</title>
</head>
<body>
<?php
$username = $_POST['username'];
$password = $_POST['password'];

if ($username == "kevin" && $password == "kevin123") {
    echo "<p><b>Login berhasil!</b></p>";
    echo "<p>Selamat datang, <span style='color:blue; font-size:20px;'><b>$username</b></span>.</p>";
    echo "<a href='login.php' style='color:purple;'>kembali ke halaman login</a>";
} else {
    echo "<p><span style='color:red; font-size:18px;'><b>Username : $username Tidak Terdaftar!</b></span></p>";
    echo "<a href='login.php' style='color:purple;'>kembali ke halaman login</a>";
}
?>
</body>
</html>
