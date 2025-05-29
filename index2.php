<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stok - Login</title>

    <!-- Links nativos -->
    <link href="src\assets\css\style2.css" rel="stylesheet">
    <script src="src\assets\js\script2.js"></script>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="bubble bubble-1"></div>
    <div class="bubble bubble-2"></div>
    <div class="bubble bubble-3"></div>
    
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="login-card p-4 p-md-5 w-100" style="max-width: 450px;">
            <div class="text-center mb-5">
                <h1 class="text-white mb-3">Bem-vindo de volta</h1>
                <p class="text-white-50">Entre na sua conta para continuar</p>
            </div>
            
            <form>
                <!-- Campo de Email -->
                <div class="mb-4">
                    <label for="email" class="form-label text-white"></label>
                    <div class="position-relative">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" class="form-control" id="email" placeholder="seu@email.com">
                    </div>
                </div>
                
                <!-- Campo de Senha -->
                <div class="mb-3">
                    <label for="password" class="form-label text-white"></label>
                    <div class="position-relative">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" class="form-control" id="password" placeholder="********">
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="divider mb-4"></div>
                
                <div class="text-center">
                    <span class="text-white-50">Não tem uma conta? </span>
                    <a href="#" class="link-orange fw-medium">Cadastre-se</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>