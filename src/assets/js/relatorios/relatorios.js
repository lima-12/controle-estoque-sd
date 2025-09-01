document.addEventListener('DOMContentLoaded', function() {
    const chartContainer = document.getElementById('estoqueChart');
    const customLegendContainer = document.getElementById('custom-legend');

    if (!chartContainer) {
        console.error('Canvas element for chart not found!');
        return;
    }

    const ctx = chartContainer.getContext('2d');

    // Função para gerar a legenda HTML dinamicamente
    const generateLegend = (chart) => {
        // Limpa a legenda antiga antes de criar uma nova
        customLegendContainer.innerHTML = '';

        const legendItems = chart.data.labels.map((label, index) => {
            const backgroundColor = chart.data.datasets[0].backgroundColor[index];
            // Cria os elementos da legenda
            const item = document.createElement('div');
            item.className = 'legend-item';

            item.innerHTML = `
                <span class="legend-color-box" style="background-color: ${backgroundColor}; border: 1px solid ${backgroundColor.replace('0.8', '1')}"></span>
                <span class="legend-label">${label}</span>
            `;
            return item;
        });

        // Adiciona todos os itens ao container da legenda
        legendItems.forEach(item => {
            customLegendContainer.appendChild(item);
        });
    };

    fetch('../../controllers/produtoController.php?action=getAllProducts')
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro ao carregar os dados dos produtos');
            }
            return response.json();
        })
        .then(produtos => {
            if (!produtos || produtos.length === 0) {
                const noDataMessage = document.getElementById('noDataMessage');
                if (noDataMessage) {
                    noDataMessage.style.display = 'block';
                }
                chartContainer.style.display = 'none';
                return;
            }

            // Usamos os nomes originais dos produtos, sem quebrar ou truncar
            const nomes = produtos.map(p => p.nome);
            const quantidades = produtos.map(p => p.quantidade);
            
            const backgroundColors = [
                'rgba(255, 159, 64, 0.8)', 'rgba(54, 162, 235, 0.8)',
                'rgba(255, 99, 132, 0.8)', 'rgba(75, 192, 192, 0.8)',
                'rgba(153, 102, 255, 0.8)', 'rgba(255, 206, 86, 0.8)',
                'rgba(201, 203, 207, 0.8)', 'rgba(238, 130, 238, 0.8)',
                'rgba(0, 255, 127, 0.8)', 'rgba(255, 0, 0, 0.8)'
            ];

            const estoqueChart = new Chart(ctx, { // Armazena o gráfico numa variável
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
                        // ALTERAÇÃO: Desabilitamos a legenda padrão do Chart.js
                        legend: {
                            display: false,
                        },
                        title: {
                            display: true,
                            text: 'Distribuição de Estoque por Produto',
                            font: {
                                size:18
                            }
                        },
                        datalabels: {
                            color: '#fff',
                            formatter: (value) => value,
                            font: {
                                weight: 'bold'
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });

            // NOVO: Chama a função para gerar nossa legenda customizada
            generateLegend(estoqueChart);
        })
        .catch(error => {
            console.error('Erro ao carregar o gráfico:', error);
            const noDataMessage = document.getElementById('noDataMessage');
            if (noDataMessage) {
                noDataMessage.innerHTML = `<i class="fas fa-exclamation-triangle"></i><p>Erro ao carregar o gráfico.</p>`;
                noDataMessage.style.display = 'block';
            }
            chartContainer.style.display = 'none';
        });
});