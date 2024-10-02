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

    <script src="select.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/create.css">

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
                <a href="#"><button>Create an account</button></a>
            <?php endif; ?>
        </nav>
    </header>
    <form action="create-post.php" class="container">
        <h2>Create Post</h2>
        
        <?php
            $categories_sql = "SELECT id, name FROM categories";
            $categories_result = $conn->query($categories_sql);
        ?>
        <div>
            <label for="category">Category</label>
            <select name="category" id="category">
                <option value="" disabled selected>Select a catogory</option>
                <?php
                    if ($categories_result->num_rows > 0) {
                        while ($row = $categories_result->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                        }
                    } else {
                        echo "<option value='' disabled>No categories available</option>";
                    }
                ?>
            </select>
        </div>

        <div>
            <label for="penceramah">Sauce</label>
            <input type="text" id="penceramah" name="penceramah" placeholder="Enter nama penceramah" required>
        </div>

        <div>
            <p class="tags__option">Tags (optional):</p>
            <input type="hidden" name="selected_tags" id="selected-tags" value="">
            <div class="tags__container">
                <?php
                    $tags_sql = "SELECT id, name FROM tags";
                    $tags_result = $conn->query($tags_sql);

                    if ($tags_result->num_rows > 0) {
                        while ($tag = $tags_result->fetch_assoc()) {
                            echo "<button type='button' class='tag__btn' data-tag-id='" . $tag['id'] . "'>" . $tag['name'] . "</button>";
                        }
                    }
                ?>
            </div>
        </div>

        <div>
            <label for="title">Title</label>
            <input type="text" id="title" name="title" placeholder="Enter blog title" required>
        </div>

        <div>
            <label for="content">Content:</label>
            <textarea id="content" name="content" required></textarea>
        </div>
        
        <!--<div id="editor"></div>
        <script>
            const toolbarOptions = [
                ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
                ['blockquote', 'code-block'],
                ['link', 'image', 'video', 'formula'],

                [{ 'header': 1 }, { 'header': 2 }],               // custom button values
                [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'list': 'check' }],
                [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
                [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
                [{ 'direction': 'rtl' }],                         // text direction

                [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

                [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
                [{ 'font': [] }],
                [{ 'align': [] }],

                ['clean']                                         // remove formatting button
            ];

            const quill = new Quill('#editor', {
            modules: {
                toolbar: toolbarOptions
            },
            placeholder: "Write your blog content here...",
            theme: 'snow'
            });
        </script>-->

        <div class="user__action">
            <a href="index.html"><button id="back-btn" onclick="window.history.back()">Cancel</button></a>
            <input id="submit" type="submit" value="Confirm">
        </div>
    </form>
    

</body>
</html>