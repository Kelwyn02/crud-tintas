<?php
include('conexao.php');

$username = 'Lumix';
$password = 'Lumix@2024';

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO tb_usuarios (username, password) VALUES ('$username', '$hashed_password')";
if ($mysqli->query($sql) === TRUE) {
    echo "Novo usuário criado com sucesso.";
} else {
    echo "Erro: " . $sql . "<br>" . $mysqli->error;
}
