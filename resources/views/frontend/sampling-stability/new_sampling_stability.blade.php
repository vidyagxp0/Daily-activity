@extends('frontend.layout.main')
@section('container')
    @php
        $users = DB::table('users')->select('id', 'name')->get();
        $locations = DB::table('q_m_s_divisions')->select('id', 'name')->get();

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
        .mini-modal {
            display: none;
            position: absolute;
            z-index: 1;
            padding: 10px;
            background-color: #fefefe;
            border: 1px solid #888;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 200px;
            /* Adjust width as needed */
        }
        #change-control-fields .inner-block .group-input table input, #change-control-fields .inner-block .group-input table select{
            border: 1px solid black;
            padding: 4px
        }

        .mini-modal-content {
            background-color: #fefefe;
            padding: 10px;
            border-radius: 4px;
        }

        .mini-modal-content h2 {
            font-size: 16px;
            margin-top: 0;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
        }
    </style>
    <div class="mini-modal">
        <div class="mini-modal-content">
            <span class="close">&times;</span>
            <h2>Select Language</h2>
            <select id="language-select">
                <option value="en-us">English</option>
                <option value="hi-in">Hindi</option>
                <option value="te-in">Telugu</option>
                <option value="fr-fr">French</option>
                <option value="es-es">Spanish</option>
                <option value="zh-cn">Chinese (Mandarin)</option>
                <option value="ja-jp">Japanese</option>
                <option value="de-de">German</option>
                <option value="ru-ru">Russian</option>
                <option value="ko-kr">Korean</option>
                <option value="it-it">Italian</option>
                <option value="pt-br">Portuguese (Brazil)</option>
                <option value="ar-sa">Arabic</option>
                <option value="bn-in">Bengali</option>
                <option value="pa-in">Punjabi</option>
                <option value="mr-in">Marathi</option>
                <option value="gu-in">Gujarati</option>
                <option value="ur-pk">Urdu</option>
                <option value="ta-in">Tamil</option>
                <option value="kn-in">Kannada</option>
                <option value="ml-in">Malayalam</option>
                <option value="or-in">Odia</option>
                <option value="as-in">Assamese</option>
                <!-- Add more languages as needed -->
            </select>
            <button id="select-language-btn">Select</button>
        </div>
    </div>
    </div>
    </div>
    </div>



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

    @php
        $division = DB::table('divisions')->get();
    @endphp

    <div class="form-field-head">

        <div class="division-bar">
            <strong>Site Division/Project</strong> :
            {{ Helpers::getDivisionName(session()->get('division')) }} / Stability Management
        </div>
    </div>
    <div id="change-control-fields">
        <div class="container-fluid">

            <!-- Tab links -->
            <div class="cctab">
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Sample Registration</button>
                <!-- <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Sample Analysis</button> -->
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Supervisor Review</button>
                <!-- <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Stability Information</button> -->
                <button class="cctablinks" onclick="openCity(event, 'CCForm5')">QA Review</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Activity Log</button>
            </div>

            <div class="language-sleect d-flex" style="align-items: center; gap: 20px; margin-left: 20px;">
                <div style="margin-bottom:29px;">Select Language </div>
                <div class="main-head" id="google_translate_element"></div>
            </div>

            <script type="text/javascript">
                function googleTranslateElementInit() {
                    new google.translate.TranslateElement({
                        pageLanguage: 'en',
                        includedLanguages: 'en,es,fr,de,zh,hi,ar,pt,ja,ru',
                        layout: google.translate.TranslateElement.InlineLayout.SIMPLE
                    }, 'google_translate_element');
                }
            </script>
            <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
            </script>
            <script>
                $(document).ready(function() {
                    setTimeout(() => {
                        $('body').css('top', '0');
                    }, 5000);
                })
            </script>
            <form id="auditform" class="mainform" action="{{ route('store-stability-management') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <div id="step-form">

                    <!-- General information content -->
                    <div id="CCForm1" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>Record Number</b></label>
                                        <input disabled type="text" name="record_number"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}/Stability Management/{{ date('Y') }}/{{ $record_number }}">
                                        <input type="hidden" name="recordNumber"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}/Stability Management/{{ date('Y') }}/{{ $record_number }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Location/Lab Code</b></label>
                                        <input disabled type="text"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                        <input type="hidden" name="division_id"
                                            value="{{ session()->get('division') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator"><b>Initiator</b></label>
                                        <input disabled type="text" value="{{ Auth::user()->name }}">

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input ">
                                        <label for="Due Date"><b>Date of Initiation</b></label>
                                        <input readonly type="text" value="{{ date('d-M-Y') }}"
                                            name="intiation_date">
                                        <input type="hidden" value="{{ date('d-m-Y') }}" name="intiation_date">
                                    </div>
                                </div>
                                <!-- <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            Assigned To <span class="text-danger"></span>
                                        </label>
                                        <select id="select-state" placeholder="Select..." name="assign_to">
                                            <option value="">Select a value</option>
                                            @foreach ($users as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('assign_to')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div> -->

                                @php
                                    $initiationDate = date('Y-m-d');
                                    $dueDate = date('Y-m-d', strtotime($initiationDate . '+30 days'));
                                @endphp

                                <div class="col-md-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="due-date"> Due Date</label>
                                        <div><small class="text-primary">Please mention expected date of completion</small>
                                        </div>
                                        <!-- <div class="calenderauditee"> -->
                                        <div class="calenderauditee">
                                            <input type="text" id="due_date" name="due_date" readonly
                                                placeholder="DD-MM-YYYY" />
                                            <input type="date" readonly name="due_date_n"
                                                min="{{ \Carbon\Carbon::now()->format('d-M-Y') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'due_date')" />
                                        </div>
                                        <!-- </div> -->
                                    </div>
                                </div>

                                <script>
                                    // Format the due date to DD-MM-YYYY
                                    // Your input date
                                    var dueDate = "{{ $dueDate }}"; // Replace {{ $dueDate }} with your actual date variable

                                    // Create a Date object
                                    var date = new Date(dueDate);

                                    // Array of month names
                                    var monthNames = [
                                        "Jan", "Feb", "Mar", "Apr", "May", "Jun",
                                        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
                                    ];

                                    // Extracting day, month, and year from the date
                                    var day = date.getDate().toString().padStart(2, '0'); // Ensuring two digits
                                    var monthIndex = date.getMonth();
                                    var year = date.getFullYear();

                                    // Formatting the date in "DD-MM-YYYY" format
                                    var dueDateFormatted = `${day}-${monthNames[monthIndex]}-${year}`;

                                    // Set the formatted due date value to the input field
                                    document.getElementById('due_date').value = dueDateFormatted;
                                </script>


                                <!-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator Group"><b>Initiator Group</b></label>
                                        <select name="Initiator_Group" id="initiator_group">
                                            <option value="">-- Select --</option>
                                            <option value="CQA" @if (old('Initiator_Group', $data->Initiator_Group ?? '') == 'CQA') selected @endif>
                                                Corporate Quality Assurance</option>
                                            <option value="QAB" @if (old('Initiator_Group', $data->Initiator_Group ?? '') == 'QAB') selected @endif>
                                                Quality Assurance Biopharma</option>
                                            <option value="CQC" @if (old('Initiator_Group', $data->Initiator_Group ?? '') == 'CQC') selected @endif>
                                                Central Quality Control</option>
                                            <option value="MANU" @if (old('Initiator_Group', $data->Initiator_Group ?? '') == 'MANU') selected @endif>
                                                Manufacturing</option>
                                            <option value="PSG" @if (old('Initiator_Group', $data->Initiator_Group ?? '') == 'PSG') selected @endif>Plasma
                                                Sourcing Group</option>
                                            <option value="CS" @if (old('Initiator_Group', $data->Initiator_Group ?? '') == 'CS') selected @endif>
                                                Central Stores</option>
                                            <option value="ITG" @if (old('Initiator_Group', $data->Initiator_Group ?? '') == 'ITG') selected @endif>
                                                Information Technology Group</option>
                                            <option value="MM" @if (old('Initiator_Group', $data->Initiator_Group ?? '') == 'MM') selected @endif>
                                                Molecular Medicine</option>
                                            <option value="CL" @if (old('Initiator_Group', $data->Initiator_Group ?? '') == 'CL') selected @endif>
                                                Central Laboratory</option>
                                            <option value="TT" @if (old('Initiator_Group', $data->Initiator_Group ?? '') == 'TT') selected @endif>Tech
                                                team</option>
                                            <option value="QA" @if (old('Initiator_Group', $data->Initiator_Group ?? '') == 'QA') selected @endif>
                                                Quality Assurance</option>
                                            <option value="QM" @if (old('Initiator_Group', $data->Initiator_Group ?? '') == 'QM') selected @endif>
                                                Quality Management</option>
                                            <option value="IA" @if (old('Initiator_Group', $data->Initiator_Group ?? '') == 'IA') selected @endif>IT
                                                Administration</option>
                                            <option value="ACC" @if (old('Initiator_Group', $data->Initiator_Group ?? '') == 'ACC') selected @endif>
                                                Accounting</option>
                                            <option value="LOG" @if (old('Initiator_Group', $data->Initiator_Group ?? '') == 'LOG') selected @endif>
                                                Logistics</option>
                                            <option value="SM" @if (old('Initiator_Group', $data->Initiator_Group ?? '') == 'SM') selected @endif>
                                                Senior Management</option>
                                            <option value="BA" @if (old('Initiator_Group', $data->Initiator_Group ?? '') == 'BA') selected @endif>
                                                Business Administration</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator Group Code">Initiator Group Code</label>
                                        <input type="text" name="initiator_group_code" id="initiator_group_code"
                                            value="" readonly>
                                    </div>
                                </div> -->

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="short_description">Short Description<span
                                                class="text-danger">*</span></label>
                                        <span id='rchars' class="text-primary">255<span> characters remaining
                                                <div class="relative-container">
                                                    <input id="short_description" id="docname" type="text"
                                                        class="mic-input" name="short_description" maxlength="255"
                                                        required>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="audit-agenda-grid">
                                            Stability Management<button type="button" name="audit-agenda-grid"
                                                id="addSamplePlanning">+</button>
                                        </label>
                                        <div class="responsive-table" style="overflow-x: auto;  width: 100% !important;">
                                            <table class="table table-bordered" id="addSamplePlanningTable"style="">
                                                <thead>
                                                    <tr>
                                                        <th colspan="35" style="background: rgb(0, 191, 255);">Sample Registration</th>
                                                        <th colspan="39" style="background: rgb(255, 102, 102);">Sample Analysis</th>
                                                        <th colspan="10" style="background: rgb(52, 162, 143);">Stability Information</th>
                                                        <th colspan="5" style="background: rgb(255, 232, 91);">Supervisor Review</th>
                                                        <th colspan="9" style="background: rgb(120, 148, 255);">QA Review</th>
                                                    </tr>
                                                    <tr>
                                                        <th><div style="min-width: 200px;">Sample Plan ID</div></th>
                                                        <th><div style="min-width: 200px;">Sample Plan</div></th>
                                                        <th><div style="min-width: 200px;">Sample Name</div></th>
                                                        <th><div style="min-width: 200px;">Sample Type</div></th>
                                                        <th><div style="min-width: 200px;">Product / Material Name</div></th>
                                                        <th><div style="min-width: 200px;">Product / Material Code</div></th>
                                                        <th><div style="min-width: 100px;">Batch/Lot Number</div></th>
                                                        <th><div style="min-width: 200px;">Sample Priority</div></th>
                                                        <th><div style="min-width: 150px;">Sample Quantity</div></th>
                                                        <th><div style="min-width: 150px;">Quantity Withdrawn</div></th>
                                                        <th><div style="min-width: 150px;">Current Quantity</div></th>
                                                        <th><div style="min-width: 200px;">UOM</div></th>
                                                        <th><div style="min-width: 200px;">Market</div></th>
                                                        <th><div style="min-width: 200px;">Specification ID</div></th>
                                                        <th><div style="min-width: 200px;">Specification Attachment</div></th>
                                                        <th><div style="min-width: 200px;">STP ID</div></th>
                                                        <th><div style="min-width: 200px;">STP Attachment</div></th>
                                                        <th><div style="min-width: 200px;">Test Name</div></th>
                                                        <th><div style="min-width: 200px;">Test Method</div></th>
                                                        <th><div style="min-width: 200px;">Test Parameters</div></th>
                                                        <th><div style="min-width: 200px;">Testing Frequency</div></th>
                                                        <th><div style="min-width: 200px;">Testing Location</div></th>
                                                        <th><div style="min-width: 100px;">LSL</div></th>
                                                        <th><div style="min-width: 100px;">USL</div></th>
                                                        <th><div style="min-width: 200px;">Testing Deadline</div></th>
                                                        <th><div style="min-width: 200px;">Planner Name</div></th>
                                                        <th><div style="min-width: 200px;">Sample Source</div></th>
                                                        <th><div style="min-width: 200px;">Planned Date</div></th>
                                                        <th><div style="min-width: 200px;">Start Date</div></th>
                                                        <th><div style="min-width: 300px;">Delay Justification</div></th>
                                                        <th><div style="min-width: 200px;">Lab Technician</div></th>
                                                        <th><div style="min-width: 200px;">Sample Cost Estimation</div></th>
                                                        <th><div style="min-width: 200px;">Resource Utilization</div></th>
                                                        <th><div style="min-width: 200px;">Sample Collection Date</div></th>
                                                        <th><div style="min-width: 200px;">Supporting Documents</div></th>


                                                        <th><div style="min-width: 200px;">Analysis Type</div></th>
                                                        <th><div style="min-width: 100px;">Result</div></th>
                                                        <th><div style="min-width: 200px;">Analysis Result</div></th>
                                                        <th><div style="min-width: 200px;">Analyst</div></th>
                                                        <th><div style="min-width: 200px;">Reagent</div></th>
                                                        <th><div style="min-width: 200px;">Testing Start Date</div></th>
                                                        <th><div style="min-width: 200px;">Testing End Date</div></th>
                                                        <th><div style="min-width: 100px;">Analysis Status</div></th>
                                                        <th><div style="min-width: 100px;">Pass/Fail</div></th>
                                                        <th><div style="min-width: 300px;">Instruction for Other Analyst</div></th>
                                                        <th><div style="min-width: 100px;">Test Plan Id</div></th>
                                                        <th><div style="min-width: 200px;">Turnaround Time (TAT)</div></th>
                                                        <th><div style="min-width: 200px;">Sample Retesting Date</div></th>
                                                        <th><div style="min-width: 200px;">Review Due Date</div></th>
                                                        <th><div style="min-width: 200px;">Sample Storage Location</div></th>
                                                        <th><div style="min-width: 200px;">Transportation Method</div></th>
                                                        <th><div style="min-width: 300px;">Sample Preparation Method</div></th>
                                                        <th><div style="min-width: 300px;">Sample Packaging Details</div></th>
                                                        <th><div style="min-width: 200px;">Sample Label</div></th>
                                                        <th><div style="min-width: 300px;">Regulatory Requirements</div></th>
                                                        <th><div style="min-width: 200px;">Quality Control Checks</div></th>
                                                        <th><div style="min-width: 200px;">Control Sample Reference</div></th>
                                                        <th><div style="min-width: 200px;">Control Sample</div></th>
                                                        <th><div style="min-width: 200px;">Reference Sample</div></th>
                                                        <th><div style="min-width: 200px;">Sample Integrity Status</div></th>
                                                        <th><div style="min-width: 200px;">Assigned Department</div></th>
                                                        <th><div style="min-width: 200px;">Risk Assessment</div></th>
                                                        <th><div style="min-width: 200px;">Supervisor</div></th>
                                                        <th><div style="min-width: 350px;">Instruments Reserved</div></th>
                                                        <th><div style="min-width: 200px;">Lab Availability</div></th>
                                                        <th><div style="min-width: 200px;">Sample Date</div></th>
                                                        <th><div style="min-width: 200px;">Sample Movement History</div></th>
                                                        <th><div style="min-width: 200px;">Testing Progress</div></th>
                                                        <th><div style="min-width: 200px;">Alerts/Notifications</div></th>
                                                        <th><div style="min-width: 200px;">Deviation Logs</div></th>
                                                        <th><div style="min-width: 200px;">Comments/Notes</div></th>
                                                        <th><div style="min-width: 200px;">Attachment</div></th>
                                                        <th><div style="min-width: 200px;">Sampling Frequency</div></th>
                                                        <th><div style="min-width: 200px;">Stability Study Type</div></th>
                                                        <th><div style="min-width: 200px;">Supporting Documents</div></th>

                                                        <!-- Stability Review -->
                                                        <th><div style="min-width: 200px;">Stability Status</div></th>
                                                        <th><div style="min-width: 200px;">Stability Study Protocol</div></th>
                                                        <th><div style="min-width: 200px;">Stability Protocol Approval Date</div></th>
                                                        <th><div style="min-width: 200px;">Country of Regulatory Submissions</div></th>
                                                        <th><div style="min-width: 200px;">ICH Zone</div></th>
                                                        <th><div style="min-width: 200px;">Photostability Testing Results</div></th>
                                                        <th><div style="min-width: 200px;">Reconstitution Stability</div></th>
                                                        <th><div style="min-width: 200px;">Testing Interval (Months)</div></th>
                                                        <th><div style="min-width: 200px;">Shelf Life Recommendation</div></th>
                                                        <th><div style="min-width: 200px;">Stability Attachment</div></th>


                                                        <!-- Supervisor Review -->
                                                        <th><div style="min-width: 200px;">Reviewer/Approver</div></th>
                                                        <th><div style="min-width: 200px;">Sample Desposion</div></th>
                                                        <th><div style="min-width: 300px;">Reviewer Comment</div></th>
                                                        <th><div style="min-width: 200px;">Review Date</div></th>
                                                        <th><div style="min-width: 200px;">Supervisor Attachment</div></th>


                                                        <!-- QA Review -->
                                                        <th><div style="min-width: 200px;">QA Reviewer/Approver</div></th>
                                                        <th><div style="min-width: 300px;">QA Reviewer Comment</div></th>
                                                        <th><div style="min-width: 200px;">QA Review Date</div></th>
                                                        <th><div style="min-width: 200px;">QA Attachment</div></th>

                                                        <th><div style="min-width: 200px;">Destruction Due On</div></th>
                                                        <th><div style="min-width: 200px;">Destruction Date</div></th>
                                                        <th><div style="min-width: 200px;">Destricted By</div></th>
                                                        <th><div style="min-width: 300px;">Remarks</div></th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <input type="number"
                                                                name="samplePlanningData[0][samplePlanId]" value="1001" readonly>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="samplePlanningData[0][samplePlan]">
                                                        </td>
                                                        <td>
                                                            <input type="text"
                                                                name="samplePlanningData[0][samplePlanName]">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="samplePlanningData[0][sampleType]">
                                                        </td>
                                                        <td>
                                                            <input type="text"
                                                                name="samplePlanningData[0][productmaterial]">
                                                        </td>
                                                        <td>
                                                            <input type="text"
                                                                name="samplePlanningData[0][productmaterialCode]">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="samplePlanningData[0][batchNumber]">
                                                        </td>
                                                        <td>
                                                            <select name="samplePlanningData[0][samplePriority]">
                                                                <option value="">Select Priority</option>
                                                                <option value="High">High</option>
                                                                <option value="Medium">Medium</option>
                                                                <option value="Low">Low</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="number"
                                                                name="samplePlanningData[0][sampleQuantity]" class="sampleQuantity">
                                                        </td>
                                                        <td>
                                                            <input type="number"
                                                                name="samplePlanningData[0][quantityWithdrawn]" class="quantityWithdrawn">
                                                        </td>
                                                        <td>
                                                            <input type="number"
                                                                name="samplePlanningData[0][currentQuantity]" class="currentQuantity">
                                                        </td>
                                                        <td>
                                                            <select name="samplePlanningData[0][UOM]">
                                                                <option value="">Select UOM</option>
                                                                <option value="Pieces">Pieces</option>
                                                                <option value="Kilograms">Kilograms</option>
                                                                <option value="Liters">Liters</option>
                                                                <option value="Meters">Meters</option>
                                                                <option value="Cubic Meters">Cubic Meters</option>
                                                                <option value="Grams">Grams</option>
                                                                <option value="Milliliters">Milliliters</option>
                                                                <option value="Dozens">Dozens</option>
                                                                <option value="Percent ">Percent </option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="samplePlanningData[0][market]">
                                                                <option value="">Select a country</option>
                                                                <option value="Afghanistan">Afghanistan</option>
                                                                <option value="Albania">Albania</option>
                                                                <option value="Algeria">Algeria</option>
                                                                <option value="American Samoa">American Samoa</option>
                                                                <option value="Andorra">Andorra</option>
                                                                <option value="Angola">Angola</option>
                                                                <option value="Argentina">Argentina</option>
                                                                <option value="Armenia">Armenia</option>
                                                                <option value="Australia">Australia</option>
                                                                <option value="Austria">Austria</option>
                                                                <option value="Bahrain">Bahrain</option>
                                                                <option value="Bangladesh">Bangladesh</option>
                                                                <option value="Barbados">Barbados</option>
                                                                <option value="Belarus">Belarus</option>
                                                                <option value="Belgium">Belgium</option>
                                                                <option value="Belize">Belize</option>
                                                                <option value="Benin">Benin</option>
                                                                <option value="Bhutan">Bhutan</option>
                                                                <option value="Bolivia">Bolivia</option>
                                                                <option value="Botswana">Botswana</option>
                                                                <option value="Brazil">Brazil</option>
                                                                <option value="Bulgaria">Bulgaria</option>
                                                                <option value="Colombia">Colombia</option>
                                                                <option value="Croatia">Croatia</option>
                                                                <option value="Czech Republic">Czech Republic</option>
                                                                <option value="Denmark">Denmark</option>
                                                                <option value="Canada">Canada</option>
                                                                <option value="Egypt">Egypt</option>
                                                                <option value="Finland">Finland</option>
                                                                <option value="France">France</option>
                                                                <option value="Germany">Germany</option>
                                                                <option value="India">India</option>
                                                                <option value="Italy">Italy</option>
                                                                <option value="Japan">Japan</option>
                                                                <option value="Mexico">Mexico</option>
                                                                <option value="Netherlands">Netherlands</option>
                                                                <option value="New Zealand">New Zealand</option>
                                                                <option value="Nigeria">Nigeria</option>
                                                                <option value="Pakistan">Pakistan</option>
                                                                <option value="Poland">Poland</option>
                                                                <option value="Russia">Russia</option>
                                                                <option value="Saudi Arabia">Saudi Arabia</option>
                                                                <option value="Spain">Spain</option>
                                                                <option value="Sweden">Sweden</option>
                                                                <option value="Switzerland">Switzerland</option>
                                                                <option value="Turkey">Turkey</option>
                                                                <option value="United Kingdom">United Kingdom</option>
                                                                <option value="United States">United States</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text"
                                                                name="samplePlanningData[0][specificationId]">
                                                        </td>
                                                        <td>
                                                            <input type="file"
                                                                name="samplePlanningData[0][specificationAttach]">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="samplePlanningData[0][STPId]">
                                                        </td>
                                                        <td>
                                                            <input type="file" name="samplePlanningData[0][STPAttach]">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="samplePlanningData[0][testName]">
                                                        </td>
                                                        <td>
                                                            <input type="text"
                                                                name="samplePlanningData[0][testMethod]">
                                                        </td>
                                                        <td>
                                                            <input type="text"
                                                                name="samplePlanningData[0][testParameter]">
                                                        </td>
                                                        <td>
                                                            <input type="text"
                                                                name="samplePlanningData[0][testingFrequency]">
                                                        </td>
                                                        <td>
                                                            <select name="samplePlanningData[0][testingLocation]">
                                                                <option value="">Select Location</option>
                                                                @if(!empty($locations))
                                                                    @foreach($locations as $location)
                                                                        <option value="{{$location->id}}">{{ $location->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </td>
                                                        <td><input type="number" name="samplePlanningData[0][LSL]" class="lsl-field" id="lsl_0"></td>
                                                        <td><input type="number" name="samplePlanningData[0][USL]" class="usl-field" id="usl_0"></td>

                                                        <td>
                                                            <div class="col-md-6 new-date-data-field">
                                                                <div class="group-input input-date">
                                                                    <div class="calenderauditee">
                                                                        <input type="text" id="testingDeadline" readonly placeholder="DD-MMM-YYYY" />
                                                                        <input type="date" name="samplePlanningData[0][testingDeadline]"
                                                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                                                            class="hide-input" oninput="handleDateInput(this, 'testingDeadline')" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <input type="text"
                                                                name="samplePlanningData[0][plannerName]">
                                                        </td>
                                                        <td>
                                                            <input type="text"
                                                                name="samplePlanningData[0][sampleSource]">
                                                        </td>

                                                        <td>
                                                            <div class="col-md-6 new-date-data-field">
                                                                <div class="group-input input-date">
                                                                    <div class="calenderauditee">
                                                                        <input type="text" id="plannedDate" readonly placeholder="DD-MMM-YYYY" />
                                                                        <input type="date" name="samplePlanningData[0][plannedDate]"
                                                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                                                            class="hide-input" oninput="handleDateInput(this, 'plannedDate')" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-md-6 new-date-data-field">
                                                                <div class="group-input input-date">
                                                                    <div class="calenderauditee">
                                                                        <input type="text" id="startDate" readonly placeholder="DD-MMM-YYYY" />
                                                                        <input type="date" name="samplePlanningData[0][startDate]"
                                                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                                                            class="hide-input" oninput="handleDateInput(this, 'startDate')" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <textarea name="samplePlanningData[0][delayJustification]"></textarea>
                                                        </td>

                                                        <td>
                                                            <select multiple name="samplePlanningData[0][labTechnician]" id="labTechnicians">
                                                                <!-- <option value="">Select Lab Technician</option> -->
                                                                @if(!empty($analystData))
                                                                    @foreach($analystData as $item)
                                                                        <option value="{{ $item->userId }}">{{ $item->userName }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text"
                                                                name="samplePlanningData[0][sampleCostEstimation]">
                                                        </td>
                                                        <td>
                                                            <input type="text"
                                                                name="samplePlanningData[0][resourceUtilization]">
                                                        </td>
                                                        <td>
                                                            <div class="col-md-6 new-date-data-field">
                                                                <div class="group-input input-date">
                                                                    <div class="calenderauditee">
                                                                        <input type="text" id="sampleCollectionDate" readonly placeholder="DD-MMM-YYYY" />
                                                                        <input type="date" name="samplePlanningData[0][sampleCollectionDate]"
                                                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                                                            class="hide-input" oninput="handleDateInput(this, 'sampleCollectionDate')" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <input type="file" name="samplePlanningData[0][supportingDocumentGI]">
                                                        </td>

                                                        <!-- Sample Analysis Tab Fields -->
                                                        <td>
                                                            <input type="text" name="samplePlanningData[0][analysisType]">
                                                        </td>
                                                        <td><input type="number" name="samplePlanningData[0][results]" class="results-field" id="results_0" oninput="validateDefaultInput()"></td>
                                                        <td>
                                                            <input type="text" readonly name="samplePlanningData[0][analysisResult]"  id="analysisresults_0" oninput="validateDefaultInput()">
                                                        </td>
                                                        <script>
                                                            function validateDefaultInput() {
                                                                var lsl = parseFloat(document.getElementById('lsl_0').value);
                                                                var usl = parseFloat(document.getElementById('usl_0').value);
                                                                var resultField = document.getElementById('results_0');
                                                                var analysisResult = document.getElementById('analysisresults_0');
                                                                var result = parseFloat(resultField.value);

                                                                if (event.target.id === 'results_0') {
                                                                    if (isNaN(lsl) || isNaN(usl) || isNaN(result)) {
                                                                        resultField.style.borderColor = '';
                                                                        resultField.style.color = '';
                                                                        analysisResult.style.backgroundColor = '';
                                                                        return;
                                                                    }

                                                                    if (result >= lsl && result <= usl) {
                                                                        resultField.style.borderColor = 'green';
                                                                        resultField.style.color = 'green';
                                                                        analysisResult.style.backgroundColor = 'green';
                                                                    } else {
                                                                        resultField.style.borderColor = 'red';
                                                                        resultField.style.color = 'red';
                                                                        analysisResult.style.backgroundColor = 'red';
                                                                    }
                                                                }
                                                            }
                                                        </script>

                                                        <td>
                                                            <select multiple name="samplePlanningData[0][analyst]" id="analystData">
                                                                @if(!empty($analystData))
                                                                    @foreach($analystData as $item)
                                                                        <option value="{{ $item->userId }}">{{ $item->userName }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </td>

                                                        <td>
                                                            <select multiple name="samplePlanningData[0][reagent]" id="reagentData">
                                                                @if(!empty($filteredData))
                                                                    @foreach($filteredData as $item)
                                                                        <option value="{{ $item['name'] }}">{{ $item['name'] }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </td>
                                                        
                                                        
                                                        <td>
                                                            <div class="col-md-6 new-date-data-field">
                                                                <div class="group-input input-date-time">
                                                                    <div class="calenderauditee">
                                                                        <input type="datetime-local" style="width: 150px;"
                                                                            name="samplePlanningData[0][testingStartDate]" 
                                                                            id="testingStartDate" 
                                                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}" 
                                                                            value="" 
                                                                            class="form-control" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-md-6 new-date-data-field">
                                                                <div class="group-input input-date-time">
                                                                    <div class="calenderauditee">
                                                                        <input type="datetime-local"  style="width: 150px;"
                                                                            name="samplePlanningData[0][testingEndDate]" 
                                                                            id="testingEndDate" 
                                                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}" 
                                                                            value="" 
                                                                            class="form-control" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>


                                                        <!-- <td>
                                                            <div class="col-md-6 new-date-data-field">
                                                                <div class="group-input input-date">
                                                                    <div class="calenderauditee">
                                                                        <input type="text" id="testingStartDate" readonly placeholder="DD-MMM-YYYY" />
                                                                        <input type="date" name="samplePlanningData[0][testingStartDate]"
                                                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                                                            class="hide-input" oninput="handleDateInput(this, 'testingStartDate')" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td> -->
                                                        <td>
                                                            <select name="samplePlanningData[0][analysisStatus]">
                                                                <option value="">Select Value</option>
                                                                <option value="Not Yet Started">Not Yet Started</option>
                                                                <option value="Started">Started</option>
                                                                <option value="Completed">Completed</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="samplePlanningData[0][passFail]">
                                                                <option value="">Select Value</option>
                                                                <option value="Pass">Pass</option>
                                                                <option value="Fail">Fail</option>
                                                                <option value="Not Yet">Not Yet</option>
                                                                <option value="Under Investigation">Under Investigation</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <textarea name="samplePlanningData[0][analystInstruction]"></textarea>
                                                        </td>
                                                        <td>
                                                            <input type="number" name="samplePlanningData[0][testPlanId]">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="samplePlanningData[0][turaroundTime]">
                                                        </td>
                                                        <td>
                                                            <div class="col-md-6 new-date-data-field">
                                                                <div class="group-input input-date">
                                                                    <div class="calenderauditee">
                                                                        <input type="text" id="sampleRetestingDate" readonly placeholder="DD-MMM-YYYY" />
                                                                        <input type="date" name="samplePlanningData[0][sampleRetestingDate]"
                                                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                                                            class="hide-input" oninput="handleDateInput(this, 'sampleRetestingDate')" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-md-6 new-date-data-field">
                                                                <div class="group-input input-date">
                                                                    <div class="calenderauditee">
                                                                        <input type="text" id="reviewDate" readonly placeholder="DD-MMM-YYYY" />
                                                                        <input type="date" name="samplePlanningData[0][reviewDate]"
                                                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                                                            class="hide-input" oninput="handleDateInput(this, 'reviewDate')" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <select name="samplePlanningData[0][sampleStorageLocation]">
                                                                <option value="">Select Location</option>
                                                                @if(!empty($locations))
                                                                    @foreach($locations as $location)
                                                                        <option value="{{$location->id}}">{{ $location->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="samplePlanningData[0][transportationMethod]">
                                                        </td>
                                                        <td>
                                                            <textarea name="samplePlanningData[0][samplePreprationMethod]"></textarea>
                                                        </td>
                                                        <td>
                                                            <textarea name="samplePlanningData[0][samplePackagingDetail]"></textarea>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="samplePlanningData[0][sampleLabel]">
                                                        </td>
                                                        <td>
                                                            <textarea name="samplePlanningData[0][regulatoryRequirement]"></textarea>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="samplePlanningData[0][qualityControlCheck]">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="samplePlanningData[0][controlSamplePreference]">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="samplePlanningData[0][controlSample]">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="samplePlanningData[0][referenceSample]">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="samplePlanningData[0][sampleIntegrityStatus]">
                                                        </td>
                                                        <td>
                                                            <select name="samplePlanningData[0][assignedDepartment]">
                                                                <option value="">Select Department</option>
                                                                <option value="CQA">Corporate Quality Assurance</option>
                                                                <option value="QAB">Quality Assurance Biopharma</option>
                                                                <option value="CQC">Central Quality Control</option>
                                                                <option value="MANU">Manufacturing</option>
                                                                <option value="PSG">Plasma Sourcing Group</option>
                                                                <option value="CS">Central Stores</option>
                                                                <option value="ITG">Information Technology Group</option>
                                                                <option value="MM">Molecular Medicine</option>
                                                                <option value="CL">Central Laboratory</option>
                                                                <option value="TT">Tech Team</option>
                                                                <option value="QA">Quality Assurance</option>
                                                                <option value="QM">Quality Management</option>
                                                                <option value="IA">IT Administration</option>
                                                                <option value="ACC">Accounting</option>
                                                                <option value="LOG">Logistics</option>
                                                                <option value="SM">Senior Management</option>
                                                                <option value="BA">Business Administration</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="samplePlanningData[0][riskAssessment]">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="samplePlanningData[0][supervisor]">
                                                        </td>
                                                        <td>
                                                            <select id="instrumentReserved" multiple name="samplePlanningData[0][instrumentReserved]">
                                                                <option value="">Select Option</option>
                                                                <option value="High-Performance Liquid Chromatography (HPLC)">High-Performance Liquid Chromatography (HPLC)</option>
                                                                <option value="Gas Chromatography (GC)">Gas Chromatography (GC)</option>
                                                                <option value="Thin-Layer Chromatography (TLC)">Thin-Layer Chromatography (TLC)</option>
                                                                <option value="Ultra-Performance Liquid Chromatography (UPLC)">Ultra-Performance Liquid Chromatography (UPLC)</option>
                                                                <option value="Ion Chromatography">Ion Chromatography</option>
                                                                <option value="Ultraviolet-Visible Spectrophotometer (UV-Vis)">Ultraviolet-Visible Spectrophotometer (UV-Vis)</option>
                                                                <option value="Infrared Spectrophotometer (IR)">Infrared Spectrophotometer (IR)</option>
                                                                <option value="Fourier-Transform Infrared Spectroscopy (FTIR)">Fourier-Transform Infrared Spectroscopy (FTIR)</option>
                                                                <option value="Atomic Absorption Spectroscopy (AAS)">Atomic Absorption Spectroscopy (AAS)</option>
                                                                <option value="Nuclear Magnetic Resonance Spectroscopy (NMR)">Nuclear Magnetic Resonance Spectroscopy (NMR)</option>
                                                                <option value="Mass Spectrometer (MS)">Mass Spectrometer (MS)</option>
                                                                <option value="Raman Spectrometer">Raman Spectrometer</option>
                                                                <option value="Optical Microscope">Optical Microscope</option>
                                                                <option value="Scanning Electron Microscope (SEM)">Scanning Electron Microscope (SEM)</option>
                                                                <option value="Transmission Electron Microscope (TEM)">Transmission Electron Microscope (TEM)</option>
                                                                <option value="Particle Size Analyzer">Particle Size Analyzer</option>
                                                                <option value="Differential Scanning Calorimeter (DSC)">Differential Scanning Calorimeter (DSC)</option>
                                                                <option value="Thermogravimetric Analyzer (TGA)">Thermogravimetric Analyzer (TGA)</option>
                                                                <option value="pH Meter">pH Meter</option>
                                                                <option value="Conductivity Meter">Conductivity Meter</option>
                                                                <option value="Karl Fischer Titrator">Karl Fischer Titrator</option>
                                                                <option value="Potentiometer">Potentiometer</option>
                                                                <option value="Trainee">Trainee</option>
                                                                <option value="Polarimeter">Polarimeter</option>
                                                                <option value="Dissolution Tester">Dissolution Tester</option>
                                                                <option value="Disintegration Tester">Disintegration Tester</option>
                                                                <option value="Tablet Hardness Tester">Tablet Hardness Tester</option>
                                                                <option value="Friability Tester">Friability Tester</option>
                                                                <option value="Moisture Analyzer">Moisture Analyzer</option>
                                                                <option value="X-Ray Diffraction (XRD)">X-Ray Diffraction (XRD)</option>
                                                                <option value="High-Performance Thin-Layer Chromatography (HPTLC)">High-Performance Thin-Layer Chromatography (HPTLC)</option>
                                                                <option value="Refractometer">Refractometer</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="samplePlanningData[0][labAvailability]">
                                                        </td>
                                                        <td>
                                                            <div class="col-md-6 new-date-data-field">
                                                                <div class="group-input input-date">
                                                                    <div class="calenderauditee">
                                                                        <input type="text" id="sampleDate" readonly placeholder="DD-MMM-YYYY" />
                                                                        <input type="date" name="samplePlanningData[0][sampleDate]"
                                                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                                                            class="hide-input" oninput="handleDateInput(this, 'sampleDate')" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="samplePlanningData[0][sampleMovementHistory]">
                                                        </td>
                                                        <td>
                                                            <select name="samplePlanningData[0][testingProcess]">
                                                                <option value="">Select Process</option>
                                                                <option value="Not Yet">Not Yet</option>
                                                                <option value="WIP">WIP</option>
                                                                <option value="Completed">Completed</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="samplePlanningData[0][alertNotification]">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="samplePlanningData[0][deviationLogs]">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="samplePlanningData[0][commentsLog]">
                                                        </td>
                                                        <td>
                                                            <input type="file" name="samplePlanningData[0][attachment]">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="samplePlanningData[0][samplingFrequency]">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="samplePlanningData[0][stabilityStudyType]">
                                                        </td>
                                                        <td>
                                                            <input type="file" name="samplePlanningData[0][supportingDocumentSampleAnalysis]">
                                                        </td>

                                                        <!-- Stability Information -->
                                                        <td>
                                                            <select name="samplePlanningData[0][stabilityStatus]">
                                                                <option>Select Value</option>
                                                                <option value="Long Term">Long Term</option>
                                                                <option value="Accelerated">Accelerated</option>
                                                                <option value="Intermmediate">Intermmediate</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="file" name="samplePlanningData[0][stabilityProtocolAttach]">
                                                        </td>
                                                        <td>
                                                            <div class="col-md-6 new-date-data-field">
                                                                <div class="group-input input-date">
                                                                    <div class="calenderauditee">
                                                                        <input type="text" id="stabilityApprovalDate" readonly placeholder="DD-MMM-YYYY" />
                                                                        <input type="date" name="samplePlanningData[0][stabilityApprovalDate]"
                                                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                                                            class="hide-input" oninput="handleDateInput(this, 'stabilityApprovalDate')" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="samplePlanningData[0][countryOfRegulatorySubmision]">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="samplePlanningData[0][ICHZone]">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="samplePlanningData[0][photostabilityTestingResult]">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="samplePlanningData[0][reconstitutionStability]">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="samplePlanningData[0][testingInterval]">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="samplePlanningData[0][shelfLifeRecommendation]">
                                                        </td>
                                                        <td>
                                                            <input type="file" name="samplePlanningData[0][stabilityAttachment]">
                                                        </td>

                                                        <!-- Supervisor Review -->
                                                        <td>
                                                            <select name="samplePlanningData[0][reviewerApprover]">
                                                                <option value="">Select User</option>
                                                                @if(!empty($users))
                                                                    @foreach($users as $user)
                                                                        <option value="{{$user->id}}">{{ $user->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="samplePlanningData[0][sampleDesposion]">
                                                        </td>
                                                        <td>
                                                            <textarea name="samplePlanningData[0][reviewerComment]"></textarea>
                                                        </td>
                                                        <td>
                                                            <div class="col-md-6 new-date-data-field">
                                                                <div class="group-input input-date">
                                                                    <div class="calenderauditee">
                                                                        <input type="text" id="supervisorReviewDate" readonly placeholder="DD-MMM-YYYY" />
                                                                        <input type="date" name="samplePlanningData[0][supervisorReviewDate]"
                                                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                                                            class="hide-input" oninput="handleDateInput(this, 'supervisorReviewDate')" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="file" name="samplePlanningData[0][supervisorAttach]">
                                                        </td>

                                                        <!-- QA Review -->
                                                        <td> 
                                                            <select name="samplePlanningData[0][QAreviewerApprover]">
                                                                <option value="">Select User</option>
                                                                @if(!empty($users))
                                                                    @foreach($users as $user)
                                                                        <option value="{{$user->id}}">{{ $user->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <textarea name="samplePlanningData[0][QAreviewerComment]"></textarea>
                                                        </td>
                                                        <td>
                                                            <div class="col-md-6 new-date-data-field">
                                                                <div class="group-input input-date">
                                                                    <div class="calenderauditee">
                                                                        <input type="text" id="QAreviewDate" readonly placeholder="DD-MMM-YYYY" />
                                                                        <input type="date" name="samplePlanningData[0][QAreviewDate]"
                                                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                                                            class="hide-input" oninput="handleDateInput(this, 'QAreviewDate')" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="file" name="samplePlanningData[0][QAsupervisorAttach]">
                                                        </td>

                                                        <td>
                                                            <div class="col-md-6 new-date-data-field">
                                                                <div class="group-input input-date">
                                                                    <div class="calenderauditee">
                                                                        <input type="text" id="destructionDueOn" readonly placeholder="DD-MMM-YYYY" />
                                                                        <input type="date" name="samplePlanningData[0][destructionDueOn]"
                                                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                                                            class="hide-input" oninput="handleDateInput(this, 'destructionDueOn')" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-md-6 new-date-data-field">
                                                                <div class="group-input input-date">
                                                                    <div class="calenderauditee">
                                                                        <input type="text" id="desctructionDate" readonly placeholder="DD-MMM-YYYY" />
                                                                        <input type="date" name="samplePlanningData[0][desctructionDate]"
                                                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value=""
                                                                            class="hide-input" oninput="handleDateInput(this, 'desctructionDate')" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="samplePlanningData[0][destructedBy]">
                                                        </td>
                                                        <td>
                                                            <textarea name="samplePlanningData[0][destructionRemarks]"></textarea>
                                                        </td>
                                                        <td><button class="removeRowBtn">Remove</button></td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>


                                <script>
                                    $(document).on('input', '.quantityWithdrawn', function() {
                                        var row = $(this).closest('tr');
                                        var quantity = parseFloat(row.find('.sampleQuantity').val()) || 0;
                                        var withdrawn = parseFloat($(this).val()) || 0;
                                        var currentQuantity = quantity - withdrawn;
                                        row.find('.currentQuantity').val(currentQuantity);
                                    });

                                    function validateDynamicInput(rowIndex) {
                                            var lsl = parseFloat(document.getElementById('lsl_' + rowIndex).value);
                                            var usl = parseFloat(document.getElementById('usl_' + rowIndex).value);
                                            var resultField = document.getElementById('results_' + rowIndex);
                                            var analysisResults = document.getElementById('analysisresults_' + rowIndex);
                                            var result = parseFloat(resultField.value);

                                            if (event.target.id === 'results_' + rowIndex) {
                                                if (isNaN(lsl) || isNaN(usl) || isNaN(result)) {
                                                    resultField.style.borderColor = '';
                                                    resultField.style.color = '';
                                                    analysisResults.style.backgroundColor = '';
                                                    return;
                                                }

                                                if (result >= lsl && result <= usl) {
                                                    resultField.style.borderColor = 'green';
                                                    resultField.style.color = 'green';
                                                    analysisResults.style.backgroundColor = 'green';
                                                } else {
                                                    resultField.style.borderColor = 'red';
                                                    resultField.style.color = 'red';
                                                    analysisResults.style.backgroundColor = 'red';
                                                }
                                            }
                                        }

                                    document.addEventListener("DOMContentLoaded", function() {
                                        let rowIndex = 1;
                                        let nextSamplePlanId = 1002;
                                        const users = @json($users->toArray() ?? []);
                                        const locations = @json($locations->toArray() ?? []);
                                        const labTechnicians = @json($analystData->toArray() ?? []);
                                        const analysts = @json($analystData->toArray() ?? []);
                                        const reagentDatas = @json($filteredData ?? []);
                                        
                                        document.getElementById("addSamplePlanning").addEventListener("click", function() {
                                            const tableBody = document.querySelector("#addSamplePlanningTable tbody");
                                            const newRow = document.createElement("tr");

                                            let userOptions = `<option value="">Select User</option>`;
                                            if (Array.isArray(users)) {
                                                users.forEach(user => {
                                                    userOptions += `<option value="${user.id}">${user.name}</option>`;
                                                });
                                            } else {
                                                console.warn("Users data is not an array");
                                            }

                                            let locationOptions = `<option value="">Select Location</option>`;
                                            if (Array.isArray(locations)) {
                                                locations.forEach(location => {
                                                    locationOptions += `<option value="${location.id}">${location.name}</option>`;
                                                });
                                            } else {
                                                console.warn("Locations data is not an array");
                                            }


                                            let labTechnicianOptions = `<option value="">Select Lab Technician</option>`;
                                            if (Array.isArray(labTechnicians)) {
                                                labTechnicians.forEach(labTechnician => {
                                                    labTechnicianOptions += `<option value="${labTechnician.userId}">${labTechnician.userName}</option>`;
                                                });
                                            } else {
                                                console.warn("Technician data is not an array");
                                            }

                                            let analystOptions = `<option value="">Select Analyst</option>`;
                                            if (Array.isArray(analysts)) {
                                                analysts.forEach(analyst => {
                                                    analystOptions += `<option value="${analyst.userId}">${analyst.userName}</option>`;
                                                });
                                            } else {
                                                console.warn("Analyst data is not an array");
                                            }

                                            let reagentOptions = `<option value="">Select Used Quality</option>`;
                                            if (Array.isArray(reagentDatas)) {
                                                reagentDatas.forEach(item => {
                                                    reagentOptions += `<option value="${item.name}">${item.name}</option>`;
                                                });
                                            } else {
                                                console.warn("Filtered data is not an array");
                                            }

                                            newRow.innerHTML = `
                                                                    
                                                                <td><input type="number" name="samplePlanningData[${rowIndex}][samplePlanId]" value="${nextSamplePlanId}" readonly></td>
                                                                <td><input type="text" name="samplePlanningData[${rowIndex}][samplePlan]"></td>
                                                                <td><input type="text" name="samplePlanningData[${rowIndex}][samplePlanName]"></td>
                                                                <td><input type="text" name="samplePlanningData[${rowIndex}][sampleType]"></td>
                                                                <td><input type="text" name="samplePlanningData[${rowIndex}][productmaterial]"></td>
                                                                <td><input type="text" name="samplePlanningData[${rowIndex}][productmaterialCode]"></td>
                                                                <td><input type="text" name="samplePlanningData[${rowIndex}][batchNumber]"></td>
                                                                <td>
                                                                    <select name="samplePlanningData[${rowIndex}][samplePriority]">
                                                                         <option value="">Select Priority</option>
                                                                        <option value="High">High</option>
                                                                        <option value="Medium">Medium</option>
                                                                        <option value="Low">Low</option>
                                                                    </select>
                                                                </td>
                                                                <td><input type="text" name="samplePlanningData[${rowIndex}][sampleQuantity]" class="sampleQuantity"></td>
                                                                <td><input type="text" name="samplePlanningData[${rowIndex}][quantityWithdrawn]" class="quantityWithdrawn"></td>
                                                                <td><input type="text" name="samplePlanningData[${rowIndex}][currentQuantity]" class="currentQuantity"></td>
                                                                <td>
                                                                    <select name="samplePlanningData[${rowIndex}][UOM]">
                                                                        <option value="">Select UOM</option>
                                                                        <option value="Pieces">Pieces</option>
                                                                        <option value="Kilograms">Kilograms</option>
                                                                        <option value="Liters">Liters</option>
                                                                        <option value="Meters">Meters</option>
                                                                        <option value="Cubic Meters">Cubic Meters</option>
                                                                        <option value="Grams">Grams</option>
                                                                        <option value="Milliliters">Milliliters</option>
                                                                        <option value="Dozens">Dozens</option>
                                                                        <option value="Percent ">Percent </option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select name="samplePlanningData[${rowIndex}][market]">
                                                                        <option value="">Select a country</option>
                                                                        <option value="Afghanistan">Afghanistan</option>
                                                                        <option value="Albania">Albania</option>
                                                                        <option value="Algeria">Algeria</option>
                                                                        <option value="American Samoa">American Samoa</option>
                                                                        <option value="Andorra">Andorra</option>
                                                                        <option value="Angola">Angola</option>
                                                                        <option value="Argentina">Argentina</option>
                                                                        <option value="Armenia">Armenia</option>
                                                                        <option value="Australia">Australia</option>
                                                                        <option value="Austria">Austria</option>
                                                                        <option value="Bahrain">Bahrain</option>
                                                                        <option value="Bangladesh">Bangladesh</option>
                                                                        <option value="Barbados">Barbados</option>
                                                                        <option value="Belarus">Belarus</option>
                                                                        <option value="Belgium">Belgium</option>
                                                                        <option value="Belize">Belize</option>
                                                                        <option value="Benin">Benin</option>
                                                                        <option value="Bhutan">Bhutan</option>
                                                                        <option value="Bolivia">Bolivia</option>
                                                                        <option value="Botswana">Botswana</option>
                                                                        <option value="Brazil">Brazil</option>
                                                                        <option value="Bulgaria">Bulgaria</option>
                                                                        <option value="Colombia">Colombia</option>
                                                                        <option value="Croatia">Croatia</option>
                                                                        <option value="Czech Republic">Czech Republic</option>
                                                                        <option value="Denmark">Denmark</option>
                                                                        <option value="Canada">Canada</option>
                                                                        <option value="Egypt">Egypt</option>
                                                                        <option value="Finland">Finland</option>
                                                                        <option value="France">France</option>
                                                                        <option value="Germany">Germany</option>
                                                                        <option value="India">India</option>
                                                                        <option value="Italy">Italy</option>
                                                                        <option value="Japan">Japan</option>
                                                                        <option value="Mexico">Mexico</option>
                                                                        <option value="Netherlands">Netherlands</option>
                                                                        <option value="New Zealand">New Zealand</option>
                                                                        <option value="Nigeria">Nigeria</option>
                                                                        <option value="Pakistan">Pakistan</option>
                                                                        <option value="Poland">Poland</option>
                                                                        <option value="Russia">Russia</option>
                                                                        <option value="Saudi Arabia">Saudi Arabia</option>
                                                                        <option value="Spain">Spain</option>
                                                                        <option value="Sweden">Sweden</option>
                                                                        <option value="Switzerland">Switzerland</option>
                                                                        <option value="Turkey">Turkey</option>
                                                                        <option value="United Kingdom">United Kingdom</option>
                                                                        <option value="United States">United States</option>
                                                                    </select>
                                                                </td>
                                                                <td><input type="text" name="samplePlanningData[${rowIndex}][specificationId]"></td>
                                                                <td><input type="file" name="samplePlanningData[${rowIndex}][specificationAttach]"></td>
                                                                <td><input type="text" name="samplePlanningData[${rowIndex}][STPId]"></td>
                                                                <td><input type="file" name="samplePlanningData[${rowIndex}][STPAttach]"></td>
                                                                <td><input type="text" name="samplePlanningData[${rowIndex}][testName]"></td>
                                                                <td><input type="text" name="samplePlanningData[${rowIndex}][testMethod]"></td>
                                                                <td><input type="text" name="samplePlanningData[${rowIndex}][testParameter]"></td>
                                                                <td><input type="text" name="samplePlanningData[${rowIndex}][testingFrequency]"></td>
                                                               <td>
                                                                    <select name="samplePlanningData[${rowIndex}][testingLocation]">
                                                                        ${locationOptions}
                                                                    </select>
                                                                </td>
                                                                <td><input type="number" name="samplePlanningData[${rowIndex}][LSL]" class="lsl-field" id="lsl_${rowIndex}" oninput="validateDynamicInput(${rowIndex})"></td>
                                                                <td><input type="number" name="samplePlanningData[${rowIndex}][USL]" class="usl-field" id="usl_${rowIndex}" oninput="validateDynamicInput(${rowIndex})"></td>

                                                                <td>
                                                                    <div class="col-md-6 new-date-data-field">
                                                                        <div class="group-input input-date">
                                                                            <div class="calenderauditee">
                                                                                <input type="text" id="testingDeadline${rowIndex}" readonly placeholder="DD-MMM-YYYY" />
                                                                                <input type="date" name="samplePlanningData[${rowIndex}][testingDeadline]"
                                                                                    min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                                    class="hide-input" oninput="handleDateInput(this, 'testingDeadline${rowIndex}')" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>


                                                                <td><input type="text" name="samplePlanningData[${rowIndex}][plannerName]"></td>
                                                                <td><input type="text" name="samplePlanningData[${rowIndex}][sampleSource]"></td>
                                                                <td>
                                                                    <div class="col-md-6 new-date-data-field">
                                                                        <div class="group-input input-date">
                                                                            <div class="calenderauditee">
                                                                                <input type="text" id="plannedDate${rowIndex}" readonly placeholder="DD-MMM-YYYY" />
                                                                                <input type="date" name="samplePlanningData[${rowIndex}][plannedDate]"
                                                                                    min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                                    class="hide-input" oninput="handleDateInput(this, 'plannedDate${rowIndex}')" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="col-md-6 new-date-data-field">
                                                                        <div class="group-input input-date">
                                                                            <div class="calenderauditee">
                                                                                <input type="text" id="startDate${rowIndex}" readonly placeholder="DD-MMM-YYYY" />
                                                                                <input type="date" name="samplePlanningData[${rowIndex}][startDate]"
                                                                                    min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                                    class="hide-input" oninput="handleDateInput(this, 'startDate${rowIndex}')" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <textarea name="samplePlanningData[${rowIndex}][delayJustification]"></textarea>
                                                                </td>
                                                                <td>
                                                                    <select multiple id="labTechnicians_${rowIndex}" name="samplePlanningData[${rowIndex}][labTechnician]">
                                                                        ${labTechnicianOptions}
                                                                    </select>
                                                                </td>
                                                                <td><input type="text" name="samplePlanningData[${rowIndex}][sampleCostEstimation]"></td>
                                                                <td><input type="text" name="samplePlanningData[${rowIndex}][resourceUtilization]"></td>
                                                                <td>
                                                                    <div class="col-md-6 new-date-data-field">
                                                                        <div class="group-input input-date">
                                                                            <div class="calenderauditee">
                                                                                <input type="text" id="sampleCollectionDate${rowIndex}" readonly placeholder="DD-MMM-YYYY" />
                                                                                <input type="date" name="samplePlanningData[${rowIndex}][sampleCollectionDate]"
                                                                                    min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                                    class="hide-input" oninput="handleDateInput(this, 'sampleCollectionDate${rowIndex}')" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td><input type="file" name="samplePlanningData[${rowIndex}][supportingDocumentGI]"></td>

                                                                <td>
                                                                    <input type="text" name="samplePlanningData[${rowIndex}][analysisType]">
                                                                </td>
                                                                <td><input type="number" name="samplePlanningData[${rowIndex}][results]"  class="results-field" id="results_${rowIndex}" oninput="validateDynamicInput(${rowIndex})"></td>
                                                                <td>
                                                                    <input readonly type="text" name="samplePlanningData[${rowIndex}][analysisResult]"  id="analysisresults_${rowIndex}" oninput="validateDynamicInput(${rowIndex})">
                                                                </td>
                                                                 <td>
                                                                    <select multiple id="analystData_${rowIndex}" name="samplePlanningData[${rowIndex}][analyst]">
                                                                        ${analystOptions}
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select multiple id="reagentDatas_${rowIndex}" name="samplePlanningData[${rowIndex}][reagent]">
                                                                        ${reagentOptions}
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <div class="col-md-6 new-date-data-field">
                                                                        <div class="group-input input-date">
                                                                            <div class="calenderauditee">
                                                                                <input type="text" 
                                                                                    id="testingStartDate${rowIndex}" 
                                                                                    readonly  style="width: 150px;"
                                                                                    placeholder="DD-MMM-YYYY HH:mm" 
                                                                                    value="{{ Helpers::formatDateTime($row['testingStartDate'] ?? '') }}" />

                                                                                <input type="datetime-local" 
                                                                                    name="samplePlanningData[${rowIndex}][testingStartDate]" 
                                                                                    min="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}" 
                                                                                    value="{{ $row['testingStartDate'] ?? '' }}" 
                                                                                    class="hide-input" 
                                                                                    oninput="handleDateInput(this, 'testingStartDate${rowIndex}')" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="col-md-6 new-date-data-field">
                                                                        <div class="group-input input-date">
                                                                            <div class="calenderauditee">
                                                                                <input type="text" style="width: 150px;"
                                                                                    id="testingEndDate${rowIndex}" 
                                                                                    readonly 
                                                                                    placeholder="DD-MMM-YYYY HH:mm" 
                                                                                    value="{{ Helpers::formatDateTime($row['testingEndDate'] ?? '') }}" />

                                                                                <input type="datetime-local" 
                                                                                    name="samplePlanningData[${rowIndex}][testingEndDate]" 
                                                                                    min="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}" 
                                                                                    value="{{ $row['testingEndDate'] ?? '' }}" 
                                                                                    class="hide-input" 
                                                                                    oninput="handleDateInput(this, 'testingEndDate${rowIndex}')" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                                <td>
                                                                    <select name="samplePlanningData[${rowIndex}][analysisStatus]">
                                                                        <option value="">Select Value</option>
                                                                        <option value="Not Yet Started">Not Yet Started</option>
                                                                        <option value="Started">Started</option>
                                                                        <option value="Completed">Completed</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select name="samplePlanningData[${rowIndex}][passFail]">
                                                                        <option value="">Select Value</option>
                                                                        <option value="Pass">Pass</option>
                                                                        <option value="Fail">Fail</option>
                                                                        <option value="Not Yet">Not Yet</option>
                                                                        <option value="Under Investigation">Under Investigation</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <textarea name="samplePlanningData[${rowIndex}][analystInstruction]"></textarea>
                                                                </td>
                                                                <td>
                                                                    <input type="number" name="samplePlanningData[${rowIndex}][testPlanId]">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="samplePlanningData[${rowIndex}][turaroundTime]">
                                                                </td>
                                                                <td>
                                                                    <div class="col-md-6 new-date-data-field">
                                                                        <div class="group-input input-date">
                                                                            <div class="calenderauditee">
                                                                                <input type="text" id="sampleRetestingDate${rowIndex}" readonly placeholder="DD-MMM-YYYY" />
                                                                                <input type="date" name="samplePlanningData[${rowIndex}][sampleRetestingDate]"
                                                                                    min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                                    class="hide-input" oninput="handleDateInput(this, 'sampleRetestingDate${rowIndex}')" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="col-md-6 new-date-data-field">
                                                                        <div class="group-input input-date">
                                                                            <div class="calenderauditee">
                                                                                <input type="text" id="reviewDate${rowIndex}" readonly placeholder="DD-MMM-YYYY" />
                                                                                <input type="date" name="samplePlanningData[${rowIndex}][reviewDate]"
                                                                                    min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                                    class="hide-input" oninput="handleDateInput(this, 'reviewDate${rowIndex}')" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <select name="samplePlanningData[${rowIndex}][sampleStorageLocation]">
                                                                        ${locationOptions}
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="samplePlanningData[${rowIndex}][transportationMethod]">
                                                                </td>
                                                                <td>
                                                                    <textarea name="samplePlanningData[${rowIndex}][samplePreprationMethod]"></textarea>
                                                                </td>
                                                                <td>
                                                                    <textarea name="samplePlanningData[${rowIndex}][samplePackagingDetail]"></textarea>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="samplePlanningData[${rowIndex}][sampleLabel]">
                                                                </td>
                                                                <td>
                                                                    <textarea name="samplePlanningData[${rowIndex}][regulatoryRequirement]"></textarea>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="samplePlanningData[${rowIndex}][qualityControlCheck]">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="samplePlanningData[${rowIndex}][controlSamplePreference]">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="samplePlanningData[${rowIndex}][controlSample]">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="samplePlanningData[${rowIndex}][referenceSample]">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="samplePlanningData[${rowIndex}][sampleIntegrityStatus]">
                                                                </td>
                                                                <td>
                                                                    <select name="samplePlanningData[${rowIndex}][assignedDepartment]">
                                                                        <option value="">Select Department</option>
                                                                        <option value="CQA">Corporate Quality Assurance</option>
                                                                        <option value="QAB">Quality Assurance Biopharma</option>
                                                                        <option value="CQC">Central Quality Control</option>
                                                                        <option value="MANU">Manufacturing</option>
                                                                        <option value="PSG">Plasma Sourcing Group</option>
                                                                        <option value="CS">Central Stores</option>
                                                                        <option value="ITG">Information Technology Group</option>
                                                                        <option value="MM">Molecular Medicine</option>
                                                                        <option value="CL">Central Laboratory</option>
                                                                        <option value="TT">Tech Team</option>
                                                                        <option value="QA">Quality Assurance</option>
                                                                        <option value="QM">Quality Management</option>
                                                                        <option value="IA">IT Administration</option>
                                                                        <option value="ACC">Accounting</option>
                                                                        <option value="LOG">Logistics</option>
                                                                        <option value="SM">Senior Management</option>
                                                                        <option value="BA">Business Administration</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="samplePlanningData[${rowIndex}][riskAssessment]">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="samplePlanningData[${rowIndex}][supervisor]">
                                                                </td>
                                                                <td>
                                                                    <select multiple  id="instrumentReserved_${rowIndex}" name="samplePlanningData[${rowIndex}][instrumentReserved]">
                                                                        <option value="">Select Option</option>
                                                                        <option value="High-Performance Liquid Chromatography (HPLC)">High-Performance Liquid Chromatography (HPLC)</option>
                                                                        <option value="Gas Chromatography (GC)">Gas Chromatography (GC)</option>
                                                                        <option value="Thin-Layer Chromatography (TLC)">Thin-Layer Chromatography (TLC)</option>
                                                                        <option value="Ultra-Performance Liquid Chromatography (UPLC)">Ultra-Performance Liquid Chromatography (UPLC)</option>
                                                                        <option value="Ion Chromatography">Ion Chromatography</option>
                                                                        <option value="Ultraviolet-Visible Spectrophotometer (UV-Vis)">Ultraviolet-Visible Spectrophotometer (UV-Vis)</option>
                                                                        <option value="Infrared Spectrophotometer (IR)">Infrared Spectrophotometer (IR)</option>
                                                                        <option value="Fourier-Transform Infrared Spectroscopy (FTIR)">Fourier-Transform Infrared Spectroscopy (FTIR)</option>
                                                                        <option value="Atomic Absorption Spectroscopy (AAS)">Atomic Absorption Spectroscopy (AAS)</option>
                                                                        <option value="Nuclear Magnetic Resonance Spectroscopy (NMR)">Nuclear Magnetic Resonance Spectroscopy (NMR)</option>
                                                                        <option value="Mass Spectrometer (MS)">Mass Spectrometer (MS)</option>
                                                                        <option value="Raman Spectrometer">Raman Spectrometer</option>
                                                                        <option value="Optical Microscope">Optical Microscope</option>
                                                                        <option value="Scanning Electron Microscope (SEM)">Scanning Electron Microscope (SEM)</option>
                                                                        <option value="Transmission Electron Microscope (TEM)">Transmission Electron Microscope (TEM)</option>
                                                                        <option value="Particle Size Analyzer">Particle Size Analyzer</option>
                                                                        <option value="Differential Scanning Calorimeter (DSC)">Differential Scanning Calorimeter (DSC)</option>
                                                                        <option value="Thermogravimetric Analyzer (TGA)">Thermogravimetric Analyzer (TGA)</option>
                                                                        <option value="pH Meter">pH Meter</option>
                                                                        <option value="Conductivity Meter">Conductivity Meter</option>
                                                                        <option value="Karl Fischer Titrator">Karl Fischer Titrator</option>
                                                                        <option value="Potentiometer">Potentiometer</option>
                                                                        <option value="Trainee">Trainee</option>
                                                                        <option value="Polarimeter">Polarimeter</option>
                                                                        <option value="Dissolution Tester">Dissolution Tester</option>
                                                                        <option value="Disintegration Tester">Disintegration Tester</option>
                                                                        <option value="Tablet Hardness Tester">Tablet Hardness Tester</option>
                                                                        <option value="Friability Tester">Friability Tester</option>
                                                                        <option value="Moisture Analyzer">Moisture Analyzer</option>
                                                                        <option value="X-Ray Diffraction (XRD)">X-Ray Diffraction (XRD)</option>
                                                                        <option value="High-Performance Thin-Layer Chromatography (HPTLC)">High-Performance Thin-Layer Chromatography (HPTLC)</option>
                                                                        <option value="Refractometer">Refractometer</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="samplePlanningData[${rowIndex}][labAvailability]">
                                                                </td>
                                                                <td>
                                                                    <div class="col-md-6 new-date-data-field">
                                                                        <div class="group-input input-date">
                                                                            <div class="calenderauditee">
                                                                                <input type="text" id="sampleDate${rowIndex}" readonly placeholder="DD-MMM-YYYY" />
                                                                                <input type="date" name="samplePlanningData[${rowIndex}][sampleDate]"
                                                                                    min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                                    class="hide-input" oninput="handleDateInput(this, 'sampleDate${rowIndex}')" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="samplePlanningData[${rowIndex}][sampleMovementHistory]">
                                                                </td>
                                                                <td>
                                                                    <select name="samplePlanningData[${rowIndex}][testingProcess]">
                                                                        <option value="">Select Process</option>
                                                                        <option value="Not Yet">Not Yet</option>
                                                                        <option value="WIP">WIP</option>
                                                                        <option value="Completed">Completed</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="samplePlanningData[${rowIndex}][alertNotification]">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="samplePlanningData[${rowIndex}][deviationLogs]">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="samplePlanningData[${rowIndex}][commentsLog]">
                                                                </td>
                                                                <td>
                                                                    <input type="file" name="samplePlanningData[${rowIndex}][attachment]">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="samplePlanningData[${rowIndex}][samplingFrequency]">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="samplePlanningData[${rowIndex}][stabilityStudyType]">
                                                                </td>
                                                                <td>
                                                                    <input type="file" name="samplePlanningData[${rowIndex}][supportingDocumentSampleAnalysis]">
                                                                </td>

                                                                <td>
                                                                    <select name="samplePlanningData[${rowIndex}][stabilityStatus]">
                                                                        <option>Select Value</option>
                                                                        <option value="Long Term">Long Term</option>
                                                                        <option value="Accelerated">Accelerated</option>
                                                                        <option value="Intermmediate">Intermmediate</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="file" name="samplePlanningData[${rowIndex}][stabilityProtocolAttach]">
                                                                </td>
                                                                <td>
                                                                    <div class="col-md-6 new-date-data-field">
                                                                        <div class="group-input input-date">
                                                                            <div class="calenderauditee">
                                                                                <input type="text" id="stabilityApprovalDate${rowIndex}" readonly placeholder="DD-MMM-YYYY" />
                                                                                <input type="date" name="samplePlanningData[${rowIndex}][stabilityApprovalDate]"
                                                                                    min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                                    class="hide-input" oninput="handleDateInput(this, 'stabilityApprovalDate${rowIndex}')" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="samplePlanningData[${rowIndex}][countryOfRegulatorySubmision]">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="samplePlanningData[${rowIndex}][ICHZone]">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="samplePlanningData[${rowIndex}][photostabilityTestingResult]">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="samplePlanningData[${rowIndex}][reconstitutionStability]">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="samplePlanningData[${rowIndex}][testingInterval]">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="samplePlanningData[${rowIndex}][shelfLifeRecommendation]">
                                                                </td>
                                                                <td>
                                                                    <input type="file" name="samplePlanningData[${rowIndex}][stabilityAttachment]">
                                                                </td>

                                                                <td>
                                                                    <select name="samplePlanningData[${rowIndex}][reviewerApprover]">
                                                                        ${userOptions}
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="samplePlanningData[${rowIndex}][sampleDesposion]">
                                                                </td>
                                                                <td>
                                                                    <textarea name="samplePlanningData[${rowIndex}][reviewerComment]"></textarea>
                                                                </td>
                                                                <td>
                                                                    <div class="col-md-6 new-date-data-field">
                                                                        <div class="group-input input-date">
                                                                            <div class="calenderauditee">
                                                                                <input type="text" id="supervisorReviewDate${rowIndex}" readonly placeholder="DD-MMM-YYYY" />
                                                                                <input type="date" name="samplePlanningData[${rowIndex}][supervisorReviewDate]"
                                                                                    min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                                    class="hide-input" oninput="handleDateInput(this, 'supervisorReviewDate${rowIndex}')" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <input type="file" name="samplePlanningData[${rowIndex}][supervisorAttach]">
                                                                </td>
                                                                <td>
                                                                    <select name="samplePlanningData[${rowIndex}][QAreviewerApprover]">
                                                                        ${userOptions}
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <textarea name="samplePlanningData[${rowIndex}][QAreviewerComment]"></textarea>
                                                                </td>
                                                                <td>
                                                                    <div class="col-md-6 new-date-data-field">
                                                                        <div class="group-input input-date">
                                                                            <div class="calenderauditee">
                                                                                <input type="text" id="QAreviewDate${rowIndex}" readonly placeholder="DD-MMM-YYYY" />
                                                                                <input type="date" name="samplePlanningData[${rowIndex}][QAreviewDate]"
                                                                                    min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                                    class="hide-input" oninput="handleDateInput(this, 'QAreviewDate${rowIndex}')" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <input type="file" name="samplePlanningData[${rowIndex}][QAsupervisorAttach]">
                                                                </td>

                                                                <td>
                                                                    <div class="col-md-6 new-date-data-field">
                                                                        <div class="group-input input-date">
                                                                            <div class="calenderauditee">
                                                                                <input type="text" id="destructionDueOn${rowIndex}" readonly placeholder="DD-MMM-YYYY" />
                                                                                <input type="date" name="samplePlanningData[${rowIndex}][destructionDueOn]"
                                                                                    min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                                    class="hide-input" oninput="handleDateInput(this, 'destructionDueOn${rowIndex}')" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="col-md-6 new-date-data-field">
                                                                        <div class="group-input input-date">
                                                                            <div class="calenderauditee">
                                                                                <input type="text" id="desctructionDate${rowIndex}" readonly placeholder="DD-MMM-YYYY" />
                                                                                <input type="date" name="samplePlanningData[${rowIndex}][desctructionDate]"
                                                                                    min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                                    class="hide-input" oninput="handleDateInput(this, 'desctructionDate${rowIndex}')" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="samplePlanningData[${rowIndex}][destructedBy]">
                                                                </td>
                                                                <td>
                                                                    <textarea name="samplePlanningData[${rowIndex}][destructionRemarks]"></textarea>
                                                                </td>
                                                                <td><button type="button" class="removeRowBtn">Remove</button></td>
                                                            `;

                                            tableBody.appendChild(newRow);
                                            rowIndex++;
                                            nextSamplePlanId++;
                                            console.log(rowIndex - 1, "rowIndex - 1");
                                            
                                            VirtualSelect.init({
                                                ele: '#instrumentReserved_' + (rowIndex - 1),
                                                multiple: true
                                            }); 
                                            VirtualSelect.init({
                                                ele: '#labTechnicians_' + (rowIndex - 1),
                                                multiple: true
                                            });
                                            VirtualSelect.init({
                                                ele: '#analystData_' + (rowIndex - 1),
                                                multiple: true
                                            }); 
                                            VirtualSelect.init({
                                                ele: '#reagentDatas_' + (rowIndex - 1),
                                                multiple: true
                                            }); 
                                        });

                                        // document.querySelector("#addSamplePlanningTable tbody").addEventListener("click", function(e) {
                                        //     if (e.target && e.target.classList.contains("removeRowBtn")) {
                                        //         e.target.closest("tr").remove();
                                        //     }
                                        // });

                                        document.querySelector("#addSamplePlanningTable tbody").addEventListener("click", function (e) {
                                            if (e.target && e.target.classList.contains("removeRowBtn")) {
                                                const row = e.target.closest("tr");
                                                const idInput = row.querySelector("input[name$='[samplePlanId]']");
                                                if (idInput) {
                                                    const removedId = parseInt(idInput.value);
                                                    if (removedId < nextSamplePlanId - 1) {
                                                        nextSamplePlanId--;
                                                    }
                                                }
                                                row.remove();
                                            }
                                        });

                                        document.addEventListener('input', function (event) {
                                            if (event.target.matches('.lsl-field') || event.target.matches('.usl-field')) {
                                                const rowIndex = event.target.name.match(/\d+/)[0];
                                                const lsl = document.querySelector(`input[name="samplePlanningData[${rowIndex}][LSL]"]`).value;
                                                
                                                const usl = document.querySelector(`input[name="samplePlanningData[${rowIndex}][USL]"]`).value;
                                                const analysisField = document.querySelector(`input[name="samplePlanningData[${rowIndex}][analysisResult]"]`);

                                                if (parseFloat(usl) > parseFloat(lsl)) {
                                                    analysisField.style.backgroundColor = 'red';
                                                } else {
                                                    analysisField.style.backgroundColor = 'green';
                                                }
                                            }
                                        });

                                        function addDynamicRow(rowIndex) {
                                            const table = document.getElementById('addSamplePlanningTable');
                                            const newRow = `<tr>
                                                <td><input type="number" name="samplePlanningData[${rowIndex}][LSL]" class="lsl-field" id="lsl_${rowIndex}"></td>
                                                <td><input type="number" name="samplePlanningData[${rowIndex}][USL]" class="usl-field" id="usl_${rowIndex}"></td>
                                                <td><input type="text" name="samplePlanningData[${rowIndex}][analysisResult]"  id="analysisResult_${rowIndex}"></td>
                                            </tr>`;
                                            table.insertAdjacentHTML('beforeend', newRow);
                                        }

                                        
                                    });
                                </script>

                                <!-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Plan ID">Sample Plan ID</label>
                                        <input type="number" name="sample_plan_id">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Plan ID">Sample Plan</label>
                                        <input type="text" name="sample_plan">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Plan ID">Sample Name</label>
                                        <input type="text" name="sample_name">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Plan ID">Sample Type</label>
                                        <input type="text" name="sample_type">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Plan ID">Product / Material Name</label>
                                        <input type="text" name="product_name">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Plan ID">Batch/Lot Number</label>
                                        <input type="text" name="batch_number">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Plan ID">Sample Priority</label>
                                        <select name="sample_priority">
                                            <option value="">Select Priority Level</option>
                                            <option value="Low">Low</option>
                                            <option value="Medium">Medium</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Plan ID">Sample Quantity</label>
                                        <input type="number" name="sample_quantity">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Plan ID">UOM</label>
                                        <select name="UOM">
                                            <option value="">Select Priority Level</option>
                                            <option value="gm">gm</option>
                                            <option value="ml">ml</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Market">Market</label>
                                        <input type="text" name="market">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Specification Id">Specification Id</label>
                                        <input type="text" name="specification_id">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="others">Specification Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="specification_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="specification_attachment[]"
                                                    oninput="addMultipleFiles(this, 'specification_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="STP Id">STP Id</label>
                                        <input type="text" name="STP_id">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="others">STP Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="STP_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="STP_attachment[]"
                                                    oninput="addMultipleFiles(this, 'STP_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Test Name">Test Name</label>
                                        <input type="text" name="test_name">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Test Method">Test Method</label>
                                        <input type="text" name="test_method">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Test Parameters">Test Parameters</label>
                                        <select name="test_parameter">
                                            <option>Select Tests</option>
                                            <option value="Description">Description</option>
                                            <option value="Weight Of 20 tablets">Weight Of 20 tablets</option>
                                            <option value="Average Weight ( mg )">Average Weight ( mg )</option>
                                            <option value="Thickness">Thickness</option>
                                            <option value="Disintigration Time">Disintigration Time</option>
                                            <option value="Hardness">Hardness</option>
                                            <option value="Diameter">Diameter</option>
                                            <option value="Friability">Friability</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Testing Frequency">Testing Frequency</label>
                                        <input type="text" name="testing_frequency">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Testing Location">Testing Location</label>
                                        <input type="text" name="testing_location">
                                    </div>
                                </div> -->

                                <!-- <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Test Grouping">Test Grouping</label>
                                                <input type="text" name="test_grouping">
                                            </div>
                                        </div> -->

                                <!-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="LSL">LSL</label>
                                        <input type="text" name="LSL">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="USL">USL</label>
                                        <input type="text" name="USL">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Testing Deadline">Testing Deadline</label>
                                        <input type="date" name="testing_deadline">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Planner Name">Planner Name</label>
                                        <input type="text" name="planner_name">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Source">Sample Source</label>
                                        <input type="text" name="sample_source">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Planned Date">Planned Date</label>
                                        <input type="date" name="planned_date">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Lab Technician">Lab Technician</label>
                                        <input type="text" name="lab_technician">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Cost Estimation">Sample Cost Estimation</label>
                                        <input type="text" name="sample_cost_estimation">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Resource Utilization">Resource Utilization</label>
                                        <input type="text" name="resource_utilization">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Assigned Department">Assigned Department</label>
                                        <input type="text" name="assigned_department">
                                    </div>
                                </div> -->

                                <!-- <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Test Grouping">Test Grouping</label>
                                                <input type="text" name="test_grouping2">
                                            </div>
                                        </div> -->

                                <!-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Collection Date">Sample Collection Date</label>
                                        <input type="date" name="sample_collection_date">
                                    </div>
                                </div> -->

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="delay_justification">Comment</label>
                                        <div class="relative-container">
                                            <textarea name="samplePreprationComment"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="others">Supporting Documents</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="supportive_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="supportive_attachment[]"
                                                    oninput="addMultipleFiles(this, 'supportive_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="button-block">
                                <button type="submit" id="ChangesaveButton"
                                    class="saveButton on-submit-disable-button ">Save</button>
                                <button type="button" id="ChangeNextButton" class="nextButton">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>


                    <!-- <div id="CCForm2" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Analysis Type">Analysis Type</label>
                                        <input type="text" name="analysis_type">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Analysis Result">Analysis Result</label>
                                        <input type="text" name="analysis_result">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Analysis Date">Analysis Date</label>
                                        <input type="date" name="analysis_date">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Testing Start Date">Testing Start Date</label>
                                        <input type="date" name="testin_start_date">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Testing End Date">Testing End Date</label>
                                        <input type="date" name="testin_End_date">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="delay_justification">Delay Justification</label>
                                        <div class="relative-container">
                                            <textarea name="delay_justification"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Testing Outcome">Testing End Date</label>
                                        <input type="date" name="testin_outcome">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Pass/Fail">Pass/Fail</label>
                                        <select name="pass_fail">
                                            <option value="">Select Value</option>
                                            <option value="Pass">Pass</option>
                                            <option value="Fail">Fail</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Test Plan Id">Test Plan Id</label>
                                        <input type="text" name="test_plan_id">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Turnaround Time (TAT)">Turnaround Time (TAT)</label>
                                        <input type="text" name="turnaround_time">
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Retesting Date">Sample Retesting Date</label>
                                        <input type="date" name="retesting_date">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Review Date">Review Date</label>
                                        <input type="date" name="review_date">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Storage Location">Sample Storage Location</label>
                                        <input type="text" name="storage_location">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Transportation Method">Transportation Method</label>
                                        <input type="text" name="transportation_method">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="delay_justification">Sample Preparation Method</label>
                                        <div class="relative-container">
                                            <textarea name="sample_prepration_method"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="delay_justification">Sample Packaging Details</label>
                                        <div class="relative-container">
                                            <textarea name="sample_packaging_detail"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Label">Sample Label</label>
                                        <input type="text" name="sample_lable">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Regulatory Requirements">Regulatory Requirements</label>
                                        <div class="relative-container">
                                            <textarea name="regulatory_requirement"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Quality Control Checks">Quality Control Checks</label>
                                        <input type="text" name="quality_control_checks">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Control Sample Reference">Control Sample Reference</label>
                                        <input type="text" name="control_sample_reference">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Control Sample">Control Sample</label>
                                        <input type="text" name="control_sample">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Reference Sample">Reference Sample</label>
                                        <input type="text" name="reference_sample">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Integrity Status">Sample Integrity Status</label>
                                        <select name="sample_integrity_status">
                                            <option value="">Select Status</option>
                                            <option value="Intact">Intact</option>
                                            <option value="Compromised">Compromised</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Assigned Department">Assigned Department</label>
                                        <input type="text" name="assigned_department">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Risk Assessment">Risk Assessment</label>
                                        <div class="relative-container">
                                            <textarea name="risk_assessment"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Supervisor">Supervisor</label>
                                        <input type="text" name="supervisor">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Instruments Reserved">Instruments Reserved</label>
                                        <input type="text" name="instruments_reserved">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Lab Availability">Lab Availability</label>
                                        <input type="text" name="lab_availability">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Date">Sample Date</label>
                                        <input type="date" name="sample_date">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sample Movement History">Sample Movement History</label>
                                        <div class="relative-container">
                                            <textarea name="sample_movement_history"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Testing Progress">Testing Progress</label>
                                        <div class="relative-container">
                                            <textarea name="testing_process"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Alerts/Notifications">Alerts/Notifications</label>
                                        <div class="relative-container">
                                            <textarea name="alert_notification"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Deviation Logs">Deviation Logs</label>
                                        <div class="relative-container">
                                            <textarea name="deviation_logs"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Comments/Notes">Comments/Notes</label>
                                        <div class="relative-container">
                                            <textarea name="comments_logs"></textarea>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="others">Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="sample_analysis_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="sample_analysis_attachment[]"
                                                    oninput="addMultipleFiles(this, 'sample_analysis_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Sampling Frequency">Sampling Frequency</label>
                                        <input type="text" name="sampling_frequency">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Stability Study Type">Stability Study Type</label>
                                        <select name="stability_type">
                                            <option value="">Select Status</option>
                                            <option value="Retained">Retained</option>
                                            <option value="Disposed">Disposed</option>
                                            <option value="Returned">Returned</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="others">Supporting Documents</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                            documents</small></div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="supportivesample_analysis_attachment"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile"
                                                name="supportivesample_analysis_attachment[]"
                                                oninput="addMultipleFiles(this, 'supportivesample_analysis_attachment')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="button-block">
                                <button type="submit" id="ChangesaveButton"
                                    class="saveButton on-submit-disable-button ">Save</button>
                                <button type="button" id="ChangeNextButton" class="nextButton">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div> -->

                    <div id="CCForm3" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Reviewer/Approver">Reviewer/Approver</label>
                                        <select name="reviewer_approver" id="">
                                            <option value="">Select Reviewer/Approver</option>
                                            @if(!empty($users))
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <!-- <input type="text" name="reviewer_approver"> -->
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Reviewer Comment">Reviewer Comment</label>
                                        <div class="relative-container">
                                            <textarea name="reviewer_comment"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Review Date">Review Date</label>
                                        <input type="date" name="review_date">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="others">Supervisor Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="supervisor_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="supervisor_attachment[]"
                                                    oninput="addMultipleFiles(this, 'supervisor_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" id="ChangesaveButton"
                                    class="saveButton on-submit-disable-button ">Save</button>
                                <button type="button" id="ChangeNextButton" class="nextButton">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <!-- <div id="CCForm4" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Stability Study Type">Stability Status</label>
                                        <select name="stability_status">
                                            <option value="">Select Status</option>
                                            <option value="Long Term">Long Term</option>
                                            <option value="Accelerated">Accelerated</option>
                                            <option value="Intermediate">Intermediate</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="others">Stability Study Protocol</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="stability_protocol"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="stability_protocol[]"
                                                    oninput="addMultipleFiles(this, 'stability_protocol')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Stability Protocol Approval Date">Stability Protocol Approval
                                            Date</label>
                                        <input type="date" name="stability_protocol_date">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Country of Regulatory Submissions">Country of Regulatory
                                            Submissions</label>
                                        <input type="text" name="submission_country">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="ICH ZoneICH Zone">ICH ZoneICH Zone</label>
                                        <input type="text" name="zone">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Photostability Testing Results">Photostability Testing Results</label>
                                        <input type="text" name="testing_result">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Reconstitution Stability">Reconstitution Stability</label>
                                        <input type="text" name="reconstitution_stability">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Testing Interval (Months)">Testing Interval (Months)</label>
                                        <select name="testing_interval">
                                            <option value="">Select Interval</option>
                                            <?php for ($i = 0; $i <= 60; $i++): ?>
                                            <option value="<?= $i ?>"><?= $i ?> Month</option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Shelf Life Recommendation">Shelf Life Recommendation</label>
                                        <input type="text" name="shelf_life_recommedation">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="others">Stability Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="stability_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="stability_attachment[]"
                                                    oninput="addMultipleFiles(this, 'stability_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" id="ChangesaveButton"
                                    class="saveButton on-submit-disable-button ">Save</button>
                                <button type="button" id="ChangeNextButton" class="nextButton">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div> -->

                    <div id="CCForm5" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="QA Reviewer/Approver">QA Reviewer/Approver</label>
                                        <select name="QA_reviewer_approver" id="">
                                            <option value="">Select QA Reviewer/Approver</option>
                                            @if(!empty($users))
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <!-- <input type="text" name="QA_reviewer_approver"> -->
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="QA Reviewer Comment">QA Reviewer Comment</label>
                                        <div class="relative-container">
                                            <textarea name="QA_reviewer_comment"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="QA Review Date">QA Review Date</label>
                                        <input type="text" name="QA_review_date">
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="others">QA Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="QA_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="QA_attachment[]"
                                                    oninput="addMultipleFiles(this, 'QA_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" id="ChangesaveButton"
                                    class="saveButton on-submit-disable-button ">Save</button>
                                <button type="button" id="ChangeNextButton" class="nextButton">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity Log content -->
                <div id="CCForm6" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Audit Schedule On">Sample Registration By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Audit Schedule On">Sample Registration On</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Audit Schedule On">Comment</label>
                                    <div class="static"></div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Audit Preparation Completed On"> Analysis Complete
                                        By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Audit Preparation Completed On">Analysis Complete
                                        On</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Audit Schedule On">Comment</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Audit Mgr.more Info Reqd By">Supervisor Review Complete By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Audit Mgr.more Info Reqd On"> Supervisor Review Complete On</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Audit Schedule On">Comment</label>
                                    <div class="static"></div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="No CAPA Required By">QA Review Complete By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="No Capa Required On">QA Review Complete On</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Audit Schedule On"> Comment</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Cancelled By">Cancelled By</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Cancelled On">Cancelled On</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="group-input">
                                    <label for="Audit Schedule On">Comment</label>
                                    <div class="static"></div>
                                </div>
                            </div>
                        </div>
                        <div class="button-block">
                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                            <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                    Exit </a> </button>
                        </div>
                    </div>
                </div>

        </div>
        </form>

    </div>
    </div>
    <!-- // Ananlyst (Muti , Qualified Ananlyst)
// Reagent (Mutip), Stock Transfers (Approved)
// Lab Technician(Muti , Qualified Ananlyst) -->


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
            ele: '#instrumentReserved, #labTechnicians, #Audit, #analystData ,#reagentData'
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
    <!-- Add the following script at the end of your HTML -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const supplierAgencies = document.getElementById('supplier_agencies');
            const othersGroup = document.getElementById('external_agencies_req');
            const othersField = document.getElementById('others');
            const othersLabel = othersField.previousElementSibling;

            function toggleOthersField(value) {
                if (value === 'others') {
                    othersGroup.style.display = 'block';
                    othersField.required = true;
                    othersLabel.querySelector('span').classList.remove('d-none');
                } else {
                    othersGroup.style.display = 'none';
                    othersField.required = false;
                    othersLabel.querySelector('span').classList.add('d-none');
                }
            }

            // Initial check
            toggleOthersField(supplierAgencies.value);

            // Add event listener
            supplierAgencies.addEventListener('change', function() {
                toggleOthersField(this.value);
            });
        });
    </script>

    <!-- for Voice Access -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const recognition = new(window.SpeechRecognition || window.webkitSpeechRecognition)();
            const docnameInput = document.getElementById('docname');
            const startRecordBtn = document.getElementById('start-record-btn');

            recognition.continuous = false;
            recognition.interimResults = false;
            recognition.lang = 'en-US';

            startRecordBtn.addEventListener('click', function() {
                recognition.start();
            });

            recognition.onresult = function(event) {
                const transcript = event.results[0][0].transcript;
                docnameInput.value += transcript;
            };

            recognition.onerror = function(event) {
                console.error(event.error);
            };
        });
    </script>
    <script>
        < link rel = "stylesheet"
        href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" >
    </script>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize speech recognition
            const recognition = new(window.SpeechRecognition || window.webkitSpeechRecognition)();
            recognition.continuous = false;
            recognition.interimResults = false;
            recognition.lang = 'en-US';

            // Function to start speech recognition and append result to the target element
            function startRecognition(targetElement) {
                recognition.start();
                recognition.onresult = function(event) {
                    const transcript = event.results[0][0].transcript;
                    targetElement.value += transcript;
                };
                recognition.onerror = function(event) {
                    console.error(event.error);
                };
            }


        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize speech recognition
            const recognition = new(window.SpeechRecognition || window.webkitSpeechRecognition)();
            recognition.continuous = false;
            recognition.interimResults = false;
            recognition.lang = 'en-US';

            // Function to start speech recognition and append result to the target element
            function startRecognition(targetElement) {
                recognition.start();
                recognition.onresult = function(event) {
                    const transcript = event.results[0][0].transcript;
                    targetElement.value += transcript;
                };
                recognition.onerror = function(event) {
                    console.error(event.error);
                };
            }

            function toggleOthersField(selectedValue) {
                const container = document.getElementById('external_agencies_req');
                if (selectedValue === 'others') {
                    container.classList.remove('d-none');
                } else {
                    container.classList.add('d-none');
                }
            }
        })
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize speech recognition
            const recognition = new(window.SpeechRecognition || window.webkitSpeechRecognition)();
            recognition.continuous = false;
            recognition.interimResults = false;
            recognition.lang = 'en-US';

            // Function to start speech recognition and append result to the target element
            function startRecognition(targetElement) {
                recognition.start();
                recognition.onresult = function(event) {
                    const transcript = event.results[0][0].transcript;
                    targetElement.value += transcript;
                };
                recognition.onerror = function(event) {
                    console.error(event.error);
                };
            }

            function toggleOthersField(selectedValue) {
                const container = document.getElementById('external_agencies_req');
                if (selectedValue === 'others') {
                    container.classList.remove('d-none');
                } else {
                    container.classList.add('d-none');
                }
            }
        });
    </script>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        $(document).ready(function() {
            let audio = null;
            let selectedLanguage = 'en-us'; // Default language
            let inputText = '';

            // When the user clicks the button, open the mini modal
            $(document).on('click', '.speak-btn', function() {
                let inputField = $(this).siblings('textarea, input');
                inputText = inputField.val();
                let modal = $(this).siblings('.mini-modal');
                if (inputText) {
                    // Store the input field element
                    $(modal).data('inputField', inputField);
                    modal.css({
                        display: 'block',
                        top: $(this).position().top - modal.outerHeight() - 10,
                        left: $(this).position().left + $(this).outerWidth() - modal.outerWidth()
                    });
                }
            });

            // When the user clicks on <span> (x), close the mini modal
            $(document).on('click', '.close', function() {
                $(this).closest('.mini-modal').css('display', 'none');
            });

            // When the user selects a language and clicks the button
            $(document).on('click', '#select-language-btn', function(event) {
                event.preventDefault(); // Prevent form submission
                let modal = $(this).closest('.mini-modal');
                selectedLanguage = modal.find('#language-select').val();
                let inputField = modal.data('inputField');
                let textToSpeak = inputText;

                if (textToSpeak) {
                    if (audio) {
                        audio.pause();
                        audio.currentTime = 0;
                    }

                    // Translate the text before converting to speech
                    translateText(textToSpeak, selectedLanguage.split('-')[0]).then(translatedText => {
                        const apiKey = '2273705f1f6f434194956a200a586470';
                        const url =
                            `https://api.voicerss.org/?key=${apiKey}&hl=${selectedLanguage}&src=${encodeURIComponent(translatedText)}&r=0&c=WAV&f=44khz_16bit_stereo`;
                        audio = new Audio(url);
                        audio.play();
                        audio.onended = function() {
                            audio = null;
                        };
                    });

                }

                modal.css('display', 'none');
            });

            // Speech-to-Text functionality
            const recognition = new(window.SpeechRecognition || window.webkitSpeechRecognition)();
            recognition.continuous = false;
            recognition.interimResults = false;
            recognition.lang = 'en-US';

            function startRecognition(targetElement) {
                recognition.start();
                recognition.onresult = function(event) {
                    const transcript = event.results[0][0].transcript;
                    targetElement.value += transcript;
                };
                recognition.onerror = function(event) {
                    console.error(event.error);
                };
            }


            async function translateText(text, targetLanguage) {
                const url = 'https://text-translator2.p.rapidapi.com/translate';
                const data = new FormData();
                data.append('source_language', 'en');
                data.append('target_language', targetLanguage);
                data.append('text', text);

                const options = {
                    method: 'POST',
                    headers: {
                        'x-rapidapi-key': '5246c9098fmshc966ee7f6cea588p14a110jsn3979434fe858',
                        'x-rapidapi-host': 'text-translator2.p.rapidapi.com'
                    },
                    body: data
                };

                const response = await fetch(url, options);
                const result = await response.json();
                return result.data.translatedText;
            }

            // Update remaining characters
            $('#docname').on('input', function() {
                const remaining = 255 - $(this).val().length;
                $('#rchars').text(remaining);
            });

            // Initialize remaining characters count
            const remaining = 255 - $('#docname').val().length;
            $('#rchars').text(remaining);
        });
    </script>


    <style>
        #external_agencies_req {
            display: none;
        }
    </style>
    <script>
        $(document).ready(function() {

            $('.mainform').on('submit', function(e) {
                $('.on-submit-disable-button').prop('disabled', true);
            });
        })
    </script>
@endsection