<?php
session_start();
require 'pdo.php';

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$_POST['username']]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($_POST['password'], $user['password'])) {

    session_regenerate_id(true);

    $_SESSION['loggedin'] = true;
    $_SESSION['user_id'] = $user['ID'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['icon'] = $user['icon'] ?: 'default.png';

    header("Location: home.php");
    exit;
}

header("Location: index.php");
exit;