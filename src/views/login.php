<?php
require_once __DIR__ . '/../config/Session.php';
require_once __DIR__ . '/../Model/Usuario.php';

use App\model\Usuario;

// Se já estiver logado, redireciona para home
if (Session::isLoggedIn()) {
    header('Location: home.php');
    exit;
}

$erroLogin = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (!empty($email) && !empty($senha)) {
        try {
            $usuarioModel = new Usuario();
            $usuarios = $usuarioModel->find($email);
            
            if ($usuarios && count($usuarios) > 0) {
                $usuario = $usuarios[0];
                
                // Use password_verify for hashed passwords
                if ($senha == $usuario['senha']) {
                    // Armazena usuário na sessão
                    Session::setUser($usuario);
                    header('Location: home.php');
                    exit;
                } else {
                    $erroLogin = 'Email ou senha incorretos.';
                }
            } else {
                $erroLogin = 'Email ou senha incorretos.';
            }
        } catch (Exception $e) {
            $erroLogin = 'Erro ao conectar com o banco de dados.';
        }
    } else {
        $erroLogin = 'Por favor, preencha todos os campos.';
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
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/login.js"></script>

</body>
</html>
