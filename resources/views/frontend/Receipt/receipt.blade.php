@extends('frontend.rcms.layout.main_rcms')
@section('rcms_container')
    <style>
        #change-control-fields .inner-block .group-input table input, #change-control-fields .inner-block .group-input table select{
            border: 1px solid black;
            padding: 4px
        }
        header .header_rcms_bottom {
            display: none;
        }

        .calenderauditee {
            position: relative;
        }

        .new-date-data-field .input-date input.hide-input {
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
        }

        .new-date-data-field input {
            border: 1px solid grey;
            border-radius: 5px;
            padding: 5px 15px;
            display: block;
            width: 100%;
            background: white;
        }

        .calenderauditee input::-webkit-calendar-picker-indicator {
            width: 100%;
        }

        .remove-file {
            cursor: pointer;
        }
    </style>
       <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
    
        table, th, td {
            border: 1px solid black; /* Black border */
        }
    
        th, td {
            padding: 8px;
            text-align: center;
        }
    
        /* Styling for headers */
        .storage-header {
            background-color: #f0ad4e; /* Orange for Storage and Handling */
            color: #000;
            font-size: 13px;
        }
    
        .inventory-header {
            background-color: #5bc0de; /* Blue for Inventory Management */
            color: #000;
            font-size: 13px;
        }
    
        .reagent-header {
            background-color: #5cb85c; /* Green for Reagent Information */
            color: #000;
            font-size: 13px;
        }
    
        .destruction-header {
            background-color: #d9534f; /* Red for Destruction Instruction */
            color: #000;
            font-size: 13px;
        }
    
        /* Adjusting input width */
        input, select {
            width: 100%;
            box-sizing: border-box;
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
        $('#ObservationAdd').click(function(e) {
            function generateTableRow(serialNumber) {
                $(document).ready(function () {
                        $(".datepicker").datepicker({
                            dateFormat: "d-M-yy" 
                        });
                    });

            function getCurrentDate() {
                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0'); // Months are zero-based
                var yyyy = today.getFullYear();
                return dd + '-' + mm + '-' + yyyy;
            }    

            var currentDate = getCurrentDate();
                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="sample_coordinator[' + serialNumber + '][serial]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" class="datepicker" name="sample_coordinator[' + serialNumber + '][assignment_date]" value="' + currentDate + '" placeholder="DD-MM-YYYY"></td>' +
                    '<td><input type="text" name="sample_coordinator[' + serialNumber + '][analytical_receipt]"></td>' +
                    '<td><input type="text" name="sample_coordinator[' + serialNumber + '][sample_name]"></td>' +
                    '<td><input type="text" name="sample_coordinator[' + serialNumber + '][Batch]"></td>' +
                    '<td><input type="text" name="sample_coordinator[' + serialNumber + '][sample_quantity]"></td>' +
                    '<td><input type="text" class="datepicker" name="sample_coordinator[' + serialNumber + '][manufacturing_date]" placeholder="DD-MM-YYYY"></td>' +
                    '<td><input type="text" class="datepicker" name="sample_coordinator[' + serialNumber + '][expiry_date]" placeholder="DD-MM-YYYY"></td>' +
                    '<td><input type="text" name="sample_coordinator[' + serialNumber + '][recommended_storage]"></td>' +
                    '<td><input type="text" name="sample_coordinator[' + serialNumber + '][physical_observation]"></td>' +
                    '<td><input type="text" class="Document_Remarks" name="sample_coordinator[' + serialNumber + '][Remarks]"></td>' +
                    '<td><button type="button" class="btn btn-danger remove-row">Remove</button></td>' +
                    '</tr>';
                return html;
            }

            var tableBody = $('#job-responsibilty-table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);

            $('#job-responsibilty-table').on('click', '.remove-row', function() {
                    $(this).closest('tr').remove();
                    updateSerialNumbers();
            });


        });
    });
</script>
<style>
    .highlight {
      background-color: yellow!important;
      border: 2px solid orange!important;
    }
    #google_translate_element > div > span{
        display: none !important;
    }
</style>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
            let docIndex = 1;
            $('#documentAdd').click(function(e) {
                function generateTableRow(serialNumber) {
                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        ' <td><input type="text" name="documentDetails[' + docIndex +
                        '][currentDocNumber]"></td>' +
                        ' <td><input type="text"name="documentDetails[' + docIndex +
                        '][currentVersionNumber]"></td>' +
                        '<td><input type="text" name="documentDetails[' + docIndex +
                        '][newDocNumber]"></td>' +
                        '<td><input type="text" name="documentDetails[' + docIndex +
                        '][newVersionNumber\]"></td>' +
                        '<td><button type="text" class="removeRowBtn">Remove</button></td>' +
                        '</tr>';
                    '</tr>';

                    docIndex++;
                    return html;
                }
                var tableBody = $('#documentTableDetails tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            let affectedDocIndex = 1;
            $('#affectedDocAdd').click(function(e) {
                function generateTableRow(serialNumber) {
                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        ' <td><input type="text" name="affectedDocuments[' + affectedDocIndex +
                        '][afftectedDoc]"></td>' +
                        ' <td><input type="text"name="affectedDocuments[' + affectedDocIndex +
                        '][documentName]"></td>' +
                        '<td><input type="number" name="affectedDocuments[' + affectedDocIndex +
                        '][documentNumber]"></td>' +
                        '<td><input type="text" name="affectedDocuments[' + affectedDocIndex +
                        '][versionNumber]"></td>' +
                        ' <td><input type="date"name="affectedDocuments[' + affectedDocIndex +
                        '][implimentationDate]"></td>' +
                        '<td><input type="text" name="affectedDocuments[' + affectedDocIndex +
                        '][newDocumentNumber]"></td>' +
                        '<td><input type="text" name="affectedDocuments[' + affectedDocIndex +
                        '][newVersionNumber]"></td>' +
                        '<td><button type="text" class="removeRowBtn">Remove</button></td>' +
                        '</tr>';
                    '</tr>';

                    docIndex++;
                    return html;
                }
                var tableBody = $('#affectedDocAddTable tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>

    <div id="rcms_form-head">
        <div class="container-fluid">
            <div class="inner-block">


                <div class="slogan">
                    <strong>Site Division / Project </strong>:
                    {{ Helpers::getDivisionName(session()->get('division')) }} / Sample Management I
                </div>
            </div>
        </div>
    </div>
    @php
        $users = DB::table('users')->get();
    @endphp
    <div id="change-control-fields">
        <div class="container-fluid">
            <div class="inner-block state-block">
                <div class="d-flex justify-content-between align-items-center">
                     

                    <script type="text/javascript">
                        function googleTranslateElementInit() {
                            new google.translate.TranslateElement({
                                pageLanguage: 'en',
                                includedLanguages: 'af,am,ar,az,be,bg,bn,bs,ca,ceb,co,cs,cy,da,de,el,en,eo,es,et,eu,fa,fi,fr,fy,ga,gd,gl,gu,ha,haw,he,hi,hmn,hr,ht,hu,hy,id,ig,is,it,ja,jw,ka,kk,km,kn,ko,ku,ky,la,lb,lo,lt,lv,mg,mi,mk,ml,mn,mr,ms,mt,my,ne,nl,no,ny,pa,pl,ps,pt,ro,ru,sd,si,sk,sl,sm,sn,so,sq,sr,st,su,sv,sw,ta,te,tg,th,tl,tr,uk,ur,uz,vi,xh,yi,yo,zh-CN,zh-TW,zu',
                                layout: google.translate.TranslateElement.InlineLayout.SIMPLE
                            }, 'google_translate_element');
                        }
                    </script>
                    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
                    </script> 
                </div>
            </div>


            <!-- Tab links -->
            <style>
                .btn-details {
                    display: none; /* Initially hide */
                }
                .btn-assay {
                    display: none; /* Initially hide */
                }
                .btn-dissolution {
                    display: none; /* Initially hide */
                }
            </style>

            <div class="cctab">
                {{-- <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Equipment Information</button> --}}
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Receipt of the Sample at IPC</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Receipt at Division</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Receipt by Sample Coordinator</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Allocation of Sample for Analysis</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Sample Analysis</button>
                <button class="cctablinks button1" style="display:none;" onclick="openCity(event, 'CCForm6')">Related Substance</button>
                <button class="cctablinks button2" style="display:none;" onclick="openCity(event, 'CCForm7')">Assay Analysis</button>
                <button class="cctablinks button3" style="display:none;" onclick="openCity(event, 'CCForm8')">Dissolution Analysis</button>
                {{-- <button class="cctablinks btn-details" onclick="openCity(event, 'CCForm6')">Details Standard Analysis</button>
                <button class="cctablinks btn-assay" onclick="openCity(event, 'CCForm7')">Assay Test Analysis</button>
                <button class="cctablinks btn-dissolution" onclick="openCity(event, 'CCForm8')">Dissolution Analysis</button> --}}
                <button class="cctablinks" onclick="openCity(event, 'CCForm9')">Review-1</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm10')">Review-2</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm11')">Approver</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm12')">Activity Log</button>
            </div>

            <div class="language-sleect d-flex" style="align-items: center; gap: 20px;">
                        <div>Select Language </div>
                        <div class="main-head" id="google_translate_element"></div>
                    </div>
            <form action="{{ route('receipt_store') }}" method="POST" enctype="multipart/form-data" id="sampleManagmentIForm">
                @csrf
                <!-- Tab content -->
                <div id="step-form">

                    @if (!empty($parent_id))
                        <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                        <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                    @endif

                    <div id="CCForm1" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>Record Number</b></label>
                                        <input readonly type="text" name="record_number"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}/IM/{{ date('Y') }}/{{ $record_number }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Division Code</b></label>
                                        <input disabled type="text" name="division_code"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                        <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator"><b>Initiator</b></label>
                                        <input disabled type="text" name="division_code"
                                            value="{{ Auth::user()->name }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input ">
                                        <label for="Date Due"><b>Date of Initiation</b></label>
                                        <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                        <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            Assigned To <span class="text-danger"></span>
                                        </label>
                                        <select id="assign_to" placeholder="Select..." name="assign_to">
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
                                        <label for="Due Date"> Due Date <span class="text-danger">*</span></label>
                                        <div class="calenderauditee">
                                            <input disabled type="text" id="due_date" readonly placeholder="DD-MMM-YYYY"
                                                required />
                                            <input type="date" name="due_date" required
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'due_date')" />
                                        </div>


                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span
                                                class="text-danger">*</span></label><span id="rchars"
                                            class="text-primary">255 </span><span class="text-primary"> characters
                                            remaining</span>
                                        <div class="relative-container">
                                            <input id="docname" type="text" name="short_description"
                                                maxlength="255" required>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Zone">Division<span class="text-danger">*</span></label>
                                        <select name="receipt_division" id="receipt_division" required>
                                            <option value="">--Select--</option>
                                            <option value="ARD">Analytical Research & Development Division</option>
                                            <option value="RSD">Reference Standard Division</option>
                                            <option value="MIC">Microbiology Division</option>
                                            <option value="BIO">Biologics Division</option>
                                            <option value="PVP">PvPI Division</option>
                                            <option value="QAL">Quality Assurance Division</option>
                                            <option value="MVP">MvPI Division</option>
                                            <option value="OTH">Others</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6"> 
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>Reception Diary Number</b></label>
                                        <input readonly type="text" id="record_number" name="record_number" 
                                            value="IPC/DIN/{{ date('Y') }}/{{ $record_number }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Zone">Mode of Receipt<span class="text-danger">*</span></label>
                                        <select name="mode_receipt" id="mode_receipt" required>
                                            <option value="">--Select--</option>
                                            <option value="Hand Delivery">Hand Delivery</option>
                                            <option value="Post">Post</option>
                                            <option value="Courier">Courier</option>
                                            <option value="Others">Others</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6" id="other_input_field" style="display: none;">
                                    <div class="group-input">
                                        <label for="other_mode">Others<span class="text-danger">*</span></label>
                                        <input type="text" name="other_mode" id="other_mode" placeholder="Enter details">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator">Initiator </label>
                                        <input disabled type="text" name="initiator_id"
                                            value="{{ Auth::user()->name }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Next Preventive Maintenance Date">Due Date</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="due_date" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" id="due_date_checkdate"
                                                name="due_date" class="hide-input"
                                                oninput="handleDateInput(this, 'due_date');checkDate('last_pm_date_checkdate','due_date_checkdate')" />
                                        </div>
                                    </div>
                                </div>
                                <!-- Additional input field for "Others" -->
                                
                                <script>
                                    document.getElementById("mode_receipt").addEventListener("change", function () {
                                        var otherInputField = document.getElementById("other_input_field");
                                        if (this.value === "Others") {
                                            otherInputField.style.display = "block";
                                            document.getElementById("other_mode").setAttribute("required", "required");
                                        } else {
                                            otherInputField.style.display = "none";
                                            document.getElementById("other_mode").removeAttribute("required");
                                        }
                                    });
                                
                                    // Trigger change event on page load to ensure correct state
                                    document.getElementById("mode_receipt").dispatchEvent(new Event("change"));
                                </script>
                                
                                <div class="col-lg-6">
                                    <div class="group-input ">
                                        <label for="Date Due"><b>Date</b></label>
                                        <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                        <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                    </div>
                                </div>
                               
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator Group">Department Group</label>
                                        <select name="initiator_Group" id="initiator_group">
                                            <option value="">-- Select --</option>
                                            <option value="CQA" @if (old('initiator_Group') == 'CQA') selected @endif>
                                                Corporate Quality Assurance</option>
                                            <option value="QAB" @if (old('initiator_Group') == 'QAB') selected @endif>
                                                Quality
                                                Assurance Biopharma</option>
                                            <option value="CQC" @if (old('initiator_Group') == 'CQC') selected @endif>
                                                Central
                                                Quality Control</option>
                                            <option value="MANU" @if (old('initiator_Group') == 'MANU') selected @endif>
                                                Manufacturing</option>
                                            <option value="PSG" @if (old('initiator_Group') == 'PSG') selected @endif>Plasma
                                                Sourcing Group</option>
                                            <option value="CS" @if (old('initiator_Group') == 'CS') selected @endif>
                                                Central
                                                Stores</option>
                                            <option value="ITG" @if (old('initiator_Group') == 'ITG') selected @endif>
                                                Information Technology Group</option>
                                            <option value="MM" @if (old('initiator_Group') == 'MM') selected @endif>
                                                Molecular Medicine</option>
                                            <option value="CL" @if (old('initiator_Group') == 'CL') selected @endif>
                                                Central
                                                Laboratory</option>
                                            <option value="TT" @if (old('initiator_Group') == 'TT') selected @endif>Tech
                                                Team</option>
                                            <option value="QA" @if (old('initiator_Group') == 'QA') selected @endif>
                                                Quality Assurance</option>
                                            <option value="QM" @if (old('initiator_Group') == 'QM') selected @endif>
                                                Quality Management</option>
                                            <option value="IA" @if (old('initiator_Group') == 'IA') selected @endif>IT
                                                Administration</option>
                                            <option value="ACC" @if (old('initiator_Group') == 'ACC') selected @endif>
                                                Accounting</option>
                                            <option value="LOG" @if (old('initiator_Group') == 'LOG') selected @endif>
                                                Logistics</option>
                                            <option value="SM" @if (old('initiator_Group') == 'SM') selected @endif>
                                                Senior Management</option>
                                            <option value="BA" @if (old('initiator_Group') == 'BA') selected @endif>
                                                Business Administration</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator Group Code">Department Group Code</label>
                                        <input type="text" name="initiator_group_code" id="initiator_group_code"
                                            value="" readonly >
                                    </div>
                                </div>
                                <script>
                                    document.getElementById('initiator_group').addEventListener('change', function() {
                                        var selectedValue = this.value;
                                        document.getElementById('initiator_group_code').value = selectedValue;
                                    });
                            
                                </script>
                               <div class="col-12">
                                    <div class="group-input">
                                        <label for="Received From">Received From<span class="text-danger">*</span></label>
                                        <span id="rchars1" class="text-primary">100</span>
                                        <span class="text-primary"> characters remaining</span>
                                        <div class="relative-container">
                                            <input required id="docename" type="text" name="received_from" maxlength="100">
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Received From">Brief Description of Sample<span class="text-danger">*</span></label>
                                        <span id="rchars" class="text-primary">500</span>
                                        <span class="text-primary"> characters remaining</span>
                                        <div class="relative-container">
                                            <textarea required  id="docname" type="text" name="brief_description" maxlength="500"></textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Next Preventive Maintenance Date">Date of Review</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="date_of_review" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" id="date_of_review_checkdate"
                                                name="date_of_review" class="hide-input"
                                                oninput="handleDateInput(this, 'date_of_review');checkDate('last_pm_date_checkdate','date_of_review_checkdate')" />
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Zone">Source of sample<span class="text-danger">*</span></label>
                                        <select name="source_of_sample" id="source_of_sample" onchange="showStakeholderFields()">
                                            <option value="">--Select--</option>
                                            <option value="Stakeholder">Stakeholder</option>
                                            <option value="Market Purchase">Market Purchase</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Div for Stakeholder Input Fields (hidden initially) -->
                                <div id="stakeholderFields" style="display: none;">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="stakeholder_email">Stakeholder's Email Address<span class="text-danger">*</span></label>
                                                <input required type="email" id="stakeholder_email" name="stakeholder_email" placeholder="Enter email" >
                                                <span id="email_error" style="color: red; display: none;">Please enter a valid email address.</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="stakeholder_contact">Stakeholder's Contact Number<span class="text-danger">*</span></label>
                                                <input required type="text" id="stakeholder_contact" name="stakeholder_contact" placeholder="Enter contact number" >
                                                <span id="contact_error" style="color: red; display: none;">Please enter a valid contact number (only digits, 10 characters).</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <script>
                                    function showStakeholderFields() {
                                        var sourceOfSample = document.getElementById("source_of_sample").value;
                                        var stakeholderFields = document.getElementById("stakeholderFields");
                                        
                                        if (sourceOfSample === "Stakeholder") {
                                            stakeholderFields.style.display = "block"; 
                                        } else {
                                            stakeholderFields.style.display = "none"; 
                                        }
                                    }
                                
                                    document.getElementById('stakeholder_email').addEventListener('input', function() {
                                        var email = this.value;
                                        var emailError = document.getElementById('email_error');
                                        
                                        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
                                        if (email && !emailPattern.test(email)) {
                                            emailError.style.display = "inline"; 
                                        } else {
                                            emailError.style.display = "none"; 
                                        }
                                    });
                                
                                    document.getElementById('stakeholder_contact').addEventListener('input', function() {
                                        var contactNumber = this.value;
                                        var contactError = document.getElementById('contact_error');
                                        
                                        var contactPattern = /^\d{10}$/;
                                        if (contactNumber && !contactPattern.test(contactNumber)) {
                                            contactError.style.display = "inline"; 
                                        } else {
                                            contactError.style.display = "none";
                                        }
                                    });
                                </script>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">Comment</label>
                                        <textarea class="tiny" name="Sample_at_ipc_Comment" id="Sample_at_ipc_Comment"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input" id="attachment_section">
                                        <label for="Certificate Analysis">Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or Attached
                                                File</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Sample_at_ipc_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="Sample_at_ipc_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Sample_at_ipc_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white"
                                        href="{{ url('rcms/qms-dashboard') }}">Exit</a> </button>
                            </div>
                        </div>
                    </div>


                    <div id="CCForm2" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Next Preventive Maintenance Date">Date Of Receipt</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="date_of_receipt" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" id="date_of_receipt_checkdate"
                                                name="date_of_receipt" class="hide-input"
                                                oninput="handleDateInput(this, 'date_of_receipt');checkDate('last_pm_date_checkdate','date_of_receipt_checkdate')" />
                                        </div>
                                    </div>
                                </div>  

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Reagent Code">Receptionist Diary Number</label>
                                        <input type="text" readonly name="receptionist_diary" id="receptionist_diary">
                                    </div>
                                </div>
                                
                                <script>
                                    document.addEventListener('DOMContentLoaded', () => {
                                        const receiptDivisionSelect = document.getElementById('receipt_division');
                                        const recordNumberInput = document.getElementById('record_number');
                                        const receptionistDiaryInput = document.getElementById('receptionist_diary');
                                        const sampleType = document.getElementById('sampleType');
                                
                                        function updateRecordNumber() {
                                            const selectedDivision = receiptDivisionSelect?.value || 'DIN';
                                            const currentYear = new Date().getFullYear();
                                            const recordNumber = '{{ $record_number }}';
                                            const newRecordNumber = `IPC/${selectedDivision}/${currentYear}/${recordNumber}`;
                                            if (recordNumberInput) {
                                                recordNumberInput.value = newRecordNumber;
                                            }
                                        }
                                
                                        function updateReceptionistDiary() {
                                            const selectedDivision = receiptDivisionSelect?.value || 'DIN';
                                            const selectedSampleType = sampleType.value || '';
                                            const currentYear = new Date().getFullYear();
                                            const recordNumber = '{{ $record_number }}';
                                            const newReceptionistDiary = `IPC/${selectedDivision}/${currentYear}/${selectedSampleType}${recordNumber}`;
                                            if (receptionistDiaryInput) {
                                                receptionistDiaryInput.value = newReceptionistDiary;
                                            }
                                        }
                                
                                        if (receiptDivisionSelect) {
                                            receiptDivisionSelect.addEventListener('change', () => {
                                                updateRecordNumber();
                                                updateReceptionistDiary();
                                            });
                                        }
                                
                                        if (sampleType) {
                                            sampleType.addEventListener('change', updateReceptionistDiary);
                                        }
                                
                                        updateRecordNumber();
                                        updateReceptionistDiary();
                                    });
                                </script>
                                
                                
                                
                                
                               
                               <div class="col-12"> 
                                    <div class="group-input">
                                        <label for="Corrective Action">Received From</label>
                                        <input type="text" name="received_from_1" id="received_from_1">
                                    </div>
                                </div>
                            
                            <script>
                                const receivedFromInput = document.getElementById('docename');
                                const receivedFrom1Input = document.getElementById('received_from_1');
                            
                                receivedFromInput.addEventListener('input', function() {
                                    receivedFrom1Input.value = receivedFromInput.value;
                                });
                            
                                document.addEventListener('DOMContentLoaded', function() {
                                    receivedFrom1Input.value = receivedFromInput.value;
                                });
                            </script>
                               <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">Brief Description of Sample</label>
                                        <textarea class="tiny" name="brief_description_of_sample_1" id="brief_description_of_sample_1"></textarea>
                                    </div>
                               </div>
                               <script>
                                    const briefDescriptionInput = document.getElementById('docname');
                                    const briefDescriptionTextarea = document.getElementById('brief_description_of_sample_1');
                                
                                    briefDescriptionInput.addEventListener('input', function() {
                                        briefDescriptionTextarea.value = briefDescriptionInput.value;
                                    });
                                
                                    document.addEventListener('DOMContentLoaded', function() {
                                        briefDescriptionTextarea.value = briefDescriptionInput.value;
                                    });
                               </script>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Zone">Sample type</label>
                                        <select name="sample_type" id="sampleType">
                                            <option value="">--Select--</option>
                                            <option value="N">New Drug Substance</option>
                                            <option value="I">Indian Pharmacopoeia Reference Standard</option>
                                            <option value="T">Proficiency Testing</option>
                                            <option value="C">Inter Laboratory Comparison</option>
                                            <option value="P">Phytopharmaceutical</option>
                                            <option value="M">Miscellaneous</option>
                                            <option value="0">Others</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-lg-6 other-sample-section" style="display: none;">
                                    <div class="group-input">
                                        <label for="other_sample_type">Others</label>
                                        <input type="text" class="other-sample-type" name="other_sample_type" placeholder="Enter details here..." />
                                    </div>
                                </div>
                                
                                <script>
                                    document.addEventListener("DOMContentLoaded", function () {
                                        const dropdown = document.querySelector(".sample-type");
                                        const otherSection = document.querySelector(".other-sample-section");
                                
                                        dropdown.addEventListener("change", function () {
                                            if (dropdown.value === "Others") {
                                                otherSection.style.display = "block";
                                            } else {
                                                otherSection.style.display = "none";
                                            }
                                        });
                                    });
                                </script>
                                
                                <div class="col-12">
                                    <div class="group-input" id="attachment_section">
                                        <label for="Certificate Analysis">Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or Attached
                                                File</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="attachment_receptionist"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="attachment_receptionist[]"
                                                    oninput="addMultipleFiles(this, 'attachment_receptionist')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>


                    <div id="CCForm3" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                          <div class="row">

                            
                            <div class="group-input">
                                <label style="display: flex; justify-content: space-between;" for="audit-agenda-grid">
                                   <div>
                                        Sample Coordinator
                                        <button type="button" name="audit-agenda-grid" id="ObservationAdd">+</button>
                                        <span class="text-primary" data-bs-toggle="modal"
                                            data-bs-target="#observation-field-instruction-modal"
                                            style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                            (Launch Instruction)
                                        </span>
                                   </div>
                                </label>                              
                                
                                <div class="table-responsive table-container">
                                    <table class="table table-bordered " id="job-responsibilty-table" style="width: 100%;" >
                                        <thead>                                            
                                            <tr style="background-color: #000; text-align: center;">
                                                <th style="border: 1px solid #000; padding: 8px;" ><div style="width: 30px;">Sr No.</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Assignment Of Date</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Analytical Receipt (AR) Number</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Sample Name</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Batch Number</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Sample Quantity</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Manufacturing Date</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Expiry Date</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Recommended Storage Conditions</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Physical Observation</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Remarks</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 100px;">Action</div></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           
                                        </tbody>
                                    </table>
                                </div>
                                <br>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">Sample Coordinator Comment</label>
                                        <textarea class="tiny" name="Sample_coordinator_Comment" id="Sample_coordinator_Comment"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input" id="attachment_section">
                                        <label for="Certificate Analysis">Sample Coordinator Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or Attached
                                                File</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Sample_coordinator_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="Sample_coordinator_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Sample_coordinator_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                  
                                <br>
                                <div class="button-block">
                                    <button type="submit" class="saveButton">Save</button>
                                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                    <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                    <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                            class="text-white">Exit</a></button>
                                </div>
                            </div>
                          </div>
                        </div>
                    </div>

                 
                    <script>
                        // Wait until the DOM content is fully loaded
                        document.addEventListener('DOMContentLoaded', function () {
                            // Get references to the input fields
                            const initialQtyInput = document.querySelector('input[name="sample_coordinator[0][initial_quality]"]');
                            const usedQtyInput = document.querySelector('input[name="sample_coordinator[0][used_quality]"]');
                            const transferQtyInput = document.querySelector('input[name="sample_coordinator[0][transfer_quality]"]');
                            const remainingQtyInput = document.querySelector('input[name="sample_coordinator[0][remaining_quality]"]');
                
                            // Function to calculate remaining quantity
                            function calculateRemainingQuantity() {
                                // Get the values from the input fields
                                const initialQty = parseFloat(initialQtyInput.value) || 0;
                                const usedQty = parseFloat(usedQtyInput.value) || 0;
                                const transferQty = parseFloat(transferQtyInput.value) || 0;
                
                                // Calculate the remaining quantity
                                const remainingQty = initialQty - (usedQty + transferQty);
                
                                // Update the remaining quantity field
                                remainingQtyInput.value = remainingQty >= 0 ? remainingQty : 0; // Ensure no negative values
                            }
                
                            // Add event listeners to input fields
                            initialQtyInput.addEventListener('input', calculateRemainingQuantity);
                            usedQtyInput.addEventListener('input', calculateRemainingQuantity);
                            transferQtyInput.addEventListener('input', calculateRemainingQuantity);
                        });
                    </script>
                    <!-- Water Consumption Detail ****************************-->
                    <div id="CCForm4" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                {{-- <div class="col-6">
                                    <div class="group-input">
                                        <label for="Type">Analysis Type</label>
                                        <select name="analysis_type" id="analysis_type" onchange="filterButtons()">
                                            <option value="">-- Select --</option>
                                            <option value="details">Details Analysis</option>
                                            <option value="assay">Assay Testing</option>
                                            <option value="dissolution">Dissolution Test</option>
                                        </select>
                                    </div>
                                </div> --}}
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="checklists">Analysis Type</label>
                                        <select multiple  id="analysis_type" class="abc" name="analysis_type[]">
                                            <option value="Details-Analysis">Related Substance</option>
                                            <option value="Assay-Testing">Assay Analysis</option>
                                            <option value="Dissolution-Test">Dissolution Analysis</option>
                                          </select>
                                    </div>
                                </div>
                                <script>
                                    const virtualSelectInstance = VirtualSelect.init({
                                                ele: '#analysis_type'
                                            });
                                
                                    document.querySelector('.abc').addEventListener('change', function() {
                                    const selectedOptions = $('#analysis_type').val();
                                    console.log(selectedOptions);
                                    console.log('selectedOptions', selectedOptions);
                                
                                
                                    const button1 = $('.button1')
                                    if (selectedOptions.includes('Details-Analysis')) {
                                        button1.show()
                                        console.log('Show button1');
                                    } else {
                                        button1.hide()
                                        console.log('Hide button1');
                                    }
                                
                                
                                    const button2 = $('.button2')
                                    if (selectedOptions.includes('Assay-Testing')) {
                                        button2.show()
                                        console.log('Show button2');
                                    } else {
                                        button2.hide()
                                        console.log('Hide button2');
                                    }
                                
                                
                                    const button3 = $('.button3');
                                    if (selectedOptions.includes('Dissolution-Test')) {
                                        button3.show()
                                        console.log('Show button3');
                                    } else {
                                        button3.hide()
                                        console.log('Hide button3');
                                    }
                                  });
                                
                                        function openCity(evt, cityName) {
                                            console.log('Open city:', cityName);
                                        }    
                               </script>
                            {{-- <script>
                                function filterButtons() {
                                    const selectedType = document.getElementById('analysis_type').value;
                        
                                    document.querySelector('.btn-details').style.display = (selectedType === 'details') ? 'inline-block' : 'none';
                                    document.querySelector('.btn-assay').style.display = (selectedType === 'assay') ? 'inline-block' : 'none';
                                    document.querySelector('.btn-dissolution').style.display = (selectedType === 'dissolution') ? 'inline-block' : 'none';
                                }
                        
                                function openCity(event, cityName) {
                                    alert(`Button clicked for: ${cityName}`);
                                }
                            </script>  --}}
                                
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="specifications">Selection of Specifications or Standard Test Protocols (STPs):</label>
                                        <select id="specifications" name="specifications" onchange="handleSpecificationChange(this.value)">
                                          <option value="">--Select--</option>
                                          <option value="Manufacturers Specifications">Manufacturers Specifications</option>
                                          <option value="British Pharmacopoeia (BP)">British Pharmacopoeia (BP)</option>
                                          <option value="European Pharmacopoeia (Ph. Eur.)">European Pharmacopoeia (Ph. Eur.)</option>
                                          <option value="United States Pharmacopeia (USP)">United States Pharmacopeia (USP)</option>
                                          <option value="Manufacturer’s STPs">Manufacturer’s STPs</option>
                                          <option value="Other Sources">Other Sources</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <div id="details_section" style="display:none; margin-top: 10px;">
                                            <label for="details">Details:</label>
                                            <textarea id="details" name="details" rows="4" cols="50" placeholder="Enter details here..."></textarea>
                                        </div>
                                    </div>
                                </div>
                                  
                                  <div class="col-12">
                                    <div class="group-input" id="attachment_section">
                                        <label for="Certificate Analysis">Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or Attached
                                                File</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="attachment_analysis"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="attachment_analysis[]"
                                                    oninput="addMultipleFiles(this, 'attachment_analysis')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                  
                                <script>
                                    function handleSpecificationChange(value) {
                                      const detailsSection = document.getElementById("details_section");
                                      const attachmentSection = document.getElementById("attachment_section");
                                      
                                      detailsSection.style.display = "none";
                                      attachmentSection.style.display = "none";
                                  
                                      if (value === "Manufacturer’s STPs" || value === "Other Sources") {
                                        detailsSection.style.display = "block";
                                        attachmentSection.style.display = "block";
                                      }
                                    }
                                </script>
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                        class="text-white">Exit</a></button>
                            </div>
                        </div>
                    </div>

                    <div id="CCForm5" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Zone">Acknowledgement</label>
                                        <select name="Acknowledgement" id="Acknowledgement">
                                            <option value="">--Select--</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Zone">MOA Change Needed</label>
                                        <select name="moa_change_needed" id="moa_change_needed">
                                            <option value="">--Select--</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12" id="moa_change_details_container" style="display: none;">
                                    <div class="group-input">
                                        <label for="Description">MOA Change Details</label>
                                        <textarea class="tiny" name="moa_change_details" id="moa_change_details"></textarea>
                                    </div>
                                </div>
                                
                                <script>
                                    document.addEventListener("DOMContentLoaded", function () {
                                        const moaChangeNeeded = document.getElementById("moa_change_needed");
                                        const moaChangeDetailsContainer = document.getElementById("moa_change_details_container");
                                
                                        moaChangeNeeded.addEventListener("change", function () {
                                            if (this.value === "Yes") {
                                                moaChangeDetailsContainer.style.display = "block";
                                            } else {
                                                moaChangeDetailsContainer.style.display = "none";
                                            }
                                        });
                                    });
                                </script>
                                
                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Next Preventive Maintenance Date">Analysis Start Date</label>
                                        <input type="text" name="analysis_start_date" id="analysis_start_date" class="datetimepicker" placeholder="Select Date and Time">
                                    </div>
                                </div>
                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Next Preventive Maintenance Date">Analysis End Date</label>
                                        <input type="text" name="analysis_end_date" id="analysis_end_date" class="datetimepicker" placeholder="Select Date and Time">
                                    </div>
                                </div>
                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Next Preventive Maintenance Date">Turn Around Time (TAT)</label>
                                        <input type="text" name="turn_around_time" id="turn_around_time" readonly placeholder="Turn Around Time">
                                    </div>
                                </div>
                              
                                @php
                                    $division = DB::table('q_m_s_divisions')
                                        ->where('name', Helpers::getDivisionName(session()->get('division')))
                                        ->first();
                                    $userRoles = DB::table('user_roles')
                                        ->where([
                                            'q_m_s_roles_id' => 4,
                                            'q_m_s_divisions_id' => $division->id,
                                        ])
                                        ->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $Review1 = DB::table('users')->whereIn('id', $userRoleIds)->get();
                                @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="hod_person">Reviewer-1</label>
                                        <select multiple name="review_1_person[]" id="review_1_person">
                                            <option value="">Select Reviewer</option>
                                            @if ($Review1)
                                                @foreach ($Review1 as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="hod_person">Reviewer-2</label>
                                        <select multiple name="review_2_person[]" id="review_2_person">
                                            <option value="">Select Reviewer</option>
                                            @if ($Review1)
                                                @foreach ($Review1 as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="hod_person">Approver</label>
                                        <select multiple name="approver_person[]" id="approver_person">
                                            <option value="">Select Approver</option>
                                            @if ($Review1)
                                                @foreach ($Review1 as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <!-- Include Flatpickr CSS and JS -->
                                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
                                <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
                                
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        // Initialize Flatpickr
                                        flatpickr(".datetimepicker", {
                                            enableTime: true,
                                            dateFormat: "d-M-Y H:i",
                                            time_24hr: true,
                                            onChange: calculateTAT // Call calculateTAT on change
                                        });
                                
                                        // Function to calculate Turn Around Time (TAT)
                                        function calculateTAT() {
                                            const startDate = document.getElementById("analysis_start_date").value;
                                            const endDate = document.getElementById("analysis_end_date").value;
                                
                                            if (startDate && endDate) {
                                                const start = new Date(startDate);
                                                const end = new Date(endDate);
                                
                                                // Calculate difference in milliseconds
                                                const diffMs = end - start;
                                
                                                if (diffMs >= 0) {
                                                    // Convert difference to days, hours, minutes
                                                    const days = Math.floor(diffMs / (1000 * 60 * 60 * 24));
                                                    const hours = Math.floor((diffMs % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                    const minutes = Math.floor((diffMs % (1000 * 60 * 60)) / (1000 * 60));
                                
                                                    // Set the TAT value
                                                    document.getElementById("turn_around_time").value = `${days}d ${hours}h ${minutes}m`;
                                                } else {
                                                    alert("End date must be after the start date!");
                                                    document.getElementById("turn_around_time").value = "";
                                                }
                                            }
                                        }
                                
                                        // Attach event listeners to inputs
                                        document.getElementById("analysis_start_date").addEventListener("change", calculateTAT);
                                        document.getElementById("analysis_end_date").addEventListener("change", calculateTAT);
                                    });
                                </script>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">Sample Analysis Comment</label>
                                        <textarea class="tiny" name="sample_analysis_Comment" id="sample_analysis_Comment"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input" id="attachment_section">
                                        <label for="Certificate Analysis">Sample Analysis Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or Attached
                                                File</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="sample_analysis_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="sample_analysis_attachment[]"
                                                    oninput="addMultipleFiles(this, 'sample_analysis_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white"
                                        href="{{ url('rcms/qms-dashboard') }}">Exit</a> </button>
                            </div>
                        </div>
                    </div>
                    </div>



                    <!-- Emission to Water ****************************-->
                    <div id="CCForm6" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                {{-- <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>Division</b></label>
                                        <input  type="text" name="Division"  
                                        value="">
                                        </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator">Title </label>
                                        <input  type="text" name="title"
                                            value="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Due">Date</label>
                                        <input  type="text" value="{{ date('d-M-Y') }}" name="date">
                                        <input type="hidden" value="{{ date('Y-m-d') }}" name="date">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Due">Objective</label>
                                        <input  type="text" value="" name="objective">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator">Background </label>
                                        <input  type="text" name="background"
                                            value="">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Initiator">Method </label>
                                        <input  type="text" name="method"
                                            value="">
                                    </div>
                                </div> --}}


                              


                                

                                <div class="col-12 sub-head">
                                    Details of Standards and Samples:
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Material Details">
                                            Details of Standards and Samples:
                                            <button type="button" name="ann" id="addDetails_Standards">+</button>
                                        </label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="Details_Standards" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Row #</th>
                                                        <th>Reg. No.</th>
                                                        <th>Date</th>
                                                        <th>Name of Standards/Samples</th>
                                                        <th>Qty.</th>
                                                        <th>Batch No./Company Name</th>
                                                        <th>Mfg. Date</th>
                                                        <th>Exp. Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Initial Row Placeholder -->
                                                    <tr>
                                                        <td><input disabled type="text"
                                                                name="standards_samples_details[0][row]" value="1">
                                                        </td>
                                                        <td><input type="text"
                                                                name="standards_samples_details[0][reg_no]"></td>
                                                        <td><input type="date" name="standards_samples_details[0][date]">
                                                        </td>
                                                        <td><input type="text" name="standards_samples_details[0][name]">
                                                        </td>
                                                        <td><input type="number" name="standards_samples_details[0][qty]">
                                                        </td>
                                                        <td><input type="text"
                                                                name="standards_samples_details[0][batch_company]"></td>
                                                        <td><input type="date"
                                                                name="standards_samples_details[0][mfg_date]"></td>
                                                        <td><input type="date"
                                                                name="standards_samples_details[0][exp_date]"></td>
                                                        <td><button type="button" class="removeRowBtn">Remove</button></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    $(document).ready(function() {
                                        // Add new row in Details of Standards and Samples table
                                        $('#addDetails_Standards').click(function(e) {
                                            e.preventDefault();

                                            function generateStandardsSamplesTableRow(serialNumber) {
                                                var html =
                                                    '<tr>' +
                                                    '<td><input disabled type="text" name="standards_samples_details[' + serialNumber +
                                                    '][row]" value="' + (serialNumber + 1) + '"></td>' +
                                                    '<td><input type="text" name="standards_samples_details[' + serialNumber +
                                                    '][reg_no]"></td>' +
                                                    '<td><input type="date" name="standards_samples_details[' + serialNumber +
                                                    '][date]"></td>' +
                                                    '<td><input type="text" name="standards_samples_details[' + serialNumber +
                                                    '][name]"></td>' +
                                                    '<td><input type="number" name="standards_samples_details[' + serialNumber +
                                                    '][qty]"></td>' +
                                                    '<td><input type="text" name="standards_samples_details[' + serialNumber +
                                                    '][batch_company]"></td>' +
                                                    '<td><input type="date" name="standards_samples_details[' + serialNumber +
                                                    '][mfg_date]"></td>' +
                                                    '<td><input type="date" name="standards_samples_details[' + serialNumber +
                                                    '][exp_date]"></td>' +
                                                    '<td><button type="button" class="removeRowBtn">Remove</button></td>' +
                                                    '</tr>';
                                                return html;
                                            }

                                            var tableBody = $('#Details_Standards tbody');
                                            var rowCount = tableBody.children('tr').length;
                                            var newRow = generateStandardsSamplesTableRow(rowCount);
                                            tableBody.append(newRow);
                                        });

                                        // Remove row in Details of Standards and Samples table
                                        $(document).on('click', '.removeRowBtn', function() {
                                            $(this).closest('tr').remove();
                                        });
                                    });
                                </script>
                                <div class="col-12 sub-head">
                                    Details of Chemicals and Reagents:
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Material Details">
                                            Details of Chemicals and Reagents:
                                            <button type="button" name="ann" id="addDetails_Chemicals">+</button>
                                        </label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="Details_Chemicals" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Row #</th>
                                                        <th>Name of Chemicals/ Reagents</th>
                                                        <th>Make</th>
                                                        <th>Batch No./ LotNo.</th>
                                                        <th>Mfg.Date.</th>
                                                        <th>Exp.Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Initial Row Placeholder -->
                                                    <tr>
                                                        <td><input disabled type="text" name="chemicals_reagents_details[0][row]" value="1"></td>
                                                        <td>
                                                            <select name="chemicals_reagents_details[0][name]">
                                                                <option value="">Select</option>
                                                                <option value="Potassium Hydrogen Phosphate">Potassium Hydrogen Phosphate</option>
                                                                <option value="Potassium Hydroxide">Potassium Hydroxide</option>
                                                                <option value="Acetonitrile">Acetonitrile</option>
                                                                <option value="Water">Water</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="text" name="chemicals_reagents_details[0][make]"></td>
                                                        <td><input type="text" name="chemicals_reagents_details[0][batch_lot_no]"></td>
                                                        <td><input type="date" name="chemicals_reagents_details[0][mfg_date]"></td>
                                                        <td><input type="date" name="chemicals_reagents_details[0][exp_date]"></td>
                                                        <td><button type="button" class="removeRowBtn">Remove</button></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        // Add new row in Details of Chemicals and Reagents table
                                        $('#addDetails_Chemicals').click(function(e) {
                                            e.preventDefault();
                                
                                            function generateChemicalsReagentsTableRow(serialNumber) {
                                                var html =
                                                    '<tr>' +
                                                    '<td><input disabled type="text" name="chemicals_reagents_details[' + serialNumber +
                                                    '][row]" value="' + (serialNumber + 1) + '"></td>' +
                                                    '<td>' +
                                                    '<select name="chemicals_reagents_details[' + serialNumber + '][name]">' +
                                                    '<option value="">Select</option>' +
                                                    '<option value="Potassium Hydrogen Phosphate">Potassium Hydrogen Phosphate</option>' +
                                                    '<option value="Potassium Hydroxide">Potassium Hydroxide</option>' +
                                                    '<option value="Acetonitrile">Acetonitrile</option>' +
                                                    '<option value="Water">Water</option>' +
                                                    '</select>' +
                                                    '</td>' +
                                                    '<td><input type="text" name="chemicals_reagents_details[' + serialNumber + '][make]"></td>' +
                                                    '<td><input type="text" name="chemicals_reagents_details[' + serialNumber + '][batch_lot_no]"></td>' +
                                                    '<td><input type="date" name="chemicals_reagents_details[' + serialNumber + '][mfg_date]"></td>' +
                                                    '<td><input type="date" name="chemicals_reagents_details[' + serialNumber + '][exp_date]"></td>' +
                                                    '<td><button type="button" class="removeRowBtn">Remove</button></td>' +
                                                    '</tr>';
                                                return html;
                                            }
                                
                                            var tableBody = $('#Details_Chemicals tbody');
                                            var rowCount = tableBody.children('tr').length;
                                            var newRow = generateChemicalsReagentsTableRow(rowCount);
                                            tableBody.append(newRow);
                                        });
                                
                                        // Remove row in Details of Chemicals and Reagents table
                                        $(document).on('click', '.removeRowBtn', function() {
                                            $(this).closest('tr').remove();
                                        });
                                    });
                                </script>
                                

                                <div class="col-12 sub-head">
                                    Details of Instruments Used:
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Material Details">
                                            Details of Instruments Used:
                                            <button type="button" name="ann" id="addDetails_Instruments">+</button>
                                        </label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="Details_Instruments"
                                                style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Row #</th>
                                                        <th>Name of Instrument</th>
                                                        <th>Instrument ID</th>
                                                        <th>Calibration On</th>
                                                        <th>Calibration Due</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Initial Row Placeholder -->
                                                    <tr>
                                                        <td><input disabled type="text"
                                                                name="instruments_used_details[0][row]" value="1">
                                                        </td>
                                                        <td><input type="text"
                                                                name="instruments_used_details[0][name]"></td>
                                                        <td><input type="text" name="instruments_used_details[0][id]">
                                                        </td>
                                                        <td><input type="date"
                                                                name="instruments_used_details[0][calibration_on]"></td>
                                                        <td><input type="date"
                                                                name="instruments_used_details[0][calibration_due]"></td>
                                                        <td><button type="button" class="removeRowBtn">Remove</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        // Add new row in Details of Instruments Used table
                                        $('#addDetails_Instruments').click(function(e) {
                                            e.preventDefault();

                                            function generateInstrumentsTableRow(serialNumber) {
                                                var html =
                                                    '<tr>' +
                                                    '<td><input disabled type="text" name="instruments_used_details[' + serialNumber +
                                                    '][row]" value="' + (serialNumber + 1) + '"></td>' +
                                                    '<td><input type="text" name="instruments_used_details[' + serialNumber +
                                                    '][name]"></td>' +
                                                    '<td><input type="text" name="instruments_used_details[' + serialNumber +
                                                    '][id]"></td>' +
                                                    '<td><input type="date" name="instruments_used_details[' + serialNumber +
                                                    '][calibration_on]"></td>' +
                                                    '<td><input type="date" name="instruments_used_details[' + serialNumber +
                                                    '][calibration_due]"></td>' +
                                                    '<td><button type="button" class="removeRowBtn">Remove</button></td>' +
                                                    '</tr>';
                                                return html;
                                            }

                                            var tableBody = $('#Details_Instruments tbody');
                                            var rowCount = tableBody.children('tr').length;
                                            var newRow = generateInstrumentsTableRow(rowCount);
                                            tableBody.append(newRow);
                                        });

                                        // Remove row in Details of Instruments Used table
                                        $(document).on('click', '.removeRowBtn', function() {
                                            $(this).closest('tr').remove();
                                        });
                                    });
                                </script>

                                <div class="col-12 sub-head">
                                    Related Substances Test Results:
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Material Details">
                                            Related Substances Test Results:
                                            <button type="button" name="ann"
                                                id="addDetails_RelatedSubstances">+</button>
                                        </label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="Details_RelatedSubstances"
                                                style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Row #</th>
                                                        <th>Sample Name/Batch No</th>
                                                        <th>Relative Retention Time</th>
                                                        <th>Name of Impurities</th>
                                                        <th>Result (%)</th>
                                                        <th>Limit (%)</th>
                                                        <th>Remarks</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Initial Row Placeholder -->
                                                    <tr>
                                                        <td><input disabled type="text"
                                                                name="related_substances_test_details[0][row]"
                                                                value="1"></td>
                                                        <td><input type="text"
                                                                name="related_substances_test_details[0][sample_name]">
                                                        </td>
                                                        <td><input type="text"
                                                                name="related_substances_test_details[0][relative_retention_time]">
                                                        </td>
                                                        <td><input type="text"
                                                                name="related_substances_test_details[0][impurities]"></td>
                                                        <td><input type="number"
                                                                name="related_substances_test_details[0][result]"></td>
                                                        <td><input type="number"
                                                                name="related_substances_test_details[0][limit]"></td>
                                                        <td><input type="text"
                                                                name="related_substances_test_details[0][remarks]"></td>
                                                        <td><button type="button" class="removeRowBtn">Remove</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        // Add new row in Related Substances Test Results table
                                        $('#addDetails_RelatedSubstances').click(function(e) {
                                            e.preventDefault();

                                            function generateRelatedSubstancesTableRow(serialNumber) {
                                                var html =
                                                    '<tr>' +
                                                    '<td><input disabled type="text" name="related_substances_test_details[' +
                                                    serialNumber + '][row]" value="' + (serialNumber + 1) + '"></td>' +
                                                    '<td><input type="text" name="related_substances_test_details[' + serialNumber +
                                                    '][sample_name]"></td>' +
                                                    '<td><input type="text" name="related_substances_test_details[' + serialNumber +
                                                    '][relative_retention_time]"></td>' +
                                                    '<td><input type="text" name="related_substances_test_details[' + serialNumber +
                                                    '][impurities]"></td>' +
                                                    '<td><input type="number" name="related_substances_test_details[' + serialNumber +
                                                    '][result]"></td>' +
                                                    '<td><input type="number" name="related_substances_test_details[' + serialNumber +
                                                    '][limit]"></td>' +
                                                    '<td><input type="text" name="related_substances_test_details[' + serialNumber +
                                                    '][remarks]"></td>' +
                                                    '<td><button type="button" class="removeRowBtn">Remove</button></td>' +
                                                    '</tr>';
                                                return html;
                                            }

                                            var tableBody = $('#Details_RelatedSubstances tbody');
                                            var rowCount = tableBody.children('tr').length;
                                            var newRow = generateRelatedSubstancesTableRow(rowCount);
                                            tableBody.append(newRow);
                                        });

                                        // Remove row in Related Substances Test Results table
                                        $(document).on('click', '.removeRowBtn', function() {
                                            $(this).closest('tr').remove();
                                        });
                                    });
                                </script>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">Related Substance Comment</label>
                                        <textarea class="tiny" name="related_substance_Comment" id="related_substance_Comment"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input" id="attachment_section">
                                        <label for="Certificate Analysis">Related Substance Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or Attached
                                                File</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="related_substance_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="related_substance_attachment[]"
                                                    oninput="addMultipleFiles(this, 'related_substance_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                        class="text-white">Exit</a></button>
                            </div>
                        </div>
                    </div>

                    <!-- Emission to Air ****************************-->
                    <div id="CCForm7" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                {{-- <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Objective </label>
                                        <input id="" type="text" name="objective_assay">
                                    </div>
                                </div>  

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Background </label>
                                        <input id="" type="text" name="background_assay">
                                    </div>
                                </div>
                               
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Short Description"> Method:</label>
                                        <input id="" type="text" name="method_assay">
                                    </div>
                                </div> --}}


                                <div class="col-12">
                                <div class="group-input">
                                    <label for="root_cause">
                                    Details of Standards and Samples
                                        <button type="button" id="promate_add">+</button>
                                        <span class="text-primary" data-bs-toggle="modal" data-bs-target="#document-details-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                            (Launch Instruction)
                                        </span>
                                    </label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="prod_mate_details" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 100px;">Row #</th>
                                                    <th>Reg. No.</th>
                                                    <th>Date</th>
                                                    <th>Name of Standards/Samples</th>
                                                    <th>Received From</th>
                                                    <th>Qty.</th>
                                                    <th>Batch No./Company Name</th>
                                                    <th>Mfg. Date</th>
                                                    <th>Exp. Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input disabled type="text" name="Product_Material[0][serial]" value="1"></td>
                                                    <td><input type="text" name="Product_Material[0][product_name_ca]"></td>
                                                    <td><input type="date" name="Product_Material[0][batch_no_pmd_ca]"></td>
                                                    <td><input type="text" name="Product_Material[0][batch_size_pmd_ca]"></td>
                                                    <td><input type="text" name="Product_Material[0][pack_profile_pmd_ca]"></td>
                                                    <td><input type="text" name="Product_Material[0][released_quantity_pmd_ca]"></td>
                                                    <td><input type="text" name="Product_Material[0][remarks_ca]"></td>
                                                    <td><input type="date" name="Product_Material[0][mfg_date_pmd_ca]"></td>
                                                    <td><input type="date" name="Product_Material[0][expiry_date_pmd_ca]"></td>
                                                    <td><button type="button" class="removeRowBtn">Remove</button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            <script>
                                $(document).ready(function() {
                                    $('#promate_add').click(function(e) {
                                        e.preventDefault();
                            
                                        function generateTableRow(productserialno) {
                                            var html =
                                                '<tr>' +
                                                '<td><input disabled type="text" name="Product_Material[' + productserialno + '][serial]" value="' + (productserialno + 1) + '"></td>' +
                                                '<td><input type="text" name="Product_Material[' + productserialno + '][product_name_ca]"></td>' +
                                                '<td><input type="date" name="Product_Material[' + productserialno +
                                                '][batch_no_pmd_ca]"></td>' +
                                                '<td><input type="text" name="Product_Material[' + productserialno + '][batch_size_pmd_ca]"></td>' +
                                                '<td><input type="text" name="Product_Material[' + productserialno + '][pack_profile_pmd_ca]"></td>' +
                                                '<td><input type="text" name="Product_Material[' + productserialno + '][released_quantity_pmd_ca]"></td>' +
                                                '<td><input type="text" name="Product_Material[' + productserialno + '][remarks_ca]"></td>' +
                                                '<td><input type="date" name="Product_Material[' + productserialno +
                                                '][mfg_date_pmd_ca]"></td>' +
                                                '<td><input type="date" name="Product_Material[' + productserialno +
                                                '][expiry_date_pmd_ca]"></td>' +
                                                '<td><button type="button" class="removeRowBtn">Remove</button></td>' +
                                                '</tr>';
                                            return html;
                                        }
                            
                                        var tableBody = $('#prod_mate_details tbody');
                                        var rowCount = tableBody.children('tr').length;
                                        var newRow = generateTableRow(rowCount);
                                        tableBody.append(newRow);
                                    });
                            
                                    $(document).on('click', '.removeRowBtn', function() {
                                        $(this).closest('tr').remove();
                                    });
                                });
                            </script>

                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="root_cause">
                                            Details of Chemicals and Reagents:
                                                <button type="button" id="add_report_approval_row">+</button>
                                                <span class="text-primary" data-bs-toggle="modal"
                                                    data-bs-target="#document-details-field-instruction-modal"
                                                    style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                    (Launch Instruction)
                                                </span>
                                            </label>
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="report_approval_table">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 100px;">Row #</th>
                                                            <th>Name of Chemicals/ Reagents</th>
                                                            <th>Make</th>
                                                            <th>Batch No./ Lot No.</th>
                                                            <th>Mfg.Date</th>
                                                            <th>Exp.Date</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><input disabled type="text" name="Report_Approval[0][serial]" value="1"></td>
                                                            <td><input type="text" name="Report_Approval[0][names_rrv]"></td>
                                                            <td><input type="text" name="Report_Approval[0][department_rrv]"></td>
                                                            <td><input type="text" name="Report_Approval[0][sign_rrv]"></td>
                                                            <td><input type="date" name="Report_Approval[0][mfg_date_pmd]">
                                                            </td>
                                                            <td><input type="date" name="Report_Approval[0][expiry_date_pmd]">
                                                            </td>
                                                            <td><button type="button" class="removeRowBtn">Remove</button></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        $(document).on('click', '.removeRowBtn', function() {
                                            $(this).closest('tr').remove();
                                        });

                                        $(document).ready(function() {
                                            $('#add_report_approval_row').click(function(e) {
                                                e.preventDefault();

                                                function generateTableRow(reportNumber) {
                                                    var html =
                                                        '<tr>' +
                                                        '<td><input disabled type="text" name="Report_Approval[' + reportNumber + '][serial]" value="' + (reportNumber + 1) + '"></td>' +
                                                        '<td><input type="text" name="Report_Approval[' + reportNumber + '][names_rrv]"></td>' +
                                                        '<td><input type="text" name="Report_Approval[' + reportNumber + '][department_rrv]"></td>' +
                                                        '<td><input type="text" name="Report_Approval[' + reportNumber + '][sign_rrv]"></td>' +
                                                        '<td><input type="date" name="Report_Approval[' + reportNumber +
                                                        '][mfg_date_pmd]"></td>' +
                                                        '<td><input type="date" name="Report_Approval[' + reportNumber +
                                                        '][expiry_date_pmd]"></td>' +
                                                        '<td><button type="button" class="removeRowBtn">Remove</button></td>' +
                                                        '</tr>';
                                                    return html;
                                                }

                                                var tableBody = $('#report_approval_table tbody');
                                                var rowCount = tableBody.children('tr').length;
                                                var newRow = generateTableRow(rowCount);
                                                tableBody.append(newRow);
                                            });
                                        });
                                    </script>



                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="root_cause">
                                            Details of Instruments Used:
                                                <button type="button" id="add_report_instruments">+</button>
                                                <span class="text-primary" data-bs-toggle="modal"
                                                    data-bs-target="#document-details-field-instruction-modal"
                                                    style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                    (Launch Instruction)
                                                </span>
                                            </label>
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="report_instrument_approval_table">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 100px;">Row #</th>
                                                            <th>Name of Instrument</th>
                                                            <th>Instrument ID</th>
                                                            <th>Calibration On</th>
                                                            <th>Calibration Due</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><input disabled type="text" name="Details_Instruments[0][serial]" value="1"></td>
                                                            <td><input type="text" name="Details_Instruments[0][names_instrument]"></td>
                                                            <td><input type="text" name="Details_Instruments[0][instrument_id]"></td>

                                                            <td><input type="date" name="Details_Instruments[0][callobration_on_date]">
                                                            </td>
                                                            <td><input type="date" name="Details_Instruments[0][callobration_due_date]">
                                                            </td>

                                                            <td><button type="button" class="removeRowBtn">Remove</button></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        $(document).on('click', '.removeRowBtn', function() {
                                            $(this).closest('tr').remove();
                                        });

                                        $(document).ready(function() {
                                            $('#add_report_instruments').click(function(e) {
                                                e.preventDefault();

                                                function generateTableRow(instrumentNumber) {
                                                    var html =
                                                        '<tr>' +
                                                        '<td><input disabled type="text" name="Details_Instruments[' + instrumentNumber + '][serial]" value="' + (instrumentNumber + 1) + '"></td>' +
                                                        '<td><input type="text" name="Details_Instruments[' + instrumentNumber + '][names_instrument]"></td>' +
                                                        '<td><input type="text" name="Details_Instruments[' + instrumentNumber + '][instrument_id]"></td>' +
                                                        '<td><input type="date" name="Details_Instruments[' + instrumentNumber +
                                                        '][callobration_on_date]"></td>' +
                                                        '<td><input type="date" name="Details_Instruments[' + instrumentNumber +
                                                        '][callobration_due_date]"></td>' +
                                                        '<td><button type="button" class="removeRowBtn">Remove</button></td>' +
                                                        '</tr>';
                                                    return html;
                                                }

                                                var tableBody = $('#report_instrument_approval_table tbody');
                                                var rowCount = tableBody.children('tr').length;
                                                var newRow = generateTableRow(rowCount);
                                                tableBody.append(newRow);
                                            });
                                        });
                                    </script>

                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="root_cause">
                                                Assay Test Results:
                                                <button type="button" id="add_assay_test_result">+</button>
                                                <span class="text-primary" data-bs-toggle="modal"
                                                    data-bs-target="#document-details-field-instruction-modal"
                                                    style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                    (Launch Instruction)
                                                </span>
                                            </label>
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="report_assay_test_table">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 100px;">Row #</th>
                                                            <th>Name of Sample</th>
                                                            <th>Result (%)</th>
                                                            <th>Limit (%)</th>
                                                            <th>Remarks</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><input disabled type="text" name="Assay_Test[0][serial]" value="1"></td>
                                                            <td><input type="text" name="Assay_Test[0][names_of_sample]"></td>
                                                            <td><input type="text" name="Assay_Test[0][result]"></td>
                                                            <td><input type="text" name="Assay_Test[0][limit]"></td>
                                                            <td><input type="text" name="Assay_Test[0][remarks]"></td>
                                                            <td><button type="button" class="removeRowBtn">Remove</button></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        $(document).on('click', '.removeRowBtn', function() {
                                            $(this).closest('tr').remove();
                                        });

                                        $(document).ready(function() {
                                            $('#add_assay_test_result').click(function(e) {
                                                e.preventDefault();

                                                function generateTableRow(assayNumber) {
                                                    var html =
                                                        '<tr>' +
                                                        '<td><input disabled type="text" name="Assay_Test[' + assayNumber + '][serial]" value="' + (assayNumber + 1) + '"></td>' +
                                                        '<td><input type="text" name="Assay_Test[' + assayNumber + '][names_of_sample]"></td>' +
                                                        '<td><input type="text" name="Assay_Test[' + assayNumber + '][result]"></td>' +
                                                        '<td><input type="text" name="Assay_Test[' + assayNumber + '][limit]"></td>' +    
                                                        '<td><input type="text" name="Assay_Test[' + assayNumber + '][remarks]"></td>' +
                                                        '<td><button type="button" class="removeRowBtn">Remove</button></td>' +
                                                        '</tr>';
                                                    return html;
                                                }

                                                var tableBody = $('#report_assay_test_table tbody');
                                                var rowCount = tableBody.children('tr').length;
                                                var newRow = generateTableRow(rowCount);
                                                tableBody.append(newRow);
                                            });
                                        });
                                    </script>


                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Conclusion: </label>
                                        <textarea class="tiny" id="" type="text" name="conclusion_assay"></textarea>
                                    </div>
                                </div> 

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">Assay Analysis Comment</label>
                                        <textarea class="tiny" name="assay_analysis_Comment" id="assay_analysis_Comment"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input" id="attachment_section">
                                        <label for="Certificate Analysis">Assay Analysis Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or Attached
                                                File</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="assay_analysis_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="assay_analysis_attachment[]"
                                                    oninput="addMultipleFiles(this, 'assay_analysis_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>    
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                        class="text-white">Exit</a></button>
                            </div>
                        </div>
                    </div>

                    <!-- Chemical Waste ****************************-->
                    <div id="CCForm8" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                {{-- <div class="col-12">
                                    <div class="group-input">
                                        <label for="due-dateextension">Objective:</label>
                                        <input type="text" name="objective_dissolution">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="due-dateextension">Background:</label>
                                        <input type="text" name="background_dissolution">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="due-dateextension">Method:</label>
                                        <input type="text" name="method_dissolution">
                                    </div>
                                </div> --}}

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="root_cause">
                                            Details of Standards and Samples:
                                            <button type="button" id="promate_addd">+</button>
                                            <span class="text-primary" data-bs-toggle="modal" data-bs-target="#document-details-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="prod_mate_detailsss" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 100px;">S.No.</th>
                                                        <th>Reg. No.</th>
                                                        <th>Date</th>
                                                        <th>Name of Standards/Samples</th>
                                                        <th>Received From</th>
                                                        <th>Qty.</th>
                                                        <th>Batch No./ Company Name</th>
                                                        <th>Mfg. Date</th>
                                                        <th>Exp. Date</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><input disabled type="text" name="Product_MaterialDetails[0][serial]" value="1"></td>
                                                        <td><input type="text" name="Product_MaterialDetails[0][product_name_ca]"></td>
                                                        <td><input type="date" name="Product_MaterialDetails[0][batch_no_pmd_ca]"></td>
                                                        <td><input type="text" name="Product_MaterialDetails[0][batch_size_pmd_ca]"></td>
                                                        <td><input type="text" name="Product_MaterialDetails[0][pack_profile_pmd_ca]"></td>
                                                        <td><input type="text" name="Product_MaterialDetails[0][released_quantity_pmd_ca]"></td>
                                                        <td><input type="text" name="Product_MaterialDetails[0][remarks_ca]"></td>
                                                        <td><input type="date" name="Product_MaterialDetails[0][mfg_date_pmd_ca]"></td>
                                                        <td><input type="date" name="Product_MaterialDetails[0][expiry_date_pmd_ca]"></td>
                                                        <td><button type="button" class="removeRowBtn">Remove</button></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    $(document).ready(function () {
                                    $('#promate_addd').click(function (e) {
                                        e.preventDefault();

                                        // Function to generate a new row with the given serial number
                                        function generateTableRow(productserialno) {
                                            var today = new Date().toISOString().split('T')[0]; // Get current date in YYYY-MM-DD format
                                            return `
                                                <tr>
                                                    <td><input disabled type="text" name="Product_MaterialDetails[${productserialno}][serial]" value="${productserialno + 1}"></td>
                                                    <td><input type="text" name="Product_MaterialDetails[${productserialno}][product_name_ca]"></td>
                                                    <td><input type="date" name="Product_MaterialDetails[${productserialno}][batch_no_pmd_ca]"></td>
                                                    <td><input type="text" name="Product_MaterialDetails[${productserialno}][batch_size_pmd_ca]"></td>
                                                    <td><input type="text" name="Product_MaterialDetails[${productserialno}][pack_profile_pmd_ca]"></td>
                                                    <td><input type="text" name="Product_MaterialDetails[${productserialno}][released_quantity_pmd_ca]"></td>
                                                    <td><input type="text" name="Product_MaterialDetails[${productserialno}][remarks_ca]"></td>
                                                    <td><input type="date" name="Product_MaterialDetails[${productserialno}][mfg_date_pmd_ca]"></td>
                                                    <td><input type="date" name="Product_MaterialDetails[${productserialno}][expiry_date_pmd_ca]"></td>

                                                    <td><button type="button" class="removeRowBtn">Remove</button></td>
                                                </tr>`;
                                        }

                                        // Get the table body and current row count
                                        var tableBody = $('#prod_mate_detailsss tbody');
                                        var rowCount = tableBody.children('tr').length;
                                        var newRow = generateTableRow(rowCount); // Generate a new row
                                        tableBody.append(newRow); // Add the new row to the table
                                    });

                                    // Event listener for removing rows
                                    $(document).on('click', '.removeRowBtn', function () {
                                        $(this).closest('tr').remove();
                                    });
                                  });
                                </script>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="chemicals_reagents">
                                            Details of Chemicals and Reagents:
                                            <button type="button" id="chemicals_add">+</button>
                                            <span class="text-primary" data-bs-toggle="modal" data-bs-target="#document-details-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="chemicals_reagents_details" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 100px;">S.No.</th>
                                                        <th>Name of Chemicals/Reagents</th>
                                                        <th>Make</th>
                                                        <th>Batch No./Lot No.</th>
                                                        <th>Mfg. Date</th>
                                                        <th>Exp. Date</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><input disabled type="text" name="ChemicalsDetails[0][serial]" value="1"></td>
                                                        <td><input type="text" name="ChemicalsDetails[0][chemical_name]"></td>
                                                        <td><input type="text" name="ChemicalsDetails[0][make]"></td>
                                                        <td><input type="text" name="ChemicalsDetails[0][batch_lot_no]"></td>
                                                        <td><input type="date" name="ChemicalsDetails[0][mfg_date]"></td>
                                                        <td><input type="date" name="ChemicalsDetails[0][exp_date]"></td>
                                                        <td><button type="button" class="removeRowBtn">Remove</button></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    $(document).ready(function () {
                                        $('#chemicals_add').click(function (e) {
                                            e.preventDefault();

                                            // Function to generate a new row with the given serial number
                                            function generateTableRow(serialNumber) {
                                                var today = new Date().toISOString().split('T')[0]; // Get current date in YYYY-MM-DD format
                                                return `
                                                    <tr>
                                                        <td><input disabled type="text" name="ChemicalsDetails[${serialNumber}][serial]" value="${serialNumber + 1}"></td>
                                                        <td><input type="text" name="ChemicalsDetails[${serialNumber}][chemical_name]"></td>
                                                        <td><input type="text" name="ChemicalsDetails[${serialNumber}][make]"></td>
                                                        <td><input type="text" name="ChemicalsDetails[${serialNumber}][batch_lot_no]"></td>
                                                        <td><input type="date" name="ChemicalsDetails[${serialNumber}][mfg_date]"></td>
                                                        <td><input type="date" name="ChemicalsDetails[${serialNumber}][exp_date]"></td>
                                                        <td><button type="button" class="removeRowBtn">Remove</button></td>
                                                    </tr>`;
                                            }

                                            // Get the table body and current row count
                                            var tableBody = $('#chemicals_reagents_details tbody');
                                            var rowCount = tableBody.children('tr').length;
                                            var newRow = generateTableRow(rowCount); // Generate a new row
                                            tableBody.append(newRow); // Add the new row to the table
                                        });

                                        // Event listener for removing rows
                                        $(document).on('click', '.removeRowBtn', function () {
                                            $(this).closest('tr').remove();
                                        });
                                    });
                                </script>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="instruments_used">
                                            Details of Instruments Used:
                                            <button type="button" id="instrument_add">+</button>
                                            <span class="text-primary" data-bs-toggle="modal" data-bs-target="#document-details-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="instruments_used_details" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 100px;">S.No.</th>
                                                        <th>Name of Instrument</th>
                                                        <th>Instrument ID</th>
                                                        <th>Calibration On</th>
                                                        <th>Calibration Due</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><input disabled type="text" name="InstrumentDetails[0][serial]" value="1"></td>
                                                        <td><input type="text" name="InstrumentDetails[0][instrument_name]"></td>
                                                        <td><input type="text" name="InstrumentDetails[0][instrument_id]"></td>
                                                        <td><input type="date" name="InstrumentDetails[0][calibration_on]"></td>
                                                        <td><input type="date" name="InstrumentDetails[0][calibration_due]"></td>
                                                        <td><button type="button" class="removeRowBtn">Remove</button></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    $(document).ready(function () {
                                        // Add a new row when the "+" button is clicked
                                        $('#instrument_add').click(function (e) {
                                            e.preventDefault();

                                            // Function to generate a new row with the given serial number
                                            function generateTableRow(serialNumber) {
                                                var today = new Date().toISOString().split('T')[0]; // Get the current date in YYYY-MM-DD format
                                                return `
                                                    <tr>
                                                        <td><input disabled type="text" name="InstrumentDetails[${serialNumber}][serial]" value="${serialNumber + 1}"></td>
                                                        <td><input type="text" name="InstrumentDetails[${serialNumber}][instrument_name]"></td>
                                                        <td><input type="text" name="InstrumentDetails[${serialNumber}][instrument_id]"></td>
                                                        <td><input type="date" name="InstrumentDetails[${serialNumber}][calibration_on]"></td>
                                                        <td><input type="date" name="InstrumentDetails[${serialNumber}][calibration_due]"></td>
                                                        <td><button type="button" class="removeRowBtn">Remove</button></td>
                                                    </tr>`;
                                            }

                                            // Get the table body and current row count
                                            var tableBody = $('#instruments_used_details tbody');
                                            var rowCount = tableBody.children('tr').length;
                                            var newRow = generateTableRow(rowCount); // Generate a new row
                                            tableBody.append(newRow); // Append the new row to the table
                                        });

                                        // Event listener for removing rows
                                        $(document).on('click', '.removeRowBtn', function () {
                                            $(this).closest('tr').remove();
                                        });
                                    });
                                </script>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="instruments_used">
                                            Dissolution Test Results:
                                        </label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dissolution_test_results" style="width: 100%; font-size: 0.85rem;">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 100px;">S.No.</th>
                                                        <th class="text-center">Details</th>
                                                        <th class="text-center">Information</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td><label for="batch_no_0">Batch No. / Company Name</label></td>
                                                        <td><input type="text" name="DissolutionTest[0][batch_no]" id="batch_no_0"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td><label for="timepoint_0">Timepoint</label></td>
                                                        <td><input type="text" name="DissolutionTest[0][timepoint]" id="timepoint_0"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td><label for="minimum_0">Minimum</label></td>
                                                        <td><input type="text" name="DissolutionTest[0][minimum]" id="minimum_0"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>4</td>
                                                        <td><label for="maximum_0">Maximum</label></td>
                                                        <td><input type="text" name="DissolutionTest[0][maximum]" id="maximum_0"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>5</td>
                                                        <td><label for="average_0">Average</label></td>
                                                        <td><input type="text" name="DissolutionTest[0][average]" id="average_0"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>6</td>
                                                        <td><label for="remarks_0">Remarks</label></td>
                                                        <td><input type="text" name="DissolutionTest[0][remarks]" id="remarks_0"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>7</td>
                                                        <td><label for="limit_percent_0">Limit (%)</label></td>
                                                        <td><input type="text" name="DissolutionTest[0][limit_percent]" id="limit_percent_0"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>8</td>
                                                        <td><label for="conclusion_0">Conclusion</label></td>
                                                        <td><input type="text" name="DissolutionTest[0][conclusion]" id="conclusion_0"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">Dissolution Analysis Comment</label>
                                        <textarea class="tiny" name="dissolution_analysis_Comment" id="dissolution_analysis_Comment"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input" id="attachment_section">
                                        <label for="Certificate Analysis">Dissolution Analysis Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or Attached
                                                File</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="dissolution_analysis_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="dissolution_analysis_attachment[]"
                                                    oninput="addMultipleFiles(this, 'dissolution_analysis_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                        class="text-white">Exit</a></button>
                            </div>
                        </div>
                    </div>

                    <div id="CCForm9" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Zone">Review-1 Assesment</label>
                                        <select name="review_1_assesment" id="review_1_assesment">
                                            <option value="">--Select--</option>
                                            <option value="OK">OK</option>
                                            <option value="Not OK">Not OK</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">Comment</label>
                                        <textarea class="tiny" name="Review1_Comment" id="Review1_Comment"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input" id="attachment_section">
                                        <label for="Certificate Analysis">Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or Attached
                                                File</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="review1_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="review1_attachment[]"
                                                    oninput="addMultipleFiles(this, 'review1_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                        class="text-white">Exit</a></button>
                            </div>
                        </div>
                    </div>

                    <div id="CCForm10" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Zone">Review-2 Assesment</label>
                                        <select name="review_2_assesment" id="review_2_assesment">
                                            <option value="">--Select--</option>
                                            <option value="OK">OK</option>
                                            <option value="Not OK">Not OK</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">Comment</label>
                                        <textarea class="tiny" name="Review2_Comment" id="Review2_Comment"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input" id="attachment_section">
                                        <label for="Certificate Analysis">Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or Attached
                                                File</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="review2_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="review2_attachment[]"
                                                    oninput="addMultipleFiles(this, 'review2_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                        class="text-white">Exit</a></button>
                            </div>
                        </div>
                    </div>

                    <div id="CCForm11" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Zone">Assesment Of Approver</label>
                                        <select name="approver_assesment" id="approver_assesment">
                                            <option value="">--Select--</option>
                                            <option value="Approve">Approve</option>
                                            <option value="Reject">Reject</option>
                                            <option value="Retest">Retest</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">Comment</label>
                                        <textarea class="tiny" name="approver_Comment" id="approver_Comment"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input" id="attachment_section">
                                        <label for="Certificate Analysis">Approver Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or Attached
                                                File</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="approver_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="approver_attachment[]"
                                                    oninput="addMultipleFiles(this, 'approver_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                        class="text-white">Exit</a></button>
                            </div>
                        </div>
                    </div>

                    
                    <div id="CCForm12" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Plan Proposed By">Submit By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Plan Proposed On">Submit On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Cancelled By">Submit Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Plan Proposed By">Cancelled By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Plan Proposed On">Cancelled On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Cancelled By">Cancelled Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Plan Proposed By">Supervisor Approval By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Plan Proposed On">Supervisor Approval On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Supervisor Approval By">Supervisor Approval Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Plan Proposed By">Complete By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Plan Proposed On">Complete On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Supervisor Approval By">Complete Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Plan Proposed By">Additional Work Required By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Plan Proposed On">Additional Work Required On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Supervisor Approval By">Additional Work Required Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Plan Proposed By">QA Approval By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Plan Proposed On">QA Approval On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Supervisor Approval By">QA Approval Comment</label>
                                        <div class="static"></div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>

    <div class="modal fade" id="change-control-type-of-change-instruction-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Instructions</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <h4>1. Major Change:</h4>
                    <ul>
                        <li>A major change is usually a significant alteration that may have a substantial impact on the
                            product.</li>

                        <li>It might involve modifications to the manufacturing process, formulation, equipment, or other
                            critical aspects of production.</li>

                        <li>Major changes often require thorough assessment, validation, and regulatory approval before
                            implementation.</li>
                    </ul>


                    <h4>2. Minor Change:</h4>
                    <ul>

                        <li>A minor change is typically a less significant alteration, one that is unlikely to have a
                            substantial impact on product quality, safety, or efficacy.</li>

                        <li>Minor changes may include adjustments to documentation, labeling, or other non-critical aspects
                            that don't significantly affect the product's characteristics.</li>

                        <li>These changes may still require some level of evaluation and documentation but may not
                            necessitate the same level of scrutiny as major changes.</li>
                    </ul>


                    <h4>3. Critical Change:</h4>
                    <ul>

                        <li>A critical change is one that has the potential to significantly impact product quality, safety,
                            or efficacy and may require immediate attention.</li>

                        <li>These changes are often associated with unexpected events or deviations that need prompt
                            resolution to maintain product integrity.</li>

                        <li>Critical changes may require urgent assessment, corrective actions, and regulatory reporting.
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {

            $('#submitPrompt').click(async function() {
                let docDescription = $('input[name=short_description]').val().trim();
                if (docDescription === '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Empty Input',
                        text: 'Please enter a document short description.',
                    });
                    return;
                }

                Swal.fire({
                    title: 'Generating AI Response...',
                    html: 'Please wait while we gather insights based on your input. This might take a moment...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                try {
                    let open_ai_key = "{{ config('app.open_ai_key') }}";

                    const response = await axios.post(
                        'https://api.openai.com/v1/chat/completions', {
                            "model": "gpt-3.5-turbo",
                            "messages": [{
                                "role": "user",
                                "content": `Generate a structured JSON response (string key: string value) with fields Impact On Operations, Impact On Product Quality, Regulatory Impact, Risk Level, Validation Requirement based on the Change Control description: "${docDescription}". Make content as lengthy as possible.`
                            }]
                        }, {
                            headers: {
                                'Authorization': `Bearer ${open_ai_key}`,
                                'Content-Type': 'application/json'
                            }
                        }
                    );

                    Swal.close();

                    let content = response.data.choices[0].message.content;
                    let jsonResponse = JSON.parse(content);
                    console.log('data', jsonResponse)
                    populateFields(jsonResponse);
                    $('#customModal').modal('hide');

                } catch (error) {
                    console.log('error in ai generating response', error.message)
                }
            });

            function populateFields(data) {
                for (let section in data) {
                    let sectionData = data[section];

                    switch (section.toLowerCase()) {
                        case "impact on operations":
                            $("textarea[name='impact_operations']").val(sectionData);
                            break;

                        case "impact on product quality":
                            $("textarea[name='impact_product_quality']").val(sectionData);
                            break;

                        case "regulatory impact":
                            $("textarea[name='regulatory_impact']").val(sectionData);
                            break;

                        case "risk level":
                            $("textarea[name='risk_level']").val(sectionData);
                            break;

                        case "validation requirement":
                            $("textarea[name='validation_requirment']").val(sectionData);
                            break;

                        default:
                            console.warn(`No matching field found for section: ${section}`);
                    }
                }
            }

        });
    </script>

    <style>
        #step-form>div {
            display: none;
        }

        #step-form>div:nth-child(1) {
            display: block;
        }

        #productTable,
        #materialTable {
            display: none;
        }
    </style>

    <script>
        VirtualSelect.init({
            ele: '#investigators, #department, #root-cause-methodology,#investigation_team , #review_1_person, #review_2_person, #approver_person'
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


        function addRootCauseAnalysisRiskAssessment(tableId) {
            var table = document.getElementById(tableId);
            var currentRowCount = table.rows.length;
            var newRow = table.insertRow(currentRowCount);
            newRow.setAttribute("id", "row" + currentRowCount);
            var cell1 = newRow.insertCell(0);
            cell1.innerHTML = currentRowCount;

            var cell2 = newRow.insertCell(1);
            cell2.innerHTML = "<input name='risk_factor[]' type='text'>";

            var cell3 = newRow.insertCell(2);
            cell3.innerHTML = "<input name='risk_element[]' type='text'>";

            var cell4 = newRow.insertCell(3);
            cell4.innerHTML = "<input name='problem_cause[]' type='text'>";

            var cell5 = newRow.insertCell(4);
            cell5.innerHTML = "<input name='existing_risk_control[]' type='text'>";

            var cell6 = newRow.insertCell(5);
            cell6.innerHTML =
                "<select onchange='calculateInitialResult(this)' class='fieldR' name='initial_severity[]'><option value=''>-- Select --</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>";

            var cell7 = newRow.insertCell(6);
            cell7.innerHTML =
                "<select onchange='calculateInitialResult(this)' class='fieldP' name='initial_probability[]'><option value=''>-- Select --</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>";

            var cell8 = newRow.insertCell(7);
            cell8.innerHTML =
                "<select onchange='calculateInitialResult(this)' class='fieldN' name='initial_detectability[]'><option value=''>-- Select --</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>";

            var cell9 = newRow.insertCell(8);
            cell9.innerHTML = "<input name='initial_rpn[]' type='text' class='initial-rpn'  >";

            var cell10 = newRow.insertCell(9);
            cell10.innerHTML =
                "<select name='risk_acceptance[]'><option value=''>-- Select --</option><option value='N'>N</option><option value='Y'>Y</option></select>";

            var cell11 = newRow.insertCell(10);
            cell11.innerHTML = "<input name='risk_control_measure[]' type='text'>";

            var cell12 = newRow.insertCell(11);
            cell12.innerHTML =
                "<select onchange='calculateResidualResult(this)' class='residual-fieldR' name='residual_severity[]'><option value=''>-- Select --</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>";

            var cell13 = newRow.insertCell(12);
            cell13.innerHTML =
                "<select onchange='calculateResidualResult(this)' class='residual-fieldP' name='residual_probability[]'><option value=''>-- Select --</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>";

            var cell14 = newRow.insertCell(13);
            cell14.innerHTML =
                "<select onchange='calculateResidualResult(this)' class='residual-fieldN' name='residual_detectability[]'><option value=''>-- Select --</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option></select>";

            var cell15 = newRow.insertCell(14);
            cell15.innerHTML = "<input name='residual_rpn[]' type='text' class='residual-rpn' >";

            var cell16 = newRow.insertCell(15);
            cell16.innerHTML =
                "<select name='risk_acceptance2[]'><option value=''>-- Select --</option><option value='N'>N</option><option value='Y'>Y</option></select>";

            var cell17 = newRow.insertCell(16);
            cell17.innerHTML = "<input name='mitigation_proposal[]' type='text'>";

            var cell18 = newRow.insertCell(17);
            cell18.innerHTML = "<button type='text' class='removeRowBtn' name='Action[]' readonly>Remove</button>";

            for (var i = 1; i < currentRowCount; i++) {
                var row = table.rows[i];
                row.cells[0].innerHTML = i;
            }
        }


        function updateRowNumbers(table) {
            // Update the row number for each row in the tbody (excluding the header)
            var rows = table.getElementsByTagName('tbody')[0].rows;
            for (var i = 0; i < rows.length; i++) {
                rows[i].cells[0].innerHTML = i + 1; // Set the row number
            }
        }
    </script>

    <script>
        function calculateInitialResult(selectElement) {
            let row = selectElement.closest('tr');
            let R = parseFloat(row.querySelector('.fieldR').value) || 0;
            let P = parseFloat(row.querySelector('.fieldP').value) || 0;
            let N = parseFloat(row.querySelector('.fieldN').value) || 0;
            let result = R * P * N;
            row.querySelector('.initial-rpn').value = result;
        }
    </script>

    <script>
        function calculateResidualResult(selectElement) {
            let row = selectElement.closest('tr');
            let R = parseFloat(row.querySelector('.residual-fieldR').value) || 0;
            let P = parseFloat(row.querySelector('.residual-fieldP').value) || 0;
            let N = parseFloat(row.querySelector('.residual-fieldN').value) || 0;
            let result = R * P * N;
            row.querySelector('.residual-rpn').value = result;
        }
    </script>

    <script>
        const productSelect = document.getElementById('productSelect');
        const productTable = document.getElementById('productTable');
        const materialSelect = document.getElementById('materialSelect');
        const materialTable = document.getElementById('materialTable');

        materialSelect.addEventListener('change', function() {
            if (materialSelect.value === 'yes') {
                materialTable.style.display = 'block';
            } else {
                materialTable.style.display = 'none';
            }
        });

        productSelect.addEventListener('change', function() {
            if (productSelect.value === 'yes') {
                productTable.style.display = 'block';
            } else {
                productTable.style.display = 'none';
            }
        });
    </script>

    <script>
        VirtualSelect.init({
            ele: '#related_records, #cft_reviewer, #risk_assessment_related_record'
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
        function calculateRiskAnalysis(selectElement) {
            // Get the row containing the changed select element
            let row = selectElement.closest('tr');

            // Get values from select elements within the row
            let R = parseFloat(document.getElementById('analysisR').value) || 0;
            let P = parseFloat(document.getElementById('analysisP').value) || 0;
            let N = parseFloat(document.getElementById('analysisN').value) || 0;

            // Perform the calculation
            let result = R * P * N;

            // Update the result field within the row
            document.getElementById('analysisRPN').value = result;
        }
    </script>
    {{-- var riskData = @json($riskData); --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() { //DISABLED PAST DATES IN APPOINTMENT DATE
            var dateToday = new Date();
            var month = dateToday.getMonth() + 1;
            var day = dateToday.getDate();
            var year = dateToday.getFullYear();

            if (month < 10)
                month = '0' + month.toString();
            if (day < 10)
                day = '0' + day.toString();

            var maxDate = year + '-' + month + '-' + day;

            $('#dueDate').attr('min', maxDate);
        });
    </script>

    <script>
        $(document).ready(function() {
            var aiText = $('.ai_text');


            console.log(riskData);
            $('#short_description').on('input', function() {
                var description = $(this).val().toLowerCase();
                var riskLevelSelectize = $('#risk_level')[0].selectize;
                // var aiText = $('#ai_text');

                var foundRiskLevel = false;
                for (var i = 0; i < riskData.length; i++) {
                    if (description.includes(riskData[i].keyword.toLowerCase())) {
                        riskLevelSelectize.setValue(riskData[i].risk_level, true);
                        aiText.show();
                        foundRiskLevel = true;
                        console.log(riskData[i].keyword);
                        break;
                    }
                }
                if (!foundRiskLevel) {
                    riskLevelSelectize.setValue('0', true);
                    aiText.hide();
                }
            });

            $('#risk_level').on('change', function() {
                if ($(this).val() !== '0') {
                    aiText.hide();
                }
            });
        });
    </script>
    <script>
        // JavaScript
        document.getElementById('initiator_group').addEventListener('change', function() {
            var selectedValue = this.value;
            document.getElementById('initiator_group_code').value = selectedValue;
        });
    </script>

    <style>
        .swal2-container.swal2-center.swal2-backdrop-show .swal2-icon.swal2-error.swal2-icon-show,
        .swal2-container.swal2-center.swal2-backdrop-show .selectize-control.swal2-select.single {
            display: none !important;
        }

        .swal2-container.swal2-center.swal2-backdrop-show #swal2-title {
            text-align: center;
            font-size: 1.5rem !important;
        }

        .swal2-container.swal2-center.swal2-backdrop-show .swal2-html-container.my-html-class {
            text-transform: capitalize !important;
        }
    </style>
     <script>
        document.addEventListener('DOMContentLoaded', function() {
            var maxLength = 500;
            var inputField = document.getElementById('docname');
            var charCounter = document.getElementById('rchars');
    
            if (inputField) {
                inputField.addEventListener('input', function() {
                    var remainingChars = maxLength - inputField.value.length;
                    charCounter.textContent = remainingChars;
                });
            }
        });
    </script>
   
     <script>
        var maxLength = 100;
        $('#docename').keyup(function() {
            var textlen = maxLength - $(this).val().length;
            $('#rchars1').text(textlen);
        });
    </script>
    <script>
        $(document).ready(function() {
            // Event listener for the remove file button
            $(document).on('click', '.remove-file', function() {
                $(this).closest('.file-container').remove();
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const removeButtons = document.querySelectorAll('.remove-file');

            removeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const fileName = this.getAttribute('data-file-name');
                    const fileContainer = this.parentElement;

                    // Hide the file container
                    if (fileContainer) {
                        fileContainer.style.display = 'none';
                    }
                });
            });
        });
    </script>

    <script>
        function addSparePartInformation(tableId) {
            var table = document.getElementById(tableId);
            var currentRowCount = table.rows.length;
            var newRow = table.insertRow(currentRowCount);
            newRow.setAttribute("id", "row" + currentRowCount);

            var cell1 = newRow.insertCell(0);
            cell1.innerHTML = currentRowCount;

            var cell2 = newRow.insertCell(1);
            cell2.setAttribute('colspan', '2');
            cell2.innerHTML = "<input name='SpareEquipment_Name[]' type='text'>";

            var cell3 = newRow.insertCell(2);
            cell3.setAttribute('colspan', '2');
            cell3.innerHTML = "<input name='SpareEquipment_ID[]' type='text'>";

            var cell4 = newRow.insertCell(3);
            cell4.setAttribute('colspan', '2');
            cell4.innerHTML = "<input name='SparePart_ID[]' type='text'>";

            var cell5 = newRow.insertCell(4);
            cell5.setAttribute('colspan', '2');
            cell5.innerHTML = "<input name='SparePart_Name[]' type='text'>";

            var cell6 = newRow.insertCell(5);
            cell6.setAttribute('colspan', '2');
            cell6.innerHTML = "<input name='SpareManufacturer[]' type='text'>";

            var cell7 = newRow.insertCell(6);
            cell7.setAttribute('colspan', '2');
            cell7.innerHTML = "<input name='SpareModel_Number[]' type='text'>";

            var cell8 = newRow.insertCell(7);
            cell8.setAttribute('colspan', '2');
            cell8.innerHTML = "<input name='SpareSerial_Number[]' type='text'>";

            var cell9 = newRow.insertCell(8);
            cell9.setAttribute('colspan', '2');
            cell9.innerHTML = "<input name='SpareOEM[]' type='text'>";

            var cell10 = newRow.insertCell(9);
            cell10.setAttribute('colspan', '2');
            cell10.innerHTML = "<input name='SparePart_Category[]' type='text'>";

            var cell11 = newRow.insertCell(10);
            cell11.setAttribute('colspan', '2');
            cell11.innerHTML = "<input name='SparePart_Group[]' type='text'>";

            var cell12 = newRow.insertCell(11);
            cell12.setAttribute('colspan', '2');
            cell12.innerHTML = "<input name='SparePart_Dimensions[]' type='text'>";

            var cell13 = newRow.insertCell(12);
            cell13.setAttribute('colspan', '2');
            cell13.innerHTML = "<input name='SpareMaterial[]' type='text'>";

            var cell14 = newRow.insertCell(13);
            cell14.setAttribute('colspan', '2');
            cell14.innerHTML = "<input name='SpareWeight[]' type='text'>";

            var cell15 = newRow.insertCell(14);
            cell15.setAttribute('colspan', '2');
            cell15.innerHTML = "<input name='SpareColor[]' type='text'>";

            var cell16 = newRow.insertCell(15);
            cell16.setAttribute('colspan', '2');
            cell16.innerHTML = "<input name='SparePart_Lifecycle_Stage[]' type='text'>";

            var cell17 = newRow.insertCell(16);
            cell17.setAttribute('colspan', '2');
            cell17.innerHTML = "<input name='SparePart_Status[]' type='text'>";

            var cell18 = newRow.insertCell(17);
            cell18.setAttribute('colspan', '2');
            cell18.innerHTML = "<input name='SpareAvailability[]' type='text'>";

            var cell19 = newRow.insertCell(18);
            cell19.setAttribute('colspan', '2');
            cell19.innerHTML = "<input name='SpareQuantity_on_Hand[]' type='text'>";

            var cell20 = newRow.insertCell(19);
            cell20.setAttribute('colspan', '2');
            cell20.innerHTML = "<input name='SpareQuantity_on_Order[]' type='text'>";

            var cell21 = newRow.insertCell(20);
            cell21.setAttribute('colspan', '2');
            cell21.innerHTML = "<input name='SpareReorder_Point[]' type='text'>";

            var cell22 = newRow.insertCell(21);
            cell22.setAttribute('colspan', '2');
            cell22.innerHTML = "<input name='SpareSafety_Stock[]' type='text'>";

            var cell23 = newRow.insertCell(22);
            cell23.setAttribute('colspan', '2');
            cell23.innerHTML = "<input name='SpareMinimum_Order_Quantity[]' type='text'>";

            var cell24 = newRow.insertCell(23);
            cell24.setAttribute('colspan', '2');
            cell24.innerHTML = "<input name='SpareLead_Time[]' type='text'>";

            var cell25 = newRow.insertCell(24);
            cell25.setAttribute('colspan', '2');
            cell25.innerHTML = "<input name='SpareStock_Location[]' type='text'>";

            var cell26 = newRow.insertCell(25);
            cell26.setAttribute('colspan', '2');
            cell26.innerHTML = "<input name='SpareBin_Number[]' type='text'>";

            var cell27 = newRow.insertCell(26);
            cell27.setAttribute('colspan', '2');
            cell27.innerHTML = "<input name='SpareStock_Keeping_Unit[]' type='text'>";

            var cell28 = newRow.insertCell(27);
            cell28.setAttribute('colspan', '2');
            cell28.innerHTML = "<input name='SpareLot_Number[]' type='text'>";

            var cell29 = newRow.insertCell(28);
            cell29.setAttribute('colspan', '2');
            cell29.innerHTML = "<input name='SpareExpiry_Date[]' type='text'>";

            var cell30 = newRow.insertCell(29);
            cell30.setAttribute('colspan', '2');
            cell30.innerHTML = "<input name='SpareSupplier_Name[]' type='text'>";

            var cell31 = newRow.insertCell(30);
            cell31.setAttribute('colspan', '2');
            cell31.innerHTML = "<input name='SpareSupplier_Contact_Information[]' type='text'>";

            var cell32 = newRow.insertCell(31);
            cell32.setAttribute('colspan', '2');
            cell32.innerHTML = "<input name='SpareSupplier_Lead_Time[]' type='text'>";

            var cell33 = newRow.insertCell(32);
            cell33.setAttribute('colspan', '2');
            cell33.innerHTML = "<input name='SpareSupplier_Price[]' type='text'>";

            var cell34 = newRow.insertCell(33);
            cell34.setAttribute('colspan', '2');
            cell34.innerHTML = "<input name='SpareSupplier_Part_Number[]' type='text'>";

            var cell35 = newRow.insertCell(34);
            cell35.setAttribute('colspan', '2');
            cell35.innerHTML = "<input name='SpareSupplier_Warranty_Information[]' type='text'>";

            var cell36 = newRow.insertCell(35);
            cell36.setAttribute('colspan', '2');
            cell36.innerHTML = "<input name='SpareSupplier_Performance_Metrics[]' type='text'>";

            var cell37 = newRow.insertCell(36);
            cell37.setAttribute('colspan', '2');
            cell37.innerHTML =
                "<button type='button' onclick='removeSparePartRow(this)' class='removeRowBtn'>Remove</button>";

            // Update row numbers
            for (var i = 1; i < table.rows.length; i++) {
                table.rows[i].cells[0].innerHTML = i;
            }
        }


        function removeSparePartRow(button) {
            // Get the row to remove
            var row = button.closest("tr");
            var table = row.parentNode;
            row.parentNode.removeChild(row);

            // After removing, update the row numbers again
            updateRowNumbers(table);
        }

        function updateRowNumbers(table) {
            // Update the row number for each row in the tbody (excluding the header)
            var rows = table.getElementsByTagName('tbody')[0].rows;
            for (var i = 0; i < rows.length; i++) {
                rows[i].cells[0].innerHTML = i + 1; // Set the row number
            }
        }
    </script>
    <!-----------------Validation Code -------------------->
    
    <div class="modal fade" id="dynamicModal" tabindex="-1" aria-labelledby="dynamicModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="dynamicModalLabel">Required Fields</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p id="dynamicModalMessage">Please fill the required fields below:</p>
        <div id="dynamicModalInputContainer">
          <!-- Dynamic input fields will be injected here -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="dynamicModalSave">Save</button>
      </div>
    </div>
  </div>
</div>

<style>
  .modal-content {
    border-radius: 10px;
  }
  .modal-header {
    border-bottom: 1px solid rgba(233, 39, 39, 0.1);
  }
  .modal-footer {
    border-top: 1px solid rgba(0, 0, 0, 0.1);
  }
  .shadow-lg {
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
  }
  .btn-primary:hover {
    background-color: rgb(0, 133, 82);
    border-color: rgb(5, 119, 71);
  }
  .btn-secondary:hover {
    background-color: #5a6268;
    border-color: #5a6268;
  }
  #dynamicModalInputContainer {
    background: linear-gradient(to right, rgb(77, 105, 133), #e9ecef);
    border-radius: 8px;
    padding: 20px;
  }
  .modal-title {
    font-weight: bold;
    font-size: 1.25rem;
  }
  .modal-body p {
    font-size: 1rem;
    color: rgb(79, 120, 155);
  }
</style>

<script>
  document.querySelector('.saveButton').addEventListener('click', function (e) {
    e.preventDefault();

    const shortDescriptionField = document.getElementById('docename');
    const categorizationField = document.getElementById('receipt_division');
    const modeReceiptField = document.getElementById('mode_receipt');
    const breifDescriptionField = document.getElementById('docname');
    const sourceOfSampleField = document.getElementById('source_of_sample');
    
    let isShortDescriptionValid = !!shortDescriptionField?.value.trim();
    let isCategorizationValid = !!categorizationField?.value;
    let isModeReceiptValid = !!modeReceiptField?.value;
    let isBriefDescValid = !!breifDescriptionField?.value;
    let isSourceOfSampleValid = !!sourceOfSampleField?.value;

    if (isShortDescriptionValid && isCategorizationValid && isModeReceiptValid && isBriefDescValid && isSourceOfSampleValid) {
      $('#sampleManagmentIForm')[0].submit();
      console.log("Form submitted successfully!");
      return;
    }

    let modalInputs = "";
    if (!isShortDescriptionValid) {
      modalInputs += `
        <div class="form-group">
          <label for="modalShortDescription">Received From<span class="text-danger">*</span></label>
          <input id="modalShortDescription" type="text" name="modal_short_description" maxlength="255" class="form-control" value="${shortDescriptionField?.value || ""}">
        </div>
      `;
    }
    if (!isBriefDescValid) {
      modalInputs += `
        <div class="form-group">
          <label for="briefDescription">Brief Description<span class="text-danger">*</span></label>
          <input id="briefDescription" type="text" name="brief_description" maxlength="255" class="form-control" value="${breifDescriptionField?.value || ""}">
        </div>
      `;
    }
    if (!isCategorizationValid) {
      modalInputs += `
        <div class="form-group">
          <label for="modalInitialCategorization">Initial Categorization<span class="text-danger">*</span></label>
          <select id="modalInitialCategorization" class="form-control">
            <option value="">--Select--</option>
            <option value="ARD" ${categorizationField?.value === "ARD" ? "selected" : ""}>Analytical Research & Development Division</option>
            <option value="RSD" ${categorizationField?.value === "RSD" ? "selected" : ""}>Reference Standard Division</option>
            <option value="BIO" ${categorizationField?.value === "BIO" ? "selected" : ""}>Biologics Division</option>
            <option value="PVP" ${categorizationField?.value === "PVP" ? "selected" : ""}>PvPI Division</option>
            <option value="QAL" ${categorizationField?.value === "QAL" ? "selected" : ""}>Quality Assurance Division</option>
            <option value="MVP" ${categorizationField?.value === "MVP" ? "selected" : ""}>MvPI Division</option>
            <option value="OTH" ${categorizationField?.value === "OTH" ? "selected" : ""}>Others</option>
          </select>
        </div>
      `;
    }

    if (!isModeReceiptValid) {
      modalInputs += `
        <div class="form-group">
          <label for="modelsourceValid">Source of Sample <span class="text-danger">*</span></label>
          <select id="modelsourceValid" class="form-control">
            <option value="">--Select--</option>
            <option value="Stakeholder" ${sourceOfSampleField?.value === "Stakeholder" ? "selected" : ""}>Stakeholder</option>
            <option value="Market Purchase" ${sourceOfSampleField?.value === "Market Purchase" ? "selected" : ""}>Market Purchase</option>
          </select>
        </div>
      `;
    }

    if (!isSourceOfSampleValid) {
      modalInputs += `
        <div class="form-group">
          <label for="modelReceiptValid">Mode of Receipt<span class="text-danger">*</span></label>
          <select id="modelReceiptValid" class="form-control">
            <option value="">--Select--</option>
            <option value="Hand Delivery" ${modeReceiptField?.value === "Hand Delivery" ? "selected" : ""}>Hand Delivery</option>
            <option value="Post" ${modeReceiptField?.value === "Post" ? "selected" : ""}>Post</option>
            <option value="Courier" ${modeReceiptField?.value === "Courier" ? "selected" : ""}>Courier</option>
            <option value="Others" ${modeReceiptField?.value === "Others" ? "selected" : ""}>Others</option>
          </select>
        </div>
      `;
    }

    showDynamicModal("Required Fields", "Please complete the fields below:", modalInputs, function (values) {
      if (values.modalShortDescription) {
        shortDescriptionField.value = values.modalShortDescription;
      }
      if (values.briefDescription) {
        breifDescriptionField.value = values.briefDescription;
      }
      if (values.modalInitialCategorization) {
        categorizationField.value = values.modalInitialCategorization;
      }
      if (values.modelReceiptValid) {
        modeReceiptField.value = values.modelReceiptValid;
      }
      if (values.modelsourceValid) {
        sourceOfSampleField.value = values.modelsourceValid;
      }
      console.log("Form submitted successfully with updated values!");
    });
  });

  function showDynamicModal(title, message, inputHtml, onSave) {
    document.getElementById("dynamicModalLabel").textContent = title;
    document.getElementById("dynamicModalMessage").textContent = message;

    const inputContainer = document.getElementById("dynamicModalInputContainer");
    inputContainer.innerHTML = inputHtml;

    const saveButton = document.getElementById("dynamicModalSave");
    saveButton.onclick = function () {
      const inputs = inputContainer.querySelectorAll("input, select");
      const values = {};
      let allValid = true;

      inputs.forEach((input) => {
        if (!input.value.trim()) {
          allValid = false;
          alert(`Please provide a valid ${input.name || "value"}.`);
        } else {
          values[input.id] = input.value.trim();
        }
      });

      if (allValid) {
        onSave(values);
        const modal = bootstrap.Modal.getInstance(document.getElementById("dynamicModal"));
        modal.hide();
      }
    };

    const modal = new bootstrap.Modal(document.getElementById("dynamicModal"));
    modal.show();
  }
</script>
@endsection
