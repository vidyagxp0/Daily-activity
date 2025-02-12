@extends('frontend.layout.main')
@section('container')
    @php
        $users = DB::table('users')->select('id', 'name')->where('active', 1)->get();
        $userRoles = DB::table('user_roles')->select('user_id')->where('q_m_s_roles_id', 4)->distinct()->get();
        $departments = DB::table('departments')->select('id', 'name')->get();
        $divisions = DB::table('q_m_s_divisions')->select('id', 'name')->get();

        $userIds = DB::table('user_roles')->where('q_m_s_roles_id', 4)->distinct()->pluck('user_id');

        // Step 3: Use the plucked user_id values to get the names from the users table
        $userNames = DB::table('users')->whereIn('id', $userIds)->pluck('name');

        // If you need both id and name, use the select method and get
        $userDetails = DB::table('users')->whereIn('id', $userIds)->select('id', 'name')->get();
        // dd ($userIds,$userNames, $userDetails);
    @endphp
    <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
        }
        iframe#\:2\.container {
        /* display: none; */
        height: 0px !important;
        background: #4274da !important;
    }
    img.goog-te-gadget-icon {
        display: none;
    }
    .skiptranslate.goog-te-gadget {
        margin-bottom: 0px;
    }
    div#google_translate_element {
        border: none;
    }
    .VIpgJd-ZVi9od-aZ2wEe-wOHMyf.VIpgJd-ZVi9od-aZ2wEe-wOHMyf-ti6hGc {
        display: none;
    }
    </style>


    <!-- @error('email')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

            @error('emp_id')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror -->

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
    <div style="" class="form-field-head">
        <div class="pr-id">
            <i class="fas fa-user-tie"></i> New Employee
        </div>
        
    </div>




    {{-- ======================================
                    DATA FIELDS
    ======================================= --}}
    <div id="change-control-fields">
        <div class="container-fluid">
            
            <!-- Tab links -->
            <div class="cctab">

                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')"><i class="fas fa-user-tie"></i> Employee</button>
            
                <button class="cctablinks" onclick="openCity(event, 'CCForm2')"><i class="fas fa-list-alt"></i> Activity Log</button>

            </div>
            <form action="{{ route('employee.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Tab content -->
                <div id="step-form">

                    <div id="CCForm1" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="language-select d-flex" style="align-items: center justify-content-end; ">
                                <div style="margin-top: -10px;">Select Language </div>
                            <div class="main-head" id="google_translate_element"></div>
                            </div>
                                  <style>
                                    .language-select {
                                    display: flex;
                                    align-items: center;
                                    justify-content: flex-end;
                                    padding: 10px; 
                                    background-color: #f8f9fa; 
                                    border-radius: 5px; 
                                }

                                .language-select .main-head {
                                    margin-left: 10px; 
                                }

                                .language-select div {
                                    font-size: 14px; 
                                    color: #333; 
                                }
                                 </style>      
                            <script type="text/javascript">
                                function googleTranslateElementInit() {
                                    new google.translate.TranslateElement({
                                        pageLanguage: 'en',
                                        includedLanguages: 'en,es,fr,de,zh,hi,ar,pt,ja,ru',
                                        layout: google.translate.TranslateElement.InlineLayout.SIMPLE
                                    }, 'google_translate_element');
                                }
                            </script>                                            
                            <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
                    
                            <div class="col-12 sub-head">
                                Basic Information
                            </div>
                            <div class="row">
                                {{-- <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Site Division/Project">Site Division/Project <span class="text-danger">*</span></label>
                                    <select name="division_id" required>
                                        <option value="">-- Select --</option>
                                        @foreach ($divisions as $division)
                                        <option value="{{ $division->id }}">{{ $division->name }}</option>
                            @endforeach
                            </select>
                        </div>
                        </div> --}}


                                {{-- <div class="group-input">
                                        <label for="site_name">Site Division/Project <span
                                                class="text-danger">*</span></label>
                                        <select name="site_division">
                                            <option value="">Enter Your Selection Here</option>
                                            <option value="Corporate" {{ old('site_division') == 'Corporate' ? 'selected' : '' }}>Corporate</option>
                                            <option value="Plant" {{ old('site_division') == 'Plant' ? 'selected' : '' }}>Plant</option>
                                            <option value="Plant" {{ old('site_division') == 'Plant' ? 'selected' : '' }}>Plant</option>
                                            <option value="Plant" {{ old('site_division') == 'Plant' ? 'selected' : '' }}>Plant</option>
                                        </select>

                                        <!-- <input type="text" id="site_division" name="site_division" required> -->
                                    </div> --}}
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Site/Location">Site/Location</label>
                                        <select id="training-select" name="site_division" onchange="toggleMultiSelect()">
                                            <option value="">Select Division</option>
                                            <option value="P1">P1 (Indore Location)</option>
                                            <option value="P2">P2 (Pithampur Location)</option>
                                            <option value="P4">P4 (Ujjain Site)</option>
                                            <option value="C1">C1 (China Plant)</option>
                                        </select>
                                    </div>
                                </div>


                                {{-- <div class="col-lg-6">
                        <div class="group-input">
                            <label for="Assigned To">Assigned To <span class="text-danger">*</span></label>
                            <select name="assigned_to" required>
                                <option value="">-- Select --</option>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}
                                {{-- <div class="col-lg-6 new-date-data-field">
                        <div class="group-input input-date">
                            <label for="Joining Date">Joining Date<span
                            class="text-danger">*</span><label>
                            <div class="calenderauditee">
                                <input type="text" id="joining_date"  readonly placeholder="DD-MMM-YYYY" />
                                <input type="date" name="joining_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input" oninput="handleDateInput(this, 'joining_date')" />
                       </div>
                     </div>
                  </div> --}}



                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Prefix">Prefix<span class="text-danger">*</span></label>
                                        <select name="prefix" id="prefix-select" required onchange="toggleInputBox()">
                                            <option value="">Enter Your Selection Here</option>
                                            <option value="PW" {{ old('prefix') == 'PW' ? 'selected' : '' }}>Permanent
                                                Workers</option>
                                            <option value="PS" {{ old('prefix') == 'PS' ? 'selected' : '' }}>Permanent
                                                Staff</option>
                                            <option value="OS" {{ old('prefix') == 'OS' ? 'selected' : '' }}>Others
                                                Separately</option>
                                        </select>
                                        <div id="other-input" style="display:none; margin-top: 5px;">
                                            <label for="other">Others</label>
                                            <input type="text" name="other" id="other" value="{{ old('other') }}"
                                                style="width: 100%;">
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    function toggleInputBox() {
                                        const selectElement = document.getElementById('prefix-select');
                                        const otherInput = document.getElementById('other-input');

                                        if (selectElement.value === 'OS') {
                                            otherInput.style.display = 'block';
                                        } else {
                                            otherInput.style.display = 'none';
                                        }
                                    }
                                </script>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Employee ID">Employee ID<span class="text-danger">*</span></label>
                                        <input type="number" min="1" name="emp_id" value="{{ old('emp_id') }}" required>
                                        @if ($errors->has('emp_id'))
                                            <span style="color: red;">{{ $errors->first('emp_id') }}</span>
                                        @endif
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="employee_name">Employee Name <span class="text-danger">*</span></label>
                                        <div class="relative-container">
                                        <input type="text" name="employee_name" value="{{ old('employee_name') }}"
                                            required>
                                        @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Gender">Gender</label>
                                        <select name="gender" value="{{ old('gender') }}">
                                            <option value="">Enter Your Selection Here</option>
                                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female
                                            </option>
                                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other
                                            </option>
                                        </select>
                                    </div>
                                </div>


                                <!-- <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Department">Department Name<span class="text-danger">*</span></label>
                                            <select name="department" required>
                                                <option value="">-- Select --</option>

                                                @foreach (Helpers::getDepartments() as $code => $department)
    <option value="{{ $code }}">{{ $department }}</option>
    @endforeach
                                            </select>
                                        </div>
                                    </div> -->



                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Date Of birth">Date Of Birth<span class="text-danger">*</span></label>
                                        <div class="calenderauditee">
                                            <input type="text" id="date_of_birth" value="{{ old('date_of_birth') }}"
                                                readonly placeholder="DD-MMM-YYYY" />
                                            <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                                            max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="" class="hide-input"
                                                oninput="handleDateInput(this, 'date_of_birth')" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="qualification">Nationality<span class="text-danger">*</span></label>
                                      <div class="relative-container">
                                        <input type="text" name="nationality" value="">
                                        @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>



                                <!-- <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Job Title">Designation<span class="text-danger">*</span></label>
                                            <select name="job_title" required>
                                                <option value="">Enter Your Selection Here</option>
                                                <option value="Trainee">Trainee</option>
                                                <option value="Officer">Officer</option>
                                                <option value="Sr. Officer">Sr. Officer</option>
                                                <option value="Executive">Executive</option>
                                                <option value="Sr.executive">Sr. Executive</option>
                                                <option value="Asst. manager">Asst. Manager </option>
                                                <option value="Manager">Manager</option>
                                                <option value="Sr. GM">Sr. GM</option>
                                                <option value="Sr. manager">Sr. Manager</option>
                                                <option value="Deputy GM">Deputy GM</option>
                                                <option value="AGM and GM">AGM and GM</option>
                                                <option value="Head quality">Head quality</option>
                                                <option value="VP quality">VP quality</option>
                                                <option value="Plant head ">Plant head </option>
                                                <option value="other designation ">Other Designation </option>
                                            </select>
                                        </div>
                                    </div> -->



                                <script>
                                    function toggleOtherDepartment() {
                                        const departmentSelect = document.getElementById('department');
                                        const otherDepartmentContainer = document.getElementById('other_department_container');
                                        // Check if the selected department is "Other"
                                        if (departmentSelect.value === "Other") {
                                            otherDepartmentContainer.style.display = 'block';
                                        } else {
                                            otherDepartmentContainer.style.display = 'none';
                                        }
                                    }

                                    // Call the function on page load to set the initial state of the Other Department input
                                    window.onload = function() {
                                        toggleOtherDepartment();
                                    };
                                </script>

                                <script>
                                    function toggleOtherDesignation() {
                                        const jobTitleSelect = document.getElementById('job_title');
                                        const otherDesignationContainer = document.getElementById('other_designation_container');
                                        if (jobTitleSelect.value === "other designation") {
                                            otherDesignationContainer.style.display = 'block';
                                        } else {
                                            otherDesignationContainer.style.display = 'none';
                                        }
                                    }
                                </script>





                                <!-- <div class="col-lg-6">
                <div class="group-input">
                    <label for="Additional Medical Document">Medical Checkup Report?</label>
                    <select name="has_additional_document" id="has_additional_document">
                        <option value="">--Select--</option>
                        <option value="No">No</option>
                        <option value="Yes">Yes</option>
                    </select>
                </div>
        </div>

        <div class="col-lg-6" id="medical_attachment" style="">
            <div class="group-input">
                <label for="Attached Medical Document">Medical Checkup Attachment</label>
                <input type="file" name="additional_document" id="additional_document">
            </div>
        </div>

        <script>
            document.getElementById('has_additional_document').addEventListener('change', function() {

                if (this.value === 'Yes') {
                    document.getElementById('medical_attachment').style.display = 'block';
                } else {
                    document.getElementById('medical_attachment').style.display = 'none';
                }
            });
        </script> -->





                                <div class="col-12 sub-head">
                                    Employement Details
                                </div>


                                <!-- <div class="col-lg-6">
                <div class="group-input">
                    <label for="Zone">Zone</label>
                    <select name="zone">
                        <option value="">Enter Your Selection Here</option>
                        <option value="Asia">Asia</option> -->
                                <!-- <option value="Europe">Europe</option>
                        <option value="Africa">Africa</option>
                        <option value="Central America">Central America</option>
                        <option value="South America">South America</option>
                        <option value="Oceania">Oceania</option>
                        <option value="North America">North America</option> -->
                                <!-- </select>
                </div>
            </div> -->
                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Country">Country</label>
                                        <select name="country" class="form-select country"
                                            aria-label="Default select example" disabled>
                                            <option value="IN">India</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="City">State</label>
                                        <select name="state" class="form-select state"
                                            aria-label="Default select example" onchange="loadCities()">
                                            <option selected>Select State/District</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="State/District">City</label>
                                        <select name="city" class="form-select city"
                                            aria-label="Default select example">
                                            <option selected>Select City</option>
                                        </select>
                                    </div>
                                </div> --}}

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="emp_job">Job Title<span class="text-danger">*</span></label>
                                        {{-- <input type="text" name="job_title" value="{{ old('job_title') }}" required> --}}
                                        <select name="emp_job" required>
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
                                            <option value="Compliance Training Manager">Compliance Training Manager
                                            </option>
                                            <option value="Cleaning Technician">Cleaning Technician</option>
                                            <option value="Administrator">Administrator</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Joining Date">Joining Date<span class="text-danger">*</span></label>
                                        <div class="calenderauditee">
                                            <input type="text" id="joining_date" value="{{ old('joining_date') }}"
                                                readonly placeholder="DD-MMM-YYYY" />
                                            <input type="date" name="joining_date" value="{{ old('joining_date') }}"
                                                max="" value="" class="hide-input"
                                                oninput="handleDateInput(this, 'joining_date')" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="qualification">Qualification<span class="text-danger">*</span></label>
                                       <div class="relative-container">
                                        <input type="text" name="qualification" value="{{ old('qualification') }}"
                                            required>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Department">Department Name<span class="text-danger">*</span></label>
                                        <select name="department" id="department" required
                                            onchange="toggleOtherDepartment()">
                                            <option value="">-- Select --</option>

                                            @foreach (Helpers::getDepartments() as $code => $department)
                                                <option value="{{ $code }}"
                                                    {{ old('department') == $code ? 'selected' : '' }}>
                                                    {{ $department }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="job_title">Designation<span class="text-danger">*</span></label>
                                        <select name="job_title" id="job_title" required
                                            onchange="toggleOtherDesignation()">
                                            <option value="">Enter Your Selection Here</option>
                                            <option value="Trainee" {{ old('job_title') == 'Trainee' ? 'selected' : '' }}>
                                                Trainee</option>
                                            <option value="Officer" {{ old('job_title') == 'Officer' ? 'selected' : '' }}>
                                                Officer</option>
                                            <option value="Senior Officer"
                                                {{ old('job_title') == 'Senior Officer' ? 'selected' : '' }}>Senior Officer
                                            </option>
                                            <option value="Executive"
                                                {{ old('job_title') == 'Executive' ? 'selected' : '' }}>Executive</option>
                                            <option value="Senior Executive"
                                                {{ old('job_title') == 'Senior Executive' ? 'selected' : '' }}>Senior
                                                Executive</option>
                                            <option value="Assistant Manager"
                                                {{ old('job_title') == 'Assistant Manager' ? 'selected' : '' }}>Assistant
                                                Manager</option>
                                            <option value="Manager" {{ old('job_title') == 'Manager' ? 'selected' : '' }}>
                                                Manager</option>
                                            <option value="Senior General Manager"
                                                {{ old('job_title') == 'Senior General Manager' ? 'selected' : '' }}>Senior
                                                General Manager</option>
                                            <option value="Senior Manager"
                                                {{ old('job_title') == 'Senior Manager' ? 'selected' : '' }}>Senior Manager
                                            </option>
                                            <option value="Deputy General Manager"
                                                {{ old('job_title') == 'Deputy General Manager' ? 'selected' : '' }}>Deputy
                                                General Manager</option>
                                            <option value="Assistant General Manager and General Manager"
                                                {{ old('job_title') == 'Assistant General Manager and General Manager' ? 'selected' : '' }}>
                                                Assistant General Manager and General Manager</option>
                                            <option value="Head Quality"
                                                {{ old('job_title') == 'Head Quality' ? 'selected' : '' }}>Head Quality
                                            </option>
                                            <option value="VP Quality"
                                                {{ old('job_title') == 'VP Quality' ? 'selected' : '' }}>VP Quality
                                            </option>
                                            <option value="Plant Head"
                                                {{ old('job_title') == 'Plant Head' ? 'selected' : '' }}>Plant Head
                                            </option>
                                            <option value="Other Designation"
                                                {{ old('job_title') == 'Other Designation' ? 'selected' : '' }}>Other
                                                Designation</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-lg-6" id="other_department_container" style="display: none;">
                                    <div class="group-input">
                                        <label for="other_department">Other Department</label>
                                        <input type="text" name="other_department"
                                            value="{{ old('other_department') }}" id="other_department">
                                    </div>
                                </div>
                                <div class="col-lg-6" id="other_designation_container" style="display: none;">
                                    <div class="group-input">
                                        <label for="other_designation">Other Designation</label>
                                        <input type="text" name="other_designation"
                                            value="{{ old('other_designation') }}" id="other_designation">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Attached CV">Attached CV</label>
                                        <input type="file" id="myfile" name="attached_cv"
                                            value="{{ old('attached_cv') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Certification/Qualification">Certification/Qualification</label>
                                        <input type="file" id="myfile" name="certification"
                                            value="{{ old('certification') }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Experience">Experience (No. of Years)<span
                                                class="text-danger">*</span></label>
                                        <select name="experience" id="Experience" value="{{ old('experience') }}"
                                            required>
                                            <option value="">Select </option>
                                            @for ($i = 1; $i <= 70; $i++)
                                                <option value="{{ $i }}"
                                                    {{ old('experience') == $i ? 'selected' : '' }}>{{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Additional Medical Document">Medical Checkup Report?</label>
                                        <select name="has_additional_document" id="has_additional_document"
                                            value="{{ old('has_additional_document') }}">
                                            <option value="">--Select--</option>
                                            <option value="No">No</option>
                                            <option value="Yes">Yes</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6" id="medical_attachment" style="display:none;">
                                    <div class="group-input">
                                        <label for="Attached Medical Document">Medical Checkup Attachment</label>
                                        <input type="file" name="additional_document" id="additional_document"
                                            value="{{ old('additional_document') }}">
                                    </div>
                                </div>

                                <script>
                                    document.getElementById('has_additional_document').addEventListener('change', function() {
                                        const medicalAttachment = document.getElementById('medical_attachment');
                                        if (this.value === 'Yes') {
                                            medicalAttachment.style.display = 'block';
                                        } else {
                                            medicalAttachment.style.display = 'none';
                                            document.getElementById('additional_document').value = '';
                                        }
                                    });
                                </script>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Additional Medical Document">Employment Type</label>
                                        <select name="employee_type" id="employee_type">
                                            <option value="">--Select--</option>
                                            <option value="full_time">Full Time</option>
                                            <option value="part_time">Part-Time</option>
                                            <option value="contracter">Contractor</option>
                                        </select>
                                    </div>
                                </div>



                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Additional Medical Document">Employee Status</label>
                                        <select name="employee_status" id="employee_status"
                                            value="{{ old('employee_status') }}">
                                            <option value="">--Select--</option>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                            <option value="terminated">Terminated</option>
                                        </select>
                                    </div>
                                </div>



                                <!-- <script>
                                    var config = {
                                        cUrl: 'https://api.countrystatecity.in/v1',
                                        ckey: 'NHhvOEcyWk50N2Vna3VFTE00bFp3MjFKR0ZEOUhkZlg4RTk1MlJlaA=='
                                    };

                                    var countrySelect = document.querySelector('.country'),
                                        stateSelect = document.querySelector('.state'),
                                        citySelect = document.querySelector('.city');

                                    function loadCountries() {
                                        let apiEndPoint = `${config.cUrl}/countries`;

                                        $.ajax({
                                            url: apiEndPoint,
                                            headers: {
                                                "X-CSCAPI-KEY": config.ckey
                                            },
                                            success: function(data) {
                                                data.forEach(country => {
                                                    const option = document.createElement('option');
                                                    option.value = country.iso2;
                                                    option.textContent = country.name;
                                                    countrySelect.appendChild(option);
                                                });
                                            },
                                            error: function(xhr, status, error) {
                                                console.error('Error loading countries:', error);
                                            }
                                        });
                                    }



                                    function loadCities() {
                                        citySelect.disabled = false;
                                        citySelect.innerHTML = '<option value="">Select City</option>';

                                        const selectedCountryCode = countrySelect.value;
                                        const selectedStateCode = stateSelect.value;

                                        $.ajax({
                                            url: `${config.cUrl}/countries/${selectedCountryCode}/states/${selectedStateCode}/cities`,
                                            headers: {
                                                "X-CSCAPI-KEY": config.ckey
                                            },
                                            success: function(data) {
                                                data.forEach(city => {
                                                    const option = document.createElement('option');
                                                    option.value = city.id;
                                                    option.textContent = city.name;
                                                    citySelect.appendChild(option);
                                                });
                                            },
                                            error: function(xhr, status, error) {
                                                console.error('Error loading cities:', error);
                                            }
                                        });
                                    }
                                    $(document).ready(function() {
                                        loadCountries();
                                    });
                                </script> -->
                                {{-- <script>
                                    var config = {
                                        cUrl: 'https://api.countrystatecity.in/v1',
                                        ckey: 'NHhvOEcyWk50N2Vna3VFTE00bFp3MjFKR0ZEOUhkZlg4RTk1MlJlaA=='
                                    };

                                    var countrySelect = document.querySelector('.country'),
                                        stateSelect = document.querySelector('.state'),
                                        citySelect = document.querySelector('.city');

                                    // Function to load states for India
                                    function loadStates() {
                                        stateSelect.disabled = false;
                                        stateSelect.innerHTML = '<option value="">Select State</option>';

                                        const selectedCountryCode = "IN"; // Fixed to India

                                        // Fetching states for India
                                        $.ajax({
                                            url: `${config.cUrl}/countries/${selectedCountryCode}/states`,
                                            headers: {
                                                "X-CSCAPI-KEY": config.ckey
                                            },
                                            success: function(data) {
                                                data.forEach(state => {
                                                    const option = document.createElement('option');
                                                    option.value = state.iso2;
                                                    option.textContent = state.name;
                                                    stateSelect.appendChild(option);
                                                });
                                            },
                                            error: function(xhr, status, error) {
                                                console.error('Error loading states:', error);
                                            }
                                        });
                                    }

                                    // Function to load cities based on selected state
                                    function loadCities() {
                                        citySelect.disabled = false;
                                        citySelect.innerHTML = '<option value="">Select City</option>';

                                        const selectedCountryCode = "IN"; // Fixed to India
                                        const selectedStateCode = stateSelect.value;

                                        // Fetching cities for the selected state
                                        $.ajax({
                                            url: `${config.cUrl}/countries/${selectedCountryCode}/states/${selectedStateCode}/cities`,
                                            headers: {
                                                "X-CSCAPI-KEY": config.ckey
                                            },
                                            success: function(data) {
                                                data.forEach(city => {
                                                    const option = document.createElement('option');
                                                    option.value = city.id;
                                                    option.textContent = city.name;
                                                    citySelect.appendChild(option);
                                                });
                                            },
                                            error: function(xhr, status, error) {
                                                console.error('Error loading cities:', error);
                                            }
                                        });
                                    }

                                    // Load states when the page is ready
                                    $(document).ready(function() {
                                        loadStates(); // Automatically load states for India
                                    });
                                </script> --}}

                                <!--
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Site Name">Site Name</label>
                                                <select name="site_name">
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option value="Corporate">Corporate</option>
                                                    <option value="Plant">Plant</option>

                                                </select>
                                            </div>
                                        </div> -->
                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <div class="group-input">
                                            <label for="Building">Building</label>
                                            <input type="text" name="building" value="{{ old('building')}}">
                                        </div>
                                    </div>
                                </div> --}}
                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Floor">Floor</label>
                                        <input type="text" name="floor" value="{{ old('floor')}}">
                                    </div>
                                </div> --}}
                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Room">Room</label>
                                        <input type="text" name="room" value="{{ old('room')}}">
                                    </div>
                                </div> --}}
                                {{-- <div class="col-6">
                                    <div class="group-input">
                                        <label for="Picture">Picture</label>
                                        <input type="file" id="myfile" name="picture" value="{{ old('picture')}}">
                                    </div>
                                </div> --}}
                                {{-- <div class="col-6">
                                    <div class="group-input">
                                        <label for="Picture">Specimen Signature </label>
                                        <input type="file" id="myfile" name="specimen_signature" value="{{ old('specimen_signature')}}">
                                    </div>
                                </div> --}}

                                {{-- <div class="col-6">
                                    <div class="group-input">
                                        <label for="Facility Name">HOD </label>
                                        <select multiple name="hod[]" placeholder="Select HOD" data-search="false" data-silent-initial-value-set="true" id="hod">
                                            @foreach ($userDetails as $userRole)
                                            <option value="{{ $userRole->id }}">{{ $userRole->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Facility Name">Designee </label>
                                        <select multiple name="designee[]" placeholder="Select Designee Name" data-search="false" data-silent-initial-value-set="true" id="designee">
                                            <option value="QA Head">QA Head</option>
                                            <option value="QC Head">QC Head</option>

                                        </select>
                                    </div>
                                </div> --}}
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Comments">Comments</label>
                                        <div class="relative-container">
                                        <textarea name="comment">{{ old('comment') }}</textarea>
                                        @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="File Attachment">File Attachment</label>
                                        <input type="file" id="myfile" name="file_attachment"
                                            value="{{ old('file_attachment') }}">
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="col-12 sub-head">
                                Job Responsibilities
                            </div>
                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    Job Responsibilities
                                    <button type="button" name="audit-agenda-grid" id="ObservationAdd">+</button>
                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        (Launch Instruction)
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="job-responsibilty-table" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;">Sr No.</th>
                                                <th>Job Responsibilities </th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input disabled type="text" name="jobResponsibilities[0][serial]" value="1"></td>
                                                <td><input type="text" name="jobResponsibilities[0][job]"></td>
                                                <td><input type="text" name="jobResponsibilities[0][remarks]"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div> --}}


                            <div class="col-12 sub-head">
                                Contact Information
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="email">Email<span class="text-danger">*</span></label>
                                        <div class="relative-container">
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Enter employee email" value="{{ old('email') }}" required>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                        @if ($errors->has('email'))
                                            <span style="color: red;">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="email">Phone Number<span class="text-danger"></span></label>
                                        <div class="relative-container">
                                        <input type="text" class="form-control" id="phone_number" name="phone_number"
                                            placeholder="Enter employee phone Number" value="">
                                        @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h4>Address 1</h4>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="address">Address<span class="text-danger"></span></label>
                                       <div class="relative-container">
                                        <input type="text" class="form-control" id="address_one" name="address_one"
                                            placeholder="Enter employee Address" value="{{ old('address_one') }}">
                                        @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>

                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="street">Street<span class="text-danger"></span></label>
                                        <div class="relative-container">
                                        <input type="text" class="form-control" id="street_one" name="street_one"
                                            placeholder="Enter employee street" value="{{ old('street_one') }}">
                                        @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>

                                    </div>
                                </div>
                            </div>


                            {{-- <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Country">Country</label>
                                        <select name="country" class="form-select country" aria-label="Default select example" onchange="loadStates()">
                                            <option value="">Select Country</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="State">State</label>
                                        <select name="state" class="form-select state" aria-label="Default select example" onchange="loadCities()"
                                            disabled>
                                            <option value="">Select State</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="City">City</label>
                                        <select name="city" class="form-select city" aria-label="Default select example" disabled>
                                            <option value="">Select City</option>
                                        </select>
                                    </div>
                                </div>

                                <script>
                                    var config = {
                                        cUrl: 'https://api.countrystatecity.in/v1',
                                        ckey: 'NHhvOEcyWk50N2Vna3VFTE00bFp3MjFKR0ZEOUhkZlg4RTk1MlJlaA=='
                                    };

                                    var countrySelect = document.querySelector('.country'),
                                        stateSelect = document.querySelector('.state'),
                                        citySelect = document.querySelector('.city');

                                    function loadCountries() {
                                        let apiEndPoint = `${config.cUrl}/countries`;

                                        $.ajax({
                                            url: apiEndPoint,
                                            headers: {
                                                "X-CSCAPI-KEY": config.ckey
                                            },
                                            success: function(data) {
                                                data.forEach(country => {
                                                    const option = document.createElement('option');
                                                    option.value = country.name;
                                                    option.textContent = country.name;
                                                    option.dataset.code = country
                                                    .iso2;
                                                    countrySelect.appendChild(option);
                                                });
                                            },
                                            error: function(xhr, status, error) {
                                                console.error('Error loading countries:', error);
                                            }
                                        });
                                    }

                                    function loadStates() {
                                        stateSelect.disabled = false;
                                        stateSelect.innerHTML = '<option value="">Select State</option>';

                                        const selectedCountryCode = countrySelect.options[countrySelect.selectedIndex].dataset.code;

                                        $.ajax({
                                            url: `${config.cUrl}/countries/${selectedCountryCode}/states`,
                                            headers: {
                                                "X-CSCAPI-KEY": config.ckey
                                            },
                                            success: function(data) {
                                                data.forEach(state => {
                                                    const option = document.createElement('option');
                                                    option.value = state.name
                                                    option.textContent = state.name;
                                                    option.dataset.code = state
                                                    .iso2;
                                                    stateSelect.appendChild(option);
                                                });
                                            },
                                            error: function(xhr, status, error) {
                                                console.error('Error loading states:', error);
                                            }
                                        });
                                    }

                                    function loadCities() {
                                        citySelect.disabled = false;
                                        citySelect.innerHTML = '<option value="">Select City</option>';

                                        const selectedCountryCode = countrySelect.options[countrySelect.selectedIndex].dataset.code;
                                        const selectedStateCode = stateSelect.options[stateSelect.selectedIndex].dataset.code;

                                        $.ajax({
                                            url: `${config.cUrl}/countries/${selectedCountryCode}/states/${selectedStateCode}/cities`,
                                            headers: {
                                                "X-CSCAPI-KEY": config.ckey
                                            },
                                            success: function(data) {
                                                data.forEach(city => {
                                                    const option = document.createElement('option');
                                                    option.value = city.name;
                                                    option.textContent = city.name;
                                                    citySelect.appendChild(option);
                                                });
                                            },
                                            error: function(xhr, status, error) {
                                                console.error('Error loading cities:', error);
                                            }
                                        });
                                    }

                                    $(document).ready(function() {
                                        loadCountries();
                                    });
                                </script>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="postal code">Postal Code</label>
                                        <input type="text" name="postal_code_two" id="postal_code_two" value="">
                                    </div>
                                </div>
                            </div> --}}


                            {{-- - Testing purpos code - --}}

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Country">Country</label>
                                        <select name="country" class="form-select country"
                                            aria-label="Default select example" onchange="loadStates()" disabled>
                                            <option value="India" data-code="IN" selected>India</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="State">State</label>
                                        <select name="state" class="form-select state"
                                            aria-label="Default select example" onchange="loadCities()" disabled>
                                            <option value="" disabled selected>Select State</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="City">City</label>
                                        <select name="city" class="form-select city"
                                            aria-label="Default select example" disabled>
                                            <option value="">Select City</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="postal code">Postal Code</label>
                                       
                                       <div class="relative-container">
                                        <input type="text" name="postal_code_one" id="postal_code_one"
                                            value="">
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                var config = {
                                    cUrl: 'https://api.countrystatecity.in/v1',
                                    ckey: 'NHhvOEcyWk50N2Vna3VFTE00bFp3MjFKR0ZEOUhkZlg4RTk1MlJlaA=='
                                };

                                var stateSelect = document.querySelector('.state'),
                                    citySelect = document.querySelector('.city');

                                function loadStates() {
                                    stateSelect.disabled = false;
                                    stateSelect.innerHTML = '<option value="">Select State</option>';

                                    const selectedCountryCode = "IN"; // Always India

                                    $.ajax({
                                        url: `${config.cUrl}/countries/${selectedCountryCode}/states`,
                                        headers: {
                                            "X-CSCAPI-KEY": config.ckey
                                        },
                                        success: function(data) {
                                            data.forEach(state => {
                                                const option = document.createElement('option');
                                                option.value = state.name;
                                                option.textContent = state.name;
                                                option.dataset.code = state.iso2;
                                                stateSelect.appendChild(option);
                                            });
                                            // Automatically select the first state if available
                                            // if (data.length > 0) {
                                            //     stateSelect.options[1].selected = true; // First state (0 index is the prompt)
                                            //     loadCities(); // Load cities for the first state
                                            // }
                                        },
                                        error: function(xhr, status, error) {
                                            console.error('Error loading states:', error);
                                        }
                                    });
                                }

                                function loadCities() {
                                    citySelect.disabled = false;
                                    citySelect.innerHTML = '<option value="">Select City</option>';

                                    const selectedStateCode = stateSelect.options[stateSelect.selectedIndex]?.dataset.code;

                                    $.ajax({
                                        url: `${config.cUrl}/countries/IN/states/${selectedStateCode}/cities`,
                                        headers: {
                                            "X-CSCAPI-KEY": config.ckey
                                        },
                                        success: function(data) {
                                            data.forEach(city => {
                                                const option = document.createElement('option');
                                                option.value = city.name;
                                                option.textContent = city.name;
                                                citySelect.appendChild(option);
                                            });
                                        },
                                        error: function(xhr, status, error) {
                                            console.error('Error loading cities:', error);
                                        }
                                    });
                                }

                                // Load states when the page is ready
                                $(document).ready(function() {
                                    loadStates(); // This will load states for India immediately
                                });
                            </script>



                            {{-- --- country state city test for code --- --}}

                            <br>



                            <h4>Address 2</h4>
                            <div class="row">

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="address">Address<span class="text-danger"></span></label>
                                           <div class="relative-container">
                                            <input type="text" class="form-control" id="addressNew" name="addressNew"
                                                placeholder="Enter employee Address" value="{{ old('addressNew') }}">
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>

                                        </div>
                                    </div>


                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="street">Street<span class="text-danger"></span></label>
                                            <div class="relative-container">
                                            <input type="text" class="form-control" id="streetNew" name="streetNew"
                                                placeholder="Enter employee street" value="{{ old('streetNew') }}">
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>

                                        </div>
                                    </div>
                                </div>

                                {{-- -----Address2 for code---- --}}

                                {{-- <div class="row">
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Country">Country</label>
                                            <select name="countryNew" class="form-select countryNew" aria-label="Default select example" onchange="loadStatesNew()">
                                                <option value="">Select Country</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="State">State</label>
                                            <select name="stateNew" class="form-select stateNew" aria-label="Default select example" onchange="loadCitiesNew()"
                                                disabled>
                                                <option value="">Select State</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="City">City</label>
                                            <select name="cityNew" class="form-select cityNew" aria-label="Default select example" disabled>
                                                <option value="">Select City</option>
                                            </select>
                                        </div>
                                    </div>
                                    <script>
                                        var config = {
                                            cUrl: 'https://api.countrystatecity.in/v1',
                                            ckey: 'NHhvOEcyWk50N2Vna3VFTE00bFp3MjFKR0ZEOUhkZlg4RTk1MlJlaA=='
                                        };

                                        var countrySelectNew = document.querySelector('.countryNew'),
                                            stateSelectNew = document.querySelector('.stateNew'),
                                            citySelectNew = document.querySelector('.cityNew');

                                        function loadCountriesNew() {
                                            let apiEndPoint = `${config.cUrl}/countries`;

                                            $.ajax({
                                                url: apiEndPoint,
                                                headers: {
                                                    "X-CSCAPI-KEY": config.ckey
                                                },
                                                success: function(data) {
                                                    data.forEach(countryNew => {
                                                        const option = document.createElement('option');
                                                        option.value = countryNew.name;
                                                        option.textContent = countryNew.name;
                                                        option.dataset.code = countryNew
                                                        .iso2;
                                                        countrySelectNew.appendChild(option);
                                                    });
                                                },
                                                error: function(xhr, status, error) {
                                                    console.error('Error loading countries:', error);
                                                }
                                            });
                                        }

                                        function loadStatesNew() {
                                            stateSelectNew.disabled = false;
                                            stateSelectNew.innerHTML = '<option value="">Select State</option>';

                                            const selectedCountryCodeNew = countrySelectNew.options[countrySelectNew.selectedIndex].dataset.code;

                                            $.ajax({
                                                url: `${config.cUrl}/countries/${selectedCountryCodeNew}/states`,
                                                headers: {
                                                    "X-CSCAPI-KEY": config.ckey
                                                },
                                                success: function(data) {
                                                    data.forEach(stateNew => {
                                                        const option = document.createElement('option');
                                                        option.value = stateNew.name
                                                        option.textContent = stateNew.name;
                                                        option.dataset.code = stateNew
                                                        .iso2;
                                                        stateSelectNew.appendChild(option);
                                                    });
                                                },
                                                error: function(xhr, status, error) {
                                                    console.error('Error loading states:', error);
                                                }
                                            });
                                        }

                                        function loadCitiesNew() {
                                            citySelectNew.disabled = false;
                                            citySelectNew.innerHTML = '<option value="">Select City</option>';

                                            const selectedCountryCodeNew = countrySelectNew.options[countrySelectNew.selectedIndex].dataset.code;
                                            const selectedStateCodeNew = stateSelectNew.options[stateSelectNew.selectedIndex].dataset.code;

                                            $.ajax({
                                                url: `${config.cUrl}/countries/${selectedCountryCodeNew}/states/${selectedStateCodeNew}/cities`,
                                                headers: {
                                                    "X-CSCAPI-KEY": config.ckey
                                                },
                                                success: function(data) {
                                                    data.forEach(cityNew => {
                                                        const option = document.createElement('option');
                                                        option.value = cityNew.name;
                                                        option.textContent = cityNew.name;
                                                        citySelectNew.appendChild(option);
                                                    });
                                                },
                                                error: function(xhr, status, error) {
                                                    console.error('Error loading cities:', error);
                                                }
                                            });
                                        }

                                        $(document).ready(function() {
                                            loadCountriesNew();
                                        });
                                    </script>

                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="postal code">Postal Code</label>
                                        <div class="relative-container">   
                                            <input type="text" name="postal_code_two" id="postal_code_two" value="">
                                        @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                        </div>
                                    </div>
                                </div> --}}

                                {{-- --Addresss2 for code--- --}}

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Country">Country</label>
                                            <select name="countryNew" class="form-select countryNew"
                                                aria-label="Default select example" onchange="loadStatesNew()" disabled>
                                                <option value="">Select Country</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="State">State</label>
                                            <select name="stateNew" class="form-select stateNew"
                                                aria-label="Default select example" onchange="loadCitiesNew()" disabled>
                                                <option value="" disabled selected>Select State</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="City">City</label>
                                            <select name="cityNew" class="form-select cityNew"
                                                aria-label="Default select example" disabled>
                                                <option value="">Select City</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="postal code">Postal Code</label>
                                            <div class="relative-container">
                                            <input type="text" name="postal_code_two" id="postal_code_two"
                                                value="">
                                                @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    var config = {
                                        cUrl: 'https://api.countrystatecity.in/v1',
                                        ckey: 'NHhvOEcyWk50N2Vna3VFTE00bFp3MjFKR0ZEOUhkZlg4RTk1MlJlaA=='
                                    };

                                    var countrySelectNew = document.querySelector('.countryNew'),
                                        stateSelectNew = document.querySelector('.stateNew'),
                                        citySelectNew = document.querySelector('.cityNew');

                                    function loadCountriesNew() {
                                        let apiEndPoint = `${config.cUrl}/countries`;

                                        $.ajax({
                                            url: apiEndPoint,
                                            headers: {
                                                "X-CSCAPI-KEY": config.ckey
                                            },
                                            success: function(data) {
                                                data.forEach(countryNew => {
                                                    const option = document.createElement('option');
                                                    option.value = countryNew.name;
                                                    option.textContent = countryNew.name;
                                                    option.dataset.code = countryNew.iso2;
                                                    countrySelectNew.appendChild(option);
                                                });

                                                // Automatically select India
                                                countrySelectNew.value = 'India'; // Select 'India' by default
                                                loadStatesNew(); // Load states for India
                                            },
                                            error: function(xhr, status, error) {
                                                console.error('Error loading countries:', error);
                                            }
                                        });
                                    }

                                    function loadStatesNew() {
                                        stateSelectNew.disabled = false;
                                        stateSelectNew.innerHTML = '<option value="">Select State</option>';

                                        const selectedCountryCodeNew = countrySelectNew.options[countrySelectNew.selectedIndex].dataset.code;

                                        $.ajax({
                                            url: `${config.cUrl}/countries/${selectedCountryCodeNew}/states`,
                                            headers: {
                                                "X-CSCAPI-KEY": config.ckey
                                            },
                                            success: function(data) {
                                                data.forEach(stateNew => {
                                                    const option = document.createElement('option');
                                                    option.value = stateNew.name;
                                                    option.textContent = stateNew.name;
                                                    option.dataset.code = stateNew.iso2;
                                                    stateSelectNew.appendChild(option);
                                                });

                                                // Automatically select the first state if available
                                                // if (data.length > 0) {
                                                //     stateSelectNew.options[1].selected = true; // Select first state
                                                //     loadCitiesNew(); // Load cities for the selected state
                                                // }
                                            },
                                            error: function(xhr, status, error) {
                                                console.error('Error loading states:', error);
                                            }
                                        });
                                    }

                                    function loadCitiesNew() {
                                        citySelectNew.disabled = false;
                                        citySelectNew.innerHTML = '<option value="">Select City</option>';

                                        const selectedCountryCodeNew = countrySelectNew.options[countrySelectNew.selectedIndex].dataset.code;
                                        const selectedStateCodeNew = stateSelectNew.options[stateSelectNew.selectedIndex].dataset.code;

                                        $.ajax({
                                            url: `${config.cUrl}/countries/${selectedCountryCodeNew}/states/${selectedStateCodeNew}/cities`,
                                            headers: {
                                                "X-CSCAPI-KEY": config.ckey
                                            },
                                            success: function(data) {
                                                data.forEach(cityNew => {
                                                    const option = document.createElement('option');
                                                    option.value = cityNew.name;
                                                    option.textContent = cityNew.name;
                                                    citySelectNew.appendChild(option);
                                                });
                                            },
                                            error: function(xhr, status, error) {
                                                console.error('Error loading cities:', error);
                                            }
                                        });
                                    }

                                    $(document).ready(function() {
                                        loadCountriesNew(); // Load countries on page ready
                                    });
                                </script>

                            </div>

                            <div class="button-block">
                                <button type="submit" id="ChangesaveButton01" class="saveButton">Save</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <!-- <button type="button" class="backButton" onclick="previousStep()">Back</button> -->

                            </div>

                        </div>
                    </div>
                </div>

                <!-- Tab content -->
                {{-- <div id="CCForm2" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="group-input" id="external-details-grid">
                                <label for="audit-agenda-grid">
                                    External Training Details
                                    <button disabled type="button" name="audit-agenda-grid" id="details-grid">+</button>
                                    <span class="text-primary" data-bs-toggle="modal"
                                        data-bs-target="#observation-field-instruction-modal"
                                        style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        (Launch Instruction)
                                    </span>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="external-training-table"
                                        style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="width: 50px;">Sr. No.</th>
                                                <th>Topic</th>

                                                <th style="width: 200px;">External Training Date</th>
                                                <th>External Trainer</th>

                                                <th>External Training Agency</th>
                                                <th style="width: 200px;">Certificate</th>
                                                <th style="width: 200px;">Supporting Documents</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input disabled type="text" name="external_training[0][serial]"
                                                        value="1"></td>
                                                <td><input disabled type="text" name="external_training[0][topic]">
                                                </td>
                                                <td><input disabled type="date"
                                                        name="external_training[0][external_training_date]"></td>
                                                <td><input disabled type="text"
                                                        name="external_training[0][external_trainer]"></td>
                                                <td><input disabled type="text"
                                                        name="external_training[0][external_agency]"></td>
                                                <td><input disabled type="file"
                                                        name="external_training[0][certificate]"></td>
                                                <td><input disabled type="file"
                                                        name="external_training[0][supproting_documents]"></td>
                                            </tr>

                                        </tbody>

                                    </table>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="External Comments">External Comments</label>
                                        <textarea disabled name="external_comment"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="External Attachment">External Attachment</label>
                                        <input disabled type="file" id="myfile" name="external_attachment">
                                    </div>
                                </div>
                            </div>
                            <script>
                                $(document).ready(function() {
                                    $('#details-grid').click(function(e) {
                                        function generateTableRow(serialNumber) {
                                            var users = @json($users);

                                            var html =
                                                '<tr>' +
                                                '<td><input disabled type="text" name="external_training[' + serialNumber +
                                                '][serial]" value="' + serialNumber +
                                                '"></td>' +
                                                '<td><input type="text" name="external_training[' + serialNumber +
                                                '][topic]"></td>' +
                                                '<td><input type="date" name="external_training[' + serialNumber +
                                                '][external_training_date]"></td>' +
                                                '<td><input type="text" name="external_training[' + serialNumber +
                                                '][external_trainer]"></td>' +
                                                '<td><input type="text" name="external_training[' + serialNumber +
                                                '][external_agency]"></td>' +
                                                '<td><input type="file" name="external_training[' + serialNumber +
                                                '][certificate]"></td>' +
                                                '<td><input type="file" name="external_training[' + serialNumber +
                                                '][supproting_documents]"></td>' +
                                                '</tr>';

                                            // for (var i = 0; i < users.length; i++) {
                                            //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                                            // }

                                            '</tr>';

                                            return html;
                                        }

                                        var tableBody = $('#external-training-table tbody');
                                        var rowCount = tableBody.children('tr').length;
                                        var newRow = generateTableRow(rowCount + 1);
                                        tableBody.append(newRow);
                                    });
                                });
                            </script>

                        </div>
                        <div class="button-block">
                            <button type="submit" id="ChangesaveButton02" class="saveButton">Save</button>
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button" id="ChangeNextButton" class="nextButton">Next</button>
                            <button type="button"> <a href="{{ url('TMS') }}" class="text-white">
                                    Exit </a> </button>
                        </div>
                    </div>
                </div> --}}


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



                <!-- Activity Log content -->
                <div id="CCForm2" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Activated By">Activate By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Activated On">Activate On</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Activated On">Activate Comment</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for=" Rejected By">Send induction-Training By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Rejected On">Send induction-Training On</label>
                                    <div class="static"></div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Rejected On">Send induction-Training Comment</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Rejected On">Complete By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Rejected On">Complete On</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Rejected On">Complete Comment</label>
                                    <div class="static"></div>
                                </div>
                            </div>

                        </div>
                        <div class="button-block">
                            <button type="submit" id="ChangesaveButton01" class="saveButton">Save</button>
                            <button type="button" class="backButton">Back</button>
                            <button type="button"> <a href="{{ url('TMS') }}" class="text-white">Exit </a> </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

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

            // Find the index of the clicked tab button
            const index = Array.from(cctablinks).findIndex(button => button === evt.currentTarget);

            // Update the currentStep to the index of the clicked tab
            currentStep = index;
        }

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
    <script>
        $(document).ready(function() {
            setTimeout(() => {
                $('body').css('top', '0');
            }, 5000);
        })
    </script>
@endsection
