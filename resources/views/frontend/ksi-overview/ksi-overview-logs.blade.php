@extends('frontend.layout.main')

@section('container')

<h5 class="card-title mt-3" style="text-align: center;">{{$process}} {{$label}} Logs</h5>

<div class="table-responsive mt-4">
    <table class="table table-bordered table-striped" id="kpiTable">
        <thead>
            <tr>
                <th>#</th>
                <th>ID</th>
                <th>Parent ID</th>
                <th>Division</th>
                <th>Process</th>
                <th>Initiated Through</th>
                <th>Short Description</th>
                <th>Date Opened</th>
                <th>Originator</th>
                <th>Due Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="11" class="text-center">Loading data...</td>
            </tr>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    const process = "{{ $process }}";
    const label = "{{ $label }}";
    const url = `{{ route('kpi.logs', ['process' => ':process', 'label' => ':label']) }}`
        .replace(':process', process)
        .replace(':label', label);

    async function fetchAndRenderTable() {
        try {
            const res = await axios.get(url);

            if (res.data.status === 'ok') {
                const data = res.data.body;

                if (data && data.length > 0) {
                    const tableBody = document.querySelector('#kpiTable tbody');
                    tableBody.innerHTML = '';

                    const processRoutes = {
                        "Internal Audit": "{{ route('showInternalAudit', ['id' => 'recordId']) }}",
                        "Audit Program": "{{ url('showAuditProgram', ['id' => 'recordId']) }}",
                        "Supplier": "{{ url('rcms/supplier-show', ['id' => 'recordId']) }}",
                        "Supplier Audit": "{{ route('showSupplierAudit', ['id' => 'recordId']) }}",
                        "Complaint Management": "{{ route('marketcomplaint.marketcomplaint_view', ['id' => 'recordId']) }}",
                        "Risk Assessment": "{{ route('showRiskManagement', ['id' => 'recordId']) }}",
                        "Equipment Lifecycle": "{{ route('showEquipmentInfo', ['id' => 'recordId']) }}",
                        "Lab Incident": "{{ route('ShowLabIncident', ['id' => 'recordId']) }}",
                        "Incident": "{{ route('incident-show', ['id' => 'recordId']) }}",
                        "External Audit": "{{ route('showExternalAudit', ['id' => 'recordId']) }}",
                        "Action Item": "{{ url('rcms/actionItem', ['id' => 'recordId']) }}",
                        "Extension": "{{ url('extension_newshow', ['id' => 'recordId']) }}",
                        "Effectiveness Check": "{{ url('effectiveness.show', ['id' => 'recordId']) }}",
                        "CAPA": "{{ url('capashow', ['id' => 'recordId']) }}",
                        "Preventive Maintenance": "{{ route('showpreventive', ['id' => 'recordId']) }}",
                        "Deviation": "{{ route('devshow', ['id' => 'recordId']) }}",
                        "Root Cause Analysis": "{{ route('root_show', ['id' => 'recordId']) }}",
                        "Calibration Management": "{{ route('showCalibrationDetails', ['id' => 'recordId']) }}",
                    };


                    data.forEach((row, index) => {
                        const tr = document.createElement('tr');
                        const routeName = processRoutes[process];

                        console.log('row', processRoutes[process]);

                        const detailUrl = processRoutes[process]?.replace('recordId', row.id) || '#';
                        console.log(detailUrl);


                        tr.innerHTML = `
                            <td>${index + 1}</td>
                            <td>
                                <a href="${detailUrl}" style="color: rgb(43, 43, 48);">
                                    ${String(row.id).padStart(4, '0')}
                                </a>
                            </td>
                            <td>${row.parent_id || '-'}</td>
                            <td>${row.division || '-'}</td>
                            <td>${row.type || row.form_type || '-'}</td>
                            <td>${row.initiated_through || '-'}</td>
                            <td>${row.description || '-'}</td>
                            <td>${row.intiation_date || '-'}</td>
                            <td>${row.originator || '-'}</td>
                            <td>${row.due_date || '-'}</td>
                            <td>${row.status || '-'}</td>
                        `;
                        tableBody.appendChild(tr);
                    });
                } else {
                    document.querySelector('#kpiTable tbody').innerHTML = `
                        <tr>
                            <td colspan="11" class="text-center">No records found.</td>
                        </tr>
                    `;
                }
            } else {
                console.error('Error fetching data:', res.data.message);
                document.querySelector('#kpiTable tbody').innerHTML = `
                    <tr>
                        <td colspan="11" class="text-center">Failed to fetch data.</td>
                    </tr>
                `;
            }
        } catch (err) {
            console.error('Error in API call:', err.message);
            document.querySelector('#kpiTable tbody').innerHTML = `
                <tr>
                    <td colspan="11" class="text-center">Failed to fetch data.</td>
                </tr>
            `;
        }
    }

    fetchAndRenderTable();
</script>

@endsection