<?php
require_once __DIR__ . '/../../config/Session.php';

$currentScript = $_SERVER['SCRIPT_NAME'];
$basePath = '';

if (strpos($currentScript, '/home.php') !== false) {
    $basePath = '../assets/';
} elseif (strpos($currentScript, '/produto/') !== false) {
    $basePath = '../../assets/';
} elseif (strpos($currentScript, '/filiais/') !== false) {
    $basePath = '../../assets/';
} elseif (strpos($currentScript, '/usuarios/') !== false) {
    $basePath = '../../assets/';
} else {
    $basePath = '../assets/';
}

// Obtém o usuário logado
$usuarioLogado = Session::getUser();

// Calcula os caminhos corretos para os links baseado na página atual
$homePath = '';
$produtosPath = '';
$relatoriosPath = '';
$usuariosPath = '';

// Se estamos na página home.php
if (strpos($currentScript, '/home.php') !== false) {
    $homePath = './home.php';
    $produtosPath = './produto/index.php';
    $relatoriosPath = './relatorios/index.php';
    $usuariosPath = './usuarios/index.php';
}
// Se estamos em qualquer página dentro da pasta produto/
elseif (strpos($currentScript, '/produto/') !== false) {
    $homePath = '../home.php';
    $produtosPath = './index.php';
    $relatoriosPath = '../relatorios/index.php';
    $usuariosPath = '../usuarios/index.php';
}
// Se estamos em qualquer página dentro da pasta filiais/
elseif (strpos($currentScript, '/filiais/') !== false) {
    $homePath = '../home.php';
    $produtosPath = '../produto/index.php';
    $relatoriosPath = '../relatorios/index.php';
    $usuariosPath = '../usuarios/index.php';
}
// Se estamos em qualquer página dentro da pasta usuarios/
elseif (strpos($currentScript, '/usuarios/') !== false) {
    $homePath = '../home.php';
    $produtosPath = '../produto/index.php';
    $relatoriosPath = '../relatorios/index.php';
    $usuariosPath = './index.php';
}
// Para outras páginas na raiz de views/
else {
    $homePath = './home.php';
    $produtosPath = './produto/index.php';
    $relatoriosPath = './relatorios/index.php';
    $usuariosPath = './usuarios/index.php';
}
?>

<nav class="navbar-expand-lg navbar bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo $homePath; ?>">
            <img src="<?php echo $basePath; ?>img/logo-stok-azul-laranja.png" alt="Logo Stok" class="navbar-logo"/>
        </a>
        
        <!-- Botão de alternância para abrir o menu offcanvas -->
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Menu desktop -->
        <!-- <div class="navbar-nav ms-auto">
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user me-1"></i><?= htmlspecialchars($usuarioLogado['nome']) ?>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="../../controllers/sair.php">
                        <i class="fas fa-sign-out-alt me-2"></i>Sair
                    </a></li>
                </ul>
            </div>
        </div> -->
        
        <!-- Menu offcanvas que aparece em telas menores -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <!-- Cabeçalho do menu offcanvas com título ou logotipo -->
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">
                    <img src="<?php echo $basePath; ?>img/logo-stok-azul-laranja.png" alt="Logo Stok" class="navbar-logo"/>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <!-- Corpo do menu offcanvas com links de navegação -->
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?php echo $homePath; ?>">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?php echo $produtosPath; ?>">Produtos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?php echo $usuariosPath; ?>">Usuários</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?php echo $relatoriosPath; ?>">Relatórios</a>
                    </li>
                    
                    <!-- Dropdown do usuário -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user me-1"></i><?= htmlspecialchars($usuarioLogado['nome']) ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../controllers/sair.php">
                                <i class="fas fa-sign-out-alt me-2"></i>Sair
                            </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</nav>