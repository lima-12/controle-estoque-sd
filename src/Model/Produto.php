<?php

namespace App\model;

use PDO;
use PDOException;
use App\config\Conexao;

require_once __DIR__ . '/../config/Conexao.php';

class Produto {

    private $pdo;

    public function __construct()
    {
        // echo "debug";
        $conexao = new Conexao();
        $this->pdo = $conexao->pdo;
    }


    public function getAll($busca = null) {
        try {
            if ($busca) {
                $sql = "
                    SELECT 
                        p.id, p.nome, p.preco, p.imagem,
                        COALESCE(SUM(pf.quantidade), 0) AS quantidade
                    FROM produtos p
                    LEFT JOIN produto_filial pf ON p.id = pf.produto_id
                    WHERE p.nome LIKE :busca
                    GROUP BY p.id, p.nome, p.preco, p.imagem
                ";
                $stmt = $this->pdo->prepare($sql);
                $busca = '%' . $busca . '%';
                $stmt->bindParam(':busca', $busca, PDO::PARAM_STR);
            } else {
                $sql = "
                    SELECT 
                        p.id, p.nome, p.preco, p.imagem,
                        COALESCE(SUM(pf.quantidade), 0) AS quantidade
                    FROM produtos p
                    LEFT JOIN produto_filial pf ON p.id = pf.produto_id
                    GROUP BY p.id, p.nome, p.preco, p.imagem
                ";
                $stmt = $this->pdo->prepare($sql);
            }
    
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro na consulta: " . $e->getMessage();
            return false;
        }
    }

    public function getDetalhesComFiliais($id) {
        try {
            $sqlProduto = "SELECT id, nome, preco, imagem FROM produtos WHERE id = :id";
            $stmt = $this->pdo->prepare($sqlProduto);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $produto = $stmt->fetch(PDO::FETCH_ASSOC);
    
            $sqlFiliais = "
                SELECT 
                    f.id, f.nome, pf.quantidade
                FROM filiais f
                LEFT JOIN produto_filial pf ON f.id = pf.filial_id AND pf.produto_id = :id
            ";
            $stmt = $this->pdo->prepare($sqlFiliais);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $filiais = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            $produto['filiais'] = $filiais;
            return $produto;
    
        } catch (PDOException $e) {
            return ['erro' => $e->getMessage()];
        }
    }

}