<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: homepage.php");
    exit();
}

require_once 'connect.php';

// Get user data
$stmt = $conn->prepare("SELECT * FROM sign_up WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Profile - CUMBREPACK</title>
    <!-- Include your CSS files here -->
</head>
<body>
    <!-- Include your header here (same as homepage.php) -->

    <section class="section-padding">
        <div class="container-lg">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="section-title">My Profile</h2>
                    
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <img src="https://via.placeholder.com/150" class="rounded-circle mb-3" alt="Profile Picture">
                                        <h4><?php echo htmlspecialchars($user['nama']); ?></h4>
                                        <p class="text-muted">Member since <?php echo date('F Y', strtotime($user['created_at'] ?? 'now')); ?></p>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h4>Personal Information</h4>
                                    <form action="update_profile.php" method="post">
                                        <div class="mb-3">
                                            <label class="form-label">Full Name</label>
                                            <input type="text" class="form-control" name="nama" value="<?php echo htmlspecialchars($user['nama']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Phone Number</label>
                                            <input type="tel" class="form-control" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Update Profile</button>
                                    </form>
                                    
                                    <hr>
                                    
                                    <h4>Change Password</h4>
                                    <form action="change_password.php" method="post">
                                        <div class="mb-3">
                                            <label class="form-label">Current Password</label>
                                            <input type="password" class="form-control" name="current_password" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">New Password</label>
                                            <input type="password" class="form-control" name="new_password" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Confirm New Password</label>
                                            <input type="password" class="form-control" name="confirm_password" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Change Password</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Include your footer here (same as homepage.php) -->
</body>
</html>