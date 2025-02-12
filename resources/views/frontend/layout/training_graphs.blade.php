<!DOCTYPE html>
<html>
<head>
    <title>Employee Training Graphs</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* General body styling */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f7fa;
            color: #333;
        }

        /* Header styling */
        .main-header {
            background: #215dd4ba;
            padding: 20px 0;
            color: #fff;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .main-header h1 {
            margin: 0;
            font-size: 24px;
            /* text-transform: uppercase; */
            letter-spacing: 2px;
        }

        /* Summary section styling */
        .summary {
            display: flex;
            justify-content: space-around;
            align-items: center;
            background: #ffffff;
            margin: 20px auto;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 80%;
        }

        .summary p {
            margin: 0;
            font-size: 18px;
        }

        .summary span {
            font-weight: bold;
            color: #4274daba;
        }

        /* Chart container styling */
        .chart-container {
            margin: 20px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 80%;
            text-align: center;
        }

        canvas {
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <div class="main-header">
        <h1>Employee Training Graphs</h1>
    </div>

    <!-- Summary Section -->
    <div class="summary">
        <p>Total Employees: <span>{{ $totalEmployees }}</span></p>
        <p>Active Employees: <span>{{ $activeEmployees }}</span></p>
        <p>Inactive Employees: <span>{{ $totalEmployees - $activeEmployees }}</span></p>
    </div>

    <!-- Chart Section -->
    <div class="chart-container">
        <canvas id="employeeChart"></canvas>
    </div>

    <script>
        // Chart.js configuration
        var ctx = document.getElementById('employeeChart').getContext('2d');
        var employeeChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Active Employees', 'Inactive Employees'],
                datasets: [{
                    data: [
                        {{ $activeEmployees }},
                        {{ $totalEmployees - $activeEmployees }}
                    ],
                    backgroundColor: ['#4caf50', '#f44336'],
                    borderColor: ['#ffffff', '#ffffff'],
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Disable aspect ratio for custom height/width
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                size: 14,
                                family: 'Arial'
                            }
                        }
                    },
                    tooltip: {
                        enabled: true,
                        callbacks: {
                            label: function(tooltipItem) {
                                return `${tooltipItem.label}: ${tooltipItem.raw}`;
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
