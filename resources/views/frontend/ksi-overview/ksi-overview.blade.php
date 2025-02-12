@extends('frontend.layout.main')

@section('container')
<br>

<style>
    .record-analytics-heading {
        display: flex;
        align-items: center;
        font-size: 1.8rem;
        font-weight: bold;
        color: #427CE6; 
        margin-bottom: 20px;
        padding: 15px; 
        border: 2px solid #000000; 
        border-radius: 10px; 
        text-align: center;
        box-shadow: 0 2px 5px rgb(0 0 0);
    }

    .record-analytics-heading i {
        margin-right: 10px;
        color: #427CE6;
    }

    .card-text {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgb(0 0 0);
    }

    .card-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 20px;
        text-align: center;
    }

    .process-list {
        margin-top: 20px;
        list-style-type: none;
        padding: 0;
    }

    .process-item {
        font-size: 1.2rem;
        margin: 5px 0;
    }

    .process-count {
        display: inline-block;
        background-color: #427CE6;
        color: rgb(255, 255, 255);
        font-weight: bold;
        padding: 5px 10px;
        border-radius: 5px;
        margin-left: 10px;
    }
</style>

<div class="container" style="max-width: 1769px;">
    <h3 class="record-analytics-heading">
        <i class="fas fa-chart-bar"></i> KPI Analytics 
    </h3> 

    <div class="col-12 col-md-8">
        <button class="btn btn-outline-secondary chart-btn me-2" data-chart="column" title="Bar Chart">
            <i class="bi bi-bar-chart"></i>
        </button>
        <button class="btn btn-outline-secondary chart-btn me-2" data-chart="pie" title="Pie Chart">
            <i class="bi bi-pie-chart"></i>
        </button>
        <button class="btn btn-outline-secondary chart-btn me-2" data-chart="line" title="Line Chart">
            <i class="bi bi-graph-up"></i>
        </button>
        <button class="btn btn-outline-secondary chart-btn" data-chart="scatter" title="Scatter Chart">
            <i class="bi bi-cloud"></i>
        </button>

        <!-- Refresh Button -->
        <button class="btn btn-outline-secondary chart-btn" onclick="location.reload()" title="Refresh Page" style="background-color: #427CE6; border-color: #427CE6; color: rgb(255, 255, 255);">
            <i class="bi bi-arrow-clockwise"></i> Refresh
        </button>
    </div>
    
    <div class="tab-pane fade show active" id="pendingTrainingPie" role="tabpanel" aria-labelledby="home-tab">
        <div class="card border-0">
            <div class="card-body">
                <h5 class="card-title">
                    <span class="process-count">Open Records</span> 
                </h5>
                <div class="d-flex justify-content-center align-items-center" style="display: none;">
                    <div id="loadingSpinner" class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <div class="card-text d-flex justify-content-center align-items-center h-100" id="pendingTrainingAnalysisPie">
                </div>             
            </div>
        </div>
    </div>
</div>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        let currentChartType = 'pie';

      
        const chartButtons = document.querySelectorAll('.chart-btn');
        chartButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                const chartType = event.currentTarget.dataset.chart;
                currentChartType = chartType; 
                preparePendingTrainingChart(chartType);
            });
        });

        
        async function preparePendingTrainingChart(chartType = 'pie') {
            $('#loadingSpinner').show(); 
            $('#pendingTrainingAnalysisPie').hide(); 

            try {
                const url = "/get-process-open-records"; 
                const res = await axios.get(url);

                if (res.data.status === 'ok') {
                    const bodyData = res.data.body;

                    const totalCount = bodyData.reduce((sum, item) => sum + item.count, 0); 
                    const labels = bodyData.map(item => item.name);
                    const series = bodyData.map(item => item.count);
                    const percentages = bodyData.map(item => ((item.count / totalCount) * 100).toFixed(1)); 

                    
                    renderChart(chartType, series, labels, percentages);

                
                    displayProcessList(bodyData, percentages);

                   
                    $('#processCount').text(`Total Records: ${totalCount}`).show();

                } else {
                    console.error("Error fetching data:", res.data.message);
                    $('#loadingSpinner').html('<p style="color: red;">Error loading data!</p>');
                }

            } catch (err) {
                console.error("Error:", err.message);
                $('#loadingSpinner').html('<p style="color: red;"></p>');
            }
        }

                function renderChart(chartType, seriesData, labels, percentages) {
                Highcharts.chart('pendingTrainingAnalysisPie', {
                chart: {
                    type: chartType,
                    plotShadow: false
                },
                title: {
                    text: ''
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.y})'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    [chartType]: { 
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: ({point.y} )({point.percentage:.1f}%)',
                            connectorColor: 'silver'
                        },
                        showInLegend: true,
                        point: {
                            events: {
                                click: function () {
                                    const label = this.name; 
                                    const url = "{{ route('api.drillChartStages.chart', ['label' => ':label']) }}"
                                        .replace(':label', encodeURIComponent(label)); 
                                    window.location.href = url; 
                                }
                            }
                        }
                    }
                },
                series: [{
                    name: 'Share',
                    colorByPoint: true,
                    data: labels.map((label, index) => ({
                        name: label,
                        y: seriesData[index],
                        percentage: percentages[index]
                    }))
                }]
            });

            $('#loadingSpinner').fadeOut(); 
            $('#pendingTrainingAnalysisPie').fadeIn(); 
        }


        function displayProcessList(processData, percentages) {
            const processListContainer = document.getElementById('processList');
            processListContainer.innerHTML = ''; 

            processData.forEach((item, index) => {
                const listItem = document.createElement('li');
                listItem.classList.add('process-item');
                listItem.innerHTML = `
                    <strong>${item.name}:</strong> 
                    <span class="process-count">${item.count}</span> 
                    (<span class="process-percentage">${percentages[index]}%</span>)`; 
                processListContainer.appendChild(listItem);
            });
        }

      
        preparePendingTrainingChart(currentChartType);
    });
</script>




<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

@endsection
