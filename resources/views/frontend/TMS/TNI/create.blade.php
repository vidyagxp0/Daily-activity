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
        let trainingPlanIndex = 1;

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
                    console.log('arguments', arguments[0])
                    console.log('arguments sop', arguments[0]['sops'])
                    if (Array.isArray(arguments[0])) {
                        for (var i = 0; i < arguments.length; i++) {
                            var response = arguments[i][0];
                            console.log('Response:', response);
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

        $('#addTrainingPlan').click(function(e) {
            function generateTableRow(serialNumber) {
                var documents = @json($documents); 
                var documentOptionHtml = '<option value="">-- Select --</option>';
                documents.forEach(document => {
                    documentOptionHtml += `<option value="${document.id}">${document.sop_type_short}/${document.department_id}/000${document.id}/R${document.major}</option>`;
                });

                var html =
                    '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber + '"></td>' +
                        '<td><select  id="documentPlan_' + trainingPlanIndex + '" class="training-select" name="trainingPlanData[' + trainingPlanIndex + '][documentNumber]">' +
                            documentOptionHtml + '</select></td>' + 
                        '<td><input type="text" class="sops" name="trainingPlanData[' + trainingPlanIndex + '][documentName]" readonly></td>' +
                        '<td><select multiple id="designation_' + trainingPlanIndex + '" class="designation-select" name="trainingPlanData[' + trainingPlanIndex + '][designation]">' +
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
                            '</select></td>' +
                        '<td><select name="trainingPlanData[' + trainingPlanIndex + '][trainingType]">' +
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
                            '<input type="text" id="scheduled_start_date' + serialNumber + '" readonly placeholder="DD-MMM-YYYY" />' +
                            '<input type="date" name="trainingPlanData[' + trainingPlanIndex + '][startDate]" id="scheduled_start_date' + serialNumber +
                            '_checkdate" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, `scheduled_start_date' +
                            serialNumber + '`);checkDate(`scheduled_start_date' + serialNumber +
                            '_checkdate`,`scheduled_end_date' + serialNumber + '_checkdate`)" /></div></div></div></td>' +
                        // End Date Field
                        '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee">' +
                            '<input type="text" id="scheduled_end_date' + serialNumber + '" readonly placeholder="DD-MMM-YYYY" />' +
                            '<input type="date" name="trainingPlanData[' + trainingPlanIndex + '][endDate]" id="scheduled_end_date' + serialNumber +
                            '_checkdate" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, `scheduled_end_date' +
                            serialNumber + '`);checkDate(`scheduled_start_date' + serialNumber +
                            '_checkdate`,`scheduled_end_date' + serialNumber + '_checkdate`)" /></div></div></div></td>' +
                          '<td><button type="button" class="removeRowBtn">Remove</button></td>' +
                    '</tr>';

                trainingPlanIndex++;
                return html;
            }

            var tableBody = $('#addTrainingPlanTable tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);

            VirtualSelect.init({
                ele: '#doocumentPlan_' + (trainingPlanIndex - 1),
                multiple: true
            });

            VirtualSelect.init({
                ele: '#designation_' + (trainingPlanIndex - 1),
                multiple: true
            });

            tableBody.find('.training-select').last().change(function() {
                var row = $(this).closest('tr');
                fetchAndDisplayTitles($(this), row);
            });
            });
        });
    </script>
    <div class="form-field-head">
        <div class="pr-id">
            TNI Matrix
        </div>
    </div>

    <div id="change-control-fields">
        <div class="container-fluid">

            <div class="cctab">
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
                <!-- <button class="cctablinks " onclick="openCity(event, 'CCForm2')">External Training</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Activity Log</button> -->
            </div>

            <form action="{{ route('tni-store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Tab content -->
                <div id="step-form">

                    <div id="CCForm1" class="inner-block cctabcontent" style="overflow: auto;">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="site_name">TNI No.</label>
                                        <div><small class="text-primary">TNI No. will be auto populated after creation.</small></div>
                                        <input type="text" placeholder="TNI No." disabled>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="site_name">Site / Location <span class="text-danger">*</span></label>
                                        <select name="division_id" required>
                                            <option value="">Select Division</option>
                                            <option value="P1">P1 (Indore Location)</option>
                                            <option value="P2">P2 (Pithampur Location)</option>
                                            <option value="P4">P4 (Ujjain Site)</option>
                                            <option value="C1">C1 (China Plant)</option>
                                        </select>
                                    </div>
                                </div>
                                 
                                
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="site_name">Initiator <span class="text-danger">*</span></label>
                                        <input type="text" value="{{ Auth::user()->name }}" readonly>
                                    </div>
                                </div>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Joining Date">Initiation Date <span class="text-danger">*</span></label>
                                        <input disabled type="text" value="{{ date('d-M-Y') }}" name="initiation_date">
                                        <input type="hidden" value="{{ date('d-M-Y') }}" name="initiation_date">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="site_name">Department <span class="text-danger">*</span></label>
                                        <select name="department_code" required>
                                            <option value="">Select Department</option>
                                                @foreach (Helpers::getDepartments() as $code => $Department)
                                                    <option value="{{ $code }}"> {{ $Department }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="start_date">Start Date</label>
                                        <input id="start_date" type="date" name="start_date" onchange="setMinEndDate()">
                                    </div>
                                </div>
    
                                <div class="col-lg-6">  
                                    <div class="group-input">
                                        <label for="end_date">End Date</label>
                                        <input id="end_date" type="date" name="end_date" onchange="setMaxStartDate()">
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
                                                    <th style="width: 25%;">SOP Number</th>
                                                    <th>SOP Title</th>
                                                    <th style="width: 20%;">Designation</th>
                                                    <th style="width: 10%;">Training Type</th>
                                                    <th style="width: 10%;">Start Date</th>
                                                    <th style="width: 10%;">End Date</th>
                                                    <th style="width: 10%;">Minimum Sop View Time(in min)</th>
                                                    <th style="width: 10%;">Maximum Sop View Time(in min)</th>


                                                    <th style="width: 10%;">Action</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input disabled type="text" name="trainingPlanData[0][serial]" value="1">
                                                    </td>
                                                    <td>
                                                        <select name="trainingPlanData[0][documentNumber]" id="doocumentPlan">
                                                            <option value="">-- Select --</option>
                                                            @foreach ($documents as $document)
                                                                <option value="{{ $document->id }}">{{ $document->sop_type_short }}/{{ $document->department_id }}/000{{ $document->id }}/R{{ $document->major }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="sops" name="trainingPlanData[0][documentName]" readonly>
                                                    </td>
                                                    <td>
                                                        <select name="trainingPlanData[0][designation]" multiple id="designation" class="designation-select">
                                                            <option value="">Enter Your Selection Here</option>
                                                            <option value="Trainee">Trainee</option>
                                                            <option value="Officer">Officer</option>
                                                            <option value="Senior Officer">Senior Officer</option>
                                                            <option value="Executive">Executive</option>
                                                            <option value="Senior Executive">Senior Executive</option>
                                                            <option value="Assistant Manager">Assistant Manager</option>
                                                            <option value="Manager">Manager</option>
                                                            <option value="Senior General Manager">Senior General Manager</option>
                                                            <option value="Senior Manager">Senior Manager</option>
                                                            <option value="Deputy General Manager">Deputy General Manager</option>
                                                            <option value="Assistant General Manager and General Manager">Assistant General Manager and General Manager</option>
                                                            <option value="Head Quality">Head Quality</option>
                                                            <option value="VP Quality">VP Quality</option>
                                                            <option value="Plant Head">Plant Head</option>
                                                            <option value="Other Designation">Other Designation</option>
                                                        </select>
                                                        
                                                    </td>
                                                    <td>
                                                        <select name="trainingPlanData[0][trainingType]">
                                                            <option value="">-- Select --</option>
                                                            <option value="Read & Understand">Read & Understand</option>
                                                            <option value="Read & Understand with Questions">Read & Understand with Questions</option>
                                                            <option value="Classroom Training">Classroom Training</option>
                                                            <option value="On Job Training">On Job Training</option>
                                                            <option value="External Training">External Training</option>
                                                            <option value="Refresher Training">Refresher Training</option>
                                                            <option value="Retraining">Retraining</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <div class="group-input new-date-data-field mb-0">
                                                            <div class="input-date">
                                                                <div class="calenderauditee">
                                                                    <input type="text" class="test" id="scheduled_start_date1" readonly placeholder="DD-MMM-YYYY" />
                                                                    <input type="date" id="scheduled_start_date1_checkdate" 
                                                                           name="trainingPlanData[0][startDate]" 
                                                                           min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" 
                                                                           class="hide-input" 
                                                                           oninput="handleDateInput(this, 'scheduled_start_date1'); checkDate('scheduled_start_date1_checkdate','scheduled_end_date1_checkdate')" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    
                                                    <td>
                                                        <div class="group-input new-date-data-field mb-0">
                                                            <div class="input-date">
                                                                <div class="calenderauditee">
                                                                    <input type="text" class="test" id="scheduled_end_date1" readonly placeholder="DD-MMM-YYYY" />
                                                                    <input type="date" id="scheduled_end_date1_checkdate" 
                                                                           name="trainingPlanData[0][endDate]" 
                                                                           min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" 
                                                                           class="hide-input" 
                                                                           oninput="handleDateInput(this, 'scheduled_end_date1'); checkDate('scheduled_start_date1_checkdate', 'scheduled_end_date1_checkdate')" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    
                                                    <td><input type="number" min="0" name="trainingPlanData[0][total_minimum_time]" id=""></td>
                                                    <td><input type="number" min="0" name="trainingPlanData[0][per_screen_running_time]" id=""></td>
                                                    <td><button type="button" class="removeRowBtn">Remove</button></td>
                                                </tr>
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
            ele: '#Facility, #Group, #Audit, #Auditee ,#reference_record, #designee,  #designation'
        });
    </script>

    <script>
        $(document).ready(function() {

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
                    console.log('arguments', arguments[0])
                    console.log('arguments sop', arguments[0]['sops'])
                    if (Array.isArray(arguments[0])) {
                        for (var i = 0; i < arguments.length; i++) {
                            var response = arguments[i][0];
                            console.log('Response:', response);
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

        $('#doocumentPlan').change(function() {
            var row = $(this).closest('tr');
            fetchAndDisplayTitles($(this), row);
        });

        // VirtualSelect.init({
        //     ele: '#doocumentPlan',
        //     multiple: true,
        //     zIndex: 9999,
        // });
    });
    </script>

    <script>
        $(document).on('click', '.removeRowBtn', function() {
            $(this).closest('tr').remove();
        })
    </script>
@endsection
