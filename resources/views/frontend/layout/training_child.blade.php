<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training Analytics Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
            color: #343a40;
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
        }

        /* Chart Containers */
        .chart-container {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            width: 100%;
            max-width: 800px; /* Limit chart width */
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

        .main-header {
            background: linear-gradient(45deg, #4e73df, #1cc88a);
            padding: 10px;
            color: #fff;
           
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="inner-block">
        <div class="main-header">
            <h1>Employee Training Analytics</h1>
        </div>
        <div class="chart-container">
            <canvas id="trainingBarChart"></canvas>
        </div>
    </div>
</div>

<script>
    // Get chart data from the backend
    const chartData = @json($chartData);

    // Create the bar chart
    const ctx = document.getElementById('trainingBarChart').getContext('2d');
    const trainingBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Induction', 'On the Job', 'Classroom'],  // Labels for each training type
            datasets: [{
                label: 'Total Trainings',
                data: [chartData.induction.total, chartData.job.total, chartData.classroom.total],
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            },
            {
                label: 'Pass Trainings',
                data: [chartData.induction.pass, chartData.job.pass, chartData.classroom.pass],
                backgroundColor: 'rgba(75, 192, 192, 0.7)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            },
            {
                label: 'Fail Trainings',
                data: [chartData.induction.fail, chartData.job.fail, chartData.classroom.fail],
                backgroundColor: 'rgba(255, 99, 132, 0.7)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            },
            {
                label: 'Pending Trainings',
                data: [chartData.induction.pending, chartData.job.pending, chartData.classroom.pending],
                backgroundColor: 'rgba(255, 206, 86, 0.7)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Trainings'
                    }
                },
                
                x: {
                    title: {
                        display: true,
                        text: 'Training Type'
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    });
</script>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
