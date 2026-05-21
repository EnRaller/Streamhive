<?php
require 'pdo.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("
SELECT videos.*, users.username, users.icon
FROM videos
JOIN users ON videos.user_id = users.ID
WHERE videos.id = ?
");

$stmt->execute([$id]);
$video = $stmt->fetch();
?>

<h1><?= htmlspecialchars($video['title']) ?></h1>

<video width="800" controls autoplay>
    <source src="uploads/videos/<?= htmlspecialchars($video['filename']) ?>">
</video>

<p><?= htmlspecialchars($video['description']) ?></p>

<p>
    Video-maker: <?= htmlspecialchars($video['username']) ?> |
    Views: <?= $video['views'] ?> views
</p>