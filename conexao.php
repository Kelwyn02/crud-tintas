<?php
$host = "localhost";
$db = "db_buscaTintas";
$user = "root";
$password = "";

$mysqli = new mysqli($host, $user, $password, $db);
if ($mysqli->connect_errno) {
    die("Falha na conexão com o banco de dados: " . $mysqli->connect_error);
}
