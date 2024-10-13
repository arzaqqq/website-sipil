<x-filament-panels::page>
    <div class="flex flex-col">
        <!-- Bar Chart -->
        <h2 class="text-xl font-bold mb-4">Bar Chart: Rata-rata Rating per Mata Kuliah dan Dosen</h2>
        <canvas id="barChart"></canvas>
        <div class="w-24 h-1">
            <button id="downloadBarChart" class="mt-2 mb-4 px-2 py-2 font-bold text-sm text-white rounded-md" style="background-color: #3B82F6;">Unduh Bar Chart</button>
        </div>

        <!-- Line Chart -->
        <h2 class="text-xl font-bold mb-4 mt-8">Line Chart: Rata-rata Rating per Pertanyaan</h2>
        <canvas id="lineChart"></canvas>
        <div class="w-24 h-1">
            <button id="downloadLineChart" class="mt-2 px-2 py-2 font-semibold text-sm text-white rounded" style="background-color: #3B82F6;">Unduh Line Chart</button>
        </div>

    </div>

    <!-- Load Script Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let barChart, lineChart;

            // Fetch data untuk grafik utama
            fetch('{{ url("/surveys/chart-data") }}')
                .then(response => response.json())
                .then(data => {
                    // Bar Chart
                    const barCtx = document.getElementById('barChart').getContext('2d');
                    const barDatasets = data.datasets.map(dataset => ({
                        label: dataset.label,
                        data: dataset.data,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }));

                    barChart = new Chart(barCtx, {
                        type: 'bar',
                        data: {
                            labels: data.labels,
                            datasets: barDatasets
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Persentase Rating (%)'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Mata Kuliah - Dosen'
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top',
                                }
                            }
                        }
                    });

                    // Line Chart
                    const lineCtx = document.getElementById('lineChart').getContext('2d');
                    const lineDatasets = data.datasets.map(dataset => ({
                        label: dataset.label,
                        data: dataset.data,
                        fill: false,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        tension: 0.1
                    }));

                    lineChart = new Chart(lineCtx, {
                        type: 'line',
                        data: {
                            labels: data.labels,
                            datasets: lineDatasets
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Persentase Rating (%)'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Mata Kuliah - Dosen'
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top',
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error fetching data:', error));

            // Event listener untuk unduh Bar Chart
            document.getElementById('downloadBarChart').addEventListener('click', function () {
                const link = document.createElement('a');
                link.href = barChart.toBase64Image();
                link.download = 'bar-chart.png';
                link.click();
            });

            // Event listener untuk unduh Line Chart
            document.getElementById('downloadLineChart').addEventListener('click', function () {
                const link = document.createElement('a');
                link.href = lineChart.toBase64Image();
                link.download = 'line-chart.png';
                link.click();
            });

        });
    </script>
</x-filament-panels::page>
