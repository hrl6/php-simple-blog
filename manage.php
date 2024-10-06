<?php
    include 'header.php'; 
    include 'logged-in.php';
?>

<?php
    if (isset($user_id)) {
        $show = "SELECT 
                    p.id,
                    p.date_created,
                    p.date_updated,
                    p.category_id,
                    p.penceramah,
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
                WHERE p.user_id = ?
                GROUP BY p.id, c.name
                ORDER BY p.date_updated DESC";
        
        $stmt_show = $conn->prepare($show);
        $stmt_show->bind_param('i', $user_id);
        $stmt_show->execute();
        $result = $stmt_show->get_result();
        //$stmt_show->bind_result($id, $date_created, $date_updated, $category_id, $penceramah, $title, $content, $likes, $userdb_id, $category_name, $tag_names);
    }
?>

    <section class='container'>
        <?php echo "User ID: #" . $user_id?>
        <h2>Manage Posts</h2>
        <p>Total posts: <span><?php echo $result->num_rows; ?></span></p>
        <table>
            <thead>
                <tr>
                    <th>Date Created</th>
                    <th>Date Updated</th>
                    <th>Penceramah</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Likes</th>
                    <th>Category</th>
                    <th>Tags</th>
                    <th>Action</th>
                </tr>
            </thead>
            
            <tbody>
                <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo date("j M Y", strtotime($row['date_created'])); ?></td>
                    <td><?php echo date("j M Y", strtotime($row['date_updated'])); ?></td>
                    <td><?php echo htmlspecialchars($row['penceramah']); ?></td>
                    <td><?php echo html_entity_decode($row['title']); ?></td>
                    <td><a href="post.php?id=<?php echo $row['id']?>">View content...</a></td>
                    <td><?php echo htmlspecialchars($row['likes']); ?></td>
                    <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['tag_names']); ?></td>
                        <td>
                            <!--<button><i class='bx bxs-edit-alt'></i></button>-->
                            <a href="edit-post.php?id=<?php echo $row['id']; ?>">
                                <button><i class='bx bxs-edit-alt'></i></button>
                            </a>
                            <a href="delete-post.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this post?');">
                                <button><i class='bx bxs-trash'></i></button>
                            </a>
                </tr>
                <?php 
                    }} else {
                        echo "<tr><td colspan='9'>No posts found.</td></tr>";
                    }; 
                ?>
            </tbody>
        </table>
    </section>

<?php $stmt_show->close(); ?>

</body>
</html>