@extends('frontend.layout.main')
@section('container')
    @php
        $users = DB::table('users')->select('id', 'name')->where('active', 1)->get();
        $userRoles = DB::table('user_roles')->select('user_id')->where('q_m_s_roles_id', 4)->distinct()->get();
        // $Department = DB::table('departments')->select('id', 'name')->get();
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
    {{-- <script>
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
    </script> --}}

    <div class="form-field-head">
        <div class="pr-id">
            Yearly Training Planner
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
                            <a class="text-white" href="{{ route('audit_trail', $dataYTP->id) }}"> Audit Trail
                            </a>
                        </button>
                        @if ($dataYTP->stage == 1)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Submit
                            </button>
                            <a href="#cancel-modal"> <button class="button_theme1" data-bs-toggle="modal"
                                    data-bs-target="#cancel-modal">
                                    Cancel
                                </button></a>
                        @elseif($dataYTP->stage == 2)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Review
                            </button>
                            <a href="#rejection-modal"> <button class="button_theme1" data-bs-toggle="modal"
                                    data-bs-target="#rejection-modal">
                                    More Info Required
                                </button></a>
                        @elseif($dataYTP->stage == 3)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Approved
                            </button>
                            <a href="#rejection-modal"> <button class="button_theme1" data-bs-toggle="modal"
                                    data-bs-target="#rejection-modal">
                                    More Info Required
                                </button></a>
                            {{-- @elseif($dataYTP->stage == 4)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Complete
                            </button> --}}
                        @endif
                        <button class="button_theme1"> <a class="text-white" href="{{ url('TMS') }}"> Exit
                            </a>
                        </button>


                    </div>

                </div>
                <div class="status">
                    <div class="head">Current Status</div>
                    {{-- ------------------------------By Pankaj-------------------------------- --}}
                    @if ($dataYTP->stage == 0)
                        <div class="progress-bars ">
                            <div class="bg-danger">Closed-Cancelled</div>
                        </div>
                    @else
                        <div class="progress-bars d-flex">
                            @if ($dataYTP->stage >= 1)
                                <div class="active">Opened</div>
                            @else
                                <div class="">Opened</div>
                            @endif

                            @if ($dataYTP->stage >= 2)
                                <div class="active">In Review</div>
                            @else
                                <div class="">In Review</div>
                            @endif
                            @if ($dataYTP->stage >= 3)
                                <div class="active">For Approval</div>
                            @else
                                <div class="">For Approval</div>
                            @endif
                            @if ($dataYTP->stage >= 4)
                                <div class="bg-danger">Closed - Done</div>
                            @else
                                <div class="">Closed-Complete</div>
                            @endif

                            {{-- @if ($dataYTP->stage >= 5)
                                <div class="bg-danger">Closed - Done</div>
                            @else
                                <div class="">Closed-Complete</div>
                            @endif --}}
                    @endif


                </div>
                {{-- @endif --}}
            </div>
        </div>
        <!-- Tab links -->
        <div class="cctab">

            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Informantion</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm2')"> In Review</button>
            <button class="cctablinks" onclick="openCity(event, 'CCForm3')">For Approve</button>
            {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm2')"> Categorization </button> --}}
            {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Progress and Tracking</button> --}}

        </div>
        <script>
            $(document).ready(function() {
                <?php if ($dataYTP->stage == 3) : ?>
                $("#target :input").prop("disabled", true);
                <?php endif; ?>
            });
        </script>

        <form id="mainForm" action="{{ route('YTP.update', $dataYTP->id) }}" method="POST" enctype="multipart/form-data">
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
                                    <select id="site_division" name="site_division" onchange="toggleMultiSelect()">
                                        <option value="">Select Division</option>
                                        <option value="P1(Indore Location)"
                                            @if ($dataYTP->site_division == 'P1(Indore Location)') selected @endif>
                                            P1 (Indore Location)</option>
                                        <option value="P2(Pithampur Location)"
                                            @if ($dataYTP->site_division == 'P2(Pithampur Location)') selected @endif>P2
                                            (Pithampur Location)
                                        </option>
                                        <option value="P4(Ujjain Site)" @if ($dataYTP->site_division == 'P4(Ujjain Site)') selected @endif>
                                            P4 (Ujjain
                                            Site)</option>
                                        <option value="C1(China Plant)" @if ($dataYTP->site_division == 'C1(China Plant)') selected @endif>
                                            C1 (China Plant)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Prepared By">Prepared By<span class="text-danger">*</span></label>
                                    <input type="text" value="{{ Auth::user()->name }}" readonly>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Prepared On">Prepared On<span class="text-danger">*</span></label>
                                    <input disabled type="text" value="{{ date('d-M-Y') }}"
                                        value="{{ $dataYTP->initiation_date }}" name="initiation_date">
                                    <input type="hidden" value="{{ date('d-M-Y') }}" name="initiation_date">
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Department">Department Name<span class="text-danger"></span></label>
                                    <select name="department" id="department" onchange="toggleOtherDepartment()">
                                        <option value="">-- Select --</option>

                                        @foreach (Helpers::getDepartments() as $code => $department)
                                            <option value="{{ $code }}"
                                                {{ $dataYTP->department == $code ? 'selected' : '' }}>
                                                {{ $department }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Year">Year<span class="text-danger">*</span></label>
                                    <select name="year" id="year">
                                        @for ($year = 1990; $year <= date('Y'); $year++)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <!-- JavaScript to set the selected year -->
                            <script>
                                document.addEventListener("DOMContentLoaded", function() {
                                    // Pass PHP variable to JavaScript
                                    var selectedYear = @json($selectedYear);

                                    // Debugging: check if selectedYear is coming through correctly
                                    console.log("Selected Year from Blade: ", selectedYear);

                                    // Get the dropdown element
                                    var yearDropdown = document.getElementById("year");

                                    if (yearDropdown && selectedYear) {
                                        // Set the selected option based on the selectedYear value
                                        yearDropdown.value = selectedYear;

                                        // Additional Debugging: Check if dropdown value is set
                                        console.log("Dropdown value after setting: ", yearDropdown.value);
                                    } else {
                                        console.log("Dropdown or selectedYear is not available.");
                                    }
                                });
                            </script>



                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Type of Material">Reference Number</label>
                                    <select name="document_number" id="document_number">
                                        <option value="">----Select---</option>
                                        @foreach ($data as $item)
                                            <option value="{{ $item->id }}"
                                                data-doc-number="{{ $item->sop_type_short }}/{{ $item->department_id }}/000{{ $item->id }}/R{{ $item->major }}"
                                                data-sop-id="{{ $item->id }}"
                                                {{ $dataYTP->document_number == $item->id ? 'selected' : '' }}>
                                                {{ $item->sop_type_short }}/{{ $item->department_id }}/000{{ $item->id }}/R{{ $item->major }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Description">Topic/Subject</label>
                                    <input type="text" name="topic" value="{{ $dataYTP->topic }}" id="topic">
                                </div>
                            </div>






                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="start_date">Start Date <span class="text-danger"> *</span> </label>
                                    <input id="start_date" type="date" name="start_date"
                                        value="{{ $dataYTP->start_date }}" onchange="setMinEndDate()" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="end_date">End Date <span class="text-danger">*</span></label>
                                    <input id="end_date" type="date" name="end_date"
                                        value="{{ $dataYTP->end_date }}" onchange="setMaxStartDate()" required>
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
                    <div class="row">
                        <div class="col-lg-12 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="Review Comment">Review Comment</label>
                                <textarea type="text" name="Review_Comment" id="Review_Comment">{{ $dataYTP->Review_Comment }}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Review Attachments">Review Attachments</label>
                                <div><small class="text-primary">Please Attach all relevant or Review
                                        documents</small></div>
                                <div class="file-attachment-field">
                                    <div class="file-attachment-list" id="Review_Attachments">
                                        @if ($dataYTP->Review_Attachments)
                                            @foreach (json_decode($dataYTP->Review_Attachments) as $file)
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
                                                    <input type="hidden" name="existing_Review_Attachments[]"
                                                        value="{{ $file }}">
                                                </h6>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="add-btn">
                                        <div>Add</div>
                                        <input type="file" id="Review_Attachments" name="Review_Attachments[]"
                                            oninput="addMultipleFiles(this, 'Review_Attachments')" multiple>
                                    </div>
                                </div>
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

            <div id="CCForm3" class="inner-block cctabcontent">
                <div class="inner-block-content">
                    <div class="row">
                        <div class="col-lg-12 new-date-data-field">
                            <div class="group-input input-date">
                                <label for="Approval Comment">Approval Comment</label>
                                <textarea type="text" name="Approval_Comment" id="Approval_Comment">{{ $dataYTP->Approval_Comment }}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="group-input">
                                <label for="Approval Attachments">Approval Attachments</label>
                                <div><small class="text-primary">Please Attach all relevant or Approval
                                        documents</small></div>
                                <div class="file-attachment-field">
                                    <div class="file-attachment-list" id="Approval_Attachments">
                                        @if ($dataYTP->Approval_Attachments)
                                            @foreach (json_decode($dataYTP->Approval_Attachments) as $file)
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
                                                    <input type="hidden" name="existing_Approval_Attachments[]"
                                                        value="{{ $file }}">
                                                </h6>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="add-btn">
                                        <div>Add</div>
                                        <input type="file" id="Approval_Attachments" name="Approval_Attachments[]"
                                            oninput="addMultipleFiles(this, 'Approval_Attachments')" multiple>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="button-block">
                        <button type="submit" class="saveButton on-submit-disable-button">Save</button>
                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                        {{-- <button type="button" class="nextButton" onclick="nextStep()">Next</button> --}}

                    </div>
                </div>
            </div>

        </form>
    </div>
    </div>
    <script>
        $(document).ready(function() {          
            $('#mainForm').on('submit', function(e) {
                $('.on-submit-disable-button').prop('disabled', true);
            });
        })
    </script>

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

                    <form action="{{ route('employee.child', $dataYTP->id) }}" method="POST" id="childForm">
                        @csrf
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="group-input">
                                <label style="display: flex;" for="major">
                                    <input type="radio" name="child_type" id="major" value="induction_training">
                                    Induction Training
                                </label>


                                {{-- <label style="display: flex;" for="major">
                                <input type="radio" name="child_type" id="major" value="variation">
                                Read and Understand
                            </label>

                            <label for="major">
                                <input type="radio" name="child_type" id="major" value="renewal">
                                Classroom
                            </label>
                            <label for="major">
                                <input type="radio" name="child_type" id="major" value="correspondence">
                                Correspondence
                            </label>
                            <label for="major">
                                <input type="radio" name="child_type" id="major" value="osur">
                                PSUR
                            </label> --}}

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
    </div>
    <script>
        $(document).ready(function() {
            
            $('#childForm').on('submit', function(e) {
                $('.on-submit-disable-button').prop('disabled', true);
            });
        })
    </script>


    <div class="modal fade" id="signature-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ url('tms/YTP/ytp_views', $dataYTP->id) }}" method="POST" id="signatureModalForm">
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
            
            $('#signatureModalForm').on('submit', function(e) {
                $('.on-submit-disable-button').prop('disabled', true);
            });
        })
    </script>
    <div class="modal fade" id="cancel-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <form action="{{ url('tms/YTP/stageCancel', $dataYTP->id) }}" method="POST" id="cancelModalForm">
                    @csrf
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">E-Signature</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
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
                    <div class="modal-footer">
                        <button type="submit" class="on-submit-disable-button">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            
            $('#cancelModalForm').on('submit', function(e) {
                $('.on-submit-disable-button').prop('disabled', true);
            });
        })
    </script>
    <div class="modal fade" id="rejection-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ url('tms/YTP/stageReject', $dataYTP->id) }}" method="POST" id="rejectionModalForm">
                    @csrf
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">E-Signature</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
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
                    <div class="modal-footer">
                        <button type="submit" class="on-submit-disable-button">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            
            $('#rejectionModalForm').on('submit', function(e) {
                $('.on-submit-disable-button').prop('disabled', true);
            });
        })
    </script>

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
