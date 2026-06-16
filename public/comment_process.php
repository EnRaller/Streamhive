<?php
session_start();
require 'pdo.php';
require '../app/models/classes/Comment.php';

if (!isset($_SESSION['loggedin'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$video_id = $_POST['video_id'];
$content = trim($_POST['content']);

if ($content === '') {
    header("Location: watch.php?id=" . $video_id);
    exit;
}

$commentModel = new Comment($pdo);
$commentModel->create($user_id, $video_id, $content);

header("Location: watch.php?id=" . $video_id);
exit;