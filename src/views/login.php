

<?php
session_start();

$erroLogin = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    $usuariosPath = 'usuarios.json'; // ajuste o caminho se precisar
    $usuarios = [];

    if (file_exists($usuariosPath)) {
        $jsonUsuarios = file_get_contents($usuariosPath);
        $usuarios = json_decode($jsonUsuarios, true) ?? [];
    }

    $usuarioEncontrado = null;
    foreach ($usuarios as $usuario) {
        if (strtolower($usuario['email']) === strtolower($email)) {
            // verifica senha com hash
            if (password_verify($senha, $usuario['senha'])) {
                $usuarioEncontrado = $usuario;
                break;
            }
        }
    }

    if ($usuarioEncontrado) {
        // Armazena usuário na sessão
        $_SESSION['usuario'] = $usuarioEncontrado;
        header('Location: src/telaPrincipal.php');
        exit;
    } else {
        $erroLogin = 'Email ou senha incorretos.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Stok - Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="../assets/css/login.css" />
</head>
<body>

<div class="login-container">
    <div class="login-card ">
        <div class="d-flex flex-column align-items-center text-center mb-2">
            <img src="../assets/img/logo-stok-azul-laranja.png" alt="Logo Stok" class="login-logo w-50" />
            <h1 class="login-title">Bem-vindo de volta</h1>
            <p class="login-subtitle">Entre na sua conta para continuar</p>
        </div>

        <?php if ($erroLogin): ?>
            <div class="alert alert-danger text-center">
                <?= htmlspecialchars($erroLogin) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="input-group-custom mb-3">
                <i class="fas fa-envelope input-icon-custom"></i>
                <input
                    type="email"
                    name="email"
                    class="form-control form-control-custom"
                    placeholder="seu@email.com"
                    required
                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                />
            </div>

            <div class="input-group-custom mb-3">
                <i class="fas fa-lock input-icon-custom"></i>
                <input
                    type="password"
                    name="senha"
                    class="form-control form-control-custom password-input"
                    placeholder="********"
                    required
                />
                <button type="button" class="password-toggle">
                    <i class="fas fa-eye"></i>
                </button>
            </div>

            <button type="submit" class="btn btn-entrar w-100">
                Entrar
            </button>

            <div class="login-footer mt-3 text-center">
                <span class="texto-abaixo">Não tem uma conta?</span>
                <a href="cadastro.php" class="link-orange">Cadastre-se</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/script2.js"></script>

</body>
</html>
