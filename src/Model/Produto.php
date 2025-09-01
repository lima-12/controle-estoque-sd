<?php

namespace App\model;

use PDO;
use PDOException;
use Exception;
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

    /**
     * Registra a entrada de um produto no estoque de uma filial
     * 
     * @param int $produtoId ID do produto
     * @param int $filialId ID da filial
     * @param int $quantidade Quantidade a ser adicionada (deve ser maior que zero)
     * @return array Resultado da operação
     */
    public function registrarEntrada($produtoId, $filialId, $quantidade)
    {
        try {
            // Validações
            if ($quantidade <= 0) {
                throw new Exception('A quantidade deve ser maior que zero');
            }

            // Inicia transação
            $this->pdo->beginTransaction();

            // Verifica se já existe um registro para este produto e filial
            $stmt = $this->pdo->prepare(
                'SELECT id, quantidade FROM produto_filial 
                 WHERE produto_id = :produto_id AND filial_id = :filial_id'
            );
            $stmt->execute([
                ':produto_id' => $produtoId,
                ':filial_id' => $filialId
            ]);
            
            $registro = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($registro) {
                // Atualiza a quantidade existente
                $novaQuantidade = $registro['quantidade'] + $quantidade;
                $stmt = $this->pdo->prepare(
                    'UPDATE produto_filial 
                     SET quantidade = :quantidade 
                     WHERE id = :id'
                );
                $stmt->execute([
                    ':quantidade' => $novaQuantidade,
                    ':id' => $registro['id']
                ]);
            } else {
                // Cria um novo registro
                $stmt = $this->pdo->prepare(
                    'INSERT INTO produto_filial (produto_id, filial_id, quantidade) 
                     VALUES (:produto_id, :filial_id, :quantidade)'
                );
                $stmt->execute([
                    ':produto_id' => $produtoId,
                    ':filial_id' => $filialId,
                    ':quantidade' => $quantidade
                ]);
            }

            // Registra o movimento no histórico (se houver uma tabela para isso)
            // $this->registrarMovimento($produtoId, $filialId, $quantidade, 'entrada');

            $this->pdo->commit();
            
            return [
                'success' => true,
                'message' => 'Entrada de produto registrada com sucesso!'
            ];
            
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return [
                'success' => false,
                'message' => 'Erro ao registrar entrada de produto: ' . $e->getMessage()
            ];
        }
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

    public function criarProduto($dados) {
        try {
            $this->pdo->beginTransaction();
            
            // 1. Salva a imagem se houver
            $nomeImagem = null;
            if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
                $nomeImagem = $this->processarUploadImagem($_FILES['imagem']);
            }
            
            // 2. Insere o produto
            $sql = "INSERT INTO produtos (nome, preco, imagem) VALUES (:nome, :preco, :imagem)";
            $stmt = $this->pdo->prepare($sql);
            
            $stmt->execute([
                ':nome' => $dados['nome'],
                ':preco' => $dados['preco'],
                ':imagem' => $nomeImagem
            ]);
            
            $produtoId = $this->pdo->lastInsertId();
            
            $this->pdo->commit();
            return ['success' => true, 'id' => $produtoId];
            
        } catch (Exception $e) {
            $this->pdo->rollBack();
            // Remove a imagem se o upload foi feito mas ocorreu um erro
            if (isset($caminhoImagem) && file_exists($caminhoImagem)) {
                unlink($caminhoImagem);
            }
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    public function atualizarProduto($dados, $arquivoImagem = null) {
        error_log('Iniciando atualização do produto. Dados: ' . print_r($dados, true));
        error_log('Arquivo de imagem: ' . print_r($arquivoImagem, true));
        
        try {
            $this->pdo->beginTransaction();
            
            // 1. Processa o upload da nova imagem, se fornecida
            $nomeImagem = null;
            $caminhoImagem = null;
            
            if ($arquivoImagem && $arquivoImagem['error'] === UPLOAD_ERR_OK) {
                // Remove a imagem antiga, se existir
                if (!empty($dados['imagem_atual'])) {
                    $caminhoImagemAntiga = __DIR__ . '/../../assets/img/produtos/' . $dados['imagem_atual'];
                    if (file_exists($caminhoImagemAntiga)) {
                        unlink($caminhoImagemAntiga);
                    }
                }
                
                // Faz upload da nova imagem
                $nomeImagem = $this->processarUploadImagem($arquivoImagem);
            } elseif (!empty($dados['imagem_atual'])) {
                // Mantém a imagem atual se não for fornecida uma nova
                $nomeImagem = $dados['imagem_atual'];
            }
            
            // 2. Atualiza os dados do produto
            $sql = "UPDATE produtos SET 
                    nome = :nome, 
                    preco = :preco" . 
                    ($nomeImagem !== null ? ", imagem = :imagem" : "") . 
                    " WHERE id = :id";
                    
            error_log('SQL de atualização: ' . $sql);
                    
            $stmt = $this->pdo->prepare($sql);
            
            $params = [
                ':id' => $dados['id'],
                ':nome' => $dados['nome'],
                ':preco' => $dados['preco']
            ];
            
            if ($nomeImagem !== null) {
                $params[':imagem'] = $nomeImagem;
            }
            
            $result = $stmt->execute($params);
            $rowCount = $stmt->rowCount();
            
            $this->pdo->commit();
            
            error_log('Atualização concluída. Linhas afetadas: ' . $rowCount);
            return ['success' => true, 'id' => $dados['id']];
            
        } catch (Exception $e) {
            $this->pdo->rollBack();
            // Remove a imagem se o upload foi feito mas ocorreu um erro
            if (isset($caminhoImagem) && file_exists($caminhoImagem)) {
                unlink($caminhoImagem);
            }
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
    
    /**
     * Processa o upload de uma imagem e retorna o nome do arquivo
     */
    private function processarUploadImagem($arquivo) {
        $extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
        $nomeImagem = uniqid('produto_') . '.' . $extensao;
        $caminhoImagem = __DIR__ . '/../../assets/img/produtos/' . $nomeImagem;
        
        if (!is_dir(dirname($caminhoImagem))) {
            mkdir(dirname($caminhoImagem), 0755, true);
        }
        
        if (!move_uploaded_file($arquivo['tmp_name'], $caminhoImagem)) {
            throw new Exception('Falha ao fazer upload da imagem');
        }
        
        return $nomeImagem;
    }
    
    /**
     * Exclui um produto do banco de dados
     * 
     * @param int $id ID do produto a ser excluído
     * @return array Resultado da operação
     */
    public function excluirProduto($id) {
        try {
            error_log('Iniciando exclusão do produto ID: ' . $id);
            $this->pdo->beginTransaction();
            
            // 1. Primeiro, verifica se o produto existe
            $sqlVerificaProduto = "SELECT id FROM produtos WHERE id = :id";
            $stmtVerificaProduto = $this->pdo->prepare($sqlVerificaProduto);
            $stmtVerificaProduto->execute([':id' => $id]);
            
            if ($stmtVerificaProduto->rowCount() === 0) {
                $erro = 'Produto não encontrado';
                error_log($erro);
                return [
                    'success' => false,
                    'error' => $erro
                ];
            }
            
            // 2. Verifica se existem produtos em estoque
            $sqlVerificaEstoque = "SELECT COUNT(*) as total FROM produto_filial WHERE produto_id = :produto_id AND quantidade > 0";
            error_log('SQL verificação de estoque: ' . $sqlVerificaEstoque . ' (ID: ' . $id . ')');
            
            $stmtVerificaEstoque = $this->pdo->prepare($sqlVerificaEstoque);
            $stmtVerificaEstoque->execute([':produto_id' => $id]);
            $resultado = $stmtVerificaEstoque->fetch(PDO::FETCH_ASSOC);
            
            error_log('Resultado da verificação de estoque: ' . print_r($resultado, true));
            
            // Se houver produtos em estoque, não permite a exclusão
            if ($resultado && $resultado['total'] > 0) {
                $erro = 'Não é possível excluir o produto pois existem itens em estoque.';
                error_log($erro);
                return [
                    'success' => false,
                    'error' => $erro
                ];
            }
            
            // 3. Primeiro, remove as relações na tabela produto_filial
            $sqlDeleteRelacionamentos = "DELETE FROM produto_filial WHERE produto_id = :produto_id";
            $stmtDeleteRelacionamentos = $this->pdo->prepare($sqlDeleteRelacionamentos);
            $stmtDeleteRelacionamentos->execute([':produto_id' => $id]);
            error_log('Relacionamentos removidos: ' . $stmtDeleteRelacionamentos->rowCount());
            
            // 4. Agora remove o produto
            $sqlDeleteProduto = "DELETE FROM produtos WHERE id = :id";
            error_log('SQL de exclusão: ' . $sqlDeleteProduto . ' (ID: ' . $id . ')');
            
            $stmtProduto = $this->pdo->prepare($sqlDeleteProduto);
            $resultadoDelete = $stmtProduto->execute([':id' => $id]);
            $linhasAfetadas = $stmtProduto->rowCount();
            
            error_log('Resultado da exclusão: ' . ($resultadoDelete ? 'sucesso' : 'falha'));
            error_log('Linhas afetadas: ' . $linhasAfetadas);
            
            if ($linhasAfetadas === 0) {
                throw new Exception('Nenhum produto foi excluído. Verifique se o ID está correto.');
            }
            
            $this->pdo->commit();
            
            $mensagem = 'Produto excluído com sucesso!';
            error_log($mensagem);
            
            return [
                'success' => true,
                'message' => $mensagem
            ];
            
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return [
                'success' => false,
                'error' => 'Erro ao excluir o produto: ' . $e->getMessage()
            ];
        }
    }
}