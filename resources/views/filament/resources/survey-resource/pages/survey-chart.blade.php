<x-filament-panels::page>
    <div class="flex flex-col">
        <canvas id="barChart"></canvas> <!-- Canvas untuk BarChart -->
        <canvas id="pieChart" class="mt-8"></canvas> <!-- Canvas untuk PieChart -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Fetch data untuk grafik
            fetch('{{ url("/surveys/chart-data") }}')
                .then(response => response.json())
                .then(data => {
                    // BarChart
                    const barCtx = document.getElementById('barChart').getContext('2d');
                    new Chart(barCtx, {
                        type: 'bar',
                        data: {
                            labels: data.labels,
                            datasets: data.datasets
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                legend: {
                                    display: true,
                                }
                            }
                        }
                    });

                    // PieChart
                    const pieCtx = document.getElementById('pieChart').getContext('2d');
                    new Chart(pieCtx, {
                        type: 'pie',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Distribution of Ratings',
                                data: data.datasets[0].data, // Data yang sama digunakan untuk pie chart
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                });
        });
    </script>
</x-filament-panels::page>
