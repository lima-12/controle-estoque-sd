<nav class="navbar-expand-lg navbar bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="../assets/img/logo-stok-azul-laranja.png" alt="Logo Stok" class="navbar-logo me-2" />
        </a>
        
        <!-- Botão de alternância para abrir o menu offcanvas -->
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Menu offcanvas que aparece em telas menores -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <!-- Cabeçalho do menu offcanvas com título ou logotipo -->
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">
                    <img src="../assets/img/logo-stok-azul-laranja.png" alt="Logo Stok" class="navbar-logo me-2" />
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <!-- Corpo do menu offcanvas com links de navegação -->
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/produto/index.php">Produtos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/show.php">Filiais</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#contato">Relatórios</a>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</nav>