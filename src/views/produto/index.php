<?php
    require_once __DIR__ . '/../../config/Session.php';
    
    // Verifica se o usuário está logado
    Session::requireLogin();
    
    $title = 'Lista Produtos';
    
    // Função para obter a URL base
    function base_url($path = '') {
        $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
        $script_name = dirname($_SERVER['SCRIPT_NAME']);
        return rtrim($base_url . $script_name, '/') . '/' . ltrim($path, '/');
    }
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
    <link rel="stylesheet" href="../../assets/css/botao.css">
</head>

<body>

    <?php include_once(__DIR__ . '/../components/navbar.php'); ?>

    <div class="produtos-container px-4">
        <!-- Breadcrumb alinhado ao grid -->
        <div class="breadcrump">
            <?php 
                $breadcrumbs = [
                    ['label' => 'Home', 'href' => '../home.php'],
                    ['label' => 'Produtos']
                ];
                include_once(__DIR__ . '/../components/breadcrumb.php');
            ?>
        </div>

        <!-- Seção do título e da barra de pesquisa -->
        <div class="d-flex justify-content-center mb-4">
            <form class="d-flex search-form-container">
                <input class="form-control me-2" type="search" id="searchInput" placeholder="Pesquisar" aria-label="Pesquisar">
                <button class="btn btn-stok-primary" type="submit">Pesquisar</button>
            </form>
        </div>

        <!-- Grid de produtos -->
        <div class="produtos-grid" id="produtos-grid"></div>

        <div class="no-products d-none" id="no-products">
            <i class="fas fa-box-open"></i>
            <p>Nenhum produto encontrado</p>
        </div>
    </div>

    <a href="./create.php" class="btn-add-product">
        <i class="fas fa-plus"></i> Adicionar Produto
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Define a URL base para uso no JavaScript
        const baseUrl = '<?php 
            $base = rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/');
            echo $base;
        ?>';
        console.log('URL base definida como:', baseUrl);
    </script>
    <script src="../../assets/js/produto/index.js"></script>
</body>
</html>