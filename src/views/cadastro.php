<?php
$usuariosPath = 'usuarios.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $confirmarSenha = $_POST['confirmar_senha'] ?? '';

    if ($senha !== $confirmarSenha) {
        die('As senhas não coincidem.');
    }

    if (empty($nome) || empty($email) || empty($senha)) {
        die('Preencha todos os campos.');
    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // Lê os usuários existentes
    $usuarios = [];
    if (file_exists($usuariosPath)) {
        $json = file_get_contents($usuariosPath);
        $usuarios = json_decode($json, true) ?? [];
    }

    // Verifica se o e-mail já está cadastrado
    foreach ($usuarios as $usuario) {
        if (strtolower($usuario['email']) === strtolower($email)) {
            die('E-mail já cadastrado.');
        }
    }

    $novoUsuario = [
        "nome" => $nome,
        "email" => $email,
        "senha" => $senhaHash,
        "foto" => null,
        "data_criacao" => date('Y-m-d H:i:s')
    ];

    // Adiciona e salva
    $usuarios[] = $novoUsuario;
    file_put_contents($usuariosPath, json_encode($usuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    header('Location: index.php?cadastro=sucesso');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Stok - Cadastro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="../assets/css/cadastro.css" />
</head>
<body>

    <div class="login-container">
        <div class="login-card">
            <div class="d-flex flex-column align-items-center text-center mb-2">
                <h1 class="login-title-cadastro">Crie sua conta</h1>
            </div>

            <form action="cadastro.php" method="POST">
                <div class="input-group-custom">
                    <i class="fa-solid fa-user input-icon-custom"></i>
                    <input name="nome" class="form-control form-control-custom" placeholder="Nome" required />
                </div>

                <div class="input-group-custom">
                    <i class="fas fa-envelope input-icon-custom"></i>
                    <input
                        name="email"
                        type="email"
                        class="form-control form-control-custom"
                        placeholder="seu@email.com"
                        required
                    />
                </div>
                
                <div class="input-group-custom">
                    <i class="fas fa-lock input-icon-custom"></i>
                    <input
                        name="senha"
                        type="password"
                        class="form-control form-control-custom password-input"
                        placeholder="Senha"
                        required
                    />
                    <button type="button" class="password-toggle"><i class="fas fa-eye"></i></button>
                </div>

                <div class="input-group-custom">
                    <i class="fas fa-lock input-icon-custom"></i>
                    <input
                        name="confirmar_senha"
                        type="password"
                        class="form-control form-control-custom password-input"
                        placeholder="Confirmar senha"
                        required
                    />
                    <button type="button" class="password-toggle"><i class="fas fa-eye"></i></button>
                </div>

                <button type="submit" class="btn btn-entrar">Criar</button>

                <div class="login-footer">
                    <span class="texto-abaixo">Já possui uma conta?</span>
                    <a href="index.php" class="link-orange">Entre agora mesmo</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/cadastro.js"></script>
</body>
</html>
