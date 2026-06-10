<?php
session_start();
require 'pdo.php';

if (!isset($_SESSION['loggedin'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$video_id = $_POST['video_id'];
$content = trim($_POST['content']);

if ($content == "") {
    header("Location: watch.php?id=" . $video_id);
    exit;
}

$stmt = $pdo->prepare("
INSERT INTO comments (user_id, video_id, content, created_at)
VALUES (?, ?, ?, ?)
");

$stmt->execute([
    $user_id,
    $video_id,
    $content,
    date('Y-m-d')
]);

header("Location: watch.php?id=" . $video_id);
exit;
?>