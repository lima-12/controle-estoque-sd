<?php
// Processamento do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeProduto = htmlspecialchars($_POST['nomeProduto'] ?? '');
    $descricao = htmlspecialchars($_POST['descricao'] ?? '');
    $detalhes = htmlspecialchars($_POST['detalhes'] ?? '');
    $quantidade = intval($_POST['quantidade'] ?? 0);
    $preco = floatval($_POST['preco'] ?? 0.00);
    
    $mensagemSucesso = '';
    $erro = '';
    
    // Validação básica
    if (empty($nomeProduto)) {
        $erro = "O nome do produto é obrigatório.";
    } elseif ($quantidade < 0) {
        $erro = "A quantidade não pode ser negativa.";
    } elseif ($preco < 0) {
        $erro = "O preço não pode ser negativo.";
    } else {
        $mensagemSucesso = "Produto <strong>'{$nomeProduto}'</strong> cadastrado com sucesso!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Produto - Sistema de Estoque</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="src\assets\css\cadastroProdutos.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <?php if (!empty($mensagemSucesso)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $mensagemSucesso ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($erro)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $erro ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h1 class="h4">Cadastrar Produto</h1>
                <p class="mb-0">Adicione um novo item ao seu inventário.</p>
            </div>
            
            <div class="card-body">
                <form method="POST" action="">
                    <div class="mb-4">
                        <div class="h5 mb-3">Nome do Produto</div>
                        
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="nomeProduto" name="nomeProduto" 
                                   placeholder="Ex: Camiseta Estilizada" required
                                   value="<?= isset($nomeProduto) ? $nomeProduto : '' ?>">
                            <label for="nomeProduto">Ex: Camiseta Estilizada</label>
                        </div>
                        
                        <div class="h5 mb-3">Descrição do Produto</div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="descricao" name="descricao" 
                                      placeholder="Descrição (Opcional)" style="height: 100px"><?= isset($descricao) ? $descricao : '' ?></textarea>
                            <label for="descricao">Detalhes sobre o produto...</label>
                        </div>

                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="h5 input-title">Quantidade</div>
                                <div class="input-group">
                                    <span class="input-group-text">#</span>
                                    <input type="number" class="form-control" id="quantidade" name="quantidade" 
                                           value="<?= isset($quantidade) ? $quantidade : 0 ?>" min="0">
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <div class="h5 input-title">Preço (R$)</div>
                                <div class="input-group">
                                    <span class="input-group-text">R$</span>
                                    <input type="number" class="form-control" id="preco" name="preco" 
                                           value="<?= isset($preco) ? number_format($preco, 2, '.', '') : '0.00' ?>" 
                                           min="0" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Cadastrar Produto</button>
                    </div>
                </form>
            </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>