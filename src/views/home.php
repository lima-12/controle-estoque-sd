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

        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>

        <link rel="stylesheet" href="../assets/css/style.css">
        <link rel="stylesheet" href="../assets/css/components/navbar.css">

        <title> Dashboard </title>
        <!-- <style>
            body { padding-top: 60px; }
        </style> -->
    </head>

<body style="background-color: #f8f9fa">
	<?php include_once(__DIR__ . '/components/navbar.php'); ?>

	<?php 
		$breadcrumbs = [
			['label' => 'Home']
		];
		include_once(__DIR__ . '/components/breadcrumb.php');
	?>
	
	<div class="container mt-4">
		<h2 class="mb-4">Dashboard de Controle</h2>

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
						<p class="text-muted mb-0">Conteúdo a definir. Este bloco ficará ao lado da tabela no desktop e abaixo no mobile.</p>
					</div>
				</div>
			</div>
		</div>

	</div>



</body>

<script>
	document.addEventListener('DOMContentLoaded', function () {
		if (window.DataTable) {
			new DataTable('#tabela-estoque-critico', {
				paging: true,
				pageLength: 5,
				lengthChange: false,
				searching: true,
				info: true,
				order: [],
				responsive: true
			});
		}
	});
</script>