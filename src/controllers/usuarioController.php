<?php

require_once __DIR__ . '/../Model/Usuario.php';
use App\model\Usuario;

header('Content-Type: application/json');

$usuarioModel = new Usuario();

if (isset($_GET['busca'])) {
    $busca = $_GET['busca'];
    // Por enquanto vamos retornar todos os usuários, 
    // você pode implementar a busca depois
    echo json_encode($usuarioModel->getAll());
    exit;
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    echo json_encode($usuarioModel->find(null, $id));
    exit;
}

// Se não houver parâmetros específicos, retorna todos os usuários
echo json_encode($usuarioModel->getAll());
