// ============================================
// JAVASCRIPT PARA TELA DE DETALHES DA FILIAL
// Seguindo padrão visual e funcionalidade do sistema
// ============================================

// Função para obter a URL base
function getBaseUrl() {
    const script = document.currentScript || document.querySelector('script[src*="show.js"]');
    if (script) {
        const src = script.src;
        const basePath = src.substring(0, src.lastIndexOf('/assets/'));
        return basePath;
    }
    return '';
}

const baseUrl = getBaseUrl();

// Obter ID da filial da URL
function getFilialId() {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get('id');
}

// Carregar dados da filial ao iniciar a página
document.addEventListener('DOMContentLoaded', function() {
    loadFilialDetails();
    loadProdutosFilial();
});

// Função para carregar detalhes da filial
async function loadFilialDetails() {
    const detailsContainer = document.getElementById('filial-details');
    const filialId = getFilialId();
    
    if (!filialId) {
        showError('ID da filial não fornecido');
        return;
    }
    
    try {
        const response = await fetch(`${baseUrl}/controllers/filialController.php?action=getById&id=${filialId}`);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success && data.filial) {
            renderFilialDetails(data.filial);
        } else {
            throw new Error(data.message || 'Filial não encontrada');
        }
        
    } catch (error) {
        console.error('Erro ao carregar detalhes da filial:', error);
        showError('Erro ao carregar detalhes da filial. Tente novamente.');
    }
}

// Função para renderizar detalhes da filial
function renderFilialDetails(filial) {
    const detailsContainer = document.getElementById('filial-details');
    const createdDate = new Date(filial.created_at).toLocaleDateString('pt-BR');
    
    const detailsHTML = `
        <div class="filial-details-content">
            <div class="filial-header mb-4">
                <div class="filial-icon-large">
                    <i class="fas fa-building"></i>
                </div>
                <div class="filial-title">
                    <h3 class="mb-1">${escapeHtml(filial.nome)}</h3>
                    <p class="text-muted mb-0">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        ${escapeHtml(filial.cidade)} - ${escapeHtml(filial.uf)}
                    </p>
                </div>
            </div>
            
            <div class="filial-info-grid">
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-building me-2"></i>Nome da Filial
                    </div>
                    <div class="info-value">${escapeHtml(filial.nome)}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-map-marker-alt me-2"></i>Endereço
                    </div>
                    <div class="info-value">${escapeHtml(filial.endereco)}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-city me-2"></i>Cidade
                    </div>
                    <div class="info-value">${escapeHtml(filial.cidade)}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-flag me-2"></i>Estado
                    </div>
                    <div class="info-value">${escapeHtml(filial.uf)}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-calendar me-2"></i>Data de Criação
                    </div>
                    <div class="info-value">${createdDate}</div>
                </div>
                
                <div class="info-item">
                    <div class="info-label">
                        <i class="fas fa-hashtag me-2"></i>ID da Filial
                    </div>
                    <div class="info-value">#${filial.id}</div>
                </div>
            </div>
        </div>
    `;
    
    detailsContainer.innerHTML = detailsHTML;
}

// Função para carregar produtos da filial
async function loadProdutosFilial() {
    const produtosContainer = document.getElementById('produtos-filial');
    const filialId = getFilialId();
    
    if (!filialId) {
        showProdutosError('ID da filial não fornecido');
        return;
    }
    
    try {
        const response = await fetch(`${baseUrl}/controllers/filialController.php?action=getProdutosByFilial&id=${filialId}`);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success) {
            renderProdutosFilial(data.produtos || []);
        } else {
            throw new Error(data.message || 'Erro ao carregar produtos');
        }
        
    } catch (error) {
        console.error('Erro ao carregar produtos da filial:', error);
        showProdutosError('Erro ao carregar produtos da filial. Tente novamente.');
    }
}

// Função para renderizar produtos da filial
function renderProdutosFilial(produtos) {
    const produtosContainer = document.getElementById('produtos-filial');
    
    if (produtos.length === 0) {
        produtosContainer.innerHTML = `
            <div class="text-center text-muted">
                <i class="fas fa-box-open fa-2x mb-3"></i>
                <p>Esta filial não possui produtos em estoque.</p>
            </div>
        `;
        return;
    }
    
    const produtosHTML = `
        <div class="produtos-list">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Produto</th>
                            <th>Preço</th>
                            <th class="text-center">Quantidade</th>
                            <th class="text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${produtos.map(produto => `
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        ${produto.imagem ? 
                                            `<img src="../../assets/img/produtos/${produto.imagem}" alt="${escapeHtml(produto.produto_nome)}" class="produto-img me-3" style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px;">` 
                                            : 
                                            `<div class="produto-placeholder me-3" style="width: 40px; height: 40px; background: #f8f9fa; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-box text-muted"></i>
                                            </div>`
                                        }
                                        <div>
                                            <strong>${escapeHtml(produto.produto_nome)}</strong>
                                            <br>
                                            <small class="text-muted">ID: #${produto.id}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>R$ ${parseFloat(produto.preco).toFixed(2).replace('.', ',')}</td>
                                <td class="text-center">
                                    <span class="badge bg-primary">${produto.quantidade}</span>
                                </td>
                                <td class="text-center">
                                    <strong>R$ ${(parseFloat(produto.preco) * parseInt(produto.quantidade)).toFixed(2).replace('.', ',')}</strong>
                                </td>
                            </tr>
                        `).join('')}
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="2"><strong>Total Geral:</strong></td>
                            <td class="text-center">
                                <strong class="text-primary">${produtos.reduce((total, produto) => total + parseInt(produto.quantidade), 0)}</strong>
                            </td>
                            <td class="text-center">
                                <strong class="text-success">R$ ${produtos.reduce((total, produto) => total + (parseFloat(produto.preco) * parseInt(produto.quantidade)), 0).toFixed(2).replace('.', ',')}</strong>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    `;
    
    produtosContainer.innerHTML = produtosHTML;
}

// Função para mostrar erro nos produtos
function showProdutosError(message) {
    const produtosContainer = document.getElementById('produtos-filial');
    produtosContainer.innerHTML = `
        <div class="text-center text-danger">
            <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
            <p>${message}</p>
        </div>
    `;
}

// Função para excluir filial
async function deleteFilial(id) {
    const result = await Swal.fire({
        title: 'Confirmar exclusão',
        text: 'Tem certeza que deseja excluir esta filial? Esta ação também removerá todo o estoque associado a esta filial.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sim, excluir filial e estoque',
        cancelButtonText: 'Cancelar',
        footer: '<span class="text-warning"><i class="fas fa-exclamation-triangle"></i> Atenção: Todo o estoque desta filial será perdido permanentemente!</span>'
    });
    
    if (result.isConfirmed) {
        try {
            const response = await fetch(`${baseUrl}/controllers/filialController.php?action=delete&id=${id}`, {
                method: 'DELETE'
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            
            if (data.success) {
                Swal.fire({
                    title: 'Sucesso!',
                    text: 'Filial e todo o seu estoque foram excluídos com sucesso.',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    // Redirecionar para a lista de filiais
                    window.location.href = './index.php';
                });
            } else {
                throw new Error(data.message || 'Erro ao excluir filial');
            }
            
        } catch (error) {
            console.error('Erro ao excluir filial:', error);
            Swal.fire({
                title: 'Erro!',
                text: error.message || 'Erro ao excluir filial. Tente novamente.',
                icon: 'error'
            });
        }
    }
}

// Função para mostrar erro
function showError(message) {
    const detailsContainer = document.getElementById('filial-details');
    detailsContainer.innerHTML = `
        <div class="text-center text-danger">
            <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
            <p>${message}</p>
            <a href="./index.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Voltar à Lista
            </a>
        </div>
    `;
}

// Função para escapar HTML
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

