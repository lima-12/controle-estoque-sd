document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get('id');

    fetch(`../../controllers/produtoController.php?id=${id}`)
        .then(res => res.json())
        .then(produto => {
            const container = document.getElementById('produto-detalhes');
            let html = `
                <h2>${produto.nome}</h2>
                <img src="/src/assets/img/produtos/${produto.imagem}" class="img-fluid mb-3" style="max-height: 200px;">
                <p><strong>Preço:</strong> R$ ${parseFloat(produto.preco).toLocaleString('pt-BR', { minimumFractionDigits: 2 })}</p>

                <h4>Estoque por Filial</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle" id="estoque-filial">
                        <thead><tr><th>Filial</th><th>Quantidade</th></tr></thead>
                        <tbody>
                            ${produto.filiais.map(f => `
                                <tr>
                                    <td>${f.nome}</td>
                                    <td>${f.quantidade ?? 0}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            `;
            container.innerHTML = html;

            // Inicializa DataTables (v2) com Bootstrap 5
            if (window.DataTable) {
                new DataTable('#estoque-filial', {
                    paging: true,
                    searching: true,
                    info: true,
                    order: [],
                    responsive: true
                });
            }
        });
});