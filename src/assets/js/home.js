document.addEventListener('DOMContentLoaded', function() {
    // Inicia o carregamento do gráfico de pizza
    loadEstoqueChart();

    // Inicia a funcionalidade da tabela de estoque crítico
    initializeDataTable();
});

/**
 * Carrega e renderiza o gráfico de pizza de estoque geral.
 */
function loadEstoqueChart() {
    const chartContainer = document.getElementById('estoqueChart');
    if (!chartContainer) return;

    const customLegendContainer = document.getElementById('custom-legend');
    const ctx = chartContainer.getContext('2d');

    const generateLegend = (chart) => {
        if (!customLegendContainer) return;
        customLegendContainer.innerHTML = '';
        const legendItems = chart.data.labels.map((label, index) => {
            const backgroundColor = chart.data.datasets[0].backgroundColor[index];
            const item = document.createElement('div');
            item.className = 'legend-item';
            item.innerHTML = `<span class="legend-color-box" style="background-color: ${backgroundColor}; border: 1px solid ${backgroundColor.replace('0.8', '1')}"></span><span class="legend-label">${label}</span>`;
            return item;
        });
        legendItems.forEach(item => customLegendContainer.appendChild(item));
    };

    fetch('../controllers/produtoController.php?action=getAllProducts')
        .then(response => {
            if (!response.ok) throw new Error('Erro na rede ao buscar produtos.');
            return response.json();
        })
        .then(produtos => {
            const noDataMessage = document.getElementById('noDataMessage');
            if (!produtos || produtos.length === 0) {
                if (noDataMessage) noDataMessage.style.display = 'block';
                chartContainer.style.display = 'none';
                return;
            }

            const nomes = produtos.map(p => p.nome);
            const quantidades = produtos.map(p => p.quantidade);
            const backgroundColors = ['rgba(255, 159, 64, 0.8)', 'rgba(54, 162, 235, 0.8)', 'rgba(255, 99, 132, 0.8)', 'rgba(75, 192, 192, 0.8)', 'rgba(153, 102, 255, 0.8)', 'rgba(255, 206, 86, 0.8)', 'rgba(201, 203, 207, 0.8)'];

            const estoqueChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: nomes,
                    datasets: [{
                        label: 'Quantidade em Estoque',
                        data: quantidades,
                        backgroundColor: backgroundColors.slice(0, nomes.length),
                        borderColor: backgroundColors.map(color => color.replace('0.8', '1')),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        title: { display: true, text: 'Distribuição de Estoque por Produto', font: { size: 18 } },
                        datalabels: { color: '#fff', font: { weight: 'bold' } }
                    }
                },
                plugins: [ChartDataLabels]
            });
            generateLegend(estoqueChart);
        })
        .catch(error => console.error('Erro ao carregar o gráfico:', error));
}

/**
 * Inicializa a biblioteca DataTables na tabela de estoque crítico.
 */
function initializeDataTable() {
    if (window.DataTable && document.getElementById('tabela-estoque-critico')) {
        new DataTable('#tabela-estoque-critico', {
            paging: true,
            pageLength: 5,
            lengthChange: false,
            searching: true,
            info: true,
            order: [],
            responsive: true,
            language: {
                // CORREÇÃO: Adicionado "https:" no início da URL
                url: 'https://cdn.datatables.net/plug-ins/1.10.25/i18n/Portuguese-Brasil.json'
            }
        });
    }
}

