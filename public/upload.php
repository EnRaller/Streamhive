<!DOCTYPE html>
<html>
<head>
    <title>Video Uploaden</title>
    <link rel="stylesheet" href="style.css?v=2">
</head>
<body>

<div class="header">
    <a href="home.php">Home</a>
    <a href="logout.php">Logout</a>
</div>

<div class="tekstmidden">
    <h1>Upload een video</h1>
</div>

<form action="upload_process.php" method="POST" enctype="multipart/form-data" class="register form">

    <label class="form-label">Titel</label>
    <div class="form-group">
        <input class="form-input" type="text" name="title" required>
    </div>

    <label class="form-label">Beschrijving</label>
    <div class="form-group">
        <input class="form-input" type="text" name="description" required>
    </div>

    <label class="form-label">Categorie</label>
    <div class="form-group">
        <select class="form-input" name="category_id">
            <option value="1">Gaming</option>
            <option value="2">Koken</option>
        </select>
    </div>

    <label class="form-label">Video (.mp4)</label>
    <div class="form-group mar-bot-5">
        <input type="file" name="fileToUpload" accept="video/mp4" required>
    </div>

    <label class="form-label">Thumbnail</label>
<div class="form-group mar-bot-5">
    <input type="file" name="thumbnail" accept="image/*" required>
</div>

    <button class="btn" type="submit">Upload Video</button>

</form>

</body>
</html>