@extends('frontend.rcms.layout.main_rcms')

<script>
    // Function to update the options of the second dropdown based on the selection in the first dropdown
    function updateQueryOptions() {
        var scopeSelect = document.getElementById('scope');
        var querySelect = document.getElementById('query');
        var scopeValue = scopeSelect.value;

        // Clear existing options in the query dropdown
        querySelect.innerHTML = '';

        // Add options based on the selected scope
        if (scopeValue === 'external_audit') {
            querySelect.options.add(new Option('Opened', '1'));
            querySelect.options.add(new Option('Audit Preparation', '2'));
            querySelect.options.add(new Option('Pending Audit', '3'));
            querySelect.options.add(new Option('Pending Response', '4'));
            querySelect.options.add(new Option('CAPA Execution in Progress', '5'));
            querySelect.options.add(new Option('Closed - Done', '6'));


        } else if (scopeValue === 'internal_audit') {
            querySelect.options.add(new Option('Opened', '1'));
            querySelect.options.add(new Option('Audit Preparation', '2'));
            querySelect.options.add(new Option('Pending Audit', '3'));
            querySelect.options.add(new Option('Pending Response', '4'));
            querySelect.options.add(new Option('CAPA Execution in Progress', '5'));
            querySelect.options.add(new Option('Closed - Done', '6'));

        } else if (scopeValue === 'capa') {
            querySelect.options.add(new Option('Opened', '1'));
            querySelect.options.add(new Option('Pending CAPA Plan', '2'));
            querySelect.options.add(new Option('CAPA In Progress', '3'));
            querySelect.options.add(new Option('Pending Approval', '4'));
            querySelect.options.add(new Option('Pending Actions Completion', '5'));
            querySelect.options.add(new Option('Closed - Done', '6'));

        }else if (scopeValue === 'Global Capa') {
            querySelect.options.add(new Option('Opened', '1'));
            querySelect.options.add(new Option('Pending CAPA Plan', '2'));
            querySelect.options.add(new Option('CAPA In Progress', '3'));
            querySelect.options.add(new Option('Pending Approval', '4'));
            querySelect.options.add(new Option('Pending Actions Completion', '5'));
            querySelect.options.add(new Option('Closed - Done', '6'));

        }
        else if (scopeValue === 'Preventive Maintenance') {
            querySelect.options.add(new Option('Opened', '1'));
            querySelect.options.add(new Option('Supervisor Review', '2'));
            querySelect.options.add(new Option('Work in Progress', '3'));
            querySelect.options.add(new Option('Pending QA Approval', '4'));
            querySelect.options.add(new Option('Closed - Done', '5'));

        } else if (scopeValue === 'audit_program') {
            querySelect.options.add(new Option('Opened', '1'));
            querySelect.options.add(new Option('Pending Approval', '2'));
            querySelect.options.add(new Option('Pending Audit', '3'));
            querySelect.options.add(new Option('Closed - Done', '4'));

        } else if (scopeValue === 'lab_incident') {
            querySelect.options.add(new Option('Opened', '1'));
            querySelect.options.add(new Option('Pending Incident Review ', '2'));
            querySelect.options.add(new Option('Pending Investigation', '3'));
            querySelect.options.add(new Option('Pending Activity Completion', '4'));
            querySelect.options.add(new Option('Pending CAPA', '5'));
            querySelect.options.add(new Option('Pending QA Review', '6'));
            querySelect.options.add(new Option('Pending QA Head Approve', '7'));
            querySelect.options.add(new Option('Close - Done', '8'));

        } else if (scopeValue === 'risk_assement') {
            querySelect.options.add(new Option('Opened', '1'));
            querySelect.options.add(new Option('Risk Analysis & Work Group Assignment', '2'));
            querySelect.options.add(new Option('Risk Processing & Action Plan', '3'));
            querySelect.options.add(new Option('Pending HOD Approval ', '4'));
            querySelect.options.add(new Option('Actions Items in Progress', '5'));
            querySelect.options.add(new Option('Residual Risk Evaluation', '6'));
            querySelect.options.add(new Option('Close - Done', '7'));

        } else if (scopeValue === 'root_cause_analysis') {
            querySelect.options.add(new Option('Opened', '1'));
            querySelect.options.add(new Option('Investigation in Progress', '2'));
            querySelect.options.add(new Option('Pending Group Review Discussion', '3'));
            querySelect.options.add(new Option('Pending Group Review', '4'));
            querySelect.options.add(new Option('Pending QA Review', '5'));
            querySelect.options.add(new Option('Close - Done', '6'));

        }else if (scopeValue === 'Out_Of_Calibration') {
            querySelect.options.add(new Option('Opened', '1'));
            querySelect.options.add(new Option('In Progress', '2'));
            querySelect.options.add(new Option('Close - Done', '3'));

        }else if (scopeValue === 'management_review') {
            querySelect.options.add(new Option('Opened', '1'));
            querySelect.options.add(new Option('In Progress', '2'));
            querySelect.options.add(new Option('Close - Done', '3'));

        } else if (scopeValue === 'extension') {
            querySelect.options.add(new Option('Opened', '1'));
            querySelect.options.add(new Option('Pending Approval', '2'));
            querySelect.options.add(new Option('Close - Done', '3'));

        } else if (scopeValue === 'documents') {
            querySelect.options.add(new Option('Opened', '1'));
            querySelect.options.add(new Option('Close - Cancel', '2'));
            querySelect.options.add(new Option('Close - Done', '3'));

        } else if (scopeValue === 'observation') {
            querySelect.options.add(new Option('Opened', '1'));
            querySelect.options.add(new Option('Pending CAPA Plan', '2'));
            querySelect.options.add(new Option('Pending Approval', '3'));
            querySelect.options.add(new Option('Pending Final Approval', '4'));
            querySelect.options.add(new Option('Close - Done', '5'));
        } else if (scopeValue === 'action_item') {
            querySelect.options.add(new Option('Opened', '1'));
            querySelect.options.add(new Option('Work in Progress', '2'));
            querySelect.options.add(new Option('Close - Done', '3'));

        } else if (scopeValue === 'effectiveness_check') {
            querySelect.options.add(new Option('Opened', '1'));
            querySelect.options.add(new Option('Check Effectiveness', '2'));
            querySelect.options.add(new Option('Close - Done', '3'));


        } else if (scopeValue === 'CC') {
            querySelect.options.add(new Option('Opened', '1'));
            querySelect.options.add(new Option('Under HOD Review', '2'));
            querySelect.options.add(new Option('Pending QA Review', '3'));
            querySelect.options.add(new Option('CFT Review', '4'));
            querySelect.options.add(new Option('Pending Change Implementation', '5'));
            querySelect.options.add(new Option('Close - Done', '6'));
        }
           

    }
</script>
<style>
    #short_width{
        display: inline-block;
    width: 320px !important;
    white-space: nowrap;
    overflow: hidden !important;
    text-overflow: ellipsis;
    }
    .table-container {
  overflow: auto;
  /* max-height: 350px;
  max-height: 350px; */
}

.table-header11 {
  position: sticky;
  top: 0;
  background-color: white;
  z-index: 1;
}

.table-body-new {
  margin-top: 30px;
}
.td_c{
    width: 100px !important;
}
.td_desc{
    width: 10px;
}
</style>
@section('rcms_container')
    <div id="rcms-dashboard">
        <div class="container-fluid">
            <div class="dash-grid">


                <div>
                    <div class="inner-block scope-table" style="height: calc(100vh - 170px); padding: 0;">
                       <div class="d-flex grid-block" style="gap: 7px;">
                            <div class="col-lg-2 group-input" >
                                <label for="scope">Process</label>
                                <select id="scope" name="form">
                                    <option value="">All Records</option>
                                    @foreach ($uniqueProcessNames as $ultraprocess)
                                        <option value="{{ $ultraprocess }}">{{ $ultraprocess }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2 group-input" >
                                <label for="query">Criteria</label>
                                <select id="query" name="stage">
                                    <option value="">All Records</option>
                                    <option value="Closed">Closed Records</option>
                                    <option value="Opened">Opened Records</option>
                                    <option value="Cancelled">Cancelled Records</option>
                                    <option value="">Initial Deviation Category= Minor</option>
                                    <option value="">Initial Deviation Category= Major</option>
                                    <option value="">Initial Deviation Category= Critical</option>
                                     <option value="">Post Categorization Of Deviation= Minor</option>
                                    <option value="">Post Categorization Of Deviation= Major</option>
                                    <option value="">Post Categorization Of Deviation= Critical</option>
                                </select>
                            </div>
                            <div class="col-lg-2 group-input" >
                                <label for="query">Time Period</label>
                                <select id="filterType">
                                    <option value="all">All Records</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="fortnight">Fortnight</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="quarterly">Quarterly</option>
                                    <option value="halfyearly">Half Yearly</option>
                                    <option value="annually">Annually</option>
                                    <option value="custom">Custom Date</option>
                                </select>
                            </div>

                            <div class="col-lg-2 group-input" >
                                <label for="start_date">Start Date:</label>
                                <input type="date" id="start_date" name="start_date" disabled style="width: 125px; height: 35px; margin-left: 5px; border-radius: 10px;">
                            </div>

                            <div class="col-lg-2 group-input" >
                                <label for="end_date">End Date:</label>
                                <input type="date" id="end_date" name="end_date" disabled style="width: 125px; height: 35px; margin-left:5px;    border-radius: 10px;">
                            </div>

                            <div  class="create" id="create-record-button" style="margin-bottom: 10px;">
                                <a href="{{ route('qms.dashboard', ['export' => 'pdf']) }}" class=""> <button class="button_theme1">Export</button> </a>
                            </div>
                        </div>

                        <style>
                
                    .grid-block {
                        display: flex;
                        flex-wrap: wrap;
                        gap: 15px; 
                        padding: 20px;
                        background-color: #f9f9f9; 
                        border: 1px solid #ddd;
                        border-radius: 10px;
                    }


                    .group-input {
                        display: flex;
                    flex-direction: column;
                    align-items: flex-start;
                    padding: 10px;
                    border: 1px solid #e0e0e0;
                    border-radius: 8px;
                    background-color: #fff;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                    
                    flex: 1; 
                    }


                    .group-input label {
                        font-weight: bold;
                        font-size: 14px;
                        margin-bottom: 5px; 
                        color: #000;
                    }


                    .group-input select,
                    .group-input input[type="date"] {
                        width: 100%;
                        padding: 8px 10px;
                        border: 1px solid #ccc;
                        border-radius: 5px;
                        font-size: 14px;
                        color: #000;
                        outline: none;
                        transition: border-color 0.3s ease;
                    }

                    .group-input select:focus,
                    .group-input input[type="date"]:focus {
                        border-color: #bfd0f2; 
                        box-shadow: 0 0 5px #bfd0f2;


                    .group-input input[disabled] {
                        background-color: #e9ecef; 
                        cursor: not-allowed;
                    }


                    @media (max-width: 768px) {
                        .grid-block {
                            flex-direction: column; 
                            gap: 10px;
                        }

                        .group-input {
                            width: 100%; 
                        }
                    }

                        </style>


                        <div class="main-scope-table table-container">
                        <div class="main-scope-table table-container">
                            <table class="table table-bordered" id="auditTable">
                                <thead class="table-header11">
                                    <tr>
                                        <th>ID</th>
                                        <th>Parent ID</th>
                                        <th>Division</th>
                                        <th>Process</th>
                                        <th>Initiated Through</th>
                                        <th class="td_desc">Short Description</th>
                                        <th>Date Opened</th>
                                        <th>Originator</th>
                                        <th> Due Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="searchTable">
                                    @php
                                        $table = json_encode($datag);
                                        $tables = json_decode($table);
                                        $total_count = count($datag);

                                    @endphp
                                    @foreach (collect($tables->data)->sortByDesc('date_open') as $datas)
                                        <tr>
                                            <td>
                                                @if ($datas->type == 'Sample Management I')
                                                    <a href="{{ route('showreceipt', $datas->id) }}" style="color: rgb(43, 43, 48)">
                                                        {{ str_pad(($total_count - $loop->index), 4, '0', STR_PAD_LEFT) }}
                                                    </a>
                                                    <a href="{{ url('rcms/qms-dashboard', $datas->id) }}/Sample Management I">
                                                        <div class="icon" onclick="showChild()" data-bs-toggle="tooltip"
                                                            title="Related Records">
                                                            {{-- <img src="{{ asset('user/images/single.png') }}" alt="..."
                                                                class="w-100 h-100"> --}}
                                                        </div>
                                                    </a>
                                                @elseif ($datas->type == 'Sample Management II')
                                                <a href="{{ route('edit-sample-planning', $datas->id) }}" style="color: rgb(43, 43, 48)">
                                                    {{ str_pad(($total_count - $loop->index), 4, '0', STR_PAD_LEFT) }}
                                                </a>
                                                <a href="{{ url('rcms/qms-dashboard', $datas->id) }}/Sample Management II">
                                                    <div class="icon" onclick="showChild()" data-bs-toggle="tooltip"
                                                        title="Related Records">
                                                        {{-- <img src="{{ asset('user/images/single.png') }}" alt="..."
                                                            class="w-100 h-100"> --}}
                                                    </div>
                                                </a>
                                                @elseif ($datas->type == 'Inventory Management')
                                                    <a href="{{ route('showinventory', $datas->id) }}" style="color: rgb(43, 43, 48)">
                                                        {{ str_pad(($total_count - $loop->index), 4, '0', STR_PAD_LEFT) }}
                                                    </a>
                                                    <a href="{{ url('rcms/qms-dashboard', $datas->id) }}/IM">
                                                        <div class="icon" onclick="showChild()" data-bs-toggle="tooltip"
                                                            title="Related Records">
                                                            {{-- <img src="{{ asset('user/images/single.png') }}" alt="..."
                                                                class="w-100 h-100"> --}}
                                                        </div>
                                                    </a>
                                                @elseif ($datas->type == 'Analytics Qualification')
                                                    <a href="{{ route('analytics_qualification.show', $datas->id) }}" style="color: rgb(43, 43, 48)">
                                                        {{ str_pad(($total_count - $loop->index), 4, '0', STR_PAD_LEFT) }}
                                                    </a>
                                                    <a href="{{ url('rcms/qms-dashboard', $datas->id) }}/IM">
                                                        <div class="icon" onclick="showChild()" data-bs-toggle="tooltip"
                                                            title="Related Records">
                                                        </div>
                                                    </a>
                                                @elseif ($datas->type == 'Stability Management')
                                                    <a href="{{ route('edit-stability-management', $datas->id) }}" style="color: rgb(43, 43, 48)">
                                                        {{ str_pad(($total_count - $loop->index), 4, '0', STR_PAD_LEFT) }}
                                                    </a>
                                                    <a href="{{ url('rcms/qms-dashboard', $datas->id) }}/edit-stability-management">
                                                        <div class="icon" onclick="showChild()" data-bs-toggle="tooltip"
                                                            title="Related Records">
                                                        </div>
                                                    </a>
                                                @elseif ($datas->type == 'ControlSample Details')
                                                <a href="{{ route('controleSampleShow', $datas->id) }}" style="color: rgb(43, 43, 48)">
                                                    {{ str_pad(($total_count - $loop->index), 4, '0', STR_PAD_LEFT) }}
                                                </a>
                                                <a href="{{ url('rcms/qms-dashboard', $datas->id) }}/controleSampleShow">
                                                    <div class="icon" onclick="showChild()" data-bs-toggle="tooltip"
                                                        title="Related Records">
                                                        {{-- <img src="{{ asset('user/images/single.png') }}" alt="..."
                                                            class="w-100 h-100"> --}}
                                                    </div>
                                                </a>
                                                @endif
                                               
                                            </td>
                                            @if ($datas->parent_id != null)
                                                <td>
                                                    {{ str_pad($datas->parent_id, 4, '0', STR_PAD_LEFT) }}
                                                </td>
                                            @else
                                                <td>
                                                    -
                                                </td>
                                            @endif
                                            <td class="viewdetails" data-id="{{ $datas->id }}"
                                                data-type="{{ $datas->type }}" data-bs-toggle="modal"
                                                data-bs-target="#record-modal">
                                                @if ($datas->division_id)
                                                    {{ Helpers::getDivisionName($datas->division_id) }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="viewdetails" data-id="{{ $datas->id }}"
                                                data-type="{{ $datas->type }}" data-bs-toggle="modal"
                                                data-bs-target="#record-modal" style="{{ $datas->type == 'Capa' ? 'text-transform: uppercase' : '' }}">
                                                {{ $datas->type }}
                                            </td>

                                            <td class="viewdetails" data-id="{{ $datas->id }}"
                                                data-type="{{ $datas->type }}" data-bs-toggle="modal"
                                                data-bs-target="#record-modal">
                                                {{ ucwords(str_replace('_', ' ', $datas->initiated_through)) }}
                                            </td>

                                            <td id="short_width" class="viewdetails" data-id="{{ $datas->id }}"
                                                data-type="{{ $datas->type }}" data-bs-toggle="modal"
                                                data-bs-target="#record-modal">
                                                {{ $datas->short_description }}
                                            </td>
                                            @php
                                                $date = new \DateTime($datas->date_open);
                                                $formattedDate = $date->format('d-M-Y H:i:s');
                                            @endphp

                                            <td class="viewdetails" data-id="{{ $datas->id }}"
                                                data-type="{{ $datas->type }}" data-bs-toggle="modal"
                                                data-bs-target="#record-modal">
                                                {{ $formattedDate }}
                                            </td>
                                            <td class="viewdetails" data-id="{{ $datas->id }}"
                                                data-type="{{ $datas->type }}" data-bs-toggle="modal"
                                                data-bs-target="#record-modal">
                                                {{ Helpers::getInitiatorName($datas->initiator_id) }}
                                            </td>
                                            <td class="viewdetails" data-id="{{ $datas->id }}"
                                                data-type="{{ $datas->type }}" data-bs-toggle="modal"
                                                data-bs-target="#record-modal">
                                                @if (property_exists($datas, 'due_date'))
                                                    {{ $datas->type !== 'Extension' ? Helpers::getdateFormat($datas->due_date) : ''  }}
                                                @endif
                                            </td>
                                            <td class="viewdetails" data-id="{{ $datas->id }}"
                                                data-type="{{ $datas->type }}" data-bs-toggle="modal"
                                                data-bs-target="#record-modal">
                                                {{ $datas->stage }}
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- <div class="scope-pagination">
                            {{ $datag->links() }}
                        </div>  --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-sm" id="record-modal">
        <div class="modal-contain">
            <div class="modal-dialog m-0">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body " id="auditTableinfo">
                        Please wait...
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function showChild() {
            $(".child-row").toggle();
        }

        $(".view-list").hide();

        function toggleview() {
            $(".view-list").toggle();
        }

        $("#record-modal .drop-list").hide();

        function showAction() {
            $("#record-modal .drop-list").toggle();
        }
    </script>
    <script type='text/javascript'>
        $(document).ready(function() {
            $('#auditTable').on('click', '.viewdetails', function() {
                var auditid = $(this).attr('data-id');
                var formType = $(this).attr('data-type');
                if (auditid > 0) {
                    var url = "{{ route('recordModalLims', ['id' => ':auditid', 'type' => ':formType']) }}";
                    url = url.replace(':auditid', auditid).replace(':formType', formType);

                    $('#auditTableinfo').empty();
                    $.ajax({
                        url: url,
                        dataType: 'json',
                        success: function(response) {
                            $('#auditTableinfo').append(response.html);
                            $('#record-modal').modal('show');
                        }
                    });
                }
            });
        });
    </script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#filterType').on('change', function() {
            var filterType = $(this).val();
            
            if (filterType === 'custom') {
                $('#start_date').removeAttr('disabled');
                $('#end_date').removeAttr('disabled');
            } else {
                $('#start_date').val('').attr('disabled', true);
                $('#end_date').val('').attr('disabled', true);
            }
        });

        $('#filterType, #start_date, #end_date').on('change', function() {
            var filterType = $('#filterType').val();
            var startDate = $('#start_date').val();
            var endDate = $('#end_date').val();

            $.ajax({
                url: "{{ route('qms.dashboard') }}",
                type: "GET",
                data: {
                    filterType: filterType,
                    start_date: startDate,
                    end_date: endDate
                },
                success: function(response) {
                    $('#searchTable').empty();

                    $.each(response.data, function(index, record) {
                        var row = '<tr>' +
                            '<td>' + record.record + '</td>' +
                            '<td>' + record.parent + '</td>' +
                            '<td>' + record.division_name + '</td>' +
                            '<td>' + record.type + '</td>' +
                            '<td>' + record.initiated_through + '</td>' +
                            '<td style="width: 400px;">' + record.short_description + '</td>' +
                            '<td>' + record.filter_date_opened + '</td>' +
                            '<td>' + record.filter_originator + '</td>' +
                            '<td>' + record.filter_due_date + '</td>' +
                            '<td>' + record.stage + '</td>' +
                            '</tr>';
                        $('#searchTable').append(row);
                    });
                }
            });
        });
    });
</script>

@endsection
