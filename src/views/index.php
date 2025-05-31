<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stok - Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style2.css">
</head>
<body>

    <div class="login-container">
        <div class="login-card ">
            <div class="d-flex flex-column align-items-center text-center mb-2">
            <!-- Logo -->
            <img src="../assets/img/logo-stok-azul-laranja.png" alt="Logo Stok" class="login-logo w-50">
            <!-- Títulos -->
            <h1 class="login-title">Bem-vindo de volta</h1>
            <p class="login-subtitle">Entre na sua conta para continuar</p>
            </div>

            <!-- Formulário -->
            <form>
                <!-- Campo de Email -->
                <div class="input-group-custom">
                    <i class="fas fa-envelope input-icon-custom"></i>
                    <input type="email" class="form-control form-control-custom" placeholder="seu@email.com" required>
                </div>
                
                <!-- Campo de Senha -->
                <div class="input-group-custom">
                    <i class="fas fa-lock input-icon-custom"></i>
                    <input type="password" class="form-control form-control-custom" placeholder="********" required>
                    <button type="button" class="password-toggle">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>

                <!-- Botão de Entrar -->
                <button type="submit" class="btn btn-entrar">
                    Entrar
                </button>

                <!-- Rodapé -->
                <div class="login-footer">
                    <span class="texto-abaixo">Não tem uma conta?</span>
                    <a href="cadastro.php" class="link-orange">Cadastre-se</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="src/assets/js/script2.js"></script>
</body>
</html>