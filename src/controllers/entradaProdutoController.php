<?php

require_once __DIR__ . '/../Model/Produto.php';
require_once __DIR__ . '/../Model/Filiais.php';

use App\model\Produto;
use App\model\Filiais;

header('Content-Type: application/json');

$produtoModel = new Produto();
$filialModel = new Filiais();

// Rota para listar produtos e filiais para o formulário
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getFormData') {
    try {
        $produtos = $produtoModel->getAll();
        $filiais = $filialModel->getAll();
        
        echo json_encode([
            'success' => true,
            'produtos' => $produtos,
            'filiais' => $filiais
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Erro ao carregar dados do formulário: ' . $e->getMessage()
        ]);
    }
    exit;
}

// Rota para processar a entrada de produtos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Verifica se os dados necessários foram enviados
        if (empty($_POST['produto_id']) || empty($_POST['filial_id']) || empty($_POST['quantidade'])) {
            throw new Exception('Todos os campos são obrigatórios');
        }

        $produtoId = (int)$_POST['produto_id'];
        $filialId = (int)$_POST['filial_id'];
        $quantidade = (int)$_POST['quantidade'];
        $observacao = $_POST['observacao'] ?? '';

        // Validações adicionais
        if ($quantidade <= 0) {
            throw new Exception('A quantidade deve ser maior que zero');
        }

        // Registra a entrada do produto
        $resultado = $produtoModel->registrarEntrada($produtoId, $filialId, $quantidade);
        
        if (!$resultado['success']) {
            throw new Exception($resultado['message']);
        }

        // Aqui você pode adicionar o registro do histórico/movimentação se necessário
        // $this->registrarMovimentacao($produtoId, $filialId, $quantidade, 'entrada', $observacao);

        echo json_encode([
            'success' => true,
            'message' => 'Entrada de produto registrada com sucesso!'
        ]);
        
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
    exit;
}

// Rota não encontrada
http_response_code(404);
echo json_encode([
    'success' => false,
    'message' => 'Rota não encontrada'
]);
