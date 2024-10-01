<?php include 'header.php'?>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $signup_username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
        $signup_email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
        $signup_pw = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);
        $signup_confirm_pw = filter_input(INPUT_POST, "confirm_password", FILTER_SANITIZE_SPECIAL_CHARS);

        if ($signup_pw == $signup_confirm_pw) {
            $check_sql = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
            $check_sql->bind_param('ss', $signup_username, $signup_email);
            $check_sql->execute();
            $check_sql->store_result();

            if ($check_sql->num_rows > 0) {
                echo "<script>alert('Username or email already exists. Please use a different one.');</script>";
            } else {
                $stmt = $conn->prepare("INSERT INTO users (username, email, password, roles) VALUES (?, ?, ?, ?)");

                $hash_pw = password_hash($signup_pw, PASSWORD_DEFAULT);
                $role = 'Admin';
                
                $stmt->bind_param('ssss', $signup_username, $signup_email, $hash_pw, $role);
                
                if ($stmt->execute()) {
                    $user_id = $stmt->insert_id;
                    $db_username = $signup_username;
                    $db_email = $signup_email;
                    $db_role = 'Admin';

                    $_SESSION['id'] = $user_id;
                    $_SESSION['username'] = $db_username;
                    $_SESSION['email'] = $db_email;
                    $_SESSION['roles'] = $db_role;
                    
                    $stmt->close();
    
                    header('Location: index.php');
                    exit();
                } else {
                    echo "<script>alert('Error: " . $stmt->error() . "');</script>";
                }

                $stmt->close();
            }
            $check_sql->close();
        } else {
            echo "<script>alert('Password did not match. Cuba lagi.');</script>";
        }
    }
?>

    <form class='container auth__container' action="signup.php" method="POST">
        <h1>Create Your Account</h1>
        <p>Asslmlkm! Join us dear adven- ehem* pengguna :D</p>
        <div>
            <label for="username">Username</label>
            <input type="text" id='username' name='username' placeholder='Enter username' required>
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" id='email' name='email' placeholder='Enter email' required>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" id='password' name='password' placeholder='Password' required>
        </div>
        <div>
            <label for="confirm_password">Confirm Password</label>
            <input type="password" id='confirm-password' name='confirm_password' placeholder='Confirm Password' required>
        </div>
        <input id="submit" type="submit" value="Sign Up">
    </form>
</body>
</html>