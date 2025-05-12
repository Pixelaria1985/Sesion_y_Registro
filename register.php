<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: welcome.php");
    exit();
}

require 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $message = "Usuario ya existente";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $insert = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $insert->bind_param("ss", $username, $hashedPassword);
        if ($insert->execute()) {
            header("Location: login.php");
            exit();
        } else {
            $message = "Error al registrar";
        }
    }
}
?>

<form method="POST">
    <h2>Registro</h2>
    Usuario: <input type="text" name="username" required><br>
    Contraseña: <input type="password" name="password" required><br>
    <button type="submit">Registrar</button>
</form>
<p style="color:red;"><?= $message ?></p>
<a href="login.php">Ir al Login</a>
