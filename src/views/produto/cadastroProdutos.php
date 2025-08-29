<?php
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
    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/css/produto/cadastroProdutos.css" />

</head>
<body>
    <!-- Container principal do formulário -->
    <div class="container-formulario">
        <!-- Cartão com o conteúdo do formulário -->
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
                <form method="post">
                    <!-- Upload de imagem do produto (opcional) -->
                    <div class="rotulo-campo">Imagem do Produto (opcional)</div>
                    <label class="area-upload" id="area-upload">
                        <input type="file" id="inputArquivo" name="imagemProduto" accept="image/*">
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
                    <button type="submit" class="btn botao-enviar">
                        <i class="fas fa-plus icone-botao"></i>
                        Cadastrar
                    </button>
                </form>
            </div>

        </div>
    </div>

    <!-- Scripts Bootstrap e JS personalizado -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="src/assets/js/cadastroProdutos.js"></script>
</body>
</html>