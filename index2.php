<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stok - Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1e3a8a, #0d6efd, #f98f19);
            min-height: 100vh;
            font-family: 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 0 15px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        .login-logo {
            width: 300px;
            height: auto;
            display: block;
        }

        .login-title {
            color: white;
            font-size: 1.5rem;
            margin-bottom: 5px;
            text-align: center;
        }

        .login-subtitle {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            text-align: center;
            margin-bottom: 25px;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 15px;
        }

        .input-icon-custom {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
            z-index: 2;
        }

        .form-control-custom {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding-left: 45px !important;
            height: 45px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .form-control-custom:focus {
            background-color: rgba(255, 255, 255, 0.2);
            border-color: #f98f19;
            box-shadow: 0 0 0 0.25rem rgba(249, 143, 25, 0.25);
            color: white;
        }

        .form-control-custom::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.6);
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
        }

        .password-toggle:hover {
            color: white;
        }

        .btn-entrar {
            background-color: #f98f19;
            border: none;
            color: white;
            font-weight: 600;
            padding: 10px;
            border-radius: 8px;
            width: 100%;
            margin-top: 15px;
            transition: all 0.3s ease;
        }

        .btn-entrar:hover {
            background-color: #e08115;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(249, 143, 25, 0.3);
        }

        .login-footer {
            text-align: center;
            margin-top: 20px;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        .link-orange {
            color: #f98f19;
            text-decoration: none;
            font-weight: 500;
            margin-left: 5px;
        }

        .link-orange:hover {
            color: #ffca2c;
            text-decoration: underline;
        }

        @media (max-width: 576px) {
            .login-card {
                padding: 25px 20px;
            }
            
            .login-logo {
                width: 120px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card ">
            <div class="d-flex flex-column align-items-center text-center mb-4">
            <!-- Logo -->
            <img src="src/assets/img/stok azul e laranja.png" alt="Logo Stok" class="login-logo w-50">
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
                    <span>Não tem uma conta?</span>
                    <a href="#" class="link-orange">Cadastre-se</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Script para alternar a visibilidade da senha
        document.querySelector('.password-toggle').addEventListener('click', function() {
            const passwordInput = this.previousElementSibling;
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    </script>
</body>
</html>