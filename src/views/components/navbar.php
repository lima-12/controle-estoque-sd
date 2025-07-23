<!-- Barra de navegação com expansão em telas grandes e plano de fundo terciário -->
<nav class="navbar-expand-lg navbar bg-primary fixed-top">
    <!-- Contêiner fluido para envolver os elementos -->
    <div class="container-fluid">

        <!-- Link para o logotipo da página -->
        <a class="navbar-brand" href="#">
            <!-- <img src="./assets/logo.png" alt="Logo da cafeteria Serenatto"> -->
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
                    <img src="./assets/logo-mobile.png" alt="Logo da cafeteria Serenatto">
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
                        <a class="nav-link active" aria-current="page" href="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/index.php">Produtos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?php echo dirname($_SERVER['SCRIPT_NAME']); ?>/show.php">Filiais</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#contato">Relatórios</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="#">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="modo-noturno">
                                <label class="form-check-label" for="modo-noturno">Modo noturno</label>
                            </div>
                        </a>
                    </li> -->
                </ul>
            </div>
        </div>

    </div>
</nav>