document.addEventListener('DOMContentLoaded', function() {
    const toggleButtons = document.querySelectorAll('.password-toggle');
    
    toggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const inputGroup = this.closest('.input-group-custom');
            const passwordInput = inputGroup.querySelector('.password-input');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    });

    const senhaInputs = document.querySelectorAll('input[type="password"]');
    
    if (senhaInputs.length >= 2) {
        const senhaPrincipal = senhaInputs[0];
        const confirmacaoSenha = senhaInputs[1];
        const form = senhaPrincipal.closest('form');
        const submitButton = form.querySelector('button[type="submit"]');

        function validarSenhas() {
            const saoIguais = senhaPrincipal.value === confirmacaoSenha.value;
            const senhasPreenchidas = senhaPrincipal.value !== '' && confirmacaoSenha.value !== '';

            if (submitButton) {
                submitButton.disabled = !(saoIguais && senhasPreenchidas);
            }
            
            if (senhasPreenchidas && !saoIguais) {
                confirmacaoSenha.classList.add('is-invalid');
                senhaPrincipal.classList.add('is-invalid');
            } else {
                confirmacaoSenha.classList.remove('is-invalid');
                senhaPrincipal.classList.remove('is-invalid');
            }
            
            return saoIguais;
        }

        senhaPrincipal.addEventListener('input', validarSenhas);
        confirmacaoSenha.addEventListener('input', validarSenhas);

        validarSenhas();

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