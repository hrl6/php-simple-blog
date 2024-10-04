<?php
    include 'database.php';

    if (isset($_GET['id'])) {
        $post_id = $_GET['id'];

        $delete = "DELETE FROM posts WHERE id = ?";
        $delete_stmt = $conn->prepare($delete);
        $delete_stmt->bind_param('i', $post_id);

        if ($delete_stmt->execute()) {
            echo  "<script> alert('Post successfully deleted!'); </script>";
        } else {
            echo "<script>alert('Error deleting post: " . $stmt->error() . "');</script>";
        }

        $delete_stmt->close();

        header("Location: manage.php");
        exit();
    } else {
        echo "<script> alert('No post ID provided!'); </script>";
    }
?>