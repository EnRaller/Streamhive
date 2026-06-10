<?php
session_start();
require 'pdo.php';

$email = trim($_POST['email']);
$username = trim($_POST['username']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$role = 'user';
$created_at = date('Y-m-d');

$icon = 'default.png';

if (!empty($_FILES['icon']['name'])) {

    $targetDir = "uploads/";
    $fileName = time() . "_" . basename($_FILES["icon"]["name"]);
    $targetFile = $targetDir . $fileName;

    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($imageFileType, $allowed)) {

        if ($_FILES['icon']['size'] <= 2000000) {

            if (move_uploaded_file($_FILES["icon"]["tmp_name"], $targetFile)) {
                $icon = $fileName;
            }

        }
    }
}

$stmt = $pdo->prepare("
INSERT INTO users (email, username, password, role, created_at, icon)
VALUES (?, ?, ?, ?, ?, ?)
");

$stmt->execute([
    $email,
    $username,
    $password,
    $role,
    $created_at,
    $icon
]);

header("Location: index.php");
exit;
?>