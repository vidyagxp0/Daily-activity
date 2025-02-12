@extends('frontend.layout.main')
@section('container')
    @php
        $users = DB::table('users')->select('id', 'name')->get();
        $divisions = DB::table('q_m_s_divisions')->select('id', 'name')->get();
        $departments = DB::table('departments')->select('id', 'name')->get();

    @endphp
<style>
        .progress-bars div {
            flex: 1 1 auto;
            border: 1px solid grey;
            padding: 5px;
            /* border-radius: 20px; */
            text-align: center;
            position: relative;
            /* border-right: none; */
            background: white;
        }

        .state-block {
            padding: 20px;
            margin-bottom: 20px;
        }

        .progress-bars div.active {
            background: green;
            font-weight: bold;
        }

        #change-control-fields>div>div.inner-block.state-block>div.status>div.progress-bars.d-flex>div:nth-child(1) {
            border-radius: 20px 0px 0px 20px;
        }

        #change-control-fields>div>div.inner-block.state-block>div.status>div.progress-bars.d-flex>div:nth-child(4) {
            border-radius: 0px 20px 20px 0px;

        }
    </style>
    <style>
        label.error {
            color: red;
        }
    </style>

    <script>
        $(document).ready(function() {
            let auditForm = $('form#auditform')

            $('#ChangesaveButton').on('click', function(e) {
                console.log('submit test')
                let isValid = auditForm.validate();

                if (!isValid) {
                    e.preventDefault();
                }
            })

        });
    </script>
    <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
        }
    </style>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(function() {
            $("#datepicker").datepicker();
        });
    </script>

    <script>
        function otherController(value, checkValue, blockID) {
            let block = document.getElementById(blockID)
            let blockTextarea = block.getElementsByTagName('textarea')[0];
            let blockLabel = block.querySelector('label span.text-danger');
            if (value === checkValue) {
                blockLabel.classList.remove('d-none');
                blockTextarea.setAttribute('required', 'required');
            } else {
                blockLabel.classList.add('d-none');
                blockTextarea.removeAttribute('required');
            }
        }
    </script>
    <script>
        function addAuditAgenda(tableId) {
            var table = document.getElementById(tableId);
            var currentRowCount = table.rows.length;
            var newRow = table.insertRow(currentRowCount);
            newRow.setAttribute("id", "row" + currentRowCount);
            var cell1 = newRow.insertCell(0);
            cell1.innerHTML = currentRowCount;

            var cell2 = newRow.insertCell(1);
            cell2.innerHTML = "<input type='text'>";

            var cell3 = newRow.insertCell(2);
            cell3.innerHTML = "<input type='date'>";

            var cell4 = newRow.insertCell(3);
            cell4.innerHTML = "<input type='time'>";

            var cell5 = newRow.insertCell(4);
            cell5.innerHTML = "<input type='date'>";

            var cell6 = newRow.insertCell(5);
            cell6.innerHTML = "<input type='time'>";

            var cell7 = newRow.insertCell(6);
            cell7.innerHTML =
                // '<select name="auditor"><option value="">-- Select --</option><option value="1">Amit Guru</option></select>'

                var cell8 = newRow.insertCell(7);
            cell8.innerHTML =
                // '<select name="auditee"><option value="">-- Select --</option><option value="1">Amit Guru</option></select>'

                var cell9 = newRow.insertCell(8);
            cell9.innerHTML = "<input type='text'>";
            for (var i = 1; i < currentRowCount; i++) {
                var row = table.rows[i];
                row.cells[0].innerHTML = i;
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#internalaudit-table').click(function(e) {

                function generateTableRow(serialNumber) {
                    var users = @json($users);

                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial_number[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="audit[]"></td>' +
                        '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"> <input type="text" id="scheduled_start_date' +
                        serialNumber +
                        '" readonly placeholder="DD-MMM-YYYY" /><input type="date" name="scheduled_start_date[]" id="scheduled_start_date' +
                        serialNumber +
                        '_checkdate" min="{{ \Carbon\Carbon::now()->format('
                                        Y - m - d ') }}"  class="hide-input" oninput="handleDateInput(this, scheduled_start_date' +
                        serialNumber + ');checkDate(scheduled_start_date' + serialNumber +
                        '_checkdate,scheduled_end_date' + serialNumber +
                        '_checkdate)" /></div></div></div></td>' +
                        '<td><input type="time" name="scheduled_start_time[]"></td>' +
                        '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"> <input type="text" id="scheduled_end_date' +
                        serialNumber +
                        '" readonly placeholder="DD-MMM-YYYY" /><input type="date" name="scheduled_end_date[]" id="scheduled_end_date' +
                        serialNumber +
                        '_checkdate"  min="{{ \Carbon\Carbon::now()->format('
                                        Y - m - d ') }}"class="hide-input" oninput="handleDateInput(this, scheduled_end_date' +
                        serialNumber + ');checkDate(scheduled_start_date' + serialNumber +
                        '_checkdate,scheduled_end_date' + serialNumber +
                        '_checkdate)" /></div></div></div></td>' +
                        '<td><input type="time" name="scheduled_end_time[]"></td>' +
                        '<td><select name="auditor[]">' +
                        '<option value="">Select a value</option>';

                    for (var i = 0; i < users.length; i++) {
                        html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    }

                    html += '</select></td>' +
                        '<td><select name="auditee[]">' +
                        '<option value="">Select a value</option>';

                    for (var i = 0; i < users.length; i++) {
                        html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    }
                    html += '</select></td>' +
                        '<td><input type="text" name="remarks[]"></td>' +
                        '</tr>';

                    return html;
                }

                var tableBody = $('#internalaudit tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $('#attachmentgrid-table').click(function(e) {

                function generateTableRow(serialNumber) {
                    var users = @json($users);

                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="trainer_listOfAttachment[' + serialNumber +
                        '][serial_number]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="trainer_listOfAttachment[' + serialNumber +
                        '][title_of document]"></td>' +
                        '<td><input type="text" name="trainer_listOfAttachment[' + serialNumber +
                        '][supporting_document]"></td>' +
                        '<td><input type="text" name="trainer_listOfAttachment[' + serialNumber +
                        '][remarks]"></td>' +
                        '</tr>';

                    // for (var i = 0; i < users.length; i++) {
                    //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    // }


                    '</tr>';

                    return html;
                }

                var tableBody = $('#attachmentgrid tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#Trainer_Skill_table').click(function(e) {

                function generateTableRow(serialNumber) {
                    var users = @json($users);

                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="trainer_skill[' + serialNumber +
                        '][serial_number]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="trainer_skill[' + serialNumber +
                        '][Trainer_skill_set]"></td>' +

                        '<td><input type="text" name="trainer_skill[' + serialNumber +
                        '][remarks]"></td>' +
                        '</tr>';

                    // for (var i = 0; i < users.length; i++) {
                    //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    // }


                    '</tr>';

                    return html;
                }

                var tableBody = $('#Trainer_Skill_table_details tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>



    <script>
        $(document).ready(function() {
            $('#ObservationAdd').click(function(e) {
                function generateTableRow(serialNumber) {

                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="jobResponsibilities[' + serialNumber +
                        '][serial]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="jobResponsibilities[' + serialNumber +
                        '][job]"></td>' +
                        '<td><input type="text" class="Document_Remarks" name="jobResponsibilities[' +
                        serialNumber + '][remarks]"></td>' +


                        '</tr>';

                    return html;
                }

                var tableBody = $('#job-responsibilty-table tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>

    <style>
        .calenderauditee {
            position: relative;
        }

        .new-date-data-field input.hide-input {
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
        }

        .new-date-data-field input {
            border: 1px solid grey;
            border-radius: 5px;
            padding: 5px 15px;
            display: block;
            width: 100%;
            background: white;
        }

        .calenderauditee input::-webkit-calendar-picker-indicator {
            width: 100%;
        }
    </style>
    <div class="form-field-head">

        <div class="division-bar">
            <strong>Department Wise Employees Job Role</strong>
            {{-- <strong>Site Division/Project</strong> : --}}
        </div>
    </div>



    {{-- ======================================
                    DATA FIELDS
    ======================================= --}}




    <div id="change-control-fields">
        <div class="container-fluid">

    <div class="modal fade" id="signature-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('dwse-stage-change', $dwe->id) }}" method="POST">
                    @csrf
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">E-Signature</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="mb-3 text-justify">
                            Please select a meaning and a outcome for this task and enter your username
                            and password for this task. You are performing an electronic signature,
                            which is legally binding equivalent of a hand written signature.
                        </div>
                        <div class="group-input">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment</label>
                            <input type="comment" name="comment">
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" data-bs-dismiss="modal">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
            </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="rejection-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('dwse-stage-reject', $dwe->id) }}" method="POST">
                    @csrf
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">E-Signature</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="mb-3 text-justify">
                            Please select a meaning and a outcome for this task and enter your username
                            and password for this task. You are performing an electronic signature,
                            which is legally binding equivalent of a hand written signature.
                        </div>
                        <div class="group-input">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment <span class="text-danger">*</span></label>
                            <input type="comment" name="comment" required>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" data-bs-dismiss="modal">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
<div class="inner-block state-block">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="main-head">Record Workflow </div>

                        <div class="d-flex" style="gap:20px;">
                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => $dwe->division_id])
                                    ->get();
                                $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                            @endphp
                            <!-- <button class="button_theme1"> <a class="text-white" href="{{ url('rootAuditTrial', $dwe->id) }}"> Audit Trail </a> </button> -->

                            @if ($dwe->stage == 1)
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                    Submit
                                </button>
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                    Cancel
                                </button>
                            @elseif ($dwe->stage == 2)
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                    More Info Required
                                </button>
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                    Reviewed
                                </button>
                            @elseif($dwe->stage == 3)
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                    More Info Required
                                </button>
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                    Approved
                                </button>
                            @endif
                            <button class="button_theme1"> <a class="text-white" href="{{ url('TMS') }}"> Exit</a> </button>
                        </div>

                    </div>
                    <div class="status">
                        <div class="head">Current Status</div>
                        @if ($dwe->stage == 0)
                            <div class="progress-bars">
                                <div class="bg-danger">Closed-Cancelled</div>
                            </div>
                        @else
                            <div class="progress-bars d-flex" style="">
                                @if ($dwe->stage >= 1)
                                    <div class="active">Opened</div>
                                @else
                                    <div class="">Opened</div>
                                @endif

                                @if ($dwe->stage >= 2)
                                    <div class="active">In Review</div>
                                @else
                                    <div class="">In Review</div>
                                @endif

                                @if ($dwe->stage >= 3)
                                    <div class="active">For Approval</div>
                                @else
                                    <div class="">For Approval</div>
                                @endif

                                @if ($dwe->stage >= 4)
                                    <div class="active bg-danger">Closed - Done</div>
                                @else
                                    <div class="">Closed - Done</div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

            <!-- Tab links -->
            <div class="cctab">
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Reviewer Remarks</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Approval Remarks</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Activity Log</button>
            </div>

            <script>
                $(document).ready(function() {
                    <?php if (in_array($dwe->stage, [4,0])) : ?>
                    $("#target :input").prop("disabled", true);
                    <?php endif; ?>
                });
            </script>

            <form id="target" action="{{ route('departmentwise_update', $dwe->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                 @method('PUT')
                <div id="step-form">

                    <!-- General information content -->
                    <!-- <div id="CCForm1" class="inner-block cctabcontent"> -->


                    <div id="CCForm1" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">




                           <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Site/Location">Site/Location<span class="text-danger">*</span></label>
                            <select id="training-select" name="location" onchange="toggleMultiSelect()" required>
                                <option value="">Select Division</option>
                                <option value="P1(Indore Location)" @if ($dwe->location == 'P1(Indore Location)') selected @endif>P1 (Indore Location)</option>
                                <option value="P2(Pithampur Location)" @if ($dwe->location == 'P2(Pithampur Location)') selected @endif>P2 (Pithampur Location)</option>
                                <option value="P4(Ujjain Site)" @if ($dwe->location == 'P4(Ujjain Site)') selected @endif>P4 (Ujjain Site)</option>
                                <option value="C1(China Plant)" @if ($dwe->location == 'C1(China Plant)') selected @endif>C1 (China Plant)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="year">Year<span class="text-danger">*</span></label>
                            <select name="year" required>
                                <option value="">-- Select --</option>
                                <option value="2024" @if ($dwe->year == '2024') selected @endif>2024</option>
                            </select>
                        </div>
                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="employee_name">Reviewer<span class="text-danger">*</span></label>

                                            <select name="reviewer" id="reviewer" required>
                                                <option value="">-- Select --</option>
                                                @foreach ($users as $user)
                                                <option value="{{ $user->id }}" @if ($user->id == $dwe->reviewer) selected @endif>{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="employee_name">Approver<span class="text-danger">*</span></label>

                                            <select name="approver" id="approver" required>
                                                <option value="">-- Select --</option>
                                                @foreach ($users as $user)
                                                <option value="{{ $user->id }}" @if ($user->id == $dwe->approver) selected @endif>{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                    {{-- <div class="col-lg-6">
                        <div class="group-input">
                            <label for="document_number">Document Number</label>
                            <select name="document_number" id=""
                                 onchange="fetchSopLink2(this)">
                                 <option value="">---Select Document Number---</option>
                                 @foreach ($ref_doc as $dat)
                                     <option value="{{ $dat->id }}"
                                         data-doc-number="{{ $dat->sop_type_short }}/{{ $dat->department_id }}/000{{ $dat->id }}/R{{ $dat->major }}"
                                         data-sop-id="{{ $dat->id }}"
                                         {{ $dwe->document_number == $dat->id ? 'selected' : '' }}>
                                         {{ $dat->sop_type_short }}/{{ $dat->department_id }}/000{{ $dat->id }}/R{{ $dat->major }}
                                     </option>
                                 @endforeach
                            </select>
                        </div>
                    </div> --}}

{{-- <div class="col-lg-6">
    <div class="group-input">
        <label for="document_number">Document Number <span class="text-danger">*</span></label>
        <select name="document_number[]" id="document_number" data-multiple="true" multiple required>
            <option value="">---Select Document Number---</option>
            @foreach ($ref_doc as $dat)
                <option value="{{ $dat->id }}"
                    data-doc-number="{{ $dat->sop_type_short }}/{{ $dat->department_id }}/000{{ $dat->id }}/R{{ $dat->major }}"
                    data-sop-id="{{ $dat->id }}"
                    @if(in_array($dat->id, $selectedDocumentNumbers)) selected @endif>
                    {{ $dat->sop_type_short }}/{{ $dat->department_id }}/000{{ $dat->id }}/R{{ $dat->major }}
                </option>
            @endforeach
        </select>
    </div>
</div> --}}

<!-- <div class="col-lg-6">
    <div class="group-input">
        <label for="document_number">Document Number <span class="text-danger">*</span></label>
        <select name="document_number[]" id="document_number" required multiple>
            <option value="">---Select Document Number---</option>
            @foreach ($ref_doc as $dat)
                <option value="{{ $dat->id }}"
                    data-doc-number="{{ $dat->sop_type_short }}/{{ $dat->department_id }}/000{{ $dat->id }}/R{{ $dat->major }}"
                    data-sop-id="{{ $dat->id }}"
                    {{ in_array($dat->id, (array) $dwe->document_number) ? 'selected' : '' }}>
                    {{ $dat->sop_type_short }}/{{ $dat->department_id }}/000{{ $dat->id }}/R{{ $dat->major }}
                </option>
            @endforeach
        </select>
    </div>
</div> -->
<div class="col-6">
  <div class="group-input">
    <label for="Reference Document">Document Number<span class="text-danger">*</span></label>
    <select name="document_number[]" id="document_number" data-multiple="true" multiple required>
        <option value="">----Select---</option>
        @foreach ($ref_doc as $item)
            <option value="{{ $item->id }}"
                {{ in_array($item->id, $selectedDocumentNumbers) ? 'selected' : '' }}>
                {{ $item->sop_type_short }}/{{ $item->department_id }}/000{{ $item->id }}/R{{ $item->major }}
            </option>
        @endforeach
    </select>
   </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    VirtualSelect.init({
        ele: '#document_number',
        multiple: true,
        search: true,
        placeholder: '----Select---',
        disableSelectAll: true,
        dropboxWidth: '100%'
    });
});
</script>


<!-- <script>
        VirtualSelect.init({
        ele: '#document_number',
        multiple: true,
        search: true, 
        placeholder: '----Select---',
        disableSelectAll: true,
        dropboxWidth: '100%'
    });
</script> -->




        <div class="col-lg-6">
            <div class="group-input">
                <label for="department">Department<span class="text-danger">*</span></label>
                <select id="department" name="department" onchange="fetchEmployees()">
                    <option value="">-- Select Department --</option>
                    @foreach (Helpers::getDepartments() as $code => $department)
                        <option value="{{ $code }}" {{ $dwe->department == $code ? 'selected' : '' }}>
                            {{ $department }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="group-input">
                <label for="employee_name">Name of Employee <span class="text-danger">*</span></label>
                <select name="employee_name" id="employee_name">
                    <option value="">-- Select Employee --</option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}" {{ $dwe->employee_name == $employee->id ? 'selected' : '' }}>
                            {{ $employee->employee_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
                        <!-- <div class="col-lg-6">
                            <div class="group-input">
                                <label for="employee_code">Employee Code</label>
                                <input type="text" name="employee_code" id="employee_code" value="{{ $dwe->employee_code ?? '' }}" readonly>
                            </div>
                        </div> -->


                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="job_role">Job Role <span class="text-danger">*</span></label>
                            <select name="job_role[]" id="job_role" data-multiple="true" multiple required>
                                <option value="">Enter Your Selection Here</option>
                                <option value="Purchasing Manager" @if(in_array('Purchasing Manager', $selectedJobRoles)) selected @endif>Purchasing Manager</option>
                                <option value="IT Manager" @if(in_array('IT Manager', $selectedJobRoles)) selected @endif>IT Manager</option>
                                <option value="HR Manager" @if(in_array('HR Manager', $selectedJobRoles)) selected @endif>HR Manager</option>
                                <option value="Customer Support" @if(in_array('Customer Support', $selectedJobRoles)) selected @endif>Customer Support</option>
                                <option value="Project Manager" @if(in_array('Project Manager', $selectedJobRoles)) selected @endif>Project Manager</option>
                                <option value="Shift Technician" @if(in_array('Shift Technician', $selectedJobRoles)) selected @endif>Shift Technician</option>
                                <option value="Senior QA Officer" @if(in_array('Senior QA Officer', $selectedJobRoles)) selected @endif>Senior QA Officer</option>
                                <option value="Secretary Administrator" @if(in_array('Secretary Administrator', $selectedJobRoles)) selected @endif>Secretary/Administrator</option>
                                <option value="QA Officer" @if(in_array('QA Officer', $selectedJobRoles)) selected @endif>QA Officer</option>
                                <option value="Deputy GM" @if(in_array('Deputy GM', $selectedJobRoles)) selected @endif>Manager/Shift Manager</option>
                                <option value="GMT Trainer" @if(in_array('GMT Trainer', $selectedJobRoles)) selected @endif>GMT Trainer</option>
                                <option value="GMP Training Administrator" @if(in_array('GMP Training Administrator', $selectedJobRoles)) selected @endif>GMP Training Administrator</option>
                                <option value="Doc Control Officer" @if(in_array('Doc Control Officer', $selectedJobRoles)) selected @endif>Doc Control Officer</option>
                                <option value="Compliance Training Manager" @if(in_array('Compliance Training Manager', $selectedJobRoles)) selected @endif>Compliance Training Manager</option>
                                <option value="Cleaning Technician" @if(in_array('Cleaning Technician', $selectedJobRoles)) selected @endif>Cleaning Technician</option>
                                <option value="Administrator" @if(in_array('Administrator', $selectedJobRoles)) selected @endif>Administrator</option>
                            </select>
                        </div>
                    </div>

                    <script>
                            VirtualSelect.init({
                            ele: '#job_role', 
                            multiple: true,
                            search: true,  
                            placeholder: '----Select---', // Placeholder text for the dropdown
                            disableSelectAll: true, // Optional: Disable 'Select All' option if not needed
                            dropboxWidth: '100%'    // Make dropdown width responsive to the container
                        });
                    </script>


                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="start_date">Start Date</label>
                                        <input id="start_date" type="date" name="start_date"
                                            value="{{ $dwe->start_date }}" onchange="setMinEndDate()">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="end_date">End Date</label>
                                        <input id="end_date" type="date" name="end_date"
                                            value="{{ $dwe->end_date }}" onchange="setMaxStartDate()">
                                    </div>
                                </div>

                            <script>
                                function setMinEndDate() {
                                    var startDate = document.getElementById('start_date').value;
                                    document.getElementById('end_date').min = startDate; 
                                }

                                function setMaxStartDate() {
                                    var endDate = document.getElementById('end_date').value;
                                    document.getElementById('start_date').max = endDate;
                                }
                            </script>

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Prepared_by">Prepared By </label>
                            <input type="text" name="Prepared_by" value="{{ $dwe->Prepared_by }}" readonly>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Prepared_date">Prepared On </label>
                            <input type="date" name="Prepared_date" value="{{ $dwe->Prepared_date }}" readonly>
                        </div>
                    </div>

                    <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="evaluation">Minimum Sop View Time(in min)</label>
                                    <input type="number" min="0" name="total_minimum_time" id="" value="{{ $dwe->total_minimum_time }}">
                                </div>
                            </div>
                    <div class="col-lg-6">
                        <div class="group-input">
                           <label for="evaluation">Maximum Sop View Time(in min)</label>
                                    <input type="number" min="0" name="per_screen_run_time" id="" value="{{ $dwe->per_screen_run_time }}">
                                </div>
                            </div>


                    <script>
                        function fetchEmployees() {
                            var department = document.getElementById('department').value;

                            if (department) {
                                fetch(`/api/employees?department=${department}`)
                                    .then(response => response.json())
                                    .then(data => {
                                        var employeeSelect = document.getElementById('employee_name');
                                        employeeSelect.innerHTML = '<option value="">-- Select Employee --</option>';

                                        data.forEach(function(employee) {
                                            var option = document.createElement('option');
                                            option.value = employee.id;
                                            option.text = employee.employee_name;
                                            employeeSelect.appendChild(option);
                                        });
                                    });
                            } else {
                                document.getElementById('employee_name').innerHTML = '<option value="">-- Select Employee --</option>';
                            }
                        }
                    </script>
                    </div>

                            <div class="button-block">
                                <button type="submit" id="" class="saveButton">Save</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                {{-- <button type="button"> <a href="{{ url('TMS') }}" class="text-white">
                             Exit </a> </button> --}}

                            </div>
                        </div>
                    </div>

                    <div id="CCForm2" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Activated On">Remarks</label>
                                    <textarea name="reviewer_remark">{{ $dwe->reviewer_remark }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="External Attachment">Reviewer Attachment</label>
                                    <input type="file" id="myfile" name="reviewer_remark_attachment"
                                        value="{{ $dwe->reviewer_remark_attachment }}">
                                    <a href="{{ asset('upload/' . $dwe->reviewer_remark_attachment) }}"
                                        target="_blank">{{ $dwe->reviewer_remark_attachment }}</a>
                                </div>
                            </div>

                        </div>
                        <div class="button-block">
                        <button type="submit" id="" class="saveButton">Save</button>
                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                        <button type="button" class="backButton">Back</button>
                        <!-- <button type="button" id="ChangeNextButton" class="nextButton">Next</button> -->

                        </div>
                    </div>
                </div>

                <div id="CCForm3" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Activated On">Remarks</label>
                                    <textarea name="approval_remark">{{ $dwe->approval_remark }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="External Attachment">Approval Attachment</label>
                                    <input type="file" id="myfile" name="approval_remark_attachment"
                                        value="{{ $dwe->approval_remark_attachment }}">
                                    <a href="{{ asset('upload/' . $dwe->approval_remark_attachment) }}"
                                        target="_blank">{{ $dwe->approval_remark_attachment }}</a>
                                </div>
                            </div>

                        </div>
                        <div class="button-block">
                        <button type="submit" id="" class="saveButton">Save</button>
                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                        <button type="button" class="backButton">Back</button>
                        <!-- <button type="button" id="ChangeNextButton" class="nextButton">Next</button> -->

                        </div>
                    </div>
                </div>
                    <!-- Activity Log content -->
                    <div id="CCForm4" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Submitted On">Submitted By</label>
                                        <div class="static">{{$dwe->submitted_by}}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Submitted On">Submitted On</label>
                                        <div class="static">{{$dwe->submitted_on}}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Activated On">Submitted Comment</label>
                                        <div class="static">{{$dwe->submitted_comment}}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Rejected On">Cancel By</label>
                                        <div class="static">{{$dwe->cancelled_by}}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Rejected On">Cancel On</label>
                                        <div class="static">{{$dwe->cancelled_on}}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Rejected On">Cancel Comment</label>
                                        <div class="static">{{$dwe->cancelled_comment}}</div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for=" Rejected By">Reviewed By</label>
                                        <div class="static">{{$dwe->reviewed_by}}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Rejected On">Reviewed On</label>
                                        <div class="static">{{$dwe->reviewed_on}}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Rejected On">Reviewed Comment</label>
                                        <div class="static">{{$dwe->reviewed_comment}}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Rejected On">Reject By</label>
                                        <div class="static">{{$dwe->inReviewToOpened_by}}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Rejected On">Reject On</label>
                                        <div class="static">{{$dwe->inReviewToOpened_on}}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Rejected On">Reject Comment</label>
                                        <div class="static">{{$dwe->inReviewToOpened_comment}}</div>
                                    </div>
                                </div>


                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Rejected On">Approved By</label>
                                        <div class="static">{{$dwe->approved_by}}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Rejected On">Approved On</label>
                                        <div class="static">{{$dwe->approved_on}}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Rejected On">Approved Comment</label>
                                        <div class="static">{{$dwe->approved_comment}}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Rejected On">More Info required By</label>
                                        <div class="static">{{$dwe->approvalToReview_by}}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Rejected On">More Info required On</label>
                                        <div class="static">{{$dwe->approvalToReview_on}}</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Rejected On">More Info required Comment</label>
                                        <div class="static">{{$dwe->approvalToReview_comment}}</div>
                                    </div>
                                </div>
                                

                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <!-- <button type="submit">Submit</button> -->
                                <button type="button"> <a href="{{ url('TMS') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>


    <style>
        #step-form>div {
            display: none
        }

        #step-form>div:nth-child(1) {
            display: block;
        }
    </style>
    <script>
        document.getElementById('myfile').addEventListener('change', function() {
            var fileListDiv = document.querySelector('.file-list');
            fileListDiv.innerHTML = ''; // Clear previous entries

            for (var i = 0; i < this.files.length; i++) {
                var file = this.files[i];
                var listItem = document.createElement('div');
                listItem.textContent = file.name;
                fileListDiv.appendChild(listItem);
            }
        });
    </script>


    <script>
        VirtualSelect.init({
            ele: '#Facility, #Group, #Audit, #Auditee ,#reference_record, #trainerSkillSet'
        });

        function openCity(evt, cityName) {
            var i, cctabcontent, cctablinks;
            cctabcontent = document.getElementsByClassName("cctabcontent");
            for (i = 0; i < cctabcontent.length; i++) {
                cctabcontent[i].style.display = "none";
            }
            cctablinks = document.getElementsByClassName("cctablinks");
            for (i = 0; i < cctablinks.length; i++) {
                cctablinks[i].className = cctablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }



        function openCity(evt, cityName) {
            var i, cctabcontent, cctablinks;
            cctabcontent = document.getElementsByClassName("cctabcontent");
            for (i = 0; i < cctabcontent.length; i++) {
                cctabcontent[i].style.display = "none";
            }
            cctablinks = document.getElementsByClassName("cctablinks");
            for (i = 0; i < cctablinks.length; i++) {
                cctablinks[i].className = cctablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";

            // Find the index of the clicked tab button
            const index = Array.from(cctablinks).findIndex(button => button === evt.currentTarget);

            // Update the currentStep to the index of the clicked tab
            currentStep = index;
        }

        const saveButtons = document.querySelectorAll(".saveButton");
        const nextButtons = document.querySelectorAll(".nextButton");
        const form = document.getElementById("step-form");
        const stepButtons = document.querySelectorAll(".cctablinks");
        const steps = document.querySelectorAll(".cctabcontent");
        let currentStep = 0;

        function nextStep() {
            // Check if there is a next step
            if (currentStep < steps.length - 1) {
                // Hide current step
                steps[currentStep].style.display = "none";

                // Show next step
                steps[currentStep + 1].style.display = "block";

                // Add active class to next button
                stepButtons[currentStep + 1].classList.add("active");

                // Remove active class from current button
                stepButtons[currentStep].classList.remove("active");

                // Update current step
                currentStep++;
            }
        }

        function previousStep() {
            // Check if there is a previous step
            if (currentStep > 0) {
                // Hide current step
                steps[currentStep].style.display = "none";

                // Show previous step
                steps[currentStep - 1].style.display = "block";

                // Add active class to previous button
                stepButtons[currentStep - 1].classList.add("active");

                // Remove active class from current button
                stepButtons[currentStep].classList.remove("active");

                // Update current step
                currentStep--;
            }
        }
    </script>

    <script>
        document.getElementById('initiator_group').addEventListener('change', function() {
            var selectedValue = this.value;
            document.getElementById('initiator_group_code').value = selectedValue;
        });
    </script>
    <script>
        var maxLength = 255;
        $('#docname').keyup(function() {
            var textlen = maxLength - $(this).val().length;
            $('#rchars').text(textlen);
        });
    </script>
<script>
    $(document).ready(function() {
        $('#employee_name').on('change', function() {
            // Get the selected employee's code from the correct data attribute
            var employeeCode = $(this).find(':selected').data('full-id');

            // Update the employee_code input field
            $('#employee_code').val(employeeCode);
        });
    });
</script>

@endsection


@section('footer_cdn')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"
        integrity="sha512-WMEKGZ7L5LWgaPeJtw9MBM4i5w5OSBlSjTjCtSnvFJGSVD26gE5+Td12qN5pvWXhuWaWcVwF++F7aqu9cvqP0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/additional-methods.min.js"
        integrity="sha512-TiQST7x/0aMjgVTcep29gi+q5Lk5gVTUPE9XgN0g96rwtjEjLpod4mlBRKWHeBcvGBAEvJBmfDqh2hfMMmg+5A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection
