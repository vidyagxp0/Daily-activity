@extends('frontend.rcms.layout.main_rcms')
@section('rcms_container')
    @php
        $users = DB::table('users')->select('id', 'name')->get();

    @endphp

    <style>
        #change-control-fields .inner-block .group-input table input, #change-control-fields .inner-block .group-input table select{
            border: 1px solid black;
            padding: 4px
        }
        
        #step-form>div {
            display: none
        }

        #step-form>div:nth-child(1) {
            display: block;
        }

        /* .hide-input {
            display: none !important;
        } */

        .remove-file {
            cursor: pointer;
        }
    </style>
     <style>
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
            font-family: Arial, sans-serif;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
        }
        th {
            color: white;
        }
    
        /* Storage and Handling */
        th.storage-header {
            background-color: #4CAF50; /* Green */
        }
        td.storage {
            background-color: #e8f5e9; /* Light Green */
        }
    
        /* Inventory Management */
        th.inventory-header {
            background-color: #2196F3; /* Blue */
        }
        td.inventory {
            background-color: #e3f2fd; /* Light Blue */
        }
    
        /* Reagent Information */
        th.reagent-header {
            background-color: #FF9800; /* Orange */
        }
        td.reagent {
            background-color: #fff3e0; /* Light Orange */
        }
    
        /* Destruction Instruction */
        th.destruction-header {
            background-color: #F44336; /* Red */
        }
        td.destruction {
            background-color: #ffebee; /* Light Red */
        }
    </style>
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

        .form-control {
            margin-bottom: 20px;
        }

        div[class^="VIp"] {
            display: none;
        }

        #change-control-view>div.container-fluid>div.inner-block.state-block>div.status>div>div {
            font-size: 12px;
        }
        .highlight {
      background-color: yellow!important;
      border: 2px solid orange!important;
      color: #000!important;
    }
        /* #change-control-view > div.container-fluid > div.inner-block.state-block > div.status > div > div.active{
                        font-size: 12px;

                    } */
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @if (Session::has('swal'))
        <script>
            swal("{{ Session::get('swal')['title'] }}", "{{ Session::get('swal')['message'] }}",
                "{{ Session::get('swal')['type'] }}")
        </script>
    @endif
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
                var currentDivisionName = "{{ Helpers::getDivisionName($equipment->division_id) }}";
                var inventoryGridNewLocation = "{{ $inventory_grid['new_location'] ?? '' }}";

                var options = '';
                if (currentDivisionName !== "Corporate Quality Assurance (CQA)") {
                    options += '<option value="Corporate Quality Assurance (CQA)" ' + 
                               (inventoryGridNewLocation === "Corporate Quality Assurance (CQA)" ? 'selected' : '') + '>Corporate Quality Assurance (CQA)</option>';
                }
                if (currentDivisionName !== "Plant 1") {
                    options += '<option value="Plant 1" ' + 
                               (inventoryGridNewLocation === "Plant 1" ? 'selected' : '') + '>Plant 1</option>';
                }
                if (currentDivisionName !== "Plant 2") {
                    options += '<option value="Plant 2" ' + 
                               (inventoryGridNewLocation === "Plant 2" ? 'selected' : '') + '>Plant 2</option>';
                }
                if (currentDivisionName !== "Plant 3") {
                    options += '<option value="Plant 3" ' + 
                               (inventoryGridNewLocation === "Plant 3" ? 'selected' : '') + '>Plant 3</option>';
                }
                if (currentDivisionName !== "Plant 4") {
                    options += '<option value="Plant 4" ' + 
                               (inventoryGridNewLocation === "Plant 4" ? 'selected' : '') + '>Plant 4</option>';
                }
                if (currentDivisionName !== "C1") {
                    options += '<option value="C1" ' + 
                               (inventoryGridNewLocation === "C1" ? 'selected' : '') + '>C1</option>';
                }

                var html = 
                  '<tr>' +
                    '<td><input disabled type="text" name="stoke_info[' + serialNumber + '][serial]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="stoke_info[' + serialNumber + '][Batch]"></td>' +
                    '<td><select name="stoke_info[' + serialNumber + '][storage_location]" class="storage-location">' +
                        '<option>Select Storage</option>' +
                        '<option value="Fridge">Fridge</option>' +
                        '<option value="Freezer">Freezer</option>' +
                        '<option value="Room Temperature">Room Temperature</option>' +
                    '</select></td>' +
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
                    '<td><input type="text" name="stoke_info[' + serialNumber + '][initial_quality]"></td>' +
                    '<td><select name="stoke_info[' + serialNumber + '][unit]">' +
                        '<option>Select Unit</option>' +
                        '<option value="Pieces">Pieces</option>' +
                        '<option value="Kilograms">Kilograms</option>' +
                        '<option value="Liters">Liters</option>' +
                        '<option value="Meters">Meters</option>' +
                        '<option value="Cubic Meters">Cubic Meters</option>' +
                        '<option value="Grams">Grams</option>' +
                        '<option value="Milliliters">Milliliters</option>' +
                        '<option value="Dozens">Dozens</option>' +
                        '<option value="Percent ">Percent </option>' +
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
                        '<option>Select Grade/Purity</option>' +
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
                    '<td><input type="text" name="stoke_info[' + serialNumber + '][used_quality]"></td>' +
                    '<td><input type="text" class="datepicker" name="stoke_info[' + serialNumber + '][usage_date]" placeholder="DD-MM-YYYY"></td>' +
                    '<td><input type="text" name="stoke_info[' + serialNumber + '][purpose_of_use]"></td>' +
                    '<td><input type="text" class="datepicker" name="stoke_info[' + serialNumber + '][expiry_date]" placeholder="DD-MM-YYYY"></td>' +
                    '<td><input type="text" class="datepicker" name="stoke_info[' + serialNumber + '][opened_date]" placeholder="DD-MM-YYYY"></td>' +
                    '<td><select name="stoke_info[' + serialNumber + '][status]">' +
                        '<option>Select Status</option>' +
                        '<option value="Approved">Approved</option>' +
                        '<option value="Expired">Expired</option>' +
                        '<option value="Quarantined">Quarantined</option>' +
                        '<option value="Under Test">Under Test</option>' +
                        '<option value="Rejected">Rejected</option>' +
                    '</select></td>' +
                    '<td><input type="text" name="stoke_info[' + serialNumber + '][cas_number]"></td>' +
                    '<td><select name="stoke_info[' + serialNumber + '][another_location]">' +
                        '<option>Select Value</option>' +
                        '<option value="Yes">Yes</option>' +
                        '<option value="No">No</option>' +
                    '</select></td>' +
                    '<td><input type="text" name="stoke_info[' + serialNumber + '][stock_transfer]"></td>' +
                    '<td><select name="stoke_info[' + serialNumber + '][new_location]">' +
                        '<option>Select Value</option>' +
                        options +
                    '</select></td>' +
                    '<td><input type="text" name="stoke_info[' + serialNumber + '][transfer_quality]"></td>' +
                    '<td><input type="text" name="stoke_info[' + serialNumber + '][remaining_quality]" class="remaining-quantity" readonly></td>' +
                    '<td><input type="text" name="stoke_info[' + serialNumber + '][distruction]"></td>' +
                    '<td><input type="text" class="datepicker" name="stoke_info[' + serialNumber + '][distruction_due_on]" placeholder="DD-MM-YYYY"></td>' +
                    '<td><input type="text" class="datepicker" name="stoke_info[' + serialNumber + '][distruction_date]" placeholder="DD-MM-YYYY"></td>' +
                    '<td><input type="text" name="stoke_info[' + serialNumber + '][distruction_by]"></td>' +
                    '<td><input type="text" class="Document_Remarks" name="stoke_info[' + serialNumber + '][Remarks]"></td>' +
                    '<td><button type="button" class="btn btn-danger remove-row">Remove</button></td>' +
                '</tr>';
                
                return html;
            }

            $('#job-responsibilty-table').on('click', '.remove-row', function() {
                    $(this).closest('tr').remove();
                    updateSerialNumbers();
            });

            var tableBody = $('#job-responsibilty-table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);

            var newRowElement = tableBody.children('tr').last();
            var initialQtyInput = newRowElement.find('[name$="[initial_quality]"]');
            var usedQtyInput = newRowElement.find('[name$="[used_quality]"]');
            var transferQtyInput = newRowElement.find('[name$="[transfer_quality]"]');
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

        $('#job-responsibilty-table').on('change', 'select[name^="stoke_info"]', function() {
           
        });
     });
</script>




    <div id="rcms_form-head">
        <div class="container-fluid">
            <div class="inner-block">


                <div class="slogan">
                    @php
                        $name = DB::table('q_m_s_divisions')
                            ->where('id', $data->id)
                            ->value('name');
                    @endphp
                    <strong>Site Division / Project </strong>:
                    {{ Helpers::getDivisionName($equipment->division_id) }} / Inventory Management
                </div>
            </div>
        </div>
    </div>

    <!-- /* Change Control View Data Fields */ -->

    <div id="change-control-view">
        <div class="container-fluid">

            <div class="inner-block state-block">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="language-sleect d-flex" style="align-items: center; gap: 20px;">
                        <div>Select Language </div>
                        <div class="main-head" id="google_translate_element"></div>
                    </div>

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

                    {{-- <div class="d-flex" style="gap:20px;">

                        <?php
                        $userRoles = DB::table('user_roles')->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => $data->division_id])->get();
                        $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                       ?>

                        <button class="button_theme1"> <a class="text-white"
                                href="{{ url('SanctionAuditTrail', $data->id) }}"> Audit Trail </a> </button>

                        @if ($equipment->stage == 1 && (in_array(13, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>
                        @else
                        @endif
                        <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/lims-dashboard') }}"> Exit
                            </a> </button>
                    </div> --}}
                    <div class="d-flex" style="gap:20px;">
                        @php
                            $userRoles = DB::table('user_roles')
                                ->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => $data->division_id])
                                ->get();
                            $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                        @endphp
                    
                        {{-- <button class="button_theme1" onclick="window.print();return false;" class="new-doc-btn">Print</button> --}}
                        <button class="button_theme1">
                            <a class="text-white" href="{{ url('InventoryAuditTrail', $data->id) }}">
                                Audit Trail
                            </a>
                        </button>
                    
                        @if ($data->stage == 1)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Submit
                            </button>
                        @elseif($data->stage == 2)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Review Complete
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Request More Info
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                                Child
                            </button>
                        @elseif($data->stage == 3)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Approval Completed
                            </button>
                        @elseif($data->stage == 4)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Complete Transferring 
                            </button>
                           
                        @elseif($data->stage == 5)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Stock Transfer
                            </button>    
                        @endif
                        <button class="button_theme1">
                            <a class="text-white" href="{{ url('rcms/lims-dashboard') }}">
                                Exit
                            </a>
                        </button>
                    </div>
                    

                    <div class="sticky-buttons">
                        <div>
                            <a type="button" class="" data-toggle="modal" data-target="#myModal3">
                                <svg width="18" height="24" viewBox="0 0 384 512" xmlns="http://www.w3.org/2000/svg">
                                    <path fill="#ffffff"
                                        d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34M332.1 128H256V51.9zM48 464V48h160v104c0 13.3 10.7 24 24 24h104v288zm220.1-208c-5.7 0-10.6 4-11.7 9.5c-20.6 97.7-20.4 95.4-21 103.5c-.2-1.2-.4-2.6-.7-4.3c-.8-5.1.3.2-23.6-99.5c-1.3-5.4-6.1-9.2-11.7-9.2h-13.3c-5.5 0-10.3 3.8-11.7 9.1c-24.4 99-24 96.2-24.8 103.7c-.1-1.1-.2-2.5-.5-4.2c-.7-5.2-14.1-73.3-19.1-99c-1.1-5.6-6-9.7-11.8-9.7h-16.8c-7.8 0-13.5 7.3-11.7 14.8c8 32.6 26.7 109.5 33.2 136c1.3 5.4 6.1 9.1 11.7 9.1h25.2c5.5 0 10.3-3.7 11.6-9.1l17.9-71.4c1.5-6.2 2.5-12 3-17.3l2.9 17.3c.1.4 12.6 50.5 17.9 71.4c1.3 5.3 6.1 9.1 11.6 9.1h24.7c5.5 0 10.3-3.7 11.6-9.1c20.8-81.9 30.2-119 34.5-136c1.9-7.6-3.8-14.9-11.6-14.9h-15.8z" />
                                </svg>
                            </a>
                        </div>
                       
                    </div>

                </div>
                {{-- <div class="status">
                   
                    @if ($data->stage == 0)
                        <div class="progress-bars">
                            <div class="bg-danger">Closed-Cancelled</div>
                        </div>
                    @else
                        <div class="progress-bars" style="margin-bottom: 16px;">
                            @if ($data->stage >= 1)
                                <div class="active">Opened</div>
                            @else
                                <div class="">Opened</div>
                            @endif
                            @if ($data->stage >= 2)
                                <div class="active bg-danger">Closed</div>
                            @else
                                <div class="">Closed</div>
                            @endif
                           
                        </div>
                    @endif
                </div> --}}
                <div class="status">
                    <div class="head">Current Status</div>
                    {{-- ------------------------------By Pankaj-------------------------------- --}}
                    @if ($data->stage == 0)
                    <div class="progress-bars">
                        <div class="bg-danger">Closed-Cancelled</div>
                    </div>
                @else
                    <div class="progress-bars d-flex">
                        @if ($data->stage >= 1)
                            <div class="active">Opened</div>
                        @else
                            <div class="">Opened</div>
                        @endif
                        @if ($data->stage >= 2)
                            <div class="active">Pending Review</div>
                        @else
                            <div class="">Pending Review</div>
                        @endif
                        @if ($data->stage >= 3)
                            <div class="active">Pending Approval</div>
                        @else
                            <div class="">Pending Approval</div>
                        @endif
                        @if ($data->stage == 4)
                            <div class="active">Stock Transferring</div>
                        @endif
                        @if ($data->stage >= 5)
                            <div class="bg-danger">Closed - Done</div>
                        @else
                            <div class="">Closed - Done</div>
                        @endif
                    </div>
                @endif
                


                </div>
                <br>
                <div class="top-block">
                    <div><strong> Record Name :&nbsp;</strong>Inventory Management</div>
                    <div><strong> Site :&nbsp;</strong>{{ Helpers::getDivisionName($data->division_id) }}</div>
                    <div><strong> Current Status :&nbsp;</strong>{{ $data->status }}</div>
                    <div><strong> Initiated By :&nbsp;</strong>{{ Helpers::getInitiatorName($data->initiator_id) }}</div>
                </div>
            </div>
            <div class="modal right fade" id="myModal3" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-titles ml-10">Inventory Management Workflow</h4>
                        </div>
                        <div style="" class="modal-body main-new-workflow">
                            <div class="button-box">
                                @if ($data->stage == 0)
                                    <div class="">
                                        <div class="mini_buttons bg-danger">Closed-Cancelled</div>
                                    </div>
                                @else
                                    @if ($data->stage >= 1 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                                        <div class="active">
                                            Opened
                                        </div>
                                    @else
                                        <div class="mini_buttons">Opened</div>
                                    @endif
                                    <div class="down-logo">
                                        <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..." class="w-100 h-100">
                                    </div>
                                    @if ($data->stage >= 2 && (in_array(14, $userRoleIds) || in_array(18, $userRoleIds)))
                                        <div class="active">
                                            Pending Review
                                        </div>
                                    @else
                                        <div class="mini_buttons">Pending Review</div>
                                    @endif
                                    <div class="down-logo">
                                        <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..." class="w-100 h-100">
                                    </div>
                                    @if ($data->stage >= 3 && (in_array(75, $userRoleIds) || in_array(18, $userRoleIds)))
                                        <div class="active">
                                            Pending Approval 
                                        </div>
                                    @else
                                        <div class="mini_buttons">Pending Approval </div>
                                    @endif
                                    <div class="down-logo">
                                        <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..." class="w-100 h-100">
                                    </div>
                                    @if ($data->stage >= 4 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                                        <div class="active">
                                            Stock Transferring
                                        </div>
                                    @else
                                        <div class="mini_buttons">Stock Transferring</div>
                                    @endif
                                    <div class="down-logo">
                                        <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..." class="w-100 h-100">
                                    </div>
                                    @if ($data->stage >= 5 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                                        <div class="active bg-danger">
                                            Closed - Done
                                        </div>
                                    @else
                                        <div class="mini_buttons">
                                            Closed - Done
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                        
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="control-list">
            @php
                $users = DB::table('users')->get();
            @endphp
            <div id="change-control-fields">
                <div class="container-fluid">
                    <!-- Tab links -->
                    <div class="cctab">
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Reagent/Item Information</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Supplier Details</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Stock Information</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Usage Tracking</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Storage and Handling</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Safety and Compliance</button>

                <button class="cctablinks" onclick="openCity(event, 'CCForm10')">Activity Log</button>
                    </div>

                    <form id="CCFormInput" action="{{ route('updateinventorymanagment', $data->id) }}" method="POST"
                        enctype="multipart/form-data">
                        <input type="hidden" name="stage" id="stage" value="{{ $data->stage }}">

                        @csrf
                        {{-- @method('PUT') --}}

                        <!-- Tab content -->
                        {{-- <div id="step-form"> --}}
                        <div>

                            <div id="CCForm1" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">

                                        <div class="col-lg-6">
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
                                                    {{ $equipment->stage == 0 || $equipment->stage == 9 ? 'disabled' : '' }}>
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
                                                    name="due_date"{{ $equipment->stage == 0 || $equipment->stage == 9 ? 'disabled' : '' }}>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Short Description">Short Description<span
                                                        class="text-danger">*</span></label><span id="rchars"
                                                    class="text-primary">255 </span><span class="text-primary"> characters
                                                    remaining</span>
                                                <div class="relative-container">
                                                    <input name="short_description" id="docname" type="text"
                                                        value="{{ $equipment->short_description }}" maxlength="255"
                                                        required
                                                        {{ $equipment->stage == 0 || $equipment->stage == 9 ? 'disabled' : '' }}>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Zone">Status</label>
                                                <select name="status_gi">
                                                    <option value="">Select Status</option>
                                                    <option value="Available" {{ $equipment->status_gi == 'Available' ? 'selected' : '' }}>Available</option>
                                                    <option value="Reserved" {{ $equipment->status_gi == 'Reserved' ? 'selected' : '' }}>Reserved</option>
                                                    <option value="In Use" {{ $equipment->status_gi == 'In Use' ? 'selected' : '' }}>In Use</option>
                                                    <option value="Under Inspection" {{ $equipment->status_gi == 'Under Inspection' ? 'selected' : '' }}>Under Inspection</option>
                                                    <option value="Expired" {{ $equipment->status_gi == 'Expired' ? 'selected' : '' }}>Expired</option>
                                                    <option value="Quarantined" {{ $equipment->status_gi == 'Quarantined' ? 'selected' : '' }}>Quarantined</option>
                                                    <option value="Rejected" {{ $equipment->status_gi == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                                    <option value="Damaged" {{ $equipment->status_gi == 'Damaged' ? 'selected' : '' }}>Damaged</option>
                                                    <option value="Out of Stock" {{ $equipment->status_gi == 'Out of Stock' ? 'selected' : '' }}>Out of Stock</option>
                                                    <option value="Replenishment Pending" {{ $equipment->status_gi == 'Replenishment Pending' ? 'selected' : '' }}>Replenishment Pending</option>
                                                    <option value="Disposed" {{ $equipment->status_gi == 'Disposed' ? 'selected' : '' }}>Disposed</option>
                                                    <option value="Archived" {{ $equipment->status_gi == 'Archived' ? 'selected' : '' }}>Archived</option>
                                                    <option value="On Hold" {{ $equipment->status_gi == 'On Hold' ? 'selected' : '' }}>On Hold</option>
                                                    <option value="Transferred" {{ $equipment->status_gi == 'Transferred' ? 'selected' : '' }}>Transferred</option>
                                                    <option value="Recalled" {{ $equipment->status_gi == 'Recalled' ? 'selected' : '' }}>Recalled</option>
                                                </select>
                                            </div>
                                        </div>   
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Reagent/Item Name</label>
                                                <input type="text" name="reagent_name" value="{{ $equipment->reagent_name }}">
                                            </div>
                                        </div> 
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Reagent/Item Code/ID</label>
                                                <input type="text" name="reagent_code" value="{{ $equipment->reagent_code }}">
                                            </div>
                                        </div> 
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">CAS Number</label>
                                                <input type="text" name="cas_number" value="{{ $equipment->cas_number }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Zone">Grade/Purity</label>
                                                <select name="geade_purity">
                                                    <option value="">Select Grade/Purity</option>
                                                    <option value="AR " {{ $equipment->geade_purity == 'AR ' ? 'selected' : '' }}>AR </option>
                                                    <option value="HPLC" {{ $equipment->geade_purity == 'HPLC' ? 'selected' : '' }}>HPLC</option>
                                                    <option value="GC" {{ $equipment->geade_purity == 'GC' ? 'selected' : '' }}>GC</option>  
                                                    <option value="ACS" {{ $equipment->geade_purity == 'ACS' ? 'selected' : '' }}>ACS</option>                                                   
                                                    <option value="Spectroscopy" {{ $equipment->geade_purity == 'Spectroscopy' ? 'selected' : '' }}>Spectroscopy</option>                                                   
                                                 
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Zone">Physical Form</label>
                                                <select name="physical_form">
                                                    <option value="">Select PM Schedule</option>
                                                    <option value="Solid" {{ $equipment->physical_form == 'Solid' ? 'selected' : '' }}>Solid</option>
                                                    <option value="Liquid" {{ $equipment->physical_form == 'Liquid' ? 'selected' : '' }}>Liquid</option>
                                                    <option value="Gas" {{ $equipment->physical_form == 'Gas' ? 'selected' : '' }}>Gas</option>                                                   
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Zone">Hazard Classification</label>
                                                <select name="hazard_classification">
                                                    <option value="">Select Hazard Classification</option>
                                                    <option value="Flammable" {{ $equipment->hazard_classification == 'Flammable' ? 'selected' : '' }}>Flammable</option>
                                                    <option value="Toxic" {{ $equipment->hazard_classification == 'Toxic' ? 'selected' : '' }}>Toxic</option>
                                                    <option value="Corrosive" {{ $equipment->hazard_classification == 'Corrosive' ? 'selected' : '' }}>Corrosive</option>    
                                                    <option value="Reactive" {{ $equipment->hazard_classification == 'Reactive' ? 'selected' : '' }}>Reactive</option>
                                                    <option value="Oxidizing" {{ $equipment->hazard_classification == 'Oxidizing' ? 'selected' : '' }}>Oxidizing</option>
                                                    <option value="Carcinogenic" {{ $equipment->hazard_classification == 'Carcinogenic' ? 'selected' : '' }}>Carcinogenic</option>    
                                                    <option value="Mutagenic" {{ $equipment->hazard_classification == 'Mutagenic' ? 'selected' : '' }}>Mutagenic</option>
                                                    <option value="Teratogenic" {{ $equipment->hazard_classification == 'Teratogenic' ? 'selected' : '' }}>Teratogenic</option>
                                                    <option value="Sensitizer" {{ $equipment->hazard_classification == 'Sensitizer' ? 'selected' : '' }}>Sensitizer</option>                                                   
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        {{-- <button type="button" class="nextButton" onclick="nextStep()">Next</button> --}}
                                        <button type="button"> <a class="text-white"
                                                href="{{ url('rcms/lims-dashboard') }}">Exit</a> </button>
                                    </div>
                                </div>
                            </div>
                           
        
                        
        
        
                            <div id="CCForm2" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Supplier Name</label>
                                                <input type="text" name="supplier_name" value="{{ $equipment->supplier_name }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Manufacturer Name</label>
                                                <input type="text" name="manufacturer_name" value="{{ $equipment->manufacturer_name }}">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Details">Supplier Contact Information</label>
                                                <textarea name="supplier_contact_info">{{ $equipment->supplier_contact_info }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Supplier Lot Number</label>
                                                <input type="text" name="supplier_lot_number" value="{{ $equipment->supplier_lot_number }}">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Calibration Procedure Reference/Document">Certificate of Analysis (CoA)</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="certificate_of_analysis">
                                                        @if ($equipment->certificate_of_analysis)
                                                            @foreach (json_decode($equipment->certificate_of_analysis) as $file)
                                                                <h6 type="button" class="file-container text-dark"
                                                                    style="background-color: rgb(243, 242, 240);">
                                                                    <b>{{ $file }}</b>
                                                                    <a href="{{ asset('upload/' . $file) }}"
                                                                        target="_blank"><i class="fa fa-eye text-primary"
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
                                                        <input
                                                            {{ $equipment->stage == 0 || $equipment->stage == 9 ? 'disabled' : '' }}
                                                            type="file" id="myfile" name="certificate_of_analysis[]"
                                                            oninput="addMultipleFiles(this, 'certificate_of_analysis')" multiple>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    
                                        <div class="button-block">
                                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                            <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                            <button type="button"> <a href="{{ url('rcms/lims-dashboard') }}"
                                                    class="text-white"> Exit </a> </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="CCForm3" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="pt-2 group-input">
                                        <label style="display: flex; justify-content: space-between;" for="audit-agenda-grid">
                                           <div>
                                            Stoke Information
                                            <button type="button" name="audit-agenda-grid" id="ObservationAdd" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }}>+</button>
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
                                            <table class="table table-bordered" id="job-responsibilty-table" style="width: 100%;">
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
                                                            border-radius: 20px; 
                                                            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);">
                                                            Storage and Handling
                                                        </th>
                                                        <th colspan="4" style="
                                                            border: 1px solid #169c4a; 
                                                            padding: 10px; 
                                                            background: linear-gradient(to bottom, #a4e5b1, #22a34a); 
                                                            color: #fff; 
                                                            font-size: 18px; 
                                                            font-weight: bold; 
                                                            text-align: center; 
                                                            border-radius: 20px; 
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
                                                            border-radius: 20px; 
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
                                                            border-radius: 20px; 
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
                                                            <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Grade/Purity</div></th>
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
                                                    @if ($InventoryManagement_grid && is_array($InventoryManagement_grid->data))
                                                        @foreach ($InventoryManagement_grid->data as $index => $inventory_grid)
                                                            <tr>
                                                                <td><input disabled type="text" name="stoke_info[{{ $loop->index }}][serial]" value="{{ $loop->index+1 }}"></td>
                                                                <td><input type="text" name="stoke_info[{{ $loop->index }}][Batch]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('Batch', $inventory_grid) ? $inventory_grid['Batch'] : '' }}"></td>
                                                                <td>
                                                                    <select name="stoke_info[{{ $loop->index }}][storage_location]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }}>
                                                                        <option>Select Storage</option>
                                                                        <option value="Fridge" {{ (array_key_exists('storage_location', $inventory_grid) && $inventory_grid['storage_location'] == 'Fridge') ? 'selected' : '' }}>Fridge</option>
                                                                        <option value="Freezer" {{ (array_key_exists('storage_location', $inventory_grid) && $inventory_grid['storage_location'] == 'Freezer') ? 'selected' : '' }}>Freezer</option>
                                                                        <option value="Room Temperature" {{ (array_key_exists('storage_location', $inventory_grid) && $inventory_grid['storage_location'] == 'Room Temperature') ? 'selected' : '' }}>Room Temperature</option>
                                                                    </select>
                                                                </td>
                                                                <td><input type="text" name="stoke_info[{{ $loop->index }}][storage_condition]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('storage_condition', $inventory_grid) ? $inventory_grid['storage_condition'] : '' }}"></td>
                                                                <td>
                                                                    <select name="stoke_info[{{ $loop->index }}][container_type]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }}>
                                                                        <option>Select Container</option>
                                                                        <option value="Cryovial" {{ (array_key_exists('container_type', $inventory_grid) && $inventory_grid['container_type'] == 'Cryovial') ? 'selected' : '' }}>Cryovial</option>
                                                                        <option value="IV Bag" {{ (array_key_exists('container_type', $inventory_grid) && $inventory_grid['container_type'] == 'IV Bag') ? 'selected' : '' }}>IV Bag</option>
                                                                        <option value="Sterile Container" {{ (array_key_exists('container_type', $inventory_grid) && $inventory_grid['container_type'] == 'Sterile Container') ? 'selected' : '' }}>Sterile Container</option>
                                                                        <option value="Desiccator Jar" {{ (array_key_exists('container_type', $inventory_grid) && $inventory_grid['container_type'] == 'Desiccator Jar') ? 'selected' : '' }}>Desiccator Jar</option>
                                                                        <option value="Microtube" {{ (array_key_exists('container_type', $inventory_grid) && $inventory_grid['container_type'] == 'Microtube') ? 'selected' : '' }}>Microtube</option>
                                                                    </select>
                                                                </td>                                                                
                                                                <td><input type="text" name="stoke_info[{{ $loop->index }}][shelf_life]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('shelf_life', $inventory_grid) ? $inventory_grid['shelf_life'] : '' }}"></td>
                                                                <td><input type="text" name="stoke_info[{{ $loop->index }}][handling_instruction]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('handling_instruction', $inventory_grid) ? $inventory_grid['handling_instruction'] : '' }}"></td>
                                                                <td><input type="text" name="stoke_info[{{ $loop->index }}][supplier_name]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('supplier_name', $inventory_grid) ? $inventory_grid['supplier_name'] : '' }}"></td>
                                                                <td><input type="text" name="stoke_info[{{ $loop->index }}][manufacturer_name]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('manufacturer_name', $inventory_grid) ? $inventory_grid['manufacturer_name'] : '' }}"></td>
                                                                <td><input type="text" name="stoke_info[{{ $loop->index }}][supplier_contact]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('supplier_contact', $inventory_grid) ? $inventory_grid['supplier_contact'] : '' }}"></td>
                                                                <td><input type="text" name="stoke_info[{{ $loop->index }}][supplier_lot]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('supplier_lot', $inventory_grid) ? $inventory_grid['supplier_lot'] : '' }}"></td>  
                                                                <td><input type="text" id="initial_quality_{{ $loop->index }}" name="stoke_info[{{ $loop->index }}][initial_quality]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('initial_quality', $inventory_grid) ? $inventory_grid['initial_quality'] : '' }}" oninput="calculateRemaining({{ $loop->index }})"></td>
                                                                <td>
                                                                    <select name="stoke_info[{{ $loop->index }}][unit]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }}>
                                                                        <option>Select Unit</option>
                                                                        <option value="Pieces" {{ (array_key_exists('unit', $inventory_grid) && $inventory_grid['unit'] == 'Pieces') ? 'selected' : '' }}>Pieces</option>
                                                                        <option value="Kilograms" {{ (array_key_exists('unit', $inventory_grid) && $inventory_grid['unit'] == 'Kilograms') ? 'selected' : '' }}>Kilograms</option>
                                                                        <option value="Liters" {{ (array_key_exists('unit', $inventory_grid) && $inventory_grid['unit'] == 'Liters') ? 'selected' : '' }}>Liters</option>
                                                                        <option value="Meters" {{ (array_key_exists('unit', $inventory_grid) && $inventory_grid['unit'] == 'Meters') ? 'selected' : '' }}>Meters</option>
                                                                        <option value="Cubic Meters" {{ (array_key_exists('unit', $inventory_grid) && $inventory_grid['unit'] == 'Cubic Meters') ? 'selected' : '' }}>Cubic Meters</option>
                                                                        <option value="Grams" {{ (array_key_exists('unit', $inventory_grid) && $inventory_grid['unit'] == 'Grams') ? 'selected' : '' }}>Grams</option>
                                                                        <option value="Milliliters" {{ (array_key_exists('unit', $inventory_grid) && $inventory_grid['unit'] == 'Milliliters') ? 'selected' : '' }}>Milliliters</option>
                                                                        <option value="Dozens" {{ (array_key_exists('unit', $inventory_grid) && $inventory_grid['unit'] == 'Dozens') ? 'selected' : '' }}>Dozens</option>
                                                                        <option value="Percent " {{ (array_key_exists('unit', $inventory_grid) && $inventory_grid['unit'] == 'Percent ') ? 'selected' : '' }}>Percent </option>
                                                                    </select>
                                                                </td>
                                                                <script>
                                                                    $(document).ready(function () {
                                                                        $(".datepicker").datepicker({
                                                                            dateFormat: "d-M-yy" 
                                                                        });
                                                                    });
                                                                </script>
                                                                <td><input type="text" name="stoke_info[{{ $loop->index }}][reagent_name]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('reagent_name', $inventory_grid) ? $inventory_grid['reagent_name'] : '' }}"></td>
                                                                <td><input type="text" name="stoke_info[{{ $loop->index }}][reagent_code]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('reagent_code', $inventory_grid) ? $inventory_grid['reagent_code'] : '' }}"></td>
                                                                <td>
                                                                    <select name="stoke_info[{{ $loop->index }}][Grade_Purity]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }}>
                                                                        <option>Select Grade/Purity</option>
                                                                        <option value="AR" {{ (array_key_exists('Grade_Purity', $inventory_grid) && $inventory_grid['Grade_Purity'] == 'AR') ? 'selected' : '' }}>AR</option>
                                                                        <option value="HPLC" {{ (array_key_exists('Grade_Purity', $inventory_grid) && $inventory_grid['Grade_Purity'] == 'HPLC') ? 'selected' : '' }}>HPLC</option>
                                                                        <option value="GC" {{ (array_key_exists('Grade_Purity', $inventory_grid) && $inventory_grid['Grade_Purity'] == 'GC') ? 'selected' : '' }}>GC</option>
                                                                        <option value="ACS" {{ (array_key_exists('Grade_Purity', $inventory_grid) && $inventory_grid['Grade_Purity'] == 'ACS') ? 'selected' : '' }}>ACS</option>
                                                                        <option value="Spectroscopy" {{ (array_key_exists('Grade_Purity', $inventory_grid) && $inventory_grid['Grade_Purity'] == 'Spectroscopy') ? 'selected' : '' }}>Spectroscopy</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select name="stoke_info[{{ $loop->index }}][Physical_form]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }}>
                                                                        <option>Select Grade/Purity</option>
                                                                        <option value="Solid" {{ (array_key_exists('Physical_form', $inventory_grid) && $inventory_grid['Physical_form'] == 'Solid') ? 'selected' : '' }}>Solid</option>
                                                                        <option value="Liquid" {{ (array_key_exists('Physical_form', $inventory_grid) && $inventory_grid['Physical_form'] == 'Liquid') ? 'selected' : '' }}>Liquid</option>
                                                                        <option value="Gas" {{ (array_key_exists('Physical_form', $inventory_grid) && $inventory_grid['Physical_form'] == 'Gas') ? 'selected' : '' }}>Gas</option>
                                                                        </select>
                                                                </td> 
                                                                <td>
                                                                    <select name="stoke_info[{{ $loop->index }}][Hazard_classification]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }}>
                                                                        <option>Select Hazard Classification</option>
                                                                        <option value="Flammable" {{ (array_key_exists('Hazard_classification', $inventory_grid) && $inventory_grid['Hazard_classification'] == 'Flammable') ? 'selected' : '' }}>Flammable</option>
                                                                        <option value="Toxic" {{ (array_key_exists('Hazard_classification', $inventory_grid) && $inventory_grid['Hazard_classification'] == 'Toxic') ? 'selected' : '' }}>Toxic</option>
                                                                        <option value="Corrosive" {{ (array_key_exists('Hazard_classification', $inventory_grid) && $inventory_grid['Hazard_classification'] == 'Corrosive') ? 'selected' : '' }}>Corrosive</option>
                                                                        <option value="Reactive" {{ (array_key_exists('Hazard_classification', $inventory_grid) && $inventory_grid['Hazard_classification'] == 'Reactive') ? 'selected' : '' }}>Reactive</option>
                                                                        <option value="Oxidizing" {{ (array_key_exists('Hazard_classification', $inventory_grid) && $inventory_grid['Hazard_classification'] == 'Oxidizing') ? 'selected' : '' }}>Oxidizing</option>
                                                                        <option value="Carcinogenic" {{ (array_key_exists('Hazard_classification', $inventory_grid) && $inventory_grid['Hazard_classification'] == 'Carcinogenic') ? 'selected' : '' }}>Carcinogenic</option>
                                                                        <option value="Mutagenic" {{ (array_key_exists('Hazard_classification', $inventory_grid) && $inventory_grid['Hazard_classification'] == 'Mutagenic') ? 'selected' : '' }}>Mutagenic</option>
                                                                        <option value="Teratogenic" {{ (array_key_exists('Hazard_classification', $inventory_grid) && $inventory_grid['Hazard_classification'] == 'Teratogenic') ? 'selected' : '' }}>Teratogenic</option>
                                                                        <option value="Sensitizer" {{ (array_key_exists('Hazard_classification', $inventory_grid) && $inventory_grid['Hazard_classification'] == 'Sensitizer') ? 'selected' : '' }}>Sensitizer</option>
                                                                        
                                                                    </select>
                                                                </td>
                                                                <td><input type="text" id="used_quality_{{ $loop->index }}" name="stoke_info[{{ $loop->index }}][used_quality]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('used_quality', $inventory_grid) ? $inventory_grid['used_quality'] : '' }}" oninput="calculateRemaining({{ $loop->index }})"></td>
                                                                <td><input type="text" class="datepicker" name="stoke_info[{{ $loop->index }}][usage_date]" placeholder="DD-MM-YYYY" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('usage_date', $inventory_grid) ? $inventory_grid['usage_date'] : '' }}"></td>
                                                                <td><input type="text" name="stoke_info[{{ $loop->index }}][purpose_of_use]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('purpose_of_use', $inventory_grid) ? $inventory_grid['purpose_of_use'] : '' }}"></td>
                                                                <td><input type="text" class="datepicker" name="stoke_info[{{ $loop->index }}][expiry_date]" placeholder="DD-MM-YYYY" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('expiry_date', $inventory_grid) ? $inventory_grid['expiry_date'] : '' }}"></td>
                                                                <td><input type="text" class="datepicker" name="stoke_info[{{ $loop->index }}][opened_date]" placeholder="DD-MM-YYYY" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('opened_date', $inventory_grid) ? $inventory_grid['opened_date'] : '' }}"></td>
                                                                <td>
                                                                    <select name="stoke_info[{{ $loop->index }}][status]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }}>
                                                                        <option>Select Value</option>
                                                                        <option value="Approved" {{ (array_key_exists('status', $inventory_grid) && $inventory_grid['status'] == 'Approved') ? 'selected' : '' }}>Approved</option>
                                                                        <option value="Expired" {{ (array_key_exists('status', $inventory_grid) && $inventory_grid['status'] == 'Expired') ? 'selected' : '' }}>Expired</option>
                                                                        <option value="Quarantined" {{ (array_key_exists('status', $inventory_grid) && $inventory_grid['status'] == 'Quarantined') ? 'selected' : '' }}>Quarantined</option>
                                                                        <option value="Under Test" {{ (array_key_exists('status', $inventory_grid) && $inventory_grid['status'] == 'Under Test') ? 'selected' : '' }}>Under Test</option>
                                                                        <option value="Rejected" {{ (array_key_exists('status', $inventory_grid) && $inventory_grid['status'] == 'Rejected') ? 'selected' : '' }}>Rejected</option>
                                                                    </select>
                                                                </td>
                                                                <td><input type="text" name="stoke_info[{{ $loop->index }}][cas_number]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('cas_number', $inventory_grid) ? $inventory_grid['cas_number'] : '' }}"></td>
                                                                <td>
                                                                    <select name="stoke_info[{{ $loop->index }}][another_location]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }}>
                                                                        <option>Select Value</option>
                                                                        <option value="Yes" {{ (array_key_exists('another_location', $inventory_grid) && $inventory_grid['another_location'] == 'Yes') ? 'selected' : '' }}>Yes</option>
                                                                        <option value="No" {{ (array_key_exists('another_location', $inventory_grid) && $inventory_grid['another_location'] == 'No') ? 'selected' : '' }}>No</option>
                                                                    </select>
                                                                </td>
                                                                <td><input type="text" name="stoke_info[{{ $loop->index }}][stock_transfer]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('stock_transfer', $inventory_grid) ? $inventory_grid['stock_transfer'] : '' }}"></td>
                                                                <td>
                                                                    <select name="stoke_info[{{ $loop->index }}][new_location]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }}>
                                                                        <option>Select Value</option>
                                                                        @if (Helpers::getDivisionName($equipment->division_id) != "Corporate Quality Assurance (CQA)")
                                                                        <option value="Corporate Quality Assurance (CQA)" 
                                                                            {{ (array_key_exists('new_location', $inventory_grid) && $inventory_grid['new_location'] == 'Corporate Quality Assurance (CQA)') ? 'selected' : '' }}>
                                                                            Corporate Quality Assurance (CQA)
                                                                        </option>
                                                                        @endif
                                                                        
                                                                        @if (Helpers::getDivisionName($equipment->division_id) != "Plant 1")
                                                                            <option value="Plant 1" 
                                                                                {{ (array_key_exists('new_location', $inventory_grid) && $inventory_grid['new_location'] == 'Plant 1') ? 'selected' : '' }}>
                                                                                Plant 1
                                                                            </option>
                                                                        @endif
                                                                        
                                                                        @if (Helpers::getDivisionName($equipment->division_id) != "Plant 2")
                                                                            <option value="Plant 2" 
                                                                                {{ (array_key_exists('new_location', $inventory_grid) && $inventory_grid['new_location'] == 'Plant 2') ? 'selected' : '' }}>
                                                                                Plant 2
                                                                            </option>
                                                                        @endif
                                                                        
                                                                        @if (Helpers::getDivisionName($equipment->division_id) != "Plant 3")
                                                                            <option value="Plant 3" 
                                                                                {{ (array_key_exists('new_location', $inventory_grid) && $inventory_grid['new_location'] == 'Plant 3') ? 'selected' : '' }}>
                                                                                Plant 3
                                                                            </option>
                                                                        @endif
                                                                        
                                                                        @if (Helpers::getDivisionName($equipment->division_id) != "Plant 4")
                                                                            <option value="Plant 4" 
                                                                                {{ (array_key_exists('new_location', $inventory_grid) && $inventory_grid['new_location'] == 'Plant 4') ? 'selected' : '' }}>
                                                                                Plant 4
                                                                            </option>
                                                                        @endif
                                                                        
                                                                        @if (Helpers::getDivisionName($equipment->division_id) != "C1")
                                                                            <option value="C1" 
                                                                                {{ (array_key_exists('new_location', $inventory_grid) && $inventory_grid['new_location'] == 'C1') ? 'selected' : '' }}>
                                                                                C1
                                                                            </option>
                                                                        @endif
                                                                    </select>
                                                                </td>
                                                                <td><input type="text" id="transfer_quality_{{ $loop->index }}" name="stoke_info[{{ $loop->index }}][transfer_quality]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('transfer_quality', $inventory_grid) ? $inventory_grid['transfer_quality'] : '' }}" oninput="calculateRemaining({{ $loop->index }})"></td>
                                                                <td><input type="text" id="remaining_quality_{{ $loop->index }}" name="stoke_info[{{ $loop->index }}][remaining_quality]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('remaining_quality', $inventory_grid) ? $inventory_grid['remaining_quality'] : '' }}" readonly></td>
                                                                <td><input type="text" name="stoke_info[{{ $loop->index }}][distruction]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('distruction', $inventory_grid) ? $inventory_grid['distruction'] : '' }}"></td>
                                                                <td><input type="text" class="datepicker" name="stoke_info[{{ $loop->index }}][distruction_due_on]" placeholder="DD-MM-YYYY" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('distruction_due_on', $inventory_grid) ? $inventory_grid['distruction_due_on'] : '' }}"></td>
                                                                <td><input type="text" class="datepicker" name="stoke_info[{{ $loop->index }}][distruction_date]" placeholder="DD-MM-YYYY" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('distruction_date', $inventory_grid) ? $inventory_grid['distruction_date'] : '' }}"></td>
                                                                <td><input type="text" name="stoke_info[{{ $loop->index }}][distruction_by]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('distruction_by', $inventory_grid) ? $inventory_grid['distruction_by'] : '' }}"></td>
                                                                <td><input type="text" name="stoke_info[{{ $loop->index }}][Remarks]" {{ $data->stage == 0 || $data->stage == 5 ? 'disabled' : '' }} value="{{ array_key_exists('Remarks', $inventory_grid) ? $inventory_grid['Remarks'] : '' }}"></td>
                                                                <td><button type="button" class="btn btn-danger remove-row">Remove</button></td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                       {{-- N/A --}}
                                                    @endif
                                                </tbody>
                                                
                                                <script>
                                                    function calculateRemaining(index) {
                                                        var initialQuantity = parseFloat(document.getElementById('initial_quality_' + index).value) || 0;
                                                        var usedQuantity = parseFloat(document.getElementById('used_quality_' + index).value) || 0;
                                                        var transferQuantity = parseFloat(document.getElementById('transfer_quality_' + index).value) || 0;
                                                
                                                        var remainingQuantity = initialQuantity - usedQuantity - transferQuantity;
                                                
                                                        document.getElementById('remaining_quality_' + index).value = remainingQuantity >= 0 ? remainingQuantity : 0;
                                                    }
                                                </script>
                                                
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="button-block">
                                    <button type="submit" class="saveButton">Save</button>
                                    <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                    <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                    <button type="button"> <a href="{{ url('rcms/lims-dashboard') }}" class="text-white">Exit</a></button>
                                </div>
                            </div>
                            {{-- <div id="CCForm3" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="stock-info-grid">
                                                Stock Information
                                            </label>
                                            <div style="overflow-x: auto;">
                                                <table class="table table-bordered" id="addStockInfoDataTable">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 5%;">Row#</th>
                                                            <th>Batch/Lot Number</th>
                                                            <th>Storage Location (e.g., Fridge, Freezer, Room Temperature)</th>
                                                            <th>Unit (e.g., grams, mL)</th>
                                                            <th>Initial Quantity (including initial_quality)</th>
                                                            <th>Used Quantity</th>
                                                            <th>Reagent Expiry Date</th>
                                                            <th>Reagent Opened Date</th>
                                                            <th>Reagent Status (e.g., Approved, Expired, Quarantined)</th>
                                                            <th>Transfer to Another Location? (yes/no)</th>
                                                            <th>Reason for Stock Transfer</th>
                                                            <th>New Location (Shyd Division)</th>
                                                            <th>Transfer Quantity</th>
                                                            <th>Remaining Quantity</th>
                                                            <th>Remarks</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (isset($stockInfo) && count($stockInfo) > 0)
                                                            @foreach ($stockInfo as $index => $stock)
                                                                <tr>
                                                                    <td>
                                                                        <input disabled type="text" name="StockInfo[{{ $index }}][serial]" value="{{ $index + 1 }}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="StockInfo[{{ $index }}][BatchLotNumber]" value="{{ $stock->BatchLotNumber }}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="StockInfo[{{ $index }}][StorageLocation]" value="{{ $stock->StorageLocation }}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="StockInfo[{{ $index }}][Unit]" value="{{ $stock->Unit }}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="StockInfo[{{ $index }}][InitialQuantity]" value="{{ $stock->InitialQuantity }}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="StockInfo[{{ $index }}][UsedQuantity]" value="{{ $stock->UsedQuantity }}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="date" name="StockInfo[{{ $index }}][ReagentExpiryDate]" value="{{ $stock->ReagentExpiryDate }}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="date" name="StockInfo[{{ $index }}][ReagentOpenedDate]" value="{{ $stock->ReagentOpenedDate }}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="StockInfo[{{ $index }}][ReagentStatus]" value="{{ $stock->ReagentStatus }}">
                                                                    </td>
                                                                    <td>
                                                                        <select name="StockInfo[{{ $index }}][TransferLocation]">
                                                                            <option value="yes" {{ $stock->TransferLocation == 'yes' ? 'selected' : '' }}>Yes</option>
                                                                            <option value="no" {{ $stock->TransferLocation == 'no' ? 'selected' : '' }}>No</option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="StockInfo[{{ $index }}][ReasonForTransfer]" value="{{ $stock->ReasonForTransfer }}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="StockInfo[{{ $index }}][NewLocation]" value="{{ $stock->NewLocation }}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="StockInfo[{{ $index }}][TransferQuantity]" value="{{ $stock->TransferQuantity }}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="StockInfo[{{ $index }}][RemainingQuantity]" value="{{ $stock->RemainingQuantity }}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="StockInfo[{{ $index }}][Remarks]" value="{{ $stock->Remarks }}">
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="15" class="text-center">No stock information available.</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        $(document).ready(function() {
                                            // Use a fallback to avoid the error
                                            let StockInfoIndex = {{ count($stockInfo ?? []) }}; // Default to an empty array if $stockInfo is null
                                    
                                            // Function to generate the table row for adding new rows
                                            function generateTableRow(index) {
                                                return `
                                                    <tr>
                                                        <td>
                                                            <input disabled type="text" name="StockInfo[${index}][serial]" value="${index + 1}">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="StockInfo[${index}][BatchLotNumber]">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="StockInfo[${index}][StorageLocation]">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="StockInfo[${index}][Unit]">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="StockInfo[${index}][InitialQuantity]">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="StockInfo[${index}][UsedQuantity]">
                                                        </td>
                                                        <td>
                                                            <input type="date" name="StockInfo[${index}][ReagentExpiryDate]">
                                                        </td>
                                                        <td>
                                                            <input type="date" name="StockInfo[${index}][ReagentOpenedDate]">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="StockInfo[${index}][ReagentStatus]">
                                                        </td>
                                                        <td>
                                                            <select name="StockInfo[${index}][TransferLocation]">
                                                                <option value="yes">Yes</option>
                                                                <option value="no">No</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="StockInfo[${index}][ReasonForTransfer]">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="StockInfo[${index}][NewLocation]">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="StockInfo[${index}][TransferQuantity]">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="StockInfo[${index}][RemainingQuantity]">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="StockInfo[${index}][Remarks]">
                                                        </td>
                                                        <td>
                                                            <button type="button" class="removeRowBtn">Remove</button>
                                                        </td>
                                                    </tr>
                                                `;
                                            }
                                    
                                            // Add new row to the table when the "Add" button is clicked
                                            $('#addStockInfoData').click(function() {
                                                var tableBody = $('#addStockInfoDataTable tbody');
                                                var newRow = generateTableRow(StockInfoIndex);
                                                tableBody.append(newRow);
                                                StockInfoIndex++; // Increment index for the next row
                                            });
                                    
                                            // Remove row when the "Remove" button is clicked
                                            $(document).on('click', '.removeRowBtn', function() {
                                                $(this).closest('tr').remove();
                                                updateTableIndexing(); // Update the row indices when a row is removed
                                            });
                                    
                                            // Update the row indexes after a row is removed
                                            function updateTableIndexing() {
                                                let index = 0;
                                                $('#addStockInfoDataTable tbody tr').each(function() {
                                                    $(this).find('input[name^="StockInfo"]').each(function() {
                                                        let name = $(this).attr('name');
                                                        name = name.replace(/\[\d+\]/, `[${index}]`); // Update the input names with the new index
                                                        $(this).attr('name', name);
                                                    });
                                                    $(this).find('select[name^="StockInfo"]').each(function() {
                                                        let name = $(this).attr('name');
                                                        name = name.replace(/\[\d+\]/, `[${index}]`); // Update the select names with the new index
                                                        $(this).attr('name', name);
                                                    });
                                                    $(this).find('input[name*="serial"]').val(index + 1); // Update serial number
                                                    index++;
                                                });
                                            }
                                    
                                            // Update the serial numbers when the page loads with existing data
                                            function updateExistingSerialNumbers() {
                                                let index = 0;
                                                $('#addStockInfoDataTable tbody tr').each(function() {
                                                    $(this).find('input[name*="serial"]').val(index + 1);
                                                    index++;
                                                });
                                            }
                                    
                                            // Call the updateExistingSerialNumbers function to update the serial numbers on page load
                                            updateExistingSerialNumbers();
                                        });
                                    </script>
                                    
                                                                        
                                </div>
                            </div> --}}
                            <!-- Water Consumption Detail ****************************-->
                            <div id="CCForm4" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Next Calibration Date">Usage Date</label>
                                                <div class="calenderauditee">                                     
                                                    <input type="text"  id="usage_date"  readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($equipment->usage_date) }}"
                                                        {{ $equipment->stage == 0 || $equipment->stage == 9 ? 'disabled' : '' }}/>
                                                    <input type="date" id="usage_date_checkdate" name="usage_date" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" {{ $equipment->stage == 0 || $equipment->stage == 9 ? 'disabled' : '' }} value="{{ $equipment->usage_date }}" class="hide-input"
                                                    oninput="handleDateInput(this, 'usage_date');checkDate('last_calibration_date_checkdate','usage_date_checkdate')"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Details">Purpose of Use</label>
                                                <textarea name="purpose_of_use">{{ $equipment->purpose_of_use }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Quantity Used</label>
                                                <input type="text" name="quality_used" value="{{ $equipment->quality_used }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Zone">Logged By</label>
                                                <select name="logged_by">
                                                    <option value="">--Select--</option>
                                                    <option value="User" {{ $equipment->logged_by == 'User' ? 'selected' : '' }}>User</option>
                                                    <option value="Liquid" {{ $equipment->logged_by == 'Liquid' ? 'selected' : '' }}>Liquid</option>
                                                    <option value="Analyst Name" {{ $equipment->logged_by == 'Analyst Name' ? 'selected' : '' }}>Analyst Name</option>                                                   
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/lims-dashboard') }}" class="text-white">Exit</a></button>
                                    </div>
                                </div>
                            </div>

                            <div id="CCForm5" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                  
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Zone">Storage Conditions</label>
                                                <select name="storage_condition">
                                                    <option value="">-- Select --</option>
                                                    <option value="Temperature" {{ $equipment->storage_condition == 'Temperature' ? 'selected' : '' }}>Temperature</option>
                                                    <option value="Humidity" {{ $equipment->storage_condition == 'Humidity' ? 'selected' : '' }}>Humidity</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Zone">Container Type</label>
                                                <select name="container_type">
                                                    <option value="">-- Select --</option>
                                                    <option value="Glass" {{ $equipment->container_type == 'Glass' ? 'selected' : '' }}>Glass</option>
                                                    <option value="Plastic" {{ $equipment->container_type == 'Plastic' ? 'selected' : '' }}>Plastic</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Details">Shelf Life After Opening</label>
                                                <textarea name="shelf_life">{{ $equipment->shelf_life }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Details">Handling Instructions</label>
                                                <textarea name="handling_instructions">{{ $equipment->handling_instructions }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a class="text-white"
                                                href="{{ url('rcms/lims-dashboard') }}">Exit</a> </button>
                                    </div>
                                </div>
                            </div>
        
                            <!-- Emission to Water ****************************-->
                            <div id="CCForm6" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Calibration Procedure Reference/Document">Safety Data Sheet (SDS)</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="safety_date_sheet">
                                                        @if ($equipment->safety_date_sheet)
                                                            @foreach (json_decode($equipment->safety_date_sheet) as $file)
                                                                <h6 type="button" class="file-container text-dark"
                                                                    style="background-color: rgb(243, 242, 240);">
                                                                    <b>{{ $file }}</b>
                                                                    <a href="{{ asset('upload/' . $file) }}"
                                                                        target="_blank"><i class="fa fa-eye text-primary"
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
                                                        <input
                                                            {{ $equipment->stage == 0 || $equipment->stage == 9 ? 'disabled' : '' }}
                                                            type="file" id="myfile" name="safety_date_sheet[]"
                                                            oninput="addMultipleFiles(this, 'safety_date_sheet')" multiple>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Corrective Action">Risk Assessment Code</label>
                                                <input type="text" name="risk_assesment_code" value="{{ $equipment->risk_assesment_code }}"></input>
                                            </div>
                                        </div>
        
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Initiator">Disposal Guidelines</label>
                                                <input type="text" name="disposal_guidelines" value="{{ $equipment->disposal_guidelines }}"></input>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Zone">Regulatory Compliance Information</label>
                                                <select name="regualatory_info">
                                                    <option value="">-- Select --</option>
                                                    <option value="GMP" {{ $equipment->regualatory_info == 'GMP' ? 'selected' : '' }}>GMP</option>
                                                    <option value="GLP" {{ $equipment->regualatory_info == 'GLP' ? 'selected' : '' }}>GLP</option>
                                                    <option value="GCP" {{ $equipment->regualatory_info == 'GCP' ? 'selected' : '' }}>GCP</option>
                                                    <option value="FDA" {{ $equipment->regualatory_info == 'FDA' ? 'selected' : '' }}>FDA</option>
                                                    <option value="EMA" {{ $equipment->regualatory_info == 'EMA' ? 'selected' : '' }}>EMA</option>
                                                    <option value="ISO Standards" {{ $equipment->regualatory_info == 'ISO Standards' ? 'selected' : '' }}>ISO Standards</option>
                                                    <option value="ICH Guidelines" {{ $equipment->regualatory_info == 'ICH Guidelines' ? 'selected' : '' }}>ICH Guidelines</option>                                             
                                                </select>
                                            </div>
                                        </div>
        
                                    </div>

                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/lims-dashboard') }}" class="text-white">Exit</a></button>
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
                                                <textarea name="supervisor_comment">{{ $equipment->supervisor_comment }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Supervisor Documents">Supervisor Documents</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting
                                                        documents</small></div>
    
                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="Supervisor_document">
                                                        @if ($equipment->Supervisor_document)
                                                            @foreach (json_decode($equipment->Supervisor_document) as $file)
                                                                <h6 type="button" class="file-container text-dark"
                                                                    style="background-color: rgb(243, 242, 240);">
                                                                    <b>{{ $file }}</b>
                                                                    <a href="{{ asset('upload/' . $file) }}"
                                                                        target="_blank"><i class="fa fa-eye text-primary"
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
                                                        <input
                                                            {{ $equipment->stage == 0 || $equipment->stage == 9 ? 'disabled' : '' }}
                                                            type="file" id="myfile" name="Supervisor_document[]"
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
                                        <button type="button"> <a href="{{ url('rcms/lims-dashboard') }}" class="text-white">Exit</a></button>
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
                                                <textarea name="QA_comment">{{ $equipment->QA_comment }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="QA Documents">QA Documents</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting
                                                        documents</small></div>
    
                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="QA_document">
                                                        @if ($equipment->QA_document)
                                                            @foreach (json_decode($equipment->QA_document) as $file)
                                                                <h6 type="button" class="file-container text-dark"
                                                                    style="background-color: rgb(243, 242, 240);">
                                                                    <b>{{ $file }}</b>
                                                                    <a href="{{ asset('upload/' . $file) }}"
                                                                        target="_blank"><i class="fa fa-eye text-primary"
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
                                                        <input
                                                            {{ $equipment->stage == 0 || $equipment->stage == 9 ? 'disabled' : '' }}
                                                            type="file" id="myfile" name="QA_document[]"
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
                                        <button type="button"> <a href="{{ url('rcms/lims-dashboard') }}" class="text-white">Exit</a></button>
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
                                                    <option value="In-use" {{ $equipment->Equipment_Lifecycle_Stage == 'In-use' ? 'selected' : '' }}>In-use</option>
                                                    <option value="Out-of-service" {{ $equipment->Equipment_Lifecycle_Stage == 'Out-of-service' ? 'selected' : '' }}>Out-of-service</option>
                                                    <option value="Retired" {{ $equipment->Equipment_Lifecycle_Stage == 'Retired' ? 'selected' : '' }}>Retired</option>
                                                
                                                </select>
                                            </div>
                                        </div>
        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Expected Useful Life">Expected Useful Life</label>
                                                <textarea name="Expected_Useful_Life">{{ $equipment->Expected_Useful_Life }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="End-of-life Date">End-of-life Date</label>
                                                <div class="calenderauditee">
                                                    <input type="text" id="End_of_life_Date" readonly
                                                        placeholder="DD-MMM-YYYY" />
                                                    <input type="date" id="End_of_life_Date_checkdate" name="End_of_life_Date" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"  class="hide-input"
                                                        oninput="handleDateInput(this, 'End_of_life_Date');checkDate('End_of_life_Date_checkdate','End_of_life_Date1_checkdate')" />
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Decommissioning and Disposal Records">Decommissioning and Disposal Records</label>
                                                <textarea name="Decommissioning_and_Disposal_Records">{{ $equipment->Decommissioning_and_Disposal_Records }}</textarea>
                                            </div>
                                        </div>
        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Replacement History">Replacement History</label>
                                                <textarea name="Replacement_History">{{ $equipment->Replacement_History }}</textarea>
                                            </div>
                                        </div>
        
        
                                        
                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/lims-dashboard') }}" class="text-white">Exit</a></button>
                                    </div>
                                </div>
                            </div>
        
                            <div id="CCForm10" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed By">Submit By</label>
                                                <div class="static">{{ $equipment->submit_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed On">Submit On</label>
                                                <div class="static">{{ $equipment->submit_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Cancelled By">Submit Comment</label>
                                                <div class="static">{{ $equipment->submit_comments }}</div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed By">Cancelled By</label>
                                                <div class="static">{{ $equipment->Cancel_By }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed On">Cancelled On</label>
                                                <div class="static">{{ $equipment->Cancel_On }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Cancelled By">Cancelled Comment</label>
                                                <div class="static">{{ $equipment->Cancel_Comment }}</div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed By">Review Complete By</label>
                                                <div class="static">{{ $equipment->Review_Complete_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed On">Review Complete On</label>
                                                <div class="static">{{ $equipment->Review_Complete_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Review Complete By">Review Complete Comment</label>
                                                <div class="static">{{ $equipment->Review_Complete_comment }}</div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed By">Approval Complete By</label>
                                                <div class="static">{{ $equipment->Approval_Complete_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed On">Approval Complete On</label>
                                                <div class="static">{{ $equipment->Approval_Complete_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Supervisor Approval By">Approval Complete Comment</label>
                                                <div class="static">{{ $equipment->Approval_Complete_comment }}</div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed By">Stock Transfer By</label>
                                                <div class="static">{{ $equipment->stock_transfer_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed On">Stock Transfer On</label>
                                                <div class="static">{{ $equipment->stock_transfer_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Supervisor Approval By">Stock Transfer Comment</label>
                                                <div class="static">{{ $equipment->stock_transfer_comment }}</div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed By">Complete Transferring By</label>
                                                <div class="static">{{ $equipment->stock_transfer1_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed On">Complete Transferring On</label>
                                                <div class="static">{{ $equipment->stock_transfer1_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Supervisor Approval By">Complete Transferring Comment</label>
                                                <div class="static">{{ $equipment->stock_transfer1_comment }}</div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    </div>

    <div class="modal fade" id="signature-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('InventoryStateChange', $equipment->id) }}" method="POST">
                    @csrf
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
                </form>
            </div>
        </div>
    </div>

    {{-- <div class="modal fade" id="MoreInfo-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('MoreInfoinventoryive', $equipment->id) }}" method="POST">
                    @csrf
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
                        {{-- <div class="modal-footer">
                            <button type="submit" data-bs-dismiss="modal">Submit</button>
                            <button>Close</button>
                        </div>  
                    <div class="modal-footer">
                        <button type="submit">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>

                    </div>
                </form>
            </div>
        </div>
    </div> --}}





    <div class="modal fade" id="MoreInfo-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('MoreInfoInventory', $equipment->id) }}" method="POST">
                    @csrf
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
                    {{-- <div class="modal-footer">
                            <button type="submit" data-bs-dismiss="modal">Submit</button>
                            <button>Close</button>
                        </div> -- --}}
                    <div class="modal-footer">
                        <button type="submit">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="child-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Child</h4>
                </div>
                <form action="{{ route('inventoryChild', $equipment->id) }}" method="POST">
                    @csrf
                    
                    <div class="modal-body">
                        <div class="group-input">
                                <label for="major">
                                    <input type="radio" name="revision" value="action-item">
                                    Action Item
                                </label>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" data-bs-dismiss="modal">Close</button>
                        <button type="submit">Continue</button>
                    </div>
                </form>

            </div>
        </div>
    </div>





    <div class="modal fade" id="cancel-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ url('InventoryCancel', $equipment->id) }}" method="POST">
                    @csrf
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
                            <input type="comment" name="comments">
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="submit" data-bs-dismiss="modal">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    

    <style>
        #productTable,
        #materialTable {
            display: none;
        }
    </style>


<script>
        VirtualSelect.init({
            ele: '#investigators, #department, #investigation_team, #root_cause_methodology'
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

        function add4Input(tableId) {
            var table = document.getElementById(tableId);
            var currentRowCount = table.rows.length;
            var newRow = table.insertRow(currentRowCount);
            newRow.setAttribute("id", "row" + currentRowCount);
            var cell1 = newRow.insertCell(0);
            cell1.innerHTML = currentRowCount;

            var cell2 = newRow.insertCell(1);
            cell2.innerHTML = "<input type='text' name='Root_Cause_Category[]'>";

            var cell3 = newRow.insertCell(2);
            cell3.innerHTML = "<input type='text' name='Root_Cause_Sub_Category[]'>";

            var cell4 = newRow.insertCell(3);
            cell4.innerHTML = "<input type='text' name='Probability[]'>";

            var cell5 = newRow.insertCell(4);
            cell5.innerHTML = "<input type='text' name='Remarks[]'>";

            let cell6 = newRow.insertCell(5);
            cell6.innerHTML = "<button type='text' class='removeRowBtn' name='Action[]' readonly>Remove</button>";

            for (var i = 1; i < currentRowCount; i++) {
                var row = table.rows[i];
                row.cells[0].innerHTML = i;
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



        function addHAZOPRiskAssessment(tableId) {
            var table = document.getElementById(tableId);
            var currentRowCount = table.rows.length; // Get the current number of rows including the header row
            
            // Insert a new row at the end of the table body (not in the header)
            var newRow = table.getElementsByTagName('tbody')[0].insertRow(); 

            // Set the row's ID
            newRow.setAttribute("id", "row" + currentRowCount);
            
            // Insert a cell for the row number (first column)
            var cell1 = newRow.insertCell(0);
            cell1.innerHTML = currentRowCount; // Row number based on current row count
            
            // Insert cells for HAZOP data fields (middle columns)
            var cell2 = newRow.insertCell(1);
            cell2.setAttribute('colspan', '2');
            cell2.innerHTML = "<input name='deviation[]' type='text' colspan='2' {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>";
            
            var cell3 = newRow.insertCell(2);
            cell3.setAttribute('colspan', '2');
            cell3.innerHTML = "<input name='session[]' type='text' {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>";
            
            var cell4 = newRow.insertCell(3);
            cell4.setAttribute('colspan', '2');
            cell4.innerHTML = "<input name='causes[]' type='text' {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>";
            
            var cell5 = newRow.insertCell(4);
            cell5.setAttribute('colspan', '2');
            cell5.innerHTML = "<input name='consequences[]' type='text' {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>";
            
            var cell6 = newRow.insertCell(5);
            cell6.setAttribute('colspan', '2');
            cell6.innerHTML = "<input name='category[]' type='text' {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>";
            
            var cell7 = newRow.insertCell(6);
            cell7.innerHTML = "<input name='risk_or_S[]' type='text' {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>";
            
            var cell8 = newRow.insertCell(7);
            cell8.innerHTML = "<input name='risk_or_F[]' type='text' {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>";
            
            var cell9 = newRow.insertCell(8);
            cell9.innerHTML = "<input name='risk_or_RR[]' type='text' {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>";
            
            var cell10 = newRow.insertCell(9);
            cell10.setAttribute('colspan', '2');
            cell10.innerHTML = "<input name='risk_enablers[]' type='text' {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>";
            
            var cell11 = newRow.insertCell(10);
            cell11.innerHTML = "<input name='risk_CR_S[]' type='text' {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>";
            
            var cell12 = newRow.insertCell(11);
            cell12.innerHTML = "<input name='risk_CR_F[]' type='text' {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>";
            
            var cell13 = newRow.insertCell(12);
            cell13.innerHTML = "<input name='risk_CR_RR[]' type='text' {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>";

            var cell14 = newRow.insertCell(13);
            cell14.setAttribute('colspan', '2');
            cell14.innerHTML = "<input name='safeguards_sensor_tag_nr[]' type='text' {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>";

            var cell15 = newRow.insertCell(14);
            cell15.setAttribute('colspan', '2');
            cell15.innerHTML = "<input name='safeguards_tag_nr[]' type='text' {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>";

            var cell16 = newRow.insertCell(15);
            cell16.setAttribute('colspan', '2');
            cell16.innerHTML = "<input name='safeguards_action[]' type='text' {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>";

            var cell17 = newRow.insertCell(16);
            cell17.setAttribute('colspan', '2');
            cell17.innerHTML = "<input name='safeguards_effective_action[]' type='text' {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>";

            var cell18 = newRow.insertCell(17);
            cell18.setAttribute('colspan', '2');
            cell18.innerHTML = "<input name='safeguards_other_safeguards[]' type='text' {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>";

            var cell19 = newRow.insertCell(18);
            cell19.setAttribute('colspan', '2');
            cell19.innerHTML = "<input name='critical_safeguards_description[]' type='text' {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>";

            var cell20 = newRow.insertCell(19);
            cell20.innerHTML = "<input name='critical_safeguards_type[]' type='text' {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>";

            var cell21 = newRow.insertCell(20);
            cell21.innerHTML = "<input name='critical_safeguards_rrf[]' type='text' {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>";

            var cell22 = newRow.insertCell(21);
            cell22.innerHTML = "<input name='risk_rating_s[]' type='text' {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>";

            var cell23 = newRow.insertCell(22);
            cell23.innerHTML = "<input name='risk_rating_f[]' type='text' {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>";

            var cell24 = newRow.insertCell(23);
            cell24.innerHTML = "<input name='risk_rating_rr[]' type='text' {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>";

            var cell25 = newRow.insertCell(24);
            cell25.setAttribute('colspan', '3');
            cell25.innerHTML = "<input name='hazop_recommendations[]' type='text' {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>";

            var cell26 = newRow.insertCell(25);
            cell26.setAttribute('colspan', '3');
            cell26.innerHTML = "<input name='responsibility_for_recommendations[]' type='text' {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>";

            var cell27 = newRow.insertCell(26);
            cell27.innerHTML = "<input name='risk_rating_after_s[]' type='text' {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>";

            var cell28 = newRow.insertCell(27);
            cell28.innerHTML = "<input name='risk_rating_after_f[]' type='text' {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>";

            var cell29 = newRow.insertCell(28);
            cell29.innerHTML = "<input name='risk_rating_after_rr[]' type='text' {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>";
            

            // Insert a cell for the action (Remove button) (last column)
            var cell30 = newRow.insertCell(29);
            cell30.setAttribute('colspan', '2');
            cell30.innerHTML = "<button type='button' onclick='removeHAZOPRow(this)' class='removeRowBtn' {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>Remove</button>";

            // Update row numbers after adding a new row
            updateRowNumbers(table);
        }

        function removeHAZOPRow(button) {
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
                rows[i].cells[0].innerHTML = i + 1;  // Set the row number
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
        wow = new WOW({
            boxClass: 'wow', // default
            animateClass: 'animated', // default
            offset: 0, // default
            mobile: true, // default
            live: true // default
        })
        wow.init();
    </script>


    <script>
        VirtualSelect.init({
            ele: '#related_records, #reviewer_person_value, #risk_assessment_related_record, #concerned_department_review'
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
        $(document).ready(function() {
            $('#add-input').click(function() {
                var lastInput = $('.bar input:last');
                var newInput = $('<input type="text" name="review_comment">');
                lastInput.after(newInput);
            });
        });
    </script>

    <!-- Example Blade View -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>

    @if (session()->has('errorMessages'))
        <script>
            // Create an array to hold all the error messages
            var errorMessages = @json(session()->get('errorMessages'));

            if (!Array.isArray(errorMessages)) {
                errorMessages = [errorMessages];
            }

            errorMessages = errorMessages.map(function(message) {
                return '<div class="seperator">==================================================</div>' +
                    '<div class="slogan"><div>This form was not submitted because of the following errors.</div><div>Please correct the errors and re-submit.</div></div>' +
                    '<div class="data">This Activity cannot be performed, as there are some blank required fields.</div>' +
                    '<div class="message">' + message + '</div>';
            });

            Swal.fire({
                icon: '',
                title: 'Connexo DMS Says',
                html: errorMessages.join(''),

                showCloseButton: true, // Display a close button
                customClass: {
                    title: 'my-title-class', // Add a custom CSS class to the title
                    htmlContainer: 'my-html-class text-danger', // Add a custom CSS class to the popup content
                },
                confirmButtonColor: '#3085d6', // Customize the confirm button color
            });
        </script>
        @php session()->forget('errorMessages'); @endphp
    @endif

   


   

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        $(document).on('click', '.removeRowBtn', function() {
            $(this).closest('tr').remove();
        })
    </script>
    <script>
        // JavaScript
        document.getElementById('initiator_group').addEventListener('change', function() {
            var selectedValue = this.value;
            document.getElementById('initiator_group_code').value = selectedValue;
        });
    </script>
    <script>
        var maxLength = 255;
        $('#docname').keyup(function() {
            var textlen = maxLength - $(this).val().length;
            $('#rchars').text(textlen);
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.remove-file').click(function() {
                const removeId = $(this).data('remove-id')
                console.log('removeId', removeId);
                $('#' + removeId).remove();
            })
        })
    </script>

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
