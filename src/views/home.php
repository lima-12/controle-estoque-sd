<?php
	require_once __DIR__ . '/../config/Session.php';
	require_once __DIR__ . '/../Model/Produto.php';
	
	// Verifica se o usuário está logado
	Session::requireLogin();
	
	use App\model\Produto;

	$produtoModel = new Produto();
	$dashboardData = $produtoModel->getDashboardData();
	$produtosCriticos = $produtoModel->getProdutosCriticos();
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

        <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="../assets/css/style.css">
        <link rel="stylesheet" href="../assets/css/components/navbar.css">
        <link rel="stylesheet" href="../assets/css/home.css">

        <title> Dashboard </title>
    </head>

<body style="background-color: #f8f9fa">
	<?php include_once(__DIR__ . '/components/navbar.php'); ?>
	
	<div class="container mt-4">
		<h2 class="mb-4">Dashboard de Controle</h2>

		<!-- Cards de Resumo -->
		<div class="row">
			<div class="col-6 col-md-3 mb-4">
				<div class="card text-white bg-primary h-100">
					<div class="card-body">
						<h5 class="card-title">Total de Produtos</h5>
						<p class="card-text fs-4"><?= $dashboardData['total_produtos'] ?? '0' ?></p>
					</div>
				</div>
			</div>
			<div class="col-6 col-md-3 mb-4">
				<div class="card text-white bg-warning h-100">
					<div class="card-body">
						<h5 class="card-title">Estoque Baixo</h5>
						<p class="card-text fs-4"><?= $dashboardData['produtos_estoque_baixo'] ?? '0' ?></p>
					</div>
				</div>
			</div>
			<div class="col-6 col-md-3 mb-4">
				<div class="card text-white bg-danger h-100">
					<div class="card-body">
						<h5 class="card-title">Produtos Esgotados</h5>
						<p class="card-text fs-4"><?= $dashboardData['produtos_esgotados'] ?? '0' ?></p>
					</div>
				</div>
			</div>
			<div class="col-6 col-md-3 mb-4">
				<div class="card text-white bg-success h-100">
					<div class="card-body">
						<h5 class="card-title">Valor em Estoque</h5>
						<p class="card-text fs-4">R$ <?= number_format($dashboardData['valor_total_estoque'] ?? 0, 2, ',', '.') ?></p>
					</div>
				</div>
			</div>
		</div>

        <!-- NOVO: Linha para o Gráfico de Pizza -->


		<!-- Linha para as Tabelas -->
		<div class="row g-4">
			<div class="col-12 col-lg-6" id="produtos-estoque-critico">
				<div class="card h-100">
					<div class="card-header">Produtos com Estoque Crítico</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-striped table-hover align-middle" id="tabela-estoque-critico">
								<thead>
									<tr>
										<th>Produto</th>
										<th>Filial</th>
										<th>Qtd</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									<?php if (!empty($produtosCriticos)): ?>
										<?php foreach ($produtosCriticos as $produto): ?>
											<tr>
												<td><?= htmlspecialchars($produto['produto_nome']) ?></td>
												<td><?= htmlspecialchars($produto['filial_nome']) ?></td>
												<td><?= $produto['quantidade'] ?></td>
												<td>
													<?php if ($produto['quantidade'] == 0): ?>
														<span class="badge bg-danger">Esgotado</span>
													<?php else: ?>
														<span class="badge bg-warning text-dark">Estoque Baixo</span>
													<?php endif; ?>
												</td>
											</tr>
										<?php endforeach; ?>
									<?php else: ?>
										<tr>
											<td colspan="4" class="text-center">Nenhum produto com estoque crítico.</td>
										</tr>
									<?php endif; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 col-lg-6">
				<div class="card h-100">
					<div class="card-header">Outra Informação</div>
					<div class="card-body">
						<div class="alert alert-info text-center" id="noDataMessage" style="display: none;">
							<i class="fas fa-info-circle me-2"></i>
							Nenhum produto encontrado para gerar o gráfico.
						</div>
						<div class="d-flex flex-column justify-content-center align-items-center">
							<div class="chart-container">
								<canvas id="estoqueChart"></canvas>
							</div>
							<div id="custom-legend" class="chart-legend mt-3"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>
    
    <!-- Scripts do Gráfico -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    
    <!-- NOVO: Link para o JS da página Home -->
    <script src="../assets/js/home.js"></script>
</body>
</html>