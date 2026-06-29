<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Upload Video</title>
</head>
<body>

<div class="header">
    <div class="header-left">StreamHive</div>
    <div class="header-right">
        <a class="btn" href="home.php">Home</a>
    </div>
</div>

<div class="container">

<form action="upload_process.php" method="POST" enctype="multipart/form-data">

    <label class="form-label">Title</label>
    <input class="form-input" name="title" required>

    <label class="form-label">Description</label>
    <input class="form-input" name="description" required>

    <label class="form-label">Categories</label>

    <div class="category-box">

        <label>
            <input type="checkbox" name="category_id[]" value="1">
            Gaming
        </label>

        <label>
            <input type="checkbox" name="category_id[]" value="2">
            Cooking
        </label>

        <label>
            <input type="checkbox" name="category_id[]" value="3">
            Sport
        </label>

        <label>
            <input type="checkbox" name="category_id[]" value="4">
            Beauty
        </label>

        <label>
            <input type="checkbox" name="category_id[]" value="5">
            Science
        </label>

    </div>

    <label class="form-label">Video</label>
    <input class="form-input" type="file" name="video" accept="video/mp4" required>

    <label class="form-label">Thumbnail</label>
    <input class="form-input" type="file" name="thumbnail" accept="image/*" required>

    <button class="btn" type="submit">Upload</button>

</form>

</div>

</body>
</html>