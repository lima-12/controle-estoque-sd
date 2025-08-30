document.addEventListener('DOMContentLoaded', function() {
    carregarUsuarios();
    setupEventListeners();
});

function setupEventListeners() {
    // Search functionality with debouncing
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        let searchTimeout;
        
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.trim();
            
            // Clear previous timeout
            clearTimeout(searchTimeout);
            
            // Set new timeout for debouncing (300ms delay)
            searchTimeout = setTimeout(() => {
                if (searchTerm.length >= 2 || searchTerm.length === 0) {
                    searchUsers(searchTerm);
                }
            }, 300);
        });
        
        // Add clear search functionality
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                searchInput.value = '';
                searchUsers('');
            }
        });
    }
}

function carregarUsuarios() {
    // Hide search results indicator when loading all users
    const resultsIndicator = document.getElementById('search-results-indicator');
    if (resultsIndicator) {
        resultsIndicator.style.display = 'none';
    }
    
    fetch('../../controllers/usuarioController.php')
        .then(response => response.json())
        .then(data => {
            const usuariosGrid = document.getElementById('usuarios-grid');
            const noUsers = document.getElementById('no-users');
            
            if (data && data.length > 0) {
                usuariosGrid.innerHTML = '';
                data.forEach(usuario => {
                    usuariosGrid.appendChild(criarCardUsuario(usuario));
                });
                noUsers.classList.add('d-none');
            } else {
                usuariosGrid.innerHTML = '';
                noUsers.classList.remove('d-none');
            }
        })
        .catch(error => {
            console.error('Erro ao carregar usuários:', error);
            Swal.fire({
                icon: 'error',
                title: 'Erro',
                text: 'Erro ao carregar usuários. Tente novamente.'
            });
        });
}

function searchUsers(searchTerm) {
    const usuariosGrid = document.getElementById('usuarios-grid');
    const noUsers = document.getElementById('no-users');
    const searchInput = document.getElementById('searchInput');
    
    // Show loading state
    if (searchTerm.length > 0) {
        usuariosGrid.innerHTML = '<div class="text-center w-100"><i class="fas fa-spinner fa-spin"></i> Buscando...</div>';
    }
    
    fetch(`../../controllers/usuarioController.php?busca=${encodeURIComponent(searchTerm)}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(users => {
            if (users && users.length > 0) {
                usuariosGrid.innerHTML = '';
                users.forEach(usuario => {
                    usuariosGrid.appendChild(criarCardUsuario(usuario));
                });
                noUsers.classList.add('d-none');
                
                // Show search results count
                if (searchTerm.length > 0) {
                    showSearchResultsCount(users.length, searchTerm);
                }
            } else {
                usuariosGrid.innerHTML = '';
                noUsers.classList.remove('d-none');
                
                // Show no results message for search
                if (searchTerm.length > 0) {
                    noUsers.innerHTML = `
                        <i class="fas fa-search"></i>
                        <p>Nenhum usuário encontrado para "${searchTerm}"</p>
                        <button class="btn btn-outline-primary btn-sm" onclick="clearSearch()">
                            <i class="fas fa-times"></i> Limpar busca
                        </button>
                    `;
                } else {
                    noUsers.innerHTML = `
                        <i class="fas fa-users"></i>
                        <p>Nenhum usuário encontrado</p>
                    `;
                }
            }
        })
        .catch(error => {
            console.error('Erro na busca:', error);
            usuariosGrid.innerHTML = `
                <div class="text-center w-100 text-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    <p>Erro ao realizar busca. Tente novamente.</p>
                </div>
            `;
        });
}

function showSearchResultsCount(count, searchTerm) {
    // Create or update search results indicator
    let resultsIndicator = document.getElementById('search-results-indicator');
    if (!resultsIndicator) {
        resultsIndicator = document.createElement('div');
        resultsIndicator.id = 'search-results-indicator';
        resultsIndicator.className = 'alert alert-info alert-dismissible fade show mt-3';
        resultsIndicator.innerHTML = `
            <i class="fas fa-search"></i>
            <span id="search-results-text"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        const container = document.querySelector('.usuarios-container');
        container.insertBefore(resultsIndicator, document.getElementById('usuarios-grid'));
    }
    
    const resultsText = document.getElementById('search-results-text');
    resultsText.textContent = `${count} usuário(s) encontrado(s) para "${searchTerm}"`;
    resultsIndicator.style.display = 'block';
}

function clearSearch() {
    const searchInput = document.getElementById('searchInput');
    searchInput.value = '';
    searchUsers('');
    
    // Hide search results indicator
    const resultsIndicator = document.getElementById('search-results-indicator');
    if (resultsIndicator) {
        resultsIndicator.style.display = 'none';
    }
}

function criarCardUsuario(usuario) {
    const card = document.createElement('div');
    card.className = 'usuario-card';
    
    // Pega a primeira letra do nome para o avatar
    const primeiraLetra = usuario.nome ? usuario.nome.charAt(0).toUpperCase() : 'U';
    
    card.innerHTML = `
        <div class="usuario-header">
            <div class="usuario-avatar">
                <i class="fas fa-user"></i>
            </div>
            <div class="usuario-info">
                <h5>${usuario.nome || 'Nome não informado'}</h5>
                <p class="usuario-email">${usuario.email || 'Email não informado'}</p>
            </div>
        </div>
        <div class="usuario-details">
            ${usuario.telefone ? `
                <div class="usuario-detail">
                    <span class="usuario-detail-label">Telefone:</span>
                    <span class="usuario-detail-value">${usuario.telefone}</span>
                </div>
            ` : ''}
            ${usuario.cidade ? `
                <div class="usuario-detail">
                    <span class="usuario-detail-label">Cidade:</span>
                    <span class="usuario-detail-value">${usuario.cidade}</span>
                </div>
            ` : ''}
            ${usuario.estado ? `
                <div class="usuario-detail">
                    <span class="usuario-detail-label">Estado:</span>
                    <span class="usuario-detail-value">${usuario.estado}</span>
                </div>
            ` : ''}
            ${usuario.data_nasc ? `
                <div class="usuario-detail">
                    <span class="usuario-detail-label">Data de Nascimento:</span>
                    <span class="usuario-detail-value">${formatarData(usuario.data_nasc)}</span>
                </div>
            ` : ''}
        </div>
        <div class="mt-3">
            <button class="btn btn-sm btn-outline-primary me-2" onclick="editarUsuario(${usuario.id}, '${usuario.nome}', '${usuario.email}')">
                <i class="fas fa-edit"></i> Editar
            </button>
            <button class="btn btn-sm btn-outline-danger" onclick="excluirUsuario(${usuario.id}, '${usuario.nome}')">
                <i class="fas fa-trash"></i> Excluir
            </button>
        </div>
    `;
    
    return card;
}

function formatarData(data) {
    if (!data) return '';
    const dataObj = new Date(data);
    return dataObj.toLocaleDateString('pt-BR');
}

function editarUsuario(id, nome, email) {
    // Show edit modal using SweetAlert2
    Swal.fire({
        title: 'Editar Usuário',
        html: `
            <form id="editUserForm">
                <div class="form-group mb-3">
                    <label for="editNome" class="form-label">Nome Completo *</label>
                    <input type="text" class="form-control" id="editNome" value="${nome}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="editEmail" class="form-label">Email *</label>
                    <input type="email" class="form-control" id="editEmail" value="${email}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="editSenha" class="form-label">Nova Senha (deixe em branco para manter)</label>
                    <input type="password" class="form-control" id="editSenha">
                </div>
            </form>
        `,
        showCancelButton: true,
        confirmButtonText: 'Salvar',
        cancelButtonText: 'Cancelar',
        preConfirm: () => {
            const nome = document.getElementById('editNome').value;
            const email = document.getElementById('editEmail').value;
            const senha = document.getElementById('editSenha').value;
            
            if (!nome || !email) {
                Swal.showValidationMessage('Nome e email são obrigatórios');
                return false;
            }
            
            return { nome, email, senha };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            updateUser(id, result.value);
        }
    });
}

function updateUser(id, userData) {
    const data = {
        id: id,
        nome: userData.nome,
        email: userData.email,
        senha: userData.senha
    };

    fetch('../../controllers/usuarioController.php', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: result.success
            });
            carregarUsuarios();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                text: result.error
            });
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        Swal.fire({
            icon: 'error',
            title: 'Erro!',
            text: 'Erro ao atualizar usuário'
        });
    });
}

function excluirUsuario(id, nome) {
    Swal.fire({
        title: 'Tem certeza?',
        text: `Tem certeza que deseja excluir o usuário ${nome}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            deleteUser(id);
        }
    });
}

function deleteUser(id) {
    const userData = { id: id };

    fetch('../../controllers/usuarioController.php', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(userData)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: result.success
            });
            carregarUsuarios();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                text: result.error
            });
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        Swal.fire({
            icon: 'error',
            title: 'Erro!',
            text: 'Erro ao deletar usuário'
        });
    });
}

function refreshUsers() {
    // Clear search input
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.value = '';
    }
    
    // Hide search results indicator
    const resultsIndicator = document.getElementById('search-results-indicator');
    if (resultsIndicator) {
        resultsIndicator.style.display = 'none';
    }
    
    // Reset no-users message
    const noUsers = document.getElementById('no-users');
    if (noUsers) {
        noUsers.innerHTML = `
            <i class="fas fa-users"></i>
            <p>Nenhum usuário encontrado</p>
        `;
    }
    
    carregarUsuarios();
}
