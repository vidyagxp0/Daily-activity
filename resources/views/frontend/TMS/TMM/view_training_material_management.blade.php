@extends('frontend.layout.main')
@section('container')
    @php
        $users = DB::table('users')->select('id', 'name')->where('active', 1)->get();
        $userRoles = DB::table('user_roles')->select('user_id')->where('q_m_s_roles_id', 4)->distinct()->get();
    
        $divisions = DB::table('q_m_s_divisions')->select('id', 'name')->get();

        $userIds = DB::table('user_roles')->where('q_m_s_roles_id', 4)->distinct()->pluck('user_id');


        $userNames = DB::table('users')->whereIn('id', $userIds)->pluck('name');

        $userDetails = DB::table('users')->whereIn('id', $userIds)->select('id', 'name')->get();
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

        #change-control-fields>div>div.inner-block.state-block>div.status>div.progress-bars.d-flex>div:nth-child(5) {
            border-radius: 0px 20px 20px 0px;

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
    <script>
        function handleDateInput(input, targetId) {
            const target = document.getElementById(targetId);
            const date = new Date(input.value);
            const options = {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            };
            const formattedDate = date.toLocaleDateString('en-US', options).replace(/ /g, '-');
            target.value = formattedDate;
        }
    </script>

    <div class="form-field-head">
        <div class="pr-id">
            Training Module Management
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


                        <button class="button_theme1">
                            <a class="text-white" href="{{ route('audittrail', $trainingTMM->id) }}"> Audit Trail
                            </a>
                        </button>
                        @if ($trainingTMM->stage == 1)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Create Training Module
                            </button>
                        @elseif($trainingTMM->stage == 2)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Training Module Created
                            </button>
                        @elseif($trainingTMM->stage == 3)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                HOD Review Complete
                            </button>
                        @elseif($trainingTMM->stage == 4)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                QA Review Complete
                            </button>
                        @endif
                        <button class="button_theme1"> <a class="text-white" href="{{ url('TMS') }}"> Exit
                            </a>
                        </button>


                    </div>

                </div>
                <div class="status">
                    <div class="head">Current Status</div>
                    {{-- ------------------------------By Pankaj-------------------------------- --}}
                    @if ($trainingTMM->stage == 0)
                        <div class="progress-bars ">
                            <div class="bg-danger">Closed-Cancelled</div>
                        </div>
                    @else
                        <div class="progress-bars d-flex">
                            @if ($trainingTMM->stage >= 1)
                                <div class="active">Opened</div>
                            @else
                                <div class="">Opened</div>
                            @endif

                            @if ($trainingTMM->stage >= 2)
                                <div class="active">Pending Training Module Creation</div>
                            @else
                                <div class="">Pending Training Module Creation</div>
                            @endif
                            @if ($trainingTMM->stage >= 3)
                                <div class="active">Pending HOD Review</div>
                            @else
                                <div class="">Pending HOD Review</div>
                            @endif
                            @if ($trainingTMM->stage >= 4)
                                <div class="active">Pending QA Review</div>
                            @else
                                <div class="">Pending QA Review</div>
                            @endif

                            @if ($trainingTMM->stage >= 5)
                                <div class="bg-danger">Closed - Done</div>
                            @else
                                <div class="">Closed-Complete</div>
                            @endif
                    @endif


                </div>
                {{-- @endif --}}
            </div>
        </div>
        <!-- Tab links -->
        <div class="cctab">

            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Informantion</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')"> Categorization </button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Progress and Tracking</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Compliance and Review</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Supplementary Modules</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Activity Log</button>

        </div>
        <script>
            $(document).ready(function() {
                <?php if ($trainingTMM->stage == 5) : ?>
                $("#target :input").prop("disabled", true);
                <?php endif; ?>
            });
        </script>

        <form id="target" action="{{ route('TMM.update', $trainingTMM->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <!-- Tab content -->
            <div id="step-form">

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
                                        <option value="P1 (Indore Location)"
                                            @if ($trainingTMM->site_division == 'P1 (Indore Location)') selected @endif>
                                            P1 (Indore Location)</option>
                                        <option value="P2 (Pithampur Location)"
                                            @if ($trainingTMM->site_division == 'P2 (Pithampur Location)') selected @endif>P2
                                            (Pithampur Location)
                                        </option>
                                        <option value="P4 (Ujjain Site)" @if ($trainingTMM->site_division == 'P4 (Ujjain Site)') selected @endif>
                                            P4 (Ujjain
                                            Site)</option>
                                        <option value="C1 (China Plant)" @if ($trainingTMM->site_division == 'C1 (China Plant)') selected @endif>
                                            C1 (China Plant)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Training Module ID">Training Module ID</label>
                                    <input name="traning_material_id" id="traning_material_id"
                                        value="TMM{{ str_pad($trainingTMM->traning_material_id, 4, '0', STR_PAD_LEFT) }}"
                                        readonly />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Prepared_by">Prepared By </label>
                                    <input type="text" name="Prepared_by" value="{{Helpers::getInitiatorName($trainingTMM->Prepared_by)}}" readonly>
                                </div>
                            </div>

                        
                            <div class="col-lg-6  new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Prepared_date">Prepared On</lable>
                                        <div class="calenderauditee">
                                            <input type="text" id="Prepared_date" required
                                                placeholder="DD-MMM-YYYY"value="{{ Helpers::getdateFormat($trainingTMM->Prepared_date) }}" readonly >
                                          
                                        </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Short Description<span
                                            class="text-danger">*</span></label><span id="rchars">255</span> characters
                                    remaining
                                    <input type="text" name="short_description" id="short_description"
                                        value="{{ $trainingTMM->short_description }}" required>
                                </div>
                                <p id="docnameError" style="color:red">**Short Description is required</p>
                            </div>


                            <div class="col-lg-12 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Title">Title<span class="text-danger">*</span></label>
                                    <textarea type="text" name="title" id="title" required>{{ $trainingTMM->title }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-12 new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Description">Description</label>
                                    <textarea type="text" name="description" id="description">{{ $trainingTMM->description }}</textarea>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Type of Module">Type of Module</label>
                                    <select name="Type_of_Material">
                                        <option value="">Enter Your Selection Here</option>
                                        <option value="PDF" @if ($trainingTMM->Type_of_Material == 'PDF') selected @endif>PDF
                                        </option>
                                        <option value="Video" @if ($trainingTMM->Type_of_Material == 'Video') selected @endif>Video
                                        </option>
                                        <option value="Presentation" @if ($trainingTMM->Type_of_Material == 'Presentation') selected @endif>
                                            Presentation
                                        </option>
                                        <option value="Quiz" @if ($trainingTMM->Type_of_Material == 'Quiz') selected @endif>Quiz
                                        </option>
                                        <option value="Manual" @if ($trainingTMM->Type_of_Material == 'Manual') selected @endif>Manual
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="Author/Instructor">Author/Instructor</label>
                                    <select id="Instructor" placeholder="Select..." name="Instructor">
                                        <option value="">Select a value</option>
                                        @foreach ($users as $key => $value)
                                            <option @if ($trainingTMM->Instructor == $value->id) selected @endif
                                                value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Version Number">Version Number</label>
                                    <input type="number" name="version_num" value="{{ $trainingTMM->version_num }}"
                                        min="0">
                                </div>
                            </div>

                           

                            <div class="col-lg-6  new-date-data-field">
                                <div class="group-input input-date">
                                    <label for="Last Updated Date">Last Updated Date</lable>
                                        <div class="calenderauditee">
                                            <input type="text" id="last_updated_date" required
                                                placeholder="DD-MMM-YYYY"value="{{ Helpers::getdateFormat($trainingTMM->last_updated_date) }}" />
                                            <input type="date" value="{{ $trainingTMM->last_updated_date }}"
                                                id="last_updated_date_checkdate" name="last_updated_date"
                                                class="hide-input" required
                                                oninput="handleDateInput(this, 'last_updated_date');checkDate('Creation_date_checkdate','last_updated_date_checkdate')" />
                                        </div>
                                </div>
                            </div>
                              

                            <div class="col-md-12">
                                <div class="group-input">
                                    <label for="Reference Document">Reference Document</label>
                                    <select name="Reference_Document" id="Reference_Document">
                                        <option value="">---Select Document Number---</option>
                                        @foreach ($ref_doc as $item)
                                            <option value="{{ $item->id }}"
                                                data-doc-number="{{ $item->sop_type_short }}/{{ $item->department_id }}/000{{ $item->id }}/R{{ $item->major }}"
                                                data-sop-id="{{ $item->id }}"
                                                {{ $trainingTMM->Reference_Document == $item->id ? 'selected' : '' }}>
                                                {{ $item->sop_type_short }}/{{ $item->department_id }}/000{{ $item->id }}/R{{ $item->major }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="group-input">
                                    <label for="Attachments">Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant Attachments</small></div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="Attachments">
                                            @if ($trainingTMM->Attachments)
                                                @foreach (json_decode($trainingTMM->Attachments) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                                            <i class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i>
                                                        </a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}">
                                                            <i class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i>
                                                        </a>
                                                        <input type="hidden" name="existing_Attachments[]"
                                                            value="{{ $file }}">
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="Attachments" name="Attachments[]"
                                                oninput="addMultipleFiles(this, 'Attachments')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>

                           


                        </div>

                        <div class="button-block">
                            <button type="submit" id="ChangesaveButton01" class="saveButton">Save</button>
                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                        </div>

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
                                    <option value="Compliance" @if ($trainingTMM->Training_Category == 'Compliance') selected @endif>
                                        Compliance
                                    </option>
                                    <option value="Technical" @if ($trainingTMM->Training_Category == 'Technical') selected @endif>
                                        Technical
                                    </option>
                                    <option value="Onboarding" @if ($trainingTMM->Training_Category == 'Onboarding') selected @endif>
                                        Onboarding
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Tags/Keywords">Tags/Keywords</label>
                                <input type="text" name="Keywords" value="{{ $trainingTMM->Keywords }}">
                            </div>
                        </div>

                      
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Department">Department</label>
                                <select multiple name="Department[]" placeholder="Select Department" data-search="false"
                                    data-silent-initial-value-set="true" id="Department">

                                    @foreach (Helpers::getDepartments() as $code => $Department)
                                        @if (in_array($Department, $savedDepartmentId))
                                            <option value="{{ $Department }}"
                                                {{ in_array($Department, $savedDepartmentId) ? 'selected' : '' }}>
                                                {{ $Department }}</option>
                                        @else
                                            <option value="{{ $Department }}">
                                                {{ $Department }}</option>
                                        @endif
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

                    </div>
                </div>
            </div>

            <div id="CCForm3" class="inner-block cctabcontent">
                <div class="inner-block-content">
                    <div class="sub-head">
                        Progress and Tracking
                    </div>
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Training Duration">Training Duration (In Minutes)</label>
                                <input type="number" name="training_duration"
                                    value="{{ $trainingTMM->training_duration }}" min="0">
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
                                    <option value="Yes" @if ($trainingTMM->regulatory_requirement == 'Yes') selected @endif>
                                        Yes
                                    </option>
                                    <option value="No" @if ($trainingTMM->regulatory_requirement == 'No') selected @endif>
                                        No
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Revision History">Revision History</label>
                                <textarea name="revision_history">{{ $trainingTMM->revision_history }}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Review Frequency">Review Frequency</label>
                                <select name="review_frequency">
                                    <option value="">-- Select --</option>
                                    <option value="Daily" @if ($trainingTMM->review_frequency == 'Daily') selected @endif>
                                        Daily
                                    </option>
                                    <option value="Weekly" @if ($trainingTMM->review_frequency == 'Weekly') selected @endif>
                                        Weekly
                                    </option>
                                    <option value="Monthly" @if ($trainingTMM->review_frequency == 'Monthly') selected @endif>
                                        Monthly
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="group-input">
                                <label for="Reviewer/Approver">Reviewer/Approver</label>
                                <select id="approver" placeholder="Select..." name="approver">
                                    <option value="">Select a value</option>
                                    @foreach ($users as $key => $value)
                                        <option @if ($trainingTMM->approver == $value->id) selected @endif
                                            value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
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
            <div id="CCForm5" class="inner-block cctabcontent">
                <div class="inner-block-content">

                    <div class="sub-head">
                        Supplementary Modules
                    </div>
                    <div class="row">

                    

                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Supporting Documents">Supporting Documents</label>
                                <div><small class="text-primary">Please Attach all relevant or supporting
                                        documents</small></div>
                                <div class="file-attachment-field">
                                    <div class="file-attachment-list" id="Supporting_Documents">
                                        @if ($trainingTMM->Supporting_Documents)
                                            @foreach (json_decode($trainingTMM->Supporting_Documents) as $file)
                                                <h6 type="button" class="file-container text-dark"
                                                    style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                                        <i class="fa fa-eye text-primary"
                                                            style="font-size:20px; margin-right:-10px;"></i>
                                                    </a>
                                                    <a type="button" class="remove-file"
                                                        data-file-name="{{ $file }}">
                                                        <i class="fa-solid fa-circle-xmark"
                                                            style="color:red; font-size:20px;"></i>
                                                    </a>
                                                    <input type="hidden" name="existing_Supporting_Documents[]"
                                                        value="{{ $file }}">
                                                </h6>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="add-btn">
                                        <div>Add</div>
                                        <input type="file" id="Supporting_Documents" name="Supporting_Documents[]"
                                            oninput="addMultipleFiles(this, 'Supporting_Documents')" multiple>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="External Links">External Links</label>
                                <input type="url" name="external_links" value="{{ $trainingTMM->external_links }}">
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
            <div id="CCForm6" class="inner-block cctabcontent">
                <div class="inner-block-content">

                    <div class="sub-head">
                        Activity Log
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="Create Training Module By">Create Training Module By</label>
                                <div class="static">{{ $trainingTMM->Create_Training_Material_by }}</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="Create Training Module On">Create Training Module On</label>
                                <div class="static">
                                    {{ $trainingTMM->Create_Training_Material_on }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="Create Training Module Comment">Create Training Module Comment</label>
                                <div class="static">
                                    {{ $trainingTMM->Create_Training_Material_comment }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for=" Training Module Created By">Training Module Created By</label>
                                <div class="static">{{ $trainingTMM->Training_Material_Created_by }}</div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="Training Module Created On">Training Module Created On</label>
                                <div class="static">{{ $trainingTMM->Training_Material_Created_on }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="Training Module Created Comment">Training Module Created Comment</label>
                                <div class="static">{{ $trainingTMM->Training_Material_Created_comment }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="HOD Review Complete By">HOD Review Complete By</label>
                                <div class="static">{{ $trainingTMM->HOD_Review_Complete_by }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="HOD Review Complete On">HOD Review Complete On</label>
                                <div class="static">{{ $trainingTMM->HOD_Review_Complete_on }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="HOD Review Complete Comment">HOD Review Complete Comment</label>
                                <div class="static">{{ $trainingTMM->HOD_Review_Complete_comment }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="QA Review Complete By">QA Review Complete By</label>
                                <div class="static">{{ $trainingTMM->Complete_by }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="QA Review Complete On">QA Review Complete On</label>
                                <div class="static">{{ $trainingTMM->Complete_on }}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="group-input">
                                <label for="QA Review Complete Comment">QA Review Complete Comment</label>
                                <div class="static">{{ $trainingTMM->Complete_comment }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="button-block">
                        <button type="submit" class="saveButton">Save</button>
                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                        {{-- <button type="button" class="nextButton" onclick="nextStep()">Next</button> --}}

                    </div>
                </div>
            </div>

        </form>
    </div>
    </div>


    <style>
        .vscomp-toggle-button {
            border-color: gray !important;
        }
    </style>
    {{-- Child   --}}
    <div class="modal fade" id="child-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Child</h4>
                </div>
                <div class="model-body">

                    <form action="{{ route('employee.child', $trainingTMM->id) }}" method="POST">
                        @csrf
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="group-input">
                                <label style="display: flex;" for="major">
                                    <input type="radio" name="child_type" id="major" value="induction_training">
                                    Induction Training
                                </label>


                            </div>

                        </div>


                        <div class="modal-footer">
                            <button type="submit">Submit</button>
                            <button type="button" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>




    <div class="modal fade" id="signature-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ url('tms/tmm/sendstage', $trainingTMM->id) }}" method="POST" id="signatureModalForm">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const removeButtons = document.querySelectorAll('.remove-file');

            removeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const fileName = this.getAttribute('data-file-name');
                    const fileContainer = this.closest('.file-container');

                    // Hide the file container
                    if (fileContainer) {
                        fileContainer.style.display = 'none';
                        // Remove hidden input associated with this file
                        const hiddenInput = fileContainer.querySelector('input[type="hidden"]');
                        if (hiddenInput) {
                            hiddenInput.remove();
                        }

                        // Add the file name to the deleted files list
                        const deletedFilesInput = document.getElementById(
                            'deleted_HOD_Attachments1');
                        let deletedFiles = deletedFilesInput.value ? deletedFilesInput.value.split(
                            ',') : [];
                        deletedFiles.push(fileName);
                        deletedFilesInput.value = deletedFiles.join(',');
                    }
                });
            });
        });

        function addMultipleFiles(input, id) {
            const fileListContainer = document.getElementById(id);
            const files = input.files;

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const fileName = file.name;
                const fileContainer = document.createElement('h6');
                fileContainer.classList.add('file-container', 'text-dark');
                fileContainer.style.backgroundColor = 'rgb(243, 242, 240)';

                const fileText = document.createElement('b');
                fileText.textContent = fileName;

                const viewLink = document.createElement('a');
                viewLink.href = '#'; // Adjust this if needed for local previews
                viewLink.target = '_blank';
                viewLink.innerHTML = '<i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i>';

                const removeLink = document.createElement('a');
                removeLink.classList.add('remove-file');
                removeLink.dataset.fileName = fileName;
                removeLink.innerHTML = '<i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i>';
                removeLink.addEventListener('click', function() {
                    fileContainer.style.display = 'none';
                });

                fileContainer.appendChild(fileText);
                fileContainer.appendChild(viewLink);
                fileContainer.appendChild(removeLink);

                fileListContainer.appendChild(fileContainer);
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
            ele: '#Department'
        });
    </script>

@endsection
