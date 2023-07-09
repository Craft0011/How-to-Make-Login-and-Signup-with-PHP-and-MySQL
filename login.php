<?php

    session_start();

    include('server.php');

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['user'];
        $password = $_POST['password'];

        // Encrypt the password before comparing it in the SQL query.
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "SELECT * FROM users WHERE user='$username'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $storedPassword = $row['password'];

            // Verify the correctness of the hashed password.
            if (password_verify($password, $storedPassword)) {
                $_SESSION['username'] = $username;
                header('location: index.php');
            } else {
                header('location: signup.php');
            }
        } else {
            header('location: login.php');
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <div class="login">
        <h1>Login</h1>
        <div class="login-img">
            <img src="login-img.png" alt="logo" width="100%" height="100%">
        </div>
        <div class="login-form">
            <form action="login.php" method="POST">
                <input type="text" name="user" placeholder="Enter Your User" require><br>
                <input type="password" name="password" placeholder="Enter Your Password" require><br>
                <button>Login</button>
            </form>
        </div>
        <span>Don't have a account?<a href="signup.php" class="sign-up">Sign Up</a></span>
        <div class="text-login">
            <span>By contioning, you agree to our</span><br>
            <span>Terms & Privacy Policy</span>
        </div>
    </div>

</body>
</html>