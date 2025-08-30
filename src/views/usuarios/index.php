<?php
    $title = 'Lista Usuários';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Stok - Usuários</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="../../assets/css/usuarios/index.css">
    <link rel="stylesheet" href="../../assets/css/components/navbar.css">
    <link rel="stylesheet" href="../../assets/css/botao.css">

</head>

<body>

    <?php include_once(__DIR__ . '/../components/navbar.php'); ?>

    <div class="usuarios-container px-4">
        <!-- Breadcrumb alinhado ao grid -->
        <div class="breadcrump">
            <?php 
                $breadcrumbs = [
                    ['label' => 'Home', 'href' => '../home.php'],
                    ['label' => 'Usuários']
                ];
                include_once(__DIR__ . '/../components/breadcrumb.php');
            ?>
        </div>

        <!-- Search and Actions Bar -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Gestão de Usuários</h2>
            <div class="d-flex">
                <div class="position-relative me-2" style="width: 250px;">
                    <input type="text" class="form-control" id="searchInput" placeholder="Buscar usuários..." style="padding-left: 35px;">
                    <i class="fas fa-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #6c757d;"></i>
                </div>
                <button class="btn btn-outline-secondary" onclick="refreshUsers()" title="Atualizar lista">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>

        <!-- Grid de usuários -->
        <div class="usuarios-grid" id="usuarios-grid"></div>

        <div class="no-users d-none" id="no-users">
            <i class="fas fa-users"></i>
            <p>Nenhum usuário encontrado</p>
        </div>
    </div>

    <a href="./create.php" class="btn-add-user">
        <i class="fas fa-plus"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../assets/js/usuarios/index.js"></script>
</body>
</html>
