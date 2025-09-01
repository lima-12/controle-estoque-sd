<?php
require_once __DIR__ . '/../config/Session.php';
require_once __DIR__ . '/../Model/Filiais.php';

// Verifica se o usuário está logado
Session::requireLogin();

// Define o tipo de conteúdo como JSON
header('Content-Type: application/json');

// Obtém a ação da requisição
$action = $_GET['action'] ?? '';

try {
    $filiaisModel = new \App\model\Filiais();
    
    switch ($action) {
        case 'getAll':
            $filiais = $filiaisModel->getAll();
            
            if ($filiais !== false) {
                echo json_encode([
                    'success' => true,
                    'filiais' => $filiais
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Erro ao buscar filiais'
                ]);
            }
            break;
            
        case 'getById':
            $id = $_GET['id'] ?? null;
            
            if (!$id) {
                echo json_encode([
                    'success' => false,
                    'message' => 'ID da filial não fornecido'
                ]);
                break;
            }
            
            $filial = $filiaisModel->getById($id);
            
            if ($filial) {
                echo json_encode([
                    'success' => true,
                    'filial' => $filial
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Filial não encontrada'
                ]);
            }
            break;
            
        case 'getProdutosByFilial':
            $id = $_GET['id'] ?? null;
            
            if (!$id) {
                echo json_encode([
                    'success' => false,
                    'message' => 'ID da filial não fornecido'
                ]);
                break;
            }
            
            $produtos = $filiaisModel->getProdutosByFilial($id);
            
            if ($produtos !== false) {
                echo json_encode([
                    'success' => true,
                    'produtos' => $produtos
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Erro ao buscar produtos da filial'
                ]);
            }
            break;
            
        case 'create':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                echo json_encode([
                    'success' => false,
                    'message' => 'Método não permitido'
                ]);
                break;
            }
            
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!$data) {
                $data = $_POST;
            }
            
            $result = $filiaisModel->create($data);
            
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Filial criada com sucesso',
                    'id' => $result
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Erro ao criar filial'
                ]);
            }
            break;
            
        case 'update':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'PUT') {
                echo json_encode([
                    'success' => false,
                    'message' => 'Método não permitido'
                ]);
                break;
            }
            
            $id = $_GET['id'] ?? null;
            
            if (!$id) {
                echo json_encode([
                    'success' => false,
                    'message' => 'ID da filial não fornecido'
                ]);
                break;
            }
            
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (!$data) {
                $data = $_POST;
            }
            
            $data['id'] = $id;
            
            $result = $filiaisModel->update($data);
            
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Filial atualizada com sucesso'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Erro ao atualizar filial'
                ]);
            }
            break;
            
        case 'delete':
            if ($_SERVER['REQUEST_METHOD'] !== 'DELETE' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
                echo json_encode([
                    'success' => false,
                    'message' => 'Método não permitido'
                ]);
                break;
            }
            
            $id = $_GET['id'] ?? null;
            
            if (!$id) {
                echo json_encode([
                    'success' => false,
                    'message' => 'ID da filial não fornecido'
                ]);
                break;
            }
            
            try {
                $result = $filiaisModel->delete($id);
                
                if ($result) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Filial e todo o seu estoque foram excluídos com sucesso'
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Erro ao excluir filial e estoque'
                    ]);
                }
            } catch (Exception $e) {
                echo json_encode([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }
            break;
            
        default:
            echo json_encode([
                'success' => false,
                'message' => 'Ação não reconhecida'
            ]);
            break;
    }
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Erro interno do servidor: ' . $e->getMessage()
    ]);
}
?>
