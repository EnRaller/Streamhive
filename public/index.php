<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Streamhive</title>
    <link rel="stylesheet" href="style.css?1">
</head>
<body>

    <!-- Code voor de header -->
    <div class="header">
        <a href="#" class="logo">
            <img src="../IMG/Streamhive.png" alt="Streamhive Logo">
        </a>
        <div class="header-right">
            <a href="login.php">Loginpagina</a>
        </div>
    </div>

    <!-- Code voor de tekst in t midden-->
    <div class="tekstmidden">
        <h1>Welkom bij Streamhive!</h1>
    </div>

<?php
require 'pdo.php';

$stmt = $pdo->query("SELECT title FROM videos");

while ($row = $stmt->fetch()) {
    echo $row['title'] . "<br>";
}
?>

</select>


</form>
</div>

</body>
</html>