<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produtos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="src/assets/css/cadastroProdutos.css">
</head>
<body>
    <div class="container-formulario">
        <div class="cartao-formulario">
            <div class="cabecalho-formulario">
                <div class="titulo-com-icone">
                    <i class="fas fa-cube icone-cabecalho"></i>
                    <div>
                        <h1 class="titulo-formulario">Cadastre seu Produto</h1>
                        <p class="subtitulo-formulario">Adicione um novo item ao seu inventário</p>
                    </div>
                </div>
            </div>

            <div class="corpo-formulario">
                <form>
                    <!-- Campo de Nome -->
                    <div class="rotulo-input">Nome do Produto</div>
                    <div class="campo-input">
                        <i class="fa-solid fa-box icone-input"></i>
                        <input class="form-control input-produto" placeholder="Ex: Sabão" required>
                    </div>

                    <!-- Campo de Descrição -->
                    <div class="rotulo-input">Descrição do Produto (opcional)</div>
                    <div class="campo-input">
                        <i class="fas fa-align-left icone-input"></i>
                        <textarea class="form-control area-descricao" placeholder="Detalhes do produto..."></textarea>
                    </div>
                    
                    <!-- Campos Quantidade e Preço -->
                    <div class="linha-inputs">
                        <div class="coluna-input">
                            <div class="rotulo-input">Quantidade</div>
                            <div class="campo-input">
                                <i class="fas fa-hashtag icone-input"></i>
                                <input type="number" class="form-control input-produto" placeholder="0" min="0" required>
                            </div>
                        </div>
                        <div class="coluna-input">
                            <div class="rotulo-input">Preço (R$)</div>
                            <div class="campo-input">
                                <i class="fas fa-dollar-sign icone-input"></i>
                                <input type="number" step="0.01" class="form-control input-produto" placeholder="0.00" min="0" required>
                            </div>
                        </div>
                    </div>

                    <hr class="linha-separadora">

                    <!-- Botão de Cadastrar -->
                    <button type="submit" class="btn botao-cadastrar">
                        <i class="fas fa-plus icone-botao"></i>
                        Cadastrar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="src/assets/js/cadastro.js"></script> -->
</body>
</html>