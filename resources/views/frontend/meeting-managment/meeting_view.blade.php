@extends('frontend.layout.main')
@section('container')
    @php
        $users = DB::table('users')
            ->select('id', 'name')
            ->get();

    @endphp
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
        }
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

        #change-control-fields>div>div.inner-block.state-block>div.status>div.progress-bars.d-flex>div:nth-child(3) {
            border-radius: 0px 20px 20px 0px;

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
        $(document).ready(function() {
            $('#internalaudit-table').click(function(e) {
                function generateTableRow(serialNumber) {
                    var users = @json($users);
                    console.log(users);
                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial_number[]" value="' + serialNumber +'"></td>' +
                        '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"> <input type="text" id="grid_date' + serialNumber +'" readonly placeholder="DD-MMM-YYYY" /><input type="date" name="grid_date[]" id="grid_date' + serialNumber +'_checkdate" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"  class="hide-input" oninput="handleDateInput(this, `grid_date' + serialNumber +'`);checkDate(`grid_date' + serialNumber +'_checkdate`,`grid_date' + serialNumber +'_checkdate`)" /></div></div></div></td>' +
                        '<td><input type="text" name="topic[]"></td>' +
                        '<td><input type="text" name="responsible[]"></td>' +
                        '<td><input type="time" name="scheduled_start_time_grid[]"></td>' +
                        '<td><input type="time" name="scheduled_end_time_grid[]"></td>' +
                        '<td><input type="text" name="remarks[]"></td>' +
                        '</tr>';
    
                    return html;
                }
    
                var tableBody = $('#internalaudit tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>
    <div class="form-field-head">

        <div class="division-bar">
            <strong>Site Division/Project</strong> :
            {{ Helpers::getDivisionName($data->division_id) }} / Meeting
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
                        @php
                        $userRoles = DB::table('user_roles')->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => $data->division_id])->get();
                        $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                    @endphp
                        {{-- <button class="button_theme1" onclick="window.print();return false;" class="new-doc-btn">Print</button> --}}
                        {{--  <button class="button_theme1"> <a class="text-white" href="{{ url('send-notification', $data->id) }}"> Send Notification </a> </button>  --}}

                        <button class="button_theme1"> <a class="text-white"
                                href="{{ url('rcms/meeting-audit-trial', $data->id) }}"> Audit Trail </a> </button>
                        @if ($data->stage == 1 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Submit
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>
                        @elseif($data->stage == 2 && (in_array(1, $userRoleIds) || in_array(18, $userRoleIds)))
                           
                            
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                               Complete
                            </button>
                        @endif
                        <a class="text-white button_theme1" href="{{ url('rcms/qms-dashboard') }}">
                            Exit
                        </a>
                    </div>

                </div>
                <div class="status">
                    <div class="head">Current Status</div>
                    @if ($data->stage == 0)
                        <div class="progress-bars">
                            <div class="active bg-danger">Closed-Cancelled</div>
                        </div>
                    @else
                        <div class="progress-bars d-flex">
                            @if ($data->stage >= 1)
                                <div class="active">Opened</div>
                            @else
                                <div class="">Opened</div>
                            @endif

                            @if ($data->stage >= 2)
                                <div class="active">In Progress
                                </div>
                            @else
                                <div class="">In Progress
                                </div>
                            @endif
                          
                                @if ($data->stage >= 3) 
                                    <div class="bg-danger">Closed-Done</div>
                                @else
                                    <div class="">Closed-Done</div>
                                @endif
                            
                        </div>
                    @endif
                </div>
            </div>
            <!-- Tab links -->
            <div class="cctab">
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Meeting</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm2')">    Meeting summary</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Activity Log</button>
            </div>

            <form id="auditform" action="{{ route('meeting-update', $data->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div id="step-form">

                    <!-- General information content -->
                    <div id="CCForm1" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">

                                @if (!empty($parent_id))
                                    <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                                    <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                                @endif
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>Record Number</b></label>
                                        <input disabled type="text" id="record_number" name="record_number"
                                            value="{{ Helpers::getDivisionName($data->division_id) }}/Meeting/{{ date('Y') }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT)  }}">
                                           
                                         {{-- <input type="text"> --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Site/Location Code</b></label>
                                        <input readonly type="text" name="division_code"
                                            value="{{ Helpers::getDivisionName($data->division_id) }}">
                                        <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                        
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
                                        <select id="select-state" placeholder="Select..." name="assign_to">
                                            <option value="">Select a value</option>
                                            @foreach ($users as $value)
                                                        <option {{ $data->assign_to == $value->id ? 'selected' : '' }}
                                                            value="{{ $value->id }}">{{ $value->name }}</option>
                                                    @endforeach
                                        </select>
                                        @error('assign_to')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                               
                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Date Due">Due Date</label>
                                        <input type="text" class="datepicker" name="due_date" value="{{ $meeting->due_date }}" placeholder="Select Due Date ">
                                    </div>
                                </div>

                                
                                <script>
                                    $( function() {
                                      $( ".datepicker" ).datepicker({
                                        dateFormat: 'd M yy'
                                      });
                                       } );
                                    </script>
                                      
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span
                                                class="text-danger">*</span></label><span id="rchars">255</span>
                                        characters remaining
                                        <input id="docname" type="text" value="{{ $meeting->short_description }}" name="short_description" maxlength="255" required>
                                    </div>
                                </div>  

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Date Due">Scheduled Start Date</label>
                                        <input type="text" id="dateTimePicker" class="form-control" name="scheduled_start_date" value="{{ $meeting->scheduled_start_date }}" placeholder="Select Due Date ">
                                    </div>
                                </div>
                                 
                                <div class="col-lg-6">
                                    <div class="group-input ">
                                        <label for="Date Due"><b>Scheduled End Date</b></label>
                                        <input type="text" id="dateTimePicker" class="form-control" name="scheduled_end_date" value="{{ $meeting->scheduled_end_date }}" placeholder="Select Date and Time">
                                    </div>
                                </div>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        flatpickr("#dateTimePicker", {
                                            enableTime: true, // Enables time selection
                                            dateFormat: "Y-m-d H:i", // Custom date and time format
                                            time_24hr: true // Use 24-hour format
                                        });
                                    })
                                </script>
                                <script>
                                    $(document).ready(function() {
                                        $('.datetimepicker').datetimepicker({
                                            format: 'd M Y H:i',
                                        });
                                    });
                                </script>
                                <script src="http://meeting.vidyagxp.com/js/datetimepicker/jquery.datetimepicker.full.min.js"></script>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Reference Recores">Attendees</label>
                                        <select multiple id="attandees" name="attandees[]">
                                            {{-- <option value="">--Select---</option> --}}
                                            @php
                                                $users = App\Models\User::all();
                                            @endphp
                                            @foreach ($users as $data1)
                                                {{-- @if (in_array($data1->id, $auditeeId)) --}}
                                                    <option value="{{ $data1->id }}" {{ in_array($data1->id, $auditeeId ) ? 'selected' : '' }}>
                                                        {{ $data1->name }}</option>
                                                {{-- @endif --}}
                                            @endforeach                                           
                                        </select>
                                    </div>
                                </div>
                              
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="audit-agenda-grid">
                                             Agenda<button type="button" name="audit-agenda-grid"
                                                id="internalaudit-table">+</button>
                                        </label>
                                        <table class="table table-bordered" id="internalaudit">
                                            <thead>
                                                <tr>
                                                    <th>Row#</th>
                                                    <th>Date</th>
                                                    <th>Topic</th>
                                                    <th>Responsible</th>
                                                    <th>Scheduled Start Time</th>
                                                    <th>Scheduled End Time</th>
                                                    <th>Comment</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(!empty($meetingGrid->grid_date))
                                                    @foreach($meetingGrid->grid_date as $index => $date)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td><input type="text" name="grid_date[]" value="{{ \Carbon\Carbon::parse($date)->format('d-M-Y') }}"></td>
                                                            <td><input type="text" name="topic[]" value="{{ $meetingGrid->topic[$index] }}"></td>
                                                            <td><input type="text" name="responsible[]" value="{{ $meetingGrid->responsible[$index] }}"></td>
                                                            <td><input type="time" name="scheduled_start_time_grid[]" value="{{ $meetingGrid->scheduled_start_time_grid[$index] }}"></td>
                                                            <td><input type="time" name="scheduled_end_time_grid[]" value="{{ $meetingGrid->scheduled_end_time_grid[$index] }}"></td>
                                                            <td><input type="text" name="remarks[]" value="{{ $meetingGrid->remarks[$index] }}"></td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Description">Description</label>
                                        <textarea name="description" id="description" cols="30" >{{ $meeting->description }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Description">Related URLs</label>
                                        <input type="text" name="related_urls" id="related_urls" value="https://mms.mydemosoftware.com/join/{{ $meeting->meeting_id }}" >
                                    </div>
                                </div>
                               
                                
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Inv Attachments">Acknowledgement Attachment</label>
                                    <div>
                                        <small class="text-primary">
                                            Please Attach all relevant or supporting documents
                                        </small>
                                    </div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="attachment_files">

                                            @if ($data->attachment_files)
                                                @foreach (json_decode($data->attachment_files) as $file)
                                                    <h6 type="button" class="file-container text-dark"
                                                        style="background-color: rgb(243, 242, 240);">
                                                        <b>{{ $file }}</b>
                                                        <a href="{{ asset('upload/' . $file) }}" target="_blank"><i
                                                                class="fa fa-eye text-primary"
                                                                style="font-size:20px; margin-right:-10px;"></i></a>
                                                        <a type="button" class="remove-file"
                                                            data-file-name="{{ $file }}"><i
                                                                class="fa-solid fa-circle-xmark"
                                                                style="color:red; font-size:20px;"></i></a>
                                                    </h6>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="attachment_files" name="attachment_files[]"
                                                oninput="addMultipleFiles(this,'attachment_files')" multiple>
                                        </div>
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
                               
                                <div class="col-lg-6">
                                    <div class="group-input ">
                                        <label for="Date Due"><b>Actual Start Date</b></label>
                                        <input type="text" class="datepicker" value="{{ $meeting->actual_start_date }}" name="actual_start_date" placeholder="Select Date and Time">
                                    </div>
                                </div>
                                 
                                <div class="col-lg-6">
                                    <div class="group-input ">
                                        <label for="Date Due"><b>Actual End Date</b></label>
                                        <input type="text" class="datepicker" value="{{ $meeting->actual_end_date }}" name="actual_end_date" placeholder="Select Date and Time">
                                    </div>
                                </div>
                                
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Meeting Minutes">Meeting Minutes</label>
                                      <textarea name="meeting_minutes" id="" cols="30" >{{ $meeting->meeting_minutes }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="decisions">Decisions</label>
                                      <textarea name="decisions" id="" cols="30" >{{ $meeting->decisions }}</textarea>
                                    </div>
                                </div>
                                


                                <div class="sub-head">
                                    Geographic Information 
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Zone">Zone</label>
                                        <select name="zone">
                                            <option value="">Enter Your Selection Here</option>
                                            <option value="Asia" {{ $meeting->zone == 'Asia' ? 'selected' : '' }}>Asia</option>
                                            <option value="Europe" {{ $meeting->zone == 'Europe' ? 'selected' : '' }}>Europe</option>
                                            <option value="Africa" {{ $meeting->zone == 'Africa' ? 'selected' : '' }}>Africa</option>
                                            <option value="Central America" {{ $meeting->zone == 'Central America' ? 'selected' : '' }}>Central America</option>
                                            <option value="South America" {{ $meeting->zone == 'South America' ? 'selected' : '' }}>South America</option>
                                            <option value="Oceania" {{ $meeting->zone == 'Oceania' ? 'selected' : '' }}>Oceania</option>
                                            <option value="North America" {{ $meeting->zone == 'North America' ? 'selected' : '' }}>North America</option>
                                        </select>
                                        
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Country">Country</label>
                                        <select name="country" class="form-select country"
                                            aria-label="Default select example" onchange="loadStates()">
                                            <option value="">Select Country</option>
                                            @if ($meeting->country)
                                                <option value="{{ $meeting->country }}" selected>{{  $meeting->country  }}</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="City">State</label>
                                        <select name="state" class="form-select state" aria-label="Default select example"
                                            onchange="loadCities()">
                                            <option value="">Select State/District</option>
                                            @if ($meeting->state)
                                            <option value="{{ $meeting->state }}" selected>{{  $meeting->state  }}</option>
                                        @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="State/District">City</label>
                                        <select name="city" class="form-select city" aria-label="Default select example">
                                            <option value="">Select City</option>
                                            @if ($meeting->city)
                                            <option value="{{ $meeting->city }}" selected>{{  $meeting->city  }}</option>
                                        @endif
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
                                        <label for="site name">Site Name </label>
                                        <input type="text" value="{{ $meeting->site_name }}" name="site_name">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Building">Building </label>
                                        <input type="text" value="{{ $meeting->building }}" name="building">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Floor">Floor </label>
                                        <input type="text" value="{{ $meeting->floor }}" name="floor">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Room">Room </label>
                                        <input type="text" value="{{ $meeting->room }}" name="room">
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

                    <!-- Activity Log content -->
                    <div id="CCForm3" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Audit Schedule On">Complete By</label>
                                        <div class="static">{{ $meeting->submitted_by }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Audit Schedule On">Complete On</label>
                                        <div class="static">{{ $meeting->submitted_on }}</div>
                                    </div>
                                </div>
                               
                            </div>
                            <div class="button-block">
                                {{-- <button type="submit" class="saveButton">Save</button> --}}
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                {{-- <button type="submit">Submit</button> --}}
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>
    <div class="modal fade" id="signature-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('meeting_stage_change', $meeting->id) }}" method="POST"
                    id="signatureModalForm">
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
            ele: '#Facility, #Group, #Audit, #Auditee ,#attandees'
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
            $('#rchars').text(textlen);});
    </script>
@endsection
