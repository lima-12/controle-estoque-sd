
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.search-form');
    const input = form.querySelector('input[type="search"]');
    const produtosGrid = document.getElementById('produtos-grid');
    const noProducts = document.getElementById('no-products');

    function buscarProdutos(busca = '') {
        fetch(`../../controllers/produtoController.php?busca=${encodeURIComponent(busca)}`)
            .then(response => response.json())
            .then(produtos => {
                produtosGrid.innerHTML = '';
                
                if (produtos.length === 0) {
                    noProducts.classList.remove('d-none');
                    return;
                }
                
                noProducts.classList.add('d-none');
                
                produtos.forEach(produto => {
                    // Determinar status do estoque
                    let classeStatus, textoStatus;
                    if (produto.quantidade == 0) {
                        classeStatus = 'bg-danger text-white';
                        textoStatus = 'Esgotado';
                    } else if (produto.quantidade <= 20) {
                        classeStatus = 'bg-warning text-dark';
                        textoStatus = 'Estoque Baixo';
                    } else {
                        classeStatus = 'bg-success text-white';
                        textoStatus = 'Disponível';
                    }

                    produtosGrid.innerHTML += `
                        <div class="produto-card">
                            <div class="produto-status">
                                <span class="badge ${classeStatus}">${textoStatus}</span>
                            </div>
                            
                            <div class="produto-image-container">
                                <img src="../../assets/img/produtos/${produto.imagem}" alt="${produto.nome}">
                            </div>
                            
                            <div class="produto-info">
                                <h5 class="produto-nome">${produto.nome}</h5>
                                <p class="produto-categoria">${produto.categoria || 'Sem categoria'}</p>
                                <p class="produto-codigo">Código: ${produto.codigo_barras || 'N/A'}</p>
                                <div class="produto-preco">R$ ${parseFloat(produto.preco).toLocaleString('pt-BR', {minimumFractionDigits: 2})}</div>
                                <a href="show.php?id=${produto.id}" class="btn-detalhes">
                                    <i class="fas fa-eye me-2"></i>Ver Detalhes
                                </a>
                            </div>
                        </div>
                    `;
                });
            })
            .catch(error => {
                console.error('Erro ao buscar produtos:', error);
                produtosGrid.innerHTML = '';
                noProducts.classList.remove('d-none');
                noProducts.innerHTML = `
                    <i class="fas fa-exclamation-triangle"></i>
                    <p>Erro ao carregar produtos</p>
                `;
            });
    }

    // Busca inicial
    buscarProdutos();

    // Ao submeter o formulário
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        buscarProdutos(input.value);
    });

    // Busca em tempo real (opcional)
    input.addEventListener('input', function() {
        const busca = this.value.trim();
        if (busca.length >= 2 || busca.length === 0) {
            buscarProdutos(busca);
        }
    });
});