@extends('frontend.layout.main')
@section('container')
    @php
        $users = DB::table('users')->select('id', 'name')->where('active', 1)->get();
        $userRoles = DB::table('user_roles')->select('user_id')->where('q_m_s_roles_id', 4)->distinct()->get();
        $departments = DB::table('departments')->select('id', 'name')->get();
        $divisions = DB::table('q_m_s_divisions')->select('id', 'name')->get();

        $userIds = DB::table('user_roles')->where('q_m_s_roles_id', 4)->distinct()->pluck('user_id');

        $userNames = DB::table('users')->whereIn('id', $userIds)->pluck('name');

        $userDetails = DB::table('users')->whereIn('id', $userIds)->select('id', 'name')->get();
    @endphp

    

<script>
$(document).ready(function() {
    let trainingPlanIndex = 0;

    // Function to update the trainingPlanIndex based on existing rows
    function updateTrainingPlanIndex() {
        trainingPlanIndex = $('#addTrainingPlanTable tbody tr').length;
    }

    // Initial update to set the index correctly
    updateTrainingPlanIndex();

    $('#addTrainingPlan').click(function(e) {
        function generateTableRow(index) {
            var documents = @json($documents);
            var documentOptionHtml = '<option value="">-- Select --</option>';
            documents.forEach(document => {
                documentOptionHtml += `<option value="${document.id}">${document.sop_type_short}/${document.department_id}/000${document.id}/R${document.major}</option>`;
            });

            var html =
                '<tr>' +
                    // Serial number field, using trainingPlanIndex for dynamic serial number
                    '<td><input disabled type="text" name="serial[]" value="' + (index + 1) + '"></td>' +
                    '<td><select  id="documentPlan_' + index + '" class="training-select" name="trainingPlanData[' + index + '][documentNumber]">' +
                        documentOptionHtml + '</select></td>' + 
                    '<td><input type="text" class="sops" name="trainingPlanData[' + index + '][documentName]" readonly></td>' +
                    '<td><select multiple id="designation_' + index + '" class="designation-select" name="trainingPlanData[' + index + '][designation]">' +
                    '<option value="Trainee">Trainee</option>' +
                    '<option value="Officer">Officer</option>' +
                    '<option value="Senior Officer">Senior Officer</option>' +
                    '<option value="Executive">Executive</option>' +
                    '<option value="Senior Executive">Senior Executive</option>' +
                    '<option value="Assistant Manager">Assistant Manager</option>' +
                    '<option value="Manager">Manager</option>' +
                    '<option value="Senior General Manager">Senior General Manager</option>' +
                    '<option value="Senior Manager">Senior Manager</option>' +
                    '<option value="Deputy General Manager">Deputy General Manager</option>' +
                    '<option value="Assistant General Manager and General Manager">Assistant General Manager and General Manager</option>' +
                    '<option value="Head Quality">Head Quality</option>' +
                    '<option value="VP Quality">VP Quality</option>' +
                    '<option value="Plant Head">Plant Head</option>' +
                    '<option value="Other Designation">Other Designation</option>' +
                     '</select></td>'
                      +
                    '<td><select name="trainingPlanData[' + index + '][trainingType]">' +
                        '<option value="">-- Select --</option>' +
                        '<option value="Read & Understand">Read & Understand</option>' +
                        '<option value="Read & Understand with Questions">Read & Understand with Questions</option>' +
                        '<option value="Classroom Training">Classroom Training</option>' +
                        '<option value="On Job Training">On Job Training</option>' +
                        '<option value="External Training">External Training</option>' +
                        '<option value="Refresher Training">Refresher Training</option>' +
                        '<option value="Retraining">Retraining</option>' +                                 
                    '</select></td>' +
                    // Start Date Field
                    '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee">' +
                        '<input type="text" class="test" id="scheduled_start_date' + index + '" readonly placeholder="DD-MMM-YYYY" />' +
                        '<input type="date" name="trainingPlanData[' + index + '][startDate]" id="scheduled_start_date' + index + '_checkdate" class="hide-input" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" ' +
                        'oninput="handleDateInput(this, \'scheduled_start_date' + index + '\'); checkDate(\'scheduled_start_date' + index + '_checkdate\', \'scheduled_end_date' + index + '_checkdate\')" />' +
                    '</div></div></div></td>' +
                    // End Date Field
                    '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee">' +
                        '<input type="text" class="test" id="scheduled_end_date' + index + '" readonly placeholder="DD-MMM-YYYY" />' +
                        '<input type="date" name="trainingPlanData[' + index + '][endDate]" id="scheduled_end_date' + index + '_checkdate"class="hide-input" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" ' +
                        'oninput="handleDateInput(this, \'scheduled_end_date' + index + '\'); checkDate(\'scheduled_start_date' + index + '_checkdate\', \'scheduled_end_date' + index + '_checkdate\')" />' +
                    '</div></div></div></td>' +
                    '<td><button type="button" class="removeRowBtn">Remove</button></td>' +
                '</tr>';

            return html;
        }

        // Update the trainingPlanIndex before appending the new row
        updateTrainingPlanIndex();
        var tableBody = $('#addTrainingPlanTable tbody');
        var newRow = generateTableRow(trainingPlanIndex); // Use the current index
        tableBody.append(newRow);

        // Increment the index after adding the row
        trainingPlanIndex++;

        // Initialize Virtual Selects
        // VirtualSelect.init({
        //     ele: '#documentPlan_' + (trainingPlanIndex - 1),
        //     multiple: true
        // });

        VirtualSelect.init({
            ele: '#designation_' + (trainingPlanIndex - 1),
            multiple: true
        });

        // Event handling for document selection
        tableBody.find('.training-select').last().change(function() {
            var row = $(this).closest('tr');
            fetchAndDisplayTitles($(this), row);
        });
    });

    function fetchAndDisplayTitles(selectElement, row) {
        var documentIds = selectElement.val();
        var titles = [];

        if (documentIds) {
            if (typeof documentIds === 'string') {
                documentIds = [documentIds];
            }

            var fetchTitlePromises = documentIds.map(function(documentId) {
                return $.ajax({
                    url: '/rcms/document-detail/' + documentId,
                    method: 'GET'
                });
            });

            $.when.apply($, fetchTitlePromises).done(function() {
                if (Array.isArray(arguments[0])) {
                    for (var i = 0; i < arguments.length; i++) {
                        var response = arguments[i][0];
                        titles.push(response.sops);
                    }
                } else {
                    titles.push(arguments[0]['sops']);
                }
                row.find('input.sops').val(titles.join(', '));
            }).fail(function() {
                alert('Failed to fetch Document Detail details.');
            });
        } else {
            row.find('input.sops').val('');
        }
    }

    // Handle the default selection of designations
    $('.designation-select').each(function() {
        var selectElement = $(this);
        var selectedValues = selectElement.data('selected');
        if (selectedValues) {
            var valuesArray = selectedValues.split(',');
            selectElement.val(valuesArray).change();
        }
    });
});


</script>
<script>
    VirtualSelect.init({
        ele: '#Facility, #Group, #Audit, #Auditee ,#reference_record, #designee,  #designation'
    });
</script>


     <style>
        .progress-bars div {
            flex: 1 1 auto;
            border: 1px solid grey;
            padding: 5px;
            /* border-radius: 20px; */
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

        #change-control-fields>div>div.inner-block.state-block>div.status>div.progress-bars.d-flex>div:nth-child(8) {
            border-radius: 0px 20px 20px 0px;

        }
        header{
            display: none !important;
        }
    </style>
    <div class="form-field-head">
        <div class="pr-id">
            TNI Matrix
        </div>
    </div>

    <div id="change-control-fields">
        <div class="container-fluid">

                <div class="inner-block state-block">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="main-head">Record Workflow </div>

                        <div class="d-flex" style="gap:20px;">
                            @php
                                $userRoles = DB::table('user_roles')
                                    ->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => $data->division_id])
                                    ->get();
                                $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                            @endphp
                            <!-- <button class="button_theme1"> <a class="text-white" href="{{ url('rootAuditTrial', $data->id) }}"> Audit Trail </a> </button> -->

                            @if ($data->stage == 1)
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                    Submit
                                </button>
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                    Cancel
                                </button>
                            @elseif ($data->stage == 2)
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                    More Info Required
                                </button>
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                    Reviewed
                                </button>
                            @elseif($data->stage == 3)
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                    More Info Required
                                </button>
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                    Approved
                                </button>
                            @endif
                            <button class="button_theme1"> <a class="text-white" href="{{ url('TMS') }}"> Exit</a> </button>
                        </div>

                    </div>
                    <div class="status">
                        <div class="head">Current Status</div>
                        @if ($data->stage == 0)
                            <div class="progress-bars">
                                <div class="bg-danger">Closed-Cancelled</div>
                            </div>
                        @else
                            <div class="progress-bars d-flex" style="">
                                @if ($data->stage >= 1)
                                    <div class="active">Opened</div>
                                @else
                                    <div class="">Opened</div>
                                @endif

                                @if ($data->stage >= 2)
                                    <div class="active">In Review</div>
                                @else
                                    <div class="">In Review</div>
                                @endif

                                @if ($data->stage >= 3)
                                    <div class="active">For Approval</div>
                                @else
                                    <div class="">For Approval</div>
                                @endif

                                @if ($data->stage >= 4)
                                    <div class="active bg-danger">Closed - Done</div>
                                @else
                                    <div class="">Closed - Done</div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

            <div class="cctab">
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
                <!-- <button class="cctablinks " onclick="openCity(event, 'CCForm2')">External Training</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Activity Log</button> -->
            </div>

            <form action="{{ route('tni-update', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Tab content -->
                <div id="step-form">

                    <div id="CCForm1" class="inner-block cctabcontent" style="overflow: auto;">
                        <div class="inner-block-content">
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="site_name">TNI No.</label>
                                        <input type="text" value={{ $data->division_id }}/TNI/{{ $data->department_code }}/{{ $data->created_at->format('Y') }}/R{{ $data->version_count }} disabled>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="site_name">Site / Location</label>
                                        <select name="division_id" disabled>
                                            <option value="">Select Division</option>
                                            <option value="P1" @if($data->division_id = "P1") selected @endif>P1 (Indore Location)</option>
                                            <option value="P2" @if($data->division_id = "P2") selected @endif>P2 (Pithampur Location)</option>
                                            <option value="P4" @if($data->division_id = "P4") selected @endif>P4 (Ujjain Site)</option>
                                            <option value="C1" @if($data->division_id = "C1") selected @endif>C1 (China Plant)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="site_name">Initiator</label>
                                        <input type="text" value="{{ Helpers::getInitiatorName($data->initiator_id) }}" disabled>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input input-date">
                                        <label for="Joining Date">Initiation Date</label>
                                        <input type="text" value="{{ $data->initiation_date }}" disabled>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="site_name">Department</label>
                                        <input type="text" value="{{ $data->department }}" disabled>
                                    </div>
                                </div>

                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="start_date">Start Date</label>
                                        <input id="start_date" type="date" name="start_date"
                                            value="{{ $data->start_date }}" onchange="setMinEndDate()" disabled>
                                    </div>
                                </div>
    
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="end_date">End Date</label>
                                        <input id="end_date" type="date" name="end_date"
                                            value="{{ $data->end_date }}" onchange="setMaxStartDate()" disabled>
                                    </div>
                                </div> --}}
                                {{-- <script>
                                    function setMinEndDate() {
                                        var startDate = document.getElementById('start_date').value;
                                        document.getElementById('end_date').min = startDate; 
                                    }
    
                                    function setMaxStartDate() {
                                        var endDate = document.getElementById('end_date').value;
                                        document.getElementById('start_date').max = endDate;
                                    }
                                </script> --}}

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
                                                    <th style="width: 15%;">SOP Number</th>
                                                    <th>SOP Title</th>
                                                    <th style="width: 10%;">Designation</th>
                                                    <th style="width: 10%;">Training Type</th>
                                                    
                                                    <th style="width: 10%;"> Start Date</th>
                                                    <th style="width: 10%;">End Date</th>
                                                    <th style="width: 10%;"> Minimum Sop View Time(in min)</th>
                                                    <th style="width: 10%;">Maximum Sop View Time(in min)</th>

                                                    <th style="width: 10%;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($existingData as $index => $item)
                                                    @php
                                                        $selectedDesignations = isset($item['designation']) ? explode(',', $item['designation']) : [];
                                                    @endphp                                                    
                                                    <tr>
                                                        <td>
                                                            <input disabled type="text" name="trainingPlanData[{{ $index }}][serial]" value="{{ (int)$index + 1 }}">
                                                        </td>
                                                        <td>
                                                            <select name="trainingPlanData[{{ $index }}][documentNumber]" id="documentPlan_{{ $index }}" class="training-select">
                                                                <option value="">-- Select --</option>
                                                                @foreach ($documents as $document)
                                                                    <option value="{{ $document->id }}" 
                                                                        @if(in_array($document->id, $item['selectedDocuments'])) selected @endif>
                                                                        {{ $document->sop_type_short }}/{{ $document->department_id }}/000{{ $document->id }}/R{{ $document->major }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        
                                                        <td>
                                                            <input type="text" class="sops" name="trainingPlanData[{{ $index }}][documentName]" readonly value="{{ $item['documentName'] ?? '' }}">
                                                        </td>
                                                        <td>
                                                            <select name="trainingPlanData[{{ $index }}][designation]" multiple id="designation_{{ $index }}" class="designation-select">
                                                                <option value="Trainee" @if(in_array('Trainee', $selectedDesignations)) selected @endif>Trainee</option>
                                                                <option value="Officer" @if(in_array('Officer', $selectedDesignations)) selected @endif>Officer</option>
                                                                <option value="Senior Officer" @if(in_array('Senior Officer', $selectedDesignations)) selected @endif>Senior Officer</option>
                                                                <option value="Executive" @if(in_array('Executive', $selectedDesignations)) selected @endif>Executive</option>
                                                                <option value="Senior Executive" @if(in_array('Senior Executive', $selectedDesignations)) selected @endif>Senior Executive</option>
                                                                <option value="Assistant Manager" @if(in_array('Assistant Manager', $selectedDesignations)) selected @endif>Assistant Manager</option>
                                                                <option value="Manager" @if(in_array('Manager', $selectedDesignations)) selected @endif>Manager</option>
                                                                <option value="Senior General Manager" @if(in_array('Senior General Manager', $selectedDesignations)) selected @endif>Senior General Manager</option>
                                                                <option value="Senior Manager" @if(in_array('Senior Manager', $selectedDesignations)) selected @endif>Senior Manager</option>
                                                                <option value="Deputy General Manager" @if(in_array('Deputy General Manager', $selectedDesignations)) selected @endif>Deputy General Manager</option>
                                                                <option value="Assistant General Manager and General Manager" @if(in_array('Assistant General Manager and General Manager', $selectedDesignations)) selected @endif>Assistant General Manager and General Manager</option>
                                                                <option value="Head Quality" @if(in_array('Head Quality', $selectedDesignations)) selected @endif>Head Quality</option>
                                                                <option value="VP Quality" @if(in_array('VP Quality', $selectedDesignations)) selected @endif>VP Quality</option>
                                                                <option value="Plant Head" @if(in_array('Plant Head', $selectedDesignations)) selected @endif>Plant Head</option>
                                                                <option value="Other Designation" @if(in_array('Other Designation', $selectedDesignations)) selected @endif>Other Designation</option>
                                                            </select>
                                                        </td>
                                                        
                                                        <td>
                                                            <select name="trainingPlanData[{{ $index }}][trainingType]">
                                                                <option value="">-- Select --</option>
                                                                <option value="Read & Understand" @if(isset($item['trainingType']) && $item['trainingType'] == 'Read & Understand') selected @endif>Read & Understand</option>
                                                                <option value="Read & Understand with Questions" @if(isset($item['trainingType']) && $item['trainingType'] == 'Read & Understand with Questions') selected @endif>Read & Understand with Questions</option>
                                                                <option value="Classroom Training" @if(isset($item['trainingType']) && $item['trainingType'] == 'Classroom Training') selected @endif>Classroom Training</option>
                                                                <option value="On Job Training" @if(isset($item['trainingType']) && $item['trainingType'] == 'On Job Training') selected @endif>On Job Training</option>
                                                                <option value="External Training" @if(isset($item['trainingType']) && $item['trainingType'] == 'External Training') selected @endif>External Training</option>
                                                                <option value="Refresher Training" @if(isset($item['trainingType']) && $item['trainingType'] == 'Refresher Training') selected @endif>Refresher Training</option>
                                                                <option value="Retraining" @if(isset($item['trainingType']) && $item['trainingType'] == 'Retraining') selected @endif>Retraining</option>
                                                            </select>
                                                        </td>
                                                         <!-- Start Date -->
                                                         <td>
                                                            <div class="group-input new-date-data-field mb-0">
                                                                <div class="input-date">
                                                                    <div class="calenderauditee">
                                                                        <input type="text" class="test" id="scheduled_start_date{{ $index }}" readonly placeholder="DD-MMM-YYYY" value="{{ isset($item['startDate']) ? \Carbon\Carbon::parse($item['startDate'])->format('d-M-Y') : '' }}" />
                                                                        <input type="date" id="scheduled_start_date{{ $index }}_checkdate"
                                                                               name="trainingPlanData[{{ $index }}][startDate]"
                                                                               min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                               value="{{ isset($item['startDate']) ? \Carbon\Carbon::parse($item['startDate'])->format('Y-m-d') : '' }}"
                                                                               oninput="handleDateInput(this, 'scheduled_start_date{{ $index }}'); checkDate('scheduled_start_date{{ $index }}_checkdate', 'scheduled_end_date{{ $index }}_checkdate')"class="hide-input" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        
                                                        <!-- End Date -->
                                                        <td>
                                                            <div class="group-input new-date-data-field mb-0">
                                                                <div class="input-date">
                                                                    <div class="calenderauditee">
                                                                        <input type="text" class="test" id="scheduled_end_date{{ $index }}" readonly placeholder="DD-MMM-YYYY" value="{{ isset($item['endDate']) ? \Carbon\Carbon::parse($item['endDate'])->format('d-M-Y') : '' }}" />
                                                                        <input type="date" id="scheduled_end_date{{ $index }}_checkdate"
                                                                               name="trainingPlanData[{{ $index }}][endDate]"
                                                                               min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                                               value="{{ isset($item['endDate']) ? \Carbon\Carbon::parse($item['endDate'])->format('Y-m-d') : '' }}"
                                                                               oninput="handleDateInput(this, 'scheduled_end_date{{ $index }}'); checkDate('scheduled_start_date{{ $index }}_checkdate', 'scheduled_end_date{{ $index }}_checkdate')"class="hide-input" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>                                    
                                                                {{-- <td><input type="number" min="0" name="trainingPlanData[{{ $index }}][total_minimum_time]" value="trainingPlanData[{{ $index }}][total_minimum_time]" id=""></td>
                                                                 <td><input type="number" min="0" name="trainingPlanData[{{ $index }}][per_screen_running_time]" value="trainingPlanData[{{ $index }}][per_screen_running_time]" id=""></td> --}}

                                                                 <td>
                                                                    <input type="text" name="trainingPlanData[{{ $index }}][total_minimum_time]" value="{{ $item['total_minimum_time'] }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="trainingPlanData[{{ $index }}][per_screen_running_time]" value="{{ $item['per_screen_running_time'] }}">
                                                                </td>
                                                                 <td><button type="button" class="removeRowBtn">Remove</button></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                            </div>

                            <div class="button-block">
                                <button type="submit" id="ChangesaveButton01" class="saveButton">Save</button>
                                <!-- <button type="button" id="ChangeNextButton" class="nextButton">Next</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button> -->
                                <button type="button"> <a href="{{ url('TMS') }}" class="text-white"> Exit </a> </button>
                            </div>

                        </div>
                    </div>
                    <!-- <div id="CCForm2" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                
                            </div>

                            <div class="button-block">
                                <button type="submit" id="ChangesaveButton01" class="saveButton">Save</button>
                                <button type="button" id="ChangeNextButton" class="nextButton">Next</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button"> <a href="{{ url('TMS') }}" class="text-white"> Exit </a> </button>
                            </div>
                        </div>
                    </div> -->

                    <div id="CCForm6" class="inner-block cctabcontent">
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
                        </div>
                    </div>


                    <script>
                        function previousStep() {
                            if (currentStep > 0) {
                                steps[currentStep].style.display = "none";
                                steps[currentStep - 1].style.display = "block";
                                stepButtons[currentStep - 1].classList.add("active");
                                stepButtons[currentStep].classList.remove("active");
                                currentStep--;
                            }
                        }
                    </script>
            </form>
        </div>
    </div>

    <div class="modal fade" id="signature-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('tni-stage-change', $data->id) }}" method="POST">
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
                            <label for="comment">Comment</label>
                            <input type="comment" name="comment">
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" data-bs-dismiss="modal">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
            </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="rejection-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('tni-stage-reject', $data->id) }}" method="POST">
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
                        <button type="submit" data-bs-dismiss="modal">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
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
        }

        const saveButtons = document.querySelectorAll('.saveButton1');
        const form = document.getElementById('step-form');
    </script>
    <script>
        VirtualSelect.init({
            ele: '#Facility, #Group, #Audit, #Auditee ,#reference_record, #designee,'
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.training-select').each(function() {
                VirtualSelect.init({
                    ele: '#' + $(this).attr('id'),
                });
            });

            $('.designation-select').each(function() {
                VirtualSelect.init({
                    ele: '#' + $(this).attr('id'),
                    multiple: true
                });
            });

    $(document).on('change', '.training-select', function() {
        var row = $(this).closest('tr');
        fetchAndDisplayTitles($(this), row);
    });

    function fetchAndDisplayTitles(selectElement, row) {
        var documentIds = selectElement.val();
        var titles = [];

        if (documentIds) {
            if (typeof documentIds === 'string') {
                documentIds = [documentIds];
            }

            var fetchTitlePromises = documentIds.map(function(documentId) {
                return $.ajax({
                    url: '/rcms/document-detail/' + documentId,
                    method: 'GET'
                });
            });

            $.when.apply($, fetchTitlePromises).done(function() {
                if (Array.isArray(arguments[0])) {
                    for (var i = 0; i < arguments.length; i++) {
                        var response = arguments[i][0];
                        titles.push(response.sops);
                    }
                } else {
                    titles.push(arguments[0]['sops']);
                }
                row.find('input.sops').val(titles.join(', '));
            }).fail(function() {
                alert('Failed to fetch Document Detail details.');
            });
        } else {
            row.find('input.sops').val('');
        }
        }

        // Reinitialize the VirtualSelect for all elements after the document is loaded
        VirtualSelect.init({
            ele: '.training-select',
            multiple: true
        });
    });

    </script>

    <script>
        $(document).on('click', '.removeRowBtn', function() {
            $(this).closest('tr').remove();
        })
    </script>
@endsection
