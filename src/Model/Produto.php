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

    public function getDashboardData() {
        try {
            $sql = "
                SELECT 
                    COUNT(p.id) AS total_produtos,
                    SUM(CASE WHEN pf.quantidade = 0 THEN 1 ELSE 0 END) AS produtos_esgotados,
                    SUM(CASE WHEN pf.quantidade > 0 AND pf.quantidade <= 10 THEN 1 ELSE 0 END) AS produtos_estoque_baixo,
                    SUM(p.preco * pf.quantidade) AS valor_total_estoque
                FROM produtos p
                LEFT JOIN produto_filial pf ON p.id = pf.produto_id
            ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
    
        } catch (PDOException $e) {
            // Em um projeto real, o ideal seria logar o erro
            return false;
        }
    }
    
    public function getProdutosCriticos() {
        try {
            $sql = "
                SELECT 
                    p.nome AS produto_nome,
                    f.nome AS filial_nome,
                    pf.quantidade
                FROM produto_filial pf
                JOIN produtos p ON pf.produto_id = p.id
                JOIN filiais f ON pf.filial_id = f.id
                WHERE pf.quantidade <= 10
                ORDER BY pf.quantidade ASC
                LIMIT 10
            ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        } catch (PDOException $e) {
            return false;
        }
    }

}