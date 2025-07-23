
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const input = form.querySelector('input[type="search"]');
    const row = document.querySelector('.row');

    function buscarProdutos(busca = '') {
        fetch(`../../controllers/produtoController.php?busca=${encodeURIComponent(busca)}`)
            .then(response => response.json())
            .then(produtos => {
                row.innerHTML = '';
                produtos.forEach(produto => {
                    row.innerHTML += `
                        <div class="col-sm-12 col-md-4 col-lg-3 mb-4">
                            <div class="card h-100">
                                <div style="height:180px; display:flex; align-items:center; justify-content:center;">
                                    <img src="/src/assets/img/produtos/${produto.imagem}" class="img-fluid" alt="${produto.nome}" style="max-height: 180px;">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">${produto.nome}</h5>
                                    <p class="card-text">Preço: R$ ${parseFloat(produto.preco).toLocaleString('pt-BR', {minimumFractionDigits: 2})}</p>
                                    <p class="card-text">Quantidade: ${produto.quantidade}</p>
                                    <a href="/src/views/produto/show.php?id=${produto.id}" class="btn btn-primary mt-2">Detalhes</a>
                                </div>
                            </div>
                        </div>
                    `;
                });
            });
    }

    // Busca inicial
    buscarProdutos();

    // Ao submeter o formulário
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        buscarProdutos(input.value);
    });
});