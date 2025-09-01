<?php
require_once __DIR__ . '/../../config/Session.php';

// Verifica se o usuário está logado
Session::requireLogin();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stok - Entrada de Produtos</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="../../assets/css/entrada-produto/index.css" />
    <link rel="stylesheet" href="../../assets/css/components/navbar.css">
    <link rel="stylesheet" href="../../assets/css/botao.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <?php include_once(__DIR__ . '/../components/navbar.php'); ?>
    
    <div class="container-entrada-produto px-4">
        <!-- Breadcrumb -->
        <div class="breadcrump mb-4">
            <?php 
                $breadcrumbs = [
                    ['label' => 'Home', 'href' => '../home.php'],
                    ['label' => 'Entrada de Produtos']
                ];
                include_once(__DIR__ . '/../components/breadcrumb.php'); 
            ?>
        </div>

        <!-- Search and Actions Bar -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Registrar Entrada de Produtos</h2>
            <!-- <div class="d-flex">
                <div class="position-relative me-2" style="width: 250px;">
                    <input type="text" class="form-control" id="searchInput" placeholder="Buscar entradas..." style="padding-left: 35px;">
                    <i class="fas fa-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #6c757d;"></i>
                </div>
                <button class="btn btn-outline-secondary" onclick="refreshEntries()" title="Atualizar lista">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div> -->
        </div>

        <div class="card">
            <!-- <div class="card-header"> Registrar Entrada de Produtos </div> -->
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="cartao-formulario">
                            <form id="formEntradaProduto">
                                <!-- Mensagens de feedback -->
                                <div id="alertContainer"></div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                        <label for="produto" class="form-label">Produto <span class="text-danger">*</span></label>
                                        <select class="form-select" id="produto" name="produto_id" required>
                                            <option value="" selected disabled>Selecione um produto</option>
                                            <!-- Os produtos serão carregados via JavaScript -->
                                        </select>
                                    </div>
                                
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                        <label for="filial" class="form-label">Filial <span class="text-danger">*</span></label>
                                        <select class="form-select" id="filial" name="filial_id" required>
                                            <option value="" selected disabled>Selecione uma filial</option>
                                            <!-- As filiais serão carregadas via JavaScript -->
                                        </select>
                                    </div>
                                
                                    <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                        <label for="quantidade" class="form-label">Quantidade <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="quantidade" name="quantidade" min="1" required>
                                    </div>
                                
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <!-- <a href="/src/views/home.php" class="btn btn-outline-secondary me-md-2">
                                            <i class="fas fa-arrow-left"></i> Voltar
                                        </a> -->
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Registrar Entrada
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Sucesso -->
    <div class="modal fade" id="modalSucesso" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="fas fa-check-circle me-2"></i> Sucesso!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <p id="mensagemSucesso">Entrada de produto registrada com sucesso!</p>
                </div>
                <div class="modal-footer">
                    <a href="/src/views/home.php" class="btn btn-secondary">Ir para a página inicial</a>
                    <button type="button" class="btn btn-primary" id="btnNovaEntrada">
                        <i class="fas fa-plus"></i> Nova Entrada
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts Bootstrap e JS personalizado -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/assets/js/entrada-produto/index.js"></script>
</body>
</html>
