<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Stok - Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f8f9fa;
    }

    .header {

    }

    .card-summary {
      border: 1px solid #dee2e6;
      border-left: 4px solid #0d6efd;
      border-radius: 8px;
      padding: 20px;
      background-color: #fff;
    }

    .status-disponivel {
      background-color: #d1e7dd;
      color: #0f5132;
      padding: 4px 10px;
      border-radius: 10px;
      font-size: 0.875rem;
    }

    .status-baixo {
      background-color: #fff3cd;
      color: #664d03;
      padding: 4px 10px;
      border-radius: 10px;
      font-size: 0.875rem;
    }

    .status-esgotado {
      background-color: #f8d7da;
      color: #842029;
      padding: 4px 10px;
      border-radius: 10px;
      font-size: 0.875rem;
    }

    .btn-acao {
      border-radius: 8px;
    }

    .alerta {
      border-left: 4px solid #ffc107;
      background-color: #fffbe6;
      padding: 10px 15px;
      border-radius: 5px;
      margin-bottom: 10px;
    }

    .btn-flutuante {
      position: fixed;
      bottom: 30px;
      right: 30px;
      background-color: #0d6efd;
      color: white;
      border: none;
      width: 55px;
      height: 55px;
      border-radius: 16px 50% 50% 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
      z-index: 999;
    }
    .btn-flutuante:hover {
      background-color: #0b5ed7;
    }
  </style>
</head>

<body>
  <div class="container my-4">
    <!-- Header -->
    <div class=" header d-flex justify-content-between align-items-center mb-4">
      <div>
        <h4>Dashboard</h4>
        <p class="text-muted">Bem-vindo ao sistema de controle de estoque</p>
      </div>
      <div class="d-flex align-items-center">
        <!-- <i class="fas fa-bell me-3 position-relative">
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
        </i> -->
        <div class="me-2 text-end">
          <strong>João Silva</strong><br>
          <small class="text-muted">Administrador</small>
        </div>
        <!-- <img src="https://via.placeholder.com/40" class="rounded-circle" alt="Avatar"> -->
      </div>
    </div>

    <!-- Filtro -->
    <div class="card p-3 mb-4">
      <div class="input-group mb-2">
        <input type="text" class="form-control" placeholder="Buscar produtos...">
      </div>
      <button class="btn btn-outline-secondary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#filtroAvancado" aria-expanded="false" aria-controls="filtroAvancado">
        <i class="fas fa-filter"></i> Filtros
      </button>
      <div class="collapse mt-3" id="filtroAvancado">
        <div class="row g-2">
          <div class="col-md-4">
            <select class="form-select">
              <option selected>Categoria</option>
              <option>Eletrônicos</option>
              <option>Alimentação</option>
              <option>Roupas</option>
              <option>Livros</option>
            </select>
          </div>
          <div class="col-md-4">
            <select class="form-select">
              <option selected>Período</option>
              <option>Últimos 7 dias</option>
              <option>Últimos 30 dias</option>
              <option>Este mês</option>
            </select>
          </div>
          <div class="col-md-4">
            <select class="form-select">
              <option selected>Status</option>
              <option>Disponível</option>
              <option>Estoque Baixo</option>
              <option>Esgotado</option>
            </select>
          </div>
        </div>
        <div class="mt-3 text-end">
          <button class="btn btn-sm btn-primary">Aplicar Filtros</button>
        </div>
      </div>
    </div>

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
          <tr>
            <td>Smartphone Galaxy S24</td>
            <td>Eletrônicos</td>
            <td>45</td>
            <td><span class="status-disponivel">Disponível</span></td>
            <td>14/01/2024</td>
          </tr>
          <tr>
            <td>Notebook Dell Inspiron</td>
            <td>Eletrônicos</td>
            <td>12</td>
            <td><span class="status-baixo">Estoque Baixo</span></td>
            <td>13/01/2024</td>
          </tr>
          <tr>
            <td>Camiseta Nike</td>
            <td>Roupas</td>
            <td>0</td>
            <td><span class="status-esgotado">Esgotado</span></td>
            <td>12/01/2024</td>
          </tr>
          <tr>
            <td>Café Premium</td>
            <td>Alimentação</td>
            <td>156</td>
            <td><span class="status-disponivel">Disponível</span></td>
            <td>11/01/2024</td>
          </tr>
          <tr>
            <td>Livro React Avançado</td>
            <td>Livros</td>
            <td>28</td>
            <td><span class="status-disponivel">Disponível</span></td>
            <td>10/01/2024</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Botão flutuante de ação -->
    <a href="cadastroProdutos.php" class="btn-flutuante" title="Cadastrar Produto">
      <i class="fas fa-plus"></i>
    </a>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>