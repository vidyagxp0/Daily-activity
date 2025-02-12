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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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
            {{ Helpers::getDivisionName(session()->get('division')) }} / Meeting
        </div>
    </div>



    {{-- ======================================
                    DATA FIELDS
    ======================================= --}}




    <div id="change-control-fields">
        <div class="container-fluid">

            <!-- Tab links -->
            <div class="cctab">
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Meeting</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm2')">    Meeting summary</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Activity Log</button>
            </div>

            <form id="auditform" action="{{ route('meetings-store') }}" method="post" enctype="multipart/form-data">
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
                                        <input type="hidden" name="record_number" id="record_number">
                                        <input disabled type="text" id="record_number" name="record_number"
                                        value="{{ Helpers::getDivisionName(session()->get('division')) }}/Meeting/{{ date('y') }}/{{ str_pad($record_number, 4, '0', STR_PAD_LEFT) }}">
                                         {{-- <input type="text"> --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Site/Location Code</b></label>
                                        <input readonly type="text"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                        <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                        
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator"><b>Initiator</b></label>
                                        <input type="hidden" name="initiator_id" value="{{ Auth::user()->id }}">                                      
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
                                        <label for="Date Due">Due Date</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="due_date" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'due_date')" />
                                        </div>
                                    </div>
                                </div>

                                
                                
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span
                                                class="text-danger">*</span></label><span id="rchars">255</span>
                                        characters remaining
                                        <input id="docname" type="text" name="short_description" maxlength="255" required>
                                    </div>
                                </div>  
                               
                                <div class="col-lg-6">
                                    <div class="group-input ">
                                        <label for="Date Due"><b>Scheduled Start Date</b></label>
                                        <input type="text" id="dateTimePicker" class="form-control" name="scheduled_start_date" placeholder="Select Date and Time">
                                    </div>
                                </div>
                              
                                <div class="col-lg-6">
                                    <div class="group-input ">
                                        <label for="Date Due"><b>Scheduled End Date</b></label>
                                        <input type="text" id="dateTimePicker" class="form-control" name="scheduled_end_date" placeholder="Select Date and Time">
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
                                    $( function() {
                                      $( ".datepicker" ).datepicker({
                                        dateFormat: 'd M yy'
                                      });
                                       } );
                                    </script>
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
                                                    <option value="{{ $data1->id }}"    >
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
                                                    <th> Date</th>
                                                    <th>Topic</th>
                                                    <th>Responsible</th>
                                                    <th>Scheduled Start Time</th>
                                                    {{-- <th>Scheduled End Date</th> --}}
                                                    <th>Scheduled End Time</th>
                                                    {{-- <th>Auditee</th> --}}
                                                    <th>Comment</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <td><input disabled type="text" name="serial_number[]" value="1"></td>
                                                <td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"> <input type="text" id="grid_date' + serialNumber +'" readonly placeholder="DD-MMM-YYYY" /><input type="date" name="grid_date[]" id="grid_date' + serialNumber +'_checkdate" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"  class="hide-input" oninput="handleDateInput(this, `grid_date' + serialNumber +'`);checkDate(`grid_date' + serialNumber +'_checkdate`,`grid_date' + serialNumber +'_checkdate`)" /></div></div></div></td>
                                                <td><input type="text" name="topic"></td>
                                                <td><input type="text" name="responsible"></td>
                                                <td><input type="time" name="scheduled_start_time_grid"></td> 
                                                <td><input type="time" name="scheduled_end_time_grid"></td>
                                                <td><input type="text" name="remarks"></td>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Description">Description</label>
                                        <textarea name="description" id="description" cols="30" ></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Description">Related URLs</label>
                                        <input type="text" name="related_urls" id="related_urls"  >
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Inv Attachments"> Attached Files</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="attachment_files"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="attachment_files[]"
                                                    oninput="addMultipleFiles(this, 'attachment_files')" multiple>
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
                               
                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Date Due"><b>Actual Start Date</b></label>
                                        <input type="text" class="datepicker" name="actual_start_date" placeholder="Select Date and Time">
                                    </div>
                                </div>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Date Due"><b>Actual End Date</b></label>
                                        <input type="text" class="datepicker" name="actual_end_date" placeholder="Select Date and Time">
                                    </div>
                                </div>
                                
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Meeting Minutes">Meeting Minutes</label>
                                      <textarea name="meeting_minutes" id="" cols="30" ></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="decisions">decisions</label>
                                      <textarea name="decisions" id="" cols="30" ></textarea>
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
                                            <option>Asia</option>
                                            <option>Europe</option>
                                            <option>Africa</option>
                                            <option>Central America</option>
                                            <option>South America</option>
                                            <option>Oceania</option>
                                            <option>North America</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Country">Country</label>
                                        <select name="country" class="form-select country"
                                            aria-label="Default select example" onchange="loadStates()">
                                            <option value="">Select Country</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="City">State</label>
                                        <select name="state" class="form-select state" aria-label="Default select example"
                                            onchange="loadCities()">
                                            <option value="">Select State/District</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="State/District">City</label>
                                        <select name="city" class="form-select city" aria-label="Default select example">
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
                                        <label for="site name">Site Name </label>
                                        <input type="text" name="site_name">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Building">Building </label>
                                        <input type="text" name="building">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Floor">Floor </label>
                                        <input type="text" name="floor">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Room">Room </label>
                                        <input type="text" name="room">
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
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Audit Schedule On">Complete On</label>
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
