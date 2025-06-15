<?php
session_start();

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

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>CUMBREPACK Outdoor Gear - Base Layer</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="author" content="">
  <meta name="keywords" content="">
  <meta name="description" content="">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="css/vendor.css">
  <link rel="stylesheet" type="text/css" href="sub_products.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
    rel="stylesheet">

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

  <!-- bagian item cart -->
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
        </ul>
        <button class="w-100 btn btn-primary btn-lg" type="button" id="continueToCheckout">Continue to checkout</button>
      </div>
    </div>
  </div>

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
                <option value="men.php">Men</option>
                <option value="women.php">Women</option>
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
              <a href="onSale.php" class="nav-link">Sale</a>
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
                    <p><a href="#">Forgot password?</a></p>
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
                <a href="#" class="p-2" title="Cart" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart">
                  <svg width="24" height="24">
                    <use xlink:href="#shopping-bag"></use>
                  </svg>
                </a>
              </li>
            </ul>
          </div>
        </div>

      </div>
    </div>
  </header>

  <section
    style="background-image: url('../imagecumbre/home_display/himalaya1.png');background-repeat: no-repeat;background-size: cover;">
    <div class="container-lg">
      <div class="row">
        <div class="col-lg-5 py-5 my-5 text-white">
          <h2 class="display-2 text-capitalize text-white"><span class="fw-medium">Discover </span>the latest <span
              class="fw-medium text-primary text-white">fashion trends</span></h2>
          <p class="fs-5 text-white">Whether you're looking for casual wear, formal attire, or seasonal outfits, we have
            something for everyone.</p>
          <div class="d-flex gap-3">
            <a href="../home/viewallProducts.php"
              class="btn btn-dark text-uppercase fs-6 rounded-pill px-5 py-4 mt-3">Start Shopping</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="section-padding overflow-hidden">
    <div class="container-lg">
      <div class="row">
        <div class="col-md-12">

          <div class="section-header d-flex flex-wrap justify-content-between mb-3">
            <h2 class="section-title text-capitalize">Category</h2>

            <div class="d-flex align-items-center">
              <a href="viewallCategory.php" class="btn btn-primary me-2">View All</a>
              <div class="swiper-buttons">
                <button class="swiper-prev category-carousel-prev btn btn-yellow">❮</button>
                <button class="swiper-next category-carousel-next btn btn-yellow">❯</button>
              </div>
            </div>
          </div>

        </div>
      </div>
      <div class="row">
        <div class="col-md-12">

          <div class="category-carousel swiper">
            <div class="swiper-wrapper">
              <a href="../sub_products/sub_baselayer.php" class="nav-link swiper-slide text-center">
                <img src="../imagecumbre/category/blayercategory.png" class="img-category" alt="Category Thumbnail">
                <h3 class="fs-6 mt-3 fw-normal category-title">Base Layer</h3>
              </a>
              <a href="../sub_products/sub_daypack.php" class="nav-link swiper-slide text-center">
                <img src="../imagecumbre/category/daypackcategory.png" class="img-category" alt="Category Thumbnail">
                <h3 class="fs-6 mt-3 fw-normal category-title">Day Pack</h3>
              </a>
              <a href="../sub_products/sub_gloves.php" class="nav-link swiper-slide text-center">
                <img src="../imagecumbre/category/glovescategory.png" class="img-category" alt="Category Thumbnail">
                <h3 class="fs-6 mt-3 fw-normal category-title">Gloves</h3>
              </a>
              <a href="../sub_products/sub_longs.php" class="nav-link swiper-slide text-center">
                <img src="../imagecumbre/category/pantscategory.png" class="img-category" alt="Category Thumbnail">
                <h3 class="fs-6 mt-3 fw-normal category-title">Long Pants</h3>
              </a>
              <a href="../sub_products/sub_wbreaker.php" class="nav-link swiper-slide text-center">
                <img src="../imagecumbre/category/wbreakercategory2.png" class="img-category" alt="Category Thumbnail">
                <h3 class="fs-6 mt-3 fw-normal category-title">Windbreaker Jacket</h3>
              </a>
              <a href="../sub_products/sub_puff.php" class="nav-link swiper-slide text-center">
                <img src="../imagecumbre/category/puffcategory2.png" class="img-category" alt="Category Thumbnail">
                <h3 class="fs-6 mt-3 fw-normal category-title">Puff Jacket</h3>
              </a>
              <a href="../sub_products/sub_wjacket.php" class="nav-link swiper-slide text-center">
                <img src="../imagecumbre/category/wjacketcategory.png" class="img-category" alt="Category Thumbnail">
                <h3 class="fs-6 mt-3 fw-normal category-title">Waterproof Jacket</h4>
              </a>
              <a href="../sub_products/sub_shoes.php" class="nav-link swiper-slide text-center">
                <img src="../imagecumbre/category/shoescategory.png" class="img-category" alt="Category Thumbnail">
                <h3 class="fs-6 mt-3 fw-normal category-title">Shoes</h3>
              </a>
              <a href="../sub_products/sub_carrier.php" class="nav-link swiper-slide text-center">
                <img src="../imagecumbre/category/carriercategory.png" class="img-category" alt="Category Thumbnail">
                <h3 class="fs-6 mt-3 fw-normal category-title">Carrier</h3>
              </a>
              <a href="../sub_products/sub_socks.php" class="nav-link swiper-slide text-center">
                <img src="../imagecumbre/category/sockscategory.png" class="img-category" alt="Category Thumbnail">
                <h3 class="fs-6 mt-3 fw-normal category-title">Socks</h3>
              </a>
              <a href="../sub_products/sub_shorts.php" class="nav-link swiper-slide text-center">
                <img src="../imagecumbre/category/short_category.png" class="img-category" alt="Category Thumbnail">
                <h3 class="fs-6 mt-3 fw-normal category-title">Short Pants</h3>
              </a>
              <a href="../sub_products/sub_tents.php" class="nav-link swiper-slide text-center">
                <img src="../imagecumbre/category/tents_category.png" class="img-category" alt="Category Thumbnail">
                <h3 class="fs-6 mt-3 fw-normal category-title">Tents</h3>
              </a>
              <a href="../sub_products/sub_hydropack.php" class="nav-link swiper-slide text-center">
                <img src="../imagecumbre/category/hydro_category.png" class="img-category" alt="Category Thumbnail">
                <h3 class="fs-6 mt-3 fw-normal category-title">Hydro Pack</h3>
              </a>
              <a href="../sub_products/sub_hat.php" class="nav-link swiper-slide text-center">
                <img src="../imagecumbre/category/hat_category.png" class="img-category" alt="Category Thumbnail">
                <h3 class="fs-6 mt-3 fw-normal category-title">Hats</h3>
              </a>
              <a href="../sub_products/sub_others.ph" class="nav-link swiper-slide text-center">
                <img src="../imagecumbre/category/others_category.png" class="img-category" alt="Category Thumbnail">
                <h3 class="fs-6 mt-3 fw-normal category-title">Others</h3>
              </a>
            </div>
          </div>

        </div>
      </div>
    </div>
  </section>

  <section class="section-padding pt-0">
    <div class="container-lg">

      <div class="row">
        <div class="col-md-12">

          <div class="section-header d-flex flex-wrap justify-content-between mb-3">

            <h2 class="section-title text-capitalize">Base Layer Products</h2>

          </div>
        </div>

        <div class="row">
          <div class="col-md-12">

            <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 row-cols-xl-4">


              <!-- Product 1 -->
              <div class="col">
                <div class="product-item mb-4">
                  <figure>
                    <a href="../detail_products/detail_baselayer1.php" title="Product Title">
                      <img src="../imagecumbre/blayer/blayer1.jpg" alt="Product Thumbnail" class="img-fluid">
                    </a>
                  </figure>
                  <div class="d-flex flex-column text-center">
                    <h3 class="fs-6 fw-normal">Wolfy Layer Women's</h3>
                    <div class="d-flex justify-content-center align-items-center gap-2">
                      <del>$370.00</del>
                      <span class="text-dark fw-semibold">$360.00</span>
                      <span
                        class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                        OFF</span>
                    </div>
                    <div class="button-area p-3 pt-0">
                      <div class="row g-1 mt-2">
                        <div class="col-3"><input type="number" name="quantity"
                            class="form-control border-dark-subtle input-number quantity" value="1"></div>
                        <div class="col-7"><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                              width="18" height="18">
                              <use xlink:href="#cart"></use>
                            </svg> Add to Cart</a></div>
                        <div class="col-2"><a href="#" class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                              height="18">
                              <use xlink:href="#heart"></use>
                            </svg></a></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Product 2 -->
              <div class="col">
                <div class="product-item mb-4">
                  <figure>
                    <a href="single-product.html" title="Product Title">
                      <img src="../imagecumbre/blayer/blayer2.jpg" alt="Product Thumbnail" class="img-fluid">
                    </a>
                  </figure>
                  <div class="d-flex flex-column text-center">
                    <h3 class="fs-6 fw-normal">Thery Layer Women's</h3>
                    <div class="d-flex justify-content-center align-items-center gap-2">
                      <del>$390.00</del>
                      <span class="text-dark fw-semibold">$380.00</span>
                      <span
                        class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                        OFF</span>
                    </div>
                    <div class="button-area p-3 pt-0">
                      <div class="row g-1 mt-2">
                        <div class="col-3"><input type="number" name="quantity"
                            class="form-control border-dark-subtle input-number quantity" value="1"></div>
                        <div class="col-7"><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                              width="18" height="18">
                              <use xlink:href="#cart"></use>
                            </svg> Add to Cart</a></div>
                        <div class="col-2"><a href="#" class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                              height="18">
                              <use xlink:href="#heart"></use>
                            </svg></a></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Product 3 -->
              <div class="col">
                <div class="product-item mb-4">
                  <figure>
                    <a href="single-product.html" title="Product Title">
                      <img src="../imagecumbre/blayer/blayer3.jpg" alt="Product Thumbnail" class="img-fluid">
                    </a>
                  </figure>
                  <div class="d-flex flex-column text-center">
                    <h3 class="fs-6 fw-normal">Dory Layer Women's</h3>
                    <div class="d-flex justify-content-center align-items-center gap-2">
                      <del>$270.00</del>
                      <span class="text-dark fw-semibold">$260.00</span>
                      <span
                        class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                        OFF</span>
                    </div>
                    <div class="button-area p-3 pt-0">
                      <div class="row g-1 mt-2">
                        <div class="col-3"><input type="number" name="quantity"
                            class="form-control border-dark-subtle input-number quantity" value="1"></div>
                        <div class="col-7"><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                              width="18" height="18">
                              <use xlink:href="#cart"></use>
                            </svg> Add to Cart</a></div>
                        <div class="col-2"><a href="#" class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                              height="18">
                              <use xlink:href="#heart"></use>
                            </svg></a></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Product 4 -->
              <div class="col">
                <div class="product-item mb-4">
                  <figure>
                    <a href="single-product.html" title="Product Title">
                      <img src="../imagecumbre/blayer/blayer4.jpg" alt="Product Thumbnail" class="img-fluid">
                    </a>
                  </figure>
                  <div class="d-flex flex-column text-center">
                    <h3 class="fs-6 fw-normal">North Layer Women's</h3>
                    <div class="d-flex justify-content-center align-items-center gap-2">
                      <del>$180.00</del>
                      <span class="text-dark fw-semibold">$170.00</span>
                      <span
                        class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                        OFF</span>
                    </div>
                    <div class="button-area p-3 pt-0">
                      <div class="row g-1 mt-2">
                        <div class="col-3"><input type="number" name="quantity"
                            class="form-control border-dark-subtle input-number quantity" value="1"></div>
                        <div class="col-7"><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                              width="18" height="18">
                              <use xlink:href="#cart"></use>
                            </svg> Add to Cart</a></div>
                        <div class="col-2"><a href="#" class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                              height="18">
                              <use xlink:href="#heart"></use>
                            </svg></a></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Product 5 -->
              <div class="col">
                <div class="product-item mb-4">
                  <figure>
                    <a href="single-product.html" title="Product Title">
                      <img src="../imagecumbre/blayer/blayer5.jpg" alt="Product Thumbnail" class="img-fluid">
                    </a>
                  </figure>
                  <div class="d-flex flex-column text-center">
                    <h3 class="fs-6 fw-normal">Aquila Layer Women's</h3>
                    <div class="d-flex justify-content-center align-items-center gap-2">
                      <del>$160.00</del>
                      <span class="text-dark fw-semibold">$150.00</span>
                      <span
                        class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                        OFF</span>
                    </div>
                    <div class="button-area p-3 pt-0">
                      <div class="row g-1 mt-2">
                        <div class="col-3"><input type="number" name="quantity"
                            class="form-control border-dark-subtle input-number quantity" value="1"></div>
                        <div class="col-7"><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                              width="18" height="18">
                              <use xlink:href="#cart"></use>
                            </svg> Add to Cart</a></div>
                        <div class="col-2"><a href="#" class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                              height="18">
                              <use xlink:href="#heart"></use>
                            </svg></a></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- products 6 -->
              <div class="col">
                <div class="product-item mb-4">
                  <figure>
                    <a href="single-product.html" title="Product Title">
                      <img src="../imagecumbre/blayer/blayer6.jpg" alt="Product Thumbnail" class="img-fluid">
                    </a>
                  </figure>
                  <div class="d-flex flex-column text-center">
                    <h3 class="fs-6 fw-normal">ThermoCore FlexFit Base Layer</h3>
                    <div class="d-flex justify-content-center align-items-center gap-2">
                      <del>$42.00</del>
                      <span class="text-dark fw-semibold">$32.00</span>
                      <span
                        class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                        OFF</span>
                    </div>
                    <div class="button-area p-3 pt-0">
                      <div class="row g-1 mt-2">
                        <div class="col-3"><input type="number" name="quantity"
                            class="form-control border-dark-subtle input-number quantity" value="1"></div>
                        <div class="col-7"><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                              width="18" height="18">
                              <use xlink:href="#cart"></use>
                            </svg> Add to Cart</a></div>
                        <div class="col-2"><a href="#" class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                              height="18">
                              <use xlink:href="#heart"></use>
                            </svg></a></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- products 7 -->
              <div class="col">
                <div class="product-item mb-4">
                  <figure>
                    <a href="single-product.html" title="Product Title">
                      <img src="../imagecumbre/blayer/blayer7.jpg" alt="Product Thumbnail" class="img-fluid">
                    </a>
                  </figure>
                  <div class="d-flex flex-column text-center">
                    <h3 class="fs-6 fw-normal">ArcticStrike Velocity Base Layer</h3>
                    <div class="d-flex justify-content-center align-items-center gap-2">
                      <del>$48.00</del>
                      <span class="text-dark fw-semibold">$38.00</span>
                      <span
                        class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                        OFF</span>
                    </div>
                    <div class="button-area p-3 pt-0">
                      <div class="row g-1 mt-2">
                        <div class="col-3"><input type="number" name="quantity"
                            class="form-control border-dark-subtle input-number quantity" value="1"></div>
                        <div class="col-7"><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                              width="18" height="18">
                              <use xlink:href="#cart"></use>
                            </svg> Add to Cart</a></div>
                        <div class="col-2"><a href="#" class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                              height="18">
                              <use xlink:href="#heart"></use>
                            </svg></a></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- products 8 -->
              <div class="col">
                <div class="product-item mb-4">
                  <figure>
                    <a href="single-product.html" title="Product Title">
                      <img src="../imagecumbre/blayer/blayer8.jpg" alt="Product Thumbnail" class="img-fluid">
                    </a>
                  </figure>
                  <div class="d-flex flex-column text-center">
                    <h3 class="fs-6 fw-normal">ShadowSkin Pro Tee Base Layer</h3>
                    <div class="d-flex justify-content-center align-items-center gap-2">
                      <del>$35.00</del>
                      <span class="text-dark fw-semibold">$25.00</span>
                      <span
                        class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                        OFF</span>
                    </div>
                    <div class="button-area p-3 pt-0">
                      <div class="row g-1 mt-2">
                        <div class="col-3"><input type="number" name="quantity"
                            class="form-control border-dark-subtle input-number quantity" value="1"></div>
                        <div class="col-7"><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                              width="18" height="18">
                              <use xlink:href="#cart"></use>
                            </svg> Add to Cart</a></div>
                        <div class="col-2"><a href="#" class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                              height="18">
                              <use xlink:href="#heart"></use>
                            </svg></a></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- products 9 -->
              <div class="col">
                <div class="product-item mb-4">
                  <figure>
                    <a href="single-product.html" title="Product Title">
                      <img src="../imagecumbre/blayer/blayer9.jpg" alt="Product Thumbnail" class="img-fluid">
                    </a>
                  </figure>
                  <div class="d-flex flex-column text-center">
                    <h3 class="fs-6 fw-normal">InfernoLine X-Tech</h3>
                    <div class="d-flex justify-content-center align-items-center gap-2">
                      <del>$46.00</del>
                      <span class="text-dark fw-semibold">$36.00</span>
                      <span
                        class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                        OFF</span>
                    </div>
                    <div class="button-area p-3 pt-0">
                      <div class="row g-1 mt-2">
                        <div class="col-3"><input type="number" name="quantity"
                            class="form-control border-dark-subtle input-number quantity" value="1"></div>
                        <div class="col-7"><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                              width="18" height="18">
                              <use xlink:href="#cart"></use>
                            </svg> Add to Cart</a></div>
                        <div class="col-2"><a href="#" class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                              height="18">
                              <use xlink:href="#heart"></use>
                            </svg></a></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- products 10 -->
              <div class="col">
                <div class="product-item mb-4">
                  <figure>
                    <a href="single-product.html" title="Product Title">
                      <img src="../imagecumbre/blayer/blayer10.jpg" alt="Product Thumbnail" class="img-fluid">
                    </a>
                  </figure>
                  <div class="d-flex flex-column text-center">
                    <h3 class="fs-6 fw-normal">Whitey Baselayer</h3>
                    <div class="d-flex justify-content-center align-items-center gap-2">
                      <del>$46.00</del>
                      <span class="text-dark fw-semibold">$36.00</span>
                      <span
                        class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                        OFF</span>
                    </div>
                    <div class="button-area p-3 pt-0">
                      <div class="row g-1 mt-2">
                        <div class="col-3"><input type="number" name="quantity"
                            class="form-control border-dark-subtle input-number quantity" value="1"></div>
                        <div class="col-7"><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg
                              width="18" height="18">
                              <use xlink:href="#cart"></use>
                            </svg> Add to Cart</a></div>
                        <div class="col-2"><a href="#" class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                              height="18">
                              <use xlink:href="#heart"></use>
                            </svg></a></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>



            </div>
          </div>
        </div>
  </section>



  <section id="featured-products" class="section-padding pt-0 products-carousel">
    <div class="container-lg overflow-hidden py-5">
      <div class="row">
        <div class="col-md-12">

          <div class="section-header d-flex flex-wrap justify-content-between my-4">

            <h2 class="section-title text-capitalize">Featured products</h2>

            <div class="d-flex align-items-center">
              <a href="viewallFeatured.php" class="btn btn-primary me-2">View All</a>
              <div class="swiper-buttons">
                <button class="swiper-prev products-carousel-prev btn btn-primary">❮</button>
                <button class="swiper-next products-carousel-next btn btn-primary">❯</button>
              </div>
            </div>
          </div>

        </div>
      </div>
      <div class="row">
        <div class="col-md-12">

          <div class="swiper">
            <div class="swiper-wrapper">

              <div class="product-item swiper-slide mb-4">
                <figure>
                  <a href="single-product.html" title="Product Title">
                    <img src="../imagecumbre/carrier/carrier2.jpg" alt="Product Thumbnail" class="img-fluid">
                  </a>
                </figure>
                <div class="d-flex flex-column text-center">
                  <h3 class="fs-6 fw-normal">FalconRidge 45+L</h3>
                  <div class="d-flex justify-content-center align-items-center gap-2">
                    <del>$450.00</del>
                    <span class="text-dark fw-semibold">$420.00</span>
                    <span
                      class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                      OFF</span>
                  </div>
                  <div class="button-area p-3 pt-0">
                    <div class="row g-1 mt-2">
                      <div class="col-3"><input type="number" name="quantity"
                          class="form-control border-dark-subtle input-number quantity" value="1"></div>
                      <div class="col-7"><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg width="18"
                            height="18">
                            <use xlink:href="#cart"></use>
                          </svg> Add to Cart</a></div>
                      <div class="col-2"><a href="#" class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                            height="18">
                            <use xlink:href="#heart"></use>
                          </svg></a></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="product-item swiper-slide mb-4">
                <figure>
                  <a href="single-product.html" title="Product Title">
                    <img src="../imagecumbre/daypack/daypack2.jpg" alt="Product Thumbnail" class="img-fluid">
                  </a>
                </figure>
                <div class="d-flex flex-column text-center">
                  <h3 class="fs-6 fw-normal">Lynkr Day Pack</h3>
                  <div class="d-flex justify-content-center align-items-center gap-2">
                    <del>$150.00</del>
                    <span class="text-dark fw-semibold">$120.00</span>
                    <span
                      class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                      OFF</span>
                  </div>
                  <div class="button-area p-3 pt-0">
                    <div class="row g-1 mt-2">
                      <div class="col-3"><input type="number" name="quantity"
                          class="form-control border-dark-subtle input-number quantity" value="1"></div>
                      <div class="col-7"><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg width="18"
                            height="18">
                            <use xlink:href="#cart"></use>
                          </svg> Add to Cart</a></div>
                      <div class="col-2"><a href="#" class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                            height="18">
                            <use xlink:href="#heart"></use>
                          </svg></a></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="product-item swiper-slide mb-4">
                <figure>
                  <a href="single-product.html" title="Product Title">
                    <img src="../imagecumbre/wbreaker/wbreaker2.jpg" alt="Product Thumbnail" class="img-fluid">
                  </a>
                </figure>
                <div class="d-flex flex-column text-center">
                  <h3 class="fs-6 fw-normal">Fintro Windbreaker Jacket</h3>
                  <div class="d-flex justify-content-center align-items-center gap-2">
                    <del>$150.00</del>
                    <span class="text-dark fw-semibold">$140.00</span>
                    <span
                      class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                      OFF</span>
                  </div>
                  <div class="button-area p-3 pt-0">
                    <div class="row g-1 mt-2">
                      <div class="col-3"><input type="number" name="quantity"
                          class="form-control border-dark-subtle input-number quantity" value="1"></div>
                      <div class="col-7"><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg width="18"
                            height="18">
                            <use xlink:href="#cart"></use>
                          </svg> Add to Cart</a></div>
                      <div class="col-2"><a href="#" class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                            height="18">
                            <use xlink:href="#heart"></use>
                          </svg></a></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="product-item swiper-slide mb-4">
                <figure>
                  <a href="single-product.html" title="Product Title">
                    <img src="../imagecumbre/wjacket/wjacket2.jpg" alt="Product Thumbnail" class="img-fluid">
                  </a>
                </figure>
                <div class="d-flex flex-column text-center">
                  <h3 class="fs-6 fw-normal">Terrashield Waterproof Jacket</h3>
                  <div class="d-flex justify-content-center align-items-center gap-2">
                    <del>$150.00</del>
                    <span class="text-dark fw-semibold">$140.00</span>
                    <span
                      class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                      OFF</span>
                  </div>
                  <div class="button-area p-3 pt-0">
                    <div class="row g-1 mt-2">
                      <div class="col-3"><input type="number" name="quantity"
                          class="form-control border-dark-subtle input-number quantity" value="1"></div>
                      <div class="col-7"><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg width="18"
                            height="18">
                            <use xlink:href="#cart"></use>
                          </svg> Add to Cart</a></div>
                      <div class="col-2"><a href="#" class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                            height="18">
                            <use xlink:href="#heart"></use>
                          </svg></a></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="product-item swiper-slide mb-4">
                <figure>
                  <a href="single-product.html" title="Product Title">
                    <img src="../imagecumbre/gloves/gloves2.jpeg" alt="Product Thumbnail" class="img-fluid">
                  </a>
                </figure>
                <div class="d-flex flex-column text-center">
                  <h3 class="fs-6 fw-normal">GlacierGrip XT</h3>
                  <div class="d-flex justify-content-center align-items-center gap-2">
                    <del>$95.00</del>
                    <span class="text-dark fw-semibold">$85.00</span>
                    <span
                      class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                      OFF</span>
                  </div>
                  <div class="button-area p-3 pt-0">
                    <div class="row g-1 mt-2">
                      <div class="col-3"><input type="number" name="quantity"
                          class="form-control border-dark-subtle input-number quantity" value="1"></div>
                      <div class="col-7"><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg width="18"
                            height="18">
                            <use xlink:href="#cart"></use>
                          </svg> Add to Cart</a></div>
                      <div class="col-2"><a href="#" class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                            height="18">
                            <use xlink:href="#heart"></use>
                          </svg></a></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="product-item swiper-slide mb-4">
                <figure>
                  <a href="single-product.html" title="Product Title">
                    <img src="../imagecumbre/daypack/daypack4.jpg" alt="Product Thumbnail" class="img-fluid">
                  </a>
                </figure>
                <div class="d-flex flex-column text-center">
                  <h3 class="fs-6 fw-normal">Kravax Day Pack</h3>
                  <div class="d-flex justify-content-center align-items-center gap-2">
                    <del>$300.00</del>
                    <span class="text-dark fw-semibold">$280.00</span>
                    <span
                      class="badge border border-dark-subtle rounded-0 fw-normal px-1 fs-7 lh-1 text-body-tertiary">10%
                      OFF</span>
                  </div>
                  <div class="button-area p-3 pt-0">
                    <div class="row g-1 mt-2">
                      <div class="col-3"><input type="number" name="quantity"
                          class="form-control border-dark-subtle input-number quantity" value="1"></div>
                      <div class="col-7"><a href="#" class="btn btn-primary rounded-1 p-2 fs-7 btn-cart"><svg width="18"
                            height="18">
                            <use xlink:href="#cart"></use>
                          </svg> Add to Cart</a></div>
                      <div class="col-2"><a href="#" class="btn btn-outline-dark rounded-1 p-2 fs-6"><svg width="18"
                            height="18">
                            <use xlink:href="#heart"></use>
                          </svg></a></div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
          <!-- / products-carousel -->

        </div>
      </div>
    </div>
  </section>

  <section id="subscription">
    <div class="container-lg">

      <div class="bg-secondary text-light py-5"
        style="background: url('../imagecumbre/subs_img.png') no-repeat; background-size: cover;">
        <div class="container">
          <div class="row justify-content-center align-items-center">
            <div class="col-md-5 p-5">
              <div class="section-header">
                <h2 class="section-title text-capitalize display-5 text-light">Get 25% Discount on your first purchase
                </h2>
              </div>
              <p>Just Sign Up & Register it now to become member.</p>
            </div>
            <div class="col-md-5 p-3">
              <form>
                <div class="mb-3">
                  <label for="name" class="form-label d-none">Name</label>
                  <input type="text" class="form-control form-control-md rounded-0" name="name" id="name"
                    placeholder="Name">
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label d-none">Email</label>
                  <input type="email" class="form-control form-control-md rounded-0" name="email" id="email"
                    placeholder="Email Address">
                </div>
                <div class="d-grid gap-2">
                  <button type="submit" class="btn btn-dark btn-md rounded-0">Submit</button>
                </div>
              </form>

            </div>

          </div>

        </div>
      </div>

    </div>
  </section>



  <section id="latest-blog" class="section-padding pt-0">
    <div class="container-lg">
      <div class="row">
        <div class="section-header d-flex align-items-center justify-content-between my-4">
          <h2 class="section-title text-capitalize">Our Recent Blog</h2>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <article class="post-item card border-0 rounded-0">
            <div class="image-holder zoom-effect">
              <a href="../footer/sub_news/Newspage1.html">
                <img src="../imagecumbre/news/handshake.png" alt="post" class="card-img-top">
              </a>
            </div>
            <div class="card-body px-0">
              <div class="post-meta d-flex text-uppercase gap-3 my-2 align-items-center">
                <div class="meta-date"><a href="#" class="text-secondary text-decoration-none">22 Mar
                    2025</a></div>
                <div class="meta-categories"><a href="" class="text-secondary text-decoration-none">trending</a></div>
              </div>
              <div class="post-header">
                <h3 class="post-title mt-3">
                  <a href="../footer/sub_news/Newspage1.html" class="text-decoration-none text-capitalize">Brand's
                    partnership
                    announcement with materials manufacturer PT Radian Sinergi Utama</a>
                </h3>
                <p>Following the bran's partnership announcement with materials manufacturer PT Radian
                  Sinergi, CUMBREPACK has been working to develop a new lightweight construction
                  method. Dedicated to continuous innovation and problemsolving for the mountain
                  athlete, CUMBREPACK obsesses over developing innovative solutions for fast and
                  efficient travel in the mountains.
                </p>
              </div>
            </div>
          </article>
        </div>
        <div class="col-md-4">
          <article class="post-item card border-0 rounded-0">
            <div class="image-holder zoom-effect">
              <a href="../footer/sub_news/Newspage2.html">
                <img src="../imagecumbre/news/mounteneering.png" alt="post" class="card-img-top">
              </a>
            </div>
            <div class="card-body px-0">
              <div class="post-meta d-flex text-uppercase gap-3 my-2 align-items-center">
                <div class="meta-date"><a href="#" class="text-secondary text-decoration-none">23 Apr
                    2025</a></div>
                <div class="meta-categories"><a href="#" class="text-secondary text-decoration-none">trending</a></div>
              </div>
              <div class="post-header">
                <h3 class="post-title mt-3">
                  <a href="../footer/sub_news/Newspage2.html" class="text-decoration-none text-capitalize">New Business
                    Unit to Deepen
                    Commitment to Mountain Footwear and Accelerate Growth
                  </a>
                </h3>
                <p>BANDUNG - April 22, 2025 - CUMBREPACK Equipment, the global design company
                  specializing in technical high-performance apparel and equipment, today announced
                  the formation of a dedicated Footwear Business Unit to accelerate the growth of its
                  footwear category following the successful Spring 2025 launch of its expanded
                  footwear collection.
                </p>
              </div>
            </div>
          </article>
        </div>
        <div class="col-md-4">
          <article class="post-item card border-0 rounded-0">
            <div class="image-holder zoom-effect">
              <a href="../footer/sub_news/Newspage3.html">
                <img src="../imagecumbre/news/fiersa.png" alt="post" class="card-img-top">
              </a>
            </div>
            <div class="card-body px-0">
              <div class="post-meta d-flex text-uppercase gap-3 my-2 align-items-center">
                <div class="meta-date"><a href="#" class="text-secondary text-decoration-none">27 Apr
                    2025</a></div>
                <div class="meta-categories"><a href="#" class="text-secondary text-decoration-none">inspiration</a>
                </div>
              </div>
              <div class="post-header">
                <h3 class="post-title mt-3">
                  <a href="../footer/sub_news/Newspage1.html" class="text-decoration-none text-capitalize">Industry
                    Veteran Fiersa
                    Besari Named Chief Merchandising Officer
                  </a>
                </h3>
                <p>Bandung, West Java(April 26, 2025) - CUMBREPACK Equipment, the global design company
                  specializing in technical high-performance apparel and equipment, has announced the
                  appointment of Matt Bolte as Chief Merchandising Officer. Additionally, the company
                  named Marissa Pardini as General Manager and Ben Stubbington as Creative Director of
                  its Veilance brand.
                </p>
              </div>
            </div>
          </article>
        </div>
      </div>
    </div>
  </section>

  <footer class="bg-dark text-light section-padding pb-5">
    <div class="container-lg">
      <div class="row">

        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="footer-menu">
            <img src="../imagecumbre/logo.jpg" width="240" height="100" alt="logo">
            <div class="social-links mt-3">
              <ul class="d-flex list-unstyled gap-2">
                <li>
                  <a href="#" class="btn btn-outline-light">
                    <svg width="16" height="16">
                      <use xlink:href="#facebook"></use>
                    </svg>
                  </a>
                </li>
                <li>
                  <a href="#" class="btn btn-outline-light">
                    <svg width="16" height="16">
                      <use xlink:href="#twitter"></use>
                    </svg>
                  </a>
                </li>
                <li>
                  <a href="#" class="btn btn-outline-light">
                    <svg width="16" height="16">
                      <use xlink:href="#youtube"></use>
                    </svg>
                  </a>
                </li>
                <li>
                  <a href="#" class="btn btn-outline-light">
                    <svg width="16" height="16">
                      <use xlink:href="#instagram"></use>
                    </svg>
                  </a>
                </li>
                <li>
                  <a href="#" class="btn btn-outline-light">
                    <svg width="16" height="16">
                      <use xlink:href="#amazon"></use>
                    </svg>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <div class="col-md-2 col-sm-6">
          <div class="footer-menu">
            <h5 class="widget-title text-light">CUMBREPACK</h5>
            <ul class="menu-list list-unstyled">
              <li class="menu-item">
                <a href="../footer/Aboutus_footer.html" class="nav-link">About us</a>
              </li>
              <li class="menu-item">
                <a href="#" class="nav-link">Conditions</a>
              </li>
              <li class="menu-item">
                <a href="../footer/Newspage_footer.html" class="nav-link">Our Blog</a>
              </li>
              <li class="menu-item">
                <a href="../footer/Career_footer.html" class="nav-link">Careers</a>
              </li>
              <li class="menu-item">
                <a href="../footer/Sustainbility_footer.html" class="nav-link">Sustainibility</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-md-2 col-sm-6">
          <div class="footer-menu">
            <h5 class="widget-title text-light">Quick Links</h5>
            <ul class="menu-list list-unstyled">
              <li class="menu-item">
                <a href="#" class="nav-link">Offers</a>
              </li>
              <li class="menu-item">
                <a href="#" class="nav-link">Stores</a>
              </li>
              <li class="menu-item">
                <a href="#" class="nav-link">Shop</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-md-2 col-sm-6">
          <div class="footer-menu">
            <h5 class="widget-title text-light">Customer Service</h5>
            <ul class="menu-list list-unstyled">
              <li class="menu-item">
                <a href="../footer/FAQ_footer.html" class="nav-link">FAQ</a>
              </li>
              <li class="menu-item">
                <a href="../footer/Contact_footer.html" class="nav-link">Contact</a>
              </li>
              <li class="menu-item">
                <a href="../footer/Policy_footer.html" class="nav-link">Privacy Policy</a>
              </li>
              <li class="menu-item">
                <a href="../footer/Refund_footer.html" class="nav-link">Returns & Refunds</a>
              </li>
              <li class="menu-item">
                <a href="../footer/Ordertrack_footer.html" class="nav-link">Delivery Information</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="footer-menu">
            <h5 class="widget-title text-light">Subscribe Us</h5>
            <p>Subscribe to our newsletter to get updates about our grand offers.</p>
            <form class="d-flex mt-3 gap-0" action="index.html">
              <input class="form-control rounded-start rounded-0 bg-light" type="email" placeholder="Email Address"
                aria-label="Email Address">
              <button class="btn btn-primary rounded-end rounded-0" type="submit">Subscribe</button>
            </form>
          </div>
        </div>

      </div>
    </div>
  </footer>
  <div id="footer-bottom" class="bg-dark text-light py-5">
    <div class="container-lg">
      <div class="row">
        <div class="col-md-6 copyright">
          <p>© 2025 CUMBREPACK. All rights reserved.</p>
        </div>
        <div class="col-md-6 credit-link text-start text-md-end">
        </div>
      </div>
    </div>
  </div>

  <script src="js/jquery-1.11.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
  <script src="js/plugins.js"></script>
  <script src="js/script.js"></script>

  <!-- script untuk cart -->
  <script>
    function changeQuantity(amount) {
      const quantityInput = document.getElementById('quantity');
      let currentValue = parseInt(quantityInput.value);
      currentValue += amount;
      if (currentValue < 1) currentValue = 1;
      quantityInput.value = currentValue;
    }

    function addToCart() {
      const productName = document.querySelector('.detail-product-title').textContent;
      const productPrice = document.querySelector('.price').textContent;
      const productImage = document.querySelector('.img-product-detail').src;

      const selectedColor = document.querySelector('.color-swatches .swatch.active').style.backgroundColor || 'Black';

      const selectedSize = document.querySelector('.size-selector .size.active').textContent;

      const quantity = document.getElementById('quantity').value;

      const priceValue = parseFloat(productPrice.replace('$', ''));
      const totalPrice = (priceValue * quantity).toFixed(2);

      const cartItem = {
        name: productName,
        price: productPrice,
        total: `$${totalPrice}`,
        image: productImage,
        color: selectedColor,
        size: selectedSize,
        quantity: quantity
      };

      let cart = JSON.parse(localStorage.getItem('cart')) || [];

      cart.push(cartItem);

      localStorage.setItem('cart', JSON.stringify(cart));

      updateCartDisplay();

      alert(`${productName} (Size: ${selectedSize}, Color: ${selectedColor}) telah ditambahkan ke keranjang!`);
    }

    function updateCartWithDeleteButtons() {
      const cart = JSON.parse(localStorage.getItem('cart')) || [];
      const cartList = document.getElementById('cartItems');

      cartList.innerHTML = '';

      if (cart.length === 0) {
        cartList.innerHTML = '<li class="list-group-item text-center py-4">Keranjang kosong</li>';
        document.getElementById('cartCount').textContent = '0';
        return;
      }

      let total = 0;

      cart.forEach((item, index) => {
        total += parseFloat(item.price.replace('$', '')) * parseInt(item.quantity);

        const listItem = document.createElement('li');
        listItem.className = 'list-group-item d-flex justify-content-between align-items-center';
        listItem.innerHTML = `
      <div class="d-flex align-items-center flex-grow-1">
        <img src="${item.image}" alt="${item.name}" width="60" height="60" class="rounded me-3">
        <div class="flex-grow-1">
          <h6 class="my-0">${item.name}</h6>
          <small class="text-muted d-block">Size: ${item.size}</small>
          <small class="text-muted">Color: ${item.color}</small>
        </div>
      </div>
      <div class="text-end">
        <div class="d-flex align-items-center justify-content-end">
          <span class="text-primary fw-bold me-3">${item.price} × ${item.quantity}</span>
          <button class="btn btn-sm btn-outline-danger delete-btn" data-index="${index}">
            <svg width="16" height="16"><use xlink:href="#trash"></use></svg>
          </button>
        </div>
        <small class="text-muted">Subtotal: $${(parseFloat(item.price.replace('$', '')) * parseInt(item.quantity)).toFixed(2)}</small>
      </div>
    `;

        cartList.appendChild(listItem);
      });

      const totalItem = document.createElement('li');
      totalItem.className = 'list-group-item d-flex justify-content-between fw-bold bg-light';
      totalItem.innerHTML = `
    <span>Total (USD)</span>
    <strong>$${total.toFixed(2)}</strong>
  `;
      cartList.appendChild(totalItem);

      document.getElementById('cartCount').textContent = cart.length;

      document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function () {
          const index = parseInt(this.getAttribute('data-index'));
          removeItemFromCart(index);
        });
      });
    }

    function removeItemFromCart(index) {
      if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        cart.splice(index, 1);

        localStorage.setItem('cart', JSON.stringify(cart));

        updateCartWithDeleteButtons();

        showAlert('Item berhasil dihapus dari keranjang', 'success');
      }
    }

    function showAlert(message, type = 'success') {
      const alertDiv = document.createElement('div');
      alertDiv.className = `alert alert-${type} position-fixed top-0 end-0 m-3`;
      alertDiv.setAttribute('role', 'alert');
      alertDiv.textContent = message;

      document.body.appendChild(alertDiv);

      setTimeout(() => {
        alertDiv.remove();
      }, 3000);
    }

    document.addEventListener('DOMContentLoaded', function () {
      updateCartWithDeleteButtons();

      const offcanvasCart = document.getElementById('offcanvasCart');
      if (offcanvasCart) {
        offcanvasCart.addEventListener('shown.bs.offcanvas', function () {
          updateCartWithDeleteButtons();
        });
      }
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

      window.location.href = 'order.html';
    }

    document.getElementById('continueToCheckout').addEventListener('click', function () {
      window.location.href = 'order.html';
    });
  </script>

<!-- script untuk memunculkan header -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
        document.querySelector('.auth-section').classList.add('d-none');
        document.querySelector('.user-section').classList.remove('d-none');

        const userIcon = document.querySelector('.user-section a[title="My Account"]');
        if (userIcon) {
          userIcon.innerHTML = `<svg width="24" height="24"><use xlink:href="#user"></use></svg>`;
          userIcon.insertAdjacentHTML('afterend', `<span class="ms-2"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>`);
        }
      <?php endif; ?>

      document.querySelector('.user-section').addEventListener('click', function (e) {
        if (e.target.closest('a[title="My Account"]')) {
          e.preventDefault();
          const dropdown = document.createElement('div');
          dropdown.className = 'dropdown-menu show';
          dropdown.style.position = 'absolute';
          dropdown.style.right = '0';
          dropdown.innerHTML = `
        <a class="dropdown-item" href="../home/logout.php">Logout</a>
      `;
          this.appendChild(dropdown);
        }
      });
    });
  </script>
</body>

</html>