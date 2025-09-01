// ============================================
// JAVASCRIPT PARA TELA DE FILIAIS
// Seguindo padrão visual e funcionalidade de usuários
// ============================================

let allFiliais = [];
let filteredFiliais = [];

// Função para obter a URL base
function getBaseUrl() {
    const script = document.currentScript || document.querySelector('script[src*="index.js"]');
    if (script) {
        const src = script.src;
        const basePath = src.substring(0, src.lastIndexOf('/assets/'));
        return basePath;
    }
    return '';
}

const baseUrl = getBaseUrl();

// Carregar filiais ao iniciar a página
document.addEventListener('DOMContentLoaded', function() {
    loadFiliais();
    setupSearch();
});

// Função para carregar filiais
async function loadFiliais() {
    const grid = document.getElementById('filiais-grid');
    const noFiliais = document.getElementById('no-filiais');
    
    try {
        // Mostrar loading
        grid.innerHTML = '<div class="text-center w-100"><i class="fas fa-spinner fa-spin"></i> Carregando filiais...</div>';
        
        const response = await fetch(`${baseUrl}/controllers/filialController.php?action=getAll`);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success) {
            allFiliais = data.filiais || [];
            filteredFiliais = [...allFiliais];
            renderFiliais();
        } else {
            throw new Error(data.message || 'Erro ao carregar filiais');
        }
        
    } catch (error) {
        console.error('Erro ao carregar filiais:', error);
        grid.innerHTML = `
            <div class="text-center w-100 text-danger">
                <i class="fas fa-exclamation-triangle"></i>
                <p>Erro ao carregar filiais. Tente novamente.</p>
            </div>
        `;
    }
}

// Função para renderizar filiais
function renderFiliais() {
    const grid = document.getElementById('filiais-grid');
    const noFiliais = document.getElementById('no-filiais');
    
    if (filteredFiliais.length === 0) {
        grid.classList.add('d-none');
        noFiliais.classList.remove('d-none');
        return;
    }
    
    grid.classList.remove('d-none');
    noFiliais.classList.add('d-none');
    
    const filiaisHTML = filteredFiliais.map(filial => createFilialCard(filial)).join('');
    grid.innerHTML = filiaisHTML;
}

// Função para criar card de filial
function createFilialCard(filial) {
    const createdDate = new Date(filial.created_at).toLocaleDateString('pt-BR');
    
    return `
        <div class="filial-card">
            <div class="filial-header">
                <div class="filial-icon">
                    <i class="fas fa-building"></i>
                </div>
                <div class="filial-info">
                    <h5>${escapeHtml(filial.nome)}</h5>
                    <div class="filial-location">
                        <i class="fas fa-map-marker-alt"></i>
                        ${escapeHtml(filial.cidade)} - ${escapeHtml(filial.uf)}
                    </div>
                </div>
            </div>
            
            <div class="filial-details">
                <div class="filial-detail">
                    <span class="filial-detail-label">Endereço:</span>
                    <span class="filial-detail-value">${escapeHtml(filial.endereco)}</span>
                </div>
                <div class="filial-detail">
                    <span class="filial-detail-label">Cidade:</span>
                    <span class="filial-detail-value">${escapeHtml(filial.cidade)}</span>
                </div>
                <div class="filial-detail">
                    <span class="filial-detail-label">Estado:</span>
                    <span class="filial-detail-value">${escapeHtml(filial.uf)}</span>
                </div>
                <div class="filial-detail">
                    <span class="filial-detail-label">Criado em:</span>
                    <span class="filial-detail-value">${createdDate}</span>
                </div>
            </div>
            
            <div class="filial-actions">
                <a href="./show.php?id=${filial.id}" class="filial-action-btn view">
                    <i class="fas fa-eye"></i> Visualizar
                </a>
                <a href="./update.php?id=${filial.id}" class="filial-action-btn edit">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <button onclick="deleteFilial(${filial.id}, '${escapeHtml(filial.nome)}')" class="filial-action-btn delete">
                    <i class="fas fa-trash"></i> Excluir
                </button>
            </div>
        </div>
    `;
}

// Função para configurar busca
function setupSearch() {
    const searchInput = document.getElementById('searchInput');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();
        
        if (searchTerm === '') {
            filteredFiliais = [...allFiliais];
        } else {
            filteredFiliais = allFiliais.filter(filial => 
                filial.nome.toLowerCase().includes(searchTerm) ||
                filial.cidade.toLowerCase().includes(searchTerm) ||
                filial.uf.toLowerCase().includes(searchTerm) ||
                filial.endereco.toLowerCase().includes(searchTerm)
            );
        }
        
        renderFiliais();
    });
}

// Função para atualizar filiais
function refreshFiliais() {
    loadFiliais();
}

// Função para excluir filial
async function deleteFilial(id, nome) {
    const result = await Swal.fire({
        title: 'Confirmar exclusão',
        text: `Tem certeza que deseja excluir a filial "${nome}"? Esta ação também removerá todo o estoque associado a esta filial.`,
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
                });
                
                // Recarregar filiais
                loadFiliais();
            } else {
                throw new Error(data.message || 'Erro ao excluir filial');
            }
            
        } catch (error) {
            console.error('Erro ao excluir filial:', error);
            Swal.fire({
                title: 'Erro!',
                text: 'Erro ao excluir filial e estoque. Tente novamente.',
                icon: 'error'
            });
        }
    }
}

// Função para escapar HTML
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
