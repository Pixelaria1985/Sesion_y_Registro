<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: welcome.php");
    exit();
}

require 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id, $hashedPassword);
    
    if ($stmt->fetch() && password_verify($password, $hashedPassword)) {
        session_regenerate_id(true); // Previene fijación de sesión
        $_SESSION['user'] = $username;
        header("Location: welcome.php");
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>

<form method="POST">
    <h2>Login</h2>
    Usuario: <input type="text" name="username" required><br>
    Contraseña: <input type="password" name="password" required><br>
    <button type="submit">Entrar</button>
</form>
<p style="color:red;"><?= $error ?></p>
<a href="register.php">Registrarse</a>
