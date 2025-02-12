@extends('frontend.rcms.layout.main_rcms')
@section('rcms_container')
    <style>
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
        
            .language-select {
                display: flex;
                justify-content: flex-start; 
                width: 100%; 
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
                    {{ Helpers::getDivisionName(session()->get('division')) }} / Calibration Management
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
                    <!-- <div class="language-sleect d-flex" style="align-items: center; gap: 20px;">
                        <div>Select Language </div>
                        <div class="main-head" id="google_translate_element"></div>
                    </div> -->

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
            <div class="cctab">
                {{-- <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Calibration Management</button> --}}
                @if($parent_id)
                <button class="cctablinks" onclick="openCity(event, 'CCForm222')">
                    Equipment/Instrument Information
                </button>
            @endif     
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">
                Calibration Management
            </button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Implementor Review</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">QA Review</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Activity Log</button>
                
                <div class="language-select d-flex align-items-center" style="justify-content: flex-start;">
                    <div>Select Language</div>
                    <div class="main-head" id="google_translate_element"></div>
                </div>
            </div>

           
            <form action="{{ route('CalibrationDetails_store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Tab content -->
                <div id="step-form">

                    @if (!empty($parent_id))
                    <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                    <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                @endif
                @if($parent_id)
                    <div id="CCForm222" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">

                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>Record Number</b></label>
                                        <input readonly type="text" name="record_number"
                                            value="{{ $equipment->record_number }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Site/Location Code</b></label>
                                        <input readonly type="text" name="division_code"
                                            value="{{ Helpers::getDivisionName($equipment->division_id) }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator"><b>Initiator</b></label>
                                        <input type="hidden" name="initiator_id">
                                        <input readonly type="text" value="{{ $equipment->initiator_name }} ">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input ">
                                        <label for="Date Due"><b>Date of Initiation</b></label>
                                        <input disabled type="text" value="{{ date('d-M-Y') }}"
                                            name="intiation_date">
                                        <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Assigned to">Assigned to</label>
                                        <select name="assign_to"
                                            {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>
                                            <option value="">-- Select --</option>
                                            @foreach ($users as $key => $value)
                                                <option value="{{ $value->id }}"
                                                    @if ($data->assign_to == $value->id) selected @endif>
                                                    {{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="due-date">Due Date <span class="text-danger"></span></label>
                                        <input readonly type="text"
                                            value="{{ Helpers::getdateFormat($equipment->due_date) }}"
                                            name="due_date"{{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>
                                    </div>
                                </div> --}}

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span
                                                class="text-danger">*</span></label><span id="rchars"
                                            class="text-primary">255 </span><span class="text-primary"> characters
                                            remaining</span>
                                        <div class="relative-container">
                                            <input readonly name="short_description" id="docname" type="text"
                                                value="{{ $equipment->short_description }}" maxlength="255"
                                                required
                                                {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                
                            
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="equipment_id">Equipment/Instrument ID/Tag Number</label>
                                        <input type="number" name="equipment_id" value="{{ $equipment->equipment_id }}" min="0" disabled/>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Equipment/Instrument_Name/Description">Equipment/Instrument Name/Description</label>
                                        <div class="relative-container">                                                    
                                            <input type="text" name="equipment_name_description" value="{{ $equipment->equipment_name_description }}" disabled/>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Manufacturer">Manufacturer</label>
                                        <div class="relative-container">                                                    
                                            <input type="text" name="manufacturer" value="{{ $equipment->manufacturer }}" disabled/>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Model_Number">Model Number</label>
                                        <input type="number" min="0" name="model_number" value="{{ $equipment->model_number }}" disabled />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Serial_Number">Serial Number</label>
                                        <input type="number" min="0" name="serial_number" value="{{ $equipment->serial_number }}" disabled />
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Location">Location</label>
                                        <div class="relative-container">                                                    
                                            <textarea name="location" disabled>{{ $equipment->location }}</textarea>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Purchase Date">Purchase Date</label>
                                        <div class="calenderauditee">                                     
                                            <input type="text"  id="purchase_date"  readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($equipment->purchase_date) }}"
                                            disabled/>
                                            <input type="date" id="purchase_date_checkdate" name="purchase_date" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" disabled value="{{ $equipment->purchase_date }}" class="hide-input"
                                            oninput="handleDateInput(this, 'purchase_date');checkDate('purchase_date_checkdate','purchase_date1_checkdate')"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Installation Date">Installation Date</label>
                                        <div class="calenderauditee">                                     
                                            <input type="text"  id="installation_date"  readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($equipment->installation_date) }}"
                                                disabled/>
                                            <input type="date" id="installation_date_checkdate " readonly name="installation_date" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" disabled value="{{ $equipment->installation_date }}" class="hide-input"
                                            oninput="handleDateInput(this, 'installation_date');checkDate('installation_date_checkdate','installation_date1_checkdate')"/>
                                        </div>
                                    </div>
                                </div>  
                                
                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Warranty Expiration Date">Warranty Expiration Date</label>
                                        <div class="calenderauditee">                                     
                                            <input type="text"  id="warranty_expiration_date"  readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($equipment->warranty_expiration_date) }}"
                                                {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }}/>
                                            <input type="date" id="warranty_expiration_date_checkdate" readonly name="warranty_expiration_date" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" {{ $equipment->stage == 0 || $equipment->stage == 10 ? 'disabled' : '' }} value="{{ $equipment->warranty_expiration_date }}" class="hide-input"
                                            oninput="handleDateInput(this, 'warranty_expiration_date');checkDate('warranty_expiration_date_checkdate','warranty_expiration_date1_checkdate')"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="criticality_level">Criticality Level </label>
                                        <select name="criticality_level" id="criticality_level" disabled>
                                            <option value="">-- Select --</option>
                                            <option value="High" {{ $equipment->criticality_level == 'High' ? 'selected' : '' }}>High</option>
                                            <option value="Medium" {{ $equipment->criticality_level == 'Medium' ? 'selected' : '' }}>Medium</option>
                                            <option value="Low" {{ $equipment->criticality_level == 'Low' ? 'selected' : '' }}>Low</option>                                                   
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="asset_type">Asset Type</label>
                                        <select name="asset_type" id="asset_type" disabled>
                                            <option value="">-- Select --</option>
                                            <option value="Reactors" {{ $equipment->asset_type == 'Reactors' ? 'selected' : '' }}>Reactors</option>
                                            <option value="Mixers/Blenders" {{ $equipment->asset_type == 'Mixers/Blenders' ? 'selected' : '' }}>Mixers/Blenders</option>
                                            <option value="Granulators" {{ $equipment->asset_type == 'Granulators' ? 'selected' : '' }}>Granulators</option>                                                   
                                            <option value="Compressors" {{ $equipment->asset_type == 'Compressors' ? 'selected' : '' }}>Compressors</option>                                                   
                                            <option value="Coating Machines" {{ $equipment->asset_type == 'Coating Machines' ? 'selected' : '' }}>Coating Machines</option>                                                   
                                            <option value="Sterilizers" {{ $equipment->asset_type == 'Sterilizers' ? 'selected' : '' }}>Sterilizers</option>                                                   
                                            <option value="Centrifuges" {{ $equipment->asset_type == 'Centrifuges' ? 'selected' : '' }}>Centrifuges</option>                                                   
                                            <option value="Dryers" {{ $equipment->asset_type == 'Dryers' ? 'selected' : '' }}>Dryers</option>                                                 
                                        </select>
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
                @endif

                    <div id="CCForm1" class="inner-block cctabcontent">
                        <div class="inner-block-content">

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>Record Number</b></label>
                                        <input readonly type="text" name="record_number"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}/CM/{{ date('Y') }}/{{ $record_number }}">
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
                                        {{-- <div class="static">{{ Auth::user()->name }}</div> --}}
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
                                        {{-- <div><small class="text-primary">If revising Due Date, kindly mention revision
                                                reason in "Due Date Extension Justification" data field.</small></div> --}}
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
                                            <input id="docname" type="text" name="short_description" maxlength="255"
                                                required>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Due">Calibration Standard Reference</label>
                                        <input type="text" name="calibration_standard_preference">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Zone">Calibration Frequency</label>
                                        <select name="callibration_frequency">
                                            <option value="">Select Calibration Frequency</option>
                                            <option value="Weekly">Weekly</option>
                                            <option value="Fortnightly">Fortnightly</option>
                                            <option value="Monthly">Monthly</option>
                                            <option value="Quarterly">Quarterly</option>
                                            <option value="Half Yearly">Half Yearly</option>
                                            <option value="Annually">Annually</option>
                                            <option value="Once in Two Years">Once in Two Years</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Last Calibration Date">Last Calibration Date</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="last_calibration_date" readonly placeholder="DD-MMM-YYYY" />
                                            <input type="date" id="last_calibration_date_checkdate" name="last_calibration_date"
                                                max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'last_calibration_date'); setNextDateMin(this.value, 'next_calibration_date_checkdate')" />
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Next Calibration Date">Next Calibration Date</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="next_calibration_date" readonly placeholder="DD-MMM-YYYY" />
                                            <input type="date" id="next_calibration_date_checkdate" name="next_calibration_date"
                                                class="hide-input"
                                                oninput="handleDateInput(this, 'next_calibration_date')" />
                                        </div>
                                    </div>
                                </div>
                                
                                <script>
                                    function setNextDateMin(lastDate, nextDateInputId) {
                                    if (lastDate) {
                                        // `nextDateInputId` is the ID of Next Calibration Date input field
                                        const nextDateInput = document.getElementById(nextDateInputId);
                                        // Set minimum date for next calibration date
                                        nextDateInput.min = lastDate;
                                    }
                                }

                                function handleDateInput(dateInput, targetId) {
                                    const targetInput = document.getElementById(targetId);
                                    if (targetInput) {
                                        // Format date to 'DD-MMM-YYYY' (optional)
                                        const formattedDate = new Date(dateInput.value).toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: 'short',
                                            year: 'numeric',
                                        });
                                        targetInput.value = formattedDate;
                                    }
                                }

                                </script>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Details">Calibration Due Reminder</label>
                                        <input type="number" name="calibration_due_reminder">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Details">Calibration Method/Procedure</label>
                                        <textarea name="calibration_method_procedure"></textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Calibration Procedure Reference/Document">Calibration Procedure
                                            Reference/Document</label>
                                        <div><small class="text-primary">Please Attach all relevant or Attached
                                                File</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="calibration_procedure_attach"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile"
                                                    name="calibration_procedure_attach[]"
                                                    oninput="addMultipleFiles(this, 'calibration_procedure_attach')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Due">Calibration Standards Used</label>
                                        <input type="text" name="calibration_used">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Due">Calibration Parameters</label>
                                        <input type="text" name="calibration_parameter">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Zone">Unscheduled or Event Based Calibration?</label>
                                        <select name="event_based_calibration">
                                            <option value="">--Select--</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Details">Reason for Unscheduled or Event Based Calibration</label>
                                        <textarea name="event_based_calibration_reason"></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Due">Event Reference No.</label>
                                        <input type="number" name="event_refernce_no">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Due">Calibration Checklist</label>
                                        <input type="text" name="calibration_checklist">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Due">Calibration Results</label>
                                        <input type="text" name="calibration_result">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Due">Calibration Certificate Number</label>
                                        <input type="number" name="calibration_certificate_result">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Calibration Certificate Attachment">Calibration Certificate
                                            Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or Attached
                                                File</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="calibration_certificate"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="calibration_certificate[]"
                                                    oninput="addMultipleFiles(this, 'calibration_certificate')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Due">Calibrated By</label>
                                        <input type="text" name="calibrated_by">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Due">Calibration Due Alert</label>
                                        <input type="text" name="calibration_due_alert">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Due">Cost of Calibration</label>
                                        <input type="text" name="calibration_cost">
                                    </div>
                                </div>

                                <div class="group-input">
                                    <label for="audit-agenda-grid">
                                        CM Checklist
                                        <button type="button" name="audit-agenda-grid" id="CheckListAdd">+</button>
                                        <span class="text-primary" data-bs-toggle="modal"
                                            data-bs-target="#observation-field-instruction-modal"
                                            style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                            (Launch Instruction)
                                        </span>
                                    </label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="responsibilty-table" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%;">Sr No.</th>
                                                    <th>Check Point</th>
                                                    <th>Comment</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input disabled type="text" name="cmchecklist[0][serial]" value="1"></td>
                                                    <td><input type="text" name="cmchecklist[0][checkpoint]"></td>
                                                    <td><input type="text" name="cmchecklist[0][comment]" ></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Details">Calibration Comments/Observations</label>
                                        <textarea name="calibration_comments"></textarea>
                                    </div>
                                </div>
                            </div>


                            <div class="button-block">
                                <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>

                    </div>


                    <div id="CCForm2" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Cancel By">Implementor Review Comment</label>
                                        {{-- <input type="text" name="Imp_review_comm" value=""> --}}
                                        <textarea name="Imp_review_comm" id="" cols="30" rows=""></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Implementor Review Attachment">Implementor Review Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or Attached
                                                File</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Implementor_Attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile"
                                                    name="Implementor_Attachment[]"
                                                    oninput="addMultipleFiles(this, 'Implementor_Attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              

                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="submit">Submit</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <div id="CCForm3" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Cancel By">QA Review Comment</label>
                                        {{-- <input type="text" name="qa_rev_comm" value=""> --}}
                                        <textarea name="qa_rev_comm" id="" cols="" rows=""></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Implementor Review Attachment">QA Review Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or Attached
                                                File</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="qa_rev_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile"
                                                    name="qa_rev_attachment[]"
                                                    oninput="addMultipleFiles(this, 'qa_rev_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              

                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>

                                <button type="submit">Submit</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <div id="CCForm4" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Cancel By">Cancel By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Cancel On">Cancel On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="group-input">
                                        <label for="Cancel Comment">Cancel Comment</label>
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
        var maxLength = 255;
        $('#docname').keyup(function() {
            var textlen = maxLength - $(this).val().length;
            $('#rchars').text(textlen);
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
    $(document).ready(function() {
        $('#CheckListAdd').click(function(e) {
            function generateTableRow(serialNumber) {

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="pmchecklist[' + serialNumber +
                    '][serial]" value="' + serialNumber +
                    '"></td>' +
                    '<td><input type="text" name="pmchecklist[' + serialNumber +
                    '][checkpoint]"></td>' +
                    '<td><input type="text" class="Document_Remarks" name="pmchecklist[' +
                    serialNumber + '][comment]"></td>' +


                    '</tr>';

                return html;
            }

            var tableBody = $('#responsibilty-table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>
@endsection
