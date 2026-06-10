<?php
session_start();
require 'pdo.php';

if (!isset($_SESSION['loggedin'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$id = $_GET['id'];
// view counter
$viewCheck = $pdo->prepare("SELECT id FROM videos WHERE id=?");
$viewCheck->execute([$id]);
$videoExists = $viewCheck->fetch();
// update de video met een view
if ($videoExists) {
    $pdo->prepare("UPDATE videos SET views = views + 1 WHERE id=?")->execute([$id]);
}

if (isset($_POST['like_video'])) {
// likes voor de video
    $check = $pdo->prepare("SELECT id FROM likes WHERE user_id=? AND video_id=? AND comment_id IS NULL");
    $check->execute([$user_id, $id]);
    $existing = $check->fetch();

    if ($existing) {
        $pdo->prepare("DELETE FROM likes WHERE id=?")->execute([$existing['id']]);
    } else {
        $pdo->prepare("INSERT INTO likes (user_id, video_id, comment_id) VALUES (?, ?, NULL)")->execute([$user_id, $id]);
    }
}

if (isset($_POST['like_comment'])) {
// likes voor comments
    $comment_id = $_POST['comment_id'];

    $check = $pdo->prepare("SELECT id FROM likes WHERE user_id=? AND comment_id=?");
    $check->execute([$user_id, $comment_id]);
    $existing = $check->fetch();

    if ($existing) {
        $pdo->prepare("DELETE FROM likes WHERE id=?")->execute([$existing['id']]);
    } else {
        $pdo->prepare("INSERT INTO likes (user_id, video_id, comment_id) VALUES (?, NULL, ?)")->execute([$user_id, $comment_id]);
    }
}
// laad de info van de maker van de video
$stmt = $pdo->prepare("
SELECT videos.*, users.username, users.icon
FROM videos
JOIN users ON videos.user_id = users.ID
WHERE videos.id = ?
");
$stmt->execute([$id]);
$video = $stmt->fetch(PDO::FETCH_ASSOC);
// laad de comments
$commentStmt = $pdo->prepare("
SELECT comments.*, users.username, users.icon
FROM comments
JOIN users ON comments.user_id = users.ID
WHERE comments.video_id = ?
ORDER BY comments.id DESC
");
$commentStmt->execute([$id]);
$comments = $commentStmt->fetchAll(PDO::FETCH_ASSOC);
// laad de likes
$videoLikes = $pdo->prepare("SELECT COUNT(*) FROM likes WHERE video_id=? AND comment_id IS NULL");
$videoLikes->execute([$id]);
$video_like_count = $videoLikes->fetchColumn();
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
<title><?= htmlspecialchars($video['title']) ?></title>
</head>
<body>

<div class="header">
    <div class="header-left">StreamHive</div>
    <div class="header-right">
        <a class="btn" href="home.php">Home</a>
    </div>
</div>

<div class="watch-container">

<video width="900" controls autoplay>
    <source src="uploads/videos/<?= htmlspecialchars($video['filename']) ?>">
</video>

<h1><?= htmlspecialchars($video['title']) ?></h1>

<div class="watch-meta">
    <img class="avatar-big" src="uploads/<?= htmlspecialchars($video['icon'] ?? 'default.png') ?>">
    <div>
        <h3><?= htmlspecialchars($video['username']) ?></h3>
        <p><?= $video['views'] ?> views</p>
    </div>
</div>

<form method="POST">
    <button class="btn" name="like_video" type="submit">Like <?= $video_like_count ?></button>
</form>

<p class="description">
    <?= htmlspecialchars($video['description']) ?>
</p>

<form class="comment-form" action="comment_process.php" method="POST">
    <input type="hidden" name="video_id" value="<?= $video['id'] ?>">
    <textarea name="content" placeholder="Write a comment..." required></textarea>
    <button class="btn" type="submit">Comment</button>
</form>

<div class="comments">

<?php foreach ($comments as $comment): ?>

<?php
$cLike = $pdo->prepare("SELECT COUNT(*) FROM likes WHERE comment_id=?");
$cLike->execute([$comment['id']]);
$comment_likes = $cLike->fetchColumn();
?>

<div class="comment">

    <img class="avatar" src="uploads/<?= htmlspecialchars($comment['icon'] ?? 'default.png') ?>">

    <div>
        <b><?= htmlspecialchars($comment['username']) ?></b>
        <p><?= htmlspecialchars($comment['content']) ?></p>

        <form method="POST">
            <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
            <button class="btn" name="like_comment" type="submit">Like <?= $comment_likes ?></button>
        </form>
    </div>
</div>
<?php endforeach; ?>
</div>
</div>
</body>
</html>