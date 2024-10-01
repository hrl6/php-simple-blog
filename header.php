<?php
    # include db manually in create-post.php bcus diff header setup
    include 'database.php';

    session_start();

    $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
    $user_email = isset($_SESSION['email']) ? $_SESSION['email'] : null;
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
    $role = isset($_SESSION['roles']) ? $_SESSION['roles'] : null;

    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['logout'])) {
        $_SESSION = array();
        session_destroy();
        header("Location: login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deen</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/post.css">
    <link rel="stylesheet" href="css/login.css">

    <!-- BOXICONS https://boxicons.com/ -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <header>
        <a href="index.php"><img src="img/deen-logo.png" alt="Logo Deen" class="logo__img"></a>
        <nav>
            <?php if (isset($_SESSION['username'])): ?>
                <form method="POST">
                    <P>Welcome, <span><?php echo $username?></span></P>    
                    <a href="index.php"><button type="submit" name="logout" id="logout-btn"><i class='bx bxs-log-out'></i>Logout</button></a>
                </form>
            <?php else: ?>
                <a href="login.php"><button id="login-btn">Login</button></a>
                <a href="signup.php"><button>Create an account</button></a>
            <?php endif; ?>
        </nav>
    </header>