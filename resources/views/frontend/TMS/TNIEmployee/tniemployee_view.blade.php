@extends('frontend.layout.main')
@section('container')
@php
$users = DB::table('users')->select('id', 'name')->where('active', 1)->get();
$userRoles = DB::table('user_roles')->select('user_id')->where('q_m_s_roles_id', 4)->distinct()->get();
$departments = DB::table('departments')->select('id', 'name')->get();
$divisions = DB::table('q_m_s_divisions')->select('id', 'name')->get();
$employees = DB::table('employees')->get();
$userIds = DB::table('user_roles')
->where('q_m_s_roles_id', 4)
->distinct()
->pluck('user_id');

// Step 3: Use the plucked user_id values to get the names from the users table
$userNames = DB::table('users')
->whereIn('id', $userIds)
->pluck('name');

// If you need both id and name, use the select method and get
$userDetails = DB::table('users')
->whereIn('id', $userIds)
->select('id', 'name')
->get();
// dd ($userIds,$userNames, $userDetails);
@endphp
<style>
    textarea.note-codable {
        display: none !important;
    }

    header {
        display: none;
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

        #change-control-fields>div>div.inner-block.state-block>div.status>div.progress-bars.d-flex>div:nth-child(4) {
            border-radius: 0px 20px 20px 0px;

        }
    </style>
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
<div class="form-field-head">
    <div class="pr-id">
      Training Need Identification (Employee)
    </div>
    
</div>




{{-- ======================================
                    DATA FIELDS
    ======================================= --}}
<div id="change-control-fields">
    <div class="container-fluid">

    <div class="inner-block state-block">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="main-head">Record Workflow </div>

                    <div class="d-flex" style="gap:20px;">

                        @php
                            $userRoles = DB::table('user_roles')
                                ->where([
                                    'user_id' => Auth::user()->id,
                                    'q_m_s_divisions_id' => $tniemployee->division_id,
                                ])
                                ->get();
                            $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                            // dd($jobTraining->division_id);
                        @endphp

                        <!-- <button class="button_theme1">
                            <a class="text-white" href=""> Audit
                                Trail
                            </a>
                        </button> -->

                        @if ($tniemployee->stage == 1)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Submit
                            </button>
                            @elseif($tniemployee->stage == 2)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Acknowledge
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                            More Info Required
                            </button>
                 
                        @elseif($tniemployee->stage == 3)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                            Approved
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                            More Info Required
                            </button>
                        
                        @endif
                        <button class="button_theme1"> <a class="text-white" href="{{ url('TMS') }}"> Exit
                            </a>
                        </button>
                    </div>

                </div>
                <div class="status">
                    <div class="head">Current Status</div>
                    @if ($tniemployee->stage == 0)
                        <div class="progress-bars ">
                            <div class="bg-danger">Closed-Cancelled</div>
                        </div>
                    @else
                        <div class="progress-bars d-flex">
                            @if ($tniemployee->stage >= 1)
                                <div class="active">Opened</div>
                            @else
                                <div class="">Opened</div>
                            @endif

                            @if ($tniemployee->stage >= 2)
                                <div class="active">Pending Acknowledge from Employee</div>
                            @else
                                <div class="">Pending Acknowledge from Employee</div>
                            @endif
                            @if ($tniemployee->stage >= 3)
                                <div class="active">Pending Approved</div>
                            @else
                                <div class="">Pending Approved</div>
                            @endif
                           
                            @if ($tniemployee->stage >= 4)
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

            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Training Need Identification of Employee</button>
            <button class="cctablinks " onclick="openCity(event, 'CCForm2')">Employee Acknowledge</button>
            <button class="cctablinks " onclick="openCity(event, 'CCForm3')">HOD Approval</button>
            <button class="cctablinks " onclick="openCity(event, 'CCForm5')">Activity Log</button>

        </div>
        
        <script>
            $(document).ready(function() {
                <?php if (in_array($tniemployee->stage, [4])) : ?>
                $("#target :input").prop("disabled", true);
                <?php endif; ?>
            });
        </script>

        <form id="target" action="{{ route('tniemployee_update',$tniemployee->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <!-- Tab content -->
            <div id="step-form">

                <div id="CCForm1" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                          

                            <!-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="employee_name">Employee Name</label>
                                    <select name="employee_name" id="employee_name" onchange="updateEmployeeCode()">
                                        <option value="">-- Select --</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->employee_name }}" data-code="{{ $employee->full_employee_id }}">{{ $employee->employee_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> -->

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="employee_name">Employee Name</label>
                                    <input type="text" name="employee_name" value="{{$tniemployee->employee_name}}" readonly>
                                    <!-- <select name="employee_name" id="employee_name" onchange="fetchEmployeeDetails()">
                                        <option value="">-- Select --</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}" data-code="{{ $employee->full_employee_id }}">
                                                {{ $employee->employee_name }}
                                            </option>
                                        @endforeach
                                    </select> -->
                                </div>
                            </div>
                            
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="employee_code">Employee Code</label>
                                    <input type="text" id="employee_code" name="employee_code" value="{{$tniemployee->employee_code}}" readonly>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="department">Department</label>
                                    <input type="text" id="department" name="department" value="{{ $tniemployee->department}}" readonly>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="designation">Designation</label>
                                    <input type="text" id="designation" name="designation" value="{{$tniemployee->designation}}" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="site_name">Job Role </label>
                                    <input type="text" id="job_role" name="job_role" value="{{$tniemployee->job_role}}" >
                                </div>
                            </div>
                   

                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Joining Date">Joining Date</label>
                                    <input type="text" id="joining_date" value="{{$tniemployee->joining_date}}" readonly >
                            </div>
                        </div>



            <script>
                function fetchEmployeeDetails() {
                    var selectElement = document.getElementById('employee_name');
                    var selectedOption = selectElement.options[selectElement.selectedIndex];
                    var employeeId = selectedOption.value;

                    if (employeeId) {
                        fetch(`/employees/${employeeId}`)
                            .then(response => response.json())
                            .then(data => {
                                document.getElementById('employee_code').value = data.full_employee_id || '';
                                document.getElementById('department').value = data.department || 'NA';
                                document.getElementById('designation').value = data.job_title || 'NA';
                            })
                            .catch(error => {
                                console.error('Error fetching employee details:', error);
                            });
                    } else {
                        document.getElementById('employee_code').value = '';
                        document.getElementById('department').value = '';
                        document.getElementById('designation').value = '';
                    }
                }
            </script>                    
            </div>

<div class="col-12">
    <div class="group-input">
        <div class="why-why-chart">
        <table class="table table-bordered">
    <thead>
        <tr>
            <th style="width: 5%;">Sr.No.</th>
            <th style="width: 30%;">SOP No.</th>
            <th>SOP Title</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Minimum Sop View Time(in min)</th>
            <th>Maximum Sop View Time(in min)</th>
        </tr>
    </thead>
    <tbody>
        @php
        $trainerIds = DB::table('user_roles')->where('q_m_s_roles_id', 6)->pluck('user_id');
        $usersDetails = DB::table('users')->select('id', 'name')->get();
        @endphp
        
        <tr>
        <td>1</td>
    <td>
        <select name="document_number_1" id="document_number_1" onchange="fetchSopDetails(this)">
            <option value="">----Select---</option>
            @foreach ($data as $item)
            <option value="{{ $item->id }}" 
                    data-sop-link="{{ $item->id }}"
                    data-sop-title="{{ $item->document_name }}"
                    @if($item->id == $tniemployee->document_number_1) selected @endif>
                {{ $item->sop_type_short }}/{{ $item->department_id }}/000{{ $item->id }}/R{{ $item->major }}
            </option>
            @endforeach
        </select>
    </td>

    <td>
        <input type="text" id="document_title_1" name="document_title_1" value="{{ $tniemployee->document_title_1 }}" readonly>
    </td>
    <td>
        <input type="date" name="startdate_1" id="startdate_1" 
            value="{{ old('startdate_1', $tniemployee->startdate_1 ?? '') }}" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
    </td>
    <td>
        <input type="date" name="enddate_1" id="enddate_1" 
            value="{{ old('enddate_1', $tniemployee->enddate_1 ?? '') }}" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
    </td>

    <td><input type="number" min="0" name="total_minimum_time_1" id="" value="{{ $tniemployee->total_minimum_time_1 }}"></td>

    <td><input type="number" min="0" name="per_screen_run_time_1" id="" value="{{ $tniemployee->per_screen_run_time_1 }}"></td>
        <!-- <td>
            <a href="#" id="view_sop_link" style="display:none;">View SOP</a>
        </td> -->

        <!-- Row 2 -->
        <tr>
            <td>2</td>
        <td>
            <select name="document_number_2" id="document_number_2" onchange="fetchSopDetails2(this)">
                <option value="">----Select---</option>
                @foreach ($data as $item)
                <option value="{{ $item->id }}" 
                        data-sop-link="{{ $item->id }}"
                        data-sop-title="{{ $item->document_name }}"
                        @if($item->id == $tniemployee->document_number_2) selected @endif>
                    {{ $item->sop_type_short }}/{{ $item->department_id }}/000{{ $item->id }}/R{{ $item->major }}
                </option>
                @endforeach
            </select>
        </td>

        <td>
           <input type="text" id="document_title_2" name="document_title_2" value="{{ $tniemployee->document_title_2 }}" readonly>
        </td>
        <td>
        <input type="date" name="startdate_2" id="startdate_2" 
            value="{{ old('startdate_2', $tniemployee->startdate_2 ?? '') }}" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
        </td>
        <td>
            <input type="date" name="enddate_2" id="enddate_2" 
                value="{{ old('enddate_2', $tniemployee->enddate_2 ?? '') }}" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
        </td>

        <td><input type="number" min="0" name="total_minimum_time_2" id="" value="{{ $tniemployee->total_minimum_time_2 }}"></td>

        <td><input type="number" min="0" name="per_screen_run_time_2" id="" value="{{ $tniemployee->per_screen_run_time_2 }}"></td>
        <!-- <td>
            <a href="#" id="view_sop_link" style="display:none;">View SOP</a>
        </td> -->

        </tr>

        <!-- Row 3 -->
        <tr>
            <td>3</td>
        <td>
            <select name="document_number_3" id="document_number_3" onchange="fetchSopDetails3(this)">
                <option value="">----Select---</option>
                @foreach ($data as $item)
                <option value="{{ $item->id }}" 
                        data-sop-link="{{ $item->id }}"
                        data-sop-title="{{ $item->document_name }}"
                        @if($item->id == $tniemployee->document_number_3) selected @endif>
                    {{ $item->sop_type_short }}/{{ $item->department_id }}/000{{ $item->id }}/R{{ $item->major }}
                </option>
                @endforeach
            </select>
        </td>

        <td>
            <input type="text" id="document_title_3" name="document_title_3" value="{{ $tniemployee->document_title_3 }}" readonly>
        </td>
        <td>
        <input type="date" name="startdate_3" id="startdate_3" 
            value="{{ old('startdate_3', $tniemployee->startdate_3 ?? '') }}" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
        </td>
        <td>
            <input type="date" name="enddate_3" id="enddate_3" 
                value="{{ old('enddate_3', $tniemployee->enddate_3 ?? '') }}" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
        </td>

        <td><input type="number" min="0" name="total_minimum_time_3" id="" value="{{ $tniemployee->total_minimum_time_3 }}"></td>
        <td><input type="number" min="0" name="per_screen_run_time_3" id="" value="{{ $tniemployee->per_screen_run_time_3 }}"></td>
        <!-- <td>
            <a href="#" id="view_sop_link" style="display:none;">View SOP</a>
        </td> -->
    
        </tr>

        <!-- Row 4 -->
        <tr>
            <td>4</td>
        <td>
            <select name="document_number_4" id="document_number_4" onchange="fetchSopDetails4(this)">
                <option value="">----Select---</option>
                @foreach ($data as $item)
                <option value="{{ $item->id }}" 
                        data-sop-link="{{ $item->id }}"
                        data-sop-title="{{ $item->document_name }}"
                        @if($item->id == $tniemployee->document_number_4) selected @endif>
                    {{ $item->sop_type_short }}/{{ $item->department_id }}/000{{ $item->id }}/R{{ $item->major }}
                </option>
                @endforeach
            </select>
        </td>

        <td>
            <input type="text" id="document_title_4" name="document_title_4" value="{{ $tniemployee->document_title_4 }}" readonly>
        </td>
        <td>
        <input type="date" name="startdate_4" id="startdate_4" 
            value="{{ old('startdate_4', $tniemployee->startdate_4 ?? '') }}" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
        </td>
        <td>
            <input type="date" name="enddate_4" id="enddate_4" 
                value="{{ old('enddate_4', $tniemployee->enddate_4 ?? '') }}" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
        </td>

        <td><input type="number" min="0" name="total_minimum_time_4" id="" value="{{ $tniemployee->total_minimum_time_4 }}"></td>

        <td><input type="number" min="0" name="per_screen_run_time_4" id="" value="{{ $tniemployee->per_screen_run_time_4 }}"></td>
        <!-- <td>
            <a href="#" id="view_sop_link" style="display:none;">View SOP</a>
        </td> -->
        </tr>

        <!-- Row 5 -->
        <tr>
            <td>5</td>
            <td>
            <select name="document_number_5" id="document_number_5" onchange="fetchSopDetails5(this)">
                <option value="">----Select---</option>
                @foreach ($data as $item)
                <option value="{{ $item->id }}" 
                        data-sop-link="{{ $item->id }}"
                        data-sop-title="{{ $item->document_name }}"
                        @if($item->id == $tniemployee->document_number_5) selected @endif>
                    {{ $item->sop_type_short }}/{{ $item->department_id }}/000{{ $item->id }}/R{{ $item->major }}
                </option>
                @endforeach
            </select>
        </td>

        <td>
            <input type="text" id="document_title_5" name="document_title_5" value="{{ $tniemployee->document_title_5 }}" readonly>
        </td>
        <td>
        <input type="date" name="startdate_5" id="startdate_5" 
            value="{{ old('startdate_5', $tniemployee->startdate_5 ?? '') }}" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
        </td>
        <td>
            <input type="date" name="enddate_5" id="enddate_5" 
                value="{{ old('enddate_5', $tniemployee->enddate_5 ?? '') }}" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
        </td>
        <td><input type="number" min="0" name="total_minimum_time_5" id="" value="{{ $tniemployee->total_minimum_time_5 }}"></td>

        <td><input type="number" min="0" name="per_screen_run_time_5" id="" value="{{ $tniemployee->per_screen_run_time_5 }}"></td>
        <!-- <td>
            <a href="#" id="view_sop_link" style="display:none;">View SOP</a>
        </td> -->

        </tr>
        </tbody>
    </table>

            </div>
        </div>
    </div>
</div>

<script>
    function fetchSopDetails(selectElement) {
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var sopTitle = selectedOption.getAttribute('data-sop-title');
        
        var sopTitleInput = document.getElementById('document_title_1');

        if (sopTitle) {
            sopTitleInput.value = sopTitle;
        } else {
            sopTitleInput.value = '';
        }
    }
</script>
<script>
        function fetchSopDetails2(selectElement) {
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var sopTitle = selectedOption.getAttribute('data-sop-title');
        
        var sopTitleInput = document.getElementById('document_title_2');

        if (sopTitle) {
            sopTitleInput.value = sopTitle;
        } else {
            sopTitleInput.value = '';
        }
    }
</script>
<script>
        function fetchSopDetails3(selectElement) {
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var sopTitle = selectedOption.getAttribute('data-sop-title');
        
        var sopTitleInput = document.getElementById('document_title_3');

        if (sopTitle) {
            sopTitleInput.value = sopTitle;
        } else {
            sopTitleInput.value = '';
        }
    }
</script>
<script>
       function fetchSopDetails4(selectElement) {
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var sopTitle = selectedOption.getAttribute('data-sop-title');
        
        var sopTitleInput = document.getElementById('document_title_4');
        if (sopTitle) {
            sopTitleInput.value = sopTitle;
        } else {
            sopTitleInput.value = '';
        }
    }
</script>
<script>
        function fetchSopDetails5(selectElement) {
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var sopTitle = selectedOption.getAttribute('data-sop-title');
        
        var sopTitleInput = document.getElementById('document_title_5');

        if (sopTitle) {
            sopTitleInput.value = sopTitle;
        } else {
            sopTitleInput.value = '';
        }
    }
</script>

<script>
    function setMinEndDate() {
        var startDate = document.getElementById('startdate_1').value;
        document.getElementById('enddate_1').min = startDate; 
    }
    function setMaxStartDate() {
        var endDate = document.getElementById('startdate_1').value;
        document.getElementById('enddate_1').max = endDate;
    }
</script>
<script>
    function setMinEndDate2() {
        var startDate = document.getElementById('startdate_2').value;
        document.getElementById('enddate_2').min = startDate; 
    }
    function setMaxStartDate2() {
        var endDate = document.getElementById('startdate_2').value;
        document.getElementById('enddate_2').max = endDate;
    }
</script>
<script>
    function setMinEndDate3() {
        var startDate = document.getElementById('startdate_3').value;
        document.getElementById('enddate_3').min = startDate; 
    }
    function setMaxStartDate3() {
        var endDate = document.getElementById('startdate_3').value;
        document.getElementById('enddate_3').max = endDate;
    }
</script>
<script>
    function setMinEndDate4() {
        var startDate = document.getElementById('startdate_4').value;
        document.getElementById('enddate_4').min = startDate; 
    }
    function setMaxStartDate4() {
        var endDate = document.getElementById('startdate_4').value;
        document.getElementById('enddate_4').max = endDate;
    }
</script>
<script>
    function setMinEndDate5() {
        var startDate = document.getElementById('startdate_5').value;
        document.getElementById('enddate_5').min = startDate; 
    }
    function setMaxStartDate5() {
        var endDate = document.getElementById('startdate_5').value;
        document.getElementById('enddate_5').max = endDate;
    }
</script>

            <div class="button-block">
                <button type="submit" id="ChangesaveButton01" class="saveButton">Save</button>
                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                <button type="button"> <a href="{{ url('TMS') }}" class="text-white">
                        Exit </a> </button>
            </div>

            </div>
            </div>

            <div id="CCForm2" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">

                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Activated On">Acknowledge Remark</label>
                                <textarea name="acknowledge" maxlength="255">{{ $tniemployee->acknowledge }}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="group-input">
                                <label for="External Attachment">Acknowledge Attachment</label>
                                <input type="file" id="myfile" name="acknowledge_attachment" value="{{ $tniemployee->acknowledge_attachment }}">
                                <a href="{{ asset('upload/' . $tniemployee->acknowledge_attachment) }}" target="_blank">{{ $tniemployee->acknowledge_attachment }}</a>
                            </div>
                        </div>
  
                        </div>
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>   
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>                                 
                        </div>
                    </div>
                </div>
            </div>

            
            <div id="CCForm3" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">

                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Activated On">HOD Remark</label>
                                <textarea name="hod_remark" maxlength="255">{{ $tniemployee->hod_remark }}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="group-input">
                                <label for="External Attachment">HOD Attachment</label>
                                <input type="file" id="myfile" name="hod_attachment" value="{{ $tniemployee->hod_attachment }}">
                                <a href="{{ asset('upload/' . $tniemployee->hod_attachment) }}" target="_blank">{{ $tniemployee->hod_attachment }}</a>
                            </div>
                        </div>
  
                        </div>
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button> 
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>  
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>                                 
                            <!-- <button type="button" class="nextButton" onclick="nextStep()">Next</button> -->
                        </div>
                    </div>
                </div>

            <div id="CCForm5" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">

                        <div class="row">
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="Activated By">Prepared by Concerned Dept. By</label>
                                <div class="static">{{ $tniemployee->submit_by }}</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="Activated On">Prepared by Concerned Dept. On</label>
                                <div class="static">{{ $tniemployee->submit_on }}</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for=" Rejected By">Prepared by Concerned Dept. Comment</label>
                                <div class="static">{{ $tniemployee->submit_comment }}</div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for=" Rejected By">Acknowledged by Employee</label>
                                <div class="static">{{ $tniemployee->acknowledge_by }}</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="Rejected On">Acknowledged On</label>
                                <div class="static">{{ $tniemployee->acknowledge_on }}</div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="Rejected On">Acknowledged Comment</label>
                                <div class="static">{{ $tniemployee->acknowledge_comment }}</div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for=" Rejected By">Cancel By</label>
                                <div class="static">{{ $tniemployee->cancel_by }}</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="Rejected On">Cancel On</label>
                                <div class="static">{{ $tniemployee->cancel_on }}</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="Rejected On">Cancel Comment</label>
                                <div class="static">{{ $tniemployee->cancel_comment }}</div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for=" Rejected By">Approved by Head/Designee of Concerned Dept. By</label>
                                <div class="static">{{ $tniemployee->approved_by }}</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="Rejected On">Approved by Head/Designee of Concerned Dept. On</label>
                                <div class="static">{{ $tniemployee->approved_on }}</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="Rejected On">Approved by Head/Designee of Concerned Dept. Comment</label>
                                <div class="static">{{ $tniemployee->approved_comment }}</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for=" Rejected By">Approved Cancel By</label>
                                <div class="static">{{ $tniemployee->acknowledge_cancel_by }}</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="Rejected On">Approved Cancel On</label>
                                <div class="static">{{ $tniemployee->acknowledge_cancel_on }}</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="Rejected On">Approved Cancel Comment</label>
                                <div class="static">{{ $tniemployee->acknowledge_cancel_comment }}</div>
                            </div>
                        </div>


                        </div>
                        {{-- <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>   
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>                                 
                        </div> --}}
                    </div>
                </div>
            </div>




        </div>
        </div>
            



<script>
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

</form>
</div>
</div>
<script>
        VirtualSelect.init({
            ele: '#Facility, #Group, #Audit, #Auditee , #capa_related_record,#cft_reviewer'
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

    const saveButtons = document.querySelectorAll('.saveButton1');
    const form = document.getElementById('step-form');
</script>
<script>
    VirtualSelect.init({
        ele: '#Facility, #Group, #Audit, #Auditee ,#reference_record, #designee, #hod'
    });
</script>

<div class="modal fade" id="signature-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ url('tniemployee/sendstage', $tniemployee->id) }}" method="POST"
                    id="sendstage">
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
                        <button type="submit" class="on-submit-disable-button">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
</div>
<script>
        $(document).ready(function() {
            
            $('#sendstage').on('submit', function(e) {
                $('.on-submit-disable-button').prop('disabled', true);
            });
        })
    </script>

    <div class="modal fade" id="cancel-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ url('tniemployee/cancelstage', $tniemployee->id) }}" method="POST" id="cancelstage">
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
                            <input type="comment" name="comments">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="on-submit-disable-button">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            
            $('#cancelstage').on('submit', function(e) {
                $('.on-submit-disable-button').prop('disabled', true);
            });
        })
    </script>
@endsection