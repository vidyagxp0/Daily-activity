<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training Analytics Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('user/css/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>

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
      

        /* Chart Containers */
        .chart-container {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            width: 90%;
            max-width: 700px;
            margin: 20px auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Canvas Styling */
        canvas {
            width: 100% !important;
            height: auto !important;
        }

        .main-header {
            background: #4274da;
            /* padding: 0.1px; */
            color: #fff;
            height: 50px;
        }



        /* Chart Titles */
        .chart-title {
            text-align: center;
            font-size: 1.2rem;
            color: #555;
            margin-bottom: 15px;
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
        .heading-name{
            display: flex;
            justify-content: center;
            font-size: 15px;
        }
        .filter-section{
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            margin-top: 10px;
            cursor: pointer;
        }
        .filter-section select{
            padding: 2px;
            cursor: pointer;
        }
        .filter-section button{
            padding: 3px;
            cursor: pointer;
            margin-right: 5px;
            /* width: 80px; */
        }
        
        #calendar>div.fc-header-toolbar.fc-toolbar.fc-toolbar-ltr>div:nth-child(1)>button {
            text-transform: capitalize;
        }

        #calendar>div.fc-header-toolbar.fc-toolbar.fc-toolbar-ltr>div:nth-child(3)>div>button.fc-timeGridDay-button.fc-button.fc-button-primary {
            text-transform: capitalize;
        }

        #calendar>div.fc-header-toolbar.fc-toolbar.fc-toolbar-ltr>div:nth-child(3)>div>button.fc-timeGridWeek-button.fc-button.fc-button-primary {
            text-transform: capitalize;
        }

        #calendar>div.fc-header-toolbar.fc-toolbar.fc-toolbar-ltr>div:nth-child(3)>div>button.fc-timeGridWeek-button.fc-button.fc-button-primary {
            text-transform: capitalize;
        }

        #calendar>div.fc-header-toolbar.fc-toolbar.fc-toolbar-ltr>div:nth-child(3)>div>button.fc-dayGridMonth-button.fc-button.fc-button-primary.fc-button-active {
            text-transform: capitalize;
        }
        .summary {
            display: flex;
            justify-content: space-around;
            align-items: center;
            background: #ffffff;
            /* margin: 20px auto; */
            padding: 6px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 80%;
        }

        .summary p {
            margin: 0;
            font-size: 12px;
        }
        .main-head-dashboard{
            display: flex;
            justify-content: center;
            font-size: 30px;
            font-weight: bold;
        }
    </style>
</head>

<body>


    <!-- Pass/Fail Chart -->
    {{-- <div class="chart-container">
        <div class="chart-title">Pass vs Fail Analysis</div>
        <canvas id="passFailChart"></canvas>
    </div> --}}

    <!-- Average Score Chart -->
    {{-- <div class="chart-container">
        <div class="chart-title">Average Score per Training Type</div>
        <canvas id="avgScoreChart"></canvas>
    </div> --}}

    <!-- Average Attempts Chart -->
    {{-- <div class="chart-container">
        <div class="chart-title">Average Attempts per Training Type</div>
        <canvas id="avgAttemptsChart"></canvas>
    </div> --}}

    {{-- //--------------- TMM --------------- --}}

    {{-- Chart 1 --}}
    <div style="padding: 2x;" class="container-fluid">
        <div class="inner-block">
            <div class="main-header">
                <div class="main-head-dashboard" style="">Training Analytics</div>
            </div>
            <div id="document" style="background: white !important; padding: 0;">
                <div class="container-fluid">
                    <div class="dashboard-container">
                        <div class="col-xl-12 col-lg-12">
                            <div class="document-left-block">
                                <div class="inner-block table-block">
                                    <div id="calendar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            
            <script>
                $(document).ready(function() {
                    var calendarEl = document.getElementById('calendar');
                    
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                        headerToolbar: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'dayGridMonth,timeGridWeek,timeGridDay'
                        },
                        events: @json($trainingStartDates),
                        contentHeight: 'auto', // Let the height adjust automatically
                        aspectRatio: 3,
                        
                        eventClick: function(info) {
                            info.jsEvent.preventDefault();
                            window.location.href = '/TMS?title=' + info.event.title;
                        }
                    });
    
                    calendar.render();
                });
            </script>
    
            <div class="main-header">
                <div class="main-head-dashboard" style="">Department Designation Training</div>
            </div>
            <div class="filter-section" style="margin-bottom: 20px;">
                <select id="filterLocation" class="form-control" style="width: 200px; margin-right: 10px;">
                    <option value="">Select Location</option>
                    <option value="P1">P1 (Indore Location)</option>
                    <option value="P2">P2 (Pithampur Location)</option>
                    <option value="P4">P4 (Ujjain Site)</option>
                    <option value="C1">C1 (China Plant)</option>
                </select>
                <select id="filterDepartment" class="form-control" style="width: 200px; margin-right: 10px;">
                    <option value="">Select Department</option>
                    <option value="CQA">Corporate Quality Assurance</option>
                    <option value="QA">Quality Assurance</option>
                    <option value="QC">Quality Control</option>
                    <option value="QM">Quality Control (Microbiology department)</option>
                    <option value="PG">Production General</option>
                    <option value="PL">Production Liquid Orals</option>
                    <option value="PT">Production Tablet and Powder</option>
                    <option value="PE">Production External (Ointment, Gels, Creams and Liquid)</option>
                    <option value="PC">Production Capsules</option>
                    <option value="PI">Production Injectable</option>
                    <option value="EN">Engineering</option>
                    <option value="HR">Human Resource</option>
                    <option value="ST">Store</option>
                    <option value="IT">Electronic Data Processing</option>
                    <option value="FD">Formulation Development</option>
                    <option value="AL">Analytical research and Development Laboratory</option>
                    <option value="PD">Packaging Development</option>
                    <option value="PU">Purchase Department</option>
                    <option value="DC">Document Cell</option>
                    <option value="RA">Regulatory Affairs</option>
                    <option value="PV">Pharmacovigilance</option>
                </select>
                <button style="background: none; color: black; border:2px solid rgba(11, 11, 11, 0.1)" id="filterSubmit" class="btn btn-primary" style="margin-right: 10px;">Submit</button>
                <button style="background: none; color: black; border:2px solid rgba(11, 11, 11, 0.1)" id="toggleChartType" class="btn btn-secondary"> Chart Type</button>
            </div>
            
            <div class="chart-container">
                <canvas id="designationChart" width="400" height="200"></canvas>
            </div>
            
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const submitButton = document.getElementById("filterSubmit");
                    const toggleButton = document.getElementById("toggleChartType");
                    const chartContainer = document.getElementById("designationChart");
                    let designationChart;
                    let chartType = 'bar'; // Default chart type
            
                    const createChart = (labels, trainingData, employeeData) => {
                        const data = {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'Training Count',
                                    data: trainingData,
                                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                    borderColor: 'rgba(54, 162, , 1)',
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
                            type: chartType, // Dynamic chart type
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
                                        beginAtZero: true,
                                        ticks: {
                            stepSize: 1
                        }
                                    }
                                }
                            }
                        };
            
                        if (designationChart) designationChart.destroy(); // Destroy the old chart
                        designationChart = new Chart(chartContainer, config);
                    };
            
                    // Fetch and update chart data
                    submitButton.addEventListener("click", () => {
                        const location = document.getElementById("filterLocation").value;
                        const department = document.getElementById("filterDepartment").value;
            
                        fetch("/api/designation-training-filter", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                            },
                            body: JSON.stringify({ location, department }),
                        })
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.labels && data.trainingData && data.employeeData) {
                                createChart(data.labels, data.trainingData, data.employeeData);
                            } else {
                                alert('No data available for the selected filters.');
                            }
                        })
                        .catch((error) => console.error("Error fetching filtered data:", error));
                    });
            
                    // Toggle chart type
                    toggleButton.addEventListener("click", () => {
                        const chartTypes = ['bar', 'pie', 'line'];
                        const currentIndex = chartTypes.indexOf(chartType);
                        chartType = chartTypes[(currentIndex + 1) % chartTypes.length]; // Switch to the next chart type
            
                        // Update the chart with the new type
                        if (designationChart) {
                            createChart(designationChart.data.labels, 
                                        designationChart.data.datasets[0].data, 
                                        designationChart.data.datasets[1].data);
                        }
                    });
                });
            </script>
            
            
            {{-- --------------------------------------- --}}
            <div class="main-header">
                <div class="main-head-dashboard" style="">Department Wise Job Role Training</div>
            </div>
            <div class="filter-section"
                style="">
                <select id="filterlocationcode" class="form-control" style="width: 200px; margin-right: 10px;">
                    <option value="">Select Location</option>
                    <option value="P1">P1 (Indore Location)</option>
                    <option value="P2">P2 (Pithampur Location)</option>
                    <option value="P4">P4 (Ujjain Site)</option>
                    <option value="C1">C1 (China Plant)</option>
                </select>
                <select id="filterDepartmentcode" class="form-control" style="width: 200px; margin-right: 10px;">
                    <option value="">Select Department</option>
                    <option value="CQA">Corporate Quality Assurance</option>
                    <option value="QA">Quality Assurance</option>
                    <option value="QC">Quality Control</option>
                    <option value="QM">Quality Control (Microbiology department)</option>
                    <option value="PG">Production General</option>
                    <option value="PL">Production Liquid Orals</option>
                    <option value="PT">Production Tablet and Powder</option>
                    <option value="PE">Production External (Ointment, Gels, Creams and Liquid)</option>
                    <option value="PC">Production Capsules</option>
                    <option value="PI">Production Injectable</option>
                    <option value="EN">Engineering</option>
                    <option value="HR">Human Resource</option>
                    <option value="ST">Store</option>
                    <option value="IT">Electronic Data Processing</option>
                    <option value="FD">Formulation Development</option>
                    <option value="AL">Analytical research and Development Laboratory</option>
                    <option value="PD">Packaging Development</option>
                    <option value="PU">Purchase Department</option>
                    <option value="DC">Document Cell</option>
                    <option value="RA">Regulatory Affairs</option>
                    <option value="PV">Pharmacovigilance</option>
                </select>
                <button style="background: none; color: black; border: 2px solid rgba(11, 11, 11, 0.1);" id="filtertrainging" class="btn btn-primary">Submit</button>
                <button style="background: none; color: black; border:2px solid rgba(11, 11, 11, 0.1)" id="toggleChartTypejobrole" class="btn btn-secondary"> Chart Type</button>

            </div>
            <div class="chart-container">
                <canvas id="jobRoleTrainingChart" width="400" height="200"></canvas> <!-- Updated chart ID -->
            </div>

           
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const filterButton = document.getElementById('filtertrainging');
                    const toggleButtonnew = document.getElementById("toggleChartTypejobrole");
            
                    const chartContainer = document.getElementById('jobRoleTrainingChart'); // Updated chart ID
                    let jobRoleTrainingChart;
            
                    // Define the initial chart type
                    let chartType = 'bar'; 
            
                    // Chart creation function
                    const createChart = (labels, trainingData, employeeData, type = 'bar') => {
                        const data = {
                            labels: labels,
                            datasets: [{
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
                            type: type, // Use the passed chart type
                            data: data,
                            options: {
                                responsive: true,
                                scales: {
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Job Roles'
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
            
                        if (jobRoleTrainingChart) jobRoleTrainingChart.destroy(); // Destroy the old chart
                        jobRoleTrainingChart = new Chart(chartContainer, config); // Create a new chart
                    };
            
                    // Fetch and update chart data
                    filterButton.addEventListener('click', function() {
                        const location = document.getElementById('filterlocationcode').value;
                        const department = document.getElementById('filterDepartmentcode').value;
            
                        fetch('/api/training-analysis/filter', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({
                                    location,
                                    department
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.error) {
                                    alert(data.error);
                                } else if (data.labels.length === 0) {
                                    alert('No data found for the selected filters.');
                                } else {
                                    createChart(data.labels, data.trainingData, data.employeeData, chartType); // Pass the current chart type
                                }
                            })
                            .catch(error => console.error('Error fetching filtered data:', error));
                    });
            
                    // Toggle chart type
                    toggleButtonnew.addEventListener("click", () => {
                        const chartTypes = ['bar', 'pie', 'line'];
                        const currentIndex = chartTypes.indexOf(chartType);
                        chartType = chartTypes[(currentIndex + 1) % chartTypes.length]; // Switch to the next chart type
            
                        // Update the chart with the new type
                        if (jobRoleTrainingChart) {
                            createChart(
                                jobRoleTrainingChart.data.labels, 
                                jobRoleTrainingChart.data.datasets[0].data, 
                                jobRoleTrainingChart.data.datasets[1].data,
                                chartType // Pass the updated chart type
                            );
                        }
                    });
                });
            </script>
            
            {{-- ----------------- --}}


            {{-- <div class="main-header">
                <h1 style="">Training Analytics Dashboard</h1>
            </div> --}}
            <div style="display: flex; gap: 12px; margin-left: 10px; margin-right: 10px;" class="">
                <div class="chart-container">
                    <div style="font-weight: bold" class="chart-title">Number of TM Created by User</div>
                    <canvas id="tmmBarChart" width="400" height="400"></canvas>
                </div>
                <script>
                    // Prepare the data for the chart
                    const labels = @json($TMMchartData['labels']);
                    const data = @json($TMMchartData['data']);

                    // Create the bar chart
                    const ctx = document.getElementById('tmmBarChart').getContext('2d');
                    const tmmBarChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Count',
                                data: data,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                            stepSize: 1
                        }
                                }
                            }
                        }
                    });
                </script>

                {{-- CHart 2 --}}
                <div class="chart-container">
                    <div style="font-weight: bold" class="chart-title ">Type of Module</div>
                    <canvas id="typePieChart" width="300" height="100"></canvas>
                </div>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        // Prepare the data for the pie chart with fallback for empty data
                        let pielabels = @json($tmmTypeChartData['labels']);
                        let piedata = @json($tmmTypeChartData['data']);
                
                        // Check if data is empty or undefined and assign default placeholder values
                        if (!pielabels || pielabels.length === 0) {
                            pielabels = ['No Data Available'];
                            piedata = [1]; // Placeholder value to render the pie chart
                        }
                
                        // Log the data for debugging
                        console.log("Labels:", pielabels);
                        console.log("Data:", piedata);
                
                        // Create the pie chart
                        const ctxpie = document.getElementById('typePieChart').getContext('2d');
                        const typePieChart = new Chart(ctxpie, {
                            type: 'pie',
                            data: {
                                labels: pielabels,
                                datasets: [{
                                    label: 'Type of Module',
                                    data: piedata,
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)', // Light grey for "No Data Available"
                                    ],
                                    borderColor: [
                                        'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    ],
                                    borderWidth: 2
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                return context.label + ': ' + context.raw;
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    });
                </script>
                
                {{-- ============== --}}
                <div class="chart-container" style="position: relative;  width: 100%; height: 450px; ">
                    <div style="font-weight: bold" class="chart-title ">Employee Training</div>

                    <div class="summary">
                        {{-- <p>Total Employees: <span>{{ $totalEmployees }}</span></p> --}}
                        <p>Active Employees: <span>{{ $activeEmployees }}</span></p>
                        <p>Inactive Employees: <span>{{ $totalEmployees - $activeEmployees }}</span></p>
                    </div>
                    <canvas style=" scale: 0.84 !important; margin-top: -41px;" id="employeeChart"></canvas>
                </div>

                <script>
                    // Chart.js configuration
                    document.addEventListener('DOMContentLoaded', function() {
                        const ctx = document.getElementById('employeeChart').getContext('2d');
                        const employeeChart = new Chart(ctx, {
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
                                maintainAspectRatio: false, // Ensures the chart adapts to custom height/width
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
                    });
                </script>
            </div>

{{-- ============================= --}}
<div style="display: flex; gap: 10px;" class="row">
    <div class="chart-container" style="position: relative; width: 100%; height: 450px;">
        <div class="heading-name" style="font-weight: bold;">Trainer Load Distribution</div>
        <canvas id="trainerBarChart"></canvas>
    </div>
</div>
<div style="display: flex; gap: 10px;" class="row">
    <div class="chart-container" style="position: relative; width: 100%; height: 450px;">
        <div class="heading-name" style="font-weight: bold;">Pending Induction Training Records by Employee</div>
        <canvas id="barChart"></canvas>
    </div>
    <div class="chart-container" style="position: relative; width: 100%; height: 450px;">
        <div class="heading-name" style="font-weight : bold">Induction Training Completion Distribution by Employee</div>
        <canvas id="trainingBarChart"></canvas>
    </div>
</div>

<!-- ---------- OTJ ----------------  -->
<div style="display: flex; gap: 10px;" class="row">
    <div class="chart-container" style="position: relative; width: 100%; height: 450px;">
        <div class="heading-name" style="font-weight: bold;">OTJ Pending Training Records by Employee</div>
        <canvas id="barChartotj"></canvas>
    </div>
    <div class="chart-container" style="position: relative; width: 100%; height: 450px;">
        <div class="heading-name" style="font-weight : bold">OTJ Training Completion Distribution by Employee</div>
        <canvas id="otjBarChart"></canvas>
    </div>

</div>

<!-- Classroom Training Section -->
<div style="display: flex; gap: 10px;" class="row">
    <div class="chart-container" style="position: relative; width: 100%; height: 450px;">
        <div class="heading-name" style="font-weight: bold;">Classroom Pending Training Records by Employee</div>
        <canvas id="barChartClassroom"></canvas>
    </div>
    <div class="chart-container" style="position: relative; width: 100%; height: 450px;">
        <div class="heading-name" style="font-weight: bold;">Classroom Training Completion by Employee</div>
        <canvas id="classroomBarChart"></canvas>
    </div>

</div>

{{-- ============================= --}}
<div style="display: flex; gap: 10px;" class="row">
    <div class="chart-container" style="position: relative; width: 100%; height: 450px;">
        <div class="heading-name" style="font-weight: bold;">Pending Induction Training Records by Department</div>
        <canvas id="pendingInductionDepartmentChart"></canvas>
    </div>
    <div class="chart-container" style="position: relative; width: 100%; height: 450px;">
        <div class="heading-name" style="font-weight : bold">Induction Training Completion Distribution by Department</div>
        <canvas id="inductionDepartmentChart"></canvas>
    </div>
    
</div>

<!-- ---------- OTJ ----------------  -->
<div style="display: flex; gap: 10px;" class="row">
    <div class="chart-container" style="position: relative; width: 100%; height: 450px;">
        <div class="heading-name" style="font-weight: bold;">OTJ Pending Training Records by Department</div>
        <canvas id="pendingOTJDepartmentChart"></canvas>
    </div>
    <div class="chart-container" style="position: relative; width: 100%; height: 450px;">
        <div class="heading-name" style="font-weight : bold">OTJ Training Completion Distribution by Department</div>
        <canvas id="otjDepartmentChart"></canvas>
    </div>

</div>

<!-- Classroom Training Section -->
<div style="display: flex; gap: 10px;" class="row">
    <div class="chart-container" style="position: relative; width: 100%; height: 450px;">
        <div class="heading-name" style="font-weight: bold;">Classroom Pending Training Records by Department</div>
        <canvas id="pendingClassroomDepartmentChart"></canvas>
    </div>
    <div class="chart-container" style="position: relative; width: 100%; height: 450px;">
        <div class="heading-name" style="font-weight: bold;">Classroom Training Completion by Department</div>
        <canvas id="classroomDepartmentChart"></canvas>
    </div>

</div>

<script>
    window.onload = function () {
    // Helper function to initialize a chart
    function createChart(ctx, labels, data, label, bgColor, borderColor) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels.length ? labels : ['No Data'], // Use placeholder label if no data
                datasets: [{
                    label: label,
                    data: data.length ? data : [0], // Use placeholder data if no data
                    backgroundColor: bgColor,
                    borderColor: borderColor,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,  // Ensure the chart does not stretch
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return context.raw === 0 && labels[0] === 'No Data'
                                    ? 'No data available'
                                    : context.raw;
                            }
                        }
                    }
                },
                layout: {
                    padding: {
                        top: 10,
                        bottom: 10
                    }
                },
                backgroundColor: "#f3f3f3" // Add a light background to the canvas if needed
            }
        });
    }

    // Trainer Count training plan
    var ctxtrainer = document.getElementById('trainerBarChart').getContext('2d');
    var trainerdata = @json($trainerData);
    createChart(
        ctxtrainer,
        trainerdata.map(data => data.trainer_name),
        trainerdata.map(data => data.training_plan_count),
        'Name of Tranier Vs Training record count',
        'rgba(75, 192, 192, 0.2)',
        'rgba(75, 192, 192, 1)'
    );

    // Induction Training Completion
    var ctx1 = document.getElementById('trainingBarChart').getContext('2d');
    var completeTrainingData = @json($completeInductionTraining);
    createChart(
        ctx1,
        completeTrainingData.map(data => data.emp_name),
        completeTrainingData.map(data => data.training_count),
        'Induction Training Count per Employee',
        'rgba(75, 192, 192, 0.2)',
        'rgba(75, 192, 192, 1)'
    );

    // Induction Training Pending
    var ctx2 = document.getElementById('barChart').getContext('2d');
    var pendingTrainingData = @json($pendingInductionTraining);
    createChart(
        ctx2,
        pendingTrainingData.map(data => data.name_employee),
        pendingTrainingData.map(data => data.pending_training_count),
        'Pending Induction Training Records',
        'rgba(54, 162, 235, 0.2)',
        'rgba(54, 162, 235, 1)'
    );

    // OTJ Training Completion
    var ctx11 = document.getElementById('otjBarChart').getContext('2d');
    var completeOTJData = @json($completeOTJTraining);
    createChart(
        ctx11,
        completeOTJData.map(data => data.emp_name),
        completeOTJData.map(data => data.training_count),
        'OTJ Training Count per Employee',
        'rgba(153, 102, 255, 0.2)',
        'rgba(153, 102, 255, 1)'
    );

    // OTJ Training Pending
    var ctx22 = document.getElementById('barChartotj').getContext('2d');
    var pendingOTJData = @json($pendingOTJTraining);
    createChart(
        ctx22,
        pendingOTJData.map(data => data.name_employee),
        pendingOTJData.map(data => data.pending_training_count),
        'Pending OTJ Training Records',
        'rgba(255, 159, 64, 0.2)',
        'rgba(255, 159, 64, 1)'
    );

    // Classroom Training Completion
    var ctxClassroom = document.getElementById('classroomBarChart').getContext('2d');
    var completeClassroomData = @json($completeClassroomTraining);
    createChart(
        ctxClassroom,
        completeClassroomData.map(data => data.emp_name),
        completeClassroomData.map(data => data.training_count),
        'Classroom Training Count per Employee',
        'rgba(255, 206, 86, 0.2)',
        'rgba(255, 206, 86, 1)'
    );

    // Classroom Training Pending
    var ctxPendingClassroom = document.getElementById('barChartClassroom').getContext('2d');
    var pendingClassroomData = @json($pendingClassroomTraining);
    createChart(
        ctxPendingClassroom,
        pendingClassroomData.map(data => data.name_employee),
        pendingClassroomData.map(data => data.pending_training_count),
        'Pending Classroom Training Records',
        'rgba(75, 192, 192, 0.2)',
        'rgba(75, 192, 192, 1)'
    );

    // ===========================
    // Induction Training by Department
    const ctxInductionDept = document.getElementById('inductionDepartmentChart').getContext('2d');
    const completeInductionDeptData = @json($completeInductionDepartment);
    createChart(
        ctxInductionDept,
        completeInductionDeptData.map(data => data.department),
        completeInductionDeptData.map(data => data.training_count),
        'Induction Training Completion by Department',
        'rgba(75, 192, 192, 0.2)',
        'rgba(75, 192, 192, 1)'
    );

    // Pending Induction Training by Department
    const ctxPendingInductionDept = document.getElementById('pendingInductionDepartmentChart').getContext('2d');
    const pendingInductionDeptData = @json($pendingInductionDepartmentTraining);
    createChart(
        ctxPendingInductionDept,
        pendingInductionDeptData.map(data => data.department),
        pendingInductionDeptData.map(data => data.pending_training_count),
        'Pending Induction Training Records by Department',
        'rgba(54, 162, 235, 0.2)',
        'rgba(54, 162, 235, 1)'
    );

    // ===========================
    // OTJ Training by Department
    const ctxOTJDept = document.getElementById('otjDepartmentChart').getContext('2d');
    const completeOTJDeptData = @json($completeOTJDepartment);
    createChart(
        ctxOTJDept,
        completeOTJDeptData.map(data => data.department),
        completeOTJDeptData.map(data => data.training_count),
        'OTJ Training Completion by Department',
        'rgba(153, 102, 255, 0.2)',
        'rgba(153, 102, 255, 1)'
    );

    // Pending OTJ Training by Department
    const ctxPendingOTJDept = document.getElementById('pendingOTJDepartmentChart').getContext('2d');
    const pendingOTJDeptData = @json($pendingOTJDepartment);
    createChart(
        ctxPendingOTJDept,
        pendingOTJDeptData.map(data => data.department),
        pendingOTJDeptData.map(data => data.pending_training_count),
        'Pending OTJ Training Records by Department',
        'rgba(255, 159, 64, 0.2)',
        'rgba(255, 159, 64, 1)'
    );

    // ===========================
    // Classroom Training by Department
    const ctxClassroomDept = document.getElementById('classroomDepartmentChart').getContext('2d');
    const completeClassroomDeptData = @json($completeClassroomDepartment);
    createChart(
        ctxClassroomDept,
        completeClassroomDeptData.map(data => data.department),
        completeClassroomDeptData.map(data => data.training_count),
        'Classroom Training Completion by Department',
        'rgba(255, 206, 86, 0.2)',
        'rgba(255, 206, 86, 1)'
    );

    // Pending Classroom Training by Department
    const ctxPendingClassroomDept = document.getElementById('pendingClassroomDepartmentChart').getContext('2d');
    const pendingClassroomDeptData = @json($pendingClassroomDepartment);
    createChart(
        ctxPendingClassroomDept,
        pendingClassroomDeptData.map(data => data.department),
        pendingClassroomDeptData.map(data => data.pending_training_count),
        'Pending Classroom Training Records by Department',
        'rgba(75, 192, 192, 0.2)',
        'rgba(75, 192, 192, 1)'
    );
};

</script>

{{-- =================================== --}}


        </div>
    </div>
   
    {{-- ---------------------- - ---------------------------- --}}

    <script>
        // Data from backend
        const trainingMetrics = @json($trainingMetrics);

        // Pass/Fail Chart
        const passFailData = {
            labels: Object.keys(trainingMetrics),
            datasets: [{
                    label: 'Pass',
                    data: Object.values(trainingMetrics).map(m => m.pass),
                    backgroundColor: 'rgba(75, 192, 192, 0.7)'
                },
                {
                    label: 'Fail',
                    data: Object.values(trainingMetrics).map(m => m.fail),
                    backgroundColor: 'rgba(255, 99, 132, 0.7)'
                }
            ]
        };

        const passFailConfig = {
            type: 'bar',
            data: passFailData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        new Chart(document.getElementById('passFailChart'), passFailConfig);

        // Average Score Chart
        const avgScoreData = {
            labels: Object.keys(trainingMetrics),
            datasets: [{
                label: 'Average Score',
                data: Object.values(trainingMetrics).map(m => m.avg_score),
                backgroundColor: 'rgba(54, 162, 235, 0.7)'
            }]
        };

        const avgScoreConfig = {
            type: 'bar',
            data: avgScoreData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        new Chart(document.getElementById('avgScoreChart'), avgScoreConfig);

        // Average Attempts Chart
        const avgAttemptsData = {
            labels: Object.keys(trainingMetrics),
            datasets: [{
                label: 'Average Attempts',
                data: Object.values(trainingMetrics).map(m => m.avg_attempts),
                backgroundColor: 'rgba(255, 159, 64, 0.7)',
                borderColor: 'rgba(255, 159, 64, 1)',
                fill: true
            }]
        };

        const avgAttemptsConfig = {
            type: 'line',
            data: avgAttemptsData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        new Chart(document.getElementById('avgAttemptsChart'), avgAttemptsConfig);
    </script>
  
    
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    $(document).ready(function() {
        $('#filterSubmit').click();
        $('#filtertrainging').click();
   

    })
  </script>

</body>

</html>
