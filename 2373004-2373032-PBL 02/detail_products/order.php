<?php
session_start();
include '../home/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
  if ($_POST['action'] === 'add_to_cart') {
    // Add to cart logic
    if (!isset($_SESSION['signup_id'])) {
      echo json_encode(['success' => false, 'message' => 'You must login to add items to cart']);
      exit;
    }

    $signup_id = $_SESSION['signup_id'];
    $variasi_id = $_POST['variasi_id'];
    $qty = $_POST['quantity'];

    $sql_harga = "SELECT harga FROM produk WHERE produk_id = (SELECT produk_id FROM variasi WHERE variasi_id = $variasi_id)";
    $result_harga = $conn->query($sql_harga);
    $row_harga = $result_harga->fetch_assoc();
    $harga_satuan = $row_harga['harga'];

    $sql = "INSERT INTO keranjang (signup_id, variasi_id, qty, harga_satuan) 
                VALUES ($signup_id, $variasi_id, $qty, $harga_satuan)";

    if ($conn->query($sql)) {
      // Get updated cart count
      $sql_count = "SELECT COUNT(*) AS count FROM keranjang WHERE signup_id = $signup_id";
      $result_count = $conn->query($sql_count);
      $row_count = $result_count->fetch_assoc();

      echo json_encode([
        'success' => true,
        'cart_count' => $row_count['count']
      ]);
    } else {
      echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
    }
    exit;
  }
}

// Fungsi untuk menambahkan item ke keranjang
if (isset($_POST['add_to_cart'])) {
  // Pastikan user sudah login
  if (!isset($_SESSION['signup_id'])) {
    $_SESSION['login_error'] = "You must login to add items to cart";
    header("Location: #loginModal"); // Redirect ke modal login
    exit();
  }

  $signup_id = $_SESSION['signup_id'];
  $variasi_id = $_POST['variasi_id'];
  $qty = $_POST['quantity'];

  // Ambil harga produk dari database
  $sql_harga = "SELECT harga FROM produk WHERE produk_id = (SELECT produk_id FROM variasi WHERE variasi_id = $variasi_id)";
  $result_harga = $conn->query($sql_harga);
  $row_harga = $result_harga->fetch_assoc();
  $harga_satuan = $row_harga['harga'];

  // Masukkan ke database
  $sql = "INSERT INTO keranjang (signup_id, variasi_id, qty, harga_satuan) 
            VALUES ($signup_id, $variasi_id, $qty, $harga_satuan)";

  if ($conn->query($sql)) {
    $_SESSION['cart_success'] = "Item added to cart successfully!";
  } else {
    $_SESSION['cart_error'] = "Error: " . $conn->error;
  }
}

// Tampilkan pesan error signup
if (isset($_SESSION['signup_error'])) {
  echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            ' . htmlspecialchars($_SESSION['signup_error']) . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
  unset($_SESSION['signup_error']); // Hapus session setelah ditampilkan
}

// Tampilkan pesan sukses signup
if (isset($_GET['signup']) && $_GET['signup'] === 'success') {
  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Registration successful! You can now login.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
}

// Tampilkan pesan error signup -->
if (isset($_SESSION['login_error'])) {
  echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            ' . htmlspecialchars($_SESSION['login_error']) . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
  unset($_SESSION['login_error']); // Hapus session setelah ditampilkan
}

// Tampilkan pesan sukses signup -->
if (isset($_GET['login']) && $_GET['login'] === 'success') {
  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Registration successful! You can now ener.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
}

// Ambil data keranjang
$cartItems = [];
$subtotal = 0;

if (isset($_SESSION['signup_id'])) {
  $signup_id = $_SESSION['signup_id'];

  $sql = "SELECT k.keranjang_id, k.variasi_id, k.qty, k.harga_satuan, 
                   p.nama_produk, p.gambar_produk, 
                   s.size_name, w.jenis_warna
            FROM keranjang k
            JOIN variasi v ON k.variasi_id = v.variasi_id
            JOIN produk p ON v.produk_id = p.produk_id
            JOIN size s ON v.size_id = s.size_id
            JOIN warna w ON v.warna_id = w.warna_id
            WHERE k.signup_id = $signup_id";

  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $cartItems[] = $row;
      $subtotal += $row['harga_satuan'] * $row['qty'];
    }
  }
}

// Ambil opsi pengiriman dari database
$sql_shipping = "SELECT * FROM opsi_pengiriman";
$result_shipping = $conn->query($sql_shipping);
$shipping_options = [];
if ($result_shipping->num_rows > 0) {
    while ($row = $result_shipping->fetch_assoc()) {
        $shipping_options[] = $row;
    }
}

// Set default shipping option
$shipping = $shipping_options[0]['harga_pengiriman']; // Ambil dari database

// Ambil data keranjang
$cartItems = [];
$subtotal = 0;

if (isset($_SESSION['signup_id'])) {
    $signup_id = $_SESSION['signup_id'];

    $sql = "SELECT k.keranjang_id, k.variasi_id, k.qty, k.harga_satuan, 
                   p.nama_produk, p.gambar_produk, 
                   s.size_name, w.jenis_warna
            FROM keranjang k
            JOIN variasi v ON k.variasi_id = v.variasi_id
            JOIN produk p ON v.produk_id = p.produk_id
            JOIN size s ON v.size_id = s.size_id
            JOIN warna w ON v.warna_id = w.warna_id
            WHERE k.signup_id = $signup_id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $cartItems[] = $row;
            $subtotal += $row['harga_satuan'] * $row['qty'];
        }
    }
}

// Hitung biaya lain
$shipping = 15.00;
$taxRate = 0.08; // Pajak 8%
$tax = $subtotal * $taxRate;
$total = $subtotal + $shipping + $tax;



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shipping - CUMBREPACK</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
    rel="stylesheet">

  <link rel="stylesheet" href="shipping.css">

   <script>
    // Fungsi untuk mengupdate harga pengiriman dan total
    function updateShippingCost() {
      const selectedOption = document.querySelector('input[name="shipping_option"]:checked');
      const shippingPrice = parseFloat(selectedOption.dataset.price);
      const subtotal = <?php echo $subtotal; ?>;
      const taxRate = <?php echo $taxRate; ?>;
      
      // Update tampilan
      document.getElementById('shipping-cost').textContent = '$' + shippingPrice.toFixed(2);
      
      // Hitung ulang pajak dan total
      const tax = subtotal * taxRate;
      const total = subtotal + shippingPrice + tax;
      
      document.getElementById('tax').textContent = '$' + tax.toFixed(2);
      document.getElementById('total').textContent = '$' + total.toFixed(2);
      
      // Update hidden input
      document.getElementById('shipping_option').value = selectedOption.value;
    }
  </script>
</head>

<body>
  <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <defs>
      <symbol xmlns="http://www.w3.org/2000/svg" id="facebook" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M15.12 5.32H17V2.14A26.11 26.11 0 0 0 14.26 2c-2.72 0-4.58 1.66-4.58 4.7v2.62H6.61v3.56h3.07V22h3.68v-9.12h3.06l.46-3.56h-3.52V7.05c0-1.05.28-1.73 1.76-1.73Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="twitter" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M22.991 3.95a1 1 0 0 0-1.51-.86a7.48 7.48 0 0 1-1.874.794a5.152 5.152 0 0 0-3.374-1.242a5.232 5.232 0 0 0-5.223 5.063a11.032 11.032 0 0 1-6.814-3.924a1.012 1.012 0 0 0-.857-.365a.999.999 0 0 0-.785.5a5.276 5.276 0 0 0-.242 4.769l-.002.001a1.041 1.041 0 0 0-.496.89a3.042 3.042 0 0 0 .027.439a5.185 5.185 0 0 0 1.568 3.312a.998.998 0 0 0-.066.77a5.204 5.204 0 0 0 2.362 2.922a7.465 7.465 0 0 1-3.59.448A1 1 0 0 0 1.45 19.3a12.942 12.942 0 0 0 7.01 2.061a12.788 12.788 0 0 0 12.465-9.363a12.822 12.822 0 0 0 .535-3.646l-.001-.2a5.77 5.77 0 0 0 1.532-4.202Zm-3.306 3.212a.995.995 0 0 0-.234.702c.01.165.009.331.009.488a10.824 10.824 0 0 1-.454 3.08a10.685 10.685 0 0 1-10.546 7.93a10.938 10.938 0 0 1-2.55-.301a9.48 9.48 0 0 0 2.942-1.564a1 1 0 0 0-.602-1.786a3.208 3.208 0 0 1-2.214-.935q.224-.042.445-.105a1 1 0 0 0-.08-1.943a3.198 3.198 0 0 1-2.25-1.726a5.3 5.3 0 0 0 .545.046a1.02 1.02 0 0 0 .984-.696a1 1 0 0 0-.4-1.137a3.196 3.196 0 0 1-1.425-2.673c0-.066.002-.133.006-.198a13.014 13.014 0 0 0 8.21 3.48a1.02 1.02 0 0 0 .817-.36a1 1 0 0 0 .206-.867a3.157 3.157 0 0 1-.087-.729a3.23 3.23 0 0 1 3.226-3.226a3.184 3.184 0 0 1 2.345 1.02a.993.993 0 0 0 .921.298a9.27 9.27 0 0 0 1.212-.322a6.681 6.681 0 0 1-1.026 1.524Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="youtube" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M23 9.71a8.5 8.5 0 0 0-.91-4.13a2.92 2.92 0 0 0-1.72-1A78.36 78.36 0 0 0 12 4.27a78.45 78.45 0 0 0-8.34.3a2.87 2.87 0 0 0-1.46.74c-.9.83-1 2.25-1.1 3.45a48.29 48.29 0 0 0 0 6.48a9.55 9.55 0 0 0 .3 2a3.14 3.14 0 0 0 .71 1.36a2.86 2.86 0 0 0 1.49.78a45.18 45.18 0 0 0 6.5.33c3.5.05 6.57 0 10.2-.28a2.88 2.88 0 0 0 1.53-.78a2.49 2.49 0 0 0 .61-1a10.58 10.58 0 0 0 .52-3.4c.04-.56.04-3.94.04-4.54ZM9.74 14.85V8.66l5.92 3.11c-1.66.92-3.85 1.96-5.92 3.08Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="instagram" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M17.34 5.46a1.2 1.2 0 1 0 1.2 1.2a1.2 1.2 0 0 0-1.2-1.2Zm4.6 2.42a7.59 7.59 0 0 0-.46-2.43a4.94 4.94 0 0 0-1.16-1.77a4.7 4.7 0 0 0-1.77-1.15a7.3 7.3 0 0 0-2.43-.47C15.06 2 14.72 2 12 2s-3.06 0-4.12.06a7.3 7.3 0 0 0-2.43.47a4.78 4.78 0 0 0-1.77 1.15a4.7 4.7 0 0 0-1.15 1.77a7.3 7.3 0 0 0-.47 2.43C2 8.94 2 9.28 2 12s0 3.06.06 4.12a7.3 7.3 0 0 0 .47 2.43a4.7 4.7 0 0 0 1.15 1.77a4.78 4.78 0 0 0 1.77 1.15a7.3 7.3 0 0 0 2.43.47C8.94 22 9.28 22 12 22s3.06 0 4.12-.06a7.3 7.3 0 0 0 2.43-.47a4.7 4.7 0 0 0 1.77-1.15a4.85 4.85 0 0 0 1.16-1.77a7.59 7.59 0 0 0 .46-2.43c0-1.06.06-1.4.06-4.12s0-3.06-.06-4.12ZM20.14 16a5.61 5.61 0 0 1-.34 1.86a3.06 3.06 0 0 1-.75 1.15a3.19 3.19 0 0 1-1.15.75a5.61 5.61 0 0 1-1.86.34c-1 .05-1.37.06-4 .06s-3 0-4-.06a5.73 5.73 0 0 1-1.94-.3a3.27 3.27 0 0 1-1.1-.75a3 3 0 0 1-.74-1.15a5.54 5.54 0 0 1-.4-1.9c0-1-.06-1.37-.06-4s0-3 .06-4a5.54 5.54 0 0 1 .35-1.9A3 3 0 0 1 5 5a3.14 3.14 0 0 1 1.1-.8A5.73 5.73 0 0 1 8 3.86c1 0 1.37-.06 4-.06s3 0 4 .06a5.61 5.61 0 0 1 1.86.34a3.06 3.06 0 0 1 1.19.8a3.06 3.06 0 0 1 .75 1.1a5.61 5.61 0 0 1 .34 1.9c.05 1 .06 1.37.06 4s-.01 3-.06 4ZM12 6.87A5.13 5.13 0 1 0 17.14 12A5.12 5.12 0 0 0 12 6.87Zm0 8.46A3.33 3.33 0 1 1 15.33 12A3.33 3.33 0 0 1 12 15.33Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="amazon" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M1.04 17.52q.1-.16.32-.02a21.308 21.308 0 0 0 10.88 2.9a21.524 21.524 0 0 0 7.74-1.46q.1-.04.29-.12t.27-.12a.356.356 0 0 1 .47.12q.17.24-.11.44q-.36.26-.92.6a14.99 14.99 0 0 1-3.84 1.58A16.175 16.175 0 0 1 12 22a16.017 16.017 0 0 1-5.9-1.09a16.246 16.246 0 0 1-4.98-3.07a.273.273 0 0 1-.12-.2a.215.215 0 0 1 .04-.12Zm6.02-5.7a4.036 4.036 0 0 1 .68-2.36A4.197 4.197 0 0 1 9.6 7.98a10.063 10.063 0 0 1 2.66-.66q.54-.06 1.76-.16v-.34a3.562 3.562 0 0 0-.28-1.72a1.5 1.5 0 0 0-1.32-.6h-.16a2.189 2.189 0 0 0-1.14.42a1.64 1.64 0 0 0-.62 1a.508.508 0 0 1-.4.46L7.8 6.1q-.34-.08-.34-.36a.587.587 0 0 1 .02-.14a3.834 3.834 0 0 1 1.67-2.64A6.268 6.268 0 0 1 12.26 2h.5a5.054 5.054 0 0 1 3.56 1.18a3.81 3.81 0 0 1 .37.43a3.875 3.875 0 0 1 .27.41a2.098 2.098 0 0 1 .18.52q.08.34.12.47a2.856 2.856 0 0 1 .06.56q.02.43.02.51v4.84a2.868 2.868 0 0 0 .15.95a2.475 2.475 0 0 0 .29.62q.14.19.46.61a.599.599 0 0 1 .12.32a.346.346 0 0 1-.16.28q-1.66 1.44-1.8 1.56a.557.557 0 0 1-.58.04q-.28-.24-.49-.46t-.3-.32a4.466 4.466 0 0 1-.29-.39q-.2-.29-.28-.39a4.91 4.91 0 0 1-2.2 1.52a6.038 6.038 0 0 1-1.68.2a3.505 3.505 0 0 1-2.53-.95a3.553 3.553 0 0 1-.99-2.69Zm3.44-.4a1.895 1.895 0 0 0 .39 1.25a1.294 1.294 0 0 0 1.05.47a1.022 1.022 0 0 0 .17-.02a1.022 1.022 0 0 1 .15-.02a2.033 2.033 0 0 0 1.3-1.08a3.13 3.13 0 0 0 .33-.83a3.8 3.8 0 0 0 .12-.73q.01-.28.01-.92v-.5a7.287 7.287 0 0 0-1.76.16a2.144 2.144 0 0 0-1.76 2.22Zm8.4 6.44a.626.626 0 0 1 .12-.16a3.14 3.14 0 0 1 .96-.46a6.52 6.52 0 0 1 1.48-.22a1.195 1.195 0 0 1 .38.02q.9.08 1.08.3a.655.655 0 0 1 .08.36v.14a4.56 4.56 0 0 1-.38 1.65a3.84 3.84 0 0 1-1.06 1.53a.302.302 0 0 1-.18.08a.177.177 0 0 1-.08-.02q-.12-.06-.06-.22a7.632 7.632 0 0 0 .74-2.42a.513.513 0 0 0-.08-.32q-.2-.24-1.12-.24q-.34 0-.8.04q-.5.06-.92.12a.232.232 0 0 1-.16-.04a.065.065 0 0 1-.02-.08a.153.153 0 0 1 .02-.06Z" />
      </symbol>

      <symbol xmlns="http://www.w3.org/2000/svg" id="menu" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M2 6a1 1 0 0 1 1-1h18a1 1 0 1 1 0 2H3a1 1 0 0 1-1-1m0 6.032a1 1 0 0 1 1-1h18a1 1 0 1 1 0 2H3a1 1 0 0 1-1-1m1 5.033a1 1 0 1 0 0 2h18a1 1 0 0 0 0-2z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="link" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M12 19a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm5 0a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm0-4a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm-5 0a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm7-12h-1V2a1 1 0 0 0-2 0v1H8V2a1 1 0 0 0-2 0v1H5a3 3 0 0 0-3 3v14a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3Zm1 17a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-9h16Zm0-11H4V6a1 1 0 0 1 1-1h1v1a1 1 0 0 0 2 0V5h8v1a1 1 0 0 0 2 0V5h1a1 1 0 0 1 1 1ZM7 15a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm0 4a1 1 0 1 0-1-1a1 1 0 0 0 1 1Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="arrow-right" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M17.92 11.62a1 1 0 0 0-.21-.33l-5-5a1 1 0 0 0-1.42 1.42l3.3 3.29H7a1 1 0 0 0 0 2h7.59l-3.3 3.29a1 1 0 0 0 0 1.42a1 1 0 0 0 1.42 0l5-5a1 1 0 0 0 .21-.33a1 1 0 0 0 0-.76Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="category" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M19 5.5h-6.28l-.32-1a3 3 0 0 0-2.84-2H5a3 3 0 0 0-3 3v13a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3v-10a3 3 0 0 0-3-3Zm1 13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-13a1 1 0 0 1 1-1h4.56a1 1 0 0 1 .95.68l.54 1.64a1 1 0 0 0 .95.68h7a1 1 0 0 1 1 1Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="calendar" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M19 4h-2V3a1 1 0 0 0-2 0v1H9V3a1 1 0 0 0-2 0v1H5a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3Zm1 15a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-7h16Zm0-9H4V7a1 1 0 0 1 1-1h2v1a1 1 0 0 0 2 0V6h6v1a1 1 0 0 0 2 0V6h2a1 1 0 0 1 1 1Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="heart" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M20.16 4.61A6.27 6.27 0 0 0 12 4a6.27 6.27 0 0 0-8.16 9.48l7.45 7.45a1 1 0 0 0 1.42 0l7.45-7.45a6.27 6.27 0 0 0 0-8.87Zm-1.41 7.46L12 18.81l-6.75-6.74a4.28 4.28 0 0 1 3-7.3a4.25 4.25 0 0 1 3 1.25a1 1 0 0 0 1.42 0a4.27 4.27 0 0 1 6 6.05Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="plus" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M19 11h-6V5a1 1 0 0 0-2 0v6H5a1 1 0 0 0 0 2h6v6a1 1 0 0 0 2 0v-6h6a1 1 0 0 0 0-2Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="minus" viewBox="0 0 24 24">
        <path fill="currentColor" d="M19 11H5a1 1 0 0 0 0 2h14a1 1 0 0 0 0-2Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="cart" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M8.5 19a1.5 1.5 0 1 0 1.5 1.5A1.5 1.5 0 0 0 8.5 19ZM19 16H7a1 1 0 0 1 0-2h8.491a3.013 3.013 0 0 0 2.885-2.176l1.585-5.55A1 1 0 0 0 19 5H6.74a3.007 3.007 0 0 0-2.82-2H3a1 1 0 0 0 0 2h.921a1.005 1.005 0 0 1 .962.725l.155.545v.005l1.641 5.742A3 3 0 0 0 7 18h12a1 1 0 0 0 0-2Zm-1.326-9l-1.22 4.274a1.005 1.005 0 0 1-.963.726H8.754l-.255-.892L7.326 7ZM16.5 19a1.5 1.5 0 1 0 1.5 1.5a1.5 1.5 0 0 0-1.5-1.5Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="check" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M18.71 7.21a1 1 0 0 0-1.42 0l-7.45 7.46l-3.13-3.14A1 1 0 1 0 5.29 13l3.84 3.84a1 1 0 0 0 1.42 0l8.16-8.16a1 1 0 0 0 0-1.47Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="trash" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M10 18a1 1 0 0 0 1-1v-6a1 1 0 0 0-2 0v6a1 1 0 0 0 1 1ZM20 6h-4V5a3 3 0 0 0-3-3h-2a3 3 0 0 0-3 3v1H4a1 1 0 0 0 0 2h1v11a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V8h1a1 1 0 0 0 0-2ZM10 5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v1h-4Zm7 14a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V8h10Zm-3-1a1 1 0 0 0 1-1v-6a1 1 0 0 0-2 0v6a1 1 0 0 0 1 1Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="search" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M21.71 20.29L18 16.61A9 9 0 1 0 16.61 18l3.68 3.68a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.39ZM11 18a7 7 0 1 1 7-7a7 7 0 0 1-7 7Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="close" viewBox="0 0 15 15">
        <path fill="currentColor"
          d="M7.953 3.788a.5.5 0 0 0-.906 0L6.08 5.85l-2.154.33a.5.5 0 0 0-.283.843l1.574 1.613l-.373 2.284a.5.5 0 0 0 .736.518l1.92-1.063l1.921 1.063a.5.5 0 0 0 .736-.519l-.373-2.283l1.574-1.613a.5.5 0 0 0-.283-.844L8.921 5.85l-.968-2.062Z" />
      </symbol>

      <symbol xmlns="http://www.w3.org/2000/svg" id="bag-heart" viewBox="0 0 24 24">
        <path fill="currentColor" fill-rule="evenodd"
          d="M12 2.75A2.25 2.25 0 0 0 9.75 5v.26c.557-.01 1.168-.01 1.84-.01h.821c.67 0 1.282 0 1.84.01V5A2.25 2.25 0 0 0 12 2.75m3.75 2.578V5a3.75 3.75 0 1 0-7.5 0v.328q-.214.018-.414.043c-1.01.125-1.842.387-2.55.974S4.168 7.702 3.86 8.672c-.3.94-.526 2.147-.81 3.666l-.021.11c-.402 2.143-.718 3.832-.777 5.163c-.06 1.365.144 2.495.914 3.422c.77.928 1.843 1.336 3.195 1.529c1.32.188 3.037.188 5.218.188h.845c2.18 0 3.898 0 5.217-.188c1.352-.193 2.426-.601 3.196-1.529s.972-2.057.913-3.422c-.058-1.331-.375-3.02-.777-5.163l-.02-.11c-.285-1.519-.512-2.727-.81-3.666c-.31-.97-.72-1.74-1.428-2.327c-.707-.587-1.54-.85-2.55-.974a11 11 0 0 0-.414-.043M8.02 6.86c-.855.105-1.372.304-1.776.64c-.403.334-.694.805-.956 1.627c-.267.84-.478 1.958-.774 3.537c-.416 2.217-.711 3.8-.764 5.013c-.052 1.19.14 1.88.569 2.399c.43.517 1.073.832 2.253 1c1.2.172 2.812.174 5.068.174h.72c2.257 0 3.867-.002 5.068-.173c1.18-.169 1.823-.484 2.253-1.001c.43-.518.621-1.208.57-2.4c-.054-1.211-.349-2.795-.765-5.012c-.296-1.58-.506-2.696-.774-3.537c-.262-.822-.552-1.293-.956-1.628s-.92-.534-1.776-.64c-.876-.108-2.013-.109-3.62-.109h-.72c-1.607 0-2.744.001-3.62.11m2.222 5.43c-.23.08-.492.33-.492.907c0 .214.141.545.51.971c.348.403.809.786 1.227 1.093c.226.166.333.242.42.288c.054.029.069.029.093.029c.025 0 .04 0 .094-.03a4 4 0 0 0 .42-.287c.418-.307.878-.69 1.227-1.093c.368-.426.51-.757.51-.971c0-.576-.263-.827-.493-.907c-.25-.088-.714-.06-1.24.443a.75.75 0 0 1-1.037 0c-.525-.503-.989-.531-1.239-.443M12 11.234c-.716-.471-1.525-.616-2.254-.36c-.933.327-1.496 1.226-1.496 2.323c0 .77.441 1.45.875 1.952c.453.525 1.014.984 1.474 1.321l.07.052c.352.26.752.556 1.331.556c.58 0 .98-.296 1.33-.556l.07-.052c.461-.337 1.022-.796 1.475-1.32c.434-.502.875-1.183.875-1.953c0-1.097-.562-1.996-1.495-2.323c-.73-.256-1.539-.111-2.255.36"
          clip-rule="evenodd" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="hand-stars" viewBox="0 0 24 24">
        <path fill="currentColor" fill-rule="evenodd"
          d="M12 2.9a13 13 0 0 0-.484.829l-.13.235l-.03.054c-.11.198-.257.466-.5.65c-.249.189-.548.255-.762.302l-.058.013l-.255.057c-.465.106-.755.173-.95.241c.12.181.323.42.651.804l.174.202l.04.047c.147.17.344.398.435.69c.09.29.059.589.036.817l-.006.062l-.027.271c-.047.484-.075.797-.075 1.018c.193-.068.456-.188.858-.373l.238-.11l.055-.025c.198-.093.478-.224.79-.224s.592.131.79.224l.055.025l.238.11c.402.185.665.305.858.373c0-.221-.028-.534-.075-1.018l-.027-.27l-.006-.063c-.023-.228-.053-.528.037-.817c.09-.292.287-.52.435-.69l.04-.047l.173-.202c.328-.384.53-.623.65-.804c-.194-.068-.484-.135-.95-.24l-.254-.058l-.058-.013c-.214-.047-.513-.113-.761-.302c-.244-.184-.391-.452-.5-.65l-.03-.054l-.131-.235A13 13 0 0 0 12 2.9m2.153 6.35h.002zm-4.308 0h.002zm1.038-7.365c.216-.282.568-.635 1.117-.635c.55 0 .901.353 1.117.635c.208.271.42.653.651 1.067l.026.046l.13.235l.133.23l.065.017l.173.04l.255.057l.052.012c.447.101.864.195 1.179.32c.341.134.753.376.912.887c.157.503-.036.937-.23 1.246c-.183.29-.465.62-.771.978l-.207.242l-.176.211c.002.056.009.135.024.286l.03.321c.047.48.09.917.074 1.261c-.016.358-.1.838-.525 1.16c-.438.333-.927.268-1.274.168c-.325-.093-.715-.272-1.133-.465l-.049-.022l-.238-.11L12 9.974l-.055.024l-.163.074l-.238.11l-.049.022c-.418.193-.808.372-1.133.465c-.347.1-.836.165-1.273-.168c-.426-.322-.51-.802-.526-1.16c-.016-.344.027-.781.073-1.26l.005-.052l.027-.27a5 5 0 0 0 .023-.286l-.057-.071l-.118-.14l-.174-.203l-.034-.039c-.306-.358-.588-.688-.77-.978c-.195-.309-.388-.743-.231-1.246c.159-.51.571-.753.912-.887c.315-.125.732-.219 1.18-.32l.051-.012l.255-.057l.239-.057l.04-.069l.091-.16l.131-.236l.026-.046c.23-.414.444-.796.651-1.067M4 8.202c.052.096.163.293.346.43c.195.15.43.2.528.22l.025.005l.02.005l-.032.038l-.018.02c-.068.079-.222.253-.292.48c-.07.225-.045.455-.033.56q0 .015.003.028v.011A1.3 1.3 0 0 0 4 9.855c-.24 0-.453.099-.548.144l.002-.011l.003-.028c.011-.105.036-.335-.034-.56c-.07-.227-.224-.401-.292-.48l-.018-.02l-.033-.038l.02-.005l.026-.005c.097-.02.333-.07.529-.22A1.3 1.3 0 0 0 4 8.202m-1.065-.076l-.142-.627zm.471 2.506v.003zm1.188.003v-.003zm-1.45-3.92c.129-.169.402-.465.856-.465s.728.296.856.464c.121.159.24.372.35.568l.018.034l.05.088l.084.019l.039.009c.21.047.445.1.63.173c.212.084.548.265.678.682c.127.409-.038.747-.156.934a5 5 0 0 1-.435.552l-.073.086l.012.12l.003.039c.023.226.046.47.037.67c-.01.212-.062.597-.41.861c-.362.274-.755.207-.967.146a4.6 4.6 0 0 1-.645-.264L4 11.4l-.071.033l-.037.016a5 5 0 0 1-.608.247c-.212.061-.605.128-.966-.146c-.35-.264-.402-.649-.411-.862c-.01-.2.015-.443.037-.67l.003-.038l.012-.12l-.073-.086l-.026-.03a5 5 0 0 1-.409-.522c-.118-.187-.283-.525-.156-.934c.13-.417.466-.598.677-.682a4.6 4.6 0 0 1 .67-.182l.085-.02l.049-.087l.019-.034c.11-.196.228-.41.349-.568M20 8.201c.052.096.163.293.346.43a1.3 1.3 0 0 0 .553.225l.02.005l-.032.038l-.018.02a1.4 1.4 0 0 0-.292.48c-.07.225-.045.455-.033.56q0 .015.003.028v.011A1.3 1.3 0 0 0 20 9.855c-.24 0-.453.099-.547.144v-.011l.003-.028a1.4 1.4 0 0 0-.033-.56a1.4 1.4 0 0 0-.292-.48l-.018-.02l-.033-.038l.02-.005l.026-.005c.097-.02.333-.07.528-.22c.183-.137.294-.334.346-.43m-.594 2.43v.003zm-.262-3.918c.129-.168.402-.464.856-.464s.727.296.856.464c.121.159.24.372.35.568l.018.034l.05.088l.084.019l.039.009c.21.047.446.1.63.173c.212.084.548.265.678.682c.127.409-.038.747-.156.934c-.107.169-.265.353-.41.523l-.025.03l-.073.085l.012.12l.003.039c.022.226.046.47.037.67c-.01.212-.062.597-.41.861c-.362.274-.755.207-.967.146c-.191-.055-.41-.156-.608-.247q-.018-.007-.037-.017L20 11.4l-.071.033l-.037.016a5 5 0 0 1-.608.247c-.212.061-.605.128-.966-.146c-.35-.264-.402-.649-.411-.862c-.01-.2.015-.443.037-.67l.003-.038l.012-.12l-.073-.086l-.026-.03a5 5 0 0 1-.409-.522c-.117-.187-.283-.525-.156-.934c.13-.417.466-.598.677-.682a4.6 4.6 0 0 1 .67-.182l.085-.02l.049-.087l.019-.034c.11-.196.228-.41.349-.568m1.45 3.92v-.002zm-11.91 3.814c1.866-.361 3.863-.28 5.48.684c.226.135.44.304.625.512c.376.423.57.947.579 1.473q.286-.186.577-.407l1.808-1.365a2.64 2.64 0 0 1 3.124 0c.835.63 1.169 1.763.57 2.723c-.425.681-1.066 1.624-1.717 2.228c-.66.61-1.597 1.124-2.306 1.466c-.862.416-1.792.646-2.697.792c-1.85.3-3.774.254-5.602-.123a14.3 14.3 0 0 0-2.865-.293H4a.75.75 0 0 1 0-1.5h2.26c1.062 0 2.135.111 3.168.324a14.1 14.1 0 0 0 5.06.111c.828-.134 1.602-.333 2.284-.662c.683-.33 1.451-.764 1.938-1.215c.493-.457 1.044-1.248 1.465-1.922c.127-.204.109-.497-.202-.732c-.37-.28-.947-.28-1.316 0l-1.808 1.365c-.72.545-1.609 1.128-2.71 1.304a9 9 0 0 1-.347.048q-.086.015-.179.02a10 10 0 0 1-1.932 0a.75.75 0 1 1 .141-1.493a8.5 8.5 0 0 0 1.668-.003l.03-.003a.742.742 0 0 0 .15-1.138a1.2 1.2 0 0 0-.275-.222c-1.181-.705-2.759-.822-4.426-.5a12.1 12.1 0 0 0-4.535 1.935a.75.75 0 0 1-.868-1.224a13.6 13.6 0 0 1 5.118-2.183"
          clip-rule="evenodd" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="delivery" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M15.543 9.517a.75.75 0 1 0-1.086-1.034l-2.314 2.43l-.6-.63a.75.75 0 1 0-1.086 1.034l1.143 1.2a.75.75 0 0 0 1.086 0z" />
        <path fill="currentColor" fill-rule="evenodd"
          d="M1.293 2.751a.75.75 0 0 1 .956-.459l.301.106c.617.217 1.14.401 1.553.603c.44.217.818.483 1.102.899c.282.412.399.865.452 1.362l.011.108H17.12c.819 0 1.653 0 2.34.077c.35.039.697.101 1.003.209c.3.105.631.278.866.584c.382.496.449 1.074.413 1.66c-.035.558-.173 1.252-.338 2.077l-.01.053l-.002.004l-.508 2.47c-.15.726-.276 1.337-.439 1.82c-.172.51-.41.96-.837 1.308c-.427.347-.916.49-1.451.556c-.505.062-1.13.062-1.87.062H10.88c-1.345 0-2.435 0-3.293-.122c-.897-.127-1.65-.4-2.243-1.026c-.547-.576-.839-1.188-.985-2.042c-.137-.8-.15-1.848-.15-3.3V7.038c0-.74-.002-1.235-.043-1.615c-.04-.363-.109-.545-.2-.677c-.087-.129-.22-.25-.524-.398c-.323-.158-.762-.314-1.43-.549l-.26-.091a.75.75 0 0 1-.46-.957M5.708 6.87v2.89c0 1.489.018 2.398.13 3.047c.101.595.274.925.594 1.263c.273.288.65.472 1.365.573c.74.105 1.724.107 3.14.107h5.304c.799 0 1.33-.001 1.734-.05c.382-.047.56-.129.685-.231s.24-.26.364-.625c.13-.385.238-.905.4-1.688l.498-2.42v-.002c.178-.89.295-1.482.322-1.926c.026-.422-.04-.569-.101-.65a.6.6 0 0 0-.177-.087a3.2 3.2 0 0 0-.672-.134c-.595-.066-1.349-.067-2.205-.067zM5.25 19.5a2.25 2.25 0 1 0 4.5 0a2.25 2.25 0 0 0-4.5 0m2.25.75a.75.75 0 1 1 0-1.5a.75.75 0 0 1 0 1.5m6.75-.75a2.25 2.25 0 1 0 4.5 0a2.25 2.25 0 0 0-4.5 0m2.25.75a.75.75 0 1 1 0-1.5a.75.75 0 0 1 0 1.5"
          clip-rule="evenodd" />
      </symbol>

      <symbol xmlns="http://www.w3.org/2000/svg" id="star-full" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="m3.1 11.3l3.6 3.3l-1 4.6c-.1.6.1 1.2.6 1.5c.2.2.5.3.8.3c.2 0 .4 0 .6-.1c0 0 .1 0 .1-.1l4.1-2.3l4.1 2.3s.1 0 .1.1c.5.2 1.1.2 1.5-.1c.5-.3.7-.9.6-1.5l-1-4.6c.4-.3 1-.9 1.6-1.5l1.9-1.7l.1-.1c.4-.4.5-1 .3-1.5s-.6-.9-1.2-1h-.1l-4.7-.5l-1.9-4.3s0-.1-.1-.1c-.1-.7-.6-1-1.1-1c-.5 0-1 .3-1.3.8c0 0 0 .1-.1.1L8.7 8.2L4 8.7h-.1c-.5.1-1 .5-1.2 1c-.1.6 0 1.2.4 1.6" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="star-half" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="m3.1 11.3l3.6 3.3l-1 4.6c-.1.6.1 1.2.6 1.5c.2.2.5.3.8.3c.2 0 .4 0 .6-.1c0 0 .1 0 .1-.1l4.1-2.3l4.1 2.3s.1 0 .1.1c.5.2 1.1.2 1.5-.1c.5-.3.7-.9.6-1.5l-1-4.6c.4-.3 1-.9 1.6-1.5l1.9-1.7l.1-.1c.4-.4.5-1 .3-1.5s-.6-.9-1.2-1h-.1l-4.7-.5l-1.9-4.3s0-.1-.1-.1c-.1-.7-.6-1-1.1-1c-.5 0-1 .3-1.3.8c0 0 0 .1-.1.1L8.7 8.2L4 8.7h-.1c-.5.1-1 .5-1.2 1c-.1.6 0 1.2.4 1.6m8.9 5V5.8l1.7 3.8c.1.3.5.5.8.6l4.2.5l-3.1 2.8c-.3.2-.4.6-.3 1c0 .2.5 2.2.8 4.1l-3.6-2.1c-.2-.2-.3-.2-.5-.2" />
      </symbol>

      <symbol xmlns="http://www.w3.org/2000/svg" id="user" viewBox="0 0 24 24">
        <g fill="none" stroke="currentColor" stroke-width="1.5">
          <circle cx="12" cy="9" r="3" />
          <circle cx="12" cy="12" r="10" />
          <path stroke-linecap="round" d="M17.97 20c-.16-2.892-1.045-5-5.97-5s-5.81 2.108-5.97 5" />
        </g>
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="wishlist" viewBox="0 0 24 24">
        <g fill="none" stroke="currentColor" stroke-width="1.5">
          <path
            d="M21 16.09v-4.992c0-4.29 0-6.433-1.318-7.766C18.364 2 16.242 2 12 2C7.757 2 5.636 2 4.318 3.332C3 4.665 3 6.81 3 11.098v4.993c0 3.096 0 4.645.734 5.321c.35.323.792.526 1.263.58c.987.113 2.14-.907 4.445-2.946c1.02-.901 1.529-1.352 2.118-1.47c.29-.06.59-.06.88 0c.59.118 1.099.569 2.118 1.47c2.305 2.039 3.458 3.059 4.445 2.945c.47-.053.913-.256 1.263-.579c.734-.676.734-2.224.734-5.321Z" />
          <path stroke-linecap="round" d="M15 6H9" />
        </g>
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="shopping-bag" viewBox="0 0 24 24">
        <g fill="none" stroke="currentColor" stroke-width="1.5">
          <path
            d="M3.864 16.455c-.858-3.432-1.287-5.147-.386-6.301C4.378 9 6.148 9 9.685 9h4.63c3.538 0 5.306 0 6.207 1.154c.901 1.153.472 2.87-.386 6.301c-.546 2.183-.818 3.274-1.632 3.91c-.814.635-1.939.635-4.189.635h-4.63c-2.25 0-3.375 0-4.189-.635c-.814-.636-1.087-1.727-1.632-3.91Z" />
          <path
            d="m19.5 9.5l-.71-2.605c-.274-1.005-.411-1.507-.692-1.886A2.5 2.5 0 0 0 17 4.172C16.56 4 16.04 4 15 4M4.5 9.5l.71-2.605c.274-1.005.411-1.507.692-1.886A2.5 2.5 0 0 1 7 4.172C7.44 4 7.96 4 9 4" />
          <path d="M9 4a1 1 0 0 1 1-1h4a1 1 0 1 1 0 2h-4a1 1 0 0 1-1-1Z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M8 13v4m8-4v4m-4-4v4" />
        </g>
      </symbol>

    </defs>
  </svg>

  <div class="preloader-wrapper">
    <div class="preloader">
    </div>
  </div>

  <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasCart">
    <div class="offcanvas-header justify-content-center">
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <div class="order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary">Your cart</span>
          <span class="badge bg-primary rounded-pill" id="cartCount">0</span>
        </h4>
        <ul class="list-group mb-3" id="cartItems">
          <!-- Item cart akan ditambahkan di sini secara dinamis -->
        </ul>
        <button class="w-100 btn btn-primary btn-lg" type="button" id="continueToCheckout">Continue to checkout</button>
      </div>
    </div>
  </div>

  <!-- Header -->
  <header>
    <div class="container-fluid">
      <div class="row py-4">

        <div
          class="col-sm-4 col-lg-2 text-center text-sm-start d-flex gap-3 justify-content-center justify-content-md-start">
          <div class="d-flex align-items-center my-3 my-sm-0">
            <!-- <a href="homepage.html"> -->
            <a href="../home/homepage.php" class="nav-link">
              <h3>CUMBREPACK</h3>
            </a>
            </a>
          </div>
        </div>

        <div class="col-sm-6 offset-sm-2 offset-md-0 col-lg-4">
          <div class="search-bar row border border-light-subtle bg-light p-2 py-1 rounded-1">
            <div class="col-md-4 d-none d-md-block">
              <select class="form-select border-0 bg-transparent" onchange="location = this.value;">
                <option value="#">All Categories</option>
                <option value="men.html">Men</option>
                <option value="women.html">Women</option>
              </select>
            </div>

            <div class="col-11 col-md-7">
              <form id="search-form" class="text-center" action="index.html" method="post">
                <input type="text" class="form-control border-0 bg-transparent"
                  placeholder="Find your choice of clothing">
              </form>
            </div>
            <div class="col-1">
              <a href="#">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                  <path fill="currentColor"
                    d="M21.71 20.29L18 16.61A9 9 0 1 0 16.61 18l3.68 3.68a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.39ZM11 18a7 7 0 1 1 7-7a7 7 0 0 1-7 7Z" />
                </svg>
              </a>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <ul
            class="navbar-nav list-unstyled d-flex flex-row gap-3 gap-lg-5 justify-content-center flex-wrap align-items-center mb-0 fw-bold text-uppercase text-dark">
            <li class="nav-item active">
              <a href="../home/homepage.php" class="nav-link">Home</a>
            </li>
            <li class="nav-item">
              <a href="../home/onSale.php" class="nav-link">Sale</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle pe-3" role="button" id="pages" data-bs-toggle="dropdown"
                aria-expanded="false">Pages</a>
              <ul class="dropdown-menu border-0 rounded-0 shadow" aria-labelledby="pages">
                <li><a href="../footer/Aboutus_footer.html" class="dropdown-item">About Us </a></li>
                <li><a href="../footer/Newspage_footer.html" class="dropdown-item">Our Blog </a></li>
                <li><a href="../footer/Sustainbility_footer.html.html" class="dropdown-item">Sustainibility </a></li>
                <li><a href="../footer/FAQ_footer.html" class="dropdown-item">FAQ </a></li>
                <li><a href="../footer/Contact_footer.html" class="dropdown-item">Contact </a></li>
                <li><a href="history.html" class="dropdown-item">History </a></li>
              </ul>
            </li>
          </ul>
        </div>

        <div class="col-sm-8 col-lg-2 d-flex gap-5 align-items-center justify-content-center justify-content-sm-end">
          <!-- Bagian awal - Tombol Login & Sign Up -->
          <div class="auth-section">
            <a href="#" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
            <a href="#" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#signupModal">Sign Up</a>
          </div>


          <!-- Login Modal -->
          <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="loginModalLabel">Login to Your Account</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <?php if (isset($_SESSION['login_error'])): ?>
                    <div class="alert alert-danger">
                      <?php echo $_SESSION['login_error'];
                      unset($_SESSION['login_error']); ?>
                    </div>
                  <?php endif; ?>

                  <form action="../home/process_login.php" method="post">
                    <div class="mb-3">
                      <label for="loginEmail" class="form-label">Email address</label>
                      <input type="email" class="form-control" name="email" id="loginEmail" required>
                    </div>
                    <div class="mb-3">
                      <label for="loginPassword" class="form-label">Password</label>
                      <input type="password" class="form-control" name="password" id="loginPassword" required>
                    </div>
                    <div class="mb-3 form-check">
                      <input type="checkbox" class="form-check-input" id="rememberMe">
                      <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                  </form>
                  <div class="text-center mt-3">
                    <p>Don't have an account? <a href="#" data-bs-toggle="modal" data-bs-target="#signupModal"
                        data-bs-dismiss="modal">Sign up</a></p>
                    <p><a href="#" data-bs-toggle="modal" data-bs-target="#forgotModal" data-bs-dismiss="modal">Forgot
                        Password?</a></p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Signup Modal -->
          <div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="signupModalLabel">Create New Account</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                  <form action="../home/process_signup.php" method="post">
                    <div class="mb-3">
                      <label for="nama" class="form-label">Full Name</label>
                      <input type="text" class="form-control" name="nama" id="nama" required>
                    </div>
                    <div class="mb-3">
                      <label for="email" class="form-label">Email address</label>
                      <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="mb-3">
                      <label for="password" class="form-label">Password</label>
                      <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <input type="submit" class="btn btn-primary w-100" name="user" value="Sign Up">
                  </form>

                  <!-- <div class="mb-3">
          <label for="signupConfirmPassword" class="form-label">Confirm Password</label>
          <input type="password" class="form-control" id="signupConfirmPassword" required>
        </div> -->


                  <div class="text-center mt-3">
                    <p>Already have an account? <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal"
                        data-bs-dismiss="modal">Login</a></p>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <!-- Forgot Modal -->
          <div class="modal fade" id="forgotModal" tabindex="-1" aria-labelledby="forgotModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="forgotModalLabel"> Reset Your Account</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <?php if (isset($_SESSION['forgot_error'])): ?>
                    <div class="alert alert-danger">
                      <?php echo $_SESSION['forgot_error'];
                      unset($_SESSION['forgot_error']); ?>
                    </div>
                  <?php endif; ?>

                  <form action="../home/process_forgot.php" method="post">
                    <div class="mb-3">
                      <label for="nama" class="form-label">Username</label>
                      <input type="text" class="form-control" name="nama" id="nama" required>
                    </div>
                    <div class="mb-3">
                      <label for="email" class="form-label">Email address</label>
                      <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="mb-3">
                      <label for="password" class="form-label">Password</label>
                      <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <div class="mb-3">
                      <label for="con_password" class="form-label">Confirm Password</label>
                      <input type="password" class="form-control" name="con_password" id="con_password" required>
                    </div>
                    <input type="submit" class="btn btn-primary w-100" name="user" value="Reset">
                  </form>
                  <div class="text-center mt-3">
                    <p>Don't have an account? <a href="homepage.php" data-bs-toggle="modal"
                        data-bs-target="#forogtModal" data-bs-dismiss="modal">Sign Up</a></p>

                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Bagian setelah login - Ikon User, Wishlist, Cart -->
          <div class="user-section d-none">
            <ul class="d-flex list-unstyled m-0 gap-3">
              <li>
                <a href="#" class="p-2" title="My Account">
                  <svg width="24" height="24">
                    <use xlink:href="#user"></use>
                  </svg>
                </a>
              </li>
              <li>
                <a href="#" class="p-2" title="Wishlist">
                  <svg width="24" height="24">
                    <use xlink:href="#wishlist"></use>
                  </svg>
                </a>
              </li>
              <li>
                <a href="#" class="p-2 position-relative" title="Cart" data-bs-toggle="offcanvas"
                  data-bs-target="#offcanvasCart">
                  <svg width="24" height="24">
                    <use xlink:href="#shopping-bag"></use>
                  </svg>
                  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary"
                    id="cart-badge">0</span>
                </a>
              </li>
            </ul>
          </div>
        </div>

      </div>
    </div>

    <!-- Tambahkan di bawah header -->
    <div id="notification"
      style="display: none; position: fixed; top: 20px; right: 20px; padding: 15px; background-color: #4CAF50; color: white; border-radius: 5px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); z-index: 1000;">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
        style="vertical-align: middle; margin-right: 10px;">
        <path fill="currentColor" d="M9 16.17L4.83 12l-1.42 1.41L9 19L21 7l-1.41-1.41L9 16.17z" />
      </svg>
      <span id="notification-message">Item added to cart!</span>
    </div>
  </header>

  <!-- Checkout Progress -->
  <section class="checkout-progress py-4 bg-light">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <ul class="progress-steps list-unstyled d-flex justify-content-between">

            <li class="step active">
              <span class="step-number">1</span>
              <span class="step-title">Order</span>
            </li>
            <li class="step">
              <span class="step-number">2</span>
              <span class="step-title">Payment</span>
            </li>
            <li class="step">
              <span class="step-number">3</span>
              <span class="step-title">Confirmation</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- Main Content -->
  <main class="checkout-main py-5">
    <div class="container">
      <div class="row">
      
        <!-- Shipping Form -->
        <div class="col-lg-7 order-lg-1">
          <div class="checkout-form">
            <h2 class="h4 mb-4">Shipping Option</h2>

             <!-- Shipping Options -->
  <div class="shipping-options mb-4">
    <?php foreach ($shipping_options as $option): ?>
      <div class="form-check mb-3 border p-3 rounded">
        <input class="form-check-input" 
               type="radio" 
               name="shipping_option" 
               id="shipping_<?= $option['opsi_pengiriman_id'] ?>" 
               value="<?= $option['opsi_pengiriman_id'] ?>"
               data-price="<?= $option['harga_pengiriman'] ?>"
               <?= $option['opsi_pengiriman_id'] == 1 ? 'checked' : '' ?>
               onchange="updateShippingCost()">
        <label class="form-check-label d-flex justify-content-between w-100" for="shipping_<?= $option['opsi_pengiriman_id'] ?>">
          <div>
            <strong><?= $option['nama_opsi'] ?></strong>
            <p class="small mb-0"><?= $option['waktu_pengiriman'] ?></p>
          </div>
          <span>$<?= number_format($option['harga_pengiriman'], 2) ?></span>
        </label>
      </div>
    <?php endforeach; ?>
  </div>
  

            <h2 class="h4 mb-4">Shipping Address</h2>

            <form id="shippingForm" action="process_order.php" method="POST">
              <!-- Tambahkan input hidden untuk data keranjang -->
              <?php foreach ($cartItems as $item): ?>
                <input type="hidden" name="cart_items[]" value="<?php echo $item['keranjang_id']; ?>">
              <?php endforeach; ?>

              <input type="hidden" name="shipping_option" id="shipping_option" value="1">
  
              <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>


              <div class="row">
                <div class="mb-3">
                  <label for="fullName" class="form-label">Full Name</label>
                  <input type="text" class="form-control" id="fullName" name="fullName" required>
                </div>

              </div>

              <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" required>
              </div>

              <div class="row">
                <div class="col-md-5 mb-3">
                  <label for="country" class="form-label">Country</label>
                  <select class="form-select" id="country" name="country" required>
                    <option value="US" selected>United States</option>
                    <option value="CA">Canada</option>
                    <option value="ID">Indonesia</option>
                  </select>
                </div>
                <div class="col-md-4 mb-3">
                  <label for="state" class="form-label">State/Province</label>
                   <input type="text" class="form-control" id="state" name="state" required>
                </div>
                <div class="col-md-3 mb-3">
                  <label for="zip" class="form-label">ZIP/Postal</label>
                  <input type="text" class="form-control" id="zip" name="zip" required>
                </div>
              </div>

              <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="tel" class="form-control" id="phone" name="phone" required>
              </div>

              <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" id="saveAddress" name="saveAddress" value="1" checked>
                <label class="form-check-label" for="saveAddress">
                  Save this address for next time
                </label>
              </div>
              

              <div class="d-flex justify-content-between">
                <a href="order.php" class="btn btn-outline-dark py-3 px-4">Back to Cart</a>
                <button type="submit" class="btn btn-dark py-3 px-5">Continue to Payment</button>
              </div>
            </form>
          </div>
        </div>

        <!-- Order Summary (Kolom Kanan) -->
        <div class="col-lg-5 order-lg-2">
          <div class="order-summary p-4 border">
            <h2 class="h4 mb-4">Order Summary</h2>

            <div class="order-items">
              <?php if (count($cartItems) > 0): ?>
                <?php foreach ($cartItems as $item): ?>
                  <div class="order-item mb-4 pb-4 border-bottom">
                    <div class="row">
                      <div class="col-3">
                        <img src="../imagecumbre/<?php echo $item['gambar_produk']; ?>" 
                             alt="<?php echo $item['nama_produk']; ?>" class="img-fluid"
                             style="height: 180px; width: auto; object-fit: cover;">
                      </div>
                      <div class="col-6">
                        <h3 class="h6"><?php echo $item['nama_produk']; ?></h3>
                        <p class="small mb-1">Color: <?php echo $item['jenis_warna']; ?></p>
                        <p class="small mb-1">Size: <?php echo $item['size_name']; ?></p>
                        <p class="small mb-1">Qty: <?php echo $item['qty']; ?></p>
                      </div>
                      <div class="col-3 text-end">
                        <p class="mb-1 fw-bold">$<?php echo number_format($item['harga_satuan'] * $item['qty'], 2); ?></p>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php else: ?>
                <p>Your cart is empty.</p>
              <?php endif; ?>
            </div>

            <div class="order-totals mt-4">
              <div class="d-flex justify-content-between mb-2">
                <span>Subtotal</span>
                <span id="subtotal">$<?php echo number_format($subtotal, 2); ?></span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span>Shipping</span>
                <span id="shipping-cost">$<?php echo number_format($shipping, 2); ?></span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span>Tax</span>
                <span id="tax">$<?php echo number_format($tax, 2); ?></span>
              </div>
              <div class="d-flex justify-content-between mt-3 pt-2 border-top">
                <span class="fw-bold">Estimated Total</span>
                <span class="fw-bold" id="total">$<?php echo number_format($total, 2); ?></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="checkout-footer py-4 bg-light border-top">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <p class="mb-0">© 2025 CUMBREPACK. All rights reserved.</p>
        </div>
        <div class="col-md-6 text-md-end">
          <a href="#" class="text-decoration-none text-dark me-3">Privacy Policy</a>
          <a href="#" class="text-decoration-none text-dark">Terms of Service</a>
        </div>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/jquery-1.11.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
  <script src="js/plugins.js"></script>
  <script src="js/script.js"></script>


  <script>
    // Fungsi untuk memperbarui badge keranjang
    function updateCartBadge() {
      fetch('get_cart_count.php')
        .then(response => response.json())
        .then(data => {
          document.getElementById('cart-badge').textContent = data.count;
        });
    }

    // Panggil saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function () {
      // Fungsi untuk memperbarui badge keranjang
      function updateCartBadge() {
        fetch('get_cart_count.php')
          .then(response => response.json())
          .then(data => {
            document.getElementById('cart-badge').textContent = data.count;
          });
      }

      // Fungsi untuk menambahkan ke keranjang
      function addToCart() {
        const variasiId = document.getElementById('selected_variasi').value;
        const quantity = document.getElementById('quantity').value;
        const price = parseFloat(document.querySelector('.price').textContent.replace('$', ''));

        const formData = new FormData();
        formData.append('variasi_id', variasiId);
        formData.append('qty', quantity);
        formData.append('harga_satuan', price);

        fetch('add_to_cart.php', {
          method: 'POST',
          body: formData
        })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              // Tampilkan notifikasi
              const notification = document.getElementById('notification');
              notification.style.display = 'block';

              // Sembunyikan setelah 3 detik
              setTimeout(() => {
                notification.style.display = 'none';
              }, 3000);

              // Update cart badge
              document.getElementById('cart-badge').textContent = data.cart_count;
            } else {
              alert('Error: ' + data.message);
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
          });
      }

      // Fungsi untuk update tampilan keranjang
      function updateCartDisplay() {
        fetch('get_cart.php')
          .then(response => response.json())
          .then(cartItems => {
            const cartList = document.getElementById('cartItems');
            const cartCount = document.getElementById('cartCount');

            // Kosongkan daftar keranjang
            cartList.innerHTML = '';

            if (cartItems.length === 0) {
              cartList.innerHTML = '<li class="list-group-item text-center py-4">Your cart is empty</li>';
              cartCount.textContent = '0';
              return;
            }

            let total = 0;

            // Buat elemen untuk setiap item
            cartItems.forEach(item => {
              const subtotal = item.harga_satuan * item.qty;
              total += subtotal;

              const listItem = document.createElement('li');
              listItem.className = 'list-group-item d-flex justify-content-between align-items-center';
              listItem.innerHTML = `
                        <div class="d-flex align-items-center flex-grow-1">
                            <img src="../imagecumbre/blayer/blayer1.jpg" alt="${item.nama_produk}" width="60" height="60" class="rounded me-3">
                            <div class="flex-grow-1">
                                <h6 class="my-0">${item.nama_produk}</h6>
                                <small class="text-muted d-block">Size: ${item.size_name}</small>
                                <small class="text-muted">Color: ${item.jenis_warna}</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="d-flex align-items-center justify-content-end">
                                <span class="text-primary fw-bold me-3">$${item.harga_satuan} × ${item.qty}</span>
                                <button class="btn btn-sm btn-outline-danger delete-btn" data-id="${item.keranjang_id}">
                                    <svg width="16" height="16"><use xlink:href="#trash"></use></svg>
                                </button>
                            </div>
                            <small class="text-muted">Subtotal: $${subtotal.toFixed(2)}</small>
                        </div>
                    `;
              cartList.appendChild(listItem);
            });

            // Tambahkan total
            const totalItem = document.createElement('li');
            totalItem.className = 'list-group-item d-flex justify-content-between fw-bold bg-light';
            totalItem.innerHTML = `
                    <span>Total (USD)</span>
                    <strong>$${total.toFixed(2)}</strong>
                `;
            cartList.appendChild(totalItem);

            // Update counter
            cartCount.textContent = cartItems.length;

            // Tambahkan event listener untuk tombol hapus
            document.querySelectorAll('.delete-btn').forEach(btn => {
              btn.addEventListener('click', function () {
                const keranjangId = this.getAttribute('data-id');
                removeItemFromCart(keranjangId);
              });
            });
          });
      }

      // Fungsi untuk menghapus item dari keranjang
      function removeItemFromCart(keranjangId) {
        if (confirm('Are you sure you want to remove this item?')) {
          const formData = new FormData();
          formData.append('keranjang_id', keranjangId);

          fetch('remove_cart_item.php', {
            method: 'POST',
            body: formData
          })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                // Perbarui tampilan keranjang
                updateCartDisplay();
                // Perbarui badge
                updateCartBadge();
              } else {
                alert('Error: ' + data.message);
              }
            });
        }
      }


      // Event listeners untuk pemilihan ukuran
      document.querySelectorAll('.size-selector .size').forEach(size => {
        size.addEventListener('click', function () {
          document.querySelectorAll('.size-selector .size').forEach(s => {
            s.classList.remove('active');
          });
          this.classList.add('active');
          document.getElementById('selected_variasi').value = this.getAttribute('data-variasi-id');
        });
      });

      // Event listeners untuk pemilihan warna
      document.querySelectorAll('.color-swatches .swatch').forEach(swatch => {
        swatch.addEventListener('click', function () {
          document.querySelectorAll('.color-swatches .swatch').forEach(s => {
            s.classList.remove('active');
          });
          this.classList.add('active');
          document.getElementById('selected_variasi').value = this.getAttribute('data-variasi-id');
        });
      });

      // Panggil fungsi saat halaman dimuat
      updateCartBadge();
      updateCartDisplay();

      // Perbarui keranjang saat offcanvas dibuka
      const offcanvasCart = document.getElementById('offcanvasCart');
      if (offcanvasCart) {
        offcanvasCart.addEventListener('shown.bs.offcanvas', function () {
          updateCartDisplay();
        });
      }
    });
  </script>

  <script>
    // Untuk swatch (color)
    const swatches = document.querySelectorAll('.color-swatches .swatch');
    swatches.forEach(swatch => {
      swatch.addEventListener('click', () => {
        swatches.forEach(s => s.classList.remove('active'));
        swatch.classList.add('active');
      });
    });

    // Untuk size
    const sizes = document.querySelectorAll('.size-selector .size');
    sizes.forEach(size => {
      size.addEventListener('click', () => {
        sizes.forEach(s => s.classList.remove('active'));
        size.classList.add('active');
      });
    });



  </script>


  <script>
    // Fungsi untuk mengubah quantity
    function changeQuantity(amount) {
      const quantityInput = document.getElementById('quantity');
      let currentValue = parseInt(quantityInput.value);
      currentValue += amount;
      if (currentValue < 1) currentValue = 1;
      quantityInput.value = currentValue;
    }

    // Fungsi untuk menambahkan ke keranjang
    function addToCart() {
      const variasiId = document.getElementById('selected_variasi').value;
      const quantity = document.getElementById('quantity').value;
      const price = parseFloat(document.querySelector('.price').textContent.replace('$', ''));

      const formData = new FormData();
      formData.append('variasi_id', variasiId);
      formData.append('qty', quantity);
      formData.append('harga_satuan', price);

      fetch('add_to_cart.php', {
        method: 'POST',
        body: formData
      })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Tampilkan notifikasi
            const notification = document.getElementById('notification');
            notification.style.display = 'block';

            // Sembunyikan setelah 3 detik
            setTimeout(() => {
              notification.style.display = 'none';
            }, 3000);

            // Update cart badge
            document.getElementById('cart-badge').textContent = data.cart_count;
          } else {
            alert('Error: ' + data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('An error occurred. Please try again.');
        });
    }

    // Event listener untuk tombol Add to Cart
    document.addEventListener('DOMContentLoaded', function () {
      const cartForm = document.getElementById('cartForm');
      if (cartForm) {
        cartForm.addEventListener('submit', function (e) {
          e.preventDefault();
          addToCart();
        });
      }

      // Event listeners untuk pemilihan ukuran
      document.querySelectorAll('.size-selector .size').forEach(size => {
        size.addEventListener('click', function () {
          document.querySelectorAll('.size-selector .size').forEach(s => {
            s.classList.remove('active');
          });
          this.classList.add('active');
          document.getElementById('selected_variasi').value = this.getAttribute('data-variasi-id');
        });
      });

      // Event listeners untuk pemilihan warna
      document.querySelectorAll('.color-swatches .swatch').forEach(swatch => {
        swatch.addEventListener('click', function () {
          document.querySelectorAll('.color-swatches .swatch').forEach(s => {
            s.classList.remove('active');
          });
          this.classList.add('active');
          document.getElementById('selected_variasi').value = this.getAttribute('data-variasi-id');
        });
      });

      // Inisialisasi pilihan pertama
      document.querySelector('.size-selector .size:first-child').classList.add('active');
      document.querySelector('.color-swatches .swatch:first-child').classList.add('active');
    });
  </script>

  <script>
    // Tambahkan ini di dalam script yang sudah ada
    document.getElementById('continueToCheckout').addEventListener('click', function () {
      window.location.href = 'order.php';
    });
  </script>



  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Check if user is logged in
      <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
        // Hide auth buttons and show user icons
        document.querySelector('.auth-section').classList.add('d-none');
        document.querySelector('.user-section').classList.remove('d-none');

        // Update user icon with name
        const userIcon = document.querySelector('.user-section a[title="My Account"]');
        if (userIcon) {
          userIcon.innerHTML = `<svg width="24" height="24"><use xlink:href="#user"></use></svg>`;
          userIcon.insertAdjacentHTML('afterend', `<span class="ms-2"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>`);
        }
      <?php endif; ?>

      // Add logout functionality
      document.querySelector('.user-section').addEventListener('click', function (e) {
        if (e.target.closest('a[title="My Account"]')) {
          e.preventDefault();
          // Create logout dropdown
          const dropdown = document.createElement('div');
          dropdown.className = 'dropdown-menu show';
          dropdown.style.position = 'absolute';
          dropdown.style.right = '0';
          dropdown.innerHTML = `
        <a class="dropdown-item" href="../home/logout.php">Logout</a>
      `;
          this.appendChild(dropdown);

          // Close dropdown when clicking outside
          // document.addEventListener('click', function closeDropdown(evt) {
          //   if (!dropdown.contains(evt.target)) {
          //     dropdown.remove();
          //     document.removeEventListener('click', closeDropdown);
          //   }
          // });
        }
      });
    });
  </script>

  <script>
    // Fungsi untuk mengupdate variasi_id berdasarkan warna dan ukuran
    function updateSelectedVariasi() {
      const activeColor = document.querySelector('.color-swatches .swatch.active');
      const activeSize = document.querySelector('.size-selector .size.active');

      if (activeColor && activeSize) {
        // Dapatkan variasi_id dari ukuran yang aktif (karena ukuran sudah memiliki variasi_id unik)
        const variasiId = activeSize.getAttribute('data-variasi-id');
        document.getElementById('selected_variasi').value = variasiId;
      }
    }

    // Event listeners untuk pemilihan ukuran
    document.querySelectorAll('.size-selector .size').forEach(size => {
      size.addEventListener('click', function () {
        document.querySelectorAll('.size-selector .size').forEach(s => {
          s.classList.remove('active');
        });
        this.classList.add('active');
        updateSelectedVariasi();
      });
    });

    // Event listeners untuk pemilihan warna
    document.querySelectorAll('.color-swatches .swatch').forEach(swatch => {
      swatch.addEventListener('click', function () {
        document.querySelectorAll('.color-swatches .swatch').forEach(s => {
          s.classList.remove('active');
        });
        this.classList.add('active');
        updateSelectedVariasi();
      });
    });

    function buyNow() {
      const product = {
        name: document.querySelector('.detail-product-title').textContent.trim(),
        price: document.querySelector('.price').textContent.trim(),
        image: document.querySelector('.img-product-detail').src,
        color: document.querySelector('.color-swatches .swatch.active')?.style.backgroundColor || 'Black',
        size: document.querySelector('.size-selector .size.active').textContent.trim(),
        quantity: parseInt(document.getElementById('quantity').value) || 1
      };

      const priceValue = parseFloat(product.price.replace('$', ''));
      product.total = `$${(priceValue * product.quantity).toFixed(2)}`;

      localStorage.setItem('cart', JSON.stringify([product]));

      window.location.href = 'order.php';
    }

    document.getElementById('continueToCheckout').addEventListener('click', function () {
      window.location.href = 'order.php';
    });

  </script>

  <script>
  document.addEventListener('DOMContentLoaded', function() {
    // Update shipping option value when radio changes
    document.querySelectorAll('input[name="shipping"]').forEach(radio => {
      radio.addEventListener('change', function() {
        document.getElementById('shipping_option').value = this.value;
      });
    });
  });
</script>

</body>

</html>