    {{-- ======================================
                    TMS HEAD
    ======================================= --}}
    <style>
        .modal123 {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content123 {
            background-color: #fff;
            margin: 15% auto;
            padding: 40px;
            width: 850px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

    </style>

 <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>

    <div id="tms-head">
        <div class="head">Learning Management System</div>
        <div class="link-list" style="    font-size: 15px;">
            {{-- <a style="cursor: pointer" onclick="

            window.open('/activity_log', '_blank', 'width=1200, height=900, top=0, left=0');"
                data-bs-toggle="tooltip" title="Training Log">
             Training Log
        </a> --}}

            <a href="{{ route('TMS.index') }}" class="tms-link">Dashboard</a>
            <a href="{{ route('scorm_new') }}" class="tms-link">Create Scorm</a>
            <a href="{{ url('TMS/show') }}" class="tms-link">Manage Training Plan</a>
            <a href="{{ route('training_analytics') }}" class="tms-link">Training Analytics</a>
            {{-- <a href="{{ route('create-tni') }}" class="tms-link">TNI/TNA</a> --}}

            {{-- <a href="{{ route('trainer_qualification') }}" class="tms-link">Trainer Qualification</a> --}}
            {{-- <a href="{{ route('analyst_qualification') }}" class="tms-link">Analyst Qualification</a> --}}
            <div class="tms-drop-block">
                <div class="drop-btn">Quizzes&nbsp;<i class="fa-solid fa-angle-down"></i></div>
                <div class="drop-list">
                    <a href="/question">Question</a>
                    <a href="/question-bank">Question Banks</a>
                    <a href="{{ route('quize.index') }}">Manage Quizzes</a>
                </div>
            </div>

            {{-- <div class="tms-drop-block">
                <div class="drop-btn">Graphs&nbsp;<i class="fa-solid fa-angle-down"></i></div>
                <div style="min-width: 270px !important; right: 0px;" class="drop-list">
                        <li>
                            <a id="designation_training">Designation Training Analytics</a>
                        </li>
                        <li>
                            <a id="jobrole_training">Job Role Training Analytics</a>
                        </li>
                        <li>
                            <a href="{{ url('training_graphs') }}">Training Graphs</a>
                        </li>
                </div>
            </div> --}}
            
            {{-- <div class="tms-drop-block">
                <div class="drop-btn">Activities&nbsp;<i class="fa-solid fa-angle-down"></i></div>
                <div class="drop-list">
                    <a href="{{ route('TMS.create') }}">Create Training Plan</a>
                    <a href="{{ url('TMS/show') }}">Manage Training Plan</a>
                    <a href="{{ url('induction_training') }}">Induction Training</a>
                    <a href="{{ url('job_training') }}">On The Job Training</a>
                    <a href="{{ url('job_description') }}">Job Description</a>
                </div>
            </div> --}}
            <!-- Dropdown -->
            <div class="tms-drop-block">
                <div class="drop-btn">Reports&nbsp;<i class="fa-solid fa-angle-down"></i></div>
                <div style="min-width: 290px !important; right: 0px;" class="drop-list">
                    <ul>
                        {{-- <li>
                    <a href="{{ url('training-attandance') }}">Training Attendance Report</a>
                            
                        </li> --}}
                        <li>
                            <a id="yearly-training" >Yearly Training Planner</a>

                        </li>
                        <li>

                            <a id="list-of-qualified-trainers">List Of Qualified Trainers</a>
                        </li>
                        <li>

                            <a href="#" id="employee-training-history">Employee Training History</a>
                        </li>
                        <li>

                            <a id="department_wise_report">Job Role Training History</a>
                        </li>
                       {{-- <li>
                             <a href="#" id="sop-training-history">SOP Training History</a> 
                        </li>--}}
                        {{-- <li>    

                            <a href="{{ url('training-need-identification') }}">Training Need Identification Matrix</a>
                        </li> --}}
                    </ul>
                </div>
            </div>
            @php
                $emp = DB::table('employees')->get();
                $users = DB::table('users')->get();
                $topic = DB::table('trainings')->get();
            @endphp
            <!-- Modal -->
            <div id="employeeModal" class="modal123" style="display: none;">
                <div class="modal-content123">
                    <span class="close">&times;</span>
                    <form method="post" id="employeeForm" action="{{ url('training-history') }}">
                        @csrf <!-- Include CSRF token for form security -->
                        <div class="pm-certificate-logos ">
                            <img style="scale: 0.7; margin-left: -35px;" src="{{ asset('user/images/connexo.png') }}" alt="connexo Logo" class="logo">
                            <p class="text-center" style="flex-grow: 1; font-size: 24px; font-weight: bold; white-space: nowrap; margin-right: 48px;">Employee Training History</p>
                            {{-- <img style="scale: 1.7" src="{{ asset('user/images/symbiotec_pharmalab_pvt_ltd__logo.jpg') }}" alt="Vidhya GxP Logo" class="logo"> --}}
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="employee_id">Employee Name</label>
                                <select name="employee_id" id="employee_id" class="form-control custom-select" required>
                                    <option value="">Select Employee</option>
                                    @foreach($emp as $val)
                                        <option value="{{ $val->id }}">{{ $val->employee_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <div class="form-group col-md-4">
                                <label for="training_type">Training</label>
                                <select name="training_type" id="training_type" class="form-control custom-select" required>
                                    <option value="">Select Training</option>
                                    <option value="Induction Training">Induction Training</option>
                                    <option value="On The Job Training">On The Job Training</option>
                                    <option value="Classroom Training">Classroom Training</option>
                                </select>
                            </div>
                        
                            <div class="form-group col-md-4">
                                <label for="department">Department</label>
                                <select name="department" id="department" class="form-control custom-select" required>
                                    <option value="NA">Select Department</option>
                                    <option value="Corporate Quality Assurance">Corporate Quality Assurance</option>
                                    <option value="Quality Assurance-">Quality Assurance</option>
                                    <option value="Quality Control">Quality Control</option>
                                    <option value="Quality Control (Microbiology department)">Quality Control (Microbiology department)</option>
                                    <option value="Production General">Production General</option>
                                    <option value="Production Liquid Orals">Production Liquid Orals</option>
                                    <option value="Production Tablet and Powder">Production Tablet and Powder</option>
                                    <option value="Production External (Ointment, Gels, Creams and Liquid)">Production External (Ointment, Gels, Creams and Liquid)</option>
                                    <option value="Production Capsules">Production Capsules</option>
                                    <option value="Production Injectable">Production Injectable</option>
                                    <option value="Engineering">Engineering</option>
                                    <option value="Human Resource">Human Resource</option>
                                    <option value="Store">Store</option>
                                    <option value="Electronic Data Processing">Electronic Data Processing</option>
                                    <option value="Formulation Development">Formulation Development</option>
                                    <option value="Analytical research and Development Laboratory">Analytical research and Development Laboratory</option>
                                    <option value="Packaging Development">Packaging Development</option>
                                    <option value="Purchase Department">Purchase Department</option>
                                    <option value="Document Cell">Document Cell</option>
                                    <option value="Regulatory Affairs">Regulatory Affairs</option>
                                    <option value="Pharmacovigilance">Pharmacovigilance</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="year">Year</label>
                                <select name="year" id="year" class="form-control custom-select" required>
                                    <option value="">Select Year</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>
                                    <option value="2028">2028</option>
                                    <option value="2029">2029</option>
                                    <option value="2030">2030</option>
                                    <option value="2031">2031</option>
                                </select>
                            </div>
                        
                            <div class="form-group col-md-4">
                                <label for="start_date">Start Date</label>
                                <input type="text" id="start_date" class="form-control datepicker" name="start_date" placeholder="DD-MM-YYYY">
                            </div>
                        
                            <div class="form-group col-md-4">
                                <label for="end_date">End Date</label>
                                <input type="text" id="end_date" class="form-control datepicker" name="end_date" placeholder="DD-MM-YYYY">
                            </div>
                        </div>
                        
                        <script>
                            $(function() {
                                $(".datepicker").datepicker({
                                    dateFormat: 'yy-mm-dd' // Format set to 'YYYY-MM-DD'
                                });
                            });
                        </script>
                        
                        <br>
                        <button type="submit">Submit</button>
                        <button type="button" onclick="closeModal()">Close</button>

                    </form>
                </div>
            </div>

            <div id="SOPModal" class="modal123" style="display: none;">
                <div class="modal-content123">
                    <span class="close">&times;</span>
                    <form method="post" id="employeeForm" action="{{ url('SOP-history') }}">
                        @csrf <!-- Include CSRF token for form security -->
                        <div class="pm-certificate-logos ">
                            <img style="scale: 0.7; margin-left: -35px;" src="{{ asset('user/images/connexo.png') }}" alt="connexo Logo" class="logo">
                            <p class="text-center" style="flex-grow: 1; font-size: 24px; font-weight: bold; white-space: nowrap; margin-right: 48px;">SOP Training History</p>
                            {{-- <img style="scale: 1.7" src="{{ asset('user/images/symbiotec_pharmalab_pvt_ltd__logo.jpg') }}" alt="Vidhya GxP Logo" class="logo"> --}}
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="sop_id">SOP Number</label>
                                <select name="sop_id" id="sop_id" class="form-control custom-select" required>
                                    <option value="">Select SOP Number</option>
                                    @foreach($topic as $val)
                                        <option value="{{ $val->id }}">{{ Helpers::getFormattedDocumentNumbers($val->sops) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <div class="form-group col-md-4">
                                <label for="training_type">Training</label>
                                <select name="training_type" id="training_type" class="form-control custom-select" required>
                                    <option value="">Select Training</option>
                                    <option value="Induction Training">Induction Training</option>
                                    <option value="On The Job Training">On The Job Training</option>
                                    <option value="Classroom Training">Classroom Training</option>
                                </select>
                            </div>
                        
                            <div class="form-group col-md-4">
                                <label for="department">Department</label>
                                <select name="department" id="department" class="form-control custom-select" required>
                                    <option value="NA">Select Department</option>
                                    <option value="Corporate Quality Assurance">Corporate Quality Assurance</option>
                                    <option value="Quality Assurance-">Quality Assurance</option>
                                    <option value="Quality Control">Quality Control</option>
                                    <option value="Quality Control (Microbiology department)">Quality Control (Microbiology department)</option>
                                    <option value="Production General">Production General</option>
                                    <option value="Production Liquid Orals">Production Liquid Orals</option>
                                    <option value="Production Tablet and Powder">Production Tablet and Powder</option>
                                    <option value="Production External (Ointment, Gels, Creams and Liquid)">Production External (Ointment, Gels, Creams and Liquid)</option>
                                    <option value="Production Capsules">Production Capsules</option>
                                    <option value="Production Injectable">Production Injectable</option>
                                    <option value="Engineering">Engineering</option>
                                    <option value="Human Resource">Human Resource</option>
                                    <option value="Store">Store</option>
                                    <option value="Electronic Data Processing">Electronic Data Processing</option>
                                    <option value="Formulation Development">Formulation Development</option>
                                    <option value="Analytical research and Development Laboratory">Analytical research and Development Laboratory</option>
                                    <option value="Packaging Development">Packaging Development</option>
                                    <option value="Purchase Department">Purchase Department</option>
                                    <option value="Document Cell">Document Cell</option>
                                    <option value="Regulatory Affairs">Regulatory Affairs</option>
                                    <option value="Pharmacovigilance">Pharmacovigilance</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="year">Year</label>
                                <select name="year" id="year" class="form-control custom-select" required>
                                    <option value="">Select Year</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>
                                    <option value="2028">2028</option>
                                    <option value="2029">2029</option>
                                    <option value="2030">2030</option>
                                    <option value="2031">2031</option>
                                </select>
                            </div>
                        
                            <div class="form-group col-md-4">
                                <label for="start_date">Start Date</label>
                                <input type="text" id="start_date" class="form-control datepicker" name="start_date" placeholder="DD-MM-YYYY">
                            </div>
                        
                            <div class="form-group col-md-4">
                                <label for="end_date">End Date</label>
                                <input type="text" id="end_date" class="form-control datepicker" name="end_date" placeholder="DD-MM-YYYY">
                            </div>
                        </div>
                        
                        <script>
                            $(function() {
                                $(".datepicker").datepicker({
                                    dateFormat: 'yy-mm-dd' // Format set to 'YYYY-MM-DD'
                                });
                            });
                        </script>
                        
                        <br>
                        <button type="submit">Submit</button>
                        <button type="button" onclick="closeModal()">Close</button>

                    </form>
                </div>
            </div>


            <script>
                function closeModal() {
                    document.getElementById('employeeModal').style.display = 'none';
                    document.getElementById('SOPModal').style.display = 'none';

                }
            </script>
            <style>
                .form-row {
                    display: flex;  /* Use flexbox to align the form fields horizontally */
                    gap: 15px;      /* Add space between columns */
                }

                .form-group {
                    flex: 1;        /* Each dropdown will take equal width */
                }
            </style>
            <style>
                 .pm-certificate-logos {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                }

                .pm-certificate-logos .logo {
                    max-height: 50px; /* Adjust as needed */
                }

                .pm-certificate-logos p {
                    text-align: center;
                }
            </style>
            <div id="yearlyModal" class="modal123" style="display: none;">
                <div class="modal-content123">
                    <span class="close">&times;</span>
                    <form method="post" id="yearlyModal" action="{{ url('yearly-training-post') }}">
                        @csrf <!-- Include CSRF token for form security -->
                        <div class="pm-certificate-logos ">
                            <img style="scale: 0.7; margin-left: -35px;" src="{{ asset('user/images/connexo.png') }}" alt="connexo Logo" class="logo">
                            <p class="text-center" style="flex-grow: 1; font-size: 24px; font-weight: bold; white-space: nowrap; margin-right: 48px;">Yearly Training Planner</p>
                            {{-- <img style="scale: 1.7" src="{{ asset('user/images/symbiotec_pharmalab_pvt_ltd__logo.jpg') }}" alt="Vidhya GxP Logo" class="logo"> --}}
                        </div>
                        <br>
                        <br>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="site_division_1">Site/Location</label>
                                <select name="site_division_1" id="site_division_1" class="form-control custom-select" required>
                                    <option value="">Select Location</option>
                                    <option value="P1(Indore Location)">P1 (Indore Location)</option>
                                    <option value="P2(Pithampur Location)">P2 (Pithampur Location)</option>
                                    <option value="P4(Ujjain Site)">P4 (Ujjain Site)</option>
                                    <option value="C1(China Plant)">C1 (China Plant)</option>
                                </select>
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label for="site_division_2">Department</label>
                                <select name="site_division_2" id="site_division_2" class="form-control custom-select" required>
                                        <option value="NA">Select Department</option>
                                        <option value="CQA">Corporate Quality Assurance</option>
                                        <option value="QA">Quality Assurance</option>
                                        <option value="QC">Quality Control</option>
                                        <option value="QM">Quality Control (Microbiology department)</option>
                                        <option value="PG">Production General</option>
                                        <option value="PL">Production Liquid Orals</option>
                                        <option value="PT">Production Tablet and Powder</option>
                                        <option value="PE">Production External (Ointment, Gels, Creams and Liquid)</option>
                                        <option value="PC">Production Capsules</option>
                                        <option value="PI">Production Injectable</option>
                                        <option value="EN">Engineering</option>
                                        <option value="HR">Human Resource</option>
                                        <option value="ST">Store</option>
                                        <option value="IT">Electronic Data Processing</option>
                                        <option value="FD">Formulation Development</option>
                                        <option value="AL">Analytical research and Development Laboratory</option>
                                        <option value="PD">Packaging Development</option>
                                        <option value="PU">Purchase Department</option>
                                        <option value="DC">Document Cell</option>
                                        <option value="RA">Regulatory Affairs</option>
                                        <option value="PV">Pharmacovigilance</option>
                                </select>
                            </div>
                        
                            <div class="form-group col-md-4">
                                <label for="site_division_3">Year</label>
                                <select name="site_division_3" id="site_division_3" class="form-control custom-select" required>
                                    <option value="">Select Year</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>
                                    <option value="2028">2028</option>
                                    <option value="2029">2029</option>
                                    <option value="2030">2030</option>
                                    <option value="2032">2031</option>
                                </select>
                            </div>
                        </div>             
                        <br>
                        <button type="submit">Submit</button>
                    </form>
                </div>
            </div>
            <div id="designation_training_Modal" class="modal123" style="display: none;">
                <div class="modal-content123">
                    <span class="close">&times;</span>
                    <form method="post" id="designation_training_Modal" action="{{ url('designation-training-post') }}">
                        @csrf <!-- Include CSRF token for form security -->
                        <div class="pm-certificate-logos ">
                            <img style="scale: 0.7; margin-left: -35px;" src="{{ asset('user/images/connexo.png') }}" alt="connexo Logo" class="logo">
                            <p class="text-center" style="flex-grow: 1; font-size: 24px; font-weight: bold; white-space: nowrap; margin-right: 48px;">Employee Designation Training Histroy</p>
                            {{-- <img style="scale: 1.7" src="{{ asset('user/images/symbiotec_pharmalab_pvt_ltd__logo.jpg') }}" alt="Vidhya GxP Logo" class="logo"> --}}
                        </div>
                        <br>
                        <br>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="division">Site/Location</label>
                                <select name="division" id="division" class="form-control custom-select" required>
                                    <option value="">Select Location</option>
                                    <option value="P1">P1 (Indore Location)</option>
                                    <option value="P2">P2 (Pithampur Location)</option>
                                    <option value="P4">P4 (Ujjain Site)</option>
                                    <option value="C1">C1 (China Plant)</option>
                                </select>
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label for="department">Department</label>
                                <select name="department" id="department" class="form-control custom-select" required>
                                    <option value="NA">Select Department</option>
                                        <option value="CQA">Corporate Quality Assurance</option>
                                        <option value="QA">Quality Assurance</option>
                                        <option value="QC">Quality Control</option>
                                        <option value="QM">Quality Control (Microbiology department)</option>
                                        <option value="PG">Production General</option>
                                        <option value="PL">Production Liquid Orals</option>
                                        <option value="PT">Production Tablet and Powder</option>
                                        <option value="PE">Production External (Ointment, Gels, Creams and Liquid)</option>
                                        <option value="PC">Production Capsules</option>
                                        <option value="PI">Production Injectable</option>
                                        <option value="EN">Engineering</option>
                                        <option value="HR">Human Resource</option>
                                        <option value="ST">Store</option>
                                        <option value="IT">Electronic Data Processing</option>
                                        <option value="FD">Formulation Development</option>
                                        <option value="AL">Analytical research and Development Laboratory</option>
                                        <option value="PD">Packaging Development</option>
                                        <option value="PU">Purchase Department</option>
                                        <option value="DC">Document Cell</option>
                                        <option value="RA">Regulatory Affairs</option>
                                        <option value="PV">Pharmacovigilance</option>
                                </select>
                            </div>
                        </div>             
                        <br>
                        <button type="submit">Submit</button>
                    </form>
                </div>
            </div>
            <div id="jobrole_training_Modal" class="modal123" style="display: none;">
                <div class="modal-content123">
                    <span class="close">&times;</span>
                    <form method="post" id="jobrole_training_Modal" action="{{ url('jobrole-training-post') }}">
                        @csrf <!-- Include CSRF token for form security -->
                        <div class="pm-certificate-logos ">
                            <img style="scale: 0.7; margin-left: -35px;" src="{{ asset('user/images/connexo.png') }}" alt="connexo Logo" class="logo">
                            <p class="text-center" style="flex-grow: 1; font-size: 24px; font-weight: bold; white-space: nowrap; margin-right: 48px;">Employee Job Role Training</p>
                            {{-- <img style="scale: 1.7" src="{{ asset('user/images/symbiotec_pharmalab_pvt_ltd__logo.jpg') }}" alt="Vidhya GxP Logo" class="logo"> --}}
                        </div>
                        <br>
                        <br>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="division">Site/Location</label>
                                <select name="division" id="division" class="form-control custom-select" required>
                                    <option value="">Select Location</option>
                                    <option value="P1">P1 (Indore Location)</option>
                                    <option value="P2">P2 (Pithampur Location)</option>
                                    <option value="P4">P4 (Ujjain Site)</option>
                                    <option value="C1">C1 (China Plant)</option>
                                </select>
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label for="department">Department</label>
                                <select name="department" id="department" class="form-control custom-select" required>
                                    <option value="NA">Select Department</option>
                                        <option value="CQA">Corporate Quality Assurance</option>
                                        <option value="QA">Quality Assurance</option>
                                        <option value="QC">Quality Control</option>
                                        <option value="QM">Quality Control (Microbiology department)</option>
                                        <option value="PG">Production General</option>
                                        <option value="PL">Production Liquid Orals</option>
                                        <option value="PT">Production Tablet and Powder</option>
                                        <option value="PE">Production External (Ointment, Gels, Creams and Liquid)</option>
                                        <option value="PC">Production Capsules</option>
                                        <option value="PI">Production Injectable</option>
                                        <option value="EN">Engineering</option>
                                        <option value="HR">Human Resource</option>
                                        <option value="ST">Store</option>
                                        <option value="IT">Electronic Data Processing</option>
                                        <option value="FD">Formulation Development</option>
                                        <option value="AL">Analytical research and Development Laboratory</option>
                                        <option value="PD">Packaging Development</option>
                                        <option value="PU">Purchase Department</option>
                                        <option value="DC">Document Cell</option>
                                        <option value="RA">Regulatory Affairs</option>
                                        <option value="PV">Pharmacovigilance</option>
                                </select>
                            </div>
                        </div>             
                        <br>
                        <button type="submit">Submit</button>
                    </form>
                </div>
            </div>
            <div id="ListModal" class="modal123" style="display: none;">
                <div class="modal-content123">
                    <span class="close">&times;</span>
                    <form method="post" id="ListModal" action="{{ url('list-of-qualified-trainers-post') }}">
                        @csrf <!-- Include CSRF token for form security -->
                        <div class="pm-certificate-logos ">
                            <img style="scale: 0.7; margin-left: -35px;" src="{{ asset('user/images/connexo.png') }}" alt="connexo Logo" class="logo">
                            <p class="text-center" style="flex-grow: 1; font-size: 24px; font-weight: bold; white-space: nowrap; margin-right: 48px;">List Of Quealified Trainers</p>
                            {{-- <img style="scale: 1.7" src="{{ asset('user/images/symbiotec_pharmalab_pvt_ltd__logo.jpg') }}" alt="Vidhya GxP Logo" class="logo"> --}}
                        </div>
                        <br>
                        <br>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="site_division_1">Site/Location 1</label>
                                <select name="site_code" id="site_code" class="form-control custom-select" required>
                                    <option value="">Select Location</option>
                                    <option value="P1(Indore Location)">P1 (Indore Location)</option>
                                    <option value="P2(Pithampur Location)">P2 (Pithampur Location)</option>
                                    <option value="P4(Ujjain Site)">P4 (Ujjain Site)</option>
                                    <option value="C1(China Plant)">C1 (China Plant)</option>
                                </select>
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label for="site_division_2">Department</label>
                                <select name="site_division_2" id="site_division_2" class="form-control custom-select" required>
                                        <option value="NA">Select Department</option>
                                        <option value="Corporate Quality Assurance">Corporate Quality Assurance</option>
                                        <option value="Quality Assurance-">Quality Assurance</option>
                                        <option value="Quality Control">Quality Control</option>
                                        <option value="Quality Control (Microbiology department)">Quality Control (Microbiology department)</option>
                                        <option value="Production General">Production General</option>
                                        <option value="Production Liquid Orals">Production Liquid Orals</option>
                                        <option value="Production Tablet and Powder">Production Tablet and Powder</option>
                                        <option value="Production External (Ointment, Gels, Creams and Liquid)">Production External (Ointment, Gels, Creams and Liquid)</option>
                                        <option value="Production Capsules">Production Capsules</option>
                                        <option value="Production Injectable">Production Injectable</option>
                                        <option value="Engineering">Engineering</option>
                                        <option value="Human Resource">Human Resource</option>
                                        <option value="Store">Store</option>
                                        <option value="Electronic Data Processing">Electronic Data Processing</option>
                                        <option value="Formulation Development">Formulation Development</option>
                                        <option value="Analytical research and Development Laboratory">Analytical research and Development Laboratory</option>
                                        <option value="Packaging Development">Packaging Development</option>
                                        <option value="Purchase Department">Purchase Department</option>
                                        <option value="Document Cell">Document Cell</option>
                                        <option value="Regulatory Affairs">Regulatory Affairs</option>
                                        <option value="Pharmacovigilance">Pharmacovigilance</option>
                                </select>
                            </div>
                        
                        </div>             
                        <br>
                        <button type="submit">Submit</button>
                    </form>
                </div>
            </div>

            <div id="DeparmentWiseModal" class="modal123" style="display: none;">
                <div class="modal-content123">
                    <span class="close">&times;</span>
                    <form method="post" id="DeparmentWiseModal" action="{{ url('department-wise-post') }}">
                        @csrf <!-- Include CSRF token for form security -->
                        <div class="pm-certificate-logos ">
                            <img style="scale: 0.7; margin-left: -35px;" src="{{ asset('user/images/connexo.png') }}" alt="connexo Logo" class="logo">
                            <p class="text-center" style="flex-grow: 1; font-size: 24px; font-weight: bold; white-space: nowrap; margin-right: 48px;">Job Role Training History</p>
                            {{-- <img style="scale: 1.7" src="{{ asset('user/images/symbiotec_pharmalab_pvt_ltd__logo.jpg') }}" alt="Vidhya GxP Logo" class="logo"> --}}
                        </div>
                        <br>
                        <br>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="site_division_1">Site/Location</label>
                                <select name="site_division_1" id="site_division_1" class="form-control custom-select" required>
                                    <option value="">Select Location</option>
                                    <option value="P1(Indore Location)">P1 (Indore Location)</option>
                                    <option value="P2(Pithampur Location)">P2 (Pithampur Location)</option>
                                    <option value="P4(Ujjain Site)">P4 (Ujjain Site)</option>
                                    <option value="C1(China Plant)">C1 (China Plant)</option>
                                </select>
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label for="site_division_2">Department</label>
                                <select name="site_division_2" id="site_division_2" class="form-control custom-select" required>
                                        <option value="NA">Select Department</option>
                                        <option value="CQA">Corporate Quality Assurance</option>
                                        <option value="QA">Quality Assurance</option>
                                        <option value="QC">Quality Control</option>
                                        <option value="QM">Quality Control (Microbiology department)</option>
                                        <option value="PG">Production General</option>
                                        <option value="PL">Production Liquid Orals</option>
                                        <option value="PT">Production Tablet and Powder</option>
                                        <option value="PE">Production External (Ointment, Gels, Creams and Liquid)</option>
                                        <option value="PC">Production Capsules</option>
                                        <option value="PI">Production Injectable</option>
                                        <option value="EN">Engineering</option>
                                        <option value="HR">Human Resource</option>
                                        <option value="ST">Store</option>
                                        <option value="IT">Electronic Data Processing</option>
                                        <option value="FD">Formulation Development</option>
                                        <option value="AL">Analytical research and Development Laboratory</option>
                                        <option value="PD">Packaging Development</option>
                                        <option value="PU">Purchase Department</option>
                                        <option value="DC">Document Cell</option>
                                        <option value="RA">Regulatory Affairs</option>
                                        <option value="PV">Pharmacovigilance</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <div class="group-input">
                                    <label for="Group Name">Job Title</label>
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
                                    </select>                                    
                                </div>
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
                        
                            <div class="form-group col-md-4">
                                <label for="site_division_3">Year</label>
                                <select name="site_division_3" id="site_division_3" class="form-control custom-select">
                                    <option value="">Select Year</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>
                                    <option value="2028">2028</option>
                                    <option value="2029">2029</option>
                                    <option value="2030">2030</option>
                                    <option value="2032">2031</option>
                                </select>
                            </div>
                        </div>             
                        <br>
                        <button type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
    document.getElementById('employee-training-history').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('employeeModal').style.display = 'block';
});

// Close the modal when the user clicks on the close button
document.querySelector('.close').addEventListener('click', function() {
    document.getElementById('employeeModal').style.display = 'none';
});
</script>

<script>
    document.getElementById('sop-training-history').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('SOPModal').style.display = 'block';
});

// Close the modal when the user clicks on the close button
document.querySelector('.close').addEventListener('click', function() {
    document.getElementById('SOPModal').style.display = 'none';
});
</script>

<script>
    // Open the modal when clicking the element with id 'yearly-training'
    document.getElementById('yearly-training').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default link behavior
        document.getElementById('yearlyModal').style.display = 'block'; // Show modal
    });

    // Close the modal when the user clicks on the <span> (x) element
    document.querySelector('.close').addEventListener('click', function() {
        document.getElementById('yearlyModal').style.display = 'none'; // Hide modal
    });

    // Close the modal if the user clicks anywhere outside of the modal content
    window.addEventListener('click', function(event) {
        if (event.target === document.getElementById('yearlyModal')) {
            document.getElementById('yearlyModal').style.display = 'none'; // Hide modal if clicked outside
        }
    });
</script>
<script>
    // Open the modal when clicking the element with id 'yearly-training'
    document.getElementById('designation_training').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default link behavior
        document.getElementById('designation_training_Modal').style.display = 'block'; // Show modal
    });

    // Close the modal when the user clicks on the <span> (x) element
    document.querySelector('.close').addEventListener('click', function() {
        document.getElementById('designation_training_Modal').style.display = 'none'; // Hide modal
    });

    // Close the modal if the user clicks anywhere outside of the modal content
    window.addEventListener('click', function(event) {
        if (event.target === document.getElementById('designation_training_Modal')) {
            document.getElementById('designation_training_Modal').style.display = 'none'; // Hide modal if clicked outside
        }
    });
</script>
<script>
    // Open the modal when clicking the element with id 'yearly-training'
    document.getElementById('jobrole_training').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default link behavior
        document.getElementById('jobrole_training_Modal').style.display = 'block'; // Show modal
    });

    // Close the modal when the user clicks on the <span> (x) element
    document.querySelector('.close').addEventListener('click', function() {
        document.getElementById('jobrole_training_Modal').style.display = 'none'; // Hide modal
    });

    // Close the modal if the user clicks anywhere outside of the modal content
    window.addEventListener('click', function(event) {
        if (event.target === document.getElementById('jobrole_training_Modal')) {
            document.getElementById('jobrole_training_Modal').style.display = 'none'; // Hide modal if clicked outside
        }
    });
</script>

<script>
    // Open the modal when clicking the element with id 'yearly-training'
    document.getElementById('list-of-qualified-trainers').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default link behavior
        document.getElementById('ListModal').style.display = 'block'; // Show modal
    });

    // Close the modal when the user clicks on the <span> (x) element
    document.querySelector('.close').addEventListener('click', function() {
        document.getElementById('ListModal').style.display = 'none'; // Hide modal
    });

    // Close the modal if the user clicks anywhere outside of the modal content
    window.addEventListener('click', function(event) {
        if (event.target === document.getElementById('ListModal')) {
            document.getElementById('ListModal').style.display = 'none'; // Hide modal if clicked outside
        }
    });
</script>

<script>
    // Open the modal when clicking the element with id 'yearly-training'
    document.getElementById('department_wise_report').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default link behavior
        document.getElementById('DeparmentWiseModal').style.display = 'block'; // Show modal
    });

    // Close the modal when the user clicks on the <span> (x) element
    document.querySelector('.close').addEventListener('click', function() {
        document.getElementById('DeparmentWiseModal').style.display = 'none'; // Hide modal
    });

    // Close the modal if the user clicks anywhere outside of the modal content
    window.addEventListener('click', function(event) {
        if (event.target === document.getElementById('DeparmentWiseModal')) {
            document.getElementById('DeparmentWiseModal').style.display = 'none'; // Hide modal if clicked outside
        }
    });
</script>
