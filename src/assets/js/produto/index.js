document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.querySelector('.search-form-container');
    const searchInput = document.getElementById('searchInput');
    const produtosGrid = document.getElementById('produtos-grid');
    const noProducts = document.getElementById('no-products');

    if (!searchForm || !searchInput || !produtosGrid || !noProducts) {
        console.error('Algum elemento não foi encontrado no DOM!');
        return;
    }

    // Função para buscar produtos do PHP
    function buscarProdutos(busca = '') {
        const url = `../../controllers/produtoController.php?busca=${encodeURIComponent(busca)}`;
        fetch(url)
            .then(r => r.json())
            .then(produtos => {
                popularGrid(produtos, busca);
            })
            .catch(err => {
                console.error('Erro ao buscar produtos:', err);
                produtosGrid.innerHTML = '';
                noProducts.classList.remove('d-none');
                noProducts.innerHTML = `<i class="fas fa-exclamation-triangle"></i><p>Erro ao carregar produtos</p>`;
            });
    }

    // Função para popular a grid de produtos
    function popularGrid(produtos, busca = '') {
        produtosGrid.innerHTML = '';

        if (!produtos || produtos.length === 0) {
            noProducts.classList.remove('d-none');
            noProducts.innerHTML = `
                <i class="fas fa-search"></i>
                <p>Nenhum produto encontrado${busca ? ` para "${busca}"` : ''}</p>
            `;
            return;
        }

        noProducts.classList.add('d-none');

        produtos.forEach(produto => {
            const quantidade = parseInt(produto.quantidade);
            const preco = parseFloat(produto.preco).toLocaleString('pt-BR', { minimumFractionDigits: 2 });
            let classeStatus = 'bg-success text-white';
            let textoStatus = 'Disponível';

            if (quantidade === 0) {
                classeStatus = 'bg-danger text-white';
                textoStatus = 'Esgotado';
            } else if (quantidade <= 20) {
                classeStatus = 'bg-warning text-dark';
                textoStatus = 'Estoque Baixo';
            }

            const imagem = produto.imagem ? `../../assets/img/produtos/${produto.imagem}` : '../../assets/img/produtos/default.png';

            produtosGrid.innerHTML += `
                <div class="produto-card">
                    <div class="produto-status">
                        <span class="badge ${classeStatus}">${textoStatus}</span>
                    </div>
                    <div class="produto-image-container">
                        <img src="${imagem}" alt="${produto.nome}">
                    </div>
                    <div class="produto-info">
                        <h5 class="produto-nome">${produto.nome}</h5>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="produto-quantidade">Quantidade: ${quantidade}</span>
                        </div>
                        <div class="produto-preco">R$ ${preco}</div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mt-auto gap-2">
                        <a href="./show.php?id=${produto.id}" class="btn btn-stok-primary btn-lg flex-grow-1">
                            <i class="fas fa-eye me-2"></i>Ver Detalhes
                        </a>
                        <button class="btn btn-lg btn-outline-primary btn-editar" data-produto-id="${produto.id}" title="Editar">
                            <i class="fas fa-pencil-alt"></i>
                        </button>
                        <button class="btn btn-lg btn-outline-danger btn-excluir" data-produto-id="${produto.id}" title="Excluir">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
        });
        
        // Adiciona os event listeners após popular a grade
        adicionarEventListeners();
    }

    function adicionarEventListeners() {
        console.log('Configurando event listeners...');
        // Event listeners para botões de editar
        document.querySelectorAll('.btn-editar').forEach(btn => {
            btn.addEventListener('click', function() {
                const produtoId = this.getAttribute('data-produto-id');
                console.log('Editar produto ID:', produtoId);
                
                // Obtém o caminho base da URL atual
                const currentPath = window.location.pathname;
                const basePath = currentPath.substring(0, currentPath.lastIndexOf('/'));
                
                // Monta a URL de redirecionamento
                const url = `${basePath}/update.php?id=${produtoId}`;
                console.log('Redirecionando para:', url);
                
                // Redireciona para a página de edição com o ID do produto
                window.location.href = url;
            });
        });

        // Event listeners para botões de excluir
        document.querySelectorAll('.btn-excluir').forEach(btn => {
            btn.addEventListener('click', function() {
                const produtoId = this.getAttribute('data-produto-id');
                console.log('Excluir produto ID:', produtoId);
                
                // SweetAlert para confirmar exclusão
                Swal.fire({
                    title: 'Tem certeza?',
                    text: "Você não poderá reverter esta ação!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sim, excluir!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // TODO: Implementar requisição AJAX para exclusão
                        console.log('Produto será excluído:', produtoId);
                        
                        // Simulação de resposta do servidor
                        Swal.fire(
                            'Excluído!',
                            'Produto foi excluído com sucesso.',
                            'success'
                        );
                    }
                });
            });
        });
    }

    buscarProdutos();

    // Evento da barra de pesquisa
    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const termo = searchInput.value.trim();
        buscarProdutos(termo);
    });
    
    // Adiciona os event listeners iniciais
    adicionarEventListeners();
});
