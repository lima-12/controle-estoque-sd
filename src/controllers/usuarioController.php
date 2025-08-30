<?php

require_once __DIR__ . '/../Model/Usuario.php';
use App\model\Usuario;

header('Content-Type: application/json');

$usuarioModel = new Usuario();

// GET - List all users or search
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['busca'])) {
        $busca = trim($_GET['busca']);
        
        if (empty($busca)) {
            // Se a busca estiver vazia, retorna todos os usuários
            echo json_encode($usuarioModel->getAll());
        } else {
            // Realiza a busca
            $result = $usuarioModel->search($busca);
            if ($result === false) {
                http_response_code(500);
                echo json_encode(['error' => 'Erro ao realizar busca']);
            } else {
                echo json_encode($result);
            }
        }
        exit;
    }

    if (isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        echo json_encode($usuarioModel->find(null, $id));
        exit;
    }

    // Se não houver parâmetros específicos, retorna todos os usuários
    echo json_encode($usuarioModel->getAll());
    exit;
}

// POST - Create new user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log("POST request received for user creation");
    
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!$data) {
        $data = $_POST;
    }
    
    error_log("Received data: " . var_export($data, true));
    
    $nome = $data['nome'] ?? '';
    $email = $data['email'] ?? '';
    $senha = $data['senha'] ?? '';
    $telefone = $data['telefone'] ?? null;
    
    // Convert empty string to null for telefone
    if ($telefone === '') {
        $telefone = null;
    }
    
    error_log("Extracted values - nome: '$nome', email: '$email', senha length: " . strlen($senha) . ", telefone: '$telefone'");
    
    if (empty($nome) || empty($email) || empty($senha)) {
        error_log("Validation failed - empty fields detected");
        http_response_code(400);
        echo json_encode(['error' => 'Nome, email e senha são obrigatórios']);
        exit;
    }
    
    // Hash the password
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    error_log("Password hashed successfully, hash length: " . strlen($senha_hash));
    
    error_log("Calling usuarioModel->insert()");
    $result = $usuarioModel->insert($nome, $email, $senha_hash, $telefone);
    error_log("Insert result: " . var_export($result, true));
    
    if ($result === true) {
        error_log("User creation successful");
        echo json_encode(['success' => 'Usuário criado com sucesso']);
    } else {
        error_log("User creation failed: " . var_export($result, true));
        http_response_code(500);
        echo json_encode(['error' => $result]);
    }
    exit;
}

// PUT - Update user
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $id = $data['id'] ?? 0;
    $nome = $data['nome'] ?? '';
    $email = $data['email'] ?? '';
    $senha = $data['senha'] ?? null;
    $telefone = $data['telefone'] ?? null;
    
    if (empty($id) || empty($nome) || empty($email)) {
        http_response_code(400);
        echo json_encode(['error' => 'ID, nome e email são obrigatórios']);
        exit;
    }
    
    if ($senha) {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $result = $usuarioModel->update($id, $nome, $email, $senha_hash, $telefone);
    } else {
        $result = $usuarioModel->update($id, $nome, $email, null, $telefone);
    }
    
    if ($result === true) {
        echo json_encode(['success' => 'Usuário atualizado com sucesso']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => $result]);
    }
    exit;
}

// DELETE - Delete user
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $id = $data['id'] ?? 0;
    
    if (empty($id)) {
        http_response_code(400);
        echo json_encode(['error' => 'ID é obrigatório']);
        exit;
    }
    
    $result = $usuarioModel->delete($id);
    
    if ($result === true) {
        echo json_encode(['success' => 'Usuário deletado com sucesso']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Erro ao deletar usuário']);
    }
    exit;
}
// Method not allowed
http_response_code(405);
echo json_encode(['error' => 'Método não permitido']);
exit;

