<?php
session_start();
require 'pdo.php';

if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header("Location: index.php");
    exit;
}

$title = $_POST['title'];
$description = $_POST['description'];
$category_id = $_POST['category_id'];
$user_id = $_SESSION['user_id'];

$filename = "none";

if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] === 0) {

    $ext = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));

    if ($ext !== "mp4") {
        die("Alleen MP4 toegestaan.");
    }

    $filename = time() . "_" . preg_replace("/[^a-zA-Z0-9._-]/", "_", $_FILES["fileToUpload"]["name"]);
    $target_file = "uploads/videos/" . $filename;

    if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        die("Upload mislukt.");
    }
}

$thumb = "default.png";

if (isset($_FILES["thumbnail"]) && $_FILES["thumbnail"]["error"] === 0) {

    $ext = strtolower(pathinfo($_FILES["thumbnail"]["name"], PATHINFO_EXTENSION));

    if (in_array($ext, ["jpg", "jpeg", "png"])) {

        $thumb = time() . "_thumb_" . preg_replace("/[^a-zA-Z0-9._-]/", "_", $_FILES["thumbnail"]["name"]);
        $target = "uploads/thumbnails/" . $thumb;

        move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $target);
    }
}

$stmt = $pdo->prepare("
INSERT INTO videos (user_id, title, description, filename, thumbnail, views, created_at, category_id)
VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");

$ok = $stmt->execute([
    $user_id,
    $title,
    $description,
    $filename,
    $thumb,
    0,
    date('Y-m-d'),
    $category_id
]);

if (!$ok) {
    die("DB insert mislukt");
}

header("Location: home.php");
exit;