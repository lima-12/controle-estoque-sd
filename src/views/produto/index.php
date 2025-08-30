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
    <link rel="stylesheet" href="../../assets/css/components/navbar.css">
</head>

<body>

    <?php include_once(__DIR__ . '/../components/navbar.php'); ?>

    <div class="produtos-container px-4">
        <!-- Breadcrumb alinhado ao grid -->
        <div class="breadcrump">
            <?php 
                $breadcrumbs = [
                    ['label' => 'Home', 'href' => dirname($_SERVER['SCRIPT_NAME']) . '/../home.php'],
                    ['label' => 'Produtos']
                ];
                include_once(__DIR__ . '/../components/breadcrumb.php');
            ?>
        </div>

        <!-- Grid de produtos -->
        <div class="produtos-grid" id="produtos-grid"></div>

        <div class="no-products d-none" id="no-products">
            <i class="fas fa-box-open"></i>
            <p>Nenhum produto encontrado</p>
        </div>
    </div>

    <a href="cadastroProdutos.php" class="btn-add-product">
        <i class="fas fa-plus"></i> Adicionar Produto
    </a>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/produto/index.js"></script>
</body>
</html>
