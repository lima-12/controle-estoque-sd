<?php
    require_once __DIR__ . '/../../config/Session.php';
    
    // Verifica se o usuário está logado
    Session::requireLogin();
    
    $title = 'Relatórios';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Stok - Relatórios</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="../../assets/css/style.css" />
    <link rel="stylesheet" href="../../assets/css/components/navbar.css" />
</head>

<body>

    <?php include_once(__DIR__ . '/../components/navbar.php'); ?>

    <div class="container mt-4">
        <!-- Breadcrumb -->
        <div class="breadcrump mb-4">
            <?php 
                $breadcrumbs = [
                    ['label' => 'Home', 'href' => '../home.php'],
                    ['label' => 'Relatórios']
                ];
                include_once(__DIR__ . '/../components/breadcrumb.php');
            ?>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-chart-bar me-2"></i>Relatórios</h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Em desenvolvimento:</strong> A página de relatórios está sendo implementada. 
                            Em breve você poderá visualizar relatórios detalhados sobre o estoque.
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="card border-primary">
                                    <div class="card-body text-center">
                                        <i class="fas fa-boxes fa-3x text-primary mb-3"></i>
                                        <h5 class="card-title">Relatório de Produtos</h5>
                                        <p class="card-text">Visualize todos os produtos em estoque</p>
                                        <button class="btn btn-primary" disabled>Em breve</button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="card border-warning">
                                    <div class="card-body text-center">
                                        <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                                        <h5 class="card-title">Estoque Baixo</h5>
                                        <p class="card-text">Produtos com estoque crítico</p>
                                        <button class="btn btn-warning" disabled>Em breve</button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="card border-success">
                                    <div class="card-body text-center">
                                        <i class="fas fa-chart-line fa-3x text-success mb-3"></i>
                                        <h5 class="card-title">Valor em Estoque</h5>
                                        <p class="card-text">Valor total do inventário</p>
                                        <button class="btn btn-success" disabled>Em breve</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
