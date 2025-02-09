<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics Dashboard</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <!-- Main Content -->
    <div class="container mx-auto pt-8">
        <h1 class="text-2xl font-bold mb-4 text-center">Analytics Dashboard</h1>
        <div class="flex flex-wrap">
            <!-- Pie Chart -->
            <div class="w-full md:w-1/2 p-4">
                <div class="bg-white border rounded shadow p-4">
                    <h2 class="text-lg font-semibold mb-4">Sales Distribution</h2>
                    <canvas id="pieChart" width="200" height="200"></canvas>
                </div>
            </div>
    
            <!-- Legend -->
            <div class="w-full md:w-1/2 p-4">
                <div class="bg-white border rounded shadow p-4">
                    <h2 class="text-lg font-semibold mb-4">Legend</h2>
                    <div id="pieLegend"></div>
                </div>
            </div>

            <!-- Bar Graph -->
            <div class="w-full md:w-1/2 p-4">
                <div class="bg-white border rounded shadow p-4">
                    <h2 class="text-lg font-semibold mb-4">Monthly Sales Overview</h2>
                    <canvas id="barGraph" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Mock data for demonstration
        var pieChartData = {
            labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
            datasets: [{
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56',
                    '#2ECC71',
                    '#9B59B6',
                    '#FF5733'
                ],
            }]
        };

        var barGraphData = {
            labels: ["January", "February", "March", "April", "May", "June"],
            datasets: [{
                label: 'Sales',
                data: [65, 59, 80, 81, 56, 55],
                backgroundColor: '#36A2EB',
                borderColor: '#36A2EB',
                borderWidth: 1
            }]
        };

        // Pie Chart
        var pieChartCtx = document.getElementById('pieChart').getContext('2d');
        var pieChart = new Chart(pieChartCtx, {
            type: 'pie',
            data: pieChartData,
            options: {
                legend: {
                    display: true,
                    position: 'bottom'
                }
            }
        });

        // Bar Graph
        var barGraphCtx = document.getElementById('barGraph').getContext('2d');
        var barGraph = new Chart(barGraphCtx, {
            type: 'bar',
            data: barGraphData,
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                legend: {
                    display: false
                }
            }
        });
    </script>
</body>

</html>
