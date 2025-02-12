@extends('frontend.layout.main')
@section('container')
    @php
        $users = DB::table('users')->select('id', 'name')->get();
        $divisions = DB::table('q_m_s_divisions')->select('id', 'name')->get();
        $departments = DB::table('departments')->select('id', 'name')->get();

    @endphp
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
            let rowIndex =
                {{ !empty($documentData) ? count($documentData) : 0 }}; // Start index based on existing rows

            // Add new rows dynamically
            $('#addRowBtn').click(function() {
                const newRow = `
                <tr>
                    <input type="hidden" name="documentData[${rowIndex}][id]" value="">
                    <td><input type="text" value="${rowIndex + 1}" name="documentData[${rowIndex}][row]" readonly></td>
                    <td><input type="text" name="documentData[${rowIndex}][title_of_document]" style="border: 1px solid; height: 40px;"></td>
                    <td>
                        <div class="file-attachment-field">
                            <div class="file-attachment-list" id="file_${rowIndex}"></div>
                            <div class="add-btn">
                                <div>Add</div>
                                <input type="file" name="documentData[${rowIndex}][file][]" oninput="addMultipleFiles(this, 'file_${rowIndex}')" multiple>
                            </div>
                        </div>
                    </td>
                    <td><textarea name="documentData[${rowIndex}][remarks]"></textarea></td>
                    <td><button type="text" class="removeRowBtn">Remove</button></td>
                </tr>
            `;
                $('#dynamicGrid tbody').append(newRow);
                rowIndex++;
            });

            // Remove row functionality
            $(document).on('click', '.removeRowBtn', function() {
                $(this).closest('tr').remove();
                rowIndex--;
                updateRowNumbers();
            });

            // Function to update row numbers after deletion
            function updateRowNumbers() {
                $('#dynamicGrid tbody tr').each(function(index) {
                    $(this).find('td:first-child input').val(index + 1);
                });
            }
        });

        // Function to handle file attachments
        function addMultipleFiles(input, fileAttachmentId) {
            const fileListDiv = $('#' + fileAttachmentId);
            fileListDiv.empty(); // Clear any previous file list
            for (let i = 0; i < input.files.length; i++) {
                fileListDiv.append('<div>' + input.files[i].name + '</div>');
            }
        }
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
                        '<td><button type="text" class="removeRowBtn">Remove</button></td>' +
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
                    var users = @json($users);

                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="observation_id[]"></td>' +

                        +'<option value="">Select a value</option>';


                    html += '</select></td>' +

                        '<td><input type="text" name="observation_description[]"></td>' +
                        '<td><input type="text" name="area[]"></td>' +
                        '<td><input type="text" name="auditee_response[]"></td>'

                    '<option value="">Select a value</option>';

                    for (var i = 0; i < users.length; i++) {
                        html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    }

                    html += '</select></td>' +
                        '<td><button type="text" class="removeRowBtn">Remove</button></td>' +

                        '</tr>';

                    return html;
                }

                var tableBody = $('#onservation-field-table tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });

            // $(document).on('click', '.removeRowBtn', function() {
            //     $(this).closest('tr').remove();
            // });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.removeRowBtn').on('click', function() {
                $(this).closest('tr').remove();
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
    <style>
        .progress-bars div {
            flex: 1 1 auto;
            border: 1px solid grey;
            padding: 5px;
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

        #change-control-fields>div>div.inner-block.state-block>div.status>div.progress-bars.d-flex>div:nth-child(6) {
            border-radius: 0px 20px 20px 0px;

        }
    </style>
    <div class="form-field-head">

        <div class="division-bar" style="font-size: 22px; padding: 10px;  border-radius: 5px; color: #fff; display: flex; align-items: center;">
            <i class="fas fa-user-check" style="color: #fff; font-size: 26px; margin-right: 10px;"></i>
            <strong>Analytical Qualification</strong>
        </div>
        
    </div>



    {{-- ======================================
                    DATA FIELDS
    ======================================= --}}

    @php
        $division = DB::table('divisions')->get();
    @endphp


    <div id="change-control-fields">
        <div class="container-fluid">

            <div class="inner-block state-block">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="main-head"><i class="fas fa-tasks"></i> Record Workflow </div>

                    <div class="d-flex" style="gap:20px;">
                        @php
                            $userRoles = DB::table('user_roles')
                                ->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => $trainer->division_id])
                                ->get();
                            $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                        @endphp

                        <button class="button_theme1">
                            <a class="text-white" href="{{ route('analytics.audittrail', $trainer->id) }}"><i class="fas fa-history"></i> Audit Trail
                            </a>
                        </button>

                        @if ($trainer->stage == 1)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                <i class="fas fa-check"></i> Submit
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                <i class="fas fa-times"></i> Reject
                            </button>
                        @elseif($trainer->stage == 2)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                <i class="fas fa-sync-alt"></i> Update Complete
                            </button>
                            {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                        Reject
                    </button> --}}
                        @elseif($trainer->stage == 3)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                <i class="fas fa-check-circle"></i> Answer Complete
                            </button>
                        @elseif($trainer->stage == 4)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                <i class="fas fa-clipboard-check"></i> Evaluation Complete
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                <i class="fas fa-times"></i> Reject
                            </button>
                        @elseif($trainer->stage == 5)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                <i class="fas fa-graduation-cap"></i> Qualified
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                       <i class="fas fa-times"></i> Reject
                            </button>
                        @endif
                        <button class="button_theme1"><i class="fas fa-sign-out-alt"></i> <a class="text-white" href="{{ url('rcms/lims-dashboard') }}"> Exit
                            </a>
                        </button>


                    </div>

                </div>
                <div class="status">
                    <div class="head">Current Status</div>
                    {{-- ------------------------------By Pankaj-------------------------------- --}}
                    @if ($trainer->stage == 0)
                        <div class="progress-bars ">
                            <div class="bg-danger">Closed-Reject</div>
                        </div>
                    @else
                        <div class="progress-bars d-flex">
                            @if ($trainer->stage >= 1)
                                <div class="active">Opened</div>
                            @else
                                <div class="">Opened</div>
                            @endif

                            @if ($trainer->stage >= 2)
                                <div class="active">Pending Trainer Update</div>
                            @else
                                <div class="">Pending Trainer Update</div>
                            @endif

                            @if ($trainer->stage >= 3)
                                <div class="active">Trainee Answer</div>
                            @else
                                <div class="">Trainee Answer</div>
                            @endif

                            @if ($trainer->stage >= 4)
                                <div class="active">HOD Evaluation</div>
                            @else
                                <div class="">HOD Evaluation</div>
                            @endif
                            @if ($trainer->stage >= 5)
                                <div class="active">QA/CQA Head Approval</div>
                            @else
                                <div class="">QA/CQA Head Approval</div>
                            @endif

                            @if ($trainer->stage >= 6)
                                <div class="bg-danger">Closed - Done</div>
                            @else
                                <div class="">Closed - Done</div>
                            @endif
                    @endif


                </div>
                {{-- @endif --}}
                {{-- ---------------------------------------------------------------------------------------- --}}
            </div>
        </div>

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')"><i class="fas fa-info-circle"></i> General Information</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')"><i class="fas fa-question-circle"></i> Questionaries</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')"><i class="fas fa-user-check"></i> HOD Evaluation</button>

            <button class="cctablinks" onclick="openCity(event, 'CCForm4')"><i class="fas fa-check-circle"></i> QA/CQA Head Approval</button>
            @if ($trainer->stage >= 5)
                <button class="cctablinks" onclick="openCity(event, 'CCForm5')"><i class="fas fa-award"></i> Certificate</button>
            @endif
           

            <button class="cctablinks" onclick="openCity(event, 'CCForm6')"><i class="fas fa-clipboard-list"></i> Activity Log</button>
        </div>
        <script>
            $(document).ready(function() {
                <?php if ($trainer->stage == 6) : ?>
                $("#target :input").prop("disabled", true);
                <?php endif; ?>
            });
        </script>

        <form id="target" action="{{ route('analytics.update', $trainer->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div id="step-form">

                <!-- General information content -->
                <div id="CCForm1" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">

                            @if (!empty($parent_id))
                                <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                                <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                            @endif

                            <div class="sub-head">
                                <i class="fas fa-info-circle"></i> Analytics Information
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Site/Location">Site Division/Project</label>
                                    {{-- <select id="training-select" name="site_code" onchange="toggleMultiSelect()">
                                        <option value="">Select Division</option>
                                        <option value="Corporate Quality Assurance (CQA)"
                                            @if ($trainer->site_code == 'Corporate Quality Assurance (CQA)') selected @endif>
                                            Corporate Quality Assurance (CQA)</option>
                                        <option value="Plant 1"
                                            @if ($trainer->site_code == 'Plant 1') selected @endif>Plant 1
                                        </option>
                                        <option value="Plant 2" @if ($trainer->site_code == 'Plant 2') selected @endif>
                                           Plant 2</option>
                                        <option value="Plant 3" @if ($trainer->site_code == 'Plant 3') selected @endif>
                                           Plant 3</option>
                                        <option value="Plant 4" @if ($trainer->site_code == 'Plant 4') selected @endif>
                                           Plant 4</option>
                                        <option value="C1" @if ($trainer->site_code == 'C1') selected @endif>
                                           C1</option>
                                    </select> --}}
                                    <input disabled type="text"
                                            value="{{ Helpers::getDivisionName($trainer->division_id) }}">
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number">Select User :</label>
                                    <input readonly type="text" name="name_employee_display"
                                        id="name_employee_display" maxlength="255" value="{{ $trainer->employee_name }}">
                                    <input type="hidden" name="employee_name" value="{{ $trainer->employee_name }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator"><b>Initiator</b></label>
                                    <input readonly type="text" name="initiator" value="{{ Auth::user()->name }}">
                                    <input type="hidden" name="initiator" value="{{ Auth::user()->name }}">

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Date Due"><b>Date of Initiation</b></label>
                                    <input readonly type="text"
                                        value="{{ date('d-M-Y', strtotime($trainer->date_of_initiation)) }}"
                                        name="date_of_initiation">
                                    <input type="hidden"
                                        value="{{ date('d-M-Y', strtotime($trainer->date_of_initiation)) }}"
                                        name="date_of_initiation">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number">ID </label>
                                    <input readonly type="text" name="employee_id_display"
                                        value="{{ $trainer->employee_id }}">
                                    <input type="hidden" name="employee_id" value="{{ $trainer->employee_id }}">
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="department">Department</label>
                                    <input readonly type="text" id="department" name="department"
                                        value="{{ $trainer->department }}">
                                </div>
                            </div>



                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="designation">Designation<span class="text-danger">*</span></label>
                                    <input readonly type="text" id="designation" name="designation"
                                        value="{{ $trainer->designation }}">
                                </div>
                            </div>



                            <div class="col-lg-6">
                                <div class="group-input" id="repeat_nature">
                                    <label for="repeat_nature">Experience</label>
                                    <input readonly type="number" name="experience" id="experience"
                                        value="{{ $trainer->experience }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">HOD</label>
                                    <select id="select-state" placeholder="Select..." name="hod">
                                        <option value="">Select</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                @if ($user->id == $trainer->hod) selected @endif>{{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('hod')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>



                            <div class="col-6">
                                <div class="group-input">
                                    <label for="qualification">Qualification</label>
                                    <input readonly id="qualification" type="text" name="qualification"
                                        value="{{ $trainer->qualification }}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="training_date">Training Date</label>
                                    <input type="date" id="training_date" name="training_date"
                                        value="{{ $trainer->training_date }}">
                                </div>
                            </div>

                            <!-- Topic of Training -->
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="topic">Topic of Training</label>
                                    <input type="text" id="" name="topic" value="{{ $trainer->topic }}">
                                </div>
                            </div>

                            <!-- Type of Training -->
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="type">Type of Training</label>
                                    <select name="type" id="type">
                                        <option value="">--Select--</option>
                                        <option value="Technical" @if ($trainer->type == 'Technical') selected @endif>
                                            Technical</option>
                                        <option value="Non-Technical" @if ($trainer->type == 'Non-Technical') selected @endif>
                                            Non-Technical</option>
                                        <option value="Safety" @if ($trainer->type == 'Safety') selected @endif>Safety
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <!-- Evaluation Required -->
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="evaluation">Evaluation Required</label>
                                    <select name="evaluation">
                                        <option value="">--Select--</option>
                                        <option value="yes" @if ($trainer->evaluation == 'yes') selected @endif>Yes
                                        </option>
                                        <option value="no" @if ($trainer->evaluation == 'no') selected @endif>No
                                        </option>
                                    </select>
                                </div>
                            </div>



                            {{-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Site Division/Project">Site Division/Project</label>
                                    <input value="{{ $trainer->site_code }}" name="site_code" readonly >
                            <select name="division_id">
                                <option>-- Select --</option>
                                @foreach ($divisions as $division)
                                <option value="{{ $division->id }}" @if ($division->id == $trainer->division_id) selected @endif >{{ $division->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}

                            {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Site/Location Code </b></label>
                                        <input readonly type="text" name="site_code"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                    <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                </div>
            </div> --}}

                            {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator"><b>Site/Location Code</b></label>
                                        <input disabled type="text" name="site_code" value="PLANT">
                                        <input type="hidden" name="site_code" value="PLANT">

                                    </div>
                                </div> --}}

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">
                                        Assigned To <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="assigned_to">
                                        <option value="">Select</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                @if ($user->id == $trainer->assigned_to) selected @endif>{{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('assign_to')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Short Description<span
                                            class="text-danger">*</span></label><span id="rchars">255</span>
                                    characters remaining
                                    <input id="short_description" type="text" name="short_description"
                                        maxlength="255" value="{{ $trainer->short_description }}">
                                </div>
                            </div>

                            <div class="">


                                <script>
                                    function removeRow(button) {
                                        var row = button.closest('tr');
                                        row.parentNode.removeChild(row);
                                    }
                                </script>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Investigation"> List of Attachments<button type="button"
                                                id="addRowBtn">+</button></label>
                                        <table class="table table-bordered" id="dynamicGrid">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%;">Sr. No.</th>
                                                    <th style="width: 20%;">Title of Document</th>
                                                    <th style="width: 40%;">Supporting Document</th>
                                                    <th style="width: 20%;">Remarks</th>
                                                    <th style="width: 5%;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!empty($documentData))
                                                    @foreach ($documentData as $index => $document)
                                                        <tr>
                                                            <!-- Hidden field for existing document ID -->
                                                            <input type="hidden"
                                                                name="documentData[{{ $index }}][id]"
                                                                value="{{ $document['id'] }}">

                                                            <td><input type="text" value="{{ $index + 1 }}"
                                                                    name="documentData[{{ $index }}][row]"
                                                                    readonly></td>
                                                            <td><input type="text"
                                                                    name="documentData[{{ $index }}][title_of_document]"
                                                                    style="border: 1px solid; height: 40px;"
                                                                    value="{{ $document['title_of_document'] }}"></td>
                                                            <td>
                                                                <div class="file-attachment-field">
                                                                    <div class="file-attachment-list"
                                                                        id="file_{{ $index }}">
                                                                        @if (!empty($document['supporting_document']))
                                                                            @foreach (json_decode($document['supporting_document']) as $file)
                                                                                <h6 class="file-container text-dark"
                                                                                    style="background-color: rgb(243, 242, 240);">
                                                                                    <b>{{ $file }}</b>
                                                                                    <a href="{{ asset('upload/' . $file) }}"
                                                                                        target="_blank"><i
                                                                                            class="fa fa-eye text-primary"
                                                                                            style="font-size:20px; margin-right:-10px;"></i></a>
                                                                                    <a type="button" class="remove-file"
                                                                                        data-file-name="{{ $file }}"><i
                                                                                            class="fa-solid fa-circle-xmark"
                                                                                            style="color:red; font-size:20px;"></i></a>
                                                                                </h6>
                                                                            @endforeach
                                                                        @endif
                                                                    </div>
                                                                    <div class="add-btn">
                                                                        <div>Add</div>
                                                                        <input type="file"
                                                                            name="documentData[{{ $index }}][file][]"
                                                                            oninput="addMultipleFiles(this, 'file_{{ $index }}')"
                                                                            multiple>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <textarea name="documentData[{{ $index }}][remarks]">{{ $document['remarks'] }}</textarea>
                                                            </td>
                                                            <td><button type="text"
                                                                    class="removeRowBtn">Remove</button></td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                            <div class="sub-head">Evaluation Criteria</div>

                            <div class="col-12">
                                <div class="group-input">
                                    <div class="why-why-chart">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 7%;">Sr. No.</th>
                                                    <th style="width: 50%;">Evaluation Criteria</th>
                                                    <th>Rating</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Clarity Of Objectives</td>
                                                    <td>
                                                        <select name="evaluation_criteria_1" id="">
                                                            <option> -- Select --</option>
                                                            <option value="1"
                                                                @if ($trainer->evaluation_criteria_1 == '1') selected @endif> 1
                                                            </option>
                                                            <option value="2"
                                                                @if ($trainer->evaluation_criteria_1 == '2') selected @endif> 2
                                                            </option>
                                                            <option value="3"
                                                                @if ($trainer->evaluation_criteria_1 == '3') selected @endif> 3
                                                            </option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Delivery & Knowledge Of Content</td>
                                                    <td>
                                                        <select name="evaluation_criteria_2" id="">
                                                            <option> -- Select --</option>
                                                            <option value="1"
                                                                @if ($trainer->evaluation_criteria_2 == '1') selected @endif> 1
                                                            </option>
                                                            <option value="2"
                                                                @if ($trainer->evaluation_criteria_2 == '2') selected @endif> 2
                                                            </option>
                                                            <option value="3"
                                                                @if ($trainer->evaluation_criteria_2 == '3') selected @endif> 3
                                                            </option>

                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Oral & Written Languagee (Speaking
                                                        Style Was Clear, Easily understood , Pleasant to hear)</td>
                                                    <td>
                                                        <select name="evaluation_criteria_3" id="">
                                                            <option> -- Select --</option>
                                                            <option value="1"
                                                                @if ($trainer->evaluation_criteria_3 == '1') selected @endif> 1
                                                            </option>
                                                            <option value="2"
                                                                @if ($trainer->evaluation_criteria_3 == '2') selected @endif> 2
                                                            </option>
                                                            <option value="3"
                                                                @if ($trainer->evaluation_criteria_3 == '3') selected @endif> 3
                                                            </option>

                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>Is Research Up to Date?</td>
                                                    <td>
                                                        <select name="evaluation_criteria_4" id="">
                                                            <option> -- Select --</option>
                                                            <option value="1"
                                                                @if ($trainer->evaluation_criteria_4 == '1') selected @endif> 1
                                                            </option>
                                                            <option value="2"
                                                                @if ($trainer->evaluation_criteria_4 == '2') selected @endif> 2
                                                            </option>
                                                            <option value="3"
                                                                @if ($trainer->evaluation_criteria_4 == '3') selected @endif> 3
                                                            </option>

                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>Interactions With Participants</td>
                                                    <td>
                                                        <select name="evaluation_criteria_5" id="">
                                                            <option value=""> -- Select --</option>
                                                            <option value="1"
                                                                @if ($trainer->evaluation_criteria_5 == '1') selected @endif> 1
                                                            </option>
                                                            <option value="2"
                                                                @if ($trainer->evaluation_criteria_5 == '2') selected @endif> 2
                                                            </option>
                                                            <option value="3"
                                                                @if ($trainer->evaluation_criteria_5 == '3') selected @endif> 3
                                                            </option>

                                                        </select>
                                                    </td>


                                                </tr>
                                                <tr>
                                                    <td>6</td>
                                                    <td>Response To Participants</td>
                                                    <td>
                                                        <select name="evaluation_criteria_6" id="">
                                                            <option value=""> -- Select --</option>
                                                            <option value="1"
                                                                @if ($trainer->evaluation_criteria_6 == '1') selected @endif> 1
                                                            </option>
                                                            <option value="2"
                                                                @if ($trainer->evaluation_criteria_6 == '2') selected @endif> 2
                                                            </option>
                                                            <option value="3"
                                                                @if ($trainer->evaluation_criteria_6 == '3') selected @endif> 3
                                                            </option>

                                                        </select>
                                                    </td>


                                                </tr>
                                                <tr>
                                                    <td>7</td>
                                                    <td>Discussion Techniques</td>
                                                    <td>
                                                        <select name="evaluation_criteria_7" id="">
                                                            <option value=""> -- Select --</option>
                                                            <option value="1"
                                                                @if ($trainer->evaluation_criteria_7 == '1') selected @endif> 1
                                                            </option>
                                                            <option value="2"
                                                                @if ($trainer->evaluation_criteria_7 == '2') selected @endif> 2
                                                            </option>
                                                            <option value="3"
                                                                @if ($trainer->evaluation_criteria_7 == '3') selected @endif> 3
                                                            </option>

                                                        </select>
                                                    </td>


                                                </tr>
                                                <tr>
                                                    <td>8</td>
                                                    <td>Managed Pace Of The Training Well /
                                                        Created a Comfortable learning environment</td>
                                                    <td>
                                                        <select name="evaluation_criteria_8" id="">
                                                            <option value=""> -- Select --</option>
                                                            <option value="1"
                                                                @if ($trainer->evaluation_criteria_8 == '1') selected @endif> 1
                                                            </option>
                                                            <option value="2"
                                                                @if ($trainer->evaluation_criteria_8 == '2') selected @endif> 2
                                                            </option>
                                                            <option value="3"
                                                                @if ($trainer->evaluation_criteria_8 == '3') selected @endif> 3
                                                            </option>

                                                        </select>
                                                    </td>


                                                </tr>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="">
                            <div class="group-input">
                                <label for="trainingQualificationStatus">Qualification Status</label>
                                <select name="trainer" id="trainingQualificationStatus">
                                    <option>-- Select --</option>
                                    <option value="Qualified" @if ($trainer->trainer == 'Qualified') selected @endif>
                                        Qualified</option>
                                    <option value="Not Qualified" @if ($trainer->trainer == 'Not Qualified') selected @endif>
                                        Not Qualified</option>
                                </select>
                            </div>
                        </div> --}}

                        <div class="col-md-12 mb-3">
                            <div class="group-input">
                                <label for="Q_comment">Qualification Comments</label>
                                <textarea class="" name="qualification_comments">{{ $trainer->qualification_comments }}</textarea>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="group-input">
                                <label for="Inv Attachments">Initial Attachment</label>
                                <input type="file" id="myfile" name="initial_attachment"
                                    value="{{ $trainer->initial_attachment }}">
                                <a href="{{ asset('upload/' . $trainer->initial_attachment) }}"
                                    target="_blank">{{ $trainer->initial_attachment }}</a>
                            </div>
                        </div>
                        <script>
                            VirtualSelect.init({
                                ele: '#reference_record, #notify_to'
                            });

                            $('#summernote').summernote({
                                toolbar: [
                                    ['style', ['style']],
                                    ['font', ['bold', 'underline', 'clear', 'italic']],
                                    ['color', ['color']],
                                    ['para', ['ul', 'ol', 'paragraph']],
                                    ['table', ['table']],
                                    ['insert', ['link', 'picture', 'video']],
                                    ['view', ['fullscreen', 'codeview', 'help']]
                                ]
                            });

                            $('.summernote').summernote({
                                toolbar: [
                                    ['style', ['style']],
                                    ['font', ['bold', 'underline', 'clear', 'italic']],
                                    ['color', ['color']],
                                    ['para', ['ul', 'ol', 'paragraph']],
                                    ['table', ['table']],
                                    ['insert', ['link', 'picture', 'video']],
                                    ['view', ['fullscreen', 'codeview', 'help']]
                                ]
                            });

                            let referenceCount = 1;

                            function addReference() {
                                referenceCount++;
                                let newReference = document.createElement('div');
                                newReference.classList.add('row', 'reference-data-' + referenceCount);
                                newReference.innerHTML = `
                                        <div class="col-lg-6">
                                            <input type="text" name="reference-text">
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="file" name="references" class="myclassname">
                                        </div><div class="col-lg-6">
                                            <input type="file" name="references" class="myclassname">
                                        </div>
                                    `;
                                let referenceContainer = document.querySelector('.reference-data');
                                referenceContainer.parentNode.insertBefore(newReference, referenceContainer.nextSibling);
                            }
                        </script>

                        <script>
                            function removeHtmlTags() {
                                var textarea = document.getElementById("summernote-16");
                                var cleanValue = textarea.value.replace(/<[^>]*>?/gm, ''); // Remove HTML tags
                                textarea.value = cleanValue;
                            }
                        </script>

                        <div class="button-block">
                            <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button"> <a href="{{ url('TMS') }}" class="text-white">
                                    Exit </a> </button>
                        </div>
                    </div>
                </div>

                <div id="CCForm2" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="col-12 sub-head">
                            Questionaries
                        </div>
                        <div class="pt-2 group-input">
                            <label for="audit-agenda-grid">
                                Questionaries
                                <button type="button" name="audit-agenda-grid" id="ObservationAdd">+</button>
                                <span class="text-primary" data-bs-toggle="modal"
                                    data-bs-target="#observation-field-instruction-modal"
                                    style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                    (Launch Instruction)
                                </span>
                            </label>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="job-responsibilty-table" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">Sr No.</th>
                                            <th>Questions</th>
                                            <th>Answer Fillup by Employee</th>
                                            <th>Comments</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($employee_grid_data && is_array($employee_grid_data->data))
                                            @foreach ($employee_grid_data->data as $index => $employee_grid)
                                                <tr>
                                                    <td><input disabled type="text"
                                                            name="jobResponsibilities[{{ $loop->index }}][serial]"
                                                            value="{{ $loop->index + 1 }}"></td>
                                                    <td>
                                                        <input type="text"
                                                            name="jobResponsibilities[{{ $loop->index }}][job]"
                                                            value="{{ is_array($employee_grid) && array_key_exists('job', $employee_grid) ? $employee_grid['job'] : '' }}"
                                                            class="question-input">
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            name="jobResponsibilities[{{ $loop->index }}][remarks]"
                                                            value="{{ is_array($employee_grid) && array_key_exists('remarks', $employee_grid) ? $employee_grid['remarks'] : '' }}"
                                                            class="answer-input">
                                                    </td>

                                                    <td>
                                                        <input type="text"
                                                            name="jobResponsibilities[{{ $loop->index }}][comments]"
                                                            value="{{ is_array($employee_grid) && array_key_exists('comments', $employee_grid) ? $employee_grid['comments'] : '' }}"
                                                            class="answer-input">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td><input disabled type="text" name="jobResponsibilities[0][serial]"
                                                        value="1"></td>
                                                <td><input type="text" name="jobResponsibilities[0][job]"
                                                        class="question-input">
                                                </td>
                                                <td><input type="text" name="jobResponsibilities[0][remarks]"
                                                        class="answer-input">

                                                </td>
                                                <td><input type="text" name="jobResponsibilities[0][comments]"
                                                        class="answer-input">

                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>

                                </table>
                            </div>
                        </div>
                        <div class="button-block">
                            <button type="submit" class="saveButton" id="">Save</button>

                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                        </div>
                    </div>
                </div>
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

                <div id="CCForm3" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Activated On">Remarks</label>
                                    <textarea name="hod_comment">{{ $trainer->hod_comment }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="External Attachment">HOD Evaluation Attachment</label>
                                    <input type="file" id="myfile" name="hod_attachment"
                                        value="{{ $trainer->hod_attachment }}">
                                    <a href="{{ asset('upload/' . $trainer->hod_attachment) }}"
                                        target="_blank">{{ $trainer->hod_attachment }}</a>
                                </div>
                            </div>

                        </div>
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>

                        </div>
                    </div>
                </div>

                <div id="CCForm4" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Activated On">Remarks</label>
                                    <textarea name="qa_final_comment">{{ $trainer->qa_final_comment }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="External Attachment">QA/CQA Attachment</label>
                                    <input type="file" id="myfile" name="qa_final_attachment"
                                        value="{{ $trainer->qa_final_attachment }}">
                                    <a href="{{ asset('upload/' . $trainer->qa_final_attachment) }}"
                                        target="_blank">{{ $trainer->qa_final_attachment }}</a>
                                </div>
                            </div>

                        </div>
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <button type="button" class="backButton">Back</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>

                        </div>
                    </div>
                </div>

              

                @if ($trainer->stage >= 5)
                    <div id="CCForm5" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="button-block">
                                        <button type="button" class="printButton" onclick="downloadCertificate()">
                                            <i class="fas fa-print"></i> Print
                                        </button>
                                    </div>

                                    <div>
                                        <div class="pm-certificate-container">
                                            <div class="outer-border"></div>
                                            <div class="inner-border"></div>

                                            <div class="pm-certificate-border">
                                                <!-- Logos Section -->
                                                <div class="pm-certificate-logos text-center">
                                                        <img src="{{ asset('user/images/connexo.png') }}" alt="connexo Logo" class="logo logo-left">
                                                        {{-- <img src="{{ asset('user/images/symbiotec_pharmalab_pvt_ltd__logo.jpg') }}" alt="Vidhya GxP Logo" class="logo logo-left"> --}}
                                                    </div>

                                                <div class="pm-certificate-header">
                                                    <div class="pm-certificate-title cursive text-center">
                                                        <h2>Trainer Completion Certificate</h2>
                                                    </div>
                                                </div>

                                                <div class="pm-certificate-body">
                                                    <div class="certificate-description"><br><br>
                                            This is to certify that Mr./Ms./Mrs.
                                            <strong>{{ $trainer->employee_name }}</strong>.
                                            has undergone Training Qualification Trainer the requirement of cGMP and has
                                            shown a good attitude and thorough understanding in the subject.
                                        </div>

                                        <div class="certificate-description">
                                            Therefore we certify that Mr. Ms. / Mrs.
                                            <strong>{{ $trainer->name_employee }}</strong>.
                                            is capable of performing his/her assigned duties in the
                                            <strong>{{ $trainer->department }}</strong> Department independently.
                                        </div>

                                        <div class="pm-certificate-footer">
                                            <div class="pm-certified text-center">
                                                <span class="bold block">Sign / Date:</span>
                                            
                                                <span class="pm-empty-space block underline"></span>
                                                <span class="bold block">HR Head</span>
                                            </div>
                                            <div class="pm-certified text-center">
                                                <span class="bold block">Sign / Date:</span>
                                                
                                                <span class="pm-empty-space block underline"></span>
                                                <span class="bold block">Head QA/CQA</span>
                                            </div>
                                        </div>


                                                   
                                                </div>
                                            </div>
                                        </div>



                                        {{--<div style="margin-top: 40px;" class="button-block">
                                             <button type="submit" class="btn btn saveButton">Save</button>
                                        <button type="button" id="ChangeNextButton"
                                            class="btn btn nextButton">Next</button>
                                        </div>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                @endif
              

                <!-- CSS Styling -->
                <style>
                    @import url('https://fonts.googleapis.com/css?family=Open+Sans|Pinyon+Script|Rochester');

                    .cursive {
                        font-family: 'Pinyon Script', cursive;
                    }

                    .sans {
                        font-family: 'Open Sans', sans-serif;
                    }

                    .bold {
                        font-weight: bold;
                    }

                    .block {
                        display: block;
                    }

                    .underline {
                        border-bottom: 1px solid #777;
                        padding: 5px;
                        margin-bottom: 15px;
                    }

                    .text-center {
                        text-align: center;
                    }

                    .pm-empty-space {
                        /* height: 40px; */
                        width: 100%;
                    }

                    .pm-certificate-container {
                        position: relative;
                        width: 90%;
                        max-width: 800px;
                        background-color: #618597;
                        padding: 30px;
                        color: #333;
                        font-family: 'Open Sans', sans-serif;
                        box-shadow: 0 9px 15px rgb(18 5 23 / 60%);
                        margin-left:110px;
                        margin-top: 35px;
                    }

                    .outer-border {
                        position: absolute;
                        top: 0;
                        left: 0;
                        right: 0;
                        bottom: 0;
                        border: 2px solid #fff;
                        pointer-events: none;
                    }

                    .inner-border {
                        position: absolute;
                        top: 10px;
                        left: 10px;
                        right: 10px;
                        bottom: 10px;
                        border: 2px solid #fff;
                        pointer-events: none;
                    }

                    .pm-certificate-border {
                        position: relative;
                        padding: 20px;
                        border: 1px solid #E1E5F0;
                        background-color: rgba(255, 255, 255, 1);
                    }


                    .pm-certificate-logos {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;

                    }

                    .logo {
                        max-width: 100px;
                    }

                    .logo-left {
                        transform: scale(0.7);
                        margin-bottom: 14px;
                    }

                    .logo-right {
                        transform: scale(1.8);
                        margin-right: 65px;
                    }

                    .pm-certificate-header {
                        margin-bottom: 10px;
                    }

                    .pm-certificate-title h2 {
                        font-size: 34px;
                    }

                    .pm-certificate-body {
                        padding: 20px;
                        display: flex;
                        flex-direction: column;
                        text-align: left;
                        // align-items: center;
                    }


                    .pm-certificate-block {
                        text-align: left;
                    }

                    .pm-name-text {
                        font-size: 20px;
                    }

                    .pm-earned {
                        margin: 15px 0 20px;
                    }

                    .pm-earned-text {
                        font-size: 20px;
                    }

                    .pm-credits-text {
                        font-size: 15px;
                    }

                    .pm-course-title {
                        margin-bottom: 15px;
                    }

                    .pm-certified {
                        font-size: 12px;
                        width: 300px;
                        margin-top: 0;
                        text-align: center;
                    }

                    .pm-certificate-footer {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        width: 100%;
                        margin-top: 20px;
                        flex-wrap: nowrap
                    }

                    @media print {
                        .print-button {
                            display: none;
                        }

                        .print-button-container {
                            display: none;
                        }
                    }


                    .print-button {
                        padding: 10px 20px;
                        background-color: #007bff;
                        color: #fff;
                        border: none;
                        border-radius: 5px;
                        cursor: pointer;
                        font-size: 14px;
                        font-weight: bold;
                        margin-block-end: 700px;
                    }


                    @media print {
                        body {
                            background: none;
                            -webkit-print-color-adjust: exact;
                            margin: 0;
                            padding: 0;
                            width: 100%;
                        }

                        .pm-certificate-container {
                            page-break-inside: avoid;
                            page-break-after: avoid;
                            width: 100%;
                            height: auto;
                            max-height: 100vh;
                            overflow: hidden;
                            box-shadow: none;
                            background-color: #618597;
                            padding: 30px;
                            margin: 0 auto;
                        }

                        .outer-border,
                        .inner-border {
                            border-color: #d3d0d0;
                        }

                        .print-button,
                        .print-button-container {
                            display: none;

                        }


                        html,
                        body {
                            height: auto;
                            max-height: 100vh;
                            overflow: hidden;
                        }
                    }
                </style>


                <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

                <script>
                    function downloadCertificate() {
                        const element = document.querySelector('.pm-certificate-container');
                        const options = {
                            margin: 10,
                            filename: 'Trainer-Completion-Certificate.pdf',
                            image: { type: 'jpeg', quality: 1.0 }, 
                            html2canvas: {
                                scale: 3, 
                                useCORS: true, 
                            },
                            jsPDF: {
                                unit: 'pt',
                                format: 'a4', 
                                orientation: 'landscape', 
                            },
                        };

                    
                        if (element) {
                            html2pdf().set(options).from(element).save()
                                .then(() => {
                                    console.log('PDF downloaded successfully');
                                })
                                .catch((error) => {
                                    console.error('Error generating PDF:', error);
                                });
                        } else {
                            console.error('Certificate container not found!');
                            alert('Error: Certificate content is not available for download.');
                        }
                    }
                </script>


               
                <!-- Activity Log content -->
                <div id="CCForm6" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Submitted On">Submit By</label>
                                    <div class="static">{{ $trainer->sbmitted_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Submitted On">Submit On</label>
                                    <div class="static">{{ $trainer->sbmitted_on }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Comment">Submit Comment</label>
                                    <div class="static">{{ $trainer->sbmitted_comment }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Submitted On">Update Complete By</label>
                                    <div class="static">{{ $trainer->update_complete_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Submitted On">Update Complete On</label>
                                    <div class="static">{{ $trainer->update_complete_on }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Comment">Update Complete Comment</label>
                                    <div class="static">{{ $trainer->update_complete_comment }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Submitted On">Answer Complete By</label>
                                    <div class="static">{{ $trainer->answer_complete_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Submitted On">Answer Complete On</label>
                                    <div class="static">{{ $trainer->answer_complete_on }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Comment">Answer Complete Comment</label>
                                    <div class="static">{{ $trainer->answer_complete_comment }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Submitted On">Evaluation Complete By</label>
                                    <div class="static">{{ $trainer->evaluation_complete_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Submitted On">Evaluation Complete On</label>
                                    <div class="static">{{ $trainer->evaluation_complete_on }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Comment">Evaluation Complete Comment</label>
                                    <div class="static">{{ $trainer->evaluation_complete_comment }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Qualified By">Qualified By</label>
                                    <div class="static">{{ $trainer->qualified_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Qualified On">Qualified On</label>
                                    <div class="static">{{ $trainer->qualified_on }}</div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Comment">Qualified Comment</label>
                                    <div class="static">{{ $trainer->qualified_comment }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for=" Rejected By">Reject By</label>
                                    <div class="static">{{ $trainer->rejected_by }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Rejected On">Reject On</label>
                                    <div class="static">{{ $trainer->rejected_on }}</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Comment">Reject Comment</label>
                                    <div class="static">{{ $trainer->rejected_comment }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>
                            <a href="/rcms/qms-dashboard">
                                <button type="button" class="backButton">Back</button>
                            </a>
                            <button type="submit">Submit</button>
                            <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                    Exit </a> </button>
                        </div>
                    </div>
                </div>

            </div>
        </form>

    </div>
    </div>

    <div class="modal fade" id="signature-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('analytics_sendstage', $trainer->id) }}" method="POST" id="signatureModalForm">
                    @csrf
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
                    <div class="modal-footer">
                        <button type="submit" class="signatureModalButton">
                            <div class="spinner-border spinner-border-sm signatureModalSpinner" style="display: none"
                                role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            Submit
                        </button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rejection-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ url('rcms/analytics/rejectStage', $trainer->id) }}" method="POST">
                    @csrf
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
                    <!-- <div class="modal-footer">
                                                                                                        <button type="submit" data-bs-dismiss="modal">Submit</button>
                                                                                                        <button>Close</button>
                                                                                                    </div> -->
                    <div class="modal-footer">
                        <button type="submit">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
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
