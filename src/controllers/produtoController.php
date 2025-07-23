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

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    echo json_encode($produtoModel->getDetalhesComFiliais($id));
    exit;
}