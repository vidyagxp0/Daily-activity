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

    <div class="form-field-head">

        <div class="division-bar">
            {{-- <strong>Site Division/Project</strong> : --}}
            Yearly Training Planner
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
                <button class="cctablinks" onclick="openCity(event, 'CCForm2')"> In Review</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">For Approve</button>
                {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Compliance and Review</button> --}}
                {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Supplementary Materials</button> --}}
                {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Activity Log</button> --}}
            </div>

            <form id="mainForm" action="{{ route('YTP.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div>

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
                                        <select id="site_division" name="site_division" onchange="toggleMultiSelect()">
                                            <option value="">Select Division</option>
                                            <option value="P1(Indore Location)">P1 (Indore Location)</option>
                                            <option value="P2(Pithampur Location)">P2 (Pithampur Location)</option>
                                            <option value="P4(Ujjain Site)">P4 (Ujjain Site)</option>
                                            <option value="C1(China Plant)">C1 (China Plant)</option>
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
                                        <input disabled type="text" value="{{ date('d-M-Y') }}" name="initiation_date">
                                        <input type="hidden" value="{{ date('d-M-Y') }}" name="initiation_date">
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Department">Department Name<span class="text-danger">*</span></label>
                                        <select name="department" id="department" required
                                            onchange="toggleOtherDepartment()">
                                            <option value="">-- Select --</option>

                                            @foreach (Helpers::getDepartments() as $code => $department)
                                                <option value="{{ $code }}"
                                                    {{ old('department') == $code ? 'selected' : '' }}>
                                                    {{ $department }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Year">Year<span class="text-danger">*</span></label>
                                        <select name="year" id="year" required>
                                            <!-- Options will be dynamically added here -->
                                        </select>
                                    </div>
                                </div>

                                <script>
                                    // Get the current year
                                    const currentYear = new Date().getFullYear();
                                    const startYear = 1900; // Define the start year
                                    const defaultSelectedYear = 2000; // Set the default selected year

                                    // Get the year select element
                                    const yearSelect = document.getElementById('year');

                                    // Populate the select with options from startYear to currentYear
                                    for (let year = currentYear; year >= startYear; year--) {
                                        const option = document.createElement('option');
                                        option.value = year;
                                        option.textContent = year;

                                        // Check if this year is the default selected year
                                        if (year === defaultSelectedYear) {
                                            option.selected = true; // Make this option selected by default
                                        }

                                        yearSelect.appendChild(option);
                                    }

                                    // After appending all options, set the default selected year explicitly
                                    yearSelect.value = defaultSelectedYear;

                                    // Event listener to update selected year
                                    yearSelect.addEventListener('change', function() {
                                        const selectedYear = yearSelect.value;
                                        console.log("Selected year:", selectedYear);
                                    });
                                </script>

                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Type of Material">Reference Number</label>
                                        <select name="document_number" id="document_number">
                                            <option value="">----Select---</option>
                                            @foreach ($data as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->sop_type_short }}/{{ $item->department_id }}/000{{ $item->id }}/R{{ $item->major }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">Topic/Subject</label>
                                        <input type="text" name="topic" id="topic">
                                    </div>
                                </div>




                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="start_date">Start Date <span class="text-danger">*</span></label>
                                        <input id="start_date" type="date" name="start_date" onchange="setMinEndDate()"
                                            required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="end_date">End Date <span class="text-danger">*</span></label>
                                        <input id="end_date" type="date" name="end_date" onchange="setMaxStartDate()"
                                            required>
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
                                <button type="submit" id="ChangesaveButton01" class="saveButton on-submit-disable-button">Save</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                            </div>

                        </div>

                    </div>
                    <div id="CCForm2" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-lg-12 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Review Comment">Review Comment</label>
                                        <textarea type="text" name="Review_Comment" id="Review_Comment"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Review Attachments">Review Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or Review
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Review_Attachments">

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
                                <button type="submit" class="saveButton on-submit-disable-button">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>

                            </div>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function() {          
                            $('#mainForm').on('submit', function(e) {
                                $('.on-submit-disable-button').prop('disabled', true);
                            });
                        })
                    </script>
                    <div id="CCForm3" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-lg-12 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Approval Comment">Approval Comment</label>
                                        <textarea type="text" name="Approval_Comment" id="Approval_Comment"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Approval Attachments">Approval Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or Approval
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Approval_Attachments">

                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="Approval_Attachments"
                                                    name="Approval_Attachments[]"
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
        function toggleOtherDepartment() {
            const departmentSelect = document.getElementById('department');
            const otherDepartmentContainer = document.getElementById('other_department_container');
            // Check if the selected department is "Other"
            if (departmentSelect.value === "Other") {
                otherDepartmentContainer.style.display = 'block';
            } else {
                otherDepartmentContainer.style.display = 'none';
            }
        }

        // Call the function on page load to set the initial state of the Other Department input
        window.onload = function() {
            toggleOtherDepartment();
        };
    </script>

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
@endsection
