<?php include 'database.php'?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deen</title>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/create.css">

    <!-- BOXICONS https://boxicons.com/ -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <header>
        <a href="index.php"><img src="img/deen-logo.png" alt="Logo Deen" class="logo__img"></a>
        <nav>
            <a href="#"><button id="login-btn">Login</button></a>
            <a href="#"><button>Create an account</button></a>
        </nav>
    </header>
    <form action="" class="container">
        <h2>Create Post</h2>

        <div>
            <label for="category">Category</label>
            <select name="category" id="category">
                <option value="" disabled selected>Select a catogory</option>
                <option value="Tafsir">Tafsir</option>
                <option value="Sirah">Sirah</option>
                <option value="Halal/Haram">Halal/Haram</option>
            </select>
        </div>

        <div>
            <label for="penceramah">Sauce</label>
            <input type="text" id="penceramah" name="penceramah" placeholder="Enter nama penceramah" required>
        </div>

        <div>
            <label>Tags (optional):</label>
            <div class="tags__container">
                <button type="button" class="tag__btn" data-tag="Tafsir">Tafsir</button>
                <button type="button" class="tag__btn" data-tag="Sirah">Sirah</button>
                <button type="button" class="tag__btn" data-tag="Halal/Haram">Halal/Haram</button>
            </div>
        </div>

        <div>
            <label for="title">Title</label>
            <input type="text" id="title" name="title" placeholder="Enter blog title" required>
        </div>

        <div>
            <label for="content">Content:</label>
            <textarea id="content" name="content" placeholder="Write your blog content here..." required></textarea>
        </div>

        <div class="user__action">
            <a href="index.html"><button id="back-btn" onclick="window.history.back()">Cancel</button></a>
            <input id="submit" type="submit" value="Confirm">
        </div>
    </form>
    

</body>
</html>