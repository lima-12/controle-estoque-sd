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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/style.css" />
    <link rel="stylesheet" href="../../assets/css/components/navbar.css" />
</head>

<body>

    <?php include_once(__DIR__ . '/../components/navbar.php'); ?>

    <div class="container mt-4">
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
                        <div class="alert alert-info text-center" id="noDataMessage" style="display: none;">
                            <i class="fas fa-info-circle me-2"></i>
                            Nenhum produto encontrado para gerar o gráfico.
                        </div>
    
                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                            <div class="chart-container" style="height: 400px; max-width: 600px;">
                                <canvas id="estoqueChart"></canvas>
                            </div>
                            <div id="custom-legend" class="chart-legend mt-3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script src="../../assets/js/relatorios/relatorios.js"></script>
</body>
</html>