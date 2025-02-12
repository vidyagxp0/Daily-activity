@extends('frontend.layout.main')
@section('container')
    @php
        $users = DB::table('users')
            ->select('id', 'name')
            ->get();

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

    <!-- --- --------adding scroll css -->
<style>
    /* Wrapper for horizontal scrolling */
    .cctab-wrapper {
        overflow-x: auto;
        white-space: nowrap;
        display: flex;
        width: 100%;
        border-bottom: 1px solid #ccc;
        scrollbar-width: thin; /* For modern browsers */
        scrollbar-color: #007bff #f1f1f1; /* Thumb color and track color */
    }

    /* Custom scrollbar for webkit browsers */
    .cctab-wrapper::-webkit-scrollbar {
        height: 8px; /* Scrollbar height */
    }

    .cctab-wrapper::-webkit-scrollbar-track {
        background: #f1f1f1; /* Scrollbar track color */
    }

    .cctab-wrapper::-webkit-scrollbar-thumb {
        background-color: #007bff; /* Scrollbar thumb color */
        border-radius: 5px; /* Rounded corners for the thumb */
    }

    /* Tabs container */
    .cctab {
        display: inline-flex;
        gap: 5px; /* Space between tabs */
        width: max-content; /* Allows horizontal scrolling if tabs overflow */
        flex-shrink: 0; /* Prevent tabs from shrinking */
    }

    /* Individual tab button styles */
    .cctablinks {
        display: inline-block;
        padding: 10px 15px;
        border: none;
        background-color: #f1f1f1;
        color: #333;
        cursor: pointer;
        text-align: center;
        white-space: nowrap;
        flex-shrink: 0;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .cctablinks:hover {
        background-color: #ddd;
    }

    .cctablinks.active {
        background-color: #007bff;
        color: #fff;
    }
</style>
<!-- --- ------------------ -->
    
    
    <div class="form-field-head">

        <div class="division-bar">
            <strong>Site Division/Project</strong> :
            {{ Helpers::getDivisionName(session()->get('division')) }} / EHS & Environment Sustainability
        </div>
    </div>



    {{-- ======================================
                    DATA FIELDS
    ======================================= --}}




    <div id="change-control-fields">
        <div class="container-fluid">

            <!-- Tab links -->
            <div class="cctab-wrapper">
            <div class="cctab">
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">EHS Event</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Detailed Information</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Damage Information</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Investigation Summary</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Root Cause And Risk Analysis</button>

                <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Employee and Personnel Information</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm7')">Regulatory Compliance Data</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm8')">Incident and Accident Reporting</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm9')">Chemical and Hazardous Materials Management</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm10')">Workplace Safety and Environment Monitoring</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm11')">Health and Occupational Safety</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm12')">Emergency Preparedness and Response</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm13')">Waste Management</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm14')">Training and Awareness</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm15')">Environmental Impact Data</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm16')">Energy Consumption</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm17')">Carbon Emissions (Greenhouse Gases)</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm18')">Water Usage</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm19')">Sustainable Procurement</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm20')">Transportation and Logistics</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm21')">Biodiversity and Land Use</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm22')">Environmental Certifications & Compliance</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm23')">Environmental Impact and Risk Assessment</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm24')">Risk Management and Hazard Identification</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm25')">Audit and Inspection Records</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm26')">Sustainability and Corporate Social Responsibility (CSR)</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm27')">Analytics and Reporting</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm28')">Sustainability Goals and Metrics</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm29')">Employee Engagement and Education</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm30')">Community Engagement and Social Responsibility</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm31')">Activity Log</button>
            </div>
    </div>

            <form id="auditform" action="{{ route('ehs_event_store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div id="step-form">

                    <!-- General information content -->
                    <div id="CCForm1" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="sub-head">
                                General Information
                            </div>
                            <div class="row">

                                @if (!empty($parent_id))
                                    <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                                    <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                                @endif
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>Record Number</b></label>
                                        <input readonly type="text" name="record_number"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}/EE/{{ date('Y') }}/{{ $record_number }}">
                                        </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Site/Location Code</b></label>
                                        <input readonly type="text" name="division_code"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                        <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                   </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator"><b>Initiator</b></label>
                                        <input readonly type="text" value="{{ Auth::user()->name }}">

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input ">
                                        <label for="Date Due"><b>Date of Initiation</b></label>
                                        <input readonly type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                        <input type="hidden" value="{{ date('d-m-Y') }}" name="intiation_date">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            Assigned To <span class="text-danger"></span>
                                        </label>
                                        <select id="assign_to" placeholder="Select..." name="assign_to">
                                            <option value="">Select a value</option>
                                            @foreach ($users as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('assign_to')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Date Due">Due Date<span
                                            class="text-danger">*</span></label>                                        
                                        <div class="calenderauditee">
                                            <input type="text" id="due_date" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'due_date')"  required/>
                                        </div>
                                    </div>
                                </div>

                               
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span
                                                class="text-danger">*</span></label><span id="rchars">255</span>
                                        characters remaining
                                        <div class="relative-container">                                                    
                                            <input id="docname" type="text" name="short_description" maxlength="255" required>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                    </div>
                                </div>  
                                <div class="sub-head">
                                    EHS Event Details
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Type">Type</label>
                                        <div><small class="text-primary">Event Type</small></div>
                                        <select name="Type" id="Type">
                                            <option value="">-- Select --</option>
                                            <option value="Accident">Accident</option>
                                            <option value="General Event">General Event</option>
                                            <option value="Incident">Incident</option>
                                            <option value="Near Miss">Near Miss</option>
                                            <option value="Self Assessment">Self Assessment</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Incident Sub Type">Incident Sub Type</label>
                                        <select name="Incident_Sub_Type" id="Incident_Sub_Type">
                                            <option value="">-- Select --</option>
                                            <option value="Accident">Accident</option>
                                            <option value="Car Accident">Car Accident</option>
                                            <option value="Injury">Injury</option>
                                            <option value="Barricade of Roads/Safety Means">Barricade of Roads/Safety Means</option>
                                            <option value="Break In">Break In</option>
                                            <option value="Cuts/Stabs/Brushes">Cuts/Stabs/Brushes</option>
                                            <option value="Electricity">Electricity</option>
                                            <option value="Falling/Launched Parts">Falling/Launched Parts</option>
                                            <option value="Falling/Stumbling/Working On Height">Falling/Stumbling/Working On Height</option>
                                            <option value="Fire Prevention Equipment/Fire">Fire Prevention Equipment/Fire</option>
                                            <option value="Hazardous Substances">Hazardous Substances</option>
                                            <option value="Hot Substances/Parts">Hot Substances/Parts</option>
                                            <option value="Housekeeping">Housekeeping</option>
                                            <option value="Inappropriate Behaviour">Inappropriate Behaviour</option>
                                            <option value="Lifting/Hoisting">Lifting/Hoisting</option>
                                            <option value="Lock Out/Tag Out/Safeguarding">Lock Out/Tag Out/Safeguarding</option>
                                            <option value="Maintenance/Inspection">Maintenance/Inspection</option>
                                            <option value="Physical Overload">Physical Overload</option>
                                            <option value="Property Damage">Property Damage</option>
                                            <option value="Rotating Parts">Rotating Parts</option>
                                            <option value="Spills">Spills</option>
                                            <option value="Stolen Property">Stolen Property</option>
                                            <option value="Stucks">Stucks</option>
                                            <option value="Technical Failure">Technical Failure</option>
                                            <option value="Training">Training</option>
                                            <option value="Transport Equipment">Transport Equipment</option>
                                            <option value="Vandalism">Vandalism</option>
                                            <option value="Work Permits/TRA/LRMA">Work Permits/TRA/LRMA</option>
                                            <option value="Work-related Illness">Work-related Illness</option>
                                            <option value="Other Environmental">Other Environmental</option>
                                            <option value="Other">Other</option>

                                        </select>
                                    </div>
                                </div>

                                <div><small class="text-primary">Event Date And time</small></div>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Date Occurred">Date Occurred</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="Date_Occurred" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" id="Date_Occurred_checkdate" name="Date_Occurred" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"  class="hide-input"
                                                oninput="handleDateInput(this, 'Date_Occurred');checkDate('Date_Occurred_checkdate','end_date_checkdate')" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Time Occurred">Time Occurred</label>
                                        <input type="time" name="Time_Occurred">
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Attached File">Attached File</label>
                                        <div><small class="text-primary">Please Attach all relevant or Attached File</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Attached_File"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="Attached_File[]"
                                                    oninput="addMultipleFiles(this, 'Attached_File')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Similar Incidents">Similar Incidents</label>
                                        <select name="Similar_Incidents" id="Similar_Incidents">
                                            <option value="">-- Select --</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                            <option value="Na">Na</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Date Of Reporting">Date Of Reporting</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="Date_Of_Reporting" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" id="Date_Of_Reporting_checkdate" name="Date_Of_Reporting" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"  class="hide-input"
                                                oninput="handleDateInput(this, 'Date_Of_Reporting');checkDate('Date_Of_Reporting_checkdate','end_date_checkdate')" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="Reporter">Reporter<span class="text-danger"></span>
                                        </label>
                                        <select id="Reporter" placeholder="Select..." name="Reporter">
                                            <option value="">Select a value</option>
                                            @foreach ($users as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('Reporter')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>                         
                               
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">Description</label>
                                        <div class="relative-container">                                                    
                                            <textarea name="Description" id="Description"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Immediate Actions">Immediate Actions</label>
                                        <div class="relative-container">                                                    
                                            <textarea name="Immediate_Actions" id="Immediate_Actions"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                                <button type="button" id="ChangeNextButton" class="nextButton">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <!-- Audit Planning content -->
                    <div id="CCForm2" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row"> 
                                
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Accident Type">Accident Type</label>
                                        <select name="Accident_Type" id="Accident_Type">
                                            <option value="">-- Select --</option>
                                            <option value="Fatality">Fatality</option>
                                            <option value="First Aid">First Aid</option>
                                            <option value="Lost Time Injury">Lost Time Injury</option>
                                            <option value="Medical Treatment">Medical Treatment</option>
                                            <option value="Restricted Work">Restricted Work</option>
                                            <option value="Other">Other</option>
                                            <option value="Na">Na</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="OSHA Reportable">OSHA Reportable</label>
                                        <select name="OSHA_Reportable" id="OSHA_Reportable">
                                            <option value="">-- Select --</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                            <option value="Na">Na</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="First Lost Work Date">First Lost Work Date</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="First_Lost_Work_Date" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" id="First_Lost_Work_Date_checkdate" name="First_Lost_Work_Date" class="hide-input"
                                                oninput="handleDateInput(this, 'First_Lost_Work_Date');checkDate('First_Lost_Work_Date_checkdate','Last_Lost_Work_Date_checkdate')" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Last Lost Work Date">Last Lost Work Date</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="Last_Lost_Work_Date" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" id="Last_Lost_Work_Date_checkdate" name="Last_Lost_Work_Date" class="hide-input" 
                                                oninput="handleDateInput(this, 'Last_Lost_Work_Date');checkDate('First_Lost_Work_Date_checkdate','Last_Lost_Work_Date_checkdate')" />
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="First Restricted Work Date">First Restricted Work Date</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="First_Restricted_Work_Date" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" id="First_Restricted_Work_Date_checkdate" name="First_Restricted_Work_Date" class="hide-input"
                                                oninput="handleDateInput(this, 'First_Restricted_Work_Date');checkDate('First_Restricted_Work_Date_checkdate','Last_Restricted_Work_Date_checkdate')" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Last Restricted Work Date">Last Restricted Work Date</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="Last_Restricted_Work_Date" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" id="Last_Restricted_Work_Date_checkdate" name="Last_Restricted_Work_Date" class="hide-input" 
                                                oninput="handleDateInput(this, 'Last_Restricted_Work_Date');checkDate('First_Restricted_Work_Date_checkdate','Last_Restricted_Work_Date_checkdate')" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Vehicle Type">Vehicle Type</label>
                                        <select name="Vehicle_Type" id="Vehicle_Type">
                                            <option value="">-- Select --</option>
                                            <option value="Alfa Romeo">Alfa Romeo</option>
                                            <option value="Asquith">Asquith</option>
                                            <option value="Audi">Audi</option>
                                            <option value="Aston Martin">Aston Martin</option>
                                            <option value="Bentley">Bentley</option>
                                            <option value="BMW">BMW</option>
                                            <option value="British Leyland">British Leyland</option>
                                            <option value="Buick">Buick</option>
                                            <option value="Cadillac">Cadillac</option>
                                            <option value="Chevrolet">Chevrolet</option>
                                            <option value="Chrysler">Chrysler</option>
                                            <option value="Citroën">Citroën</option>
                                            <option value="Daewoo">Daewoo</option>
                                            <option value="Daf">Daf</option>
                                            <option value="Daihatsu">Daihatsu</option>
                                            <option value="Daimler">Daimler</option>
                                            <option value="Dodge">Dodge</option>
                                            <option value="Ferrari">Ferrari</option>
                                            <option value="Fiat">Fiat</option>
                                            <option value="Ford">Ford</option>
                                            <option value="Genesis">Genesis</option>
                                            <option value="GMC">GMC</option>
                                            <option value="Honda">Honda</option>
                                            <option value="Hummer">Hummer</option>
                                            <option value="Hyundai">Hyundai</option>
                                            <option value="Infiniti">Infiniti</option>
                                            <option value="Isuzu">Isuzu</option>
                                            <option value="Jaguar">Jaguar</option>
                                            <option value="Jeep">Jeep</option>
                                            <option value="Kia">Kia</option>
                                            <option value="Koenigsegg">Koenigsegg</option>
                                            <option value="Lamborghini">Lamborghini</option>
                                            <option value="Land Rover">Land Rover</option>
                                            <option value="Lexus">Lexus</option>
                                            <option value="Lincoln">Lincoln</option>
                                            <option value="Lotus">Lotus</option>
                                            <option value="Maserati">Maserati</option>
                                            <option value="Mazda">Mazda</option>
                                            <option value="McLaren">McLaren</option>
                                            <option value="Mercedes-Benz">Mercedes-Benz</option>
                                            <option value="Mini">Mini</option>
                                            <option value="Mitsubishi">Mitsubishi</option>
                                            <option value="Nissan">Nissan</option>
                                            <option value="Pagani">Pagani</option>
                                            <option value="Peugeot">Peugeot</option>
                                            <option value="Porsche">Porsche</option>
                                            <option value="Ram">Ram</option>
                                            <option value="Renault">Renault</option>
                                            <option value="Rolls-Royce">Rolls-Royce</option>
                                            <option value="Saab">Saab</option>
                                            <option value="Scion">Scion</option>
                                            <option value="Seat">Seat</option>
                                            <option value="Škoda">Škoda</option>
                                            <option value="Smart">Smart</option>
                                            <option value="Subaru">Subaru</option>
                                            <option value="Suzuki">Suzuki</option>
                                            <option value="Tata">Tata</option>
                                            <option value="Tesla">Tesla</option>
                                            <option value="Toyota">Toyota</option>
                                            <option value="Volkswagen">Volkswagen</option>
                                            <option value="Volvo">Volvo</option>
                                            <option value="Zenvo">Zenvo</option>
                                            <option value="Bugatti">Bugatti</option>
                                            <option value="BYD">BYD</option>
                                            <option value="Changan">Changan</option>
                                            <option value="Geely">Geely</option>
                                            <option value="Great Wall">Great Wall</option>
                                            <option value="Mahindra">Mahindra</option>
                                            <option value="Maruti Suzuki">Maruti Suzuki</option>
                                            <option value="Proton">Proton</option>
                                            <option value="Rivian">Rivian</option>
                                            <option value="SsangYong">SsangYong</option>
                                            <option value="Troller">Troller</option>
                                            <option value="Vauxhall">Vauxhall</option>
                                            <option value="Opel">Opel</option>
                                            <option value="Fisker">Fisker</option>
                                            <option value="Lucid">Lucid</option>
                                            <option value="Polestar">Polestar</option>
                                            <option value="SRT">SRT</option>
                                            <option value="Spyker">Spyker</option>
                                            <option value="Rover">Rover</option>
                                            <option value="Aixam">Aixam</option>
                                            <option value="Baojun">Baojun</option>
                                            <option value="Chery">Chery</option>
                                            <option value="Haval">Haval</option>
                                            <option value="MG">MG</option>
                                            <option value="Perodua">Perodua</option>
                                            <option value="Prodrive">Prodrive</option>
                                            <option value="Wiesmann">Wiesmann</option>
                                            <option value="Holden">Holden</option>
                                            <option value="Pontiac">Pontiac</option>
                                            <option value="Saturn">Saturn</option>
                                            <option value="Zotye">Zotye</option>
                                            <option value="Other">Other</option>                                            
                                        </select>
                                    </div>
                                </div>
                                                                
                               
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Vehicle Number">Vehicle Number</label>
                                        <input type="text" name="Vehicle_Number">
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Litigation">Litigation</label>
                                        <select name="Litigation" id="Litigation">
                                            <option value="">-- Select --</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                            <option value="Na">Na</option>
                                        </select>
                                    </div>
                                </div>  
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Department">Department</label>
                                        <select name="Department" id="Department">
                                            <option value="">-- Select --</option>
                                            <option value="Calibration Lab">Calibration Lab</option>
                                            <option value="Engineering">Engineering</option>
                                            <option value="Facilities">Facilities</option>
                                            <option value="Lab">Lab</option>
                                            <option value="Labeling">Labeling</option>
                                            <option value="Manufacturing">Manufacturing</option>
                                            <option value="Quality Assurance">Quality Assurance</option>
                                            <option value="Quality Control">Quality Control</option>
                                            <option value="Regulatory Affairs">Regulatory Affairs</option>
                                            <option value="Security">Security</option>
                                            <option value="Training">Training</option>
                                            <option value="IT">IT</option>
                                            <option value="Application Engineering">Application Engineering</option>
                                            <option value="Trading">Trading</option>
                                            <option value="Research">Research</option>
                                            <option value="Sales">Sales</option>
                                            <option value="Finance">Finance</option>
                                            <option value="Systems">Systems</option>
                                            <option value="Administrative">Administrative</option>
                                            <option value="M&A">M&A</option>
                                            <option value="R&D">R&D</option>
                                            <option value="Human Resources">Human Resources</option>
                                            <option value="Banking">Banking</option>
                                            <option value="Marketing">Marketing</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="sub-head">
                                    Involved Persons
                                </div>
                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="Employees Involved">Employees Involved<span class="text-danger"></span>
                                        </label>
                                        <select id="Employees_Involved" placeholder="Select..." name="Employees_Involved">
                                            <option value="">Select a value</option>
                                            @foreach ($users as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('Employees_Involved')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="Involved Contractors">Involved Contractors<span class="text-danger"></span>
                                        </label>
                                        <select id="Involved_Contractors" placeholder="Select..." name="Involved_Contractors">
                                            <option value="">Select a value</option>
                                            @foreach ($users as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('Involved_Contractors')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="Attorneys Involved">Attorneys Involved<span class="text-danger"></span>
                                        </label>
                                        <select id="Attorneys_Involved" placeholder="Select..." name="Attorneys_Involved">
                                            <option value="">Select a value</option>
                                            @foreach ($users as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('Attorneys_Involved')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="group-input" >
                                        <label for="root_cause">
                                            Witnesses Information
                                            <button type="button" name="audit-incident-grid" id="Witnesses_Information_Add">+</button>
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#observation-field-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>

                                        <table class="table table-bordered" id="Witnesses_Information_Add_field_table">
                                            <thead>
                                                <tr>
                                                    <th>Row#</th>
                                                    <th>Witness Name</th>                                                    
                                                    <th>Witness Type</th>                                                   
                                                    <th>Item Description</th>                                                    
                                                    <th>Comment</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $serialNumber = 1;
                                                @endphp
                                                <tr>
                                                    <td disabled>{{ $serialNumber++ }}</td>
                                                    <td><input type="text" name="WitnessesInformation[0][Witness_Name]"></td>
                                                    <td><input type="text" name="WitnessesInformation[0][Witness_Type]"></td>
                                                    <td><input type="text" name="WitnessesInformation[0][Item_Description]">
                                                    </td>
                                                    <td><input type="text" name="WitnessesInformation[0][Comment]"></td>
                                                    <td><button class="removeRowBtn">Remove</button>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>

                                <script>
                                    $(document).ready(function() {
                                        let investdetails = 1;
                                        $('#Witnesses_Information_Add').click(function(e) {
                                            function generateTableRow(serialNumber) {
                                                var html =
                                                    '<tr>' +
                                                    '<td><input disabled type="text" style ="width:15px" value="' + serialNumber +
                                                    '"></td>' +
                                                    '<td><input type="text" name="WitnessesInformation[' + investdetails +
                                                    '][Witness_Name]" value=""></td>' +
                                                    '<td><input type="text" name="WitnessesInformation[' + investdetails +
                                                    '][Witness_Type]" value=""></td>' +
                                                    '<td><input type="text" name="WitnessesInformation[' + investdetails +
                                                    '][Item_Description]" value=""></td>' +
                                                    '<td><input type="text" name="WitnessesInformation[' + investdetails +
                                                    '][Comment]" value=""></td>' +
                                                    '<td><button class="removeRowBtn">Remove</button>' +
                                                    '</tr>';
                                                investdetails++; // Increment the row number here
                                                return html;
                                            }

                                            var tableBody = $('#Witnesses_Information_Add_field_table tbody');
                                            var rowCount = tableBody.children('tr').length;
                                            var newRow = generateTableRow(rowCount + 1);
                                            tableBody.append(newRow);
                                        });
                                        $(document).on('click', '.removeRowBtn', function() {
                                            $(this).closest('tr').remove();
                                        });
                                    });
                                </script>
                               

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="Lead Investigator">Lead Investigator</label>
                                        <select id="Lead_Investigator" placeholder="Select..." name="Lead_Investigator">
                                            <option value="">Select a value</option>
                                            @foreach ($users as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('Lead_Investigator')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div> 
                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="Line Operator">Line Operator</label>
                                        <select id="Line_Operator" placeholder="Select..." name="Line_Operator">
                                            <option value="">Select a value</option>
                                            @foreach ($users as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('Line_Operator')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div> 
                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="Reporter">Reporter</label>
                                        <select id="Reporter2" placeholder="Select..." name="Reporter2">
                                            <option value="">Select a value</option>
                                            @foreach ($users as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('Reporter2')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div> 
                                
                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="Supervisor">Supervisor<span class="text-danger"></span>
                                        </label>
                                        <select id="Supervisor" placeholder="Select..." name="Supervisor">
                                            <option value="">Select a value</option>
                                            @foreach ($users as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('Supervisor')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="sub-head">
                                    Near Miss And Measures
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Unsafe Situation">Unsafe Situation</label>
                                        <select name="Unsafe_Situation" id="Unsafe_Situation">
                                            <option value="">-- Select --</option>
                                            <option value="Accumaulation Material">Accumaulation Material</option>
                                            <option value="Atmospheric Conditions">Atmospheric Conditions</option>
                                            <option value="Bad HouseKeeping">Bad HouseKeeping</option>
                                            <option value="Defective / Inadequate Tools / Equipment">Defective / Inadequate Tools / Equipment</option>
                                            <option value="Fire / Explosion Hazard">Fire / Explosion Hazard</option>
                                            <option value="Floor / Surface Condition">Floor / Surface Condition</option>
                                            <option value="Inadequate Luminosity">Inadequate Luminosity</option>
                                            <option value="Indequate Personal Protection Equipment">Indequate Personal Protection Equipment</option>
                                            <option value="Indequate Signs / Covers">Indequate Signs / Covers</option>
                                            <option value="Indequate Warning Or Detection">Indequate Warning Or Detection</option>
                                            <option value="Limited Space / Access">Limited Space / Access</option>
                                            <option value="Noise">Noise</option>
                                            <option value="Other Unsafe Condition">Other Unsafe Condition</option>
                                            <option value="Radiation Hazard">Radiation Hazard</option>
                                            <option value="Temperature / Humidity Out Of Range">Temperature / Humidity Out Of Range</option>
                                            <option value="Toxic Exposure">Toxic Exposure</option>
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Safeguarding Measure Taken">Safeguarding Measure Taken</label>
                                        <select name="Safeguarding_Measure_Taken" id="Safeguarding_Measure_Taken">
                                            <option value="">-- Select --</option>
                                            <option value="Company Rules">Company Rules</option>
                                            <option value="Design and Modification">Design and Modification</option>
                                            <option value="Emergency Planning">Emergency Planning</option>
                                            <option value="General Promotion">General Promotion</option>
                                            <option value="Incident Analysis">Incident Analysis</option>
                                            <option value="Incident Investigation">Incident Investigation</option>
                                            <option value="Individual Communication">Individual Communication</option>
                                            <option value="Management Training">Management Training</option>
                                            <option value="Occupational Health">Occupational Health</option>
                                            <option value="Personal Protection">Personal Protection</option>
                                            <option value="Planning of Inspections">Planning of Inspections</option>
                                            <option value="Planning of Task Observations">Planning of Task Observations</option>
                                            <option value="Policy">Policy</option>
                                            <option value="Positioning">Positioning</option>
                                            <option value="Procedures and Task Analysis">Procedures and Task Analysis</option>
                                            <option value="Procurement Procedure">Procurement Procedure</option>
                                            <option value="Program Evaluation">Program Evaluation</option>
                                            <option value="Safety Meetings">Safety Meetings</option>
                                            <option value="Safety Out of Work">Safety Out of Work</option>
                                            <option value="Training of Employees">Training of Employees</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="sub-head">
                                    Environmental Information
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Environmental Category">Environmental Category</label>
                                        <select name="Environmental_Category" id="Environmental_Category">
                                            <option value="">-- Select --</option>
                                            <option value="Air">Air</option>
                                            <option value="Dust">Dust</option>
                                            <option value="Noise">Noise</option>
                                            <option value="Smell">Smell</option>
                                            <option value="Soil">Soil</option>
                                            <option value="Water">Water</option>
                                            <option value="N/A">N/A</option>
                                            
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Special Weather Conditions">Special Weather Conditions</label>
                                        <select name="Special_Weather_Conditions" id="Special_Weather_Conditions">
                                            <option value="">-- Select --</option>
                                            <option value="Earthquake">Earthquake</option>
                                            <option value="Fog">Fog</option>
                                            <option value="High Temperature">High Temperature</option>
                                            <option value="Snowfall">Snowfall</option>
                                            <option value="Low Temperature">Low Temperature</option>
                                            <option value="Rain">Rain</option>
                                            <option value="Slippery">Slippery</option>
                                            <option value="Snow">Snow</option>
                                            <option value="Storm">Storm</option>
                                            <option value="Thunder / Lightning">Thunder / Lightning</option>
                                            <option value="Wind">Wind</option>
                                            <option value="N/A">N/A</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Source Of Release Or Spill">Source Of Release Or Spill</label>
                                        <select name="Source_Of_Release_Or_Spill" id="Source_Of_Release_Or_Spill">
                                            <option value="">-- Select --</option>
                                            <option value="Laboratory">Laboratory</option>
                                            <option value="Manufacturing Plant">Manufacturing Plant</option>
                                            <option value="Nuclear Plant">Nuclear Plant</option>
                                            <option value="Oil Tanker">Oil Tanker</option>
                                            <option value="Waste Management">Waste Management</option>                                            
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Cause Of Release Or Spill">Cause Of Release Or Spill</label>
                                        <select name="Cause_Of_Release_Or_Spill" id="Cause_Of_Release_Or_Spill">
                                            <option value="">-- Select --</option>
                                            <option value="Equipment Failure">Equipment Failure</option>
                                            <option value="Carelessness">Carelessness</option>
                                            <option value="Natural Causes">Natural Causes</option>
                                            <option value="Not Known">Not Known</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Threat Caused By Release/Spill">Threat Caused By Release/Spill</label>
                                        <div class="relative-container">                                                    
                                            <input type="text" name="Threat_Caused_By_Release_Spill">
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Environment Evacuation Ordered">Environment Evacuation Ordered</label>
                                        <select name="Environment_Evacuation_Ordered" id="Environment_Evacuation_Ordered">
                                            <option value="">-- Select --</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                            <option value="Na">Na</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Date of Samples Taken">Date of Samples Taken</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="Date_Samples_Taken" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" id="Date_Samples_Taken_checkdate" name="Date_Samples_Taken" class="hide-input"
                                                oninput="handleDateInput(this, 'Date_Samples_Taken');checkDate('Date_Samples_Taken_checkdate','end_date_checkdate')" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Agencys Notified">Agencys Notified</label>
                                        <select name="Agencys_Notified" id="Agencys_Notified">
                                            <option value="">-- Select --</option>
                                            <option value="EPA">EPA</option>
                                            <option value="DEP">DEP</option>
                                            <option value="Hazmat">Hazmat</option>
                                            <option value="ATF">ATF</option>
                                            <option value="FBI">FBI</option>
                                            <option value="National Guard">National Guard</option>
                                            <option value="State Police">State Police</option>
                                            <option value="Local Police">Local Police</option>
                                            
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="root_cause">
                                            Material Released
                                            <button type="button" name="audit-incident-grid" id="Material_Released_Add">+</button>
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#observation-field-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>

                                        <table class="table table-bordered" id="Material_Released_Add_field_table">
                                            <thead>
                                                <tr>
                                                    <th>Row#</th>
                                                    <th>Type Of Materials Released</th>                                                    
                                                    <th>Quantity Of Materials Released</th>                                                   
                                                    <th>Medium Affected By Released</th>                                                    
                                                    <th>Health Risk?</th>
                                                    <th>Action</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $serialNumber = 1;
                                                @endphp
                                                <tr>
                                                    <td disabled>{{ $serialNumber++ }}</td>
                                                    <td><input type="text" name="MaterialReleased[0][Type_Of_Materials_Released]"></td>
                                                    <td><input type="text" name="MaterialReleased[0][Quantity_Of_Materials_Released]"></td>
                                                    <td><input type="text" name="MaterialReleased[0][Medium_Affected_By_Released]">
                                                    </td>
                                                    <td><input type="text" name="MaterialReleased[0][Health_Risk]"></td>
                                                    <td><button class="removeRowBtn">Remove</button>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>

                                <script>
                                    $(document).ready(function() {
                                        let investdetails = 1;
                                        $('#Material_Released_Add').click(function(e) {
                                            function generateTableRow(serialNumber) {
                                                var html =
                                                    '<tr>' +
                                                    '<td><input disabled type="text" style ="width:15px" value="' + serialNumber +
                                                    '"></td>' +
                                                    '<td><input type="text" name="MaterialReleased[' + investdetails +
                                                    '][Type_Of_Materials_Released]" value=""></td>' +
                                                    '<td><input type="text" name="MaterialReleased[' + investdetails +
                                                    '][Quantity_Of_Materials_Released]" value=""></td>' +
                                                    '<td><input type="text" name="MaterialReleased[' + investdetails +
                                                    '][Medium_Affected_By_Released]" value=""></td>' +
                                                    '<td><input type="text" name="MaterialReleased[' + investdetails +
                                                    '][Health_Risk]" value=""></td>' +
                                                    '<td><button class="removeRowBtn">Remove</button>' +
                                                    '</tr>';
                                                investdetails++; // Increment the row number here
                                                return html;
                                            }

                                            var tableBody = $('#Material_Released_Add_field_table tbody');
                                            var rowCount = tableBody.children('tr').length;
                                            var newRow = generateTableRow(rowCount + 1);
                                            tableBody.append(newRow);
                                        });
                                        $(document).on('click', '.removeRowBtn', function() {
                                            $(this).closest('tr').remove();
                                        });
                                    });
                                </script>


                                <div class="sub-head">
                                    Fire Incident
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Fire Category">Fire Category</label>
                                        <select name="Fire_Category" id="Fire_Category">
                                            <option value="">-- Select --</option>
                                            <option value="Explosion">Explosion</option>
                                            <option value="Fermentation">Fermentation</option>
                                            <option value="Flames">Flames</option>
                                            <option value="Smoke">Smoke</option>
                                            <option value="Other">Other</option>
                                            <option value="NA">NA</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Fire Evacuation Ordered ?">Fire Evacuation Ordered ?</label>
                                        <select name="Fire_Evacuation_Ordered" id="Fire_Evacuation_Ordered">
                                            <option value="">-- Select --</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                            <option value="Na">Na</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Combat By">Combat By</label>
                                        <select name="Combat_By" id="Combat_By">
                                            <option value="">-- Select --</option>
                                            <option value="Contractor">Contractor</option>
                                            <option value="Fire Brigade">Fire Brigade</option>
                                            <option value="Own Personnel">Own Personnel</option>
                                            <option value="Other">Other</option>
                                            <option value="NA">NA</option>                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Fire Fighting Equipment Used">Fire Fighting Equipment Used</label>
                                        <div class="relative-container">                                                    
                                            <input type="text" name="Fire_Fighting_Equipment_Used">
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="sub-head">
                                    Event Location
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Zone">Zone</label>
                                        <select name="zone" id="zone">
                                            <option value="">Enter Your Selection Here</option>
                                            <option value="Asia">Asia</option>
                                            <option value="Europe">Europe</option>
                                            <option value="Africa">Africa</option>
                                            <option value="Central America">Central America</option>
                                            <option value="South America">South America</option>
                                            <option value="Oceania">Oceania</option>
                                            <option value="North America">North America</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Country">Country</label>
                                        <select name="country" id="country" class="form-select country" aria-label="Default select example" onchange="loadStates()">
                                            <option value="">Select Country</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="State">State</label>
                                        <select name="state" id="state" class="form-select state" aria-label="Default select example" onchange="loadCities()">
                                            <option value="">Select State</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="City">City</label>
                                        <select name="city" id="city" class="form-select city" aria-label="Default select example">
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

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Site Name">Site Name</label>
                                        <select name="Site_Name" id="Site_Name">
                                            <option value="">-- Select --</option>
                                            <option value="Complex A">Complex A</option>
                                            <option value="Marketing A">Marketing A</option>
                                            <option value="Mountain View">Mountain View</option>
                                            <option value="Ocean View">Ocean View</option>
                                            <option value="Building 1">Building 1</option>
                                            <option value="Building 2">Building 2</option>
                                            <option value="Parkside">Parkside</option>
                                            <option value="Central Plaza">Central Plaza</option>
                                            <option value="Riverside">Riverside</option>
                                            <option value="Sunset Ridge">Sunset Ridge</option>
                                            <option value="Hilltop Site">Hilltop Site</option>
                                            <option value="Seaside Office">Seaside Office</option>
                                            <option value="City Square">City Square</option>
                                            <option value="Tech Park">Tech Park</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Building">Building</label>
                                        <select name="Building" id="Building">
                                            <option value="">-- Select --</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Floor">Floor</label>
                                        <select name="Floor" id="Floor">
                                            <option value="">-- Select --</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Room">Room</label>
                                        <select name="Room" id="Room">
                                            <option value="">-- Select --</option>
                                            <option value="101">101</option>
                                            <option value="102">102</option>
                                            <option value="103">103</option>
                                            <option value="201">201</option>
                                            <option value="202">202</option>
                                            <option value="203">203</option>
                                            <option value="301">301</option>
                                            <option value="302">302</option>
                                            <option value="303">303</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Location">Location</label>
                                        <div class="relative-container">                                                    
                                            <input type="text" name="Location" id="Location">
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <!-- Audit Preparation content -->
                    <div id="CCForm3" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="sub-head">
                                Victim Information
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Victim">Victim</label>
                                        <select name="Victim">
                                            <option value="">-- Select --</option>
                                            @foreach ($users as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Medical Treatment ?(Y/N)">Medical Treatment ?(Y/N)</label>
                                        <select name="Medical_Treatment" id="Medical_Treatment">
                                            <option value="">-- Select --</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                            <option value="Na">Na</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Victim Position">Victim Position</label>
                                        <select name="Victim_Position" id="Victim_Position">
                                            <option value="">-- Select --</option>
                                            <option value="Cleaner">Cleaner</option>
                                            <option value="Driver Internal Transport">Driver Internal Transport</option>
                                            <option value="Employee">Employee</option>
                                            <option value="Executive Manager">Executive Manager</option>
                                            <option value="Loader">Loader</option>
                                            <option value="Machinist">Machinist</option>
                                            <option value="Maintenance Engineer">Maintenance Engineer</option>
                                            <option value="Manager">Manager</option>
                                            <option value="Office Employee">Office Employee</option>
                                            <option value="Office Personnel">Office Personnel</option>
                                            <option value="Production Employee">Production Employee</option>
                                            <option value="Quality Assurance">Quality Assurance</option>
                                            <option value="Quality Inspector">Quality Inspector</option>
                                            <option value="Sorter">Sorter</option>
                                            <option value="Substitute Driver">Substitute Driver</option>
                                            <option value="Technical Personnel">Technical Personnel</option>
                                            <option value="Truck Driver">Truck Driver</option>
                                            <option value="Unloader">Unloader</option>
                                            <option value="Uploader">Uploader</option>
                                            <option value="Warehouse Assistant">Warehouse Assistant</option> 
                                            <option value="Yard Supervisor">Yard Supervisor</option>
                                            <option value="NA">NA</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Victim Relation To Company">Victim Relation To Company</label>
                                        <select name="Victim_Relation_To_Company" id="Victim_Relation_To_Company">
                                            <option value="">-- Select --</option>
                                            <option value="Contractor">Contractor</option>
                                            <option value="Own">Own</option>
                                            <option value="Temporarily Hired">Temporarily Hired</option>
                                            <option value="Third Party">Third Party</option>
                                            <option value="NA">NA</option>                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Hospitalization">Hospitalization</label>
                                        <select name="Hospitalization" id="Hospitalization">
                                            <option value="">-- Select --</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                            <option value="Na">Na</option>
                                        </select>
                                    </div>
                                </div>                                
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Hospital Name">Hospital Name</label>
                                        <div class="relative-container">                                                    
                                            <input type="text" name="Hospital_Name" id="Hospital_Name">
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Date Of Treatment">Date Of Treatment</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="Date_Of_Treatment" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" id="Date_Of_Treatment_checkdate" name="Date_Of_Treatment" class="hide-input"
                                                oninput="handleDateInput(this, 'Date_Of_Treatment');checkDate('Date_Of_Treatment_checkdate','end_date_checkdate')" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Victim Treated By">Victim Treated By</label>
                                        <input type="text" name="Victim_Treated_By" id="Victim_Treated_By">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Medical Treatment Description">Medical Treatment Description</label>
                                        <div class="relative-container">                                                    
                                            <textarea name="Medical_Treatment_Description" id="Medical_Treatment_Description"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                <div class="sub-head">
                                    Physical Damage
                                </div>
                                
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Injury Type">Injury Type</label>
                                        <select name="Injury_Type" id="Injury_Type">
                                            <option value="">-- Select --</option>
                                            <option value="Amputation">Amputation</option>
                                            <option value="Bruise">Bruise</option>
                                            <option value="Burn">Burn</option>
                                            <option value="Contusion">Contusion</option>
                                            <option value="Cut">Cut</option>
                                            <option value="Death">Death</option>
                                            <option value="Dislocation">Dislocation</option>
                                            <option value="Fracture">Fracture</option>
                                            <option value="Hearing Loss">Hearing Loss</option>
                                            <option value="Injury">Injury</option>
                                            <option value="Internal Trauma">Internal Trauma</option>
                                            <option value="Minor Burns">Minor Burns</option>
                                            <option value="Needle Puncture">Needle Puncture</option>
                                            <option value="No Injuries">No Injuries</option>
                                            <option value="Other / Multiple Injuries">Other / Multiple Injuries</option>
                                            <option value="Poisoning">Poisoning</option>
                                            <option value="Respiratory Condition">Respiratory Condition</option>
                                            <option value="Scrape">Scrape</option>
                                            <option value="Seizure">Seizure</option>
                                            <option value="Skin Disorder">Skin Disorder</option>
                                            <option value="Skin Reaction">Skin Reaction</option>
                                            <option value="Sprain">Sprain</option> 
                                            <option value="NA">NA</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Number Of Injuries">Number Of Injuries</label>
                                        <input type="Number" name="Number_Of_Injuries" id="Number_Of_Injuries" min="0">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Type Of Injuries">Type Of Injuries</label>
                                        <select name="Type_Of_Injuries" id="Type_Of_Injuries">
                                            <option value="">-- Select --</option>
                                            <option value="Amputation">Amputation</option>
                                            <option value="Bruise">Bruise</option>
                                            <option value="Burn">Burn</option>
                                            <option value="Contusion">Contusion</option>
                                            <option value="Cut">Cut</option>
                                            <option value="Death">Death</option>
                                            <option value="Dislocation">Dislocation</option>
                                            <option value="Fracture">Fracture</option>
                                            <option value="Hearing Loss">Hearing Loss</option>
                                            <option value="Injury">Injury</option>
                                            <option value="Internal Trauma">Internal Trauma</option>
                                            <option value="Minor Burns">Minor Burns</option>
                                            <option value="Needle Puncture">Needle Puncture</option>
                                            <option value="No Injuries">No Injuries</option>
                                            <option value="Other / Multiple Injuries">Other / Multiple Injuries</option>
                                            <option value="Poisoning">Poisoning</option>
                                            <option value="Respiratory Condition">Respiratory Condition</option>
                                            <option value="Scrape">Scrape</option>
                                            <option value="Seizure">Seizure</option>
                                            <option value="Skin Disorder">Skin Disorder</option>
                                            <option value="Skin Reaction">Skin Reaction</option>
                                            <option value="Sprain">Sprain</option> 
                                            <option value="NA">NA</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Injured Body Parts">Injured Body Parts</label>
                                        <select name="Injured_Body_Parts" id="Injured_Body_Parts">
                                            <option value="">-- Select --</option>
                                            <option value="Neck">Neck</option>
                                            <option value="Ankle">Ankle</option>
                                            <option value="Arm">Arm</option>
                                            <option value="Leg">Leg</option>
                                            <option value="Chest">Chest</option>
                                            <option value="Hand">Hand</option>
                                            <option value="Head">Head</option>
                                            <option value="Knee">Knee</option>
                                            <option value="Wrist">Wrist</option>
                                            <option value="Back">Back</option>
                                            <option value="Skull">Skull</option>
                                            <option value="Shoulder">Shoulder</option>
                                            <option value="Elbow">Elbow</option>
                                            <option value="Foot">Foot</option>
                                            <option value="Finger">Finger</option>
                                            <option value="Other">Other</option>
                                            <option value="NA">NA</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Type Of Illness">Type Of Illness</label>
                                        <select name="Type_Of_Illness" id="Type_Of_Illness">
                                            <option value="">-- Select --</option>
                                            <option value="Hearing Loss">Hearing Loss</option>
                                            <option value="Injury">Injury</option>
                                            <option value="Poisoning">Poisoning</option>
                                            <option value="Respiratory Condition">Respiratory Condition</option>
                                            <option value="Skin Disorder">Skin Disorder</option>
                                            <option value="All Other Illnesses">All Other Illnesses</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Permanent Disability?">Permanent Disability?</label>
                                        <select name="Permanent_Disability" id="Permanent_Disability">
                                            <option value="">-- Select --</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                            <option value="Na">Na</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="sub-head">
                                    Damage Information
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Damage Category">Damage Category</label>
                                        <select name="Damage_Category" id="Damage_Category">
                                            <option value="">-- Select --</option>
                                            <option value="Barrier / Fence">Barrier / Fence</option>
                                            <option value="Building">Building</option>
                                            <option value="Equipment">Equipment</option>
                                            <option value="Pavement">Pavement</option>
                                            <option value="Tools">Tools</option> 
                                            <option value="Vehicle">Vehicle</option>
                                            <option value="Other">Other</option>
                                            <option value="NA">NA</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Related Equipment">Related Equipment</label>
                                        <div class="relative-container">                                                    
                                            <input type="text" name="Related_Equipment" id="Related_Equipment">
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-6">
                                    <div class="group-input">
                                        <label for="Related Equipment">Related Equipment</label>
                                        <select name="Related_Equipment" id="Related_Equipment">
                                            <option value="">-- Select --</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                            <option value="Na">Na</option>
                                        </select>
                                    </div>
                                </div> --}}
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Estimated Amount Of Damage">Estimated Amount Of Damage</label>
                                        <input type="Number" name="Estimated_Amount_Of_Damage" id="Estimated_Amount_Of_Damage" min="0">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Currency">Currency</label>
                                        <select name="Currency" id="Currency">
                                            <option value="">-- Select --</option>
                                            <option value="USD">United States Dollar (USD)</option>
                                            <option value="EUR">Euro (EUR)</option>
                                            <option value="JPY">Japanese Yen (JPY)</option>
                                            <option value="GBP">British Pound Sterling (GBP)</option>
                                            <option value="AUD">Australian Dollar (AUD)</option>
                                            <option value="CAD">Canadian Dollar (CAD)</option>
                                            <option value="CHF">Swiss Franc (CHF)</option>
                                            <option value="CNY">Chinese Yuan (CNY)</option>
                                            <option value="INR">Indian Rupee (INR)</option>
                                            <option value="RUB">Russian Ruble (RUB)</option>
                                            <option value="BRL">Brazilian Real (BRL)</option>
                                            <option value="ZAR">South African Rand (ZAR)</option>
                                            <option value="MXN">Mexican Peso (MXN)</option>
                                            <option value="SGD">Singapore Dollar (SGD)</option>
                                            <option value="HKD">Hong Kong Dollar (HKD)</option>
                                            <option value="NZD">New Zealand Dollar (NZD)</option>
                                            <option value="KRW">South Korean Won (KRW)</option>
                                            <option value="SEK">Swedish Krona (SEK)</option>
                                            <option value="NOK">Norwegian Krone (NOK)</option>
                                            <option value="DKK">Danish Krone (DKK)</option>
                                            <option value="MYR">Malaysian Ringgit (MYR)</option>
                                            <option value="THB">Thai Baht (THB)</option>
                                            <option value="IDR">Indonesian Rupiah (IDR)</option>
                                            <option value="PHP">Philippine Peso (PHP)</option>
                                            <option value="AED">United Arab Emirates Dirham (AED)</option>
                                            <option value="SAR">Saudi Riyal (SAR)</option>
                                            <option value="TRY">Turkish Lira (TRY)</option>
                                            <option value="EGP">Egyptian Pound (EGP)</option>                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Insurance Company Involved?">Insurance Company Involved?</label>
                                        <select name="Insurance_Company_Involved" id="Insurance_Company_Involved">
                                            <option value="">-- Select --</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                            <option value="Na">Na</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Denied By Insurance Company">Denied By Insurance Company</label>
                                        <select name="Denied_By_Insurance_Company" id="Denied_By_Insurance_Company">
                                            <option value="">-- Select --</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                            <option value="Na">Na</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Damage Details">Damage Details</label>
                                        <div class="relative-container">                                                    
                                            <textarea name="Damage_Details" id="Damage_Details"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <!-- Audit Execution content -->
                    <div id="CCForm4" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Actual Amount Of Damage">Actual Amount Of Damage</label>
                                        <input type="Number" name="Actual_Amount_Of_Damage" id="Actual_Amount_Of_Damage" min="0">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Currency">Currency</label>
                                        <select name="Currency2" id="Currency2">
                                            <option value="">-- Select --</option>
                                            <option value="USD">United States Dollar (USD)</option>
                                            <option value="EUR">Euro (EUR)</option>
                                            <option value="JPY">Japanese Yen (JPY)</option>
                                            <option value="GBP">British Pound Sterling (GBP)</option>
                                            <option value="AUD">Australian Dollar (AUD)</option>
                                            <option value="CAD">Canadian Dollar (CAD)</option>
                                            <option value="CHF">Swiss Franc (CHF)</option>
                                            <option value="CNY">Chinese Yuan (CNY)</option>
                                            <option value="INR">Indian Rupee (INR)</option>
                                            <option value="RUB">Russian Ruble (RUB)</option>
                                            <option value="BRL">Brazilian Real (BRL)</option>
                                            <option value="ZAR">South African Rand (ZAR)</option>
                                            <option value="MXN">Mexican Peso (MXN)</option>
                                            <option value="SGD">Singapore Dollar (SGD)</option>
                                            <option value="HKD">Hong Kong Dollar (HKD)</option>
                                            <option value="NZD">New Zealand Dollar (NZD)</option>
                                            <option value="KRW">South Korean Won (KRW)</option>
                                            <option value="SEK">Swedish Krona (SEK)</option>
                                            <option value="NOK">Norwegian Krone (NOK)</option>
                                            <option value="DKK">Danish Krone (DKK)</option>
                                            <option value="MYR">Malaysian Ringgit (MYR)</option>
                                            <option value="THB">Thai Baht (THB)</option>
                                            <option value="IDR">Indonesian Rupiah (IDR)</option>
                                            <option value="PHP">Philippine Peso (PHP)</option>
                                            <option value="AED">United Arab Emirates Dirham (AED)</option>
                                            <option value="SAR">Saudi Riyal (SAR)</option>
                                            <option value="TRY">Turkish Lira (TRY)</option>
                                            <option value="EGP">Egyptian Pound (EGP)</option>                                            
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Investigation Summary">Investigation Summary</label>
                                        <div class="relative-container">                                                    
                                            <textarea name="Investigation_Summary" id="Investigation_Summary"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Conclusion">Conclusion</label>
                                        <div class="relative-container">                                                    
                                            <textarea name="Conclusion" id="Conclusion"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <!-- Audit Response & Closure content -->
                    <div id="CCForm5" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">
                                    Root Cause Analysis
                                </div>
                               
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="root-cause-methodology">Root Cause Methodology</label>
                                        <select name="root_cause_methodology[]" multiple data-search="false"
                                            data-silent-initial-value-set="true" id="root-cause-methodology">
                                            <option value="Why-Why Chart">Why-Why Chart</option>
                                            <option value="Failure Mode and Effect Analysis">Failure Mode and Effect
                                                Analysis</option>
                                            <option value="Fishbone or Ishikawa Diagram">Fishbone or Ishikawa Diagram
                                            </option>
                                            <option value="Is/Is Not Analysis">Is/Is Not Analysis</option>
                                            <option value="Rootcauseothers">Others</option>

                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="col-6">
                                    <div id="rootCause" class="group-input" style="display: none;">
                                        <label for="otherFieldsUser">Other (Root Cause Methodology)</label>
                                        <textarea name="other_root_cause_methodology" id="summernote"></textarea>
                                    </div>
                                </div> --}}

                                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

                                <script>
                                    $(document).ready(function() {
                                        // Function to check the current value of the select and toggle the input field
                                        function toggleOtherField() {
                                            const selectedVals = $('#root-cause-methodology').val();
                                            if (selectedVals && selectedVals.includes('Other_Detail')) {
                                                $('#rootCause').show();
                                            } else {
                                                $('#rootCause').hide();
                                            }
                                        }

                                        // Bind the change event to the select field
                                        $('#root-cause-methodology').change(function() {
                                            toggleOtherField();
                                        });

                                        // Check the current value when the page loads
                                        toggleOtherField();
                                    });
                                </script>

                                <div class="col-12 mb-4" id="fmea-section" style="display:none;">
                                    <div class="group-input">
                                        <label for="agenda">
                                            Failure Mode and Effect Analysis
                                            <button type="button" name="agenda"
                                                onclick="addRootCauseAnalysisRiskAssessment('risk-assessment-risk-management')">+</button>
                                            <span class="text-primary" style="font-size: 0.8rem; font-weight: 400;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" style="width: 200%"
                                                id="risk-assessment-risk-management">
                                                <thead>
                                                    <tr>
                                                        <th colspan="1"style="text-align:center;"> </th>
                                                        <th colspan="2"style="text-align:center;">Risk Identification</th>
                                                        <th colspan="1"style="text-align:center;">Risk Analysis</th>
                                                        <th colspan="4"style="text-align:center;">Risk Evaluation</th>
                                                        <th colspan="1"style="text-align:center;">Risk Control</th>
                                                        <th colspan="6"style="text-align:center;">Risk Evaluation</th>
                                                        <th colspan="2"style="text-align:center;"></th>
                                                    </tr>
                                                
                                                    <tr>
                                                        <th>Row </th>
                                                        <th>Activity</th>
                                                        <th>Possible Risk/Failure (Identified Risk) </th>
                                                        <th>Consequences of Risk/Potential Causes</th>
                                                        <th>Severity (S)</th>
                                                        <th>Probability(P)</th>
                                                        <th>Detection (D)</th>
                                                        <th>Risk Level (RPN)</th>
                                                        <th>Control Measures recommended/ Risk mitigation proposed</th>
                                                            <th>Severity (S)</th>
                                                            <th>Probability(P)</th>
                                                            <th>Detection (D)</th>
                                                        <th>Risk Level (RPN)</th>
                                                        <th>Category of Risk Level (Low, Medium and High)</th>
                                                        <th>Risk Acceptance (Y/N)</th>
                                                        <th>Traceability document </th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12" id="fishbone-section" style="display:none;">
                                    <div class="group-input">
                                        <label for="fishbone">
                                            Fishbone or Ishikawa Diagram
                                            <button type="button" name="agenda"
                                                onclick="addFishBone('.top-field-group', '.bottom-field-group')">+</button>
                                            <button type="button" name="agenda" class="fishbone-del-btn"
                                                onclick="deleteFishBone('.top-field-group', '.bottom-field-group')">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#fishbone-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <div class="fishbone-ishikawa-diagram">
                                            <div class="left-group">
                                                <div class="grid-field field-name">
                                                    <div>Measurement</div>
                                                    <div>Materials</div>
                                                    <div>Methods</div>
                                                </div>
                                                <div class="top-field-group">
                                                    <div class="grid-field fields top-field">
                                                        <div><input type="text" name="measurement[]"></div>
                                                        <div><input type="text" name="materials[]"></div>
                                                        <div><input type="text" name="methods[]"></div>
                                                    </div>
                                                </div>
                                                <div class="mid"></div>
                                                <div class="bottom-field-group">
                                                    <div class="grid-field fields bottom-field">
                                                        <div><input type="text" name="environment[]"></div>
                                                        <div><input type="text" name="manpower[]"></div>
                                                        <div><input type="text" name="machine[]"></div>
                                                    </div>
                                                </div>
                                                <div class="grid-field field-name">
                                                    <div>Mother Environment</div>
                                                    <div>Man</div>
                                                    <div>Machine</div>
                                                </div>
                                            </div>
                                            <div class="right-group">
                                                <div class="field-name">
                                                    Problem Statement
                                                </div>
                                                <div class="field">
                                                    <textarea name="problem_statement"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-12" id="HideInference" style="display:none;">
                                    <div class="group-input">
                                        <label for="Inference">
                                            Inference
                                            <button type="button" onclick="addInference('Inference')">+</button>
                                        </label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="Inference">
                                                <thead>
                                                    <tr>
                                                        <th style="width:5%">Row #</th>
                                                        <th>Type</th>
                                                        <th>Remarks</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- <td><input disabled type="text" name="serial_number[]"
                                                            value="1">
                                                    </td>
                                                    <td><input type="text" name="inference_type[]"></td>

                                                    <td><input type="text" name="inference_remarks[]"></td>
                                                    <td><button type="text" class="removeRowBtn">Remove</button></td> --}}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12" id="why-why-chart-section" style="display:none;">
                                    <div class="group-input">
                                        <label for="why-why-chart">
                                            Why-Why Chart
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#why_chart-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <div class="why-why-chart">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <!-- Problem Statement -->
                                                    <tr style="background: #f4bb22">
                                                        <th style="width:150px;">Problem Statement :</th>
                                                        <td>
                                                            <textarea name="why_problem_statement"></textarea>
                                                        </td>
                                                    </tr>

                                                    <!-- Why 1 -->
                                                    <tr class="why-row">
                                                        <th style="width:150px; color: #393cd4;">
                                                            Why 1
                                                            <span onclick="addWhyField('why_1_block', 'why_1[]')">+</span>
                                                        </th>
                                                        <td>
                                                            <div class="why_1_block">
                                                                <div class="why-field-wrapper">
                                                                    <textarea name="why_1[]"></textarea>
                                                                    <button type="button" class="btn btn-danger btn-sm"
                                                                        onclick="removeWhyField(this)">Remove</button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- Why 2 -->
                                                    <tr class="why-row">
                                                        <th style="width:150px; color: #393cd4;">
                                                            Why 2
                                                            <span onclick="addWhyField('why_2_block', 'why_2[]')">+</span>
                                                        </th>
                                                        <td>
                                                            <div class="why_2_block">
                                                                <div class="why-field-wrapper">
                                                                    <textarea name="why_2[]"></textarea>
                                                                    <button type="button" class="btn btn-danger btn-sm"
                                                                        onclick="removeWhyField(this)">Remove</button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- Why 3 -->
                                                    <tr class="why-row">
                                                        <th style="width:150px; color: #393cd4;">
                                                            Why 3
                                                            <span onclick="addWhyField('why_3_block', 'why_3[]')">+</span>
                                                        </th>
                                                        <td>
                                                            <div class="why_3_block">
                                                                <div class="why-field-wrapper">
                                                                    <textarea name="why_3[]"></textarea>
                                                                    <button type="button" class="btn btn-danger btn-sm"
                                                                        onclick="removeWhyField(this)">Remove</button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- Why 4 -->
                                                    <tr class="why-row">
                                                        <th style="width:150px; color: #393cd4;">
                                                            Why 4
                                                            <span onclick="addWhyField('why_4_block', 'why_4[]')">+</span>
                                                        </th>
                                                        <td>
                                                            <div class="why_4_block">
                                                                <div class="why-field-wrapper">
                                                                    <textarea name="why_4[]"></textarea>
                                                                    <button type="button" class="btn btn-danger btn-sm"
                                                                        onclick="removeWhyField(this)">Remove</button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- Why 5 -->
                                                    <tr class="why-row">
                                                        <th style="width:150px; color: #393cd4;">
                                                            Why 5
                                                            <span onclick="addWhyField('why_5_block', 'why_5[]')">+</span>
                                                        </th>
                                                        <td>
                                                            <div class="why_5_block">
                                                                <div class="why-field-wrapper">
                                                                    <textarea name="why_5[]"></textarea>
                                                                    <button type="button" class="btn btn-danger btn-sm"
                                                                        onclick="removeWhyField(this)">Remove</button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- Root Cause -->
                                                    <tr style="background: #0080006b;">
                                                        <th style="width:150px;">Root Cause :</th>
                                                        <td>
                                                            <textarea name="why_root_cause"></textarea>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- JavaScript to handle dynamic field addition and removal -->
                                <script>
                                    function addWhyField(containerClass, fieldName) {
                                        // Select the container to add the new textarea
                                        let container = document.querySelector('.' + containerClass);

                                        // Create the textarea
                                        let textarea = document.createElement('textarea');
                                        textarea.name = fieldName;

                                        // Create the remove button
                                        let removeButton = document.createElement('button');
                                        removeButton.type = 'button';
                                        removeButton.className = 'btn btn-danger btn-sm';
                                        removeButton.innerText = 'Remove';
                                        removeButton.onclick = function() {
                                            removeWhyField(this);
                                        };

                                        // Create a wrapper for the textarea and the remove button
                                        let fieldWrapper = document.createElement('div');
                                        fieldWrapper.classList.add('why-field-wrapper');
                                        fieldWrapper.style.marginBottom = '10px'; // Optional for better spacing
                                        fieldWrapper.appendChild(textarea);
                                        fieldWrapper.appendChild(removeButton);

                                        // Append the new field wrapper to the container
                                        container.appendChild(fieldWrapper);
                                    }

                                    function removeWhyField(button) {
                                        // Get the wrapper div and remove it
                                        let fieldWrapper = button.parentNode;
                                        fieldWrapper.remove();
                                    }
                                </script>

                                <div class="col-12" id="is-is-not-section" style="display:none;">
                                    <div class="group-input">
                                        <label for="why-why-chart">
                                            Is/Is Not Analysis
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#is_is_not-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <div class="why-why-chart">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>&nbsp;</th>
                                                        <th>Will Be</th>
                                                        <th>Will Not Be</th>
                                                        <th>Rationale</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th style="background: #0039bd85">What</th>
                                                        <td>
                                                            <textarea name="what_will_be"></textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="what_will_not_be"></textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="what_rationable"></textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="background: #0039bd85">Where</th>
                                                        <td>
                                                            <textarea name="where_will_be"></textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="where_will_not_be"></textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="where_rationable"></textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="background: #0039bd85">When</th>
                                                        <td>
                                                            <textarea name="when_will_be"></textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="when_will_not_be"></textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="when_rationable"></textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="background: #0039bd85">Why</th>
                                                        <td>
                                                            <textarea name="coverage_will_be"></textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="coverage_will_not_be"></textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="coverage_rationable"></textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="background: #0039bd85">Who</th>
                                                        <td>
                                                            <textarea name="who_will_be"></textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="who_will_not_be"></textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="who_rationable"></textarea>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                               
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="root_cause">
                                            Root Cause
                                            <button type="button" name="audit-incident-grid" id="Root_Cause_Add">+</button>
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#observation-field-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>

                                        <table class="table table-bordered" id="Root_Cause_Add_field_table">
                                            <thead>
                                                <tr>
                                                    <th>Row#</th>
                                                    <th>Root Cause Category</th>                                                    
                                                    <th>Root Cause Sub Category</th>                                                   
                                                    <th>Probability</th>                                                    
                                                    <th>Comments</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $serialNumber = 1;
                                                @endphp
                                                <tr>
                                                    <td disabled>{{ $serialNumber++ }}</td>
                                                    <td><input type="text" name="RootCause[0][Root_Cause_Category]"></td>
                                                    <td><input type="text" name="RootCause[0][Root_Cause_Sub_Category]"></td>
                                                    <td><input type="text" name="RootCause[0][Probability]"></td>
                                                    <td><input type="text" name="RootCause[0][Comments]"></td>
                                                    <td><button class="removeRowBtn">Remove</button>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>

                                <script>
                                    $(document).ready(function() {
                                        let investdetails = 1;
                                        $('#Root_Cause_Add').click(function(e) {
                                            function generateTableRow(serialNumber) {
                                                var html =
                                                    '<tr>' +
                                                    '<td><input disabled type="text" style ="width:15px" value="' + serialNumber +
                                                    '"></td>' +
                                                    '<td><input type="text" name="RootCause[' + investdetails +
                                                    '][Root_Cause_Category]" value=""></td>' +
                                                    '<td><input type="text" name="RootCause[' + investdetails +
                                                    '][Root_Cause_Sub_Category]" value=""></td>' +
                                                    '<td><input type="text" name="RootCause[' + investdetails +
                                                    '][Probability]" value=""></td>' +
                                                    '<td><input type="text" name="RootCause[' + investdetails +
                                                    '][Comments]" value=""></td>' +
                                                    '<td><button class="removeRowBtn">Remove</button>' +
                                                    '</tr>';
                                                investdetails++; // Increment the row number here
                                                return html;
                                            }

                                            var tableBody = $('#Root_Cause_Add_field_table tbody');
                                            var rowCount = tableBody.children('tr').length;
                                            var newRow = generateTableRow(rowCount + 1);
                                            tableBody.append(newRow);
                                        });
                                        $(document).on('click', '.removeRowBtn', function() {
                                            $(this).closest('tr').remove();
                                        });
                                    });
                                </script>
                                
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Root Cause Description">Root Cause Description</label>
                                        <div class="relative-container">                                                    
                                            <textarea name="Root_Cause_Description"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="sub-head">
                                    Risk Factors
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Safety Impact Probability">Safety Impact Probability</label>
                                        <select name="Safety_Impact_Probability" id="safetyProbability" onchange='calculateRiskAnalysis("safety")'>
                                            <option value="">Enter Your Selection Here</option>
                                            <option value='1'>Low - Almost Improbable (1)</option>
                                            <option value='2'>Medium - Occasional (2)</option>
                                            <option value='3'>High - Frequent (3)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Safety Impact Severity">Safety Impact Severity</label>
                                        <select name="Safety_Impact_Severity" id="safetySeverity" onchange='calculateRiskAnalysis("safety")'>
                                            <option value="">Enter Your Selection Here</option>
                                            <option value='1'>Negligible (1)</option>
                                            <option value='2'>Marginal (2)</option>
                                            <option value='3'>Critical (3)</option>
                                        </select>
                                    </div>
                                </div> 

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Legal Impact Probability">Legal Impact Probability</label>
                                        <select name="Legal_Impact_Probability" id="legalProbability"
                                            onchange='calculateRiskAnalysis("legal")'>
                                            <option value="">Enter Your Selection Here</option>
                                            <option value='1'>Low - Almost Improbable (1)</option>
                                            <option value='2'>Medium - Occasional (2)</option>
                                            <option value='3'>High - Frequent (3)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Legal Impact Severity">Legal Impact Severity</label>
                                        <select name="Legal_Impact_Severity" id="legalSeverity"
                                            onchange='calculateRiskAnalysis("legal")'>
                                            <option value="">Enter Your Selection Here</option>
                                            <option value='1'>Negligible (1)</option>
                                            <option value='2'>Marginal (2)</option>
                                            <option value='3'>Critical (3)</option>
                                        </select>
                                    </div>
                                </div>                                

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Business Impact Probability">Business Impact Probability</label>
                                        <select name="Business_Impact_Probability" id="businessProbability"
                                            onchange='calculateRiskAnalysis("business")'>
                                            <option value="">Enter Your Selection Here</option>
                                            <option value='1'>Low - Almost Improbable (1)</option>
                                            <option value='2'>Medium - Occasional (2)</option>
                                            <option value='3'>High - Frequent (3)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Business Impact Severity">Business Impact Severity</label>
                                        <select name="Business_Impact_Severity" id="businessSeverity"
                                            onchange='calculateRiskAnalysis("business")'>
                                            <option value="">Enter Your Selection Here</option>
                                            <option value='1'>Negligible (1)</option>
                                            <option value='2'>Marginal (2)</option>
                                            <option value='3'>Critical (3)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Revenue Impact Probability">Revenue Impact Probability</label>
                                        <select name="Revenue_Impact_Probability" id="revenueProbability"
                                            onchange='calculateRiskAnalysis("revenue")'>
                                            <option value="">Enter Your Selection Here</option>
                                            <option value='1'>Low - Almost Improbable (1)</option>
                                            <option value='2'>Medium - Occasional (2)</option>
                                            <option value='3'>High - Frequent (3)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Revenue Impact Severity">Revenue Impact Severity</label>
                                        <select name="Revenue_Impact_Severity" id="revenueSeverity"
                                            onchange='calculateRiskAnalysis("revenue")'>
                                            <option value="">Enter Your Selection Here</option>
                                            <option value='1'>Negligible (1)</option>
                                            <option value='2'>Marginal (2)</option>
                                            <option value='3'>Critical (3)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Brand Impact Probability">Brand Impact Probability</label>
                                        <select name="Brand_Impact_Probability" id="brandProbability"
                                            onchange='calculateRiskAnalysis("brand")'>
                                            <option value="">Enter Your Selection Here</option>
                                            <option value='1'>Negligible (1)</option>
                                            <option value='2'>Marginal (2)</option>
                                            <option value='3'>Critical (3)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Brand Impact Severity">Brand Impact Severity</label>
                                        <select name="Brand_Impact_Severity" id="brandSeverity"
                                            onchange='calculateRiskAnalysis("brand")'>
                                            <option value="">Enter Your Selection Here</option>
                                            <option value='1'>Negligible (1)</option>
                                            <option value='2'>Marginal (2)</option>
                                            <option value='3'>Critical (3)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="sub-head">
                                    Calculated Risk And Further Actions
                                </div>
                               
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Safety Impact Risk">Safety Impact Risk</label>                                        
                                        <input type="text" name="Safety_Impact_Risk" id="safetyRisk" value="" readonly>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">                                        
                                        <div><small class="text-success">1: Acceptable - Risk negligible, further Effort not justified; consider product improvement</small></div>                                        
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Legal Impact Risk">Legal Impact Risk</label>
                                        <input type="text" name="Legal_Impact_Risk" id="legalRisk" value=""
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">                                        
                                        <div><small class="text-primary">2: Mostly Acceptable - Risk negligible, further Effort not justified; consider product improvement</small></div>                                        
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Business Impact Risk">Business Impact Risk</label>
                                        <input type="text" name="Business_Impact_Risk" id="businessRisk" value=""
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">                                        
                                        <div><small class="text-info">3-4: Tolerable - Risk can be acceptable, further Effort can be in case of safety issues; consider CAPA</small></div>                                        
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Revenue Impact Risk">Revenue Impact Risk</label>
                                        <input type="text" name="Revenue_Impact_Risk" id="revenueRisk" value=""
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">                                        
                                        <div><small class="text-warning">'6: Mostly Unacceptable - Risk not justified with few exceptions; CAPA will be created</small></div>                                        
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Brand Impact Risk">Brand Impact Risk</label>
                                        <input type="text" name="Brand_Impact_Risk" id="brandRisk" value=""
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">                                        
                                        <div><small class="text-danger">9: Unacceptable - Risk not justified; CAPA will be created</small></div>                                        
                                    </div>
                                </div>

                                <div class="sub-head">
                                    General Risk Information
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Impact">Impact</label>
                                        <select name="Impact" id="Impact">
                                            <option value="">-- Select --</option>
                                            <option value="High">High</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                            <option value="None">None</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Impact Analysis">Impact Analysis</label>
                                        <div class="relative-container">                                                    
                                            <textarea name="Impact_Analysis" id="Impact_Analysis"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Recommended Actions">Recommended Actions</label>
                                        <div class="relative-container">                                                    
                                            <textarea name="Recommended_Actions" id="Recommended_Actions"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Comments">Comments</label>
                                        <div class="relative-container">                                                    
                                            <textarea name="Comments2" id="Comments2"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Direct Cause">Direct Cause</label>
                                        <select name="Direct_Cause" id="Direct_Cause">
                                            <option value="">-- Select --</option>
                                            <option value="Act is Unsafe">Act is Unsafe</option>
                                            <option value="Procedures / Instructions Not Followed">Procedures / Instructions Not Followed</option>
                                            <option value="Incorrect Stacking / Loading">Incorrect Stacking / Loading</option>
                                            <option value="Wrong Positioning">Wrong Positioning</option>
                                            <option value="Incorrect Lifting / Bending">Incorrect Lifting / Bending</option>
                                            <option value="Wrong Posture / Work Position">Wrong Posture / Work Position</option>
                                            <option value="Work On / Near Moving Parts">Work On / Near Moving Parts</option>
                                            <option value="Joking / Distraction">Joking / Distraction</option>
                                            <option value="Use of Alcohol / Drugs">Use of Alcohol / Drugs</option>
                                            <option value="Work Without Permission">Work Without Permission</option>
                                            <option value="No warnings Given">No warnings Given</option>
                                            <option value="Equipment Not Secured / Locked / Safeguarded">Equipment Not Secured / Locked / Safeguarded</option>
                                            <option value="Incorrect Work Pace">Incorrect Work Pace</option> 
                                            <option value="Safety Device Bypassed">Safety Device Bypassed</option>
                                            <option value="Use Of Defective Tools / Equipment">Use Of Defective Tools / Equipment</option>
                                            <option value="Misuse of Tools / Equipment">Misuse of Tools / Equipment</option>
                                            <option value="No / Wrong PPE Usage">No / Wrong PPE Usage</option> 
                                            <option value="Condition is Unsafe">Condition is Unsafe</option>
                                            <option value="Inadequate Signs / Covers">Inadequate Signs / Covers</option>
                                            <option value="Substances in Atmosphere">Substances in Atmosphere</option>
                                            <option value="Radiation Hazard">Radiation Hazard</option>
                                            <option value="Noise">Noise</option>
                                            <option value="Toxic Exposure">Toxic Exposure</option>
                                            <option value="Temperature / Humidity Out of Range">Temperature / Humidity Out of Range</option> 
                                            <option value="Inadequate Luminosity">Inadequate Luminosity</option>
                                            <option value="Inadequate Ventilation">Inadequate Ventilation</option>
                                            <option value="Inadequate Personnel Protection Equipment">Inadequate Personnel Protection Equipment</option>
                                            <option value="Defective / Inadequate Tools / Equipment">Defective / Inadequate Tools / Equipment</option>
                                            <option value="Limited Space / Access">Limited Space / Access</option>
                                            <option value="Accumulation of Material">Accumulation of Material</option> 
                                            <option value="Inadequate Warning Detection">Inadequate Warning Detection</option>
                                            <option value="Fire / Explosion Hazard">Fire / Explosion Hazard</option>
                                            <option value="Bad Housekeeping">Bad Housekeeping</option>
                                            <option value="Floor / Surface Condition">Floor / Surface Condition</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Safeguarding Measure Taken">Safeguarding Measure Taken</label>
                                        <select name="Safeguarding_Measure_Taken2" id="Safeguarding_Measure_Taken2">
                                            <option value="">-- Select --</option>
                                            <option value="Company Rules">Company Rules</option>
                                            <option value="Design And Modification">Design And Modification</option>
                                            <option value="Emergency Planning">Emergency Planning</option>
                                            <option value="General Promotion">General Promotion</option>
                                            <option value="Incident Analysis">Incident Analysis</option>
                                            <option value="Incident Investigation">Incident Investigation</option>
                                            <option value="Individual Communication">Individual Communication</option>
                                            <option value="Management Training">Management Training</option>
                                            <option value="Occupational Health">Occupational Health</option>
                                            <option value="Personal Protection">Personal Protection</option>
                                            <option value="Planning of Inspections">Planning of Inspections</option>
                                            <option value="Planning of Task Observations">Planning of Task Observations</option>
                                            <option value="Policy">Policy</option>
                                            <option value="Positioning">Positioning</option>
                                            <option value="Procedures And Task Analysis">Procedures And Task Analysis</option>
                                            <option value="Procurement Procedure">Procurement Procedure</option>
                                            <option value="Program Evaluation">Program Evaluation</option>
                                            <option value="Safety Meetings">Safety Meetings</option>
                                            <option value="Safety Out of Work">Safety Out of Work</option>
                                            <option value="Training of Employees">Training of Employees</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="sub-head">
                                    Risk Analysis
                                </div>
                                <div class="row">
                                   <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Severity Rate">Severity Rate</label>
                                            <select name="severity_rate" id="analysisR"
                                                onchange='calculateRiskAnalysis2(this)'>
                                                <option value="">Enter Your Selection Here</option>
                                                <option value="1">Negligible</option>
                                                <option value="2">Minor</option>
                                                <option value="3">Moderate</option>
                                                <option value="4">Major</option>
                                                <option value="5">Fatal</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Occurrence">Occurrence</label>
                                            <select name="occurrence" id="analysisP" onchange='calculateRiskAnalysis2(this)'>
                                                <option value="">Enter Your Selection Here</option>
                                                <option value="5">Extremely Unlikely</option>
                                                <option value="4">Rare</option>
                                                <option value="3">Unlikely</option>
                                                <option value="2">Likely</option>
                                                <option value="1">Very Likely</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="Detection">Detection</label>
                                            <select name="detection" id="analysisN" onchange='calculateRiskAnalysis2(this)'>
                                                <option value="">Enter Your Selection Here</option>
                                                <option value="5">Impossible</option>
                                                <option value="4">Rare</option>
                                                <option value="3">Unlikely</option>
                                                <option value="2">Likely</option>
                                                <option value="1">Very Likely</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="group-input">
                                            <label for="RPN">RPN</label>
                                            <div><small class="text-primary">Auto - Calculated</small></div>
                                            <input type="text" name="rpn" id="analysisRPN" value="" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Risk Analysis">Risk Analysis</label>
                                        <div class="relative-container">                                                    
                                            <textarea name="Risk_Analysis" id="Risk_Analysis"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Critically">Critically</label>
                                        <select name="Critically" id="Critically">
                                            <option value="">-- Select --</option>
                                            <option value="High">High</option>
                                            <option value="Medium">Medium</option>
                                            <option value="Low">Low</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Inform Local Authority?">Inform Local Authority?</label>
                                        <select name="Inform_Local_Authority" id="Inform_Local_Authority">
                                            <option value="">-- Select --</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                            <option value="Na">Na</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Authority Type">Authority Type</label>
                                        <select name="Authority_Type" id="Authority_Type">
                                            <option value="">-- Select --</option>
                                            <option value="Life Science">Life Science</option>
                                            <option value="Food Safety">Food Safety</option>
                                            <option value="Health and Safety">Health and Safety</option>
                                            <option value="Financial">Financial</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Authority Notified">Authority Notified</label>
                                        <select name="Authority_Notified" id="Authority_Notified">
                                            <option value="">-- Select --</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                            <option value="Na">Na</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Other Authority">Other Authority</label>
                                        <div class="relative-container">                                                    
                                            <textarea name="Other_Authority" id="Other_Authority"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                
                                
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>
                    <div id="CCForm6" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Employee ID">Employee ID</label>
                                        <input type="Number" name="employee_id" id="employee_id" min="0">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Employee Name">Employee Name</label>
                                        <div class="relative-container">                                                    
                                            <input type="text" name="employee_name" id="employee_name">
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Designation">Designation</label>
                                        <div class="relative-container">                                                    
                                            <input type="text" name="designation" id="designation">
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Department">Department</label>
                                        <select name="department2" id="department2">
                                            <option value="">-- Select --</option>
                                            <option value="Calibration Lab">Calibration Lab</option>
                                            <option value="Engineering">Engineering</option>
                                            <option value="Facilities">Facilities</option>
                                            <option value="Lab">Lab</option>
                                            <option value="Labeling">Labeling</option>
                                            <option value="Manufacturing">Manufacturing</option>
                                            <option value="Quality Assurance">Quality Assurance</option>
                                            <option value="Quality Control">Quality Control</option>
                                            <option value="Regulatory Affairs">Regulatory Affairs</option>
                                            <option value="Security">Security</option>
                                            <option value="Training">Training</option>
                                            <option value="IT">IT</option>
                                            <option value="Application Engineering">Application Engineering</option>
                                            <option value="Trading">Trading</option>
                                            <option value="Research">Research</option>
                                            <option value="Sales">Sales</option>
                                            <option value="Finance">Finance</option>
                                            <option value="Systems">Systems</option>
                                            <option value="Administrative">Administrative</option>
                                            <option value="M&A">M&A</option>
                                            <option value="R&D">R&D</option>
                                            <option value="Human Resources">Human Resources</option>
                                            <option value="Banking">Banking</option>
                                            <option value="Marketing">Marketing</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Phone Number">Phone Number<span class="text-danger"></span></label>
                                        {{-- <div class="relative-container"> --}}
                                        <input type="text" id="phone_number" name="phone_number"
                                            placeholder="Enter employee phone Number" value="">
                                        {{-- @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div> --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Email">Email</label>
                                        {{-- <div class="relative-container"> --}}
                                        <input type="email" id="email" name="email"
                                            placeholder="Enter employee email" >
                                            {{-- @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div> --}}
                                        @if ($errors->has('email'))
                                            <span style="color: red;">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Date of Joining">Date of Joining</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="date_of_joining" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" id="date_of_joining_checkdate" name="date_of_joining" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"  class="hide-input"
                                                oninput="handleDateInput(this, 'date_of_joining');checkDate('date_of_joining_checkdate','date_of_joining1_checkdate')" />
                                        </div>
                                    </div>
                                </div>


                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Safety Training Records">Safety Training Records</label>
                                        <select name="safety_training_records" id="safety_training_records">
                                            <option value="">-- Select --</option>
                                            <option value="Date Of Completion">Date Of Completion</option>
                                            <option value="Trainer Name">Trainer Name</option>
                                            <option value="Course Details">Course Details</option>                                            
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Medical History">Medical History</label>
                                        <select name="medical_history" id="medical_history">
                                            <option value="">-- Select --</option>
                                            <option value="Work Related Illnesses">Work Related Illnesses</option>
                                            <option value="Injuries">Injuries</option>                                            
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Personal Protective Equipment (PPE) Compliance">Personal Protective Equipment (PPE) Compliance</label>
                                        <div class="relative-container">                                                    
                                            <input type="text" name="personal_protective_equipment_compliance" id="personal_protective_equipment_compliance">
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Emergency Contacts">Emergency Contacts</label>
                                        <input type="text" id="emergency_contacts" name="emergency_contacts"
                                            placeholder="Enter Employee Emergency Contacts" value="">
                                    </div>
                                </div>
                               
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <div id="CCForm7" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            
                            <div class="row">
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Compliance Standards/Regulations">Compliance Standards/Regulations</label>
                                        <select name="compliance_standards_regulations" id="compliance_standards_regulations">
                                            <option value="">-- Select --</option>
                                            <option value="ISO 14001">ISO 14001</option>
                                            <option value="ISO 45001">ISO 45001</option>
                                            <option value="Drug and Cosmetics Act">Drug and Cosmetics Act</option>                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Regulatory Authority/Agency ">Regulatory Authority/Agency </label>
                                        <select name="regulatory_authority_agency" id="regulatory_authority_agency">
                                            <option value="">-- Select --</option>
                                            <option value="CPCB">CPCB</option>
                                            <option value="FSSAI">FSSAI</option>
                                            <option value="MoEF">MoEF</option>                                            
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Inspection Dates and Reports">Inspection Dates and Reports</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="inspection_dates_and_reports" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" id="inspection_dates_and_reports_checkdate" name="inspection_dates_and_reports" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"  class="hide-input"
                                                oninput="handleDateInput(this, 'inspection_dates_and_reports');checkDate('inspection_dates_and_reports_checkdate','inspection_dates_and_reports1_checkdate')" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Audit/Inspection Results">Audit/Inspection Results</label>
                                        <select name="audit_inspection_results" id="audit_inspection_results">
                                            <option value="">-- Select --</option>
                                            <option value="Internal Audits">Internal Audits</option>
                                            <option value="External Audits">External Audits</option>                      
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Non-compliance Issues">Non-compliance Issues</label>
                                        <select name="non_compliance_issues" id="non_compliance_issues">
                                            <option value="">-- Select --</option>
                                            <option value="Date">Date</option>
                                            <option value="Description">Description</option>
                                            <option value="Resolution Status">Resolution Status</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Environmental Permits">Environmental Permits</label>
                                        <select name="environmental_permits" id="environmental_permits">
                                            <option value="">-- Select --</option>
                                            <option value="Waste Disposal">Waste Disposal</option>
                                            <option value="Water Discharge Permits">Water Discharge Permits</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Workplace Safety Certifications">Workplace Safety Certifications</label>
                                        <div class="relative-container">                                                    
                                            <input type="number" id="workplace_safety_certifications" name="workplace_safety_certifications" value="">
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                               
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <div id="CCForm8" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Incident ID">Incident ID</label>
                                        <input type="Number" name="incident_id" id="incident_id" min="0">
                                    </div>
                                </div>
                                <div><small class="text-primary">Date and Time of Incident</small></div>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Date of Incident">Date of Incident</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="date_of_incident" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" id="date_of_incident_checkdate" name="date_of_incident" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"  class="hide-input"
                                                oninput="handleDateInput(this, 'date_of_incident');checkDate('date_of_incident_checkdate','end_date_checkdate')" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Time of Incident">Time of Incident</label>
                                        <input type="time" name="time_of_incident">
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Type of Incident">Type of Incident</label>
                                        <select name="type_of_incident" id="type_of_incident">
                                            <option value="">-- Select --</option>
                                            <option value="Accident">Accident</option>
                                            <option value="Near Miss">Near Miss</option>
                                            <option value="Chemical Spill">Chemical Spill</option>
                                            <option value="Fire">Fire</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Incident Severity">Incident Severity</label>
                                        <select name="incident_severity" id="incident_severity">
                                            <option value="">-- Select --</option>
                                            <option value="Minor">Minor</option>
                                            <option value="Moderate">Moderate</option>
                                            <option value="Severe">Severe</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Location of Incident">Location of Incident</label>
                                        <div class="relative-container">                                                    
                                            <input type="text" name="location_of_incident">
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Affected Personnel">Affected Personnel</label>
                                        <select name="affected_personnel" id="affected_personnel">
                                            <option value="">-- Select --</option>
                                            <option value="Names">Names</option>
                                            <option value="Departments">Departments</option>
                                            <option value="Injury Type">Injury Type</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Root Cause Analysis">Root Cause Analysis</label>
                                        <div class="relative-container">                                                    
                                            <input type="text" name="root_cause_analysis">
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Corrective and Preventive Actions (CAPA)">Corrective and Preventive Actions (CAPA)</label>
                                        <div class="relative-container">                                                    
                                            <input type="text" name="corrective_and_preventive_actions">
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Investigation Reports">Investigation Reports</label>
                                        <div class="relative-container">                                                    
                                            <input type="text" name="investigation_reports">
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Injury Severity and Report">Injury Severity and Report</label>
                                        <select name="injury_severity_and_report" id="injury_severity_and_report">
                                            <option value="">-- Select --</option>
                                            <option value="First Aid">First Aid</option>
                                            <option value="Medical Treatment">Medical Treatment</option>
                                            <option value="Hospitalization">Hospitalization</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Incident Resolution Status">Incident Resolution Status</label>
                                        <select name="incident_resolution_status" id="incident_resolution_status">
                                            <option value="">-- Select --</option>
                                            <option value="Resolved">Resolved</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Under Investigation">Under Investigation</option>
                                        </select>
                                    </div>
                                </div>              
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>
                    <div id="CCForm9" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="root_cause">
                                            Chemical and Hazardous Materials Management
                                            <button type="button" name="audit-incident-grid" id="Chemical_and_Hazardous_Materials_Management_Add">+</button>
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#observation-field-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>

                                        <table class="table table-bordered" id="Chemical_and_Hazardous_Materials_Management_Add_field_table">
                                            <thead>
                                                <tr>
                                                    <th>Row#</th>
                                                    <th>Chemical Name</th>                                                    
                                                    <th>CAS Number</th>                                                   
                                                    <th>Material Safety Data Sheet (MSDS)</th>                                                    
                                                    <th>Quantity Stored</th>
                                                    <th>Safety Stock Level</th>                                                    
                                                    <th>Hazard Classification</th>                                                   
                                                    <th>Spill/Leak Containment Plan</th>                                                    
                                                    <th>Personal Protective Equipment Required for Handling</th>
                                                    <th>Waste Disposal Guidelines</th>
                                                    <th>Action</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $serialNumber = 1;
                                                @endphp
                                                <tr>
                                                    <td disabled>{{ $serialNumber++ }}</td>
                                                    <td><input type="text" name="ChemicalAndHazardousMaterials[0][Chemical_Name]"></td>
                                                    <td><input type="number" name="ChemicalAndHazardousMaterials[0][CAS_Number]"></td>
                                                    <td><input type="text" name="ChemicalAndHazardousMaterials[0][Material_Safety_Data_Sheet]">
                                                    </td>
                                                    <td><input type="number" name="ChemicalAndHazardousMaterials[0][Quantity_Stored]"></td>
                                                    <td><input type="text" name="ChemicalAndHazardousMaterials[0][Safety_Stock_Level]"></td>
                                                    <td><input type="text" name="ChemicalAndHazardousMaterials[0][Hazard_Classification]"></td>
                                                    <td><input type="text" name="ChemicalAndHazardousMaterials[0][Spill_Leak_Containment_Plan]">
                                                    </td>
                                                    <td><input type="text" name="ChemicalAndHazardousMaterials[0][Personal_Protective_Equipment]"></td>
                                                    <td><input type="text" name="ChemicalAndHazardousMaterials[0][Waste_Disposal_Guidelines]"></td>

                                                    <td><button class="removeRowBtn">Remove</button>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>

                                <script>
                                    $(document).ready(function() {
                                        let investdetails = 1;
                                        $('#Chemical_and_Hazardous_Materials_Management_Add').click(function(e) {
                                            function generateTableRow(serialNumber) {
                                                var html =
                                                    '<tr>' +
                                                    '<td><input disabled type="text" style ="width:15px" value="' + serialNumber +
                                                    '"></td>' +
                                                    '<td><input type="text" name="ChemicalAndHazardousMaterials[' + investdetails +
                                                    '][Chemical_Name]" value=""></td>' +
                                                    '<td><input type="number" name="ChemicalAndHazardousMaterials[' + investdetails +
                                                    '][CAS_Number]" value=""></td>' +
                                                    '<td><input type="text" name="ChemicalAndHazardousMaterials[' + investdetails +
                                                    '][Material_Safety_Data_Sheet]" value=""></td>' +
                                                    '<td><input type="number" name="ChemicalAndHazardousMaterials[' + investdetails +
                                                    '][Quantity_Stored]" value=""></td>' +
                                                    '<td><input type="text" name="ChemicalAndHazardousMaterials[' + investdetails +
                                                    '][Safety_Stock_Level]" value=""></td>' +
                                                    '<td><input type="text" name="ChemicalAndHazardousMaterials[' + investdetails +
                                                    '][Hazard_Classification]" value=""></td>' +
                                                    '<td><input type="text" name="ChemicalAndHazardousMaterials[' + investdetails +
                                                    '][Spill_Leak_Containment_Plan]" value=""></td>' +
                                                    '<td><input type="text" name="ChemicalAndHazardousMaterials[' + investdetails +
                                                    '][Personal_Protective_Equipment]" value=""></td>' +
                                                    '<td><input type="text" name="ChemicalAndHazardousMaterials[' + investdetails +
                                                    '][Waste_Disposal_Guidelines]" value=""></td>' +
                                                    '<td><button class="removeRowBtn">Remove</button>' +
                                                    '</tr>';
                                                investdetails++; // Increment the row number here
                                                return html;
                                            }

                                            var tableBody = $('#Chemical_and_Hazardous_Materials_Management_Add_field_table tbody');
                                            var rowCount = tableBody.children('tr').length;
                                            var newRow = generateTableRow(rowCount + 1);
                                            tableBody.append(newRow);
                                        });
                                        $(document).on('click', '.removeRowBtn', function() {
                                            $(this).closest('tr').remove();
                                        });
                                    });
                                </script>
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white"
                                        href="{{ url('rcms/qms-dashboard') }}">Exit</a> </button>
                            </div>
                        </div>
                    </div>

                    <div id="CCForm10" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Workplace Safety Audits">Workplace Safety Audits</label>
                                        <div class="relative-container">                                                    
                                            <textarea type="text" name="workplace_safety_audits" id="workplace_safety_audits"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>                                

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Hazardous Area Identification">Hazardous Area Identification</label>
                                        <select name="hazardous_area_identification" id="hazardous_area_identification">
                                            <option value="">-- Select --</option>
                                            <option value="Zones for Flammable Materials">Zones for Flammable Materials</option>
                                            <option value="High Voltage Areas">High Voltage Areas</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Ventilation Systems Monitoring">Ventilation Systems Monitoring</label>
                                        <select name="ventilation_systems_monitoring" id="ventilation_systems_monitoring">
                                            <option value="">-- Select --</option>
                                            <option value="Air Quality">Air Quality</option>
                                            <option value="Exhaust Systems">Exhaust Systems</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Noise Levels Monitoring">Noise Levels Monitoring</label>
                                        <div class="relative-container">                                                    
                                            <input type="text" name="noise_levels_monitoring">
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Lighting and Temperature Monitoring">Lighting and Temperature Monitoring</label>
                                        <div class="relative-container">                                                    
                                            <input type="text" name="lighting_and_temperature_monitoring">
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Personal Monitoring (Health and Safety Data)">Personal Monitoring (Health and Safety Data)</label>
                                        <select name="personal_monitoring" id="personal_monitoring">
                                            <option value="">-- Select --</option>
                                            <option value="Fatigue Management">Fatigue Management</option>
                                            <option value="Exposure Limits">Exposure Limits</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Ergonomics Data">Ergonomics Data</label>
                                        <select name="ergonomics_data" id="ergonomics_data">
                                            <option value="">-- Select --</option>
                                            <option value="Workplace Layout">Workplace Layout</option>
                                            <option value="Workstation Setup">Workstation Setup</option>
                                            <option value="Equipment Usage">Equipment Usage</option>
                                        </select>
                                    </div>
                                </div>
                                              
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>
                    <div id="CCForm11" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            
                            <div class="row">
                               
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Employee Health Records">Employee Health Records</label>
                                        <select name="Employee_Health_Records" id="Employee_Health_Records">
                                            <option value="">-- Select --</option>
                                            <option value="Pre-employment">Pre-employment</option>
                                            <option value="Routine Health Check-ups">Routine Health Check-ups</option>
                                            <option value="Occupational Diseases">Occupational Diseases</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Occupational Exposure Limits">Occupational Exposure Limits</label>
                                        <select name="Occupational_Exposure_Limits" id="Occupational_Exposure_Limits">
                                            <option value="">-- Select --</option>
                                            <option value="PEL">PEL</option>
                                            <option value="TLV for Hazardous Substances">TLV for Hazardous Substances</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Vaccination Records">Vaccination Records</label>
                                        <div class="relative-container">                                                    
                                            <input type="text" name="Vaccination_Records">
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Pre-employment and Routine Health Screenings">Pre-employment and Routine Health Screenings</label>
                                        <div class="relative-container">                                                    
                                            <input type="text" name="Pre_employment_and_Routine_Health_Screenings">
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Workplace Injury and Illness Reporting">Workplace Injury and Illness Reporting</label>
                                        <div class="relative-container">                                                    
                                            <input type="text" name="Workplace_Injury_and_Illness_Reporting">
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Absenteeism Data">Absenteeism Data</label>
                                        <div class="relative-container">                                                    
                                            <input type="text" name="Absenteeism_Data">
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Safety Drills and Training Records">Safety Drills and Training Records</label>
                                        <div class="relative-container">                                                    
                                            <input type="text" name="Safety_Drills_and_Training_Records">
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="First Aid and Emergency Response Records">First Aid and Emergency Response Records</label>
                                        <div class="relative-container">                                                    
                                            <input type="text" name="First_Aid_and_Emergency_Response_Records">
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                            
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <div id="CCForm12" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            
                            <div class="row">
                               
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Emergency Plan">Emergency Plan</label>
                                        <select name="Emergency_Plan" id="Emergency_Plan">
                                            <option value="">-- Select --</option>
                                            <option value="Evacuation Procedures">Evacuation Procedures</option>
                                            <option value="Fire Safety Plans">Fire Safety Plans</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Emergency Contacts">Emergency Contacts</label>
                                        <select name="Emergency_Contacts2" id="Emergency_Contacts2">
                                            <option value="">-- Select --</option>
                                            <option value="Fire Department">Fire Department</option>
                                            <option value="Medical Team">Medical Team</option>
                                            <option value="First Responders">First Responders</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Emergency Equipment">Emergency Equipment</label>
                                        <select name="Emergency_Equipment" id="Emergency_Equipment">
                                            <option value="">-- Select --</option>
                                            <option value="Location and Maintenance of Fire Extinguishers">Location and Maintenance of Fire Extinguishers</option>
                                            <option value="First Aid Kits">First Aid Kits</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Incident Simulation Drills">Incident Simulation Drills</label>
                                        <select name="Incident_Simulation_Drills" id="Incident_Simulation_Drills">
                                            <option value="">-- Select --</option>
                                            <option value="Date">Date</option>
                                            <option value="Type">Type</option>
                                            <option value="Results">Results</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Response Time Metrics">Response Time Metrics</label>
                                        <div class="relative-container">                                                    
                                            <input type="text" name="Response_Time_Metrics">
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Evacuation Routes and Assembly Points">Evacuation Routes and Assembly Points</label>
                                        <div class="relative-container">                                                    
                                            <input type="text" name="Evacuation_Routes_and_Assembly_Points">
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                            
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <div id="CCForm13" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="root_cause">
                                            Waste Management
                                            <button type="button" name="audit-incident-grid" id="Waste_Management_Add">+</button>
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#observation-field-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>

                                        <table class="table table-bordered" id="Waste_Management_Add_field_table">
                                            <thead>
                                                <tr>
                                                    <th>Row#</th>
                                                    <th>Total Waste Generated (kg or tons)</th>                                                    
                                                    <th>Waste Type</th>                                                   
                                                    <th>Waste Disposal Method</th>                                                    
                                                    <th>Waste Recycling Rate</th>
                                                    <th>Waste to Landfill</th>                                                    
                                                    <th>Waste Reduction Initiatives</th> 
                                                    <th>Hazardous Waste Management</th> 
                                                    <th>Action</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $serialNumber = 1;
                                                @endphp
                                                <tr>
                                                    <td disabled>{{ $serialNumber++ }}</td>
                                                    <td><input type="number" name="WasteManagement[0][Total_Waste_Generated]"></td>
                                                    <td><input type="text" name="WasteManagement[0][Waste_Type]"></td>
                                                    <td><input type="text" name="WasteManagement[0][Waste_Disposal_Method]">
                                                    </td>
                                                    <td><input type="number" name="WasteManagement[0][Waste_Recycling_Rate]"></td>
                                                    <td><input type="number" name="WasteManagement[0][Waste_to_Landfill]"></td>
                                                    <td><input type="text" name="WasteManagement[0][Waste_Reduction_Initiatives]"></td>
                                                    <td><input type="text" name="WasteManagement[0][Hazardous_Waste_Management]">
                                                    </td>
                                                    <td><button class="removeRowBtn">Remove</button>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>

                                <script>
                                    $(document).ready(function() {
                                        let investdetails = 1;
                                        $('#Waste_Management_Add').click(function(e) {
                                            function generateTableRow(serialNumber) {
                                                var html =
                                                    '<tr>' +
                                                    '<td><input disabled type="text" style ="width:15px" value="' + serialNumber +
                                                    '"></td>' +
                                                    '<td><input type="number" name="WasteManagement[' + investdetails +
                                                    '][Total_Waste_Generated]" value=""></td>' +
                                                    '<td><input type="text" name="WasteManagement[' + investdetails +
                                                    '][Waste_Type]" value=""></td>' +
                                                    '<td><input type="text" name="WasteManagement[' + investdetails +
                                                    '][Waste_Disposal_Method]" value=""></td>' +
                                                    '<td><input type="number" name="WasteManagement[' + investdetails +
                                                    '][Waste_Recycling_Rate]" value=""></td>' +
                                                    '<td><input type="number" name="WasteManagement[' + investdetails +
                                                    '][Waste_to_Landfill]" value=""></td>' +
                                                    '<td><input type="text" name="WasteManagement[' + investdetails +
                                                    '][Waste_Reduction_Initiatives]" value=""></td>' +
                                                    '<td><input type="text" name="WasteManagement[' + investdetails +
                                                    '][Hazardous_Waste_Management]" value=""></td>' +                                                    
                                                    '<td><button class="removeRowBtn">Remove</button>' +
                                                    '</tr>';
                                                investdetails++; // Increment the row number here
                                                return html;
                                            }

                                            var tableBody = $('#Waste_Management_Add_field_table tbody');
                                            var rowCount = tableBody.children('tr').length;
                                            var newRow = generateTableRow(rowCount + 1);
                                            tableBody.append(newRow);
                                        });
                                        $(document).on('click', '.removeRowBtn', function() {
                                            $(this).closest('tr').remove();
                                        });
                                    });
                                </script>
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white"
                                        href="{{ url('rcms/qms-dashboard') }}">Exit</a> </button>
                            </div>
                        </div>
                    </div>

                    <div id="CCForm14" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="audit-agenda-grid">
                                            Training Detail<button type="button" name="audit-agenda-grid"
                                                id="addTrainingPlan">+</button>
                                        </label>
                                        <table class="table table-bordered" id="addTrainingPlanTable">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%;">Row#</th>
                                                    <th style="width: 15%;">Training Topic</th>
                                                    <th style="width: 10%;">SOP Title</th>
                                                    <th>SOP No.</th>
                                                    <th>SOP Type</th>   
                                                    <th style="width: 10%;">Training Type</th>                                                 
                                                    <th>Trainee</th>                                                
                                                    <th>Start Date</th>                                                 
                                                    <th>End Date</th>                                                
                                                    <th>Trainer</th>
                                                    <th>Training Attempt</th>
                                                    <th>Attachment</th>
                                                    <th>Minimum Sop View Time(in min)</th>
                                                    <th>Maximum Sop View Time(in min)</th>
                                                    <th style="width: 5%;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input disabled type="text" name="trainingPlanData[0][serial]" value="1">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="trainingPlanData[0][trainingTopic]" readonly>
                                                    </td>
                                                    <td>
                                                        <select name="trainingPlanData[0][documentNumber]" id="doocumentPlan" readonly>
                                                            <option value="">-- Select --</option>
                                                            @foreach ($documents as $document)
                                                                <option value="{{ $document->id }}">{{ $document->document_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="doc_number" name="trainingPlanData[0][documentName]" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="sop_type" name="trainingPlanData[0][sopType]" readonly>
                                                    </td>
                                                    <td>
                                                        <select name="trainingPlanData[0][trainingType]" readonly>
                                                            <option value="">-- Select --</option>
                                                            <option value="Read & Understand">Read & Understand</option>
                                                            <option value="Read & Understand with Questions">Read & Understand with Questions</option>
                                                            <option value="Classroom Training">Classroom Training</option>
                                                            {{-- <option value="On Job Training">On Job Training</option>
                                                            <option value="External Training">External Training</option>
                                                            <option value="Refresher Training">Refresher Training</option>
                                                            <option value="Retraining">Retraining</option> --}}
                                                        </select>
                                                    </td>
                                                    <td>
                                                            <select name="trainingPlanData[0][trainees]" readonly>
                                                                <option value="">Select a value</option>
                                                                @if(!empty($users))
                                                                    @foreach ($users as $employee)
                                                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="date" name="trainingPlanData[0][startDate]" readonly>
                                                        </td>
                                                        <td>
                                                            <input type="date" name="trainingPlanData[0][endDate]" readonly>
                                                        </td>

                                                        <td>
                                                            <select name="trainingPlanData[0][trainer]" readonly>
                                                                <option value="">Select a value</option>
                                                                @if(!empty($users))
                                                                    @foreach ($users as $user)
                                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </td>

                                                    <td>
                                                        <input type="text" name="trainingPlanData[0][trainingAttempt]" value="3" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="file" name="trainingPlanData[0][file]" class="file-input" readonly>
                                                    </td>
                                                    <td><input type="number" value="0" name="trainingPlanData[0][total_minimum_time]" id=""></td>
                                                    <td><input type="number" value="0" name="trainingPlanData[0][per_screen_run_time]" id=""></td>
                                                    <td><button type="button" class="removeRowBtn">Remove</button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        let trainingPlanIndex = 1;
                            
                                        function fetchAndDisplayTitles(selectElement, row) {
                                            var documentIds = selectElement.val();
                            
                                            if (documentIds) {
                                                if (typeof documentIds === 'string') {
                                                    documentIds = [documentIds];
                                                }
                            
                                                var fetchTitlePromises = documentIds.map(function(documentId) {
                                                    return $.ajax({
                                                        url: '/rcms/get-doc-detail/' + documentId,
                                                        method: 'GET'
                                                    });
                                                });
                            
                                                $.when.apply($, fetchTitlePromises).done(function() {
                                                    var docNumbers = [];
                                                    var sopTypes = [];
                            
                                                    if (Array.isArray(arguments[0])) {
                                                        for (var i = 0; i < arguments.length; i++) {
                                                            var response = arguments[i][0];
                                                            docNumbers.push(response.doc_number);
                                                            sopTypes.push(response.sop_type);
                                                        }
                                                    } else {
                                                        docNumbers.push(arguments[0]['doc_number']);
                                                        sopTypes.push(arguments[0]['sop_type']);
                                                    }
                            
                                                    row.find('input.doc_number').val(docNumbers.join(', '));
                                                    row.find('input.sop_type').val(sopTypes.join(', '));
                                                }).fail(function() {
                                                    alert('Failed to fetch Document Detail details.');
                                                });
                                            } else {
                                                row.find('input.doc_number').val('');
                                                row.find('input.sop_type').val('');
                                            }
                                        }
                            
                                        $('#addTrainingPlan').click(function(e) {
                                            function generateTableRow(serialNumber) {
                                                var documents = @json($documents); 
                                                var documentOptionHtml = '<option value="">-- Select --</option>';
                                                documents.forEach(document => {
                                                    documentOptionHtml += `<option value="${document.id}">${document.document_name}</option>`;
                                                });
                            
                                                var users = @json($users); 
                                                var employeeOptionHtml = '<option value="">-- Select --</option>';
                                                users.forEach(employee => {
                                                    employeeOptionHtml += `<option value="${employee.id}">${employee.name}</option>`;
                                                });
                            
                                                var users = @json($users); 
                                                var useOptionHtml = '<option value="">-- Select --</option>';
                                                users.forEach(use => {
                                                    useOptionHtml += `<option value="${use.id}">${use.name}</option>`;
                                                });
                            
                                            var html = 
                                                '<tr>' +
                                                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                                                    '<td><input type="text" name="trainingPlanData[' + trainingPlanIndex + '][trainingTopic]"></td>' +
                                                    '<td><select id="documentPlan_' + trainingPlanIndex + '" class="training-select" name="trainingPlanData[' + trainingPlanIndex + '][documentNumber]">' + documentOptionHtml + '</select></td>' +
                                                    '<td><input type="text" class="doc_number" name="trainingPlanData[' + trainingPlanIndex + '][documentName]" readonly></td>' +
                                                    '<td><input type="text" class="sop_type" name="trainingPlanData[' + trainingPlanIndex + '][sopType]" readonly></td>' +
                                                    '<td><select name="trainingPlanData[' + trainingPlanIndex + '][trainingType]">' +
                                                        '<option value="">-- Select --</option>' +
                                                        '<option value="Read & Understand">Read & Understand</option>' +
                                                        '<option value="Read & Understand with Questions">Read & Understand with Questions</option>' +
                                                        '<option value="Classroom Training">Classroom Training</option>' +
                                                        // '<option value="On Job Training">On Job Training</option>' +
                                                        // '<option value="External Training">External Training</option>' +
                                                        // '<option value="Refresher Training">Refresher Training</option>' +
                                                        // '<option value="Retraining">Retraining</option>' +
                                                    '</select></td>' +
                                                    '<td><select name="trainingPlanData[' + trainingPlanIndex + '][trainees]">' + employeeOptionHtml + '</select></td>' +
                                                    '<td><input type="date" name="trainingPlanData[' + trainingPlanIndex + '][startDate]"></td>' +
                                                    '<td><input type="date" name="trainingPlanData[' + trainingPlanIndex + '][endDate]"></td>' +
                                                    '<td><select name="trainingPlanData[' + trainingPlanIndex + '][trainer]">' + useOptionHtml + '</select></td>' +
                                                    '<td><input type="text" name="trainingPlanData[' + trainingPlanIndex + '][trainingAttempt]" value="3" readonly></td>' +
                                                    '<td>' +
                                                        '<input type="file" name="trainingPlanData[' + trainingPlanIndex + '][file]" class="file-input">' +
                                                        '<span class="file-name"></span>' +
                                                    '</td>' +
                                                    '<td><input type="number" name="trainingPlanData[' + trainingPlanIndex + '][total_minimum_time]" readonly></td>' +
                                                    '<td><input type="number" name="trainingPlanData[' + trainingPlanIndex + '][per_screen_run_time]" readonly></td>' +
                                                    '<td><button type="button" class="removeRowBtn">Remove</button></td>' +
                                                '</tr>';
                            
                            
                                                trainingPlanIndex++;
                                                return html;
                                            }
                            
                                            var tableBody = $('#addTrainingPlanTable tbody');
                                            var rowCount = tableBody.children('tr').length;
                                            var newRow = generateTableRow(rowCount + 1);
                                            tableBody.append(newRow);
                            
                                            tableBody.find('.training-select').last().change(function() {
                                                var row = $(this).closest('tr');
                                                fetchAndDisplayTitles($(this), row);
                                            });
                            
                                            tableBody.find('.file-input').last().change(function() {
                                                var fileName = $(this).val().split('\\').pop();
                                                $(this).siblings('.file-name').text(fileName);
                                            });
                                        });
                            
                                        $(document).on('change', '.file-input', function() {
                                            var fileName = $(this).val().split('\\').pop();
                                            $(this).siblings('.file-name').text(fileName);
                                        });
                            
                                        $(document).on('click', '.removeRowBtn', function() {
                                            $(this).closest('tr').remove();
                                            updateTableIndexing();
                                        });
                                    });
                                </script>                                

                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                        class="text-white">Exit</a></button>
                            </div>
                        </div>
                    </div>

                    <div id="CCForm15" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            
                            <div class="row">
                               
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Energy Consumption">Energy Consumption</label>
                                        <select name="Energy_Consumption" id="Energy_Consumption">
                                            <option value="">-- Select --</option>
                                            <option value="Electricity">Electricity</option>
                                            <option value="Gas">Gas</option>
                                            <option value="Water">Water</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Greenhouse Gas Emissions">Greenhouse Gas Emissions</label>
                                        <select name="Greenhouse_Gas_Emissions" id="Greenhouse_Gas_Emissions">
                                            <option value="">-- Select --</option>
                                            <option value="CO2">CO2</option>
                                            <option value="NOx">NOx</option>
                                            <option value="Particulate Matter">Particulate Matter</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Wastewater Discharge">Wastewater Discharge</label>
                                        <select name="Wastewater_Discharge" id="Wastewater_Discharge">
                                            <option value="">-- Select --</option>
                                            <option value="Quality and Quantity">Quality and Quantity</option>
                                            <option value="Compliance with Standards">Compliance with Standards</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Air Quality Monitoring ">Air Quality Monitoring </label>
                                        <div class="relative-container">                                                    
                                            <input type="text" name="Air_Quality_Monitoring">
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Environmental Sustainability Projects">Environmental Sustainability Projects</label>
                                        <div class="relative-container">                                                    
                                            <input type="text" name="Environmental_Sustainability_Projects">
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>                                            
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <div id="CCForm16" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Impact">Energy Type</label>
                                        <select name="enargy_type" id="enargy_type">
                                            <option value="">-- Select --</option>
                                            <option value="Electricity">Electricity</option>
                                            <option value="Natural Gas">Natural Gas</option>
                                            <option value="Renewable Energy">Renewable Energy</option>
                                            <option value="Fuel">Fuel</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Impact">Energy Source</label>
                                        <select name="enargy_source" id="enargy_source">
                                            <option value="">-- Select --</option>
                                            <option value="Grid">Grid</option>
                                            <option value="Renewable">Renewable</option>
                                            <option value="On-Site Generation">On-Site Generation</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">Energy Usage (kWh)</label>
                                        <div class="relative-container">                                                    
                                            <input name="energy_usage" id="energy_usage"></input>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">Energy Intensity</label>
                                        <div class="relative-container">                                                    
                                            <input name="energy_intensity" id="energy_intensity"></input>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">Peak Demand (kW)</label>
                                        <div class="relative-container">                                                    
                                            <input name="peak_demand" id="peak_demand"></input>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">Energy Efficiency</label>
                                        <div class="relative-container">                                                    
                                            <input name="energy_efficiency" id="energy_efficiency"></input>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                             
                                
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>
                    <!-- --- ------------- -->

                    <div id="CCForm17" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">CO2 Emissions (kg/tons)</label>
                                        <div class="relative-container">                                                    
                                            <input name="co_emissions" id="co_emissions"></input>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">Greenhouse Gas Emissions (GHG)</label>
                                        <div class="relative-container">                                                    
                                            <textarea name="greenhouse_ges_emmission" id="greenhouse_ges_emmission"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">Scope 1 Emissions</label>
                                        <div class="relative-container">                                                    
                                            <input name="scope_one_emission" id="scope_one_emission"></input>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">Scope 2 Emissions</label>
                                        <div class="relative-container">                                                    
                                            <input name="scope_two_emission" id="scope_two_emission"></input>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">Scope 3 Emissions</label>
                                        <div class="relative-container">                                                    
                                            <input name="scope_three_emission" id="scope_three_emission"></input>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">Carbon Intensity</label>
                                        <div class="relative-container">                                                    
                                            <input name="carbon_intensity" id="carbon_intensity"></input>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Impact">Energy Source</label>
                                        <select name="enargy_source" id="enargy_source">
                                            <option value="">-- Select --</option>
                                            <option value="Grid">Grid</option>
                                            <option value="Renewable">Renewable</option>
                                            <option value="On-Site Generation">On-Site Generation</option>
                                        </select>
                                    </div>
                                </div> -->

                            

                             
                                
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <!-- --- ------------ -->
                    <div id="CCForm18" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">Water Consumption (m³ or liters)</label>
                                        <div class="relative-container">                                                    
                                            <input name="water_consumption" id="water_consumption"></input>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Impact">Water Source</label>
                                        <select name="water_source" id="water_source">
                                            <option value="">-- Select --</option>
                                            <option value="Municipal Water">Municipal Water</option>
                                            <option value="Groundwater">Groundwater</option>
                                            <option value="Recycled Water">Recycled Water</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">Water Efficiency</label>
                                        <div class="relative-container">                                                    
                                            <input name="water_effeciency" id="water_effeciency"></input>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">Water Discharge (m³ or liters)</label>
                                        <div class="relative-container">                                                    
                                            <input name="water_discharge" id="water_discharge"></input>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">Waste Water Treatment</label>
                                        <div class="relative-container">                                                    
                                            <textarea name="waste_water_treatment" id="waste_water_treatment"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">Rainwater Harvesting</label>
                                        <div class="relative-container">                                                    
                                            <input name="rainwater_harvesting" id="rainwater_harvesting"></input>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                             
                                
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <!-- ---- ------- -->

                    <div id="CCForm19" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">Sustainable Products Purchased</label>
                                        <div class="relative-container">                                                    
                                            <input name="sustainable_product_purchased" id="sustainable_product_purchased"></input>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">Supplier Sustainability</label>
                                        <div class="relative-container">                                                    
                                            <textarea name="supplier_sustainability" id="supplier_sustainability"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>


                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">Sustainable Packaging</label>
                                        <div class="relative-container">                                                    
                                            <input name="sustainable_packaing" id="sustainable_packaing"></input>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">Local Sourcing</label>
                                        <div class="relative-container">                                                    
                                            <input name="local_sourcing" id="local_sourcing"></input>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">Fair Trade or Certification Labels</label>
                                        <div class="relative-container">                                                    
                                            <textarea name="fair_trade" id="fair_trade"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>


                                <!-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Impact">Water Source</label>
                                        <select name="water_source" id="water_source">
                                            <option value="">-- Select --</option>
                                            <option value="Municipal Water">Municipal Water</option>
                                            <option value="Groundwater">Groundwater</option>
                                            <option value="Recycled Water">Recycled Water</option>
                                        </select>
                                    </div>
                                </div> -->
                                



                             
                                
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <!-- --- ----- -->
                    <div id="CCForm20" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">Fuel Consumption</label>
                                        <div class="relative-container">                                                    
                                            <input name="fuel_consumption" id="fuel_consumption"></input>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Impact">Vehicle Type</label>
                                        <select name="Vehicle_Type1" id="Vehicle_Type1">
                                            <option value="">-- Select --</option>
                                            <option value="Electric Vehicles">Electric Vehicles</option>
                                            <option value="Hybrid Vehicles">Hybrid Vehicles</option>
                                            <option value="Fossil Fuel-Powered Vehicles">Fossil Fuel-Powered Vehicles</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">Fleet Emissions</label>
                                        <div class="relative-container">                                                    
                                            <input name="fleet_emissions" id="fleet_emissions"></input>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">Miles Traveled</label>
                                        <div class="relative-container">                                                    
                                            <input name="miles_traveled" id="miles_traveled"></input>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">Freight and Shipping</label>
                                        <div class="relative-container">                                                    
                                            <textarea name="freight_and_shipping" id="freight_and_shipping"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">Carbon Offset Programs</label>
                                        <div class="relative-container">                                                    
                                            <textarea name="carbon_pffset_programs" id="carbon_pffset_programs"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                             
                                
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <!-- ---- ------- -->

                    <div id="CCForm21" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">Land Area Impacted (m² or hectares)</label>
                                        <div class="relative-container">                                                    
                                            <input name="land_area_impacted" id="land_area_impacted"></input>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">Protected Areas</label>
                                        <div class="relative-container">                                                    
                                            <input name="protected_areas" id="protected_areas"></input>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">Deforestation</label>
                                        <div class="relative-container">                                                    
                                            <input name="deforestation" id="deforestation"></input>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>


                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">Habitat Preservation</label>
                                        <div class="relative-container">                                                    
                                            <textarea name="habitat_preservation" id="habitat_preservation"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">Biodiversity Initiatives</label>
                                        <div class="relative-container">                                                    
                                            <textarea name="biodiversity_initiatives" id="biodiversity_initiatives"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>


                                <!-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Impact">Vehicle Type</label>
                                        <select name="water_source" id="water_source">
                                            <option value="">-- Select --</option>
                                            <option value="Electric Vehicles">Electric Vehicles</option>
                                            <option value="Hybrid Vehicles">Hybrid Vehicles</option>
                                            <option value="Fossil Fuel-Powered Vehicles">Fossil Fuel-Powered Vehicles</option>
                                        </select>
                                    </div>
                                </div> -->
                                



                             
                                
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <!-- --- ------ -->

                    <div id="CCForm22" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Impact">Certifications</label>
                                        <select name="certifications" id="certifications">
                                            <option value="">-- Select --</option>
                                            <option value="ISO 14001">ISO 14001</option>
                                            <option value="LEED">LEED</option>
                                            <option value="Fair Trade">Fair Trade</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">Regulatory Compliance</label>
                                        <div class="relative-container">                                                    
                                            <textarea name="regulatory_compliance" id="regulatory_compliance"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">Audits</label>
                                        <div class="relative-container">                                                    
                                            <input name="audits" id="audits"></input>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                            
                                
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <!-- ---- ----- -->

                    <div id="CCForm23" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Impact">Environmental Risk</label>
                                        <select name="enviromental_risk" id="enviromental_risk">
                                            <option value="">-- Select --</option>
                                            <option value="Pollution">Pollution</option>
                                            <option value="Accidents">Accidents</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">Impact Assessment</label>
                                        <div class="relative-container">                                                    
                                            <textarea name="impact_assessment" id="impact_assessment"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Impact">Climate Change Adaptation</label>
                                        <select name="climate_change_adaptation" id="climate_change_adaptation">
                                            <option value="">-- Select --</option>
                                            <option value="Flooding">Flooding</option>
                                            <option value="Heatwaves">Heatwaves</option>    
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">Carbon Footprint</label>
                                        <div class="relative-container">                                                    
                                            <input name="carbon_footprint" id="carbon_footprint"></input>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>             
                                
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>
                    <!-- ----- ----- -->

                    <div id="CCForm24" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Impact">Risk Assessment Data</label>
                                        <select name="Risk_Assessment_Data" id="Risk_Assessment_Data">
                                            <option value="">-- Select --</option>
                                            <option value="Likelihood">Likelihood</option>
                                            <option value="Impact">Impact</option>
                                            <option value="Mitigation Measures">Mitigation Measures</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Impact">Hazard ID Reports </label>
                                        <select name="hazard_id_reports" id="hazard_id_reports">
                                            <option value="">-- Select --</option>
                                            <option value="Hazardous Operations">Hazardous Operations</option>
                                            <option value="Chemical Exposure">Chemical Exposure</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 mb-4">
                                    <div class="group-input">
                                        <label for="agenda">
                                            Failure Mode and Effect Analysis
                                            <button type="button" name="agenda"
                                                onclick="addRootRiskAssessment('risk-management')">+</button>
                                            <span class="text-primary" style="font-size: 0.8rem; font-weight: 400;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" style="width: 200%"
                                                id="risk-management">
                                                <thead>
                                                    <tr>
                                                        <th>Row #</th>
                                                        <th>Risk Factor</th>
                                                        <th>Risk element </th>
                                                        <th>Probable cause of risk element</th>
                                                        <th>Existing Risk Controls</th>
                                                        <th>Initial Severity- H(3)/M(2)/L(1)</th>
                                                        <th>Initial Probability- H(3)/M(2)/L(1)</th>
                                                        <th>Initial Detectability- H(1)/M(2)/L(3)</th>
                                                        <th>Initial RPN</th>
                                                        <th>Risk Acceptance (Y/N)</th>
                                                        <th>Proposed Additional Risk control measure (Mandatory for Risk
                                                            elements having RPN>4)</th>
                                                        <th>Residual Severity- H(3)/M(2)/L(1)</th>
                                                        <th>Residual Probability- H(3)/M(2)/L(1)</th>
                                                        <th>Residual Detectability- H(1)/M(2)/L(3)</th>
                                                        <th>Residual RPN</th>
                                                        <th>Risk Acceptance (Y/N)</th>
                                                        <th>Mitigation proposal (Mention either CAPA reference number, IQ,
                                                            OQ or
                                                            PQ)</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Comments">Risk Mitigation Plan</label>
                                        <div class="relative-container">                                                    
                                            <textarea name="risk_migration_plan" id="risk_migration_plan"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Comments">Corrective Actions</label>
                                        <div class="relative-container">                                                    
                                            <textarea name="corrective_action" id="corrective_action"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>


                
                                
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <!-- --- ---------- -->

                    <div id="CCForm25" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">Audit ID</label>
                                        <div class="relative-container">                                                    
                                            <input name="audit_id" id="audit_id"></input>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Impact">Audit Type</label>
                                        <select name="Audit_Type" id="Audit_Type">
                                            <option value="">-- Select --</option>
                                            <option value="Internal">Internal</option>
                                            <option value="External">External</option>
                                            <option value="Regulatory">Regulatory</option>
                                        </select>
                                    </div>
                                </div>
                               
                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Warranty Expiration Date">Audit Date</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="audit_date" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" id="audit_date_checkdate"
                                                name="audit_date"
                                                max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'audit_date');checkDate('audit_date_checkdate','warranty_expiration_date_checkdate')" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Impact">Audit Scope</label>
                                        <select name="audit_scope" id="audit_scope">
                                            <option value="">-- Select --</option>
                                            <option value="Departments">Departments</option>
                                            <option value="Facilities">Facilities</option>
                                            <option value="Processes">Processes</option>
                                        </select>
                                    </div>
                                </div>
                               
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Comments">Findings and Observations</label>
                                        <div class="relative-container">                                                    
                                            <textarea name="finding_and_observation" id="finding_and_observation"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Comments">Corrective Action Plans</label>
                                        <div class="relative-container">                                                    
                                            <textarea name="corrective_action_plans" id="corrective_action_plans"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Comments">Follow-up Audit Results</label>
                                        <div class="relative-container">                                                    
                                            <textarea name="follow_up_audit_result" id="follow_up_audit_result"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                             
                                
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>
                    <!-- ----  -------- -->

                    <div id="CCForm26" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Impact">Sustainability Initiatives</label>
                                        <select name="sustainability_initiatives" id="sustainability_initiatives">
                                            <option value="">-- Select --</option>
                                            <option value="Waste Reduction">Waste Reduction</option>
                                            <option value="Energy Savings">Energy Savings</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Impact">CSR Activities </label>
                                        <select name="csr_activities" id="csr_activities">
                                            <option value="">-- Select --</option>
                                            <option value="Employee Engagement">Employee Engagement</option>
                                            <option value="Environmental Programs">Environmental Programs</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Comments">Sustainability Reporting</label>
                                        <div class="relative-container">                                                    
                                            <textarea name="sustainability_reporting" id="sustainability_reporting"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Comments">Public Relations/Community Engagement Reports</label>
                                        <div class="relative-container">                                                    
                                            <textarea name="public_relation_report" id="public_relation_report"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                             
                                
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>
                    <!-- ---- ----- -->

                    <div id="CCForm27" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Impact">Dashboards </label>
                                        <select name="Dashboards" id="Dashboards">
                                            <option value="">-- Select --</option>
                                            <option value="Incidents">Incidents</option>
                                            <option value="Compliance Status">Compliance Status</option>
                                            <option value="Safety Performance">Safety Performance</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Impact">Key Performance Indicators (KPIs)</label>
                                        <select name="key_performance_indicators" id="key_performance_indicators">
                                            <option value="">-- Select --</option>
                                            <option value="Incident Rate">Incident Rate</option>
                                            <option value="PPE Compliance Rate">PPE Compliance Rate</option>
                                            <option value="Training Completion Rate">Training Completion Rate</option>
                                        </select>
                                    </div>
                                </div>

                                
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Impact">Trend Analysis</label>
                                        <select name="trend_analysis" id="trend_analysis">
                                            <option value="">-- Select --</option>
                                            <option value="Safety">Safety</option>
                                            <option value="Incidents">Incidents</option>
                                            <option value="Environmental Impact">Environmental Impact</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Impact">Data Export Functionality</label>
                                        <select name="data_export_functionality" id="data_export_functionality">
                                            <option value="">-- Select --</option>
                                            <option value="PDF  ">PDF </option>
                                            <option value="Excel">Excel</option>
                                            <option value="CSV">CSV</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Comments">Monthly/Quarterly/Annual Reports</label>
                                        <div class="relative-container">                                                    
                                            <textarea name="monthly_annual_reports" id="monthly_annual_reports"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>
                    <!-- ---- ----- -->

                    <div id="CCForm28" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                
                                
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Impact">KPIs (Key Performance Indicators)</label>
                                        <select name="KPIs" id="KPIs">
                                            <option value="">-- Select --</option>
                                            <option value="Energy Savings">Energy Savings</option>
                                            <option value="Emission Reductions">Emission Reductions</option>
                                            <option value="Water Conservation">Water Conservation</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Comments">Sustainability Targets</label>
                                        <div class="relative-container">                                                    
                                            <textarea name="sustainability_targets" id="sustainability_targets"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Comments">Progress Towards Goals</label>
                                        <div class="relative-container">                                                    
                                            <textarea name="progress_towards_goals" id="progress_towards_goals"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Goal Name">Goal Name</label>
                                        <div class="relative-container">                                                    
                                            <textarea name="Goal_Name" id="Goal_Name"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Goal Description">Goal Description</label>
                                        <div class="relative-container">                                                    
                                            <textarea name="Goal_Description" id="Goal_Description"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Responsible Department">Responsible Department</label>
                                        <select name="Responsible_Department" id="Responsible_Department">
                                            <option value="">-- Select --</option>
                                            <option value="Operations">Operations</option>
                                            <option value="R&D">R&D</option>
                                            <option value="Compliance">Compliance</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Goal Timeframe">Goal Timeframe</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="Goal_Timeframe" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" id="Goal_Timeframe_checkdate" name="Goal_Timeframe" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"  class="hide-input"
                                                oninput="handleDateInput(this, 'Goal_Timeframe');checkDate('Goal_Timeframe_checkdate','Goal_Timeframe1_checkdate')" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Region">Region</label>
                                        <select name="Region" id="Region">
                                            <option value="">-- Select --</option>
                                            <option value="Global">Global</option>
                                            <option value="North America">North America</option>
                                            <option value="Europe">Europe</option>
                                            <option value="Asia-Pacific">Asia-Pacific</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="sub-head">
                                    Energy Use
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Energy Source">Energy Source</label>
                                        <select name="Energy_Source" id="Energy_Source">
                                            <option value="">-- Select --</option>
                                            <option value="Renewable (e.g., Solar, Wind, Hydro)">Renewable (e.g., Solar, Wind, Hydro)</option>
                                            <option value="Non-Renewable (e.g., Coal, Oil, Gas)">Non-Renewable (e.g., Coal, Oil, Gas)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Energy Consumption (MWh)">Energy Consumption (MWh)</label>                                                 
                                        <input type="number" name="Energy_Consumption2">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Energy Efficiency Target (%)">Energy Efficiency Target (%)</label>                                                
                                        <input type="number" name="Energy_Efficiency_Target">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Renewable Energy Usage Target (%)">Renewable Energy Usage Target (%)</label>                                                 
                                        <input type="number" name="Renewable_Energy_Usage_Target">
                                    </div>
                                </div>

                                <div class="sub-head">
                                    Carbon Emissions
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Emission Source">Emission Source</label>
                                        <select name="Emission_Source" id="Emission_Source">
                                            <option value="">-- Select --</option>
                                            <option value="Scope 1 (Direct Emissions)">Scope 1 (Direct Emissions)</option>
                                            <option value="Scope 2 (Indirect Emissions)">Scope 2 (Indirect Emissions)</option>
                                            <option value="Scope 3 (Supply Chain Emissions)">Scope 3 (Supply Chain Emissions)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Carbon Footprint (Metric Tons CO2e)">Carbon Footprint (Metric Tons CO2e)</label>                                                  
                                        <input type="number" name="Carbon_Footprint2">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Reduction Target (%)">Reduction Target (%)</label>                                                   
                                        <input type="number" name="Reduction_Target">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Offset Mechanisms">Offset Mechanisms</label>
                                        <select name="Offset_Mechanisms" id="Offset_Mechanisms">
                                            <option value="">-- Select --</option>
                                            <option value="Reforestation">Reforestation</option>
                                            <option value="Carbon Credits">Carbon Credits</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="sub-head">
                                    Water Conservation
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Water Source">Water Source</label>
                                        <select name="Water_Source2" id="Water_Source2">
                                            <option value="">-- Select --</option>
                                            <option value="Groundwater">Groundwater</option>
                                            <option value="Surface Water">Surface Water</option>
                                            <option value="Recycled Water">Recycled Water</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Water Consumption (m³)">Water Consumption (m³)</label>                                                   
                                        <input type="number" name="Water_Consumption2">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Water Efficiency Target (%)">Water Efficiency Target (%)</label>                                                   
                                        <input type="number" name="Water_Efficiency_Target">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Recycled Water Usage Target (%)">Recycled Water Usage Target (%)</label>                                                   
                                        <input type="number" name="Recycled_Water_Usage_Target">
                                    </div>
                                </div>

                                <div class="sub-head">
                                    Waste Management
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Waste Type">Waste Type</label>
                                        <select name="Waste_Type" id="Waste_Type">
                                            <option value="">-- Select --</option>
                                            <option value="Hazardous">Hazardous</option>
                                            <option value="Non-Hazardous">Non-Hazardous</option>
                                            <option value="E-Waste">E-Waste</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Waste Quantity (kg)">Waste Quantity (kg)</label>                                                   
                                        <input type="number" name="Waste_Quantity">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Recycling Rate Target (%)">Recycling Rate Target (%)</label>                                                   
                                        <input type="number" name="Recycling_Rate_Target">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Disposal Methods">Disposal Methods</label>
                                        <select name="Disposal_Methods" id="Disposal_Methods">
                                            <option value="">-- Select --</option>
                                            <option value="Landfill">Landfill</option>
                                            <option value="Recycling">Recycling</option>
                                            <option value="Composting">Composting</option>
                                            <option value="Incineration">Incineration</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="sub-head">
                                    Biodiversity
                                </div>                                

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Protected Areas Covered (ha)">Protected Areas Covered (ha)</label>                                                  
                                        <input type="number" name="Protected_Areas_Covered">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Species Monitored">Species Monitored</label>
                                        <div class="relative-container">                                                    
                                            <input type="text" name="Species_Monitored">
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Habitat Restoration Target (ha)">Habitat Restoration Target (ha)</label>                                                
                                        <input type="number" name="Habitat_Restoration_Target">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Biodiversity Index Score">Biodiversity Index Score</label>                                                
                                        <input type="number" name="Biodiversity_Index_Score">
                                    </div>
                                </div>

                                <div class="sub-head">
                                    Sustainable Procurement
                                </div> 
                                
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Supplier Compliance">Supplier Compliance</label>
                                        <select name="Supplier_Compliance" id="Supplier_Compliance">
                                            <option value="">-- Select --</option>
                                            <option value="ISO 14001 Certified">ISO 14001 Certified</option>
                                            <option value="No Certification">No Certification</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Percentage of Sustainable Products (%)">Percentage of Sustainable Products (%)</label>                                                   
                                        <input type="number" name="Percentage_of_Sustainable_Products">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Local Sourcing Target (%)">Local Sourcing Target (%)</label>
                                        <div class="relative-container">                                                    
                                            <input type="text" name="Local_Sourcing_Target">
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="sub-head">
                                    Circular Economy Metrics
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Product Life Extension Target (%)">Product Life Extension Target (%)</label>                                                    
                                        <input type="number" name="Product_Life_Extension_Target">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Material Reusability (%)">Material Reusability (%)</label>                                                  
                                        <input type="number" name="Material_Reusability">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Recycled Material Usage (%)">Recycled Material Usage (%)</label>                                                   
                                        <input type="number" name="Recycled_Material_Usage">
                                    </div>
                                </div>

                                <div class="sub-head">
                                    Policy Alignment
                                </div> 
                                
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="SDG Alignment">SDG Alignment</label>
                                        <select name="SDG_Alignment" id="SDG_Alignment">
                                            <option value="">-- Select --</option>
                                            <option value="SDG 6: Clean Water and Sanitation">SDG 6: Clean Water and Sanitation</option>
                                            <option value="SDG 7: Affordable and Clean Energy">SDG 7: Affordable and Clean Energy</option>
                                            <option value="SDG 12: Responsible Consumption and Production">SDG 12: Responsible Consumption and Production</option>
                                            <option value="SDG 13: Climate Action">SDG 13: Climate Action</option>
                                        </select>
                                    </div>
                                </div> 
                                
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Compliance Status">Compliance Status</label>
                                        <select name="Compliance_Status" id="Compliance_Status">
                                            <option value="">-- Select --</option>
                                            <option value="Compliant">Compliant</option>
                                            <option value="Partially Compliant">Partially Compliant</option>
                                            <option value="Non-Compliant">Non-Compliant</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="sub-head">
                                    Reporting and Monitoring
                                </div> 
                                
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Progress Measurement Frequency">Progress Measurement Frequency</label>
                                        <select name="Progress_Measurement_Frequency" id="Progress_Measurement_Frequency">
                                            <option value="">-- Select --</option>
                                            <option value="Monthly">Monthly</option>
                                            <option value="Quarterly">Quarterly</option>
                                            <option value="Annually">Annually</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Recycled Material Usage (%)">Recycled Material Usage (%)</label>
                                        <div class="relative-container">                                                    
                                            <input type="text" name="Recycled_Material_Usage1">
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Current Progress (%)">Current Progress (%)</label>                                                    
                                        <input type="number" name="Current_Progress">
                                    </div>
                                </div>

                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>
                    <!-- ---- ------ -->

                    <div id="CCForm29" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">Training Programs</label>
                                        <div class="relative-container">                                                    
                                            <input name="training_programs" id="training_programs"></input>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Comments">Employee Involvement</label>
                                        <div class="relative-container">                                                    
                                            <input name="employee_involcement" id="employee_involcement"></input>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Comments">Sustainability Awareness</label>
                                        <div class="relative-container">                                                    
                                            <textarea name="sustainability_awareness" id="sustainability_awareness"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                            
                                
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>
                    <!-- ----- ------- -->

                    <div id="CCForm30" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                
                                
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Impact">Community Projects</label>
                                        <select name="community_project" id="community_project">
                                            <option value="">-- Select --</option>
                                            <option value="Tree Planting">Tree Planting</option>
                                            <option value="Water Conservation">Water Conservation</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Impact">Partnerships</label>
                                        <select name="Partnerships" id="Partnerships">
                                            <option value="">-- Select --</option>
                                            <option value="Collaboration With NGOs">Collaboration With NGOs</option>
                                            <option value="Government Bodies">Government Bodies</option>
                                            <option value="Other Organizations">Other Organizations</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Impact">Social Impact</label>
                                        <select name="social_impact" id="social_impact">
                                            <option value="">-- Select --</option>
                                            <option value="Social Equity">Social Equity</option>
                                            <option value="Diversity">Diversity</option>
                                            <option value="Local Development">Local Development</option>
                                        </select>
                                    </div>
                                </div>
                                

                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <!-- Activity Log content -->
                    <div id="CCForm31" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Submit By">Submit By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Submit On">Submit On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Submit Comment">Submit Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Cancel By">Cancel By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Cancel On">Cancel On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Cancel Comment">Cancel Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Review Complete By">Review Complete By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Review Complete On">Review Complete On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Review Complete Comment">Review Complete Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="More Information Required By">More Information Required By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="More Information Required On">More Information Required On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="More Information Required Comment">More Information Required Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Cancel By">Cancel By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Cancel On">Cancel On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Cancel Comment">Cancel Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Complete Investigation By">Complete Investigation By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Complete Investigation On">Complete Investigation On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Complete Investigation Comment">Complete Investigation Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="More Investigation Required By">More Investigation Required By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="More Investigation Required On">More Investigation Required On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="More Investigation Required Comment">More Investigation Required Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Analysis Complete By">Analysis Complete By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Analysis Complete On">Analysis Complete On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Analysis Complete Comment">Analysis Complete Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Training Required By">Training Required By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Training Required On">Training Required On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Training Required Comment">Training Required Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Training Complete By">Training Complete By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Training Complete On">Training Complete On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Training Complete Comment">Training Complete Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Propose Plan By">Propose Plan By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Propose Plan On">Propose Plan On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Propose Plan Comment">Propose Plan Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Reject By">Reject By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Reject On">Reject On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Reject Comment">Reject Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Approve Plan By">Approve Plan By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Approve Plan On">Approve Plan On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Approve Plan Comment">Approve Plan Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="More Information Required By">More Information Required By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="More Information Required On">More Information Required On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="More Information Required Comment">More Information Required Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="All CAPA Closed By">All CAPA Closed By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="All CAPA Closed On">All CAPA Closed On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="All CAPA Closed Comment">All CAPA Closed Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>

                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
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


    <style>
        #step-form>div {
            display: none
        }

        #step-form>div:nth-child(1) {
            display: block;
        }
    </style>
   <script>
    $(document).ready(function() {
        $('#root-cause-methodology').on('change', function() {
            var selectedValues = $(this).val();
            $('#why-why-chart-section').hide();
            $('#fmea-section').hide();
            $('#fishbone-section').hide();
            $('#HideInference').hide();
            $('#is-is-not-section').hide();
            $('#root-cause-others').hide();

            if (selectedValues.includes('Why-Why Chart')) {
                $('#why-why-chart-section').show();
            }
            if (selectedValues.includes('Failure Mode and Effect Analysis')) {
                $('#fmea-section').show();
            }
            if (selectedValues.includes('Fishbone or Ishikawa Diagram')) {
                $('#fishbone-section').show();
                $('#HideInference').show();
            }
            if (selectedValues.includes('Is/Is Not Analysis')) {
                $('#is-is-not-section').show();
            }
            if (selectedValues.includes('Rootcauseothers')) {
                $('#root-cause-others').show();
            }
        });
    });
</script>

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
            ele: '#Facility, #Group, #Audit, #Auditee ,#reference_record, #root-cause-methodology'
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
        // document.addEventListener('DOMContentLoaded', function() {
        //     document.getElementById('type_of_audit').addEventListener('change', function() {
        //         var typeOfAuditReqInput = document.getElementById('type_of_audit_req');
        //         if (typeOfAuditReqInput) {
        //             var selectedValue = this.value;
        //             if (selectedValue == 'others') {
        //                 typeOfAuditReqInput.setAttribute('required', 'required');
        //             } else {
        //                 typeOfAuditReqInput.removeAttribute('required');
        //             }
        //         } else {
        //             console.error("Element with id 'type_of_audit_req' not found");
        //         }
        //     });
        // });
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
            $('#rchars').text(textlen);});
    </script>
    <script>
        function calculateRiskAnalysis(type) {
            const probability = parseInt(document.getElementById(type + 'Probability').value);
            const severity = parseInt(document.getElementById(type + 'Severity').value);
            
            if (!isNaN(probability) && !isNaN(severity)) {
                const risk = probability * severity;
                
                // Mapping risk values to their corresponding descriptions
                let riskDescription = '';
                switch (risk) {
                    case 1:
                        riskDescription = '1: Acceptable';
                        break;
                    case 2:
                        riskDescription = '2: Mostly Acceptable';
                        break;
                    case 3:
                        riskDescription = '3: Tolerable';
                        break;
                    case 4:
                        riskDescription = '4: Tolerable';
                        break;
                    case 6:
                        riskDescription = '6: Mostly Unacceptable';
                        break;
                    case 9:
                        riskDescription = '9: Unacceptable';
                        break;
                    default:
                        riskDescription = 'Out of Range';
                }
                
                document.getElementById(type + 'Risk').value = riskDescription;
            } else {
                // Clear the field if selections are incomplete
                document.getElementById(type + 'Risk').value = '';
            }
        }
    </script>
    <script>
        function calculateRiskAnalysis2() {
            // Get the values of Severity Rate, Occurrence, and Detection
            const severity = document.getElementById("analysisR").value;
            const occurrence = document.getElementById("analysisP").value;
            const detection = document.getElementById("analysisN").value;
        
            // Ensure all values are selected and not empty
            if (severity && occurrence && detection) {
                // Calculate RPN by multiplying the values
                const rpn = parseInt(severity) * parseInt(occurrence) * parseInt(detection);
                // Set the calculated RPN value in the input field
                document.getElementById("analysisRPN").value = rpn;
            } else {
                // If any value is missing, clear the RPN field
                document.getElementById("analysisRPN").value = '';
            }
        }
        </script>
        <script>
            function addWhyField(con_class, name) {
                let mainBlock = document.querySelector('.why-why-chart')
                let container = mainBlock.querySelector(`.${con_class}`)
                let textarea = document.createElement('textarea')
                textarea.setAttribute('name', name);
                container.append(textarea)
            }
        </script>
        <script>
            function addInference(tableId) {
            var table = document.getElementById(tableId);
            var currentRowCount = table.rows.length;
            var newRow = table.insertRow(currentRowCount);
            newRow.setAttribute("id", "row" + currentRowCount);
            var cell1 = newRow.insertCell(0);
            cell1.innerHTML = currentRowCount;

            var cell2 = newRow.insertCell(1);
            cell2.innerHTML =
                "<select name='inference_type[]'><option value=''>-- Select --</option><option value='Measurement'>Measurement</option><option value='Materials'>Materials</option><option value='Methods'>Methods</option><option value='Mother Environment'>Mother Environment</option><option value='Man'>Man</option><option value='Machine'>Machine</option></select>";


            var cell3 = newRow.insertCell(2);
            cell3.innerHTML = "<input type='text' name='inference_remarks[]'>";

            let cell4 = newRow.insertCell(3);
            cell4.innerHTML = "<button type='text' class='removeRowBtn' name='Action[]' readonly>Remove</button>";

            for (var i = 1; i < currentRowCount; i++) {
                var row = table.rows[i];
                row.cells[0].innerHTML = i;
            }
        }
        </script>
        <script>
            function calculateInitialResult(selectElement) {
                let row = selectElement.closest('tr');
                let R = parseFloat(row.querySelector('.fieldR').value) || 0;
                let P = parseFloat(row.querySelector('.fieldP').value) || 0;
                let N = parseFloat(row.querySelector('.fieldN').value) || 0;
                let result = R * P * N;
                row.querySelector('.initial-rpn').value = result;
            }
        </script>
    
        <script>
            function calculateResidualResult(selectElement) {
                let row = selectElement.closest('tr');
                let R = parseFloat(row.querySelector('.residual-fieldR').value) || 0;
                let P = parseFloat(row.querySelector('.residual-fieldP').value) || 0;
                let N = parseFloat(row.querySelector('.residual-fieldN').value) || 0;
                let result = R * P * N;
                row.querySelector('.residual-rpn').value = result;
            }
        </script>
        <script>
            function addRootCauseAnalysisRiskAssessment(tableId) {
            var table = document.getElementById(tableId);
            var currentRowCount = table.children[1].rows.length;
            var newRow = table.children[1].insertRow(currentRowCount);
            newRow.setAttribute("id", "row" + currentRowCount);
            var cell1 = newRow.insertCell(0);
            cell1.innerHTML = currentRowCount + 1;

            var cell2 = newRow.insertCell(1);
            cell2.innerHTML = "<input name='risk_factor[]' type='text'>";

            var cell3 = newRow.insertCell(2);
            cell3.innerHTML = "<input name='risk_element[]' type='text'>";

            var cell4 = newRow.insertCell(3);
            cell4.innerHTML = "<input name='problem_cause[]' type='text'>";

            // var cell5 = newRow.insertCell(4);
            // cell5.innerHTML = "<input name='existing_risk_control[]' type='text'>";

            var cell5 = newRow.insertCell(4);
            cell5.innerHTML =
                "<select onchange='calculateInitialResult(this)' class='fieldR' name='initial_severity[]'><option value=''>-- Select --</option><option value='1'>1-Insignificant</option><option value='2'>2-Minor</option><option value='3'>3-Major</option><option value='4'>4-Critical</option><option value='5'>5-Catastrophic</option></select>";
                // "<input name='initial_severity[]' type='text'>";


            var cell6 = newRow.insertCell(5);
            cell6.innerHTML =
                "<select onchange='calculateInitialResult(this)' class='fieldP' name='initial_probability[]'><option value=''>-- Select --</option><option value='1'>1-Very rare</option><option value='2'>2-Unlikely</option><option value='3'>3-Possibly</option><option value='4'>4-Likely</option><option value='5'>5-Almost certain (every time)</option></select>";

            var cell7 = newRow.insertCell(6);
            cell7.innerHTML =
                "<select onchange='calculateInitialResult(this)' class='fieldN' name='initial_detectability[]'><option value=''>-- Select --</option><option value='1'>1-Always detected</option><option value='2'>2-Likely to detect</option><option value='3'>3-Possible to detect</option><option value='4'>4-Unlikely to detect</option><option value='5'>5-Not detectable</option></select>";

            var cell8 = newRow.insertCell(7);
            cell8.innerHTML = "<input name='initial_rpn[]' type='text' class='initial-rpn' readonly>";

            // var cell10 = newRow.insertCell(9);
            // cell10.innerHTML =
            //     "<select name='risk_acceptance[]'><option value=''>-- Select --</option><option value='N'>N</option><option value='Y'>Y</option></select>";

            var cell19 = newRow.insertCell(8);
            cell19.innerHTML = "<input name='risk_control_measure[]' type='text'>";

            var cell10 = newRow.insertCell(9);
            cell10.innerHTML =
                "<select onchange='calculateResidualResult(this)' class='residual-fieldR' name='residual_severity[]'><option value=''>-- Select --</option><option value='1'>1-Insignificant</option><option value='2'>2-Minor</option><option value='3'>3-Major</option><option value='4'>4-Critical</option><option value='5'>5-Catastrophic</option></select>";

            var cell11 = newRow.insertCell(10);
            cell11.innerHTML =
                "<select onchange='calculateResidualResult(this)' class='residual-fieldP' name='residual_probability[]'><option value=''>-- Select --</option><option value='1'>1-Very rare</option><option value='2'>2-Unlikely</option><option value='3'>3-Possibly</option><option value='4'>4-Likely</option><option value='5'>5-Almost certain (every time)</option></select>";

            var cell12 = newRow.insertCell(11);
            cell12.innerHTML =
                "<select onchange='calculateResidualResult(this)' class='residual-fieldN' name='residual_detectability[]'><option value=''>-- Select --</option><option value='1'>1-Always detected</option><option value='2'>2-Likely to detect</option><option value='3'>3-Possible to detect</option><option value='4'>4-Unlikely to detect</option><option value='5'>5-Not detectable</option></select>";

            var cell13 = newRow.insertCell(12);
            cell13.innerHTML = "<input name='residual_rpn[]' type='text' class='residual-rpn' readonly>";
            var cell14 = newRow.insertCell(13);
            cell14.innerHTML =
                "<select name='risk_acceptance[]' class='risk-acceptance' readonly>" +
                "<option value=''>-- Select --</option>" +
                "<option value='Low'>Low</option>" +
                "<option value='Medium'>Medium</option>" +
                "<option value='High'>High</option>" +
                "</select>";

            var cell15 = newRow.insertCell(14);
            cell15.innerHTML =
                "<select name='risk_acceptance2[]'><option value=''>-- Select --</option><option value='N'>N</option><option value='Y'>Y</option></select>";

            var cell16 = newRow.insertCell(15);
            cell16.innerHTML = "<input name='mitigation_proposal[]' type='text'>";

            var cell17 = newRow.insertCell(16);
            cell17.innerHTML = "<button type='text' class='removeRowBtn' name='Action[]' readonly>Remove</button>";

            for (var i = 0; i < currentRowCount-1; i++) {
                var row = table.children[1].rows[i];
                row.cells[0].innerHTML = i+1;
            }
            }
        </script>
        <script>
            function addFishBone(top, bottom) {
                let mainBlock = document.querySelector('.fishbone-ishikawa-diagram');
                let topBlock = mainBlock.querySelector(top)
                let bottomBlock = mainBlock.querySelector(bottom)
    
                let topField = document.createElement('div')
                topField.className = 'grid-field fields top-field'
    
                let measurement = document.createElement('div')
                let measurementInput = document.createElement('input')
                measurementInput.setAttribute('type', 'text')
                measurementInput.setAttribute('name', 'measurement[]')
                measurement.append(measurementInput)
                topField.append(measurement)
    
                let materials = document.createElement('div')
                let materialsInput = document.createElement('input')
                materialsInput.setAttribute('type', 'text')
                materialsInput.setAttribute('name', 'materials[]')
                materials.append(materialsInput)
                topField.append(materials)
    
                let methods = document.createElement('div')
                let methodsInput = document.createElement('input')
                methodsInput.setAttribute('type', 'text')
                methodsInput.setAttribute('name', 'methods[]')
                methods.append(methodsInput)
                topField.append(methods)
    
                topBlock.prepend(topField)
    
                let bottomField = document.createElement('div')
                bottomField.className = 'grid-field fields bottom-field'
    
                let environment = document.createElement('div')
                let environmentInput = document.createElement('input')
                environmentInput.setAttribute('type', 'text')
                environmentInput.setAttribute('name', 'environment[]')
                environment.append(environmentInput)
                bottomField.append(environment)
    
                let manpower = document.createElement('div')
                let manpowerInput = document.createElement('input')
                manpowerInput.setAttribute('type', 'text')
                manpowerInput.setAttribute('name', 'manpower[]')
                manpower.append(manpowerInput)
                bottomField.append(manpower)
    
                let machine = document.createElement('div')
                let machineInput = document.createElement('input')
                machineInput.setAttribute('type', 'text')
                machineInput.setAttribute('name', 'machine[]')
                machine.append(machineInput)
                bottomField.append(machine)
    
                bottomBlock.append(bottomField)
            }
    
            function deleteFishBone(top, bottom) {
                let mainBlock = document.querySelector('.fishbone-ishikawa-diagram');
                let topBlock = mainBlock.querySelector(top)
                let bottomBlock = mainBlock.querySelector(bottom)
                if (topBlock.firstChild) {
                    topBlock.removeChild(topBlock.firstChild);
                }
                if (bottomBlock.lastChild) {
                    bottomBlock.removeChild(bottomBlock.lastChild);
                }
            }
        </script>

        <script>
           function addRootRiskAssessment(tableId) {
            var table = document.getElementById(tableId);
            var currentRowCount = table.rows.length;
            var newRow = table.insertRow(currentRowCount);
            newRow.setAttribute("id", "row" + currentRowCount);
            var cell1 = newRow.insertCell(0);
            cell1.innerHTML = currentRowCount;

            var cell2 = newRow.insertCell(1);
            cell2.innerHTML = "<input name='risk_factor1[]' type='text'>";

            var cell3 = newRow.insertCell(2);
            cell3.innerHTML = "<input name='risk_element1[]' type='text'>";

            var cell4 = newRow.insertCell(3);
            cell4.innerHTML = "<input name='problem_cause1[]' type='text'>";

            var cell5 = newRow.insertCell(4);
            cell5.innerHTML = "<input name='existing_risk_control1[]' type='text'>";

            var cell6 = newRow.insertCell(5);
            cell6.innerHTML =
                "<select onchange='calculateInitialResult(this)' class='fieldR' name='initial_severity1[]'><option value=''>-- Select --</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>";

            var cell7 = newRow.insertCell(6);
            cell7.innerHTML =
                "<select onchange='calculateInitialResult(this)' class='fieldP' name='initial_probability1[]'><option value=''>-- Select --</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>";

            var cell8 = newRow.insertCell(7);
            cell8.innerHTML =
                "<select onchange='calculateInitialResult(this)' class='fieldN' name='initial_detectability1[]'><option value=''>-- Select --</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>";

            var cell9 = newRow.insertCell(8);
            cell9.innerHTML = "<input name='initial_rpn1[]' type='text' class='initial-rpn'  >";

            var cell10 = newRow.insertCell(9);
            cell10.innerHTML =
                "<select name='risk_acceptance1[]'><option value=''>-- Select --</option><option value='N'>N</option><option value='Y'>Y</option></select>";

            var cell11 = newRow.insertCell(10);
            cell11.innerHTML = "<input name='risk_control_measure1[]' type='text'>";

            var cell12 = newRow.insertCell(11);
            cell12.innerHTML =
                "<select onchange='calculateResidualResult(this)' class='residual-fieldR' name='residual_severity1[]'><option value=''>-- Select --</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>";

            var cell13 = newRow.insertCell(12);
            cell13.innerHTML =
                "<select onchange='calculateResidualResult(this)' class='residual-fieldP' name='residual_probability1[]'><option value=''>-- Select --</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>";

            var cell14 = newRow.insertCell(13);
            cell14.innerHTML =
                "<select onchange='calculateResidualResult(this)' class='residual-fieldN' name='residual_detectability1[]'><option value=''>-- Select --</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>";

            var cell15 = newRow.insertCell(14);
            cell15.innerHTML = "<input name='residual_rpn1[]' type='text' class='residual-rpn' >";

            var cell16 = newRow.insertCell(15);
            cell16.innerHTML =
                "<select name='risk_acceptance3[]'><option value=''>-- Select --</option><option value='N'>N</option><option value='Y'>Y</option></select>";

            var cell17 = newRow.insertCell(16);
            cell17.innerHTML = "<input name='mitigation_proposal1[]' type='text'>";

            var cell18 = newRow.insertCell(17);
            cell18.innerHTML = "<button type='text' class='removeRowBtn' name='Action[]' readonly>Remove</button>";

            for (var i = 1; i < currentRowCount; i++) {
                var row = table.rows[i];
                row.cells[0].innerHTML = i;
            }
        }

        </script>
        
@endsection
