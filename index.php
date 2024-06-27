<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include('conexao.php');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLASMOTO</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            <h1>Lista de Peças</h1>

            <?php
            if (isset($_GET['status']) && $_GET['status'] == 'success') {
                echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso',
                        text: 'Peça editada com sucesso!'
                    });
                </script>";
            } else if (isset($_GET['status']) && $_GET['status'] == 'success-delete') {
                echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso',
                        text: 'Peça deletada com sucesso!'
                    });
                </script>";
            }
            ?>

            <form class="search-form" action="" method="GET">
                <input name="busca" type="text" placeholder="Pesquisar" required>
                <input type="submit" value="Buscar">
                <button class="refresh-button" type="button" onclick="window.location.href='index.php'">Refresh</button>
            </form>

            <table>
                <tr>
                    <th>CÓDIGO DA PEÇA</th>
                    <th>NOME DA COR</th>
                    <th>CÓDIGO DA TINTA</th>
                    <th>AÇÕES</th>
                </tr>
                <?php
                // Ajustar para exibir todos os itens caso a pesquisa não esteja definida
                $pesquisa = isset($_GET['busca']) ? $mysqli->real_escape_string($_GET['busca']) : '';
                $sql_code = $pesquisa ?
                    "SELECT * FROM tb_item WHERE item_code LIKE '%$pesquisa%' OR ink_name LIKE '%$pesquisa%' OR ink_code LIKE '%$pesquisa%'" :
                    "SELECT * FROM tb_item";
                $sql_query = $mysqli->query($sql_code) or die("ERRO AO CONSULTAR." . $mysqli->error);

                if ($sql_query->num_rows == 0) {
                ?>
                    <tr>
                        <td colspan="4">Nenhum resultado encontrado.</td>
                    </tr>
                    <?php
                } else {
                    while ($dados = $sql_query->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?php echo $dados['item_code']; ?></td>
                            <td><?php echo $dados['ink_name']; ?></td>
                            <td><?php echo $dados['ink_code']; ?></td>
                            <td>
                                <div class="btn-registro">
                                    <a class="btn-editar" href="editar.php?id=<?php echo $dados['item_code']; ?>">Editar</a>
                                    <a class="btn-deletar" href="deletar.php?id=<?php echo $dados['item_code']; ?>" onclick="return confirmDelete(this)">Deletar</a>
                                </div>
                            </td>
                        </tr>
                <?php
                    }
                }
                ?>
            </table>
        </div>
    </main>
    <script>
    function confirmDelete(link) {
        Swal.fire({
            title: 'Tem certeza?',
            text: "Você não poderá reverter isso!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, deletar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link.href;
            }
        });
        return false;
    }
    </script>
</body>

</html>
