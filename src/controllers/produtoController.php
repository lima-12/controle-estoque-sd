<?php

// use App\model\Produto;
require_once __DIR__ . '/../Model/Produto.php';
use App\model\Produto;

header('Content-Type: application/json');

$produtoModel = new Produto();

if (isset($_GET['busca'])) {
    $busca = $_GET['busca'];
    echo json_encode($produtoModel->getAll($busca));
    exit;
}

// Rota para obter detalhes de um produto específico (apenas para GET)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id']) && !isset($_GET['_method'])) {
    $id = (int)$_GET['id'];
    echo json_encode($produtoModel->getDetalhesComFiliais($id));
    exit;
}

// POST - Criar ou atualizar produto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Verifica se é uma atualização (tem ID)
        $isUpdate = !empty($_POST['id']);
        
        $dados = [
            'nome' => $_POST['nome'] ?? '',
            'preco' => (float) ($_POST['preco'] ?? 0)
        ];
        
        // Se for atualização, adiciona o ID e a imagem atual
        if ($isUpdate) {
            $dados['id'] = (int)$_POST['id'];
            
            // Busca o produto atual para manter a imagem existente se não for enviada uma nova
            $produtoAtual = $produtoModel->getDetalhesComFiliais($dados['id']);
            if ($produtoAtual && !empty($produtoAtual['imagem'])) {
                $dados['imagem_atual'] = $produtoAtual['imagem'];
            }
        }
        
        // Validação básica
        if (empty($dados['nome'])) {
            throw new Exception('O nome do produto é obrigatório');
        }
        
        if ($dados['preco'] <= 0) {
            throw new Exception('O preço deve ser maior que zero');
        }
        
        // Decide qual método chamar com base se é criação ou atualização
        if ($isUpdate) {
            $resultado = $produtoModel->atualizarProduto($dados, $_FILES['imagem'] ?? null);
            $mensagemSucesso = 'Produto atualizado com sucesso!';
        } else {
            $resultado = $produtoModel->criarProduto($dados);
            $mensagemSucesso = 'Produto criado com sucesso!';
        }
        
        if ($resultado['success']) {
            http_response_code($isUpdate ? 200 : 201);
            echo json_encode([
                'success' => true, 
                'message' => $mensagemSucesso,
                'id' => $resultado['id']
            ]);
        } else {
            throw new Exception($resultado['error'] ?? ($isUpdate ? 'Erro ao atualizar o produto' : 'Erro ao criar o produto'));
        }
        
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
    exit;
}

// DELETE - Excluir produto
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
    try {
        error_log('Iniciando exclusão do produto. ID: ' . $_GET['id']);
        $id = (int)$_GET['id'];
        
        if ($id <= 0) {
            error_log('ID inválido: ' . $id);
            throw new Exception('ID do produto inválido');
        }
        
        error_log('Chamando excluirProduto para o ID: ' . $id);
        $resultado = $produtoModel->excluirProduto($id);
        error_log('Resultado da exclusão: ' . print_r($resultado, true));
        
        if ($resultado['success']) {
            error_log('Produto ID ' . $id . ' excluído com sucesso');
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'message' => $resultado['message']
            ]);
        } else {
            // Se houver uma mensagem de erro específica do modelo, usamos ela
            $errorMessage = $resultado['error'] ?? 'Erro desconhecido ao excluir o produto';
            
            // Log do erro para depuração
            error_log('Erro ao excluir produto ID ' . $id . ': ' . $errorMessage);
            
            // Se for um erro de validação (como itens em estoque), retornamos 422 (Unprocessable Entity)
            if (strpos(strtolower($errorMessage), 'não é possível excluir') !== false || 
                strpos(strtolower($errorMessage), 'itens em estoque') !== false ||
                strpos(strtolower($errorMessage), 'produto não encontrado') !== false) {
                http_response_code(422);
            } else {
                // Para outros erros, usamos 400 (Bad Request)
                http_response_code(400);
            }
            
            // Garante que a mensagem de erro seja uma string
            $errorMessage = is_string($errorMessage) ? $errorMessage : 'Ocorreu um erro ao processar a requisição';
            
            echo json_encode([
                'success' => false,
                'message' => $errorMessage
            ]);
        }
        
    } catch (PDOException $e) {
        // Erros específicos do banco de dados
        error_log('Erro no banco de dados ao excluir produto: ' . $e->getMessage());
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Erro no servidor ao processar a exclusão. Por favor, tente novamente.'
        ]);
    } catch (Exception $e) {
        // Outros erros
        error_log('Erro ao excluir produto: ' . $e->getMessage());
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
    exit;
}
