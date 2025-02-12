@extends('frontend.layout.main')
@section('container')
    @php
        $users = DB::table('users')->select('id', 'name')->get();
        $ref_doc = DB::table('documents')->select('id')->get();
        $divisions = DB::table('q_m_s_divisions')->select('id', 'name')->get();
        $departments = DB::table('departments')->select('id', 'name')->get();

    @endphp

    <style>
        label.error {
            color: red;
        }
    </style>
    <style>
        .vscomp-wrapper.has-error .vscomp-toggle-button {
        border-color: #696969 !important;
        border-radius: 5px;
    }
    </style>
    <script>
        $(document).ready(function() {
            let auditForm = $('#auditform')

            $('#ChangesaveButton').on('click', function(e) {
                console.log('submit test')
                let isValid = auditForm.validate();

                if (!isValid) {
                    e.preventDefault();
                }
            })

        });
    </script>
    <script>
        $(document).ready(function() {          
            $('.mainForm').on('submit', function(e) {
                $('.on-submit-disable-button').prop('disabled', true);
            });
        })
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


            <!-- Tab links -->
            <div class="cctab">
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>

            </div>

            <form id="auditform" class="mainForm" action="{{ route('department-wise-store') }}" method="POST" enctype="multipart/form-data">
                @csrf
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
                                                <option value="P1(Indore Location)">P1 (Indore Location)</option>
                                                <option value="P2(Pithampur Location)">P2 (Pithampur Location)</option>
                                                <option value="P4(Ujjain Site)">P4 (Ujjain Site)</option>
                                                <option value="C1(China Plant)">C1 (China Plant)</option>
                                            </select>
                                        </div>
                                    </div>
                              

                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="repeat_nature">Year<span class="text-danger">*</span></label>
                                            <select name="year" id="" required>
                                                <option value="">-- Select --</option>
                                                <option value="2024">2024</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="employee_name">Reviewer<span class="text-danger">*</span></label>
                                            <select name="reviewer" id="reviewer" required>
                                                <option value="">-- Select --</option>
                                                @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
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
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="Reference Document">Document Number<span class="text-danger">*</span></label>
                        <select name="document_number[]" id="document_number" data-multiple="true" multiple required>
                            <option value="">----Select---</option>
                            @foreach ($data as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->sop_type_short }}/{{ $item->department_id }}/000{{ $item->id }}/R{{ $item->major }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                    VirtualSelect.init({
                        ele: '#document_number',  // Target your select element by ID
                        multiple: true,           // Enable multiple selection
                        search: true,             // Enable search functionality within the dropdown
                        placeholder: '----Select---', // Placeholder text for the dropdown
                        disableSelectAll: true,   // Optional: Disable 'Select All' option if not needed
                        dropboxWidth: '100%'      // Make dropdown width responsive to the container
                    });
                });

                </script>




                              {{-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="employee_id">Name of Employee</label>
                                    <select name="employee_name" id="employee_name">
                                        <option value="">-- Select --</option>
                                        @foreach($emp as $ss)
                                            <option value="{{ $ss->id }}" data-full-id="{{ $ss->full_employee_id }}">
                                                {{ $ss->employee_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}



                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="department">Department<span class="text-danger">*</span></label>
                                    <select id="department" name="department" onchange="fetchEmployees()" required>
                                        <option value="">-- Select Department --</option>
                                        @foreach (Helpers::getDepartments() as $code => $department)
                                            <option value="{{ $code }}" {{ old('department') == $code ? 'selected' : '' }}>
                                                {{ $department }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="employee_name">Name of Employee<span class="text-danger">*</span></label>
                                    <select name="employee_name" id="employee_name" required>
                                        <option value="">-- Select Employee --</option>
                                        <!-- Employees will be populated here -->
                                    </select>
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
                                                employeeSelect.innerHTML = '<option value="">-- Select Employee --</option>'; // Clear previous options

                                                data.forEach(function(employee) {
                                                    var option = document.createElement('option');
                                                    option.value = employee.id; // Store employee ID instead of name
                                                    option.text = employee.employee_name;
                                                    employeeSelect.appendChild(option);
                                                });
                                            });
                                    } else {
                                        document.getElementById('employee_name').innerHTML = '<option value="">-- Select Employee --</option>';
                                    }
                                }
                            </script>



                            <!-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="full_employee_id">Employee Code</label>
                                    <input type="text" name="employee_code" id="employee_code" value="" readonly>
                                </div>
                            </div> -->

                                {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                <script>
                                    $(document).ready(function() {
                                        // Listen for change events on the employee_name dropdown
                                        $('#employee_name').on('change', function() {
                                            // Get the full_employee_id from the selected option's data attribute
                                            var fullEmployeeId = $(this).find(':selected').data('full-id') || '';

                                            // Update the full_employee_id input field with the selected employee's full ID
                                            $('#full_employee_id').val(fullEmployeeId);
                                        });
                                    });
                                </script> --}}


                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Group Name">Job Role<span class="text-danger">*</span></label>
                                       <select name="job_role" id="job_role" data-multiple="true" multiple required>
                                            <option value="">Enter Your Selection Here</option>
                                            <option value="Purchasing Manager">Purchasing Manager</option>
                                            <option value="IT Manager">IT Manager</option>
                                            <option value="HR Manager">HR Manager</option>
                                            <option value="Customer Support">Customer Support</option>
                                            <option value="Project Manager">Project Manager</option>
                                            <option value="Shift Technician">Shift Technician</option>
                                            <option value="Senior QA Officer">Senior QA Officer</option>
                                            <option value="Secretary Administrator">Secretary/Administrator</option>
                                            <option value="QA Officer">QA Officer</option>
                                            <option value="Deputy GM">Manager/Shift Manager</option>
                                            <option value="GMT Trainer">GMT Trainer</option>
                                            <option value="GMP Training Administrator">GMP Training Administrator</option>
                                            <option value="Doc Control Officer">Doc Control Officer</option>
                                            <option value="Compliance Training Manager">Compliance Training Manager</option>
                                            <option value="Cleaning Technician">Cleaning Technician</option>
                                            <option value="Administrator">Administrator</option>
                                        </select>                                    </div>
                                </div>
                            <script>
                                    VirtualSelect.init({
                                    ele: '#job_role',  // Target your select element by ID
                                    multiple: true, // Enable multiple selection
                                    search: true,   // Enable search functionality within the dropdown
                                    placeholder: '----Select---', // Placeholder text for the dropdown
                                    disableSelectAll: true, // Optional: Disable 'Select All' option if not needed
                                    dropboxWidth: '100%'    // Make dropdown width responsive to the container
                                });
                            </script>

                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                            <label for="">Job Role </label>
                                            <input type="text" id="job_role" name="job_role" >
                                    </div>
                                </div> --}}

                            <!-- Start Date -->
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="start_date">Start Date</label>
                                    <input id="start_date" type="date" name="start_date" onchange="setMinEndDate()" >
                                </div>
                            </div>
                            
                            <!-- End Date -->
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="end_date">End Date</label>
                                    <input id="end_date" type="date" name="end_date" onchange="setMaxStartDate()" >
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
                                        <input type="text" name="Prepared_by" id=""
                                            value="{{ Auth::user()->name }}" readonly>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="employee_id">Prepared On </label>
                                        <input type="date" name="Prepared_date" value="{{ date('Y-m-d') }}" id="Prepared_date">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="evaluation">Minimum Sop View Time(in min)</label>
                                        <input type="number" min="0" name="total_minimum_time" id="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="evaluation">Maximum Sop View Time(in min)</label>
                                        <input type="number" min="0" name="per_screen_run_time" id="">
                                    </div>
                                </div>
                            </div>





                            <div class="button-block">
                                <button type="submit" id="ChangesaveButton" class="saveButton on-submit-disable-button">Save</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                {{-- <button type="button"> <a href="{{ url('TMS') }}" class="text-white">
                Exit </a> </button> --}}

                            </div>
                        </div>
                    </div>

                    <!-- <script>
                                    function fetchEmployeeDetails() {
                                    var selectElement = document.getElementById('employee_name');
                                    var selectedOption = selectElement.options[selectElement.selectedIndex];
                                    var employeeName = selectedOption.value;
                                    var employeeCode = selectedOption.getAttribute('data-code');
                                    var department = selectedOption.getAttribute('data-department');
                                    // var designation = selectedOption.getAttribute('data-designation');
                                    var job_role = selectedOption.getAttribute('data-job');
                                    var joining_date = selectedOption.getAttribute('data-joining-date');

                                    if (employeeName) {

                                        document.getElementById('employee_code').value = employeeCode || '';
                                        document.getElementById('department').value = department || 'NA';
                                        // document.getElementById('designation').value = designation || 'NA';
                                        document.getElementById('job_role').value = job_role || 'NA';

                                        document.getElementById('joining_date').value = joining_date || 'NA';

                                        selectElement.value = employeeName;
                                    } else {
                                        document.getElementById('employee_code').value = '';
                                        document.getElementById('department').value = '';
                                        document.getElementById('designation').value = '';
                                        document.getElementById('joining_date').value = '';
                                    }
                                }

                    </script> -->
                    <!-- Activity Log content -->
                    <div id="CCForm7" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Submitted On">Submitted By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Submitted On">Submitted On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Activated On">Submit Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for=" Rejected By">Accept JD Complete By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Rejected On">Accept JD Complete On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Rejected On">Accept JD Complete Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Rejected On">Accept By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Rejected On">Accept On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Rejected On">Accept Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Rejected On">Approval Complete By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Rejected On">Approval Complete On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Rejected On">Approval Complete Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Rejected On">Send To QA By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Rejected On">Send To QA On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Rejected On">Send To QA Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Rejected On">Closure By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Rejected On">Closure On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Rejected On">Closure Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Rejected On">Reject By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Rejected On">Reject On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Rejected On">Reject Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>


                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton on-submit-disable-button">Save</button>
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
    
@endsection


@section('footer_cdn')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"
        integrity="sha512-WMEKGZ7L5LWgaPeJtw9MBM4i5w5OSBlSjTjCtSnvFJGSVD26gE5+Td12qN5pvWXhuWaWcVwF++F7aqu9cvqP0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/additional-methods.min.js"
        integrity="sha512-TiQST7x/0aMjgVTcep29gi+q5Lk5gVTUPE9XgN0g96rwtjEjLpod4mlBRKWHeBcvGBAEvJBmfDqh2hfMMmg+5A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection
