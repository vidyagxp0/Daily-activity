@extends('frontend.rcms.layout.main_rcms')
@section('rcms_container')
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <script>
        function openTab(tabName, ele) {
            let buttons = document.querySelector('.process-groups').children;
            let tables = document.querySelector('.process-tables-list').children;
            for (let element of Array.from(buttons)) {
                element.classList.remove('active');
            }
            ele.classList.add('active')
            for (let element of Array.from(tables)) {
                element.classList.remove('active');
                if (element.getAttribute('id') === tabName) {
                    element.classList.add('active');
                }
            }
        }
    </script>

    <style>
        header .header_rcms_bottom {
            display: none;
        }

        .process-groups {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }
 

        .process-groups > div {
            flex: 1;
            text-align: center;
            background-color: white;
        }

        .process-groups .scope-bar {
            display: flex;
            justify-content: flex-start;
        }

        .process-groups .scope-bar .print-btn {
            margin-left: 5px;
        }

        .filter-bar {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .filter-item {
            display: flex;
            flex-direction: column;
            min-width: 200px;
        }

        .filter-item label {
            margin-bottom: 5px;
        }

        .table-responsive {
            height: 100vh;
            overflow-x: scroll;
        }

        @media (max-width: 768px) {
            .filter-item {
                flex: 1 1 100%;
                margin: 5px 0;
            }
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px 12px;
            text-align: center;
        }

        th {
            background-color: #f8f9fa;
        }

        .spinner-border {
            display: none;
        }

        .process-groups div{
            border-top : none;
            border-bottom:none;
        }
    </style>

    <div id="rcms-desktop">
    <div class="process-groups">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                            
                            
                            <!-- Dropdown Button for Export Options -->
                            <!-- <div class="process-groups"> -->
                            <div class="scope-bar" style="display: flex;  padding:10px;  justify-content: space-between;">
                            <div class="dropdown" style=" border-top : none; border-bottom:none;">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 80px;">
                                    Export 
                                </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{ route('export.csv.extension') }}">CSV Export</a>
                                    <a class="dropdown-item" href="{{ route('export.excel.extension') }}">Excel Export</a>
                                    <a class="dropdown-item" href="#" onclick="printTable()">Print</a>
                                </div>
                            </div>
                            <div class="active" onclick="openTab('internal-audit', this)"  style="padding: 12px;  border-top : none; border-bottom:none; margin-right: 650px;"> <strong> Due Date Extension Log </strong></div>
                            {{-- <button type="button" style="padding:" class="btn btn-primary" onclick="printTable()">Print</button> --}}

                            </div>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.7.2/axios.min.js" crossorigin="anonymous"></script>
                    <!-- Bootstrap and jQuery scripts for the dropdown to work -->
                    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
                    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        </div>
      

        <div class="main-content">
            <div class="container-fluid">
                <div class="process-tables-list
                ">
                    <div class="process-table active" id="internal-audit">
                        <div class="mt-1 mb-2 bg-white" style="height: auto; padding: 10px; margin: 5px;">
                            <div class="d-flex align-items-center">
                                <div class="filter-bar d-flex justify-content-between">
                                    <div class="filter-item">
                                        <label for="process">Priority</label>
                                        <select name="priority_data" id="priority_data" style ="width:200px; margin-right:20px;">
                                        <option value="">--Select--</option>
                                            <option value="High" >High</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                        </select>
                                    </div>

                                    <div class="filter-item">
                                        <label for="criteria">Division</label>
                                        <select class="form-control" name="division_id" id="site_location_codeextension" style="margin-right:20px;">
                                            <option value="">Select Records</option>
                                            <option value="1">Corporate Quality  Assurance (CQA)</option>
                                            <option value="2">Plant1</option>
                                            <option value="3">Plant2</option>
                                            <option value="4">Plant3</option>
                                            <option value="5">Plant4</option>
                                            <option value="6">C1</option>
                                            
                                        </select>
                                    </div>

                                    <div class="filter-item">
                                        <label for="date_from_capa">Date From</label>
                                        <input type="date" class="form-control" id="date_from_extension"  style="margin-right:20px;">
                                    </div>

                                    <div class="filter-item">
                                        <label for="date_to_capa">Date To</label>
                                        <input type="date" class="form-control" id="date_to_extension"  style="margin-right:20px;">
                                    </div>


                                    <div class="filter-item">
                                        <label for="datewise">Select Period</label>
                                        <select class="form-control" id="datewisecapa"  style="margin-right:30px;">
                                            <option value="all">Select</option>
                                            <option value="yearly">Yearly</option>
                                            <option value="quarterly">Quarterly</option>
                                            <option value="monthly">Monthly</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <style>
        th.sortable {
            cursor: pointer;
            /* color: #007bff; */
        }

        th.sortable:hover {
            /* text-decoration: underline; */
        }

        th.sorted-asc:after {
            content: ' ▲'; /* Up Arrow */
        }

        th.sorted-desc:after {
            content: ' ▼'; /* Down Arrow */
        }

        .spinner-border {
            display: none;
        }
    </style>

    <div id="rcms-desktop">
      
        <div class="main-content">
            <div class="container-fluid">
                <div class="process-tables-list">
                    <div class="process-table active" id="internal-audit">
                        <div class="table-block">
                            <div class="table-responsive" style="height: 300px">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="sortable" onclick="sortTable('id', this)">Sr No.</th>
                                            <th class="sortable" onclick="sortTable('extension_no', this)">Extension No.</th>
                                            <th class="sortable" onclick="sortTable('site_location_code', this)">Division</th>
                                            <th class="sortable" onclick="sortTable('priority_data', this)">Priority</th>
                                            <th class="sortable" onclick="sortTable('short_description', this)">Short Description</th>
                                            <th class="sortable" onclick="sortTable('initiation_date', this)">Initiation Date</th>
                                            <th class="sortable" onclick="sortTable('due_date', this)">Due Date</th>
                                            <th class="sortable" onclick="sortTable('related_records', this)">Related Records</th>
                                            <th class="sortable" onclick="sortTable('closing_date', this)">Extension Closing Date</th>
                                            <th class="sortable" onclick="sortTable('status', this)">Status</th>
                                        </tr>
                                    </thead>

                                    <tbody id="tableData">
                                        @include('frontend.forms.Logs.extension_data')
                                    </tbody>
                                </table>
                                <div style="margin-top: 10px; display: flex; justify-content: center;">
                                    <div class="spinner-border text-primary" role="status" id="spinner">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.7.2/axios.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        let sortState = {
            column: '',
            order: 'asc'
        };

        // Function to handle table sorting
        async function sortTable(column, element) {
            // Toggle the sorting order
            sortState.order = (sortState.column === column && sortState.order === 'asc') ? 'desc' : 'asc';
            sortState.column = column;

            // Update the UI to reflect the current sorting
            document.querySelectorAll('th').forEach(th => th.classList.remove('sorted-asc', 'sorted-desc'));
            element.classList.add(sortState.order === 'asc' ? 'sorted-asc' : 'sorted-desc');

            document.getElementById('spinner').style.display = 'inline-block';

            try {
                const postUrl = "{{ route('api.extension.filter') }}";
                const res = await axios.post(postUrl, {
                    ...filterData,
                    sort_column: sortState.column,
                    sort_order: sortState.order
                });

                if (res.data.status === 'ok') {
                    document.getElementById('tableData').innerHTML = res.data.body;
                }
            } catch (err) {
                console.log('Error in sortTable:', err.message);
            }

            document.getElementById('spinner').style.display = 'none';
        }

        const filterData = {
            departmentextension: null,
            division_extension: null,
            period: null,
            date_fromextension: null,
            date_to_extension: null,
            sort_column: '',
            sort_order: ''
        };

        $('#priority_data').change(function() {
            filterData.departmentextension = $(this).val();
            filterRecords();
        });

        $('#site_location_codeextension').change(function() {
            filterData.division_extension = $(this).val();
            filterRecords();
        });

        $('#date_from_extension').change(function() {
            filterData.date_fromextension = $(this).val();
            filterRecords();
        });

        $('#date_to_extension').change(function() {
            filterData.date_to_extension = $(this).val();
            filterRecords();
        });

        $('#datewise').change(function() {
            filterData.period = $(this).val();
            filterRecords();
        });

        async function filterRecords() {
            $('#tableData').html('');
            $('#spinner').show();

            try {
                const postUrl = "{{ route('api.extension.filter') }}";
                const res = await axios.post(postUrl, filterData);

                if (res.data.status === 'ok') {
                    $('#tableData').html(res.data.body);
                }
            } catch (err) {
                console.log('Error in filterRecords', err.message);
            }

            $('#spinner').hide();
        }

        function printTable() {
            const department = document.getElementById('priority_data').value;
            const division = document.getElementById('site_location_codeextension').value;
            const dateFrom = document.getElementById('date_from_extension').value;
            const dateTo = document.getElementById('date_to_extension').value;

            const url = `/api/print-extension?department=${department}&division=${division}&date_from=${dateFrom}&date_to=${dateTo}`;
            window.open(url, '_blank');
        }
    </script>
@endsection
