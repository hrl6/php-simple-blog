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

    <script src="hamburger.js"></script>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/post.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/manage.css">

    <!-- BOXICONS https://boxicons.com/ -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <header>
        <a href="index.php" id="logo-img"><img src="img/deen-logo.png" alt="Logo Deen" class="logo__img"></a>
        
        <nav id="header-form">
        <?php if (isset($_SESSION['username'])): ?>
            <form method="POST">
                <P id="wc">Welcome, <span><?php echo htmlspecialchars($username); ?></span></P>
                <div class="hamburger" id="hamburger">
                    <i class='bx bx-menu'></i>
                </div>
                
                <ul class="mng__ul">
                    <li><a class="manage__btn" href="manage.php">Manage</a></li>
                    <li><button type="submit" name="logout" id="logout-btn"><i class='bx bxs-log-out'></i>Logout</button></li>
                </ul>

                <div class="close" id="close">
                    <i class='bx bx-x'></i>
                </div>
            </form>
        <?php else: ?>
            <a href="login.php"><button id="login-btn">Login</button></a>
            <a href="signup.php"><button>Create an account</button></a>
        <?php endif; ?>
        </nav>
        
    </header>