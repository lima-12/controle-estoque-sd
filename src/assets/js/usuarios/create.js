document.addEventListener('DOMContentLoaded', function() {
    setupFormValidation();
});

function setupFormValidation() {
    const form = document.getElementById('form-usuario');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (validateForm()) {
            createUser();
        }
    });
}

function validateForm() {
    const nome = document.getElementById('nome').value.trim();
    const email = document.getElementById('email').value.trim();
    const senha = document.getElementById('senha').value;
    const confirmarSenha = document.getElementById('confirmar_senha').value;
    
    // Validação do nome
    if (nome.length < 2) {
        Swal.fire({
            icon: 'error',
            title: 'Erro de Validação',
            text: 'O nome deve ter pelo menos 2 caracteres.'
        });
        return false;
    }
    
    // Validação do email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        Swal.fire({
            icon: 'error',
            title: 'Erro de Validação',
            text: 'Por favor, insira um email válido.'
        });
        return false;
    }
    
    // Validação da senha
    if (senha.length < 6) {
        Swal.fire({
            icon: 'error',
            title: 'Erro de Validação',
            text: 'A senha deve ter pelo menos 6 caracteres.'
        });
        return false;
    }
    
    // Validação da confirmação de senha
    if (senha !== confirmarSenha) {
        Swal.fire({
            icon: 'error',
            title: 'Erro de Validação',
            text: 'As senhas não coincidem!'
        });
        return false;
    }
    
    return true;
}

function createUser() {
    const telefoneValue = document.getElementById('telefone').value.trim();
    const formData = {
        nome: document.getElementById('nome').value.trim(),
        email: document.getElementById('email').value.trim(),
        senha: document.getElementById('senha').value,
        telefone: telefoneValue === '' ? null : telefoneValue
    };
    
    // Mostrar loading
    Swal.fire({
        title: 'Cadastrando usuário...',
        text: 'Aguarde um momento.',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    fetch('../../controllers/usuarioController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(result => {
        if (result.success) {
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: result.success,
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirecionar para a lista de usuários
                    window.location.href = './index.php';
                }
            });
        } else {
            throw new Error(result.error || 'Erro desconhecido');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        Swal.fire({
            icon: 'error',
            title: 'Erro!',
            text: error.message || 'Erro ao cadastrar usuário. Tente novamente.'
        });
    });
}

// Função para limpar o formulário
function clearForm() {
    document.getElementById('form-usuario').reset();
}

// Função para voltar à lista de usuários
function goBack() {
    window.location.href = './index.php';
}
