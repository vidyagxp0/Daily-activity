@extends('frontend.layout.main')

@section('container')
<h5 class="card-title mt-3" style="text-align: center;">KPI Analytics</h5>
<div class="tab-pane fade show active" id="pendingTrainingPie" role="tabpanel" aria-labelledby="home-tab">

    <div class="card border-0">
        <div class="card-body">
            <h5 class="card-title">{{$label}} Stage wise Distribution</h5>

            <div class="card-text d-flex justify-content-center align-items-center h-100"
                id="pendingTrainingAnalysisPie">
            </div>
        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>

    function renderPendingTrainingChart(seriesData, labels) {
        var barOptions = {
            series: seriesData,
            chart: {
                width: 450,
                type: 'pie',
                events: {
                    dataPointSelection: function (event, chartContext, config) {
                        if (config.dataPointIndex !== undefined) {
                            const index = config.dataPointIndex;
                            const label = config.w.config.labels[index]; // Get the clicked label
                            const process = `{{ $label }}`; // Pass Blade variable (process)

                            // Generate the route URL with both process and label
                            const url = `{{ route('api.drillChartDateDistribution.chart', ['process' => ':process', 'label' => ':label']) }}`
                                .replace(':process', process)
                                .replace(':label', label);

                            // Redirect to the generated URL
                            window.location.href = url;
                        }
                    }
                }
            },
            labels: labels,
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        var pendingTrainingAnalysisPie = new ApexCharts(document.querySelector("#pendingTrainingAnalysisPie"), barOptions);
        pendingTrainingAnalysisPie.render();
    }

    async function preparePendingTrainingChart() {
        $('#pendingTrainingAnalysis > .spinner-border').show();
        try {
            let url;
            let process = `{{ $label }}`;

            if (process === 'Action Item') {
                url = "{{ route('api.actionItem.stageDistribution') }}";
            } else if (process === 'Audit Program') {
                url = "{{ route('api.AuditProgram.stageDistribution') }}";
            } else if (process === 'CAPA') {
                url = "{{ route('api.CAPA.stageDistribution') }}"; // Use the new route
            } else if (process === 'Calibration Management') {
                url = "{{ route('api.CalibrationManagement.stageDistribution') }}"; // Use the new route
            } else if (process === 'Change Control') {
                url = "{{ route('api.ChangeControl.stageDistribution') }}"; // Use the new route
            } else if (process === 'Deviation') {
                url = "{{ route('api.Deviation.stageDistribution') }}"; // Use the new route
            }  else if (process === 'Effectiveness Check') {
                url = "{{ route('api.EffectivenessCheck.stageDistribution') }}"; // Use the new route
            } else if (process === 'Equipment Lifecycle') {
                url = "{{ route('api.EquipmentLCM.stageDistribution') }}"; // Use the new route
            } else if (process === 'Global Capa') {
                url = "{{ route('api.GlobalCAPA.stageDistribution') }}"; // Use the new route
            } else if (process === 'Global Change Control') {
                url = "{{ route('api.GlobalChangeControl.stageDistribution') }}"; // Use the new route
            } else if (process === 'Incident') {
                url = "{{ route('api.Incident.stageDistribution') }}"; // Use the new route
            } else if (process === 'Internal Audit') {
                url = "{{ route('api.InternalAudit.stageDistribution') }}"; // Use the new route
            } else if (process === 'LabIncident') {
                url = "{{ route('api.LabIncident.stageDistribution') }}"; // Use the new route
            } else if (process === 'Preventive Maintenance') {
                url = "{{ route('api.PreventiveMaintenance.stageDistribution') }}"; // Use the new route
            } else if (process === 'Risk Assessment') {
                url = "{{ route('api.RiskAssessment.stageDistribution') }}"; // Use the new route
            } else if (process === 'Root Cause Analysis') {
                url = "{{ route('api.RootCauseAnalysis.stageDistribution') }}"; // Use the new route
            } else if (process === 'Supplier') {
                url = "{{ route('api.Supplier.stageDistribution') }}"; // Use the new route
            } else if (process === 'Supplier Audit') {
                url = "{{ route('api.SupplierAudit.stageDistribution') }}"; // Use the new route
            }

            const res = await axios.get(url);

            if (res.data.status === 'ok') {
                const { labels, series } = res.data.body;
                renderPendingTrainingChart(series, labels);
            } else {
                console.error('Error fetching data:', res.data.message);
            }
        } catch (err) {
            console.error('Error in API call:', err.message);
        } finally {
            $('#pendingTrainingAnalysisPie').find('.spinner-border').remove();
        }
    }

    preparePendingTrainingChart();

</script>

@endsection