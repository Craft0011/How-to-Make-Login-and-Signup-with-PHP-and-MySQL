<?php
    session_start();

    include('server.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['user'];
        $password = $_POST['password'];

        // Check if the user already exists or not.
        $check_user_query = "SELECT * FROM users WHERE user = ?";
        $stmt = mysqli_prepare($conn, $check_user_query);
        mysqli_stmt_bind_param($stmt, "s" , $username);
        mysqli_stmt_execute($stmt);
        $check_user_result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($check_user_result) > 0) {
            echo "<script>alert('User already exists.');</script>";
            echo "<script>window.location.href = 'signup.php';</script>";
            exit;
        }

        // Check if the entered data exists or not.
        if(empty($username) || empty($password)) {
            echo "<script>alert('Please enter both username and password.');</script>";
            echo "<script>window.location.href = 'signup.php';</script>";
            exit;
        }

        // Validate password length
        if (strlen($password) < 8) {
            echo "<script>alert('Password must be at least 8 characters long.');</script>";
            echo "<script>window.location.href = 'signup.php';</script>";
            exit;
        }

        // Validate username for special characters
        if(!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
            echo "<script>alert('Username should only contain letters and numbers.');</script>";
            echo "<script>window.location.href = 'signup.php';</script>";
            exit;
        }

        // Encrypt the password before saving it in the database.
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Add a new user to the database.
        $sql = "INSERT INTO users (user, password) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss" , $username, $hashedPassword);
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['username'] = $username;
            header('location: index.php');
            exit;
        } else {
            echo "Error: Failed to add user. Please try again.";
        }
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="Sign-up">
        <h1>Sign Up</h1>
        <div class="login-form">
            <form action="signup.php" method="POST">
                <input type="text" name="user" placeholder="Enter Your User" require><br>
                <input type="password" name="password" placeholder="Enter Your Password" require><br>
                <button>Register</button>
            </form>
        </div>
        <span>You have a account?<a href="login.php" class="sign-up">Login</a></span>
        <div class="text-login">
            <span>By contioning, you agree to our</span><br>
            <span>Terms & Privacy Policy</span>
        </div>
    </div>

</body>
</html>