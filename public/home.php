<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}

require 'pdo.php';

$stmt = $pdo->query("
SELECT videos.*, users.username, users.icon
FROM videos
JOIN users ON videos.user_id = users.ID
ORDER BY videos.id DESC
");

$videos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$icon = $_SESSION['account_icon'] ?? 'default.png';
?>

<!DOCTYPE html>
<html>
<head>
<title>Home</title>
<link rel="stylesheet" href="style.css?v=2">
</head>
<body>

<div class="header">

    <div class="header-left">
        StreamHive
    </div>

    <div class="header-right">

        <a class="btn" href="upload.php">Upload</a>

        <img src="uploads/<?= htmlspecialchars($icon) ?>" class="avatar-big">

        <a class="logout" href="logout.php">Logout</a>

    </div>

</div>

<div class="feed">

<?php foreach ($videos as $video): ?>

<div class="video-card">

<a href="watch.php?id=<?= $video['id'] ?>">
<img class="thumbnail" src="uploads/thumbnails/<?= htmlspecialchars($video['thumbnail']) ?>">
</a>

<div class="video-info">

<img class="avatar" src="uploads/<?= htmlspecialchars($video['icon'] ?? 'default.png') ?>">

<div class="meta">
<h3><?= htmlspecialchars($video['title']) ?></h3>
<p>
<?= htmlspecialchars($video['username']) ?> • <?= $video['views'] ?> views
</p>
</div>

</div>

</div>

<?php endforeach; ?>

</div>

</body>
</html>