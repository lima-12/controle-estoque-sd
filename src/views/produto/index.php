<?php
    // echo "teste";exit();
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
    <div class="produtos-container">
        <!-- Header da página -->
        <div class="produtos-header">
            <div class="d-flex flex-column align-items-center text-center">
                <img src="../../assets/img/logo-stok-azul-laranja.png" alt="Logo Stok" class="w-25 mb-3" />
                <h1 class="produtos-title">Nossos Produtos</h1>
                <p class="produtos-subtitle">Gerencie seu estoque de forma eficiente</p>
            </div>

            <!-- Formulário de busca -->
            <form class="search-form d-flex" role="search">
                <div class="search-input-group flex-grow-1">
                    <i class="fas fa-search search-icon"></i>
                    <input 
                        class="form-control search-input" 
                        type="search" 
                        placeholder="Pesquisar produto..." 
                        aria-label="Pesquisar Produto"
                    />
                </div>
                <button class="btn btn-search" type="submit">
                    <i class="fas fa-search me-2"></i>Pesquisar
                </button>
            </form>
        </div>

        <!-- Grid de produtos -->
        <div class="produtos-grid" id="produtos-grid">
            <!-- Os produtos serão carregados aqui via JavaScript -->
        </div>

        <!-- Mensagem quando não há produtos -->
        <div class="no-products d-none" id="no-products">
            <i class="fas fa-box-open"></i>
            <p>Nenhum produto encontrado</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/produto/index.js"></script>
</body>
</html>