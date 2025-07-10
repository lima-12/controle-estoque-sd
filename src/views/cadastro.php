<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stok - Cadastro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/cadastro.css">
</head>
<body>

    <div class="login-container">
        <div class="login-card ">
            <div class="d-flex flex-column align-items-center text-center mb-2">
            <h1 class="login-title-cadastro">Crie sua conta</h1>
            </div>

            <form>
                <div class="input-group-custom">
                    <i class="fa-solid fa-user input-icon-custom"></i>
                    <input class="form-control form-control-custom" placeholder="Nome" required>
                </div>

                <div class="input-group-custom">
                    <i class="fas fa-envelope input-icon-custom"></i>
                    <input type="email" class="form-control form-control-custom" placeholder="seu@email.com" required>
                </div>
                
                <div class="input-group-custom">
                    <i class="fas fa-lock input-icon-custom"></i>
                    <input type="password" class="form-control form-control-custom password-input" placeholder="********" required>
                    <button type="button" class="password-toggle">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>

                <div class="input-group-custom">
                    <i class="fas fa-lock input-icon-custom"></i>
                    <input type="password" class="form-control form-control-custom password-input" placeholder="********" required>
                    <button type="button" class="password-toggle">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>

                <button type="submit" class="btn btn-entrar">
                    Criar
                </button>

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