document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.produtos-navbar .d-flex');
    const input = form ? form.querySelector('input[type="search"]') : null;
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
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="produto-quantidade">Quantidade: ${produto.quantidade}</span>
                                    <div class="d-flex gap-1">
                                        <button class="btn btn-sm btn-outline-primary btn-editar" data-produto-id="${produto.id}" title="Editar">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger btn-excluir" data-produto-id="${produto.id}" title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="produto-preco">R$ ${parseFloat(produto.preco).toLocaleString('pt-BR', {minimumFractionDigits: 2})}</div>
                                <a href="./show.php?id=${produto.id}" class="btn-detalhes">
                                    <i class="fas fa-eye me-2"></i>Ver Detalhes
                                </a>
                            </div>
                        </div>
                    `;
                });

                // Adicionar event listeners para os botões após renderizar os cards
                adicionarEventListeners();
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

    function adicionarEventListeners() {
        // Event listeners para botões de editar
        document.querySelectorAll('.btn-editar').forEach(btn => {
            btn.addEventListener('click', function() {
                const produtoId = this.getAttribute('data-produto-id');
                console.log('Editar produto ID:', produtoId);
                // TODO: Implementar modal de edição
                alert('Funcionalidade de edição será implementada em breve!');
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

    if (form && input) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            buscarProdutos(input.value);
        });

        input.addEventListener('input', function() {
            const busca = this.value.trim();
            if (busca.length >= 2 || busca.length === 0) {
                buscarProdutos(busca);
            }
        });
    }
});
