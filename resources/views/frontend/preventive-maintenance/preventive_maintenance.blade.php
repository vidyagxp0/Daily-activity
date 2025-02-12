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
    </style>
  <script>
    $(document).ready(function() {
        $('#ObservationAdd').click(function(e) {
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

            var tableBody = $('#job-responsibilty-table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
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
                    {{ Helpers::getDivisionName(session()->get('division')) }} / Preventive Maintenance
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


            <div class="cctab">
                {{-- <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Equipment Information</button> --}}
                {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Qualification Details</button> --}}
                {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Calibration Details</button> --}}
                @if($parent_id)
                <button class="cctablinks" onclick="openCity(event, 'CCForm222')">
                    Equipment/Instrument Information
                </button>
            @endif
            
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">
                Preventive Maintenance Details
            </button>
            
                {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Spare Part Information</button> --}}
                {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Training Details</button> --}}
                {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm7')">Supervisor Review</button> --}}
                {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm8')">QA Review</button> --}}
                {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm9')">Equipment Retirement</button> --}}
                <button class="cctablinks" onclick="openCity(event, 'CCForm10')">Activity Log</button>
            </div>

            <div class="language-sleect d-flex" style="align-items: center; gap: 20px;">
                        <div>Select Language </div>
                        <div class="main-head" id="google_translate_element"></div>
                    </div>
            <form action="{{ route('preventivemaintenance_store') }}" method="POST" enctype="multipart/form-data">
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
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}/PM/{{ date('Y') }}/{{ $record_number }}">
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
                                            <input id="docname" type="text" name="short_description"
                                                maxlength="255" required>
                                            @component('frontend.forms.language-model')
                                            @endcomponent
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Zone">PM Schedule</label>
                                        <select name="pm_schedule">
                                            <option value="">Select PM Schedule</option>
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
                                        <label for="Last Preventive Maintenance Date">Last Preventive Maintenance
                                            Date</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="last_pm_date" readonly placeholder="DD-MMM-YYYY" />
                                            <input type="date" id="last_pm_date_checkdate" name="last_pm_date"
                                                max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'last_pm_date');checkDate('last_pm_date_checkdate','next_pm_date_checkdate')" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Next Preventive Maintenance Date">Next Preventive Maintenance
                                            Date</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="next_pm_date" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" id="next_pm_date_checkdate"
                                                name="next_pm_date"
                                                max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'next_pm_date');checkDate('last_pm_date_checkdate','next_pm_date_checkdate')" />
                                        </div>
                                    </div>
                                </div>


                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Corrective Action">PM Task Description</label>
                                        <textarea name="pm_task_description"></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="search">Unscheduled or Event Based Preventive Maintenance?</label>
                                        <select name="event_based_PM">
                                            <option value="">Select a value</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Corrective Action">Reason for Unscheduled or Event Based Preventive
                                            Maintenance</label>
                                        <textarea name="eventbased_pm_reason"></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Due">Event Reference No.</label>
                                        <input type="text" name="PMevent_refernce_no">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="PM Procedure Reference/Document">PM Procedure
                                            Reference/Document</label>
                                        <div><small class="text-primary">Please Attach all relevant or Attached
                                                File</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="pm_procedure_document"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="pm_procedure_document[]"
                                                    oninput="addMultipleFiles(this, 'pm_procedure_document')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Due">Performed By</label>
                                        <input type="text" name="pm_performed_by">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Corrective Action">Maintenance Comments/Observations</label>
                                        <textarea name="maintenance_observation"></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Due">Parts Replaced During Maintenance</label>
                                        <input type="text" name="replaced_parts">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Due">Maintenance Work Order Number</label>
                                        <input type="text" name="work_order_number">
                                    </div>
                                </div>

                                <div class="group-input">
                                    <label for="audit-agenda-grid">
                                        PM Checklist
                                        <button type="button" name="audit-agenda-grid" id="ObservationAdd">+</button>
                                        <span class="text-primary" data-bs-toggle="modal"
                                            data-bs-target="#observation-field-instruction-modal"
                                            style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                            (Launch Instruction)
                                        </span>
                                    </label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="job-responsibilty-table" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%;">Sr No.</th>
                                                    <th>Check Point</th>
                                                    <th>Comment</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input disabled type="text" name="pmchecklist[0][serial]" value="1"></td>
                                                    <td><input type="text" name="pmchecklist[0][checkpoint]"></td>
                                                    <td><input type="text" name="pmchecklist[0][comment]" ></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Due">Emergency Maintenance Flag</label>
                                        <input type="text" name="emergency_flag_maintenance">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Due">Cost of Maintenance</label>
                                        <input type="text" name="cost_of_maintenance">
                                    </div>
                                </div>

                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                {{-- <button type="button" class="nextButton" onclick="nextStep()">Next</button> --}}
                                <button type="button"> <a class="text-white"
                                        href="{{ url('rcms/qms-dashboard') }}">Exit</a> </button>
                            </div>
                        </div>
                    </div>


                    <div id="CCForm2" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">URS Description</label>
                                        <textarea name="urs_description" id="urs_description"></textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">Initial/Business/System Level Risk Assessment
                                            Details</label>
                                        <textarea name="system_level_risk_assessment_details" id="system_level_risk_assessment_details"></textarea>
                                    </div>
                                </div>

                                <div class="col-12 mb-4">
                                    <div class="group-input">
                                        <label for="agenda">
                                            Failure Mode and Effect Analysis
                                            <button type="button" name="agenda"
                                                onclick="addRootCauseAnalysisRiskAssessment('risk-assessment-risk-management')">+</button>
                                            <span class="text-primary" style="font-size: 0.8rem; font-weight: 400;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" style="width: 200%"
                                                id="risk-assessment-risk-management">
                                                <thead>
                                                    <tr>
                                                        <th>Row #</th>
                                                        <th>Risk Factor</th>
                                                        <th>Risk element </th>
                                                        <th>Probable cause of risk element</th>
                                                        <th>Existing Risk Controls</th>
                                                        <th>Initial Severity- H(3)/M(2)/L(1)</th>
                                                        <th>Initial Probability- H(3)/M(2)/L(1)</th>
                                                        <th>Initial Detectability- H(1)/M(2)/L(3)</th>
                                                        <th>Initial RPN</th>
                                                        <th>Risk Acceptance (Y/N)</th>
                                                        <th>Proposed Additional Risk control measure (Mandatory for Risk
                                                            elements having RPN>4)</th>
                                                        <th>Residual Severity- H(3)/M(2)/L(1)</th>
                                                        <th>Residual Probability- H(3)/M(2)/L(1)</th>
                                                        <th>Residual Detectability- H(1)/M(2)/L(3)</th>
                                                        <th>Residual RPN</th>
                                                        <th>Risk Acceptance (Y/N)</th>
                                                        <th>Mitigation proposal (Mention either CAPA reference number, IQ,
                                                            OQ or
                                                            PQ)</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Supporting Documents">Supporting Documents</label>
                                        <div><small class="text-primary">Please Attach all relevant or Attached
                                                File</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="supporting_documents"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="supporting_documents[]"
                                                    oninput="addMultipleFiles(this, 'supporting_documents')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">FRS Description</label>
                                        <textarea name="frs_description" id="frs_description"></textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="FRS Attachment">FRS Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or Attached
                                                File</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="frs_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="frs_attachment[]"
                                                    oninput="addMultipleFiles(this, 'frs_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">Functional Risk Assessment Details</label>
                                        <textarea name="functional_risk_assessment_details" id="functional_risk_assessment_details"></textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="sub-head">Installation Qualification (IQ)</div>
                                    <div class="group-input">
                                        <label for="Type">IQ Test Plan</label>
                                        <select name="iq_test_plan" id="iq_test_plan">
                                            <option value="">-- Select --</option>
                                            <option value="Electrical">Electrical</option>
                                            <option value="Mechanical">Mechanical</option>
                                            <option value="Environmental">Environmental</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">IQ Protocol</label>
                                        <input name="iq_protocol" id="iq_protocol"></input>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">IQ Execution</label>
                                        <input name="iq_execution" id="iq_execution"></input>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">IQ Report</label>
                                        <input name="iq_report" id="iq_report"></input>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Equipment Qualification Attachment">Equipment Qualification
                                            Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or Attached
                                                File</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="iq_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="iq_attachment[]"
                                                    oninput="addMultipleFiles(this, 'iq_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="sub-head">Design Qualification (DQ)</div>
                                    <div class="group-input">
                                        <label for="Type">DQ Test Plan</label>
                                        <select name="dq_test_plan" id="dq_test_plan">
                                            <option value="">-- Select --</option>
                                            <option value="Electrical">Electrical</option>
                                            <option value="Mechanical">Mechanical</option>
                                            <option value="Environmental">Environmental</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">DQ Protocol</label>
                                        <input name="dq_protocol" id="dq_protocol"></input>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">DQ Execution</label>
                                        <input name="dq_execution" id="dq_execution"></input>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">DQ Report</label>
                                        <input name="dq_report" id="dq_report"></input>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Equipment Qualification Attachment">Equipment Qualification
                                            Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or Attached
                                                File</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="dq_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="dq_attachment[]"
                                                    oninput="addMultipleFiles(this, 'dq_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="sub-head">Operational Qualification (OQ)</div>
                                    <div class="group-input">
                                        <label for="Description">OQ Test Plan</label>
                                        <input name="oq_test_plan" id="oq_test_plan"></input>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">OQ Protocol</label>
                                        <input name="oq_protocol" id="oq_protocol"></input>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">OQ Execution</label>
                                        <input name="oq_execution" id="oq_execution"></input>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">OQ Report</label>
                                        <input name="oq_report" id="oq_report"></input>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Equipment Qualification Attachment">Equipment Qualification
                                            Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or Attached
                                                File</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="oq_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="oq_attachment[]"
                                                    oninput="addMultipleFiles(this, 'oq_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="sub-head">Performance Qualification (PQ)</div>
                                    <div class="group-input">
                                        <label for="Description">PQ Test Plan</label>
                                        <input name="pq_test_plan" id="pq_test_plan"></input>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">PQ Protocol</label>
                                        <input name="pq_protocol" id="pq_protocol"></input>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">PQ Execution</label>
                                        <input name="pq_execution" id="pq_execution"></input>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">PQ Report</label>
                                        <input name="pq_report" id="pq_report"></input>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Equipment Qualification Attachment">Equipment Qualification
                                            Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or Attached
                                                File</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="pq_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="pq_attachment[]"
                                                    oninput="addMultipleFiles(this, 'pq_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">Migration Details</label>
                                        <textarea name="migration_details" id="migration_details"></textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Migration Attachment">Migration Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or Attached
                                                File</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="migration_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="migration_attachment[]"
                                                    oninput="addMultipleFiles(this, 'migration_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">Configuration Specification Details</label>
                                        <textarea name="configuration_specification_details" id="configuration_specification_details"></textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Configuration Specification Attachment">Configuration Specification
                                            Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or Attached
                                                File</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="configuration_specification_attachment">
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile"
                                                    name="configuration_specification_attachment[]"
                                                    oninput="addMultipleFiles(this, 'configuration_specification_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">Rquirement Traceability Details</label>
                                        <textarea name="requirement_traceability_details" id="requirement_traceability_details"></textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Requirement Traceability Attachment">Requirement Traceability
                                            Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or Attached
                                                File</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="requirement_traceability_attachment">
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile"
                                                    name="requirement_traceability_attachment[]"
                                                    oninput="addMultipleFiles(this, 'requirement_traceability_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">Validation Summary Report</label>
                                        <textarea name="validation_summary_report" id="validation_summary_report"></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Periodic Qualification Pending On">Periodic Qualification Pending
                                            On</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="periodic_qualification_pending_on" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" id="periodic_qualification_pending_on_checkdate"
                                                name="periodic_qualification_pending_on"
                                                max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'periodic_qualification_pending_on');checkDate('periodic_qualification_pending_on_checkdate','periodic_qualification_pending_on1_checkdate')" />
                                        </div>
                                    </div>
                                </div>


                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">Periodic Qualification Notification (Days)</label>
                                        <input name="periodic_qualification_notification"
                                            id="periodic_qualification_notification"></input>
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


                    <div id="CCForm3" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">

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
                                            <input type="text" id="last_calibration_date" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" id="last_calibration_date_checkdate"
                                                name="last_calibration_date"
                                                max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'last_calibration_date');checkDate('last_calibration_date_checkdate','next_calibration_date_checkdate')" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Next Calibration Date">Next Calibration Date</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="next_calibration_date" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" id="next_calibration_date_checkdate"
                                                name="next_calibration_date"
                                                max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'next_calibration_date');checkDate('last_calibration_date_checkdate','next_calibration_date_checkdate')" />
                                        </div>
                                    </div>
                                </div>



                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Details">Calibration Due Reminder</label>
                                        <input type="text" name="calibration_due_reminder">
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
                                        <input type="text" name="event_refernce_no">
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
                                        <input type="text" name="calibration_certificate_result">
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


                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Details">Calibration Comments/Observations</label>
                                        <textarea name="calibration_comments"></textarea>
                                    </div>
                                </div>

                                <div class="button-block">
                                    <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                                    <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                    <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                            class="text-white"> Exit </a> </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Water Consumption Detail ****************************-->
                    <div id="CCForm4" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                               
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
                                <div class="col-12 mb-4">
                                    <div class="group-input">
                                        <label for="hazop">
                                            Spare Part Information
                                            <button type="button" name="hazop"
                                                onclick="addSparePartInformation('Spare-Part-Information')">+</button>
                                            <span class="text-primary" style="font-size: 0.8rem; font-weight: 400;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" style="width: 200%"
                                                id="Spare-Part-Information">
                                                <thead>
                                                    <tr style="text-align: center; vertical-align: middle; padding: 20px;">
                                                        <th rowspan="3">Row #</th>
                                                        <th colspan="34" rowspan="2">Spare Part Details</th>
                                                        <th colspan="22" rowspan="2">Inventory Information</th>
                                                        <th colspan="14" rowspan="2">Supplier Information</th>
                                                        <th colspan="2" rowspan="3">Action</th>

                                                    </tr>
                                                    <tr style="text-align: center; vertical-align: middle; padding: 20px;">

                                                    </tr>

                                                    <tr style="text-align: center; vertical-align: middle; padding: 20px;">
                                                        <th colspan="2">Equipment Name</th>
                                                        <th colspan="2">Equipment ID</th>
                                                        <th colspan="2">Part ID/Code</th>
                                                        <th colspan="2">Part Name/Description</th>
                                                        <th colspan="2">Manufacturer</th>
                                                        <th colspan="2">Model/Type Number</th>
                                                        <th colspan="2">Serial Number</th>
                                                        <th colspan="2">OEM (Original Equipment Manufacturer)</th>
                                                        <th colspan="2">Part Category</th>
                                                        <th colspan="2">Part Group</th>
                                                        <th colspan="2">Part Dimensions</th>
                                                        <th colspan="2">Material/Composition</th>
                                                        <th colspan="2">Weight</th>
                                                        <th colspan="2">Color</th>
                                                        <th colspan="2">Part Lifecycle Stage</th>
                                                        <th colspan="2">Part Status</th>
                                                        <th colspan="2">Availability</th>

                                                        <th colspan="2">Quantity on Hand</th>
                                                        <th colspan="2">Quantity on Order</th>
                                                        <th colspan="2">Reorder Point</th>
                                                        <th colspan="2">Safety Stock</th>
                                                        <th colspan="2">Minimum Order Quantity</th>
                                                        <th colspan="2">Lead Time</th>
                                                        <th colspan="2">Stock Location</th>
                                                        <th colspan="2">Bin Number</th>
                                                        <th colspan="2">Stock Keeping Unit (SKU)</th>
                                                        <th colspan="2">Lot Number/Batch Number</th>
                                                        <th colspan="2">Expiry Date</th>

                                                        <th colspan="2">Supplier/Vendor Name</th>
                                                        <th colspan="2">Supplier Contact Information</th>
                                                        <th colspan="2">Supplier Lead Time</th>
                                                        <th colspan="2">Supplier Price</th>
                                                        <th colspan="2">Supplier Part Number</th>
                                                        <th colspan="2">Supplier Warranty Information</th>
                                                        <th colspan="2">Supplier Performance Metrics</th>
                                                    </tr>



                                                </thead>
                                                <tbody>
                                                    <!-- Rows of data will go here, similar to the format shown in the provided image -->
                                                </tbody>
                                            </table>
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



                    <!-- Emission to Water ****************************-->
                    <div id="CCForm6" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="search">Training Required?</label>
                                        <select name="training_required">
                                            <option value="">Select a value</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Corrective Action">Training Description</label>
                                        <textarea name="trining_description"></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator">Training Type</label>
                                        <input type="text" name="training_type">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Training Attachment">Training Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or Attached
                                                File</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="training_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="training_attachment[]"
                                                    oninput="addMultipleFiles(this, 'training_attachment')" multiple>
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
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Corrective Action">Supervisor Review Comments</label>
                                        <textarea name="supervisor_comment"></textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Supervisor Documents">Supervisor Documents</label>
                                        <div><small class="text-primary">Please Attach all relevant or Attached
                                                File</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Supervisor_document"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="Supervisor_document[]"
                                                    oninput="addMultipleFiles(this, 'Supervisor_document')" multiple>
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
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Corrective Action">QA Review Comments</label>
                                        <textarea name="QA_comment"></textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="QA Documents">QA Documents</label>
                                        <div><small class="text-primary">Please Attach all relevant or Attached
                                                File</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="QA_document"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="QA_document[]"
                                                    oninput="addMultipleFiles(this, 'QA_document')" multiple>
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
                                        <label for="Equipment Lifecycle Stage">Equipment Lifecycle Stage</label>
                                        <select name="Equipment_Lifecycle_Stage">
                                            <option value="">Select a value</option>
                                            <option value="In-use">In-use</option>
                                            <option value="Out-of-service">Out-of-service</option>
                                            <option value="Retired">Retired</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Expected Useful Life">Expected Useful Life</label>
                                        <textarea name="Expected_Useful_Life"></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="End-of-life Date">End-of-life Date</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="End_of_life_Date" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" id="End_of_life_Date_checkdate" name="End_of_life_Date"
                                                max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'End_of_life_Date');checkDate('End_of_life_Date_checkdate','End_of_life_Date1_checkdate')" />
                                        </div>
                                    </div>
                                </div>


                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Decommissioning and Disposal Records">Decommissioning and Disposal
                                            Records</label>
                                        <textarea name="Decommissioning_and_Disposal_Records"></textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Replacement History">Replacement History</label>
                                        <textarea name="Replacement_History"></textarea>
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
                                <div class="col-lg-4">
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
                                </div>
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
     <script>
        $(document).ready(function() {
            $('#audit_program').click(function(e) {
                function generateTableRow(serialNumber) {
                    var users = @json($users);
                    console.log(users);
                    var html =
                    '<tr>' +'<td><input disabled type="text" name="serial_number[]" value="' + serialNumber + '"></td>' +
                        '<td><input type="text" name="checkpoint[]"></td>' +
                        '<td><input type="text" name="comment[]"></td>' +
                        '</tr>';

                    return html;
                }

                var tableBody = $('#audit_program_body tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>
@endsection
