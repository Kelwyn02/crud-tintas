<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include('conexao.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Capturar o estado antes da exclusão
    $sql_code = "SELECT * FROM tb_item WHERE item_code = '$id'";
    $sql_query = $mysqli->query($sql_code) or die($mysqli->error);

    if ($sql_query->num_rows > 0) {
        $dados = $sql_query->fetch_assoc();
        $before_edit = json_encode($dados); // Estado antes da exclusão
    } else {
        $before_edit = json_encode(["ink_name" => "-", "ink_code" => "-"]); // Caso não encontre o item
    }

    $sql_code = "DELETE FROM tb_item WHERE item_code = '$id'";
    $sql_query = $mysqli->query($sql_code) or die($mysqli->error);

    if ($sql_query) {
        // Registrar a ação no log
        $user_id = $_SESSION['user_id'];
        $action = "deletou";
        $after_edit = json_encode(["ink_name" => "-", "ink_code" => "-"]); // Estado após a exclusão

        $log_sql = "INSERT INTO tb_log (user_id, action, item_id, before_edit, after_edit) VALUES ('$user_id', '$action', '$id', '$before_edit', '$after_edit')";
        $mysqli->query($log_sql) or die($mysqli->error);

        header("Location: index.php?status=success-delete");
        exit();
    } else {
        echo "Erro ao deletar peça.";
    }
}
?>
