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
    
    $title = 'Editar Filial';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Stok - Editar Filial</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="../../assets/css/filiais/update.css">
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

    <div class="filial-update-container px-4">
        <!-- Breadcrumb -->
        <div class="breadcrump">
            <?php 
                $breadcrumbs = [
                    ['label' => 'Home', 'href' => '../../views/home.php'],
                    ['label' => 'Filiais', 'href' => './index.php'],
                    ['label' => 'Editar Filial']
                ];
                include_once(__DIR__ . '/../components/breadcrumb.php');
            ?>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="mb-0">
                            <i class="fas fa-edit me-2"></i>Editar Filial
                        </h4>
                    </div>
                    <div class="card-body">
                        <div id="loading" class="text-center">
                            <i class="fas fa-spinner fa-spin"></i> Carregando dados da filial...
                        </div>
                        
                        <form id="filialForm" class="d-none">
                            <input type="hidden" id="filialId" value="<?php echo $id; ?>">
                            
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome da Filial *</label>
                                <input type="text" class="form-control" id="nome" name="nome" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="endereco" class="form-label">Endereço *</label>
                                <input type="text" class="form-control" id="endereco" name="endereco" required>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="cidade" class="form-label">Cidade *</label>
                                        <input type="text" class="form-control" id="cidade" name="cidade" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="uf" class="form-label">Estado *</label>
                                        <select class="form-select" id="uf" name="uf" required>
                                            <option value="">Selecione...</option>
                                            <option value="AC">Acre</option>
                                            <option value="AL">Alagoas</option>
                                            <option value="AP">Amapá</option>
                                            <option value="AM">Amazonas</option>
                                            <option value="BA">Bahia</option>
                                            <option value="CE">Ceará</option>
                                            <option value="DF">Distrito Federal</option>
                                            <option value="ES">Espírito Santo</option>
                                            <option value="GO">Goiás</option>
                                            <option value="MA">Maranhão</option>
                                            <option value="MT">Mato Grosso</option>
                                            <option value="MS">Mato Grosso do Sul</option>
                                            <option value="MG">Minas Gerais</option>
                                            <option value="PA">Pará</option>
                                            <option value="PB">Paraíba</option>
                                            <option value="PR">Paraná</option>
                                            <option value="PE">Pernambuco</option>
                                            <option value="PI">Piauí</option>
                                            <option value="RJ">Rio de Janeiro</option>
                                            <option value="RN">Rio Grande do Norte</option>
                                            <option value="RS">Rio Grande do Sul</option>
                                            <option value="RO">Rondônia</option>
                                            <option value="RR">Roraima</option>
                                            <option value="SC">Santa Catarina</option>
                                            <option value="SP">São Paulo</option>
                                            <option value="SE">Sergipe</option>
                                            <option value="TO">Tocantins</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <a href="./index.php" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Voltar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Atualizar Filial
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../assets/js/filiais/update.js"></script>
</body>
</html>

