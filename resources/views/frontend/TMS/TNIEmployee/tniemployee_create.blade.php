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

        <!-- Tab links -->
        <div class="cctab">

            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Training Need Identification of Employee</button>
            <button class="cctablinks " onclick="openCity(event, 'CCForm2')">Employee Acknowledge</button>
            <button class="cctablinks " onclick="openCity(event, 'CCForm3')">HOD Approval</button>

            {{-- <button class="cctablinks " onclick="openCity(event, 'CCForm2')">External Training</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Activity Log</button> --}}

        </div>
<form action="{{ route('tniemployee.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
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
                        <select name="employee_name" id="employee_name" onchange="fetchEmployeeDetails()">
                            <option value="">-- Select --</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->employee_name }}" data-code="{{ $employee->full_employee_id }}" data-department="{{Helpers::getDepartments()[$employee->department] ?? 'NA' }}" data-designation="{{ $employee->job_title }}" data-job="{{ $employee->emp_job }}" data-joining-date="{{\Carbon\Carbon::parse($employee->joining_date)->format('d-M-Y') }}">
                                    {{ $employee->employee_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="employee_code">Employee Code</label>
                        <input type="text" id="employee_code" name="employee_code" readonly>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="department">Department</label>
                        <input type="text" id="department" name="department" readonly>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="designation">Designation</label>
                        <input type="text" id="designation" name="designation" readonly>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                            <label for="site_name">Job Role </label>
                            <input type="text" id="job_role" name="job_role" >
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="joining_date">Joining Date</label>
                        <input type="text" id="joining_date" name="joining_date" readonly>
                    </div>
                </div>

            <script>
                    function fetchEmployeeDetails() {
                    var selectElement = document.getElementById('employee_name');
                    var selectedOption = selectElement.options[selectElement.selectedIndex];
                    var employeeName = selectedOption.value;
                    var employeeCode = selectedOption.getAttribute('data-code');
                    var department = selectedOption.getAttribute('data-department');
                    var designation = selectedOption.getAttribute('data-designation');
                    var job_role = selectedOption.getAttribute('data-job');
                    var joining_date = selectedOption.getAttribute('data-joining-date');

                    if (employeeName) {

                        document.getElementById('employee_code').value = employeeCode || '';
                        document.getElementById('department').value = department || 'NA';
                        document.getElementById('designation').value = designation || 'NA';
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
                                            data-sop-title="{{ $item->document_name }}">
                                        {{ $item->sop_type_short }}/{{ $item->department_id }}/000{{ $item->id }}/R{{ $item->major }}
                                    </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" id="document_title_1" name="document_title_1" readonly>
                            </td>
                            <td><input type="date" name="startdate_1" id="startdate_1" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"></td>

                            <td><input type="date" name="enddate_1" id="enddate_1" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"></td>

                            <td><input type="number" min="0" name="total_minimum_time_1" id="" value=""></td>

                            <td><input type="number" min="0" name="per_screen_run_time_1" id="" value=""></td>

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
                                            data-sop-title="{{ $item->document_name }}">
                                        {{ $item->sop_type_short }}/{{ $item->department_id }}/000{{ $item->id }}/R{{ $item->major }}
                                    </option>
                                    @endforeach
                                </select>
                            </td>

                            <td>
                                <input type="text" id="document_title_2" name="document_title_2" readonly>
                            </td>
                            <td><input type="date" name="startdate_2" id="startdate_2" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"></td>

                            <td><input type="date" name="enddate_2" id="enddate_2" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"></td>

                            <td><input type="number" min="0" name="total_minimum_time_2" id="" value=""></td>

                            <td><input type="number" min="0" name="per_screen_run_time_2" id="" value=""></td>
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
                                            data-sop-title="{{ $item->document_name }}">
                                        {{ $item->sop_type_short }}/{{ $item->department_id }}/000{{ $item->id }}/R{{ $item->major }}
                                    </option>
                                    @endforeach
                                </select>
                            </td>

                            <td>
                                <input type="text" id="document_title_3" name="document_title_3" readonly>
                            </td>

                            <td><input type="date" name="startdate_3" id="startdate_3" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"></td>

                            <td><input type="date" name="enddate_3" id="enddate_3" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"></td>

                            <td><input type="number" min="0" name="total_minimum_time_3" id="" value=""></td>

                            <td><input type="number" min="0" name="per_screen_run_time_3" id="" value=""></td>
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
                                            data-sop-title="{{ $item->document_name }}">
                                        {{ $item->sop_type_short }}/{{ $item->department_id }}/000{{ $item->id }}/R{{ $item->major }}
                                    </option>
                                    @endforeach
                                </select>
                            </td>

                            <td>
                                <input type="text" id="document_title_4" name="document_title_4" readonly>
                            </td>
                            <td><input type="date" name="startdate_4" id="startdate_4" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"></td>

                            <td><input type="date" name="enddate_4" id="enddate_4" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" ></td>

                            <td><input type="number" min="0" name="total_minimum_time_4" id="" value=""></td>

                            <td><input type="number" min="0" name="per_screen_run_time_4" id="" value=""></td>
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
                                            data-sop-title="{{ $item->document_name }}">
                                        {{ $item->sop_type_short }}/{{ $item->department_id }}/000{{ $item->id }}/R{{ $item->major }}
                                    </option>
                                    @endforeach
                                </select>
                            </td>

                            <td>
                                <input type="text" id="document_title_5" name="document_title_5" readonly>
                            </td>
                            <td><input type="date" name="startdate_5" id="startdate_5"></td>

                            <td><input type="date" name="enddate_5" id="enddate_5"></td>

                            <td><input type="number" min="0" name="total_minimum_time_5" id="" value=""></td>

                            <td><input type="number" min="0" name="per_screen_run_time_5" id="" value=""></td>
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
                    
                    var sopTitleInput = document.getElementById('document_title_1'); // Input field

                    if (sopTitle) {
                        // Set the value in input field to display the SOP title
                        sopTitleInput.value = sopTitle;
                    } else {
                        // Clear the input field if no SOP is selected
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
                                <textarea name="acknowledge" maxlength="255"></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="group-input">
                                <label for="External Attachment">Acknowledge Attachment</label>
                                <input type="file" id="myfile" name="acknowledge_attachment" value="">
                                <a href="" target="_blank"></a>
                            </div>
                        </div>
  
                        </div>
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>   
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>                                 
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
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
                                <textarea name="hod_remark" maxlength="255"></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="group-input">
                                <label for="External Attachment">HOD Attachment</label>
                                <input type="file" id="myfile" name="hod_attachment" value="">
                                <a href="" target="_blank"></a>
                            </div>
                        </div>
  
                        </div>
                        <div class="button-block">
                            <button type="submit" class="saveButton">Save</button>   
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>                                 
                            <!-- <button type="button" class="nextButton" onclick="nextStep()">Next</button> -->
                        </div>
                    </div>
                </div>
            </div>
    <!-- <div id="CCForm2" class="inner-block cctabcontent">
                <div class="inner-block-content">
                    <div class="row">
                <div class="col-lg-6">
                    <div class="group-input">
                        <label for="site_name">Name <span class="text-danger">*</span></label>
                        <input type="text" id="site_division" name="site_division" >
                    </div>
                </div>    
                </div>
        <div class="button-block">
            <button type="submit" id="ChangesaveButton01" class="saveButton">Save</button>
            <button type="button" id="ChangeNextButton" class="nextButton">Next</button>
            <button type="button" class="backButton" onclick="previousStep()">Back</button>
            <button type="button"> <a href="{{ url('TMS') }}" class="text-white">
                    Exit </a> </button>
        </div>

        </div>
        </div> -->
            
            <!-- <div id="CCForm6" class="inner-block cctabcontent">
                <div class="inner-block-content">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Activated By">Activated By</label>
                                <div class="static"></div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Activated On">Activated On</label>
                                <div class="static"></div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for=" Rejected By">Retired By</label>
                                <div class="static"></div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Rejected On">Retired On</label>
                                <div class="static"></div>
                            </div>
                        </div>
            
                    </div>
                    {{-- <div class="button-block">
                                    <button type="submit" class="saveButton">Save</button>
                                    <a href="/rcms/qms-dashboard">
                                        <button type="button" class="backButton">Back</button>
                                    </a>
                                    <button type="submit">Submit</button>
                                    <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                    Exit </a> </button>
                </div> --}}
            </div>
            </div> -->


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
@endsection