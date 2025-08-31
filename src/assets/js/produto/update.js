document.addEventListener('DOMContentLoaded', function() {
    // Elementos do DOM
    const uploadArea = document.getElementById('area-upload');
    const fileInput = document.getElementById('inputArquivo');
    const form = document.getElementById('formProduto');
    const btnAtualizar = document.getElementById('btnAtualizar');
    const btnText = document.getElementById('btnText');
    const btnLoading = document.getElementById('btnLoading');
    const alertMessage = document.getElementById('alertMessage');
    
    // Obtém o ID do produto da URL
    const urlParams = new URLSearchParams(window.location.search);
    const produtoId = urlParams.get('id');

    // Configuração do drag and drop
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
            }
        });

        fileInput.addEventListener('change', () => {
            const file = fileInput.files[0];
            if (file) {
                updateUploadText(file.name);
            }
        });
    }

    // Função para atualizar o texto da área de upload
    function updateUploadText(fileName) {
        if (!uploadArea) return;
        const uploadText = uploadArea.querySelector('.texto-upload');
        if (uploadText) {
            uploadText.textContent = fileName;
        }
    }

    // Função para exibir mensagem de alerta
    function showAlert(message, type = 'success') {
        alertMessage.innerHTML = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
    }

    // Validação e envio do formulário
    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Validação básica
            const nome = form.querySelector('input[name="nome"]').value.trim();
            const preco = parseFloat(form.querySelector('input[name="preco"]').value) || 0;

            if (!nome) {
                showAlert('Por favor, preencha o nome do produto.', 'danger');
                return;
            }

            if (preco <= 0) {
                showAlert('O preço deve ser maior que zero.', 'danger');
                return;
            }

            // Desabilita o botão e mostra o loading
            btnAtualizar.disabled = true;
            btnText.classList.add('d-none');
            btnLoading.classList.remove('d-none');

            try {
                const formData = new FormData(form);
                
                // Adiciona o ID do produto ao formData
                formData.append('id', produtoId);
                
                // Se não foi selecionada uma nova imagem, remove o campo de imagem
                if (fileInput.files.length === 0) {
                    formData.delete('imagem');
                } else {
                    // Se uma nova imagem foi selecionada, adiciona ao formData
                    formData.append('imagem', fileInput.files[0]);
                }
                
                const response = await fetch(form.action, {
                    method: form.method,
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    showAlert('Produto atualizado com sucesso!', 'success');
                    
                    // Atualiza a visualização da imagem se uma nova foi enviada
                    if (fileInput.files.length > 0) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const imgPreview = document.querySelector('.img-thumbnail');
                            if (imgPreview) {
                                imgPreview.src = e.target.result;
                            } else {
                                // Se não existir a pré-visualização, recarrega a página para mostrar a nova imagem
                                window.location.reload();
                            }
                        };
                        reader.readAsDataURL(fileInput.files[0]);
                    }
                    
                    // Atualiza o texto do botão de upload
                    updateUploadText('Alterar imagem');
                    
                    // Reseta o input de arquivo
                    fileInput.value = '';
                    
                } else {
                    throw new Error(result.message || 'Erro ao atualizar o produto');
                }
            } catch (error) {
                console.error('Erro:', error);
                showAlert(error.message || 'Ocorreu um erro ao processar a requisição', 'danger');
            } finally {
                // Reabilita o botão e esconde o loading
                btnAtualizar.disabled = false;
                btnText.classList.remove('d-none');
                btnLoading.classList.add('d-none');
            }
        });
    }
});