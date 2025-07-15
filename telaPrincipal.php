<?php
// Simulando dados de produtos recentes
require_once 'produtosTeste.php';

$busca = $_GET['busca'] ?? '';
$categoria = $_GET['categoria'] ?? '';
$status = $_GET['status'] ?? '';
$periodo = $_GET['periodo'] ?? '';
$hoje = new DateTime();

$produtosRecentes = array_filter($produtosRecentes, function ($produto) use ($busca, $categoria, $status, $periodo, $hoje) {
  $nomeMatch = empty($busca) || stripos($produto['nome'], $busca) !== false;
  $categoriaMatch = empty($categoria) || $produto['categoria'] == $categoria;

  if ($produto['quantidade'] == 0) $statusProduto = 'Esgotado';
  elseif ($produto['quantidade'] <= 20) $statusProduto = 'Estoque Baixo';
  else $statusProduto = 'Disponível';

  $statusMatch = empty($status) || $statusProduto == $status;

  $dataProduto = new DateTime($produto['data']);
  if ($periodo === '7') {
    $limite = (clone $hoje)->modify('-7 days');
  } elseif ($periodo === '30') {
    $limite = (clone $hoje)->modify('-30 days');
  } elseif ($periodo === '180') {
    $limite = (clone $hoje)->modify('-180 days');
  } else {
    $limite = null;
  }

  $periodoMatch = !$limite || $dataProduto >= $limite;

  return $nomeMatch && $categoriaMatch && $statusMatch && $periodoMatch;
});
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Stok - Dashboard</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="src/assets/css/telaPrincipal.css" />
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f8f9fa;
    }
    .header {
      background: linear-gradient(to right, #f59e0b, #f97316);
      padding: 20px 30px;
      color: white;
      border-bottom-left-radius: 12px;
      border-bottom-right-radius: 12px;
    }
    .btn-flutuante {
      position: fixed;
      bottom: 30px;
      right: 30px;
      background-color: #2563eb;
      color: white;
      padding: 16px;
      border-radius: 50%;
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
      font-size: 24px;
      transition: 0.3s;
      z-index: 10;
    }
    .btn-flutuante:hover {
      transform: scale(1.1);
      background-color: #1d4ed8;
    }
    .status-disponivel {
      background-color: #dcfce7;
      color: #16a34a;
      padding: 4px 10px;
      border-radius: 20px;
      font-weight: 500;
    }
    .status-baixo {
      background-color: #fef9c3;
      color: #ca8a04;
      padding: 4px 10px;
      border-radius: 20px;
      font-weight: 500;
    }
    .status-esgotado {
      background-color: #fee2e2;
      color: #dc2626;
      padding: 4px 10px;
      border-radius: 20px;
      font-weight: 500;
    }
    .card {
      border-radius: 16px;
      border: none;
      box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    table thead {
      background-color: #f1f5f9;
    }
    table {
      border-radius: 12px;
      overflow: hidden;
    }
  </style>
</head>
<body>
  <div class="header d-flex justify-content-between align-items-center">
    <div>
      <h4 class="fw-bold">Dashboard</h4>
      <p class="mb-0">Bem-vindo ao sistema de controle de estoque</p>
    </div>
    <div class="d-flex align-items-center">
      <div class="me-2 text-end">
        <strong>João Silva</strong><br />
        <small>Administrador</small>
      </div>
    </div>
  </div>

  <div class="container my-4">
    <form method="GET" class="card p-4 mb-4">
      <div class="row g-2 align-items-center mb-3">
        <div class="col-auto">
          <button class="btn btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#filtroAvancado">
            <i class="fas fa-filter"></i>
          </button>
        </div>
        <div class="col">
          <input type="text" name="busca" class="form-control" placeholder="Buscar produtos..." value="<?= htmlspecialchars($busca) ?>">
        </div>
        <div class="col-auto">
          <button class="btn btn-primary" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>

      <div class="collapse" id="filtroAvancado">
        <div class="row g-2">
          <div class="col-md-4">
            <select name="categoria" class="form-select">
              <option value="">Categoria</option>
              <?php
              $categorias = ['Eletrônicos', 'Alimentação', 'Roupas', 'Livros', 'Higiene'];
              foreach ($categorias as $cat) {
                $selected = ($categoria === $cat) ? 'selected' : '';
                echo "<option value=\"$cat\" $selected>$cat</option>";
              }
              ?>
            </select>
          </div>

          <div class="col-md-4">
            <select name="periodo" class="form-select">
              <option value="">Período</option>
              <option value="7" <?= $periodo === '7' ? 'selected' : '' ?>>Últimos 7 dias</option>
              <option value="30" <?= $periodo === '30' ? 'selected' : '' ?>>Últimos 30 dias</option>
              <option value="180" <?= $periodo === '180' ? 'selected' : '' ?>>Últimos 6 meses</option>
            </select>
          </div>

          <div class="col-md-4">
            <select name="status" class="form-select">
              <option value="">Status</option>
              <option value="Disponível" <?= $status === 'Disponível' ? 'selected' : '' ?>>Disponível</option>
              <option value="Estoque Baixo" <?= $status === 'Estoque Baixo' ? 'selected' : '' ?>>Estoque Baixo</option>
              <option value="Esgotado" <?= $status === 'Esgotado' ? 'selected' : '' ?>>Esgotado</option>
            </select>
          </div>
        </div>
        <div class="mt-3 text-end">
          <button class="btn btn-sm btn-primary" type="submit">Aplicar Filtros</button>
        </div>
      </div>
    </form>

    <h5 class="fw-semibold">Produtos Recentes</h5>
    <div class="table-responsive mb-4">
      <table class="table align-middle">
        <thead>
          <tr>
            <th>Nome</th>
            <th>Categoria</th>
            <th>Quantidade</th>
            <th>Status</th>
            <th>Data</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($produtosRecentes as $produto): ?>
            <tr>
              <td><?= htmlspecialchars($produto['nome']) ?></td>
              <td><?= htmlspecialchars($produto['categoria']) ?></td>
              <td><?= $produto['quantidade'] ?></td>
              <td>
                <?php
                if ($produto['quantidade'] == 0) {
                  $classeStatus = 'status-esgotado';
                  $textoStatus = 'Esgotado';
                } elseif ($produto['quantidade'] <= 20) {
                  $classeStatus = 'status-baixo';
                  $textoStatus = 'Estoque Baixo';
                } else {
                  $classeStatus = 'status-disponivel';
                  $textoStatus = 'Disponível';
                }
                ?>
                <span class="<?= $classeStatus ?>"><?= $textoStatus ?></span>
              </td>
              <td><?= date("d/m/Y", strtotime($produto['data'])) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <a href="cadastroProdutos.php" class="btn-flutuante" title="Cadastrar Produto">
      <i class="fas fa-circle-plus"></i>
    </a>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>