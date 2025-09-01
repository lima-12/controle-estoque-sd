<?php
require_once __DIR__ . '/../../config/Session.php';
require_once __DIR__ . '/../../config/Config.php';

$usuarioLogado = Session::getUser();
?>

<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="navbar-brand" href="<?= url('home.php') ?>">
            <img src="<?= asset('img/logo-stok-azul-laranja.png') ?>" alt="Logo Stok" class="navbar-logo"/>
        </a>
        
        <!-- Botão toggle mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Offcanvas -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">
                    <img src="<?= asset('img/logo-stok-azul-laranja.png') ?>" alt="Logo Stok" class="navbar-logo"/>
                </h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
            </div>
            
            <div class="offcanvas-body">
                <ul class="navbar-nav ms-auto pe-3">
                    <li class="nav-item"><a class="nav-link" href="<?= url('home.php') ?>">Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= url('produto/index.php') ?>">Produtos</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= url('entrada-produto/index.php') ?>"><i class="fas fa-arrow-down me-1"></i>Entrada de Produtos</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= url('usuarios/index.php') ?>">Usuários</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= url('filiais/index.php') ?>">Filiais</a></li>
                    
                    <!-- Dropdown usuário com botão -->
                    <li class="nav-item dropdown">
                        <button class="btn dropdown-toggle d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user me-1"></i><?= htmlspecialchars($usuarioLogado['nome']) ?>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item" href="<?= BASE_URL ?>controllers/sair.php">
                                    <i class="fas fa-sign-out-alt me-2"></i>Sair
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
