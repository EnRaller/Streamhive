<?php
session_start();

require 'pdo.php';
require '../app/models/classes/Video.php';

if (!isset($_SESSION['loggedin'])) {
    header("Location: index.php");
    exit;
}

$videoModel = new Video($pdo);

$user_id = $_SESSION['user_id'];
$title = $_POST['title'];
$description = $_POST['description'];
$category_id = $_POST['category_id'];

$videoFile = "none";
$thumbFile = "default.png";

if (isset($_FILES['video']) && $_FILES['video']['error'] === 0) {

    $ext = strtolower(pathinfo($_FILES['video']['name'], PATHINFO_EXTENSION));

    if ($ext !== "mp4") {
        die("Only mp4 allowed");
    }

    $videoFile = time() . "_" . preg_replace("/[^a-zA-Z0-9._-]/", "_", $_FILES['video']['name']);
    move_uploaded_file($_FILES['video']['tmp_name'], "uploads/videos/" . $videoFile);
}

if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === 0) {

    $ext = strtolower(pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION));

    if (in_array($ext, ["jpg", "jpeg", "png"])) {

        $thumbFile = time() . "_thumb_" . preg_replace("/[^a-zA-Z0-9._-]/", "_", $_FILES['thumbnail']['name']);
        move_uploaded_file($_FILES['thumbnail']['tmp_name'], "uploads/thumbnails/" . $thumbFile);
    }
}

$videoModel->create($user_id, $title, $description, $videoFile, $thumbFile, $category_id);

header("Location: home.php");
exit;