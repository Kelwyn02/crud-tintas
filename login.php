<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <main>
        <div class="container">
            <div class="logo">
                <img class="logo-plasmoto" src="img/logo.png" alt="Logo">
            </div>
            <h1>Login</h1>
            <form class="login-form" action="autenticar.php" method="POST">
                <label for="username">Usuário</label>
                <input placeholder="Login" type="text" id="username" name="username" required>
                <label for="password">Senha</label>
                <input placeholder="Senha" type="password" id="password" name="password" required>
                <input type="submit" value="Login">
            </form>
        </div>
    </main>
    <script>
        <?php
        if (isset($_GET['error'])) {
            echo "
            Swal.fire({
                icon: 'error',
                title: 'Erro de autenticação',
                text: 'Usuário ou senha inválidos.',
            });
            ";
        }
        ?>
    </script>
</body>

</html>
