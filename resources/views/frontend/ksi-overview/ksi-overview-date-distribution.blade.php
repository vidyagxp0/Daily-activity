@extends('frontend.layout.main')

@section('container')
<h5 class="card-title mt-3" style="text-align: center;">KPI Analytics</h5>
<div id="chartContainer"></div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>

    const process = `{{ $process }}`;
    const prevLabel = `{{ $label }}`;
    async function fetchFlowCounts() {
        const url = `{{ route('api.MonthlyDistribution', ['process' => ':process', 'label' => ':label']) }}`.replace(':process', process).replace(':label', prevLabel);

        try {
            const res = await axios.get(url);

            if (res.data.status === 'ok') {
                const { labels, series } = res.data.body;

                // Render the chart with dynamic data
                renderFlowChart(labels, series);
            } else {
                console.error("Error fetching data:", res.data.message);
            }
        } catch (err) {
            console.error("Error in API call:", err.message);
        }
    }

    function renderFlowChart(labels, series) {
        var options = {
            chart: {
                type: 'bar',
                height: 350,
                events: {
                    dataPointSelection: function (event, chartContext, config) {
                        if (config.dataPointIndex !== undefined) {
                            const index = config.dataPointIndex; // Index of the clicked bar
                            const label = chartContext.opts.xaxis.categories[index]; // Fetch the label (month) using the index
                            const url = `{{ route('api.drillChartLogs.chart', ['process' => ':process', 'label' => ':label']) }}`.replace(':process', process).replace(':label', prevLabel);
                            window.location.href = url;
                        }
                    }
                }
            },
            series: [{
                name: 'Flow Count',
                data: series
            }],
            xaxis: {
                categories: labels,
            },
            // yaxis: {
            //     title: {
            //         text: 'Count of Flows'
            //     }
            // },
            title: {
                text: 'Month wise open records',
                align: 'center'
            }
        };

        var chart = new ApexCharts(document.querySelector("#chartContainer"), options);
        chart.render();
    }

    document.addEventListener('DOMContentLoaded', fetchFlowCounts);
</script>


@endsection