<?php include 'header.php'?>

    <section class="container blogs__container">
        <div class="button__container">
            <h1>Posts</h1>
            <?php if(isset($username) && $role == "Admin"): ?>
                <a href="create-post.php"><button id="create-post"><i class='bx bx-plus'></i>Create Post</button></a>
            <?php endif; ?>
        </div>
        <div class="post__container">
            <?php
                $sql = "SELECT 
                    p.id,
                    p.date_created,
                    p.date_updated,
                    p.category_id,
                    p.title,
                    p.content,
                    p.likes,
                    p.user_id,
                    c.name AS category_name
                FROM posts p
                JOIN categories c ON p.category_id = c.id
                ORDER BY date_updated DESC";

                $stmt = $conn->prepare($sql);

                if ($stmt == false) {
                    die("Error preparing statement: " . $conn->error);
                }

                $stmt->execute();
                $stmt->bind_result($id, $date_created, $date_updated, $category_id, $title, $content, $likes, $user_id, $category_name);

                while ($stmt->fetch()){
                    if (isset($title) && isset($content)) {
                        $title_words = explode(' ', $title);
                        $text_words = explode(' ', $content);
                
                        if (count($title_words) > 13) {
                            $title = html_entity_decode(implode(' ', array_slice($title_words, 0, 13))) . '...';
                        } else {
                            $title = html_entity_decode($title);
                        }

                        if (count($text_words) > 48) {
                            $text = html_entity_decode(implode(' ', array_slice($text_words, 0, 48))) . '...';
                        } else {
                            $text = html_entity_decode($content);
                        }
                    } else {
                        $text = '';
                        $title_tx = '';
                    }
            ?>

                    <p class="post__category"><?php echo htmlspecialchars($category_name); ?></p>
                    <h3><?php echo $title; ?></h3>
                    <p class="homep__content"><?php echo $text; ?></p>
                    <a href="post.php?id=<?php echo $id; ?>"><span id="read-more">View more</span></a>
                    <?php if ($date_created != $date_updated): ?>
                        <p class="post__date"><?php echo date("j F, Y", strtotime($date_updated)) . " (<em>edited</em>)"; ?></p>
                    <?php else: ?>
                        <p class="post__date"><?php echo date("j F, Y", strtotime($date_created)); ?></p>
                    <?php endif; ?>
            <?php }; ?>
        </div>
    </section>
</body>
</html>