<?php include 'header.php'?>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $login_username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $login_password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

        $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->bind_param('s', $login_username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            if (password_verify($login_password, $hashed_password)) {
                $_SESSION['id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];

                header('Location: index.php');

                exit;
            }
        }
    }
?>

    <form class='container login__container' action="login.php" method="POST">
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
        <input id="submit" type="submit" value="Sign in">
    </form>
</body>
</html>