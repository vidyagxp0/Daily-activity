@extends('frontend.layout.main')

@section('container')
<style>
    /* Table Styles */
    .custom-table th, .custom-table td {
        text-align: center;
        vertical-align: middle;
        padding: 12px;
    }

    .custom-table thead {
        background-color: #343a40;
        color: #ffffff;
    }

    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
    }

    /* Card Styles */
    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .card-header {
        background-color: #4e73df;
        color: #ffffff;
        padding: 15px;
        font-size: 18px;
    }

    .card-body {
        padding: 45px;
    }

    /* Chart Container Styles */
    .chart-container {
        height: 500px;
        width: 100%;
        padding: 20px;
    }

    .chart-title {
        color: #4e73df;
        font-weight: bold;
        text-align: center;
        margin-top: 20px;
        margin-bottom: 10px;
    }

    .table-container {
        padding: 20px;
        margin-bottom: 30px;
    }

    /* Animation for Cards */
    .card {
        transition: all 0.3s ease-in-out;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }
</style>

<div class="container mt-5">
    <h2 class="text-center mb-4">User Sessions Overview</h2>

    <!-- Session Table Card -->
    <div class="card mb-4 table-container">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">User Sessions</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover custom-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User Name</th>
                        <th>Login Time</th>
                        <th>Logout Time</th>
                        <th>Session Time (minutes)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sessions as $session)
                    <tr>
                        <td>{{ $session->id }}</td>
                        <td>{{ $session->user_name }}</td>
                        <td>{{ $session->login_time }}</td>
                        <td>{{ $session->logout_time }}</td>
                        <td>{{ $session->session_time }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="d-flex justify-content-center">
                {{ $sessions->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    <!-- Row for Bar Chart and Line Chart -->
    <div class="row">
        <!-- Bar Chart for Session Overview (col-md-6) -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">User Session Overview (Login vs. Logout vs. Session Time)</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="sessionChart" style="height: 400px; width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Line Chart for Date-wise Login and Logout (col-md-6) -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Login vs. Logout Count by Date</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="dateLineChart" style="height: 400px; width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Prepare the data for the charts
        const userNames = @json($sessions->pluck('user_name'));
        const loginTimes = @json($sessions->pluck('login_time'));
        const logoutTimes = @json($sessions->pluck('logout_time'));
        const sessionTimes = @json($sessions->pluck('session_time')); // Session time in minutes

        // Calculate Login and Logout Counts by Date
        const dateCounts = {};
        loginTimes.forEach(time => {
            const date = new Date(time).toLocaleDateString();
            dateCounts[date] = dateCounts[date] || { login: 0, logout: 0 };
            dateCounts[date].login += 1;
        });
        logoutTimes.forEach(time => {
            const date = new Date(time).toLocaleDateString();
            dateCounts[date] = dateCounts[date] || { login: 0, logout: 0 };
            dateCounts[date].logout += 1;
        });

        // Extract labels and data for the line chart
        const dateLabels = Object.keys(dateCounts);
        const loginData = dateLabels.map(date => dateCounts[date].login);
        const logoutData = dateLabels.map(date => dateCounts[date].logout);

        // Session Overview Bar Chart Configuration
        const ctxSession = document.getElementById('sessionChart').getContext('2d');
        const sessionChart = new Chart(ctxSession, {
            type: 'bar',
            data: {
                labels: userNames,
                datasets: [
                    {
                        label: 'Login Time (Hours)',
                        data: loginTimes.map(time => new Date(time).getHours()),
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Logout Time (Hours)',
                        data: logoutTimes.map(time => new Date(time).getHours()),
                        backgroundColor: 'rgba(255, 99, 132, 0.5)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Session Time (Minutes)',
                        data: sessionTimes,
                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Time (Hours and Minutes)'
                        }
                    }
                }
            }
        });

        // Date-wise Login vs. Logout Line Chart Configuration
        const ctxDateLine = document.getElementById('dateLineChart').getContext('2d');
        const dateLineChart = new Chart(ctxDateLine, {
            type: 'line',
            data: {
                labels: dateLabels,
                datasets: [
                    {
                        label: 'Login Count',
                        data: loginData,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.3)',
                        fill: true
                    },
                    {
                        label: 'Logout Count',
                        data: logoutData,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.3)',
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Login and Logout Counts'
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    title: {
                        display: true,
                        text: 'User Login vs. Logout by Date'
                    }
                }
            }
        });
    });
</script>
@endsection
