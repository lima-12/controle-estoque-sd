<?php

namespace App\model;

use PDO;
use PDOException;
use Exception;
use App\config\Conexao;

require_once __DIR__ . '/../config/Conexao.php';

class Filiais {

    private $pdo;

    public function __construct()
    {
        // echo "debug";
        $conexao = new Conexao();
        $this->pdo = $conexao->pdo;
    }


    public function getAll() {
        try {
        $sql = "
            SELECT 
                id, nome, endereco, cidade, uf, created_at
            FROM filiais
        ";
        $stmt = $this->pdo->prepare($sql);
    
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        } catch (PDOException $e) {
            echo "Erro na consulta: " . $e->getMessage();
            return false;
        }
    }

}