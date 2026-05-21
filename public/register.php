<?php
session_start();

if (isset($_SESSION['account_loggedin'])) {
    header('Location: home.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren</title>
    <link rel="stylesheet" href="style.css?v=2">
</head>
<body>

<div class="header">
    <a href="#" class="logo">
        <img src="../IMG/Streamhive.png" alt="Logo">
    </a>
    <a href="index.php">Loginpagina</a>
</div>

<div class="tekstmidden">
    <h1>Maak een account</h1>
</div>

<form action="register_process.php" method="POST" enctype="multipart/form-data" class="register form">

    <label class="form-label">Email</label>
    <div class="form-group">
        <input class="form-input" type="email" name="email" placeholder="Email" required>
    </div>

    <label class="form-label">Username</label>
    <div class="form-group">
        <input class="form-input" type="text" name="username" placeholder="Username" required>
    </div>

    <label class="form-label">Password</label>
    <div class="form-group mar-bot-5">
        <input class="form-input" type="password" name="password" placeholder="Password" required>
    </div>

    <label class="form-label">Profielfoto</label>
    <div class="form-group mar-bot-5">
        <input type="file" name="icon" accept="image/*">
    </div>

    <button class="btn" type="submit">Registreren</button>

    <p class="register-link">
        Heb je al een account?
        <a href="index.php" class="form-link">Login</a>
    </p>

</form>

</body>
</html>