<?php include 'header.php'?>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $login_username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $login_password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

        $stmt = $conn->prepare("SELECT id, username, email, password, roles FROM users WHERE username = ?");
        $stmt->bind_param('s', $login_username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $db_username, $db_email, $hashed_password, $db_role);
            $stmt->fetch();

            if (password_verify($login_password, $hashed_password)) {
                $_SESSION['id'] = $user_id;
                $_SESSION['username'] = $db_username;
                $_SESSION['email'] = $db_email;
                $_SESSION['roles'] = $db_role;

                header('Location: index.php');
                exit();
            } else {
                header('Location: login.php');
                exit();
            }
        }
    }
?>

    <form class='container auth__container' action="login.php" method="POST">
        <h1>Login</h1>
        <p>Asslmlkm! Enter your details to sign in to your account</p>
        <div>
            <label for="username">Username</label>
            <input type="text" id='username' name='username' placeholder='Enter username' required>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" id='password' name='password' placeholder='Password' required>
        </div>
        <input id="submit" type="submit" value="Sign In">
    </form>
</body>
</html>