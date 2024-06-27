<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include('conexao.php');

$id = isset($_GET['id']) ? $mysqli->real_escape_string($_GET['id']) : null;

if (!$id) {
    die("ID não fornecido.");
}

$sql_code = "SELECT * FROM tb_item WHERE item_code = '$id'";
$sql_query = $mysqli->query($sql_code) or die($mysqli->error);

if ($sql_query->num_rows > 0) {
    $dados = $sql_query->fetch_assoc();
    $before_edit = json_encode($dados); // Armazena o estado atual do item
} else {
    die("Peça não encontrada.");
}

if (isset($_POST['editar'])) {
    $ink_name = $mysqli->real_escape_string($_POST['ink_name']);
    $ink_code = $mysqli->real_escape_string($_POST['ink_code']);

    // Captura o estado depois da edição
    $after_edit = json_encode([
        'ink_name' => $ink_name,
        'ink_code' => $ink_code
    ]);

    $sql_code = "UPDATE tb_item SET ink_name = '$ink_name', ink_code = '$ink_code' WHERE item_code = '$id'";
    $sql_query = $mysqli->query($sql_code) or die($mysqli->error);

    if ($sql_query) {
        // Registrar a ação no log
        $user_id = $_SESSION['user_id'];
        $action = "editou";
        $log_sql = "INSERT INTO tb_log (user_id, action, item_id, before_edit, after_edit) VALUES ('$user_id', '$action', '$id', '$before_edit', '$after_edit')";
        $mysqli->query($log_sql) or die($mysqli->error);

        header("Location: index.php?status=success");
        exit();
    } else {
        echo "Erro ao editar peça.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Peça</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav class="nav_container">
        <div class="logo">
            <img class="logo-plasmoto" src="img/logo.png" />
        </div>
        <div class="menu">
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="ver_logs.php">Logs</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>
    <main>
        <div class="container">
            <h1>Editar Peça</h1>
            <form class="edit-form" action="" method="POST">
                <p class="piece-code"><?php echo $dados['item_code']; ?></p><br>
                <label for="ink_name">Nome da cor:</label>
                <input type="text" id="ink_name" name="ink_name" value="<?php echo $dados['ink_name']; ?>" required>
                <br>
                <label for="ink_code">Código da tinta:</label>
                <input type="text" id="ink_code" name="ink_code" value="<?php echo $dados['ink_code']; ?>" required>
                <br>
                <div class="form-buttons">
                    <input type="submit" name="editar" value="Salvar">
                    <a href="index.php" class="btn-voltar">Voltar</a>
                </div>
            </form>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
</body>

</html>
