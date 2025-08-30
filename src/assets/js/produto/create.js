document.addEventListener('DOMContentLoaded', function() {
    const uploadArea = document.getElementById('area-upload');
    const fileInput = document.getElementById('inputArquivo');

    if (uploadArea && fileInput) {
        // Drag and drop functionality
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            const file = e.dataTransfer.files[0];
            if (file) {
                fileInput.files = e.dataTransfer.files;
                updateUploadText(file.name);
                console.log('Imagem arrastada:', file.name);
            }
        });

        fileInput.addEventListener('change', () => {
            const file = fileInput.files[0];
            if (file) {
                updateUploadText(file.name);
                console.log('Imagem selecionada:', file.name);
            }
        });
    }

    // Função para atualizar o texto da área de upload
    function updateUploadText(fileName) {
        const uploadText = uploadArea.querySelector('.texto-upload');
        if (uploadText) {
            uploadText.textContent = fileName;
        }
    }

    // Validação do formulário
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const nome = form.querySelector('input[name="nome"]').value.trim();
            const quantidade = form.querySelector('input[name="quantidade"]').value;
            const preco = form.querySelector('input[name="preco"]').value;

            if (!nome) {
                e.preventDefault();
                alert('Por favor, preencha o nome do produto.');
                return;
            }

            if (quantidade < 0) {
                e.preventDefault();
                alert('A quantidade não pode ser negativa.');
                return;
            }

            if (preco < 0) {
                e.preventDefault();
                alert('O preço não pode ser negativo.');
                return;
            }

            // Se tudo estiver ok, permite o envio
            console.log('Formulário enviado com sucesso!');
        });
    }
});