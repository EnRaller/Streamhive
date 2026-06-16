<?php
session_start();
require 'pdo.php';

require '../app/models/classes/Video.php';
require '../app/models/classes/Comment.php';
require '../app/models/classes/Like.php';

if (!isset($_SESSION['loggedin'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$id = $_GET['id'];

$videoModel = new Video($pdo);
$commentModel = new Comment($pdo);
$likeModel = new Like($pdo);

$videoModel->addView($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['like_video'])) {
        $likeModel->toggleVideoLike($user_id, $id);
        header("Location: watch.php?id=" . $id);
        exit;
    }

    if (isset($_POST['like_comment'])) {
        $likeModel->toggleCommentLike($user_id, $_POST['comment_id']);
        header("Location: watch.php?id=" . $id);
        exit;
    }

    if (isset($_POST['comment_submit'])) {
        $content = trim($_POST['content']);

        if ($content !== '') {
            $commentModel->create($user_id, $id, $content);
        }

        header("Location: watch.php?id=" . $id);
        exit;
    }
}

$video = $videoModel->getById($id);
$comments = $commentModel->getByVideo($id);
$videoLikes = $likeModel->countVideoLikes($id);
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
    <button class="btn" name="like_video">Like <?= $videoLikes ?></button>
</form>

<p class="description">
    <?= htmlspecialchars($video['description']) ?>
</p>

<form method="POST">
    <textarea name="content" required></textarea>
    <button class="btn" name="comment_submit">Comment</button>
</form>

<div class="comments">

<?php foreach ($comments as $comment): ?>

<?php $likes = $likeModel->countCommentLikes($comment['comment_id']); ?>

<div class="comment">

    <img class="avatar" src="uploads/<?= htmlspecialchars($comment['icon'] ?? 'default.png') ?>">

    <div>
        <b><?= htmlspecialchars($comment['username']) ?></b>
        <p><?= htmlspecialchars($comment['content']) ?></p>

        <form method="POST">
            <input type="hidden" name="comment_id" value="<?= $comment['comment_id'] ?>">
            <button class="btn" name="like_comment">Like <?= $likes ?></button>
        </form>

    </div>

</div>

<?php endforeach; ?>

</div>

</div>

</body>
</html>