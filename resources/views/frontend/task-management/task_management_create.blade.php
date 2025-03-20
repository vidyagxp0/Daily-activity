@extends('frontend.layout.main')
@section('container')
    <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
        }
        iframe#\:2\.container {
        /* display: none; */
        height: 0px !important;
        background: #4274da !important;
    }
    img.goog-te-gadget-icon {
        display: none;
    }
    .skiptranslate.goog-te-gadget {
        margin-bottom: 0px;
    }
    div#google_translate_element {
        border: none;
    }
    .VIpgJd-ZVi9od-aZ2wEe-wOHMyf.VIpgJd-ZVi9od-aZ2wEe-wOHMyf-ti6hGc {
        display: none;
    }
    </style>
    

    <style>
        .time-required {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .time-required input {
            width: 70px;
            text-align: center;
            border: 1px solid #ccc;
        }

    </style>

    <div class="form-field-head">
        <div class="division-bar">
            <strong>Site Division/Project</strong> :
            {{ "India" }} / Presentation
            {{-- KSA / Root Cause Analysis   --}}
            {{-- EHS-North America --}}
        </div>
    </div>

    @php
        $users = DB::table('users')->get();
    @endphp

    {{-- ======================================
                    DATA FIELDS
    ======================================= --}}
    <div id="change-control-fields">
        <div class="container-fluid">
            
                        
            <script type="text/javascript">
                function googleTranslateElementInit() {
                    new google.translate.TranslateElement({
                        pageLanguage: 'en',
                        includedLanguages: 'en,es,fr,de,zh,hi,ar,pt,ja,ru',
                        layout: google.translate.TranslateElement.InlineLayout.SIMPLE
                    }, 'google_translate_element');
                }
            </script>                                            
            <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
            <script>
                $(document).ready(function() {
                    setTimeout(() => {
                        $('body').css('top', '0');
                    }, 5000);
                })
            </script>

            <!-- Tab links -->
            <div class="language-sleect d-flex" style="align-items: center; gap: 20px; margin-left: 20px;">
                <div>Select Language </div>
            <div class="main-head" id="google_translate_element"></div>
            </div>
            <div class="cctab">

                <button class="cctablinks" onclick="openCity(event, 'CCForm1')">General Information</button>
                <!-- <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Activity Log</button> -->
            </div>


            <form  action="{{ route('task_management_store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div id="step-form">    
                    @if (!empty($parent_id))
                        <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                        <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                    @endif

                    <div id="CCForm1" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>Record Number</b></label>
                                        <input disabled type="text" name="record_number"
                                            value="{{ Helpers::getDivisionName(session('division')) }} /{{ Auth::user()->name }}/{{ now()->format('d-M-Y') }}/{{ str_pad($record_number, 6, '0', STR_PAD_LEFT) }}">

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="originator">Initiator</label>
                                        <input readonly type="text" name="originator_id"
                                            value="{{ Auth::user()->name }}" />
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input ">
                                        <label for="Date Due"><b>Date of Initiation</b></label>
                                        <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                        <input type="hidden" value="{{ date('d-m-Y') }}" name="intiation_date">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="Division Code"><b>Division Code</b></label>
                                                    @if(!empty($parent_id))
                                                    <input readonly type="text" name="division_code" value="{{ Helpers::getDivisionName($parent_division_id) }}">
                                                    <input type="hidden" name="division_id" value="{{ $parent_division_id }}">
                                                @else
                                                    <input readonly type="text" name="division_code" value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                                    <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                                @endif
                                                </div>
                                            </div>

                               

                                <!-- =========================================================== -->
                                <div class="col-12 mb-4">
                                    <div class="group-input">
                                        <label for="agenda">
                                          Presentation
                                            <button type="button" name="agenda"
                                                id="task_manamegemnt_grid">+</button>
                                        </label>
                                       <div class="table-responsive">
    <table class="table table-bordered" style="width: 250%" id="task_Management_Table">
        <thead>
            <tr style="text-align: center; vertical-align: middle; padding: 20px;">
                <th>Row #</th>
                <th>Topic</th>
                <th>Category</th>
                <th>Date</th>
                <th>Speaker</th>
                <th>Attachments</th>
                <th> Remarks </th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <input disabled type="text" name="TaskManagementData[0][serial]" value="1">
                </td>
               
                <td>
                    <textarea class="auto-resize-textarea" name="TaskManagementData[0][activity1_task]"></textarea>
                </td>

                <td>
                    <select id="" placeholder="Select..." name="TaskManagementData[0][validation_team_name]">
                        <option value="">-- Select --</option>
                        <option value="GLP">GLP</option>
                        <option value="GMP">GMP</option>
                        <option value="GCP">GCP</option>
                        <option value="GDP">GDP</option>
                        <option value="GEP">GEP</option>
                        <option value="Others">Others</option>
                    </select>
                </td>

                <td>
                    <input type="datetime-local" name="TaskManagementData[0][testing_completed_by_developer_on]" class="datetimepicker">
                </td>
               
                <td>
                    <select name="TaskManagementData[0][work_in_progress_detail]" class="form-control">
                        <option value="">-- Select Speaker --</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" @if(old('TaskManagementData.0.work_in_progress_detail') == $user->id) selected @endif>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </td>
                
                 
                <td>
                    <input type="file" name="TaskManagementData[0][developer_testing_details]" >
                </td>

                <td>
                    <textarea class="auto-resize-textarea" name="TaskManagementData[0][remaining_work]"></textarea>
                </td>

               
                <td><button type="button" class="removeRowBtn">Remove</button></td>
            </tr>
        </tbody>
    </table>
</div>
                                    </div>
                                </div>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        // Initialize Flatpickr for all input fields with class 'datetimepicker'
                                        flatpickr(".datetimepicker", {
                                            enableTime: true,
                                            dateFormat: "d-M-Y H:i",
                                            time_24hr: true
                                        });
                                    });
                                </script>

<script>
    $(document).ready(function () {
        let investdetails = 1;

        // Manually embed user data inside script
        let usersList = [
            @foreach ($users as $user)
                { id: "{{ $user->id }}", name: "{{ $user->name }}" },
            @endforeach
        ];

        function generateTableRow(serialNumber) {
            let userOptions = '<option value="">-- Select Speaker --</option>';
            usersList.forEach(user => {
                userOptions += `<option value="${user.id}">${user.name}</option>`;
            });

            var html =
                '<tr>' +
                '<td><input disabled type="text" style="width:15px" value="' + serialNumber + '"></td>' +
                '<td><textarea class="auto-resize-textarea" name="TaskManagementData[' + investdetails + '][activity1_task]"></textarea></td>' +
                '<td><select name="TaskManagementData[' + investdetails + '][validation_team_name]">' +
                '<option value="">-- Select --</option>' +
                '<option value="GLP">GLP</option>' +
                '<option value="GMP">GMP</option>' +
                '<option value="GCP">GCP</option>' +
                '<option value="GEP">GEP</option>' +
                '<option value="GDP">GDP</option>' +
                '<option value="Others">Others</option>' +
                '</select></td>' +

                '<td><input type="datetime-local" name="TaskManagementData[' + investdetails + '][testing_completed_by_developer_on]" class="datetimepicker"></td>' +

                // Speaker dropdown instead of Work in Progress Detail
                '<td><select name="TaskManagementData[' + investdetails + '][work_in_progress_detail]">' +
                userOptions +
                '</select></td>' +

                '<td><input type="file" name="TaskManagementData[' + investdetails + '][developer_testing_details]" ></td>' +
                '<td><textarea class="auto-resize-textarea" name="TaskManagementData[' + investdetails + '][remaining_work]"></textarea></td>' +

                '<td><button class="removeRowBtn">Remove</button></td>' +
                '</tr>';
            investdetails++; // Increment row count
            return html;
        }

        $('#task_manamegemnt_grid').click(function (e) {
            var tableBody = $('#task_Management_Table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });

        $(document).on('click', '.removeRowBtn', function () {
            $(this).closest('tr').remove();
        });
    });
</script>


                                <script>
                                    function updateTime(element) {
                                        // Extract the row index from the input field's ID
                                        let index = element.id.split('_')[1];

                                        // Get the values from the corresponding input fields
                                        let days = parseInt(document.getElementById(`days_${index}`).value) || 0;
                                        let hours = parseInt(document.getElementById(`hours_${index}`).value) || 0;
                                        let minutes = parseInt(document.getElementById(`minutes_${index}`).value) || 0;
                                        let days_second = parseInt(document.getElementById(`days_second${index}`).value) || 0;
                                        let hours_second = parseInt(document.getElementById(`hours_second${index}`).value) || 0;
                                        let minutes_second = parseInt(document.getElementById(`minutes_second${index}`).value) || 0;

                                        // Validate the inputs
                                        if (days < 0) {
                                            alert("Days cannot be negative.");
                                            document.getElementById(`days_${index}`).value = 0;
                                            document.getElementById(`days_second${index}`).value = 0; // Reset to 0
                                            return;
                                        }

                                        if (hours < 0 || hours > 23) {
                                            alert("Hours must be between 0 and 23.");
                                            document.getElementById(`hours_${index}`).value = 0;
                                            document.getElementById(`hours_second${index}`).value = 0; // Reset to 0
                                            return;
                                        }

                                        if (minutes < 0 || minutes > 59) {
                                            alert("Minutes must be between 0 and 59.");
                                            document.getElementById(`minutes_${index}`).value = 0;
                                            document.getElementById(`minutes_second${index}`).value = 0;// Reset to 0
                                            return;
                                        }

                                        // Convert everything to total minutes
                                        let totalMinutes = (days * 24 * 60) + (hours * 60) + minutes;

                                        // Convert back to days, hours, and minutes for display (if needed)
                                        let displayDays = Math.floor(totalMinutes / (24 * 60));
                                        let displayHours = Math.floor((totalMinutes % (24 * 60)) / 60);
                                        let displayMinutes = totalMinutes % 60;

                                        console.log(`Row ${index}: ${displayDays} Days, ${displayHours} Hours, ${displayMinutes} Minutes`);
                                    }
                                </script>
                                <div class="group-input">
                                <label for="qa-eval-comments">Final Comments</label>
                                <div >
                                    <textarea name="final_comments" ></textarea>
                                    @component('frontend.forms.language-model')
                                    @endcomponent
                                </div>
                            </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="others">Supporting document</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="in_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="in_attachment" name="in_attachment[]"
                                                    oninput="addMultipleFiles(this, 'in_attachment')" multiple>

                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!-- =========================================================== -->

                            </div>
                            <div class="button-block">
                                <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                                <button type="button" id="ChangeNextButton" class="nextButton">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
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
        VirtualSelect.init({
            ele: '#investigators, #department, #root-cause-methodology,#investigation_team'
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
        $(document).on('click', '.removeRowBtn', function() {
            $(this).closest('tr').remove();
        })
    </script>
    <script>
        var maxLength = 255;
        $('#docname').keyup(function() {
            var textlen = maxLength - $(this).val().length;
            $('#rchars').text(textlen);
        });
    </script>
    <script>
     
    document.addEventListener('DOMContentLoaded', function () {
        const textareas = document.querySelectorAll('.auto-resize-textarea');
        textareas.forEach(textarea => {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto'; // Reset the height
                this.style.height = (this.scrollHeight) + 'px'; // Set the height to the scroll height
            });

            // Trigger the input event to adjust the height initially (if there's content)
            textarea.dispatchEvent(new Event('input'));
        });
    });
</script>
      
@endsection
