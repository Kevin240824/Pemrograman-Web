<?php
session_start();
require_once 'config.php'; // File konfigurasi database

// Cek apakah user sudah login
$isLoggedIn = isset($_SESSION['signup_id']);
$user = $isLoggedIn ? $_SESSION['nama'] : '';
?>

<header>
    <div class="container-fluid">
      <div class="row py-4">

        <div
          class="col-sm-4 col-lg-2 text-center text-sm-start d-flex gap-3 justify-content-center justify-content-md-start">
          <div class="d-flex align-items-center my-3 my-sm-0">
            <!-- <a href="homepage.html"> -->
            <a href="homepage.php" class="nav-link">
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
              <a href="onSale.html" class="nav-link">Sale</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle pe-3" role="button" id="pages" data-bs-toggle="dropdown"
                aria-expanded="false">Pages</a>
              <ul class="dropdown-menu border-0 rounded-0 shadow" aria-labelledby="pages">
                <li><a href="../footer/Aboutus_footer.php" class="dropdown-item">About Us </a></li>
                <li><a href="../footer/Newspage_footer.php" class="dropdown-item">Our Blog </a></li>
                <li><a href="../footer/Sustainbility_footer.php" class="dropdown-item">Sustainibility </a></li>
                <li><a href="../footer/FAQ_footer.php" class="dropdown-item">FAQ </a></li>
                <li><a href="../footer/Contact_footer.php" class="dropdown-item">Contact </a></li>
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
            <?php echo $_SESSION['login_error']; unset($_SESSION['login_error']); ?>
          </div>
        <?php endif; ?>

        <form action="process_login.php" method="post">
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
          <p>Don't have an account? <a href="#" data-bs-toggle="modal" data-bs-target="#signupModal" data-bs-dismiss="modal">Sign up</a></p>
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
                  <form action="process_signup.php" method="post">
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

<!-- Include modal login/signup -->
<?php include 'modals.php'; ?>