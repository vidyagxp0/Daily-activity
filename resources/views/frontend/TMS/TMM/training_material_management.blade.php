@extends('frontend.layout.main')
@section('container')
    <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
        }
    </style>
    <style>
        .vscomp-toggle-button {
            border-color: gray !important;
        }
    </style>
    <style>
        .blank-space {
            display: block;
            width: 100%;
            height: 200px;
            /* adjust the height as needed */
            background-color: transparent;
            /* make it transparent if you want */
        }
    </style>

    <div class="form-field-head">

        <div class="division-bar">
            {{-- <strong>Site Division/Project</strong> : --}}
            Training Module Management
        </div>
    </div>
    @php
        $users = DB::table('users')->get();
    @endphp


    <div id="change-control-fields">
        <div class="container-fluid">

            <!-- Tab links -->
            <div class="cctab">
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Informantion</button>
                {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Risk/Opportunity details </button> --}}
                <button class="cctablinks" onclick="openCity(event, 'CCForm2')"> Categorization </button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Progress and Tracking</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Compliance and Review</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Supplementary Modules</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Activity Log</button>
            </div>

            <form action="{{ route('TMM.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div id="step-form">

                    <!-- General Form Tab content -->
                    <div id="CCForm1" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="sub-head">
                                General Information
                            </div>
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Site/Location">Site/Location</label>
                                        <select id="training-select" name="site_division" onchange="toggleMultiSelect()">
                                            <option value="">Select Division</option>
                                            <option value="P1 (Indore Location)">P1 (Indore Location)</option>
                                            <option value="P2 (Pithampur Location)">P2 (Pithampur Location)</option>
                                            <option value="P4 (Ujjain Site)">P4 (Ujjain Site)</option>
                                            <option value="C1 (China Plant)">C1 (China Plant)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6"> 
                                    <div class="group-input">
                                        <label for="Training Module ID">Training Module ID</label>
                                        <input name="traning_material_id" id="traning_material_id"
                                            value="TMM{{ $record_number }}" readonly />
                                    </div>
                                </div>

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

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span
                                                class="text-danger">*</span></label><span id="rchars">255</span>
                                        characters remaining
                                        <input name="short_description" id="short_description" required />
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Title">Title<span class="text-danger">*</span></label>
                                        <textarea type="text" name="title" id="title" required></textarea>
                                    </div>
                                </div>


                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">Description</label>
                                        <textarea type="text" name="description" id="description"></textarea>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Type of Module">Type of Module</label>
                                        <select name="Type_of_Material" id="Type_of_Material">
                                            <option value="">--Select--</option>
                                            <option value="PDF">PDF</option>
                                            <option value="Video">Video</option>
                                            <option value="Presentation">Presentation</option>
                                            <option value="Quiz">Quiz</option>
                                            <option value="Manual">Manual</option>
                                        </select>
                                    </div>
                                </div>


                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Author/Instructor">Author/Instructor</label>
                                        <select name="Instructor" id="Instructor">
                                            <option value="">Enter Your Selection Here</option>

                                        </select>
                                    </div>
                                </div> --}}

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="Author/Instructor">Author/Instructor</label>
                                        <select id="Instructor" placeholder="Select..." name="Instructor">
                                            <option value="">Select a value</option>
                                            @foreach ($users as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Version Number">Version Number</label>
                                        <input type="number" name="version_num" id="version_num" min="0">
                                    </div>
                                </div>


                                {{-- <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Creation Date">Creation Date</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="Creation_date" readonly placeholder="DD-MMM-YYYY" />
                                            <input type="date" id="Creation_date_checkdate" name="Creation_date"
                                                class="hide-input"
                                                oninput="handleDateInput(this, 'Creation_date');checkDate('Creation_date_checkdate','last_updated_date_checkdate')" />
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="col-lg-6  new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Last Updated Date">Last Updated Date<span class="text-danger">*</span>
                                        </label>
                                        <div class="calenderauditee">
                                            <input type="text" id="last_updated_date" placeholder="DD-MMM-YYYY"
                                                required />
                                            <input type="date" id="last_updated_date_checkdate" name="last_updated_date"
                                                class="hide-input" required
                                                oninput="handleDateInput(this, 'last_updated_date');checkDate('Creation_date_checkdate','last_updated_date_checkdate')" />
                                        </div>

                                    </div>
                                </div>
                                   

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Reference Document">Reference Document</label>
                                        <select name="Reference_Document" id="Reference_Document">
                                            <option value="">----Select---</option>
                                            @foreach ($ref_doc as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->sop_type_short }}/{{ $item->department_id }}/000{{ $item->id }}/R{{ $item->major }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Attachments">Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant Attachments</small>
                                        </div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Attachments"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="Attachments" name="Attachments[]"
                                                    oninput="addMultipleFiles(this, 'Attachments')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="col-6">
                                    <div class="group-input">
                                        <label for="Status">Status</label>
                                        <select name="Status" id="Status">
                                            <option value="">--Select--</option>
                                            <option value="Active">Active</option>
                                            <option value="Archieved">Archieved</option>
                                            <option value="In Review">In Review</option>
                                        </select>
                                    </div>
                                </div> --}}


                            </div>

                            <div class="button-block">
                                <button type="submit" id="ChangesaveButton01" class="saveButton">Save</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('TMS') }}" class="text-white"> Exit </a>
                                </button>
                            </div>
                        </div>

                    </div>
                    <div id="CCForm2" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="sub-head">
                                Categorization
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Training Category">Training Category</label>

                                        <select name="Training_Category">
                                            <option value="">-- Select --</option>
                                            <option value="Compliance">Compliance</option>
                                            <option value="Technical">Technical</option>
                                            <option value="Onboarding">Onboarding</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Tags/Keywords">Tags/Keywords</label>
                                        <input type="text" name="Keywords" id="Keywords">
                                    </div>
                                </div>
                                {{-- <div class="col-6">
                                    <div class="group-input">
                                        <label for="language">Language</label>
                                        <input type="text" name="language" id="language">
                                    </div>
                                </div> --}}
                                {{-- <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Department">Department</label>

                                        <select name="Department">
                                            <option value="">-- Select --</option>
                                            <option value="HR">HR</option>
                                            <option value="Quality">Quality</option>
                                            <option value="Operations">Operations</option>
                                        </select>
                                    </div>
                                </div> --}}

                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Department">Department</label>
                                        <select name="Department" id="Department" onchange="toggleOtherDepartment()">
                                            @foreach (Helpers::getDepartments() as $code => $Department)
                                                <option value="{{ $code }}"
                                                    {{ old('Department') == $code ? 'selected' : '' }}>
                                                    {{ $Department }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Department">Department</label>
                                        <select multiple name="Department[]" placeholder="Select Department"
                                            data-search="false" data-silent-initial-value-set="true" id="Department">
                                            @foreach (Helpers::getDepartments() as $code => $Department)
                                                <option value="{{ $Department }}"> {{ $Department }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="blank-space">
                                </div>

                            </div>


                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('TMS') }}" class="text-white"> Exit</a>
                                </button>

                            </div>

                        </div>

                    </div>

                    <div id="CCForm3" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="sub-head">
                                Progress and Tracking
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Training Duration">Training Duration (in minutes)</label>
                                        <input type="number" name="training_duration" id="training_duration"
                                            min="0">
                                    </div>
                                </div>
                            </div>


                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('TMS') }}" class="text-white"> Exit </a>
                                </button>
                            </div>
                        </div>

                    </div>




                    <div id="CCForm4" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="sub-head">
                                Compliance and Review
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Regulatory Requirement">Regulatory Requirement</label>

                                        <select name="regulatory_requirement">
                                            <option value="">-- Select --</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Revision History">Revision History</label>
                                        <textarea type="text" name="revision_history" id="revision_history"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Review Frequency">Review Frequency</label>

                                        <select name="review_frequency">
                                            <option value="">-- Select --</option>
                                            <option value="Daily">Daily</option>
                                            <option value="Weekly">Weekly</option>
                                            <option value="Monthly">Monthly</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Reviewer/Approver">Reviewer/Approver</label>

                                        <select name="approver">
                                            <option value="">-- Select --</option>

                                        </select>
                                    </div>
                                </div> --}}
                                <div class="col-md-12">
                                    <div class="group-input">
                                        <label for="Reviewer/Approver">Reviewer/Approver</label>
                                        <select id="approver" placeholder="Select..." name="approver">
                                            <option value="">Select a value</option>
                                            @foreach ($users as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('TMS') }}" class="text-white"> Exit </a>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="CCForm5" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="sub-head">
                                Supplementary Modules
                            </div>
                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Supporting Documents">Supporting Documents</label>
                                        <div><small class="text-primary">
                                            </small>
                                        </div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Supporting_Documents"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="Supporting_Documents"
                                                    name="Supporting_Documents[]"
                                                    oninput="addMultipleFiles(this, 'Supporting_Documents')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="External Links">External Links</label>
                                        <input type="url" name="external_links" />
                                    </div>
                                </div>
                            </div>

                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('TMS') }}" class="text-white"> Exit </a>
                                </button>
                            </div>
                        </div>

                    </div>

                    <div id="CCForm6" class="inner-block cctabcontent">
                        <div class="inner-block-content">

                            <div class="sub-head">
                                Activity Log
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Create Training Module By">Create Training Module By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Create Training Module On">Create Training Module On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Create Training Module Comment">Create Training Module Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for=" Training Module Created By">Training Module Created By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Training Module Created On">Training Module Created On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Training Module Created Comment">Training Module Created
                                            Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="HOD Review Complete By">HOD Review Complete By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="HOD Review Complete On">HOD Review Complete On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="HOD Review Complete Comment">HOD Review Complete Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="QA Review Complete By">QA Review Complete By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="QA Review Complete On">QA Review Complete On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="QA Review Complete Comment">QA Review Complete Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button"> <a href="{{ url('TMS') }}" class="text-white"> Exit </a>

                            </div>
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
        VirtualSelect.init({
            ele: '#Department'
        });


        $(document).on('click', '.removeBtn', function() {
            console.log('click ');
            $(this).closest('tr').remove();
        })

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

    {{-- <script>
        VirtualSelect.init({
            ele: '#departments,#departments_2, #team_members, #training-require, #impacted_objects'
        });
    </script> --}}
    <script>
        // JavaScript
        document.getElementById('initiator_group').addEventListener('change', function() {
            var selectedValue = this.value;
            document.getElementById('initiator_group_code').value = selectedValue;
        });
    </script>

    <script>
        $(document).ready(function() {


        });
    </script>

    {{--  <script>
        $(document).on('click', '.removeRowBtn', function() {
            $(this).closest('tr').remove();
        })
        </script>  --}}

    <script>
        var maxLength = 255;
        $('#docname').keyup(function() {
            var textlen = maxLength - $(this).val().length;
            $('#rchars').text(textlen);
        });
    </script>

    {{-- <script>
        document.getElementById('action_plan').addEventListener('click', function() {
            var table = document.getElementById('action_plan_details').getElementsByTagName('tbody')[0];
            var rowCount = table.rows.length;
            var newRow = table.insertRow(rowCount);
            var serialNumber = rowCount + 1;

            var cell1 = newRow.insertCell(0);
            var cell2 = newRow.insertCell(1);
            var cell3 = newRow.insertCell(2);
            var cell4 = newRow.insertCell(3);
            var cell5 = newRow.insertCell(4);
            var cell6 = newRow.insertCell(5);

            cell1.innerHTML = '<input type="text" name="serial_number[]" value="' + serialNumber + '" disabled>';
            cell2.innerHTML = '<input type="text" name="action[]">';
            cell3.innerHTML =
                '<select id="select-state" placeholder="Select..." name="responsible[]"><option value="">Select a value</option>@foreach ($users as $user)<option value="{{ $user->id }}">{{ $user->name }}</option>@endforeach</select>';
            cell4.innerHTML =
                '<div class="group-input new-date-data-field mb-0"><div class="input-date"><div class="calenderauditee"><input type="text" id="deadline' +
                serialNumber +
                '" readonly placeholder="DD-MMM-YYYY" /><input type="date" name="deadline[]" class="hide-input" oninput="handleDateInput(this, \'deadline' +
                serialNumber + '\')" /></div></div></div>';
            cell5.innerHTML = '<input type="text" name="item_static[]">';
            cell6.innerHTML = '<button type="button" class="removeRowBtn">Remove</button>';
        });

        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('removeRowBtn')) {
                var row = e.target.closest('tr');
                row.parentNode.removeChild(row);
            }
        });

        function handleDateInput(input, targetId) {
            var target = document.getElementById(targetId);
            if (target) {
                target.value = new Date(input.value).toLocaleDateString('en-GB', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                }).replace(/ /g, '-');
            }
        }
    </script> --}}

    {{-- <script>
        function addMitigationPlan() {
            var table = document.getElementById('action_plan_details02').getElementsByTagName('tbody')[0];
            var rowCount = table.rows.length;
            var serialNumber = rowCount + 1;
            var newRow = table.insertRow(rowCount);

            newRow.innerHTML = `
        <td><input type="text" name="serial_number[]" value="${serialNumber}" disabled></td>
        <td><input type="text" name="mitigation_steps[]"></td>
        <td>
            <div class="group-input new-date-data-field mb-0">
                <div class="input-date">
                    <div class="calenderauditee">
                        <input type="text" id="deadline2_${serialNumber}" readonly placeholder="DD-MMM-YYYY" />
                        <input type="date" name="deadline2[]" class="hide-input" oninput="handleDateInput(this, 'deadline2_${serialNumber}')" />
                    </div>
                </div>
            </div>
        </td>
        <td>
            <select id="select-state" placeholder="Select..." name="responsible_person[]">
                <option value="">Select a value</option>
                @foreach ($users as $data)
                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                @endforeach
            </select>
        </td>
        <td><input type="text" name="status[]"></td>
        <td><input type="text" name="remark[]"></td>
        <td><button type="button" class="removeRowBtn">Remove</button></td>
    `;

            // Reinitialize event listener for the new row's remove button
            initializeRemoveButtons();
        }

        function initializeRemoveButtons() {
            var removeButtons = document.getElementsByClassName('removeRowBtn');
            for (var i = 0; i < removeButtons.length; i++) {
                removeButtons[i].onclick = function() {
                    var row = this.closest('tr');
                    row.parentNode.removeChild(row);
                    updateSerialNumbers();
                };
            }
        }

        function updateSerialNumbers() {
            var table = document.getElementById('action_plan_details02').getElementsByTagName('tbody')[0];
            var rows = table.getElementsByTagName('tr');
            for (var i = 0; i < rows.length; i++) {
                var serialNumberCell = rows[i].getElementsByTagName('td')[0];
                serialNumberCell.getElementsByTagName('input')[0].value = i + 1;
            }
        }

        function handleDateInput(input, targetId) {
            var target = document.getElementById(targetId);
            var date = new Date(input.value);
            var options = {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            };
            target.value = date.toLocaleDateString(undefined, options);
        }

        // Initialize remove buttons for the first row
        initializeRemoveButtons();
    </script> --}}
@endsection
