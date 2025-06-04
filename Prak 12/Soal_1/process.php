<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $position = $_POST['position'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $errors = [];

    if (empty($name)) {
        $errors[] = "Input Nama belum di isi!";
    }
    if (empty($password)) {
        $errors[] = "Input Password belum di isi!";
    }
    if (empty($confirm_password)) {
        $errors[] = "Input Confirm Password belum di isi!";
    }
    if (!empty($password) && !empty($confirm_password) && $password !== $confirm_password) {
        $errors[] = "Password dan Confirm Password belum sama!";
    }

    if (!empty($errors)) {
        header("Location: form.php?error=" . urlencode(implode('|', $errors)));
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hasil Input</title>
</head>
<body>
    <div style="border:1px solid black; padding:10px; width:300px;">
        <h3>Data yang Anda Masukkan!</h3>
        <p><strong>Name</strong> : <?= htmlspecialchars($name) ?></p>
        <p><strong>Position</strong> : <?= htmlspecialchars($position) ?></p>
        <a href="form.php">back</a>
    </div>
</body>
</html>
