// ============================================
// JAVASCRIPT PARA TELA DE CRIAÇÃO DE FILIAIS
// Seguindo padrão visual e funcionalidade do sistema
// ============================================

// Função para obter a URL base
function getBaseUrl() {
    const script = document.currentScript || document.querySelector('script[src*="create.js"]');
    if (script) {
        const src = script.src;
        const basePath = src.substring(0, src.lastIndexOf('/assets/'));
        return basePath;
    }
    return '';
}

const baseUrl = getBaseUrl();

// Configurar formulário quando a página carregar
document.addEventListener('DOMContentLoaded', function() {
    setupForm();
});

// Função para configurar o formulário
function setupForm() {
    const form = document.getElementById('filialForm');
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        if (validateForm()) {
            await submitForm();
        }
    });
}

// Função para validar o formulário
function validateForm() {
    const nome = document.getElementById('nome').value.trim();
    const endereco = document.getElementById('endereco').value.trim();
    const cidade = document.getElementById('cidade').value.trim();
    const uf = document.getElementById('uf').value;
    
    // Limpar validações anteriores
    clearValidation();
    
    let isValid = true;
    
    // Validar nome
    if (nome.length < 3) {
        showValidationError('nome', 'Nome deve ter pelo menos 3 caracteres');
        isValid = false;
    }
    
    // Validar endereço
    if (endereco.length < 5) {
        showValidationError('endereco', 'Endereço deve ter pelo menos 5 caracteres');
        isValid = false;
    }
    
    // Validar cidade
    if (cidade.length < 2) {
        showValidationError('cidade', 'Cidade deve ter pelo menos 2 caracteres');
        isValid = false;
    }
    
    // Validar estado
    if (!uf) {
        showValidationError('uf', 'Selecione um estado');
        isValid = false;
    }
    
    return isValid;
}

// Função para mostrar erro de validação
function showValidationError(fieldId, message) {
    const field = document.getElementById(fieldId);
    const feedback = document.createElement('div');
    
    field.classList.add('is-invalid');
    feedback.className = 'invalid-feedback';
    feedback.textContent = message;
    
    field.parentNode.appendChild(feedback);
}

// Função para limpar validações
function clearValidation() {
    const fields = ['nome', 'endereco', 'cidade', 'uf'];
    
    fields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        const feedback = field.parentNode.querySelector('.invalid-feedback');
        
        field.classList.remove('is-invalid', 'is-valid');
        
        if (feedback) {
            feedback.remove();
        }
    });
}

// Função para enviar o formulário
async function submitForm() {
    const form = document.getElementById('filialForm');
    const submitBtn = form.querySelector('button[type="submit"]');
    
    try {
        // Desabilitar botão e mostrar loading
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Salvando...';
        
        // Coletar dados do formulário
        const formData = new FormData(form);
        const data = {
            nome: formData.get('nome').trim(),
            endereco: formData.get('endereco').trim(),
            cidade: formData.get('cidade').trim(),
            uf: formData.get('uf')
        };
        
        // Enviar requisição
        const response = await fetch(`${baseUrl}/controllers/filialController.php?action=create`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const result = await response.json();
        
        if (result.success) {
            // Sucesso
            Swal.fire({
                title: 'Sucesso!',
                text: 'Filial criada com sucesso!',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                // Redirecionar para a lista de filiais
                window.location.href = './index.php';
            });
        } else {
            throw new Error(result.message || 'Erro ao criar filial');
        }
        
    } catch (error) {
        console.error('Erro ao criar filial:', error);
        
        Swal.fire({
            title: 'Erro!',
            text: error.message || 'Erro ao criar filial. Tente novamente.',
            icon: 'error'
        });
        
    } finally {
        // Reabilitar botão
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fas fa-save me-2"></i>Salvar Filial';
    }
}

// Função para confirmar saída sem salvar
function confirmExit() {
    const form = document.getElementById('filialForm');
    const formData = new FormData(form);
    
    // Verificar se há dados no formulário
    const hasData = Array.from(formData.values()).some(value => value.trim() !== '');
    
    if (hasData) {
        return Swal.fire({
            title: 'Sair sem salvar?',
            text: 'Você tem alterações não salvas. Deseja sair mesmo assim?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sim, sair',
            cancelButtonText: 'Cancelar'
        });
    }
    
    return Promise.resolve({ isConfirmed: true });
}

// Configurar confirmação antes de sair
window.addEventListener('beforeunload', function(e) {
    const form = document.getElementById('filialForm');
    const formData = new FormData(form);
    
    // Verificar se há dados no formulário
    const hasData = Array.from(formData.values()).some(value => value.trim() !== '');
    
    if (hasData) {
        e.preventDefault();
        e.returnValue = '';
    }
});

// Configurar links de navegação
document.addEventListener('click', function(e) {
    if (e.target.tagName === 'A' && e.target.href && !e.target.href.includes('#')) {
        const form = document.getElementById('filialForm');
        const formData = new FormData(form);
        
        // Verificar se há dados no formulário
        const hasData = Array.from(formData.values()).some(value => value.trim() !== '');
        
        if (hasData) {
            e.preventDefault();
            
            confirmExit().then((result) => {
                if (result.isConfirmed) {
                    window.location.href = e.target.href;
                }
            });
        }
    }
});
