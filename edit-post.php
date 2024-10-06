<?php
    include 'database.php';
    session_start();

    include 'logged-in.php';

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

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $show = "SELECT
                    p.id,
                    p.category_id,
                    p.penceramah,
                    p.title,
                    p.content,
                    GROUP_CONCAT(t.id SEPARATOR ', ') AS tag_ids
                FROM posts p
                LEFT JOIN posts_tags pt ON p.id = pt.post_id
                LEFT JOIN tags t ON pt.tag_id = t.id
                WHERE p.id = ? AND p.user_id = ?
                GROUP BY p.id";
        
        $show_sql = $conn->prepare($show);
        $show_sql->bind_param('ii', $id, $user_id);        
        $show_sql->execute();
        $show_sql->store_result();
        
        if ($show_sql->num_rows === 1) {
            $show_sql->bind_result($id, $category_id, $penceramah, $title, $content, $tag_ids);
            $show_sql->fetch();
        } else {
            echo "<script>
                    alert('Invalid Post ID');
                    window.location.href = 'manage.php';
                    </script>";
        }

        $show_sql->close();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $post_id = isset($_POST['post_id']) ? (int)$_POST['post_id'] : null;

        $create_category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_SPECIAL_CHARS);
        $create_penceramah = filter_input(INPUT_POST, 'penceramah', FILTER_SANITIZE_SPECIAL_CHARS);
        $create_title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
        $create_content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
    
        $select_tags = filter_input(INPUT_POST, 'selected_tags', FILTER_SANITIZE_SPECIAL_CHARS);
        $create_tags = !empty($select_tags) ? explode(", ", $select_tags) : [];

        $stmt = $conn->prepare("UPDATE posts SET category_id = ?, penceramah = ?, title = ?, content = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param('isssii', $create_category, $create_penceramah, $create_title, $create_content, $post_id, $user_id);

        if ($stmt->execute()) {
            $delete_tags = $conn->prepare("DELETE FROM posts_tags WHERE post_id = ?");
            $delete_tags->bind_param('i', $post_id);
            $delete_tags->execute();
            $delete_tags->close();

            if (!empty($create_tags)) {
                $tags_stmt = $conn->prepare("INSERT INTO posts_tags (post_id, tag_id) VALUES (?, ?)");
                foreach ($create_tags as $tag_id) {
                    $tags_stmt->bind_param('ii', $post_id, $tag_id);
                    $tags_stmt->execute();
                }
                $tags_stmt->close();
            } else {
                echo "<script>alert('No tag chosen. Please reselect if needed :D');</script>";
            }

            echo "<script>
                    alert('Post successfully updated!');
                    window.location.href = 'index.php';
                    </script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error() . "');</script>";
        }

        $stmt->close();
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

    <form class="container" action="edit-post.php" method="POST">
        <h2>Editing...</h2>
        
        <input type="hidden" name="post_id" value="<?php echo $id; ?>">

        <p>Post ID: <?php echo $id; ?></p>
        <div>
            <label for="category">Category</label>
            <select name="category" id="category">
                <option value="" disabled selected>Select a catogory</option>
                <?php
                    $categories_sql = $conn->query("SELECT id, name FROM categories");
                    
                    while ($row = $categories_sql->fetch_assoc()) {
                        $selected_status = $row['id'] == $category_id ? 'selected' : '';
                        echo "<option value='" . $row['id'] . "' $selected_status>" . $row['name'] . "</option>";
                    }
                ?>
            </select>
        </div>

        <div>
            <label for="penceramah">Sauce</label>
            <input type="text" id="penceramah" name="penceramah" placeholder="Enter nama penceramah" value="<?php echo htmlspecialchars($penceramah); ?>" required>
        </div>

        <div>
            <p class="tags__option">Tags (please reselect your tag):</p>
            <input type="hidden" name="selected_tags" id="selected-tags" value="<?php echo $tag_ids; ?>">
            <div class="tags__container">
                <?php
                    $tags_sql = "SELECT id, name FROM tags ORDER BY id ASC";
                    $tags_result = $conn->query($tags_sql);
                    $exist_tag_ids = explode(",", $tag_ids);

                    while ($tag = $tags_result->fetch_assoc()) {
                        $active_tags = in_array($tag['id'], $exist_tag_ids) ? 'active' : '';
                        echo "<button type='button' class='tag__btn' data-tag-id='" . $tag['id'] . "'>" . $tag['name'] . "</button>";
                    }
                ?>
            </div>
        </div>

        <div>
            <label for="title">Title</label>
            <input type="text" id="title" name="title" placeholder="Enter blog title" value="<?php echo html_entity_decode($title); ?>" required>
        </div>

        <div>
            <label for="content">Content:</label>
            <textarea id="content" name="content" required><?php echo html_entity_decode($content); ?></textarea>
        </div>

        <div class="user__action">
            <button id="back-btn" type="button" onclick="window.history.back()">Cancel</button>
            <input id="submit" type="submit" value="Update Post">
        </div>
    </form>
    

</body>
</html>