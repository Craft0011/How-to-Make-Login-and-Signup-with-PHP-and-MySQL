<?php

    session_start();

    if (!isset($_SESSION['username'])) {
        header('location: login.php');
        exit();
    }

    if (isset($_GET['logout'])) {
        session_unset();
        session_destroy();
        header('location: login.php');
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
     <div class="container-user">
        <span class="name-user">
            <?php
                if (isset($_SESSION['username'])) {
                    echo $_SESSION['username'];
                }
            ?>
        </span>
        <span class="logout">
            <a href="?logout">Logout</a>
        </span>
    </div>

</body>
</html>