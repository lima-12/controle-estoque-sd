<?php
require_once __DIR__ . '/../config/Session.php';

// Verifica se o usuário está logado
Session::requireLogin();

// Obtém o usuário atual da sessão
$userAtual = Session::getUser();



// $aUsuarios = $sql->getAll();
$aUsuarios = [
    [
        'id' => 1, // Must match an ID in $userAtual if simulating that user as admin/self
        'nome' => 'Admin Teste',
        'email' => 'admin.teste@example.com',
        'telefone' => '11912345678',
        'data_nasc' => '1990-01-01',
        'cidade' => 'São Paulo',
        'estado' => 'SP',
        'endereco' => 'Rua Principal, 123 Admin City'
    ],
    [
        'id' => 2,
        'nome' => 'Joana Silva Frontend',
        'email' => 'joana.silva@example.com',
        'telefone' => '21987654321',
        'data_nasc' => '1992-05-15',
        'cidade' => 'Rio de Janeiro',
        'estado' => 'RJ',
        'endereco' => 'Avenida Atlântica, 456'
    ],
    [
        'id' => 3,
        'nome' => 'Carlos Pereira Backend',
        'email' => 'carlos.pereira@example.com',
        'telefone' => '31976543210',
        'data_nasc' => '1985-11-30',
        'cidade' => 'Belo Horizonte',
        'estado' => 'MG',
        'endereco' => 'Rua das Palmeiras, 789'
    ],
    [
        'id' => 4,
        'nome' => 'Ana Costa Designer',
        'email' => 'ana.costa@example.com',
        'telefone' => '71965432109',
        'data_nasc' => '1998-07-22',
        'cidade' => 'Salvador',
        'estado' => 'BA',
        'endereco' => 'Ladeira do Sol, 101'
    ],
];

?>

<?php include_once "components/header.php" ?>

	<body>
		
		<nav class="navbar bg-body-tertiary">
			<div class="container-fluid">
				<!-- <form class="d-flex" role="search">
					<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
					<button class="btn btn-outline-success" type="submit">Search</button>
				</form> -->
				
				<a href="../controllers/sair.php" class="btn btn-outline-danger">sair</a>
			</div>
		</nav>
		
		<?php include_once "components/message.php" ?>
		

		<h1 class="text-center"> Bem Vindo <?=$userAtual['nome']?> </h1>

		<div class="m-5">
			<table class="table table-hover" >
				<thead>
					<tr>
						<th scope="col" style="width: 52%;">nome</th>
						<th scope="col" style="width: 48%;">ação</th>
					</tr>
				</thead>

				<tbody>
					<?php foreach($aUsuarios as $user) { 

						// echo'<pre>'; print_r($user); echo'</pre>';

						// $valida = (($user['id'] === $userAtual[0]['id']) || ($userAtual[0]['admin'] == 1)) ? "" : "disabled";
						$valida = false;
					?>
						<tr>
							<td> 
								<?=$user['nome']?>
							</td>
							<td>	
								<button class='btn btn-sm btn-success' data-id="esconde<?=$user['id']?>" <?=$valida?>>
									<i style="color: white;" class="bi bi-plus"></i>
								</button>

								<form action="formulario.php" method="post" style="display: inline;">
									<input type="hidden" name="id" value="<?=$user['id']?>">
									<button class='btn btn-sm btn-primary btn-edit' <?=$valida?>>
										<i style="color: white;" class="bi bi-pencil"></i>
									</button>
								</form>
								
								<form action="../controllers/delete.php" method="post" style="display: inline;">
									<input type="hidden" name="id" value="<?=$user['id']?>">
									<button class='btn btn-sm btn-danger btn-delete' data-id="<?=$user['id']?>" <?=$valida?>>
										<i style="color: white;" class="bi bi-trash"></i>
									</button>
								</form>
							</td>
						</tr>
						<tr>
							<td colspan="2" id="esconde<?=$user['id']?>" style="display: none;">
								<table>
									<tr>
										<td><strong>Email: </strong></td>
										<td><?=$user['email']?></td>
									</tr>
									<tr>
										<td><strong>Telefone: </strong></td>
										<td><?=$user['telefone']?></td>
									</tr>
									<tr>
										<td><strong>Data de Nascimento: </strong></td>
										<td><?=$user['data_nasc']?></td>
									</tr>
									<tr>
										<td><strong>Cidade - Estado: </strong></td>
										<td><?=$user['cidade']?> - <?=$user['estado']?></td>
									</tr>
									<tr>
										<td><strong>Endereço: </strong></td>
										<td><?=$user['endereco']?></td>
									</tr>
								</table>
							</td>
						</tr>
					<?php } ?>
				</tbody>

			</table>

		</div>

	</body>

<?php include_once "components/footer.php" ?>

<script>

	// new DataTable('#tabela');

    $(document).ready(function() {

        $('.btn-delete').click(function(event) {
            // Evita o comportamento padrão do formulario
            event.preventDefault();

            // Encontra o formulário associado ao botão clicado
            var form = $(this).closest('form');
            var id = $(this).data('id');

            // Utilizando SweetAlert para a confirmação
            Swal.fire({
                title: 'Tem certeza?',
                text: 'Deseja excluir este registro?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Se confirmado, envia o formulário
                    form.submit();
                }
            });
        });

		$(".btn-success").click(function(){
			var id = $(this).data("id");
			$("#" + id).toggle(500);
			$(this).find('i').toggleClass('bi-plus bi-dash');
		});

    });
</script>
