document.querySelectorAll('.password-toggle').forEach(toggle => {
    toggle.addEventListener('click', function() {
        const passwordInput = this.previousElementSibling;
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