<?php
    // echo "teste";exit();
    $title = 'Detalhes Produto';
?>


<?php include_once(__DIR__ . '/../components/header.php'); ?>

<body style="background-color: #f8f9fa">
    <?php include_once(__DIR__ . '/../components/navbar.php'); ?>
    <?php 
        $breadcrumbs = [
            ['label' => 'Produtos', 'href' => dirname($_SERVER['SCRIPT_NAME']) . '/index.php'],
            ['label' => 'Detalhes']
        ];
        include_once(__DIR__ . '/../components/breadcrumb.php');
    ?>
    
    <div class="container mt-4">
        <div id="produto-detalhes"></div>
    </div>
</body>

<?php include_once(__DIR__ . '/../components/footer.php'); ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');

    fetch(`../../controllers/produtoController.php?id=${id}`)
        .then(res => res.json())
        .then(produto => {
            const container = document.getElementById('produto-detalhes');
            let html = `
                <h2>${produto.nome}</h2>
                <img src="/src/assets/img/produtos/${produto.imagem}" class="img-fluid mb-3" style="max-height: 200px;">
                <p><strong>Preço:</strong> R$ ${parseFloat(produto.preco).toLocaleString('pt-BR', { minimumFractionDigits: 2 })}</p>

                <h4>Estoque por Filial</h4>
                <table class="table">
                    <thead><tr><th>Filial</th><th>Quantidade</th></tr></thead>
                    <tbody>
                        ${produto.filiais.map(f => `
                            <tr>
                                <td>${f.nome}</td>
                                <td>${f.quantidade ?? 0}</td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            `;
            container.innerHTML = html;
        });
});
</script>