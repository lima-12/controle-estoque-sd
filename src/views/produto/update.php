<?php
require_once __DIR__ . '/../../config/Session.php';
require_once __DIR__ . '/../../Model/Produto.php';

use App\model\Produto;

// Verifica se o usuário está logado
Session::requireLogin();

// Verifica se o ID do produto foi fornecido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php?erro=produto_invalido');
    exit;
}

$produtoModel = new Produto();
$produtoId = (int)$_GET['id'];

// Busca os dados do produto
$produto = $produtoModel->getDetalhesComFiliais($produtoId);

if (!$produto) {
    header('Location: index.php?erro=produto_nao_encontrado');
    exit;
}

// Processa o envio do formulário de atualização
$mensagemErro = '';
$mensagemSucesso = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        // Aqui será implementada a lógica de atualização
        $dados = [
            'id' => $produtoId,
            'nome' => $_POST['nome'] ?? '',
            'preco' => (float) ($_POST['preco'] ?? 0)
        ];
        
        // Validação básica
        if (empty($dados['nome'])) {
            throw new Exception('O nome do produto é obrigatório');
        }
        
        if ($dados['preco'] <= 0) {
            throw new Exception('O preço deve ser maior que zero');
        }
        
        // Atualiza o produto
        $resultado = $produtoModel->atualizarProduto($dados, $_FILES['imagem'] ?? null);
        
        if ($resultado['success']) {
            $mensagemSucesso = 'Produto atualizado com sucesso!';
            // Atualiza os dados do produto para exibir as alterações
            $produto = $produtoModel->getDetalhesComFiliais($produtoId);
        } else {
            throw new Exception($resultado['error'] ?? 'Erro ao atualizar o produto');
        }
        
    } catch (Exception $e) {
        $mensagemErro = $e->getMessage();
    }
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
                                <h1 class="titulo-formulario">Editar Produto</h1>
                                <p class="subtitulo-formulario">Atualize as informações do produto</p>
                            </div>
                        </div>
                    </div>

                    <!-- Corpo com os campos do formulário -->
                    <div class="corpo-formulario">
                        <form id="formProduto" action="/src/controllers/produtoController.php" method="POST" enctype="multipart/form-data">
                            <!-- Upload de imagem do produto (opcional) -->
                            <div class="rotulo-campo">Imagem do Produto (opcional)</div>
                            <div class="mb-3">
                                <?php if (!empty($produto['imagem'])): ?>
                                    <img src="/assets/img/produtos/<?= htmlspecialchars($produto['imagem']) ?>" alt="Imagem do produto" class="img-thumbnail mb-2" style="max-width: 200px; max-height: 200px; display: block;">
                                <?php endif; ?>
                                <label class="area-upload" id="area-upload">
                                    <input type="file" id="inputArquivo" name="imagem" accept="image/*">
                                    <div class="conteudo-upload">
                                        <i class="fas fa-image icone-upload"></i>
                                        <p class="texto-upload">
                                            <?= !empty($produto['imagem']) ? 'Alterar imagem' : 'Selecione uma imagem' ?>
                                        </p>
                                    </div>
                            </label>

                            <!-- Campo de nome do produto -->
                            <div class="rotulo-campo">Nome do Produto</div>
                            <div class="campo-input">
                                <i class="fa-solid fa-box icone-input"></i>
                                <input class="form-control entrada-produto" name="nome" placeholder="Ex: Sabão" value="<?= htmlspecialchars($produto['nome'] ?? '') ?>" required>
                            </div>


                            <!-- Campo preço -->
                            <div class="mb-3">
                                <div class="rotulo-campo">Preço (R$)</div>
                                <div class="campo-input">
                                    <i class="fas fa-dollar-sign icone-input"></i>
                                    <input type="number" name="preco" step="0.01" class="form-control entrada-produto" placeholder="0.00" min="0" value="<?= number_format($produto['preco'] ?? 0, 2, '.', '') ?>" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Linha divisória -->
                            <hr class="linha-divisoria">

                            <!-- Botão de envio do formulário -->
                            <button type="submit" class="btn botao-enviar" id="btnAtualizar">
                                <i class="fas fa-save icone-botao"></i>
                                <span id="btnText">Atualizar</span>
                                <span id="btnLoading" class="d-none">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Atualizando...
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
    <script src="../../assets/js/produto/update.js"></script>
</body>
</html>