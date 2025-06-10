<?php
// Include database configuration
require_once 'config.php';

// Check if user is redirected from signup.php
if (!isset($_SERVER['HTTP_REFERER']) || strpos($_SERVER['HTTP_REFERER'], 'signup.php') === false) {
    header("Location: index.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Success</title>
    <!-- Include your CSS files here -->
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mt-5">
                <div class="alert alert-success">
                    <h4 class="alert-heading">Registration Successful!</h4>
                    <p>Your account has been created successfully. You can now login to your account.</p>
                    <hr>
                    <p class="mb-0">
                        <a href="login.php" class="btn btn-primary">Go to Login</a>
                        <a href="index.php" class="btn btn-secondary">Back to Home</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>