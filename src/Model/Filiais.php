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
            ORDER BY nome ASC
        ";
        $stmt = $this->pdo->prepare($sql);
    
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        } catch (PDOException $e) {
            echo "Erro na consulta: " . $e->getMessage();
            return false;
        }
    }

    public function getById($id) {
        try {
            $sql = "
                SELECT 
                    id, nome, endereco, cidade, uf, created_at
                FROM filiais
                WHERE id = :id
            ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Erro ao buscar filial por ID: " . $e->getMessage());
            return false;
        }
    }

    public function getProdutosByFilial($filialId) {
        try {
            $sql = "
                SELECT 
                    p.id,
                    p.nome as produto_nome,
                    p.preco,
                    p.imagem,
                    pf.quantidade,
                    p.created_at
                FROM produtos p
                INNER JOIN produto_filial pf ON p.id = pf.produto_id
                WHERE pf.filial_id = :filial_id
                ORDER BY p.nome ASC
            ";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':filial_id', $filialId, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Erro ao buscar produtos da filial: " . $e->getMessage());
            return false;
        }
    }

    public function create($data) {
        try {
            $sql = "
                INSERT INTO filiais (nome, endereco, cidade, uf)
                VALUES (:nome, :endereco, :cidade, :uf)
            ";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':nome', $data['nome'], PDO::PARAM_STR);
            $stmt->bindParam(':endereco', $data['endereco'], PDO::PARAM_STR);
            $stmt->bindParam(':cidade', $data['cidade'], PDO::PARAM_STR);
            $stmt->bindParam(':uf', $data['uf'], PDO::PARAM_STR);
            
            if ($stmt->execute()) {
                return $this->pdo->lastInsertId();
            }
            
            return false;
            
        } catch (PDOException $e) {
            error_log("Erro ao criar filial: " . $e->getMessage());
            return false;
        }
    }

    public function update($data) {
        try {
            $sql = "
                UPDATE filiais 
                SET nome = :nome, endereco = :endereco, cidade = :cidade, uf = :uf
                WHERE id = :id
            ";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
            $stmt->bindParam(':nome', $data['nome'], PDO::PARAM_STR);
            $stmt->bindParam(':endereco', $data['endereco'], PDO::PARAM_STR);
            $stmt->bindParam(':cidade', $data['cidade'], PDO::PARAM_STR);
            $stmt->bindParam(':uf', $data['uf'], PDO::PARAM_STR);
            
            return $stmt->execute();
            
        } catch (PDOException $e) {
            error_log("Erro ao atualizar filial: " . $e->getMessage());
            return false;
        }
    }

    public function delete($id) {
        try {
            // Inicia transação para garantir consistência
            $this->pdo->beginTransaction();
            
            // Primeiro, deleta todos os registros de estoque da filial
            $deleteEstoqueSql = "DELETE FROM produto_filial WHERE filial_id = :id";
            $deleteEstoqueStmt = $this->pdo->prepare($deleteEstoqueSql);
            $deleteEstoqueStmt->bindParam(':id', $id, PDO::PARAM_INT);
            $deleteEstoqueStmt->execute();
            
            // Agora deleta a filial
            $sql = "DELETE FROM filiais WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $result = $stmt->execute();
            
            if ($result) {
                $this->pdo->commit();
                return true;
            } else {
                $this->pdo->rollBack();
                return false;
            }
            
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log("Erro ao excluir filial: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("Erro ao excluir filial: " . $e->getMessage());
            return false;
        }
    }
}