<?php
session_start();
require_once 'connect.php';

// Redirect jika belum login
if (!isset($_SESSION['logged_in'])) {
    header("Location: homepage.php");
    exit();
}

// Ambil data user
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM sign_up WHERE signup_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: homepage.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>User Profile - CUMBREPACK Outdoor Gear</title>
  <!-- Include semua CSS yang sama dengan homepage.php -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="author" content="">
  <meta name="keywords" content="">
  <meta name="description" content="">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../css/vendor.css">
  <link rel="stylesheet" type="text/css" href="../css/home.css">
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
</head>

<body>
  <!-- Include SVG icons dan preloader sama seperti homepage.php -->
  
  <header>
    <div class="container-fluid">
      <div class="row py-4">
        <!-- Logo dan menu lainnya sama seperti homepage.php -->
        
        <div class="col-sm-8 col-lg-2 d-flex gap-5 align-items-center justify-content-center justify-content-sm-end">
          <?php if (isset($_SESSION['logged_in'])): ?>
            <div class="user-section">
              <ul class="d-flex list-unstyled m-0 gap-3">
                <li>
                  <a href="profile.php" class="p-2" title="My Account">
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
                  <a href="#" class="p-2" title="Cart" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart">
                    <svg width="24" height="24">
                      <use xlink:href="#shopping-bag"></use>
                    </svg>
                  </a>
                </li>
              </ul>
            </div>
          <?php else: ?>
            <div class="auth-section">
              <a href="#" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
              <a href="#" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#signupModal">Sign Up</a>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </header>

  <section class="section-padding">
    <div class="container-lg">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card shadow">
            <div class="card-header bg-dark text-white">
              <h3 class="mb-0">User Profile</h3>
            </div>
            <div class="card-body">
              <div class="row mb-4">
                <div class="col-md-3 text-center">
                  <svg width="80" height="80" class="bg-light p-3 rounded-circle">
                    <use xlink:href="#user"></use>
                  </svg>
                </div>
                <div class="col-md-9">
                  <h4><?php echo htmlspecialchars($user['nama']); ?></h4>
                  <p class="text-muted"><?php echo htmlspecialchars($user['email']); ?></p>
                </div>
              </div>
              
              <form>
                <div class="mb-3">
                  <label class="form-label">Full Name</label>
                  <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['nama']); ?>" readonly>
                </div>
                <div class="mb-3">
                  <label class="form-label">Email Address</label>
                  <input type="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                </div>
                <div class="mb-3">
                  <label class="form-label">Phone Number</label>
                  <input type="tel" class="form-control" placeholder="Not set" readonly>
                </div>
                
                <div class="d-flex justify-content-between">
                  <a href="homepage.php" class="btn btn-outline-dark">Back to Home</a>
                  <a href="profile.php?logout=1" class="btn btn-danger">Logout</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Include footer dan script lainnya sama seperti homepage.php -->
  
</body>
</html>