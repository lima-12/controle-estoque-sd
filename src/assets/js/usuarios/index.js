document.addEventListener('DOMContentLoaded', function() {
    carregarUsuarios();
});

function carregarUsuarios() {
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
            <button class="btn btn-sm btn-outline-primary me-2" onclick="editarUsuario(${usuario.id})">
                <i class="fas fa-edit"></i> Editar
            </button>
            <button class="btn btn-sm btn-outline-danger" onclick="excluirUsuario(${usuario.id})">
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

function editarUsuario(id) {
    // Implementar edição de usuário
    Swal.fire({
        icon: 'info',
        title: 'Funcionalidade em desenvolvimento',
        text: 'A edição de usuários será implementada em breve.'
    });
}

function excluirUsuario(id) {
    Swal.fire({
        title: 'Tem certeza?',
        text: "Esta ação não pode ser desfeita!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Implementar exclusão de usuário
            Swal.fire({
                icon: 'info',
                title: 'Funcionalidade em desenvolvimento',
                text: 'A exclusão de usuários será implementada em breve.'
            });
        }
    });
}
