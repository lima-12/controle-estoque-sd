<?php
    $title = 'Lista Produtos';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Stok - Produtos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="../../assets/css/produto/index.css" />
</head>

<body>
    <nav class="produtos-navbar fixed-top">
        <div class="container-fluid d-flex justify-content-between align-items-center">

            <a class="navbar-brand d-flex align-items-center me-auto" href="#">
                <img src="../../assets/img/logo-stok-azul-laranja.png" alt="Logo Stok" class="navbar-logo me-2" />
            </a>

            <ul class="navbar-nav flex-row align-items-center">
                <li class="nav-item me-3">
                    <form class="d-flex" role="search">
                        <div class="search-input-group">
                            <i class="fas fa-search search-icon"></i>
                            <input class="form-control search-input" type="search" placeholder="Pesquisar..." aria-label="Pesquisar">
                        </div>
                    </form>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-user"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                </li>
            </ul>

        </div>
    </nav>

    <div class="navbar-spacer"></div>

    <div class="produtos-container">
        <div class="produtos-grid" id="produtos-grid">
            </div>

        <div class="no-products d-none" id="no-products">
            <i class="fas fa-box-open"></i>
            <p>Nenhum produto encontrado</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/produto/index.js"></script>
</body>
</html>