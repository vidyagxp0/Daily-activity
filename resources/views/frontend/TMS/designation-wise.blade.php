<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training Analytics Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        console.log("Chart.js loaded"); // Check Chart.js loading
    </script>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        /* Header */
        h1 {
            color: #fff;
            text-align: center;
            margin-top: 20px;
        }

        /* Chart Containers */
        .chart-container {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            width: 90%;
            /* max-width: 800px; */
            margin: 20px auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Canvas Styling */
        canvas {
            width: 100% !important;
            height: auto !important;
        }

        /* Chart Titles */
        .chart-title {
            text-align: center;
            font-size: 1.2rem;
            color: #555;
            margin-bottom: 15px;
        }
        .main-header{
            background: #4274da;
            padding: 0.5px;
            color: #fff;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .chart-container {
                padding: 15px;
            }
            .chart-title {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
  
<div class="container-fluid">
    <div class="inner-block">
        <div   class="main-header">
            <h1 style="">Department Designation Training</h1>
        </div>
        <div class="chart-container">
            <canvas id="designationChart" width="400" height="200"></canvas>
        </div>
    </div>
</div>
   

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const labels = @json(array_keys($nonZeroTrainingCount));
            const trainingData = @json(array_values($nonZeroTrainingCount));
            const employeeData = @json(array_values($designationWiseUsersCount));
    
            const data = {
                labels: labels,
                datasets: [
                    {
                        label: 'Training Count',
                        data: trainingData,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Assigned Employees',
                        data: employeeData,
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            };
    
            const config = {
                type: 'bar',
                data: data,
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Designation'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Count'
                            },
                            beginAtZero: true
                        }
                    }
                }
            };
    
            new Chart(
                document.getElementById('designationChart'),
                config
            );
        });
    </script>
    
    
</body>
</html>
