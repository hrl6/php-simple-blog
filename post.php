<?php include 'header.php'?>

    <section class="container blogs__container">
        <?php
            $id = $_GET['id'];

            $sql = "SELECT 
                    p.id,
                    p.date_created,
                    p.date_updated,
                    p.category_id,
                    p.title,
                    p.content,
                    p.likes,
                    p.user_id,
                    c.name AS category_name,
                    GROUP_CONCAT(t.name SEPARATOR ', ') AS tag_names
                FROM posts p
                JOIN categories c ON p.category_id = c.id
                LEFT JOIN posts_tags pt ON p.id = pt.post_id
                LEFT JOIN tags t ON pt.tag_id = t.id
                WHERE p.id = ?
                GROUP BY p.id, c.name";

                $stmt = $conn->prepare($sql);

                if ($stmt == false) {
                    die("Error preparing statement: " . $conn->error);
                }

                $stmt->bind_param("i", $id);

                $stmt->execute();

                $stmt->bind_result($id, $date_created, $date_updated, $category_id, $title, $content, $likes, $user_id, $category_name, $tag_names);

                while ($stmt->fetch()){
        ?>
        <p class="post__category"><?php echo htmlspecialchars($category_name); ?></p>
        <div class="post__container">
            <h2><?php echo htmlspecialchars($title); ?></h2>
            <p class="post__date"><?php echo date("j F, Y", strtotime($date_created)); ?></p>
            <ul class="post__tags">
                <?php
                    if ($tag_names) {
                        $tag_array = explode(', ', $tag_names);

                        foreach ($tag_array as $tag) {
                            echo '<li>' . htmlspecialchars($tag) . '</li>';
                        }
                    } else {
                        echo '<li>No Tags</li>';
                    }
                ?>
            </ul>
            <p class="post__content"><?php echo htmlspecialchars($content); ?></p>
            <div class="users__action">
                <button id="likes"><i class='bx bx-like'></i></button>
                <button id="bookmarks"><i class='bx bx-bookmark-plus'></i></button>
                <button id="share"><i class='bx bxs-share-alt'></i></button>
            </div>
        </div>
        <?php }; ?>
    </section>
</body>
</html>