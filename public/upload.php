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
<title>Upload</title>
<link rel="stylesheet" href="style.css?v=2">
</head>
<body>

<div class="header">
    <div class="header-left">StreamHive</div>
    <div class="header-right">
        <a class="btn" href="home.php">Home</a>
        <a class="logout" href="logout.php">Logout</a>
    </div>
</div>

<div class="form">
    <h1>Upload video</h1>

    <form action="upload_process.php" method="POST" enctype="multipart/form-data">

        <label class="form-label">Title</label>
        <input class="form-input" name="title" required>

        <label class="form-label">Description</label>
        <input class="form-input" name="description" required>

        <label class="form-label">Category</label>
        <select class="form-input" name="category_id">
            <option value="1">Gaming</option>
            <option value="2">Cooking</option>
            <option value="3">Sport</option>
            <option value="4">Beauty</option>
            <option value="5">Science</option>
        </select>

        <label class="form-label">Video</label>
        <input class="form-input" type="file" name="video" accept="video/mp4" required>

        <label class="form-label">Thumbnail</label>
        <input class="form-input" type="file" name="thumbnail" accept="image/*" required>

        <button class="btn" type="submit">Upload</button>

    </form>
</div>

</body>
</html>