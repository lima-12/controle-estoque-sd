<?php
    require_once __DIR__ . '/../../config/Session.php';
    
    // Verifica se o usuário está logado
    Session::requireLogin();
    
    // Verificar se o ID foi fornecido
    $id = $_GET['id'] ?? null;
    if (!$id) {
        header('Location: ./index.php');
        exit;
    }
    
    $title = 'Detalhes da Filial';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Stok - Detalhes da Filial</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="../../assets/css/filiais/show.css">
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

    <div class="filial-show-container px-4">
        <!-- Breadcrumb -->
        <div class="breadcrump">
            <?php 
                $breadcrumbs = [
                    ['label' => 'Home', 'href' => '../../views/home.php'],
                    ['label' => 'Filiais', 'href' => './index.php'],
                    ['label' => 'Detalhes da Filial']
                ];
                include_once(__DIR__ . '/../components/breadcrumb.php');
            ?>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">
                            <i class="fas fa-building me-2"></i>Detalhes da Filial
                        </h4>
                    </div>
                    <div class="card-body">
                        <div id="filial-details">
                            <div class="text-center">
                                <i class="fas fa-spinner fa-spin"></i> Carregando...
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="./index.php" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Voltar
                            </a>
                            <div>
                                <a href="./update.php?id=<?php echo $id; ?>" class="btn btn-primary me-2">
                                    <i class="fas fa-edit me-2"></i>Editar
                                </a>
                                <button onclick="deleteFilial(<?php echo $id; ?>)" class="btn btn-danger">
                                    <i class="fas fa-trash me-2"></i>Excluir
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Card para produtos da filial -->
                <div class="card shadow">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-boxes me-2"></i>Produtos em Estoque
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="produtos-filial">
                            <div class="text-center">
                                <i class="fas fa-spinner fa-spin"></i> Carregando produtos...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../assets/js/filiais/show.js"></script>
</body>
</html>

