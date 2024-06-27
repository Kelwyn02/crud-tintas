<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include('conexao.php');

$sql_code = "SELECT l.*, u.username, DATE_FORMAT(l.timestamp, '%d/%m/%Y | %H:%i:%s') as formatted_timestamp 
             FROM tb_log l 
             JOIN tb_usuarios u ON l.user_id = u.id 
             ORDER BY l.timestamp DESC";
$sql_query = $mysqli->query($sql_code) or die($mysqli->error);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Logs</title>
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
            <h1>Logs de Alterações</h1>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuário</th>
                        <th>Ação</th>
                        <th>ID do Item</th>
                        <th>Antes da Edição</th>
                        <th>Depois da Edição</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($log = $sql_query->fetch_assoc()) : 
                        $before_edit = json_decode($log['before_edit'], true);
                        $after_edit = json_decode($log['after_edit'], true);
                    ?>
                        <tr>
                            <td><?php echo $log['id']; ?></td>
                            <td><?php echo $log['username']; ?></td>
                            <td><?php echo $log['action']; ?></td>
                            <td><?php echo $log['item_id']; ?></td>
                            <td>
                                <?php if ($before_edit): ?>
                                    Nome da cor: <?php echo htmlspecialchars($before_edit['ink_name']); ?><br>
                                    Código da tinta: <?php echo htmlspecialchars($before_edit['ink_code']); ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($after_edit): ?>
                                    Nome da cor: <?php echo htmlspecialchars($after_edit['ink_name']); ?><br>
                                    Código da tinta: <?php echo htmlspecialchars($after_edit['ink_code']); ?>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $log['formatted_timestamp']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>
