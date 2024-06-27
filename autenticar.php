<?php
session_start();
include('conexao.php');

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $mysqli->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $sql_code = "SELECT * FROM tb_usuarios WHERE username = '$username'";
    $sql_query = $mysqli->query($sql_code) or die($mysqli->error);

    if ($sql_query->num_rows > 0) {
        $usuario = $sql_query->fetch_assoc();
        if (password_verify($password, $usuario['password'])) {
            $_SESSION['user_id'] = $usuario['id'];
            header("Location: index.php");
            exit();
        }
    }
    header("Location: login.php?error=1");
    exit();
} else {
    header("Location: login.php");
    exit();
}
