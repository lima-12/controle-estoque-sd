 const toggleButtons = document.querySelectorAll('.password-toggle');
    
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Encontra o input de senha relativo a este botão
            const inputGroup = this.closest('.input-group-custom');
            const passwordInput = inputGroup.querySelector('.password-input');
            const icon = this.querySelector('i');
            
            // Alterna o tipo do input e o ícone
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    });

document.addEventListener('DOMContentLoaded', function() {
    // 1. Encontre todos os inputs de senha na página
    const senhaInputs = document.querySelectorAll('input[type="password"]');
    
    // 2. Verifique se existem pelo menos 2 campos de senha
    if (senhaInputs.length >= 2) {
        const senhaPrincipal = senhaInputs[0];
        const confirmacaoSenha = senhaInputs[1];
        const form = senhaPrincipal.closest('form');
        const submitButton = form.querySelector('button[type="submit"]');

        // 3. Função de validação
        function validarSenhas() {
            const saoIguais = senhaPrincipal.value === confirmacaoSenha.value;
            
            // Desabilita o botão se as senhas não coincidirem
            if (submitButton) {
                submitButton.disabled = !saoIguais;
            }
            
            return saoIguais;
        }

        // 4. Ouvintes de eventos
        senhaPrincipal.addEventListener('input', validarSenhas);
        confirmacaoSenha.addEventListener('input', validarSenhas);

        // 5. Validação no envio do formulário
        if (form) {
            form.addEventListener('submit', function(e) {
                if (!validarSenhas()) {
                    e.preventDefault();
                    alert('As senhas não coincidem!');
                }
            });
        }
    }
});

// Simulate loading on form submit
document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const button = document.getElementById('loginButton');
    const buttonText = document.getElementById('buttonText');
    
    // Show loading state
    button.disabled = true;
    button.innerHTML = '<span class="loading-spinner"></span> Entrando...';
    
    // Simulate API call
    setTimeout(function() {
        button.disabled = false;
        button.innerHTML = '<span id="buttonText">Entrar</span><i class="fas fa-arrow-right ms-2"></i>';
    }, 2000);
});