<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$username = htmlspecialchars($_SESSION['user']);
?>

<h2>Bienvenido, <?= $username ?>!</h2>
<form method="POST" action="logout.php">
    <button type="submit">Cerrar sesión</button>
</form>
