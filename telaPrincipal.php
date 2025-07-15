<?php
// Simulando dados de produtos recentes
$produtosRecentes = [
  ["nome" => "Smartphone Galaxy S24", "categoria" => "Eletrônicos", "quantidade" => 45, "data" => "2024-01-14"],
  ["nome" => "Notebook Dell Inspiron", "categoria" => "Eletrônicos", "quantidade" => 12, "data" => "2024-01-13"],
  ["nome" => "Camiseta Nike", "categoria" => "Roupas", "quantidade" => 0, "data" => "2024-01-12"],
  ["nome" => "Café Premium", "categoria" => "Alimentação", "quantidade" => 156, "data" => "2024-01-11"],
  ["nome" => "Livro React Avançado", "categoria" => "Livros", "quantidade" => 28, "data" => "2024-01-10"],
  ["nome" => "Sabonete", "categoria" => "Higiene", "quantidade" => 5, "data" => "2025-07-14"]
];

// Filtros recebidos via GET
$busca = $_GET['busca'] ?? '';
$categoria = $_GET['categoria'] ?? '';
$status = $_GET['status'] ?? '';
$periodo = $_GET['periodo'] ?? '';

// Data atual
$hoje = new DateTime();

// Aplica filtro
$produtosRecentes = array_filter($produtosRecentes, function ($produto) use ($busca, $categoria, $status, $periodo, $hoje) {
  $nomeMatch = empty($busca) || stripos($produto['nome'], $busca) !== false;
  $categoriaMatch = empty($categoria) || $produto['categoria'] == $categoria;

  // Define status atual do produto
  if ($produto['quantidade'] == 0) $statusProduto = 'Esgotado';
  elseif ($produto['quantidade'] <= 20) $statusProduto = 'Estoque Baixo';
  else $statusProduto = 'Disponível';

  $statusMatch = empty($status) || $statusProduto == $status;

  // Verifica o filtro por período
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="src/assets/css/telaPrincipal.css" />
</head>

<body>
  <!-- Header -->
  <div class="header d-flex justify-content-between align-items-center">
    <div>
      <h4>Dashboard</h4>
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
    <!-- Filtro e busca -->
    <form method="GET" class="card p-3 mb-4">
      <div class="row g-2 align-items-center mb-2">
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

      <div class="collapse show" id="filtroAvancado">
        <div class="row g-2">
          <!-- Categoria -->
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

          <!-- Período -->
          <div class="col-md-4">
            <select name="periodo" class="form-select">
              <option value="">Período</option>
              <option value="7" <?= $periodo === '7' ? 'selected' : '' ?>>Últimos 7 dias</option>
              <option value="30" <?= $periodo === '30' ? 'selected' : '' ?>>Últimos 30 dias</option>
              <option value="180" <?= $periodo === '180' ? 'selected' : '' ?>>Últimos 6 meses</option>
            </select>
          </div>

          <!-- Status -->
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

    <!-- Tabela de Produtos -->
    <h5>Produtos Recentes</h5>
    <div class="table-responsive mb-4">
      <table class="table">
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

    <!-- Botão de adicionar -->
    <a href="cadastroProdutos.php" class="btn-flutuante" title="Cadastrar Produto">
      <i class="fas fa-circle-plus"></i>
    </a>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
