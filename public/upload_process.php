<?php

session_start();
require 'pdo.php';
require '../app/models/classes/Video.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$title = $_POST['title'];
$description = $_POST['description'];
$category_ids = $_POST['category_id'];

$video_name = time() . "_" . $_FILES['video']['name'];
$thumbnail_name = time() . "_" . $_FILES['thumbnail']['name'];

move_uploaded_file($_FILES['video']['tmp_name'], "uploads/videos/" . $video_name);
move_uploaded_file(
    $_FILES['thumbnail']['tmp_name'],
    "uploads/thumbnails/" . $thumbnail_name
);

$videoModel = new Video($pdo);

$videoModel->create(
    $user_id,
    $title,
    $description,
    $video_name,
    $thumbnail_name,
    $category_ids
);

header("Location: home.php");
exit;