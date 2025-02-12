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
                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="stoke_info[' + serialNumber + '][serial]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="stoke_info[' + serialNumber + '][Batch]"></td>' +
                    '<td> <select name="stoke_info[' + serialNumber + '][storage_location]">' +
                        '       <option>Select Storage</option>' +
                        '       <option value="Fridge">Fridge</option>' +
                        '       <option value="Freezer">Freezer</option>' +
                    '       <option value="Room Temperature">Room Temperature</option>' +
                    '</select></td>'+
                    '<td><input type="text" name="stoke_info[' + serialNumber + '][storage_condition]"></td>' +
                    '<td><select name="stoke_info[' + serialNumber + '][container_type]">' +
                        '<option>Select Container</option>' +
                        '<option value="Cryovial">Cryovial</option>' +
                        '<option value="IV Bag">IV Bag</option>' +
                        '<option value="Sterile Container">Sterile Container</option>' +
                        '<option value="Desiccator Jar">Desiccator Jar</option>' +
                        '<option value="Microtube">Microtube</option>' +
                    '</select></td>' +
                    '<td><input type="text" name="stoke_info[' + serialNumber + '][shelf_life]"></td>' +
                    '<td><input type="text" name="stoke_info[' + serialNumber + '][handling_instruction]"></td>' +
                    '<td><input type="text" name="stoke_info[' + serialNumber + '][supplier_name]"></td>' +
                    '<td><input type="text" name="stoke_info[' + serialNumber + '][manufacturer_name]"></td>' +
                    '<td><input type="text" name="stoke_info[' + serialNumber + '][supplier_contact]"></td>' +
                    '<td><input type="text" name="stoke_info[' + serialNumber + '][supplier_lot]"></td>' +
                    '<td><input type="text" class="initial-quantity" name="stoke_info[' + serialNumber + '][initial_quality]"></td>'+
                    '<td><select name="stoke_info[' + serialNumber + '][unit]">' +
                    '       <option>Select Unit</option>' +
                    '       <option value="Pieces">Pieces</option>' +
                    '       <option value="Kilograms">Kilograms</option>' +
                    '       <option value="Liters">Liters</option>' +
                    '       <option value="Meters">Meters</option>' +
                    '       <option value="Cubic Meters">Cubic Meters</option>' +
                    '       <option value="Grams">Grams</option>' +
                    '       <option value="Milliliters">Milliliters</option>' +
                    '       <option value="Dozens">Dozens</option>' +
                    '       <option value="Percent ">Percent </option>' +
                    '</select></td>' +
                    '<td><input type="text" name="stoke_info[' + serialNumber + '][reagent_name]"></td>' +
                    '<td><input type="text" name="stoke_info[' + serialNumber + '][reagent_code]"></td>' +
                    '<td><select name="stoke_info[' + serialNumber + '][Grade_Purity]">' +
                        '<option>Select Grade/Purity</option>' +
                        '<option value="AR">AR</option>' +
                        '<option value="HPLC">HPLC</option>' +
                        '<option value="GC">GC</option>' +
                        '<option value="ACS">ACS</option>' +
                        '<option value="Spectroscopy">Spectroscopy</option>' +
                    '</select></td>' +
                    '<td><select name="stoke_info[' + serialNumber + '][Physical_form]">' +
                        '<option>Select Physical Form</option>' +
                        '<option value="Solid">Solid</option>' +
                        '<option value="Liquid">Liquid</option>' +
                        '<option value="Gas">Gas</option>' +
                    '</select></td>' +
                    '<td><select name="stoke_info[' + serialNumber + '][Hazard_classification]">' +
                        '<option>Select Hazard Classification</option>' +
                        '<option value="Flammable">Flammable</option>' +
                        '<option value="Toxic">Toxic</option>' +
                        '<option value="Corrosive">Corrosive</option>' +
                        '<option value="Reactive">Reactive</option>' +
                        '<option value="Oxidizing">Oxidizing</option>' +
                        '<option value="Carcinogenic">Carcinogenic</option>' +
                        '<option value="Mutagenic">Mutagenic</option>' +
                        '<option value="Teratogenic">Teratogenic</option>' +
                        '<option value="Sensitizer">Sensitizer</option>' +
                    '</select></td>' +
                    '<td><input type="text" class="used-quantity" name="stoke_info[' + serialNumber + '][used_quality]"></td>' +
                    '<td><input type="text" class="datepicker" name="stoke_info[' + serialNumber + '][usage_date]" placeholder="DD-MM-YYYY"></td>' +
                    '<td><input type="text" name="stoke_info[' + serialNumber + '][purpose_of_use]"></td>' +
                    '<td><input type="text" class="datepicker" name="stoke_info[' + serialNumber + '][expiry_date]" placeholder="DD-MM-YYYY"></td>' +
                    '<td><input type="text" class="datepicker" name="stoke_info[' + serialNumber + '][opened_date]" placeholder="DD-MM-YYYY"></td>' +
                    '<td> <select name="stoke_info[' + serialNumber + '][status]">' +
                    '       <option>Select Value</option>' +
                    '       <option value="Approved">Approved</option>' +
                    '       <option value="Expired">Expired</option>' +
                    '       <option value="Quarantined">Quarantined</option>' +
                    '       <option value="Under Test">Under Test</option>' +
                    '       <option value="Rejected">Rejected</option>' +
                    '   </select></td>' +
                    '<td><input type="text" name="stoke_info[' + serialNumber + '][cas_number]"></td>' +
                    '<td> <select name="stoke_info[' + serialNumber + '][another_location]">' +
                    '       <option>Select Value</option>' +
                    '       <option value="Yes">Yes</option>' +
                    '       <option value="No">No</option>' +
                    '   </select></td>' +
                    '<td><input type="text" name="stoke_info[' + serialNumber + '][stock_transfer]"></td>' +
                    '<td> <select name="stoke_info[' + serialNumber + '][new_location]">' +
                    '       <option>Select Value</option>' +
                    '       <option value="Corporate Quality Assurance (CQA)">Corporate Quality Assurance (CQA)</option>' +
                    '       <option value="Plant 1">Plant 1</option>' +
                    '       <option value="Plant 2">Plant 2</option>' +
                    '       <option value="Plant 3">Plant 3</option>' +
                    '       <option value="Plant 4">Plant 4</option>' +
                    '       <option value="C1">C1</option>' +
                    '   </select></td>' +
                    '<td><input type="text" class="transfer-quantity" name="stoke_info[' + serialNumber + '][transfer_quality]"></td>' +
                    '<td><input type="text" class="remaining-quantity" name="stoke_info[' + serialNumber + '][remaining_quality]" readonly></td>' +
                    '<td><input type="text" name="stoke_info[' + serialNumber + '][distruction]"></td>' +
                    '<td><input type="text" class="datepicker" name="stoke_info[' + serialNumber + '][distruction_due_on]" placeholder="DD-MM-YYYY"></td>' +
                    '<td><input type="text" class="datepicker" name="stoke_info[' + serialNumber + '][distruction_date]" placeholder="DD-MM-YYYY"></td>' +
                    '<td><input type="text" name="stoke_info[' + serialNumber + '][distruction_by]"></td>' +
                    '<td><input type="text" class="Document_Remarks" name="stoke_info[' + serialNumber + '][Remarks]"></td>' +
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


            var newRowElement = tableBody.children('tr').last();
            var initialQtyInput = newRowElement.find('.initial-quantity');
            var usedQtyInput = newRowElement.find('.used-quantity');
            var transferQtyInput = newRowElement.find('.transfer-quantity');
            var remainingQtyInput = newRowElement.find('.remaining-quantity');

            function calculateRemainingQuantity() {
                var initialQty = parseFloat(initialQtyInput.val()) || 0;
                var usedQty = parseFloat(usedQtyInput.val()) || 0;
                var transferQty = parseFloat(transferQtyInput.val()) || 0;

                var remainingQty = initialQty - (usedQty + transferQty);
                remainingQtyInput.val(remainingQty >= 0 ? remainingQty : 0);
            }

            initialQtyInput.on('input', calculateRemainingQuantity);
            usedQtyInput.on('input', calculateRemainingQuantity);
            transferQtyInput.on('input', calculateRemainingQuantity);
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
                    {{ Helpers::getDivisionName(session()->get('division')) }} / Inventory Management
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
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Reagent/Item Information</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Supplier Details</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')"> Stock Information</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Usage Tracking</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Storage and Handling</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Safety and Compliance</button>
                {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm7')">Alerts and Notifications</button> --}}
                {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm8')">QA Review</button> --}}
                {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm9')">Equipment Retirement</button> --}}
                <button class="cctablinks" onclick="openCity(event, 'CCForm10')">Activity Log</button>
            </div>

            <div class="language-sleect d-flex" style="align-items: center; gap: 20px;">
                        <div>Select Language </div>
                        <div class="main-head" id="google_translate_element"></div>
                    </div>
            <form action="{{ route('inventorymanagment_store') }}" method="POST" enctype="multipart/form-data">
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
                                <div class="col-lg-6">
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
                                        <label for="Zone">Status</label>
                                        <select name="status_gi" id="status_gi">
                                            <option value="">Select Status</option>
                                            <option value="Available">Available</option>
                                            <option value="Reserved">Reserved</option>
                                            <option value="In Use">In Use</option>
                                            <option value="Under Inspection">Under Inspection</option>
                                            <option value="Expired">Expired</option>
                                            <option value="Quarantined">Quarantined</option>
                                            <option value="Rejected">Rejected</option>
                                            <option value="Damaged">Damaged</option>
                                            <option value="Replenishment Pending">Replenishment Pending</option>
                                            <option value="Out of Stock">Out of Stock</option>
                                            <option value="Disposed">Disposed</option>
                                            <option value="Archived">Archived</option>
                                            <option value="On Hold">On Hold</option>
                                            <option value="Transferred">Transferred</option>
                                            <option value="Recalled">Recalled</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Reagent Name">Reagent/Item Name</label>
                                        <input type="text" name="reagent_name" id="reagent_name">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Reagent Code">Reagent/Item Code/ID</label>
                                        <input type="text" name="reagent_code" id="reagent_code">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Reagent Code">CAS Number</label>
                                        <input type="text" name="cas_number" id="cas_number">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Zone">Grade/Purity</label>
                                        <select name="geade_purity" id="geade_purity">
                                            <option value="">Select Grade/Purity</option>
                                            <option value="AR">AR</option>
                                            <option value="HPLC">HPLC</option>
                                            <option value="GC">GC</option>
                                            <option value="ACS">ACS</option>
                                            <option value="Spectroscopy">Spectroscopy</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Zone">Physical Form</label>
                                        <select name="physical_form" id="physical_form">
                                            <option value="">Select Physical Form</option>
                                            <option value="Solid">Solid</option>
                                            <option value="Liquid">Liquid</option>
                                            <option value="Gas">Gas</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Zone">Hazard Classification</label>
                                        <select name="hazard_classification" id="hazard_classification">
                                            <option value="">--Select--</option>
                                            <option value="Flammable">Flammable</option>
                                            <option value="Toxic">Toxic</option>
                                            <option value="Corrosive">Corrosive</option>
                                            <option value="Reactive">Reactive</option>
                                            <option value="Oxidizing">Oxidizing</option>
                                            <option value="Carcinogenic">Carcinogenic</option>
                                            <option value="Mutagenic">Mutagenic</option>
                                            <option value="Teratogenic">Teratogenic</option>
                                            <option value="Sensitizer">Sensitizer</option>
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


                    <div id="CCForm2" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Reagent Code">Supplier Name</label>
                                        <input type="text" name="supplier_name" id="supplier_name">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Corrective Action">Manufacturer Name</label>
                                        <input type="text" name="manufacturer_name" id="manufacturer_name">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Description">Supplier Contact Information</label>
                                        <textarea name="supplier_contact_info" id="supplier_contact_info"></textarea>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Description">Supplier Lot Number</label>
                                        <input type="text" name="supplier_lot_number" id="supplier_lot_number">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Certificate Analysis">Certificate of Analysis (CoA)</label>
                                        <div><small class="text-primary">Please Attach all relevant or Attached
                                                File</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="certificate_of_analysis"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="certificate_of_analysis[]"
                                                    oninput="addMultipleFiles(this, 'certificate_of_analysis')" multiple>
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
                            <div class="group-input">
                                <label style="display: flex; justify-content: space-between;" for="audit-agenda-grid">
                                   <div>
                                    Stock Information
                                    <button type="button" name="audit-agenda-grid" id="ObservationAdd">+</button>
                                    <span class="text-primary" data-bs-toggle="modal"
                                        data-bs-target="#observation-field-instruction-modal"
                                        style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                        (Launch Instruction)
                                    </span>
                                   </div>
                                    <div style="display: flex;" class="search-head">
                                        <div>
                                            <input type="text" id="searchInput" name="search_input" placeholder="Search content...">
        
                                        </div>
                                        <div>
                                            <p style="border: 1px solid black;border-radius: 5px; margin-left: 14px;" id="searchButton" class="btn">Search</p>
                                        </div>
                                      </div>
                                </label>
                                
                             
                               

                                <script>
                                    $('#searchButton').click(function(e) {
                                      e.preventDefault();
                                      console.log('starting search')
                                      const input = $('input[name=search_input]').val().toLowerCase();
                                      const table = document.querySelector("table");
                                      const rows = table.querySelectorAll("thead tr");
                                      let found = false;
                                  
                                      // Remove previous highlights
                                      table.querySelectorAll(".highlight").forEach(cell => {
                                        cell.classList.remove("highlight");
                                      });
                                  
                                      console.log('rowing search', input)
                                      // Search for the value
                                      for (const row of rows) {
                                        for (const cell of row.cells) {
                                            console.log('cell', cell)
                                            console.log('cell data', cell.textContent.toLowerCase())
                                          if (cell.textContent.toLowerCase().includes(input) && input !== "") {
                                            cell.classList.add("highlight"); // Highlight cell
                                  
                                            if (!found) {
                                                console.log('first cell found')
                                              // Scroll to the matching cell
                                              const container = document.querySelector(".table-container");
                                              const cellPosition = cell.getBoundingClientRect();
                                              const containerPosition = container.getBoundingClientRect();
                                  
                                              // Adjust scroll to bring the cell into view
                                              container.scrollTop += cellPosition.top - containerPosition.top - 50;
                                              container.scrollLeft += cellPosition.left - containerPosition.left - 50;
                                  
                                              found = true;
                                            }
                                          }
                                        }
                                      }
                                  
                                      if (!found && input !== "") {
                                        alert("No matches found!");
                                      }
                                    })
                                    
                                  </script>
                                
                                <div class="table-responsive table-container">
                                    <table class="table table-bordered " id="job-responsibilty-table" style="width: 100%;" >
                                        <thead>
                                            <tr  style="background-color: #f2f2f2; color: #333; text-align: center; font-weight: bold;">
                                                <th colspan="7" style="
                                                border: 1px solid #d6a354; 
                                                padding: 10px; 
                                                background: linear-gradient(to bottom, #f8e5b1, #e9b95d); 
                                                color: #333; 
                                                font-size: 18px; 
                                                font-weight: bold; 
                                                text-align: center; 
                                                /* border-radius: 20px;  */
                                                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);">
                                                Storage and Handling
                                            </th>
                                            <th colspan="4" style="
                                                border: 1px solid #787878; 
                                                padding: 10px; 
                                                background: linear-gradient(to bottom, #afafaf, #adadad); 
                                                color: #000; 
                                                font-size: 18px; 
                                                font-weight: bold; 
                                                text-align: center; 
                                                /* border-radius: 20px;  */
                                                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);">
                                                Inventory Management
                                            </th>
                                            <th colspan="19" style="
                                                border: 1px solid #d6a354; 
                                                padding: 10px; 
                                                background: linear-gradient(to bottom, #f8e5b1, #e9b95d); 
                                                color: #333; 
                                                font-size: 18px; 
                                                font-weight: bold; 
                                                text-align: center; 
                                                /* border-radius: 20px;  */
                                                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);">
                                                Reagent Information
                                            </th>
                                            <th colspan="6" style="
                                                border: 1px solid #ccc; 
                                                padding: 10px; 
                                                background: linear-gradient(to bottom, #f2f2f2, #d9d9d9); 
                                                color: #333; 
                                                font-size: 18px; 
                                                font-weight: bold; 
                                                text-align: center; 
                                                /* border-radius: 20px;  */
                                                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);">
                                                Destruction Instruction
                                            </th>
                                            
                                                
                                                
                                            </tr>
                                            <tr style="background-color: #000; text-align: center;">
                                                <th style="border: 1px solid #000; padding: 8px;" ><div style="width: 30px;">Sr No.</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Batch/Lot Number</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Storage Location</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Storage Conditions</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Container Type</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Shelf Life After Opening</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Handling Instructions</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Supplier Name</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Manufacturer Name</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Supplier Contact Information</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Supplier Lot/AR Number</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Initial Quantity</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Unit</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Reagent/Item Name</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Reagent/Item Code/ID</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Grade Purity</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Physical Form</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Hazard Classification</div></th>


                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Used Quantity</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Usage Date</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Purpose Of Use</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Reagent/Item Expiry Date</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Reagent/Item Opened Date</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Reagent/Item Status</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">CAS Number</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Transfer to Another Location?</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Reason for Stock Transfer</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">New Location</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Transfer Quantity</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Remaining Quantity</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Destruction Instruction</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Destruction Due On</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Destruction Date</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Destruction By</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Remarks</div></th>
                                                <th style="border: 1px solid #000; padding: 8px;"><div style="width: 100px;">Action</div></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input disabled type="text" name="stoke_info[0][serial]" value="1"></td>
                                                <td><input type="text" name="stoke_info[0][Batch]"></td>
                                                <td>
                                                    <select name="stoke_info[0][storage_location]">
                                                        <option>Select Storage</option>
                                                        <option value="Fridge">Fridge</option>
                                                        <option value="Freezer">Freezer</option>
                                                        <option value="Room Temperature">Room Temperature</option>
                                                    </select>
                                                </td>
                                                <td><input type="text" name="stoke_info[0][storage_condition]"></td>
                                                <td>
                                                    <select name="stoke_info[0][container_type]">
                                                        <option>Select Container</option>
                                                        <option value="Cryovial">Cryovial</option>
                                                        <option value="IV Bag">IV Bag</option>
                                                        <option value="Sterile Container">Sterile Container</option>
                                                        <option value="Desiccator Jar">Desiccator Jar</option>
                                                        <option value="Microtube">Microtube</option>
                                                    </select>
                                                </td>                                                
                                                <td><input type="text" name="stoke_info[0][shelf_life]"></td>
                                                <td><input type="text" name="stoke_info[0][handling_instruction]"></td>
                                                <td><input type="text" name="stoke_info[0][supplier_name]"></td>
                                                <td><input type="text" name="stoke_info[0][manufacturer_name]"></td>
                                                <td><input type="text" name="stoke_info[0][supplier_contact]"></td>
                                                <td><input type="text" name="stoke_info[0][supplier_lot]"></td>
                                                <td><input type="text" name="stoke_info[0][initial_quality]"></td>
                                                <td>
                                                    <select name="stoke_info[0][unit]">
                                                        <option value="">Select Unit</option>
                                                        <option value="Pieces">Pieces</option>
                                                        <option value="Kilograms">Kilograms</option>
                                                        <option value="Liters">Liters</option>
                                                        <option value="Meters">Meters</option>
                                                        <option value="Cubic Meters">Cubic Meters</option>
                                                        <option value="Grams">Grams</option>
                                                        <option value="Milliliters">Milliliters</option>
                                                        <option value="Dozens">Dozens</option>
                                                        <option value="Percent ">Percent </option>
                                                    </select>
                                                    <script>
                                                        $(document).ready(function () {
                                                            $(".datepicker").datepicker({
                                                                dateFormat: "d-M-yy" 
                                                            });
                                                        });
                                                    </script>
                                                </td>
                                                <td><input type="text" name="stoke_info[0][reagent_name]"></td>
                                                <td><input type="text" name="stoke_info[0][reagent_code]"></td>
                                                <td>
                                                    <select name="stoke_info[0][Grade_Purity]">
                                                        <option value="">Select Grade/Purity</option>
                                                        <option value="AR">AR</option>
                                                        <option value="HPLC">HPLC</option>
                                                        <option value="GC">GC</option>
                                                        <option value="ACS">ACS</option>
                                                        <option value="Spectroscopy">Spectroscopy</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="stoke_info[0][Physical_form]">
                                                        <option value="">Select Physical Form</option>
                                                        <option value="Solid">Solid</option>
                                                        <option value="Liquid">Liquid</option>
                                                        <option value="Gas">Gas</option>
                                                      </select>
                                                </td>
                                                <td>
                                                    <select name="stoke_info[0][Hazard_classification]">
                                                        <option value="">Select Hazard Classification</option>
                                                        <option value="Flammable">Flammable</option>
                                                        <option value="Toxic">Toxic</option>
                                                        <option value="Corrosive">Corrosive</option>
                                                        <option value="Reactive">Reactive</option>
                                                        <option value="Oxidizing">Oxidizing</option>
                                                        <option value="Carcinogenic">Carcinogenic</option>
                                                        <option value="Mutagenic">Mutagenic</option>
                                                        <option value="Teratogenic">Teratogenic</option>
                                                        <option value="Sensitizer">Sensitizer</option>
                                                      </select>
                                                </td>
                                                <td><input type="text" name="stoke_info[0][used_quality]" ></td>
                                                <td><input type="text" class="datepicker" name="stoke_info[0][usage_date]" placeholder="DD-MM-YYYY"></td>
                                                <td><input type="text" name="stoke_info[0][purpose_of_use]"></td>
                                                <td><input type="text" class="datepicker" name="stoke_info[0][expiry_date]" placeholder="DD-MM-YYYY"></td>
                                                <td><input type="text" class="datepicker" name="stoke_info[0][opened_date]" placeholder="DD-MM-YYYY"></td>
                                                <td>
                                                    <select name="stoke_info[0][status]">
                                                        <option value="">Select Status</option>
                                                        <option value="Approved">Approved</option>
                                                        <option value="Expired">Expired</option>
                                                        <option value="Quarantined">Quarantined</option>
                                                        <option value="Under Test">Under Test</option>
                                                        <option value="Rejected">Rejected</option>
                                                    </select>
                                                </td>
                                                <td><input type="text" name="stoke_info[0][cas_number]"></td>
                                                <td>
                                                    <select name="stoke_info[0][another_location]">
                                                        <option value="">Select Value</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                </td>
                                                <td><input type="text" name="stoke_info[0][stock_transfer]"></td>
                                                <td>
                                                    <select name="stoke_info[0][new_location]">
                                                        <option value="">Select Location</option>
                                                        <option value="Corporate Quality Assurance (CQA)">Corporate Quality Assurance (CQA)</option>
                                                        <option value="Plant 1">Plant 1</option>
                                                        <option value="Plant 2">Plant 2</option>
                                                        <option value="Plant 3">Plant 3</option>
                                                        <option value="Plant 4">Plant 4</option>
                                                        <option value="C1">C1</option>
                                                    </select>
                                                </td>
                                                <td><input type="text" name="stoke_info[0][transfer_quality]" placeholder="Transfer Quantity"></td>
                                                <td><input type="text" name="stoke_info[0][remaining_quality]" placeholder="Remaining Quantity" readonly></td>
                                                <td><input type="text" name="stoke_info[0][distruction]" ></td>
                                                <td><input type="text" class="datepicker" name="stoke_info[0][distruction_due_on]" placeholder="DD-MM-YYYY"></td>
                                                <td><input type="text" class="datepicker" name="stoke_info[0][distruction_date]" placeholder="DD-MM-YYYY"></td>
                                                <td><input type="text" name="stoke_info[0][distruction_by]" ></td>
                                                <td><input type="text" name="stoke_info[0][Remarks]" ></td>
                                                <td><button type="button" class="btn btn-danger remove-row">Remove</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
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
                        // Wait until the DOM content is fully loaded
                        document.addEventListener('DOMContentLoaded', function () {
                            // Get references to the input fields
                            const initialQtyInput = document.querySelector('input[name="stoke_info[0][initial_quality]"]');
                            const usedQtyInput = document.querySelector('input[name="stoke_info[0][used_quality]"]');
                            const transferQtyInput = document.querySelector('input[name="stoke_info[0][transfer_quality]"]');
                            const remainingQtyInput = document.querySelector('input[name="stoke_info[0][remaining_quality]"]');
                
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
                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Next Preventive Maintenance Date">Usage Date</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="usage_date" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" id="usage_date_checkdate"
                                                name="usage_date"
                                                max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'usage_date');checkDate('last_pm_date_checkdate','usage_date_checkdate')" />
                                        </div>
                                    </div>
                                </div>   
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Description">Purpose of Use</label>
                                        <textarea name="purpose_of_use" id="purpose_of_use"></textarea>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Description">Quantity Used</label>
                                        <input name="quality_used" id="quality_used"></input>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Type">Logged By (User/Analyst Name)</label>
                                        <select name="logged_by" id="logged_by">
                                            <option value="">-- Select --</option>
                                            <option value="User">User</option>
                                            <option value="Analyst Name">Analyst Name</option>
                                        </select>
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

                    <div id="CCForm5" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Type">Storage Conditions</label>
                                        <select name="storage_condition" id="storage_condition">
                                            <option value="">-- Select --</option>
                                            <option value="Temperature">Temperature</option>
                                            <option value="Humidity">Humidity</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Type">Container Type</label>
                                        <select name="container_type" id="container_type">
                                            <option value="">-- Select --</option>
                                            <option value="Glass">Glass</option>
                                            <option value="Plastic">Plastic</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Description">Shelf Life After Opening</label>
                                        <textarea name="shelf_life" id="shelf_life"></textarea>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Description">Handling Instructions</label>
                                        <textarea name="handling_instructions" id="handling_instructions"></textarea>
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



                    <!-- Emission to Water ****************************-->
                    <div id="CCForm6" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                          <div class="row">
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Certificate Analysis">Safety Data Sheet (SDS)</label>
                                    <div><small class="text-primary">Please Attach all relevant or Attached
                                            File</small></div>
                                    <div class="file-attachment-field">
                                        <div class="file-attachment-list" id="safety_date_sheet"></div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input type="file" id="myfile" name="safety_date_sheet[]"
                                                oninput="addMultipleFiles(this, 'safety_date_sheet')" multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Description">Risk Assessment Code</label>
                                    <input name="risk_assesment_code" id="risk_assesment_code"></input>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Description">Disposal Guidelines</label>
                                    <input name="disposal_guidelines" id="disposal_guidelines"></input>
                                </div>
                            </div>
                         
                            <div class="col-6">
                                <div class="group-input">
                                    <label for="Type">Regulatory Compliance Information</label>
                                    <select name="regualatory_info" id="regualatory_info">
                                        <option value="">-- Select --</option>
                                        <option value="GMP">GMP</option>
                                        <option value="GLP">GLP</option>
                                        <option value="GCP">GCP</option>
                                        <option value="FDA">FDA</option>
                                        <option value="EMA">EMA</option>
                                        <option value="ISO Standards">ISO Standards</option>
                                        <option value="ICH Guidelines">ICH Guidelines</option>
                                    </select>
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
@endsection
