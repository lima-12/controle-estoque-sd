<?php
require_once __DIR__ . '/../../config/Session.php';

// Verifica se o usuário está logado
Session::requireLogin();

// Caminhos dos arquivos
$jsonPathProdutos = 'produtos.json';
$jsonPathCategorias = 'categorias.json';

// Carrega os produtos
$produtosRecentes = [];
if (file_exists($jsonPathProdutos)) {
    $jsonData = file_get_contents($jsonPathProdutos);
    $produtosRecentes = json_decode($jsonData, true) ?? [];
}

// Carrega as categorias do JSON
$categorias = [];
if (file_exists($jsonPathCategorias)) {
    $jsonCategorias = file_get_contents($jsonPathCategorias);
    $categorias = json_decode($jsonCategorias, true) ?? [];
}

// Processa o envio do formulário
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $novoProduto = [
        "nome" => $_POST["nome"] ?? "",
        "descricao" => $_POST["descricao"] ?? "",
        "categoria" => $_POST["categoria"] ?? "",
        "quantidade" => (int) ($_POST["quantidade"] ?? 0),
        "data" => date("Y-m-d")
    ];

    $produtosRecentes[] = $novoProduto;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stok - Cadastro de Produtos</title>
    <!-- Importando Bootstrap e Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/css/produto/create.css" />
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
                    ['label' => 'Produtos', 'href' => './index.php'],
                    ['label' => 'Cadastrar Produto']
                ];
                include_once(__DIR__ . '/../components/breadcrumb.php');
            ?>
        </div>

        <!-- Container principal do formulário -->
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="cartao-formulario">
                    <!-- Cabeçalho com título e ícone -->
                    <div class="cabecalho-formulario">
                        <div class="titulo-com-icone">
                            <i class="fas fa-cube icone-cabecalho"></i>
                            <div>
                                <h1 class="titulo-formulario">Cadastre seu Produto</h1>
                                <p class="subtitulo-formulario">Adicione um novo item ao seu inventário</p>
                            </div>
                        </div>
                    </div>

                    <!-- Corpo com os campos do formulário -->
                    <div class="corpo-formulario">
                        <form id="formProduto" enctype="multipart/form-data">
                            <!-- Upload de imagem do produto (opcional) -->
                            <div class="rotulo-campo">Imagem do Produto (opcional)</div>
                            <label class="area-upload" id="area-upload">
                                <input type="file" id="inputArquivo" name="imagem" accept="image/*">
                                <div class="conteudo-upload">
                                    <i class="fas fa-image icone-upload"></i>
                                    <p class="texto-upload">Selecione uma imagem</p>
                                </div>
                            </label>

                            <!-- Campo de nome do produto -->
                            <div class="rotulo-campo">Nome do Produto</div>
                            <div class="campo-input">
                                <i class="fa-solid fa-box icone-input"></i>
                                <input class="form-control entrada-produto" name="nome" placeholder="Ex: Sabão" required>
                            </div>

                            <!-- Campo de descrição do produto (opcional) -->
                            <div class="rotulo-campo">Descrição do Produto (opcional)</div>
                            <div class="campo-input">
                                <i class="fas fa-align-left icone-input"></i>
                                <textarea class="form-control area-descricao" name="descricao" placeholder="Detalhes do produto..."></textarea>
                            </div>

                            <!-- Linha com os campos de quantidade e preço -->
                            <div class="linha-campos">
                                <!-- Campo quantidade -->
                                <div class="coluna-campo">
                                    <div class="rotulo-campo">Quantidade</div>
                                    <div class="campo-input">
                                        <i class="fas fa-hashtag icone-input"></i>
                                        <input type="number" name="quantidade" class="form-control entrada-produto" placeholder="0" min="0" required>
                                    </div>
                                </div>
                                <!-- Campo preço -->
                                <div class="coluna-campo">
                                    <div class="rotulo-campo">Preço (R$)</div>
                                    <div class="campo-input">
                                        <i class="fas fa-dollar-sign icone-input"></i>
                                        <input type="number" name="preco" step="0.01" class="form-control entrada-produto" placeholder="0.00" min="0" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Linha divisória -->
                            <hr class="linha-divisoria">

                            <!-- Botão de envio do formulário -->
                            <button type="submit" class="btn botao-enviar" id="btnCadastrar">
                                <i class="fas fa-plus icone-botao"></i>
                                <span id="btnText">Cadastrar</span>
                                <span id="btnLoading" class="d-none">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Salvando...
                                </span>
                            </button>
                            <div id="alertMessage" class="mt-3"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts Bootstrap e JS personalizado -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/produto/create.js"></script>
</body>
</html>