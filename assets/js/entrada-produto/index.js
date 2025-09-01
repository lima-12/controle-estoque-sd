document.addEventListener('DOMContentLoaded', function() {
    // Elementos do DOM
    const form = document.getElementById('formEntradaProduto');
    const alertContainer = document.getElementById('alertContainer');
    const selectProduto = document.getElementById('produto');
    const selectFilial = document.getElementById('filial');
    const btnNovaEntrada = document.getElementById('btnNovaEntrada');
    const modalSucesso = new bootstrap.Modal(document.getElementById('modalSucesso'));

    // Carrega os dados do formulário (produtos e filiais)
    function carregarDadosFormulario() {
        fetch('/src/controllers/entradaProdutoController.php?action=getFormData')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro ao carregar dados do formulário');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    preencherSelect(selectProduto, data.produtos, 'id', 'nome');
                    preencherSelect(selectFilial, data.filiais, 'id', 'nome');
                } else {
                    mostrarAlerta('danger', 'Erro ao carregar dados: ' + (data.message || 'Erro desconhecido'));
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                mostrarAlerta('danger', 'Erro ao carregar dados do formulário. Tente recarregar a página.');
            });
    }

    // Preenche um select com os dados fornecidos
    function preencherSelect(select, dados, valor, texto) {
        // Limpa o select, mantendo apenas a primeira opção
        while (select.options.length > 1) {
            select.remove(1);
        }

        // Adiciona as opções
        if (dados && dados.length > 0) {
            dados.forEach(item => {
                const option = document.createElement('option');
                option.value = item[valor];
                option.textContent = item[texto];
                select.appendChild(option);
            });
        } else {
            const option = document.createElement('option');
            option.value = '';
            option.textContent = 'Nenhum registro encontrado';
            option.disabled = true;
            option.selected = true;
            select.appendChild(option);
        }
    }

    // Mostra uma mensagem de alerta
    function mostrarAlerta(tipo, mensagem) {
        alertContainer.innerHTML = `
            <div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
                ${mensagem}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
            </div>
        `;
    }

    // Limpa o formulário
    function limparFormulario() {
        form.reset();
        selectProduto.value = '';
        selectFilial.value = '';
    }

    // Manipula o envio do formulário
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Desabilita o botão de submit para evitar múltiplos envios
        const submitButton = form.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processando...';
        
        // Prepara os dados do formulário
        const formData = new FormData(form);
        
        // Envia a requisição
        fetch('/src/controllers/entradaProdutoController.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mostra o modal de sucesso
                document.getElementById('mensagemSucesso').textContent = data.message || 'Entrada de produto registrada com sucesso!';
                modalSucesso.show();
                
                // Limpa o formulário
                limparFormulario();
            } else {
                mostrarAlerta('danger', data.message || 'Erro ao registrar entrada de produto');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            mostrarAlerta('danger', 'Erro ao conectar com o servidor. Tente novamente.');
        })
        .finally(() => {
            // Reabilita o botão de submit
            submitButton.disabled = false;
            submitButton.innerHTML = '<i class="fas fa-save"></i> Registrar Entrada';
        });
    });

    // Configura o botão de nova entrada no modal
    if (btnNovaEntrada) {
        btnNovaEntrada.addEventListener('click', function() {
            modalSucesso.hide();
            // Rola a página para o topo do formulário
            form.scrollIntoView({ behavior: 'smooth' });
        });
    }

    // Carrega os dados do formulário quando a página é carregada
    carregarDadosFormulario();
});
