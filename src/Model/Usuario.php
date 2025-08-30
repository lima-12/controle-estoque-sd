<?php

namespace App\model;

use PDO;
use PDOException;
use App\config\Conexao;

require_once __DIR__ . '/../config/Conexao.php';

class Usuario {

    private $pdo;

    public function __construct()
    {
        // echo "debug";
        try {
            $conexao = new Conexao();
            $this->pdo = $conexao->pdo;
            
            // Debug: Test the connection
            error_log("Usuario::__construct - Database connection established");
            
            // Test if the usuarios table exists
            $stmt = $this->pdo->query("SHOW TABLES LIKE 'usuarios'");
            $tableExists = $stmt->rowCount() > 0;
            error_log("Usuario::__construct - Table 'usuarios' exists: " . ($tableExists ? 'YES' : 'NO'));
            
            if ($tableExists) {
                // Test if we can query the table
                $stmt = $this->pdo->query("SELECT COUNT(*) FROM usuarios");
                $count = $stmt->fetchColumn();
                error_log("Usuario::__construct - Current user count: $count");
            }
            
        } catch (Exception $e) {
            error_log("Usuario::__construct - Error: " . $e->getMessage());
            throw $e;
        }
    }


    function getAll(){

        try {
            $stmt = $this->pdo->query('SELECT * FROM usuarios');
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro na consulta: " . $e->getMessage();
            return false;
        }
    }

    function find($email=null, $id=null){

        // echo'<pre>'; print_r($email); echo'</pre>'; exit;

        if ($email) {
            $stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE email = ?;');
            $stmt->bindValue(1, $email, PDO::PARAM_STR);
            $stmt->execute();
        } elseif ($id) {
            $stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE id = ?;');
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    function search($searchTerm) {
        try {
            $searchTerm = '%' . $searchTerm . '%';
            
            $stmt = $this->pdo->prepare('
                SELECT * FROM usuarios 
                WHERE nome LIKE ? 
                OR email LIKE ? 
                OR telefone LIKE ?
                ORDER BY nome ASC
            ');
            
            $stmt->bindValue(1, $searchTerm, PDO::PARAM_STR);
            $stmt->bindValue(2, $searchTerm, PDO::PARAM_STR);
            $stmt->bindValue(3, $searchTerm, PDO::PARAM_STR);
            
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Usuario::search - PDO Exception: " . $e->getMessage());
            return false;
        }
    } 

    function insert($nome, $email, $senha, $telefone = null){

        try {
            // Debug: Log the attempt
            error_log("Usuario::insert - Attempting to insert: nome=$nome, email=$email, telefone=$telefone");
            
            $stmt = $this->pdo->prepare("
                INSERT INTO usuarios 
                    (
                        nome, 
                        email, 
                        senha,
                        telefone
                    ) 
                VALUES 
                    (
                        :nome, 
                        :email, 
                        :senha,
                        :telefone
                    )
            ");
    
            // Vincula os parâmetros
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':senha', $senha);
            $stmt->bindParam(':telefone', $telefone);
    
            // Debug: Log before execute
            error_log("Usuario::insert - About to execute statement");
            
            // Executa a declaração
            $result = $stmt->execute();
            
            // Debug: Log the result
            error_log("Usuario::insert - Execute result: " . var_export($result, true));
            
            return $result;
    
            // Retorna o ID do último registro inserido, se necessário
            // return $this->pdo->lastInsertId();
        } catch(PDOException $e) {
            // Se houver uma exceção, imprime o erro
            error_log("Usuario::insert - PDO Exception: " . $e->getMessage());
            return "Erro: " . $e->getMessage();
        }

    }

    function update($id, $nome, $email, $senha = null, $telefone = null){
        try {
            if ($senha) {
                $stmt = $this->pdo->prepare("
                    UPDATE usuarios 
                    SET
                        nome        = :nome,
                        email       = :email, 
                        senha       = :senha,
                        telefone    = :telefone
                    WHERE id = :id
                ");
                $stmt->bindParam(':senha', $senha);
            } else {
                $stmt = $this->pdo->prepare("
                    UPDATE usuarios 
                    SET
                        nome        = :nome,
                        email       = :email,
                        telefone    = :telefone
                    WHERE id = :id
                ");
            }
            
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':telefone', $telefone);
            $stmt->bindParam(':id', $id);
            
            $stmt->execute();
            
            return true;

        } catch(PDOException $e) {
            
            return "Erro: " . $e->getMessage();

        }
    }    

    function delete($id){

        try {
            $stmt = $this->pdo->prepare('DELETE FROM usuarios WHERE id = :id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            return true;

        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
            return false;

        }
    }

    // function verifica($email, $id) {
    //     $stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE email = ? AND senha = ?');
    //     $stmt->bindValue(1, $email, PDO::PARAM_STR);
    //     $stmt->bindValue(2, $id, PDO::PARAM_INT);
        
    //     $stmt->execute();

    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    // function updateRecuperaSenha($chave_recuperar_senha, $id) {
    //     try {

    //         $stmt = $this->pdo->prepare('
    //             UPDATE usuarios 
    //             SET recuperar_senha = :recuperar_senha 
    //             WHERE id = :id
    //         ');

    //         $stmt->bindParam(':recuperar_senha', $chave_recuperar_senha, PDO::PARAM_STR);
    //         $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    //         $stmt->execute();

    //         return true;

    //     } catch(PDOException $e) {
    //         return "Erro: " . $e->getMessage();
    //     }
    // }

    // function getRecuperaSenha($hash) {

    //     try {

    //         $stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE recuperar_senha = :recuperar_senha');
    //         $stmt->bindParam(':recuperar_senha', $hash, PDO::PARAM_STR);

    //         $stmt->execute();
    
    //         return $stmt->fetchAll(PDO::FETCH_ASSOC);

    //     } catch(PDOException $e) {
    //         return "Erro: " . $e->getMessage();
    //     }

    // }

    // function alterSenha($senha, $id) {
    //     try {
    //         $stmt = $this->pdo->prepare('
    //             UPDATE usuarios 
    //             SET 
    //                 senha       = :senha_usuario,
    //                 recuperar_senha     = :recuperar_senha
    //             WHERE id = :id
    //         ');

    //         $stmt->bindParam(':senha_usuario', $senha, PDO::PARAM_STR);
    //         $stmt->bindValue(':recuperar_senha', NULL, PDO::PARAM_NULL);
    //         $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    //         $stmt->execute();
    
    //         return true;

    //     } catch(PDOException $e) {
    //         return "Erro: " . $e->getMessage();
    //     }
    // }

}