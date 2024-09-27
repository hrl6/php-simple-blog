<?php include 'database.php'?>

<?php include 'header.php'?>

    <section class="container blogs__container">
        <div class="button__container">
            <h1>Posts</h1>
            <?php if(isset($username) && $role == "Admin"): ?>
                <a href="create-post.php"><button id="create-post"><i class='bx bx-plus'></i>Create Post</button></a>
            <?php endif; ?>
        </div>
        <div class="post__container">
            <p class="post__category">CATEGORY</p>
            <h3>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores, tenetur.</h3>
            <p class="post__content">Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore distinctio dolorem quo molestias asperiores possimus vel sed, sapiente quasi error debitis quia enim, modi commodi assumenda totam vero voluptate facilis ratione natus officiis impedit reprehenderit eligendi. Odio blanditiis deleniti incidunt facere eius rerum illum quod minus. <a href="post.php"><span id="read-more">Read more...</span></a></p>
            <p class="post__date">25 September, 2024 </p>
        </div>
    </section>
</body>
</html>