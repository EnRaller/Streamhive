<?php
session_start();
require 'pdo.php';
require '../app/models/classes/Video.php';
require '../app/models/classes/User.php';

if (!isset($_SESSION['loggedin'])) {
    header("Location: index.php");
    exit;
}

$videoModel = new Video($pdo);
$userModel = new User($pdo);

$search = $_GET['search'] ?? '';

$videos = $search !== ''
    ? $pdo->prepare("
        SELECT videos.*, users.username, users.icon
        FROM videos
        JOIN users ON videos.user_id = users.ID
        WHERE videos.title LIKE ?
        ORDER BY videos.id DESC
    ")
    : null;

if ($videos) {
    $videos->execute(["%$search%"]);
    $videos = $videos->fetchAll(PDO::FETCH_ASSOC);
} else {
    $videos = $videoModel->getAll();
}

$user = $userModel->getById($_SESSION['user_id']);
$icon = $user['icon'] ?? 'default.png';
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css?v=3">
<title>Home</title>
</head>
<body>

<div class="header">
    <div class="header-left">StreamHive</div>

    <div class="header-right">
        <form method="GET" style="display:flex;gap:10px;">
            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>">
            <button class="btn">Search</button>
        </form>

        <a class="btn" href="upload.php">Upload</a>

        <img class="avatar-big" src="uploads/<?= htmlspecialchars($icon) ?>">

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
            <p><?= htmlspecialchars($video['username']) ?> • <?= $video['views'] ?> views</p>
        </div>

    </div>

</div>

<?php endforeach; ?>

</div>

</body>
</html>