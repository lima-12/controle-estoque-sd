<?php
    require_once __DIR__ . '/../../config/Session.php';
    
    // Verifica se o usuário está logado
    Session::requireLogin();
    
    $title = 'Filiais';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Stok - Filiais</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="../../assets/css/filiais/index.css">
    <link rel="stylesheet" href="../../assets/css/components/navbar.css">
    <link rel="stylesheet" href="../../assets/css/botao.css">
</head>

<body>
    <style>
        body{
            background: linear-gradient(135deg, #8bbcf0 0%, #ffffff 35%, #ffb877 100%);
            min-height: 100vh;
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
        }
    </style>
    <?php include_once(__DIR__ . '/../components/navbar.php'); ?>

    <div class="filiais-container px-4">
        <!-- Breadcrumb alinhado ao grid -->
        <div class="breadcrump">
            <?php 
                $breadcrumbs = [
                    ['label' => 'Home', 'href' => '../../views/home.php'],
                    ['label' => 'Filiais']
                ];
                include_once(__DIR__ . '/../components/breadcrumb.php');
            ?>
        </div>

        <!-- Search and Actions Bar -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Gestão de Filiais</h2>
            <div class="d-flex">
                <div class="position-relative me-2" style="width: 250px;">
                    <input type="text" class="form-control" id="searchInput" placeholder="Buscar filiais..." style="padding-left: 35px;">
                    <i class="fas fa-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #6c757d;"></i>
                </div>
                <button class="btn btn-outline-secondary" onclick="refreshFiliais()" title="Atualizar lista">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>

        <!-- Grid de filiais -->
        <div class="filiais-grid" id="filiais-grid"></div>

        <div class="no-filiais d-none" id="no-filiais">
            <i class="fas fa-building"></i>
            <p>Nenhuma filial encontrada</p>
        </div>
    </div>

    <a href="./create.php" class="btn-add-filial">
        <i class="fas fa-plus"></i>
        <span class="btn-text">Adicionar Filial</span>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../assets/js/filiais/index.js"></script>
</body>
</html>
