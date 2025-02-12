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
                        dateFormat: "dd-M-yy" 
                    });
                });

                function getCurrentDate() {
                    var today = new Date();
                    var dd = String(today.getDate()).padStart(2, '0');
                    var monthNames = ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"];
                    var MM = monthNames[today.getMonth()]; 
                    var yyyy = today.getFullYear();
                    return dd + '-' + MM + '-' + yyyy;
                }

                var currentDivisionName = "{{ Helpers::getDivisionName($equipment->division_id) }}";
                var inventoryGridNewLocation = "{{ $inventory_grid['new_location'] ?? '' }}";
                var currentDate = getCurrentDate();
                var receptionistDiaryNumber = "{{ $equipment->receptionist_diary }}";
                var options = '';
 
                var html = 
                  '<tr>' +
                    '<td><input disabled type="text" name="sample_coordinator[' + serialNumber + '][serial]" value="' + serialNumber + '"></td>' +
                    // '<td><input type="text" class="datepicker" name="sample_coordinator[' + serialNumber + '][assignment_date]" placeholder="DD-MM-YYYY"></td>' +
                    '<td><input type="text" class="datepicker" name="sample_coordinator[' + serialNumber + '][assignment_date]" value="' + currentDate + '" placeholder="DD-MM-YYYY" {{ $data->stage == 3 ? 'required' : 'readonly' }}></td>' +
                    '<td><input type="text" name="sample_coordinator[' + serialNumber + '][analytical_receipt]" value="' + receptionistDiaryNumber + '"></td>' +
                    '<td><input type="text" class="Document_Remarks" name="sample_coordinator[' + serialNumber + '][sample_name]" {{ $data->stage == 3 ? 'required' : 'readonly' }}></td>' +
                    '<td><input type="text" class="Document_Remarks" name="sample_coordinator[' + serialNumber + '][Batch]" {{ $data->stage == 3 ? 'required' : 'readonly' }}></td>' +
                    '<td><input type="text" class="Document_Remarks" name="sample_coordinator[' + serialNumber + '][sample_quantity]" {{ $data->stage == 3 ? 'required' : 'readonly' }}></td>' +
                    '<td><input type="text" class="datepicker" name="sample_coordinator[' + serialNumber + '][manufacturing_date]" placeholder="DD-MM-YYYY" {{ $data->stage == 3 ? 'required' : 'readonly' }}></td>' +
                    '<td><input type="text" class="datepicker" name="sample_coordinator[' + serialNumber + '][expiry_date]" placeholder="DD-MM-YYYY" {{ $data->stage == 3 ? 'required' : 'readonly' }}></td>' +
                    '<td><input type="text" class="Document_Remarks" name="sample_coordinator[' + serialNumber + '][recommended_storage]" {{ $data->stage == 3 ? 'required' : 'readonly' }}></td>' +
                    '<td><input type="text" class="Document_Remarks" name="sample_coordinator[' + serialNumber + '][physical_observation]" {{ $data->stage == 3 ? 'required' : 'readonly' }}></td>' +
                    '<td><input type="text" class="Document_Remarks" name="sample_coordinator[' + serialNumber + '][Remarks]" {{ $data->stage == 3 ? 'required' : 'readonly' }}></td>' +
                    '<td style="display:none;"><input type="hidden" name="sample_coordinator[' + serialNumber + '][LSL]"></td>' +
                    '<td style="display:none;><input type="hidden" name="sample_coordinator[' + serialNumber + '][USL]"></td>' +
                    '<td style="display:none;><input type="hidden" name="sample_coordinator[' + serialNumber + '][observed_value]"></td>' +
                    '<td style="display:none;><input type="hidden" name="sample_coordinator[' + serialNumber + '][analyst_name]"></td>' +
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

        });

        $('#job-responsibilty-table').on('change', 'select[name^="stoke_info"]', function() {
           
        });
     });
</script>


<script>
    $(document).ready(function() {
        $('#Observation').click(function(e) {
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

                var currentDivisionName = "{{ Helpers::getDivisionName($equipment->division_id) }}";
                var inventoryGridNewLocation = "{{ $inventory_grid['new_location'] ?? '' }}";
                var currentDate = getCurrentDate();
                var receptionistDiaryNumber = "{{ $equipment->receptionist_diary }}";
                var options = '';
 
                var html = 
                  '<tr>' +
                    '<td><input disabled type="text" name="sample_coordinator[' + serialNumber + '][serial]" value="' + serialNumber + '"></td>' +
                    // '<td><input type="text" class="datepicker" name="sample_coordinator[' + serialNumber + '][assignment_date]" placeholder="DD-MM-YYYY"></td>' +
                    '<td><input readonly type="text" class="datepicker" name="sample_coordinator[' + serialNumber + '][assignment_date]" value="' + currentDate + '" placeholder="DD-MM-YYYY"></td>' +
                    '<td><input readonly type="text" name="sample_coordinator[' + serialNumber + '][analytical_receipt]" value="' + receptionistDiaryNumber + '"></td>' +  <!-- Set AR number to Receptionist Diary Number -->
                    '<td><input readonly type="text" class="Document_Remarks" name="sample_coordinator[' + serialNumber + '][sample_name]"></td>' +
                    '<td><input readonly type="text" class="Document_Remarks" name="sample_coordinator[' + serialNumber + '][Batch]"></td>' +
                    '<td><input readonly type="text" class="Document_Remarks" name="sample_coordinator[' + serialNumber + '][sample_quantity]"></td>' +
                    '<td><input readonly type="text" class="datepicker" name="sample_coordinator[' + serialNumber + '][manufacturing_date]" placeholder="DD-MM-YYYY"></td>' +
                    '<td><input readonly type="text" class="datepicker" name="sample_coordinator[' + serialNumber + '][expiry_date]" placeholder="DD-MM-YYYY"></td>' +
                    '<td><input readonly type="text" class="Document_Remarks" name="sample_coordinator[' + serialNumber + '][recommended_storage]"></td>' +
                    '<td><input readonly type="text" class="Document_Remarks" name="sample_coordinator[' + serialNumber + '][physical_observation]"></td>' +
                    '<td><input type="text" class="Document_Remarks" name="sample_coordinator[' + serialNumber + '][Remarks]"></td>' +
                    '<td><input type="text" class="Document_Remarks" name="sample_coordinator[' + serialNumber + '][LSL]"></td>' +
                    '<td><input type="text" class="Document_Remarks" name="sample_coordinator[' + serialNumber + '][USL]"></td>' +
                    '<td><input type="text" class="Document_Remarks" name="sample_coordinator[' + serialNumber + '][observed_value]"></td>' +
                    '<td><input type="text" class="Document_Remarks" name="sample_coordinator[' + serialNumber + '][analyst_name]"></td>' +
                    '<td><button readonly type="button" class="btn btn-danger remove-row">Remove</button></td>' +
                '</tr>';
                
                return html;
            }

            $('#job-result-table').on('click', '.remove-row', function() {
                    $(this).closest('tr').remove();
                    updateSerialNumbers();
            });

            var tableBody = $('#job-result-table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);

        });

        $('#job-result-table').on('change', 'select[name^="stoke_info"]', function() {
           
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
                    {{ Helpers::getFullDivisionName($equipment->receipt_division) }} / Sample Management I
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
                            <a class="text-white" href="{{ url('ReceiptAuditTrail', $data->id) }}">
                                Audit Trail
                            </a>
                        </button>
                    
                        @if ($data->stage == 1)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Sample Receive
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>
                        @elseif($data->stage == 2)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#MoreInfo-modal">
                                More Information Required
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Transfer To Sample Coordinator
                            </button>
                           
                        @elseif($data->stage == 3)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#MoreInfo-modal">
                                More Information Required
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Review Completed By Sample Coordinator
                            </button>

                        @elseif($data->stage == 4)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#MoreInfo-modal">
                                More Information Required
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Allocation of Sample for Analysis Completed 
                            </button>
                           
                        @elseif($data->stage == 5)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#MoreInfo-modal">
                                MOA Change Needed
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Start Analysis
                            </button>    

                        @elseif($data->stage == 6)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Analysis Complete
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#second-signature-modal">
                                Analysis Completed & Verification Required
                            </button>    

                        @elseif($data->stage == 8)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#MoreInfo-modal">
                                More Information Required
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Verification for Review-1 Complete
                            </button>    

                        @elseif($data->stage == 9)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#MoreInfo-modal">
                                More Information Required
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Verification for Review-2 Complete
                            </button>    

                        @elseif($data->stage == 10)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#MoreInfo-modal">
                                More Information Required
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Approval Complete
                            </button>       
                        @endif
                        <button class="button_theme1">
                            <a class="text-white" href="{{ url('rcms/lims-dashboard') }}">Exit</a>
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
                    <!-- Stage 1 -->
                    <div class="{{ $data->stage >= 1 ? 'active' : '' }}">Opened</div>
                
                    <!-- Stage 2 -->
                    <div class="{{ $data->stage >= 2 ? 'active' : '' }}">
                        Pending Front Office Review
                    </div>
                
                    <!-- Stage 3 -->
                    <div class="{{ $data->stage >= 3 ? 'active' : '' }}">
                        Pending Review By Sample Coordinator
                    </div>
                
                    <!-- Stage 4 -->
                    <div class="{{ $data->stage >= 4 ? 'active' : '' }}">
                        Pending Allocation of Sample for Analysis
                    </div>
                
                    <!-- Stage 5 -->
                    <div class="{{ $data->stage >= 5 ? 'active' : '' }}">
                        Pending Sample Acknowledgement
                    </div>
                
                    <!-- Stage 6 -->
                    <div class="{{ $data->stage >= 6 ? 'active' : '' }}">
                        Pending Sample Analysis
                    </div>

                    <div class="{{ $data->stage >= 8 || $data->stage == 7  ? 'active' : '' }}" @if($data->stage == 7) style="display:none;" @endif>
                        Pending Verification for Review-1
                    </div>

                    <div class="{{ $data->stage >= 9 || $data->stage == 7 ? 'active' : '' }}" @if($data->stage == 7) style="display:none;" @endif>
                        Pending Verification for Review-2   
                    </div>

                    <div class="{{ $data->stage >= 10 || $data->stage == 7 ? 'active' : '' }}" @if($data->stage == 7) style="display:none;" @endif>
                        Pending Verification for Approval
                    </div>

                    <div class="{{ $data->stage >= 11 || $data->stage == 7 ? 'bg-danger' : '' }}">
                        Closed - Done
                    </div>
                 
                </div>
                @endif
            
                </div>
                <br>
                <div class="top-block">
                    <div><strong> Record Name :&nbsp;</strong>Receipt</div>
                    <div><strong> Site :&nbsp;</strong>{{ Helpers::getFullDivisionName($equipment->receipt_division) }}</div>
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
        {{-- <style>
            .btn-details {
                display: none; /* Initially hide */
            }
            .btn-assay {
                display: none; /* Initially hide */
            }
            .btn-dissolution {
                display: none; /* Initially hide */
            }
        </style> --}}
        <div class="control-list">
            @php
                $users = DB::table('users')->get();
            @endphp
            <div id="change-control-fields">
                <div class="container-fluid">
                    <!-- Tab links -->
                    <div class="cctab">
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

                {{-- <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Reagent/Item Information</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Supplier Details</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Stock Information</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Usage Tracking</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Storage and Handling</button>--}}

                <button class="cctablinks" onclick="openCity(event, 'CCForm12')">Activity Log</button>
                    </div>

                    <form id="CCFormInput" action="{{ route('updatereceipt', $data->id) }}" method="POST"
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

                                        </div> --}}
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Zone">Division<span class="text-danger">*</span></label>
                                                <select name="receipt_division" id="receipt_division" disabled>
                                                    <option value="">Select Division</option>
                                                    <option value="ARD" {{ $equipment->receipt_division == 'ARD' ? 'selected' : '' }}>Analytical Research & Development Division</option>
                                                    <option value="RSD" {{ $equipment->receipt_division == 'RSD' ? 'selected' : '' }}>Reference Standard Division</option>
                                                    <option value="MIC" {{ $equipment->receipt_division == 'MIC' ? 'selected' : '' }}>Microbiology Division</option>
                                                    <option value="BIO" {{ $equipment->receipt_division == 'BIO' ? 'selected' : '' }}>Biologics Division</option>
                                                    <option value="PVP" {{ $equipment->receipt_division == 'PVP' ? 'selected' : '' }}>PvPI Division</option>
                                                    <option value="QAL" {{ $equipment->receipt_division == 'QAL' ? 'selected' : '' }}>Quality Assurance Division</option>
                                                    <option value="MVP" {{ $equipment->receipt_division == 'MVP' ? 'selected' : '' }}>MvPI Division</option>
                                                    <option value="OTH" {{ $equipment->receipt_division == 'OTH' ? 'selected' : '' }}>Others</option>
                                                    </select>
                                            </div>
                                        </div> 
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="RLS Record Number"><b>Reception Diary Number</b></label>
                                                <input hidden name="record_number">
                                                <input readonly type="text"  value="{{ $equipment->record_number }}" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}>
                                            </div>
                                        </div> 
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Zone">Mode of Receipt<span class="text-danger">*</span></label>
                                                <select name="mode_receipt" id="mode_receipt" readonly {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}>
                                                    <option value="">--Select--</option>
                                                    <option value="Hand Delivery" {{ $equipment->mode_receipt == 'Hand Delivery' ? 'selected' : '' }}>Hand Delivery</option>
                                                    <option value="Post" {{ $equipment->mode_receipt == 'Post' ? 'selected' : '' }}>Post</option>
                                                    <option value="Courier" {{ $equipment->mode_receipt == 'Courier' ? 'selected' : '' }}>Courier</option>
                                                    <option value="Others" {{ $equipment->mode_receipt == 'Others' ? 'selected' : '' }}>Others</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Initiator">Initiator</label>
                                                <input disabled type="text" name="initiator_id"
                                                    value="{{ $equipment->initiator_name }}">
                                                {{-- <div class="static"> </div> --}}
                                            </div>
                                        </div>
                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Next Calibration Date">Due Date</label>
                                                <div class="calenderauditee">                                     
                                                    <input type="text"  id="due_date"  readonly placeholder="DD-MMM-YYYY" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }} value="{{ Helpers::getdateFormat($equipment->due_date) }}"/>
                                                    <input type="date" id="due_date_checkdate" name="due_date" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }} value="{{ $equipment->due_date }}" class="hide-input"
                                                    oninput="handleDateInput(this, 'due_date');checkDate('last_calibration_date_checkdate','due_date_checkdate')"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6" id="other_input_field" style="display: none;">
                                            <div class="group-input">
                                                <label for="other_mode">Others<span class="text-danger">*</span></label>
                                                <input readonly type="text" name="other_mode" value="{{ $equipment->other_mode }}" id="other_mode" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }} placeholder="Enter details">
                                            </div>
                                        </div>
                                        
                                        <script>
                                            document.getElementById("mode_receipt").addEventListener("change", function () {
                                                var otherInputField = document.getElementById("other_input_field");
                                                if (this.value === "Others") {
                                                    otherInputField.style.display = "block";
                                                } else {
                                                    otherInputField.style.display = "none";
                                                }
                                            });
                                        
                                            document.getElementById("mode_receipt").dispatchEvent(new Event("change"));
                                        </script>
                                        
                                        <div class="col-lg-6">
                                            <div class="group-input ">
                                                <label for="Date Due"><b>Date</b></label>
                                                <input disabled type="text" value="{{ date('d-M-Y') }}"
                                                    name="intiation_date" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}>
                                                <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}>
                                            </div>
                                        </div> 
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Initiator Group">Department Group </label>
                                                <select name="initiator_Group" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}
                                                     id="initiator_group">
                                                     <option value="">-- Select --</option>
                                                    <option value="CQA"
                                                        @if ($data->initiator_group_code== 'CQA') selected @endif>Corporate Quality Assurance</option>
                                                    <option value="QAB"
                                                        @if ($data->initiator_group_code== 'QAB') selected @endif>Quality Assurance Biopharma</option>
                                                    <option value="CQC"
                                                        @if ($data->initiator_group_code== 'CQC') selected @endif>Central Quality Control</option>
                                                    <option value="MANU"
                                                        @if ($data->initiator_group_code== 'MANU') selected @endif>Manufacturing
                                                    </option>
                                                    <option value="PSG"
                                                        @if ($data->initiator_group_code== 'PSG') selected @endif>Plasma Sourcing Group</option>
                                                    <option value="CS"
                                                        @if ($data->initiator_group_code== 'CS') selected @endif>Central Stores</option>
                                                    <option value="ITG"
                                                        @if ($data->initiator_group_code== 'ITG') selected @endif>Information Technology Group</option>
                                                    <option value="MM"
                                                        @if ($data->initiator_group_code== 'MM') selected @endif>Molecular Medicine</option>
                                                    <option value="CL"
                                                        @if ($data->initiator_group_code== 'CL') selected @endif>Central Laboratory</option>
                                                    <option value="TT"
                                                        @if ($data->initiator_group_code== 'TT') selected @endif>Tech Team</option>
                                                    <option value="QA"
                                                        @if ($data->initiator_group_code== 'QA') selected @endif>Quality Assurance</option>
                                                    <option value="QM"
                                                        @if ($data->initiator_group_code== 'QM') selected @endif>Quality Management</option>
                                                    <option value="IA"
                                                        @if ($data->initiator_group_code== 'IA') selected @endif>IT Administration</option>
                                                    <option value="ACC"
                                                        @if ($data->initiator_group_code== 'ACC') selected @endif>Accounting
                                                    </option>
                                                    <option value="LOG"
                                                        @if ($data->initiator_group_code== 'LOG') selected @endif>Logistics
                                                    </option>
                                                    <option value="SM"
                                                        @if ($data->initiator_group_code== 'SM') selected @endif>Senior Management</option>
                                                    <option value="BA"
                                                        @if ($data->initiator_group_code== 'BA') selected @endif>Business Administration</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Initiator Group Code">Department Group Code</label>
                                                <input readonly type="text" name="initiator_group_code"{{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}
                                                    value="{{ $data->initiator_group_code}}" id="initiator_group_code"
                                                    readonly>
                                                {{-- <div class="static"></div> --}}
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
                                                <label for="Short Description">Received From<span class="text-danger">*</span></label><span id="rchars"
                                                    class="text-primary">100</span><span class="text-primary"> characters
                                                    remaining</span>
                                                <div class="relative-container">
                                                    <input name="received_from" id="docname" type="text"
                                                        value="{{ $equipment->received_from }}" maxlength="100" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Short Description">Brief Description of Sample<span class="text-danger">*</span></label><span id="rcharsss"
                                                    class="text-primary">500</span><span class="text-primary"> characters
                                                    remaining</span>
                                                <div class="relative-container">
                                                    <textarea name="brief_description" id="doceename" 
                                                         maxlength="500" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}>{{ $equipment->brief_description }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Next Calibration Date">Date of Review</label>
                                                <div class="calenderauditee">                                     
                                                    <input type="text"  id="date_of_review"  readonly placeholder="DD-MMM-YYYY" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }} value="{{ Helpers::getdateFormat($equipment->date_of_review) }}"/>
                                                    <input type="date" id="date_of_review_checkdate" name="date_of_review" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }} value="{{ $equipment->date_of_review }}" class="hide-input"
                                                    oninput="handleDateInput(this, 'date_of_review');checkDate('last_calibration_date_checkdate','date_of_review_checkdate')"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Zone">Source of sample<span class="text-danger">*</span></label>
                                                <select name="source_of_sample" id="source_of_sample" onchange="showStakeholderFields()" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}>
                                                    <option value="">--Select--</option>
                                                    <option value="Stakeholder" {{ $equipment->source_of_sample == 'Stakeholder' ? 'selected' : '' }}>Stakeholder</option>
                                                    <option value="Market Purchase" {{ $equipment->source_of_sample == 'Market Purchase' ? 'selected' : '' }}>Market Purchase</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div id="stakeholderFields" style="{{ $equipment->source_of_sample == 'Stakeholder' ? 'display: block;' : 'display: none;' }}">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <label for="stakeholder_email">Stakeholder's Email Address<span class="text-danger">*</span></label>
                                                        <input type="email" id="stakeholder_email" name="stakeholder_email" placeholder="Enter Email" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }} value="{{ $equipment->stakeholder_email }}">
                                                        <span id="email_error" style="color: red; display: none;">Please enter a valid email address.</span>
                                                    </div>
                                                </div> 
                                                <div class="col-lg-6">
                                                    <div class="group-input">
                                                        <label for="stakeholder_contact">Stakeholder's Contact Number<span class="text-danger">*</span></label>
                                                        <input type="text" id="stakeholder_contact" name="stakeholder_contact" placeholder="Enter contact number" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}  value="{{ $equipment->stakeholder_contact }}">
                                                        <span id="contact_error" style="color: red; display: none;">Please enter a valid contact number (only digits, 10 characters)</span>
                                                  </div>
                                                </div> 
                                            </div>
                                        </div>
                                        
                                        
                                        <script>
                                            document.getElementById("source_of_sample").addEventListener("change", showStakeholderFields);
                                        
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
                                        
                                    </div>
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Description">Comment</label>
                                            <textarea class="tiny" name="Sample_at_ipc_Comment" id="Sample_at_ipc_Comment" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}>{{ $equipment->Sample_at_ipc_Comment }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Calibration Procedure Reference/Document">Attachment</label>
                                            <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                            <div class="file-attachment-field">
                                                <div class="file-attachment-list" id="Sample_at_ipc_attachment">
                                                    @if ($equipment->Sample_at_ipc_attachment)
                                                        @foreach (json_decode($equipment->Sample_at_ipc_attachment) as $file)
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
                                                    {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}
                                                        type="file" id="myfile" name="Sample_at_ipc_attachment[]"
                                                        oninput="addMultipleFiles(this, 'Sample_at_ipc_attachment')" multiple>
                                                </div>
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
                        </div>


                            <div id="CCForm2" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Next Calibration Date">Date of Receipt<span class="text-danger">*</span></label>
                                                <div class="calenderauditee">                                     
                                                    <input type="text"  id="date_of_receipt"  readonly placeholder="DD-MMM-YYYY" {{ $data->stage == 2 ? 'required' : 'readonly' }} {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }} value="{{ Helpers::getdateFormat($equipment->date_of_receipt) }}"/>
                                                    <input type="date" id="date_of_receipt_checkdate" name="date_of_receipt" {{ $data->stage == 2 ? 'required' : 'readonly' }} {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }} value="{{ $equipment->date_of_receipt }}" class="hide-input"
                                                    oninput="handleDateInput(this, 'date_of_receipt');checkDate('last_calibration_date_checkdate','date_of_receipt_checkdate')"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Reagent Code">Receptionist Diary Number</label>
                                                <input hidden name="receptionist_diary">
                                                <input readonly type="text" name="receptionist_diary" id="receptionist_diary" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }} value="{{ $equipment->receptionist_diary }}">
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
                                        {{-- <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                // Get references to the required elements
                                                const recordNumberInput = document.querySelector('input[name="record_number"]');
                                                const receiptDivisionSelect = document.getElementById('receipt_division');
                                                const receptionistDiaryInput = document.getElementById('receptionist_diary');
                                        
                                                function updateRecordNumber() {
                                                    const selectedDivision = receiptDivisionSelect.value || 'DIN'; // Default to 'DIN' if no selection
                                                    const currentYear = new Date().getFullYear();
                                                    const recordNumber = '{{ $equipment->record_number ?? "0001" }}'; // Fallback to '0001' if undefined
                                                    const newRecordNumber = `IPC/${selectedDivision}/${currentYear}/${recordNumber}`;
                                        
                                                    // Update values of inputs
                                                    if (recordNumberInput) {
                                                        recordNumberInput.value = newRecordNumber;
                                                    }
                                                    if (receptionistDiaryInput) {
                                                        receptionistDiaryInput.value = newRecordNumber;
                                                    }
                                                }
                                        
                                                // Add event listener for change in the division dropdown
                                                receiptDivisionSelect.addEventListener('change', updateRecordNumber);
                                        
                                                // Initialize on page load
                                                updateRecordNumber();
                                            });
                                        </script> --}}
                                        
                                        <div class="col-12"> 
                                            <div class="group-input">
                                                <label for="Corrective Action">Received From</label>
                                                <input type="text" name="received_from_1" id="received_from_1" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }} value="{{ $equipment->received_from_1 }}">
                                            </div>
                                        </div>
                                        <script>
                                            const receivedFromInput = document.getElementById('docname');
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
                                                <textarea class="tiny" name="brief_description_of_sample_1" id="brief_description_of_sample_1" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }} >{{ $equipment->brief_description_of_sample_1 }}</textarea>
                                            </div>
                                       </div>
                                       <script>
                                            const briefDescriptionInput = document.getElementById('doceename');
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
                                                <label for="Zone">Sample type<span class="text-danger">*</span></label>
                                                <select name="sample_type" id="sampleType" {{ $data->stage == 2 ? 'required' : 'readonly' }} {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}>
                                                    <option value="">--Select--</option>
                                                    <option value="N" {{ $equipment->sample_type == 'N' ? 'selected' : '' }}>New Drug Substance</option>
                                                    <option value="I" {{ $equipment->sample_type == 'I' ? 'selected' : '' }}>Indian Pharmacopoeia Reference Standard</option>
                                                    <option value="T" {{ $equipment->sample_type == 'T' ? 'selected' : '' }}>Proficiency Testing</option>
                                                    <option value="C" {{ $equipment->sample_type == 'C' ? 'selected' : '' }}>Inter Laboratory Comparison</option>
                                                    <option value="P" {{ $equipment->sample_type == 'P' ? 'selected' : '' }}>Phytopharmaceutical</option>
                                                    <option value="M" {{ $equipment->sample_type == 'M' ? 'selected' : '' }}>Miscellaneous</option>
                                                    <option value="0" {{ $equipment->sample_type == '0' ? 'selected' : '' }}>Others</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 other-sample-section" style="display: none;">
                                            <div class="group-input">
                                                <label for="other_sample_type">Others<span class="text-danger">*</span></label>
                                                <input type="text" class="other-sample-type" name="other_sample_type"
                                                    placeholder="Enter details here..."
                                                    {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}  value="{{ $equipment->other_sample_type ?? '' }}" />
                                            </div>
                                        </div>

                                        <script>
                                            document.addEventListener("DOMContentLoaded", function () {
                                                const dropdown = document.querySelector(".sample-type");
                                                const otherSection = document.querySelector(".other-sample-section");
                                                const otherInput = document.querySelector(".other-sample-type");

                                                dropdown.addEventListener("change", function () {
                                                    if (dropdown.value === "Others") {
                                                        otherSection.style.display = "block";
                                                    } else {
                                                        otherSection.style.display = "none";
                                                        otherInput.value = ""; 
                                                    }
                                                });

                                                if (dropdown.value === "Others") {
                                                    otherSection.style.display = "block";
                                                }
                                            });
                                        </script>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Calibration Procedure Reference/Document">Attachment</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="attachment_receptionist">
                                                        @if ($equipment->attachment_receptionist)
                                                            @foreach (json_decode($equipment->attachment_receptionist) as $file)
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
                                                            {{ $equipment->stage == 0 || $equipment->stage == 11 ? 'disabled' : '' }}
                                                            type="file" id="myfile" name="attachment_receptionist[]"
                                                            oninput="addMultipleFiles(this, 'attachment_receptionist')" multiple>
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
                                            Sample Coordinator
                                            <button type="button" name="audit-agenda-grid" id="ObservationAdd" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}>+</button>
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#observation-field-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                (Launch Instruction)
                                            </span>
                                           </div>
                                        </label>
                                        <div class="table-responsive table-container">
                                            <table class="table table-bordered" id="job-responsibilty-table" style="width: 100%;">
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
                                                            <th style="border: 1px solid #000; padding: 8px; display:none;"><div style="width: 200px;">LSL</div></th>
                                                            <th style="border: 1px solid #000; padding: 8px; display:none;"><div style="width: 200px;">USL</div></th>
                                                            <th style="border: 1px solid #000; padding: 8px; display:none;"><div style="width: 200px;">Observed Value</div></th>
                                                            <th style="border: 1px solid #000; padding: 8px; display:none;"><div style="width: 200px;">Analyst Name</div></th>
                                                            <th style="border: 1px solid #000; padding: 8px;"><div style="width: 100px;">Action</div></th>
                                                        </tr>
                                                    </thead>
                                                <tbody>
                                                    @if ($ReceiptCoordinatorGrid && is_array($ReceiptCoordinatorGrid->data))
                                                        @foreach ($ReceiptCoordinatorGrid->data as $index => $receipt_grid)
                                                            <tr>
                                                                <td><input disabled type="text" name="sample_coordinator[{{ $loop->index }}][serial]" value="{{ $loop->index+1 }}"></td>
                                                                <td><input type="text" class="datepicker" name="sample_coordinator[{{ $loop->index }}][assignment_date]" placeholder="DD-MM-YYYY" {{ $data->stage == 3 ? 'required' : 'readonly' }} value="{{ array_key_exists('assignment_date', $receipt_grid) ? $receipt_grid['assignment_date'] : '' }}"></td>
                                                                <td><input type="text" name="sample_coordinator[{{ $loop->index }}][analytical_receipt]" value="{{ array_key_exists('analytical_receipt', $receipt_grid) ? $receipt_grid['analytical_receipt'] : '' }}"></td>
                                                                <td><input type="text" name="sample_coordinator[{{ $loop->index }}][sample_name]" value="{{ array_key_exists('sample_name', $receipt_grid) ? $receipt_grid['sample_name'] : '' }}" {{ $data->stage == 3 ? 'required' : 'readonly' }}></td>
                                                                <td><input type="text" name="sample_coordinator[{{ $loop->index }}][Batch]" value="{{ array_key_exists('Batch', $receipt_grid) ? $receipt_grid['Batch'] : '' }}" {{ $data->stage == 3 ? 'required' : 'readonly' }}></td>
                                                                <td><input type="text" name="sample_coordinator[{{ $loop->index }}][sample_quantity]" value="{{ array_key_exists('sample_quantity', $receipt_grid) ? $receipt_grid['sample_quantity'] : '' }}" {{ $data->stage == 3 ? 'required' : 'readonly' }}></td>
                                                                <td><input type="text" class="datepicker" name="sample_coordinator[{{ $loop->index }}][manufacturing_date]" placeholder="DD-MM-YYYY" value="{{ array_key_exists('manufacturing_date', $receipt_grid) ? $receipt_grid['manufacturing_date'] : '' }}" {{ $data->stage == 3 ? 'required' : 'readonly' }}></td>
                                                                <td><input type="text" class="datepicker" name="sample_coordinator[{{ $loop->index }}][expiry_date]" placeholder="DD-MM-YYYY" value="{{ array_key_exists('expiry_date', $receipt_grid) ? $receipt_grid['expiry_date'] : '' }}" {{ $data->stage == 3 ? 'required' : 'readonly' }}></td>
                                                                <td><input type="text" name="sample_coordinator[{{ $loop->index }}][recommended_storage]" value="{{ array_key_exists('recommended_storage', $receipt_grid) ? $receipt_grid['recommended_storage'] : '' }}" {{ $data->stage == 3 ? 'required' : 'readonly' }}></td>
                                                                <td><input type="text" name="sample_coordinator[{{ $loop->index }}][physical_observation]" value="{{ array_key_exists('physical_observation', $receipt_grid) ? $receipt_grid['physical_observation'] : '' }}" {{ $data->stage == 3 ? 'required' : 'readonly' }}></td>
                                                                <td><input type="text" name="sample_coordinator[{{ $loop->index }}][Remarks]" value="{{ array_key_exists('Remarks', $receipt_grid) ? $receipt_grid['Remarks'] : '' }}" {{ $data->stage == 3 ? 'required' : 'readonly' }}></td>
                                                                <td style="display: none;"><input type="hidden" name="sample_coordinator[{{ $loop->index }}][LSL]" value="{{ array_key_exists('LSL', $receipt_grid) ? $receipt_grid['LSL'] : '' }}"></td>
                                                                <td style="display: none;"><input type="hidden" name="sample_coordinator[{{ $loop->index }}][USL]" value="{{ array_key_exists('USL', $receipt_grid) ? $receipt_grid['USL'] : '' }}"></td>
                                                                <td style="display: none;"><input type="hidden" name="sample_coordinator[{{ $loop->index }}][observed_value]" value="{{ array_key_exists('observed_value', $receipt_grid) ? $receipt_grid['observed_value'] : '' }}"></td>
                                                                <td style="display: none;"><input type="hidden" name="sample_coordinator[{{ $loop->index }}][analyst_name]" value="{{ array_key_exists('analyst_name', $receipt_grid) ? $receipt_grid['analyst_name'] : '' }}"></td>
                                                                <td><button type="button" class="btn btn-danger remove-row">Remove</button></td>
                                                                <script>
                                                                    $(document).ready(function () {
                                                                        $(".datepicker").datepicker({
                                                                            dateFormat: "d-M-yy" 
                                                                        });
                                                                    });
                                                                </script>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                       {{-- N/A --}}
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">Sample Coordinator Comment<span class="text-danger">*</span></label>
                                        <textarea  name="Sample_coordinator_Comment" id="Sample_coordinator_Comment" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}>{{ $equipment->Sample_coordinator_Comment }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Calibration Procedure Reference/Document">Sample Coordinator Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Sample_coordinator_attachment">
                                                @if ($equipment->Sample_coordinator_attachment)
                                                    @foreach (json_decode($equipment->Sample_coordinator_attachment) as $file)
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
                                                {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}
                                                    type="file" id="myfile" name="Sample_coordinator_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Sample_coordinator_attachment')" multiple>
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
                           
                            <!-- Water Consumption Detail ****************************-->
                            <div id="CCForm4" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        {{-- <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Zone">Analysis Type</label>
                                                <select name="analysis_type" id="analysis_type" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }} onchange="handleSampleAnalysisChange(this.value)">
                                                    <option value="">--Select--</option>
                                                    <option value="details" {{ $equipment->analysis_type == 'details' ? 'selected' : '' }}>Details Analysis</option>
                                                    <option value="assay" {{ $equipment->analysis_type == 'assay' ? 'selected' : '' }}>Assay Testing</option>
                                                    <option value="dissolution" {{ $equipment->analysis_type == 'dissolution' ? 'selected' : '' }}>Dissolution Test</option>
                                                </select>
                                            </div>
                                        </div> --}}
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="checklists">Analysis Type<span class="text-danger">*</span></label>
                                                @php
                                                    $ChecklistData = explode(',',$equipment->analysis_type);
                                                @endphp
                                                <select multiple id="analysis_type" class="abc" name="analysis_type[]" {{ $data->stage == 4 ? 'required' : 'readonly' }}>
                                                    <option value="Details-Analysis" @if (in_array('Details-Analysis', $ChecklistData)) selected @endif>Related Substance</option>
                                                    <option value="Assay-Testing" @if (in_array('Assay-Testing', $ChecklistData)) selected @endif>Assay Analysis</option>
                                                    <option value="Dissolution-Test" @if (in_array('Dissolution-Test', $ChecklistData)) selected @endif>Dissolution Analysis</option>
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
                                            function handleSampleAnalysisChange(selectedValue) {
                                                document.querySelector('.btn-details').style.display = 'none';
                                                document.querySelector('.btn-assay').style.display = 'none';
                                                document.querySelector('.btn-dissolution').style.display = 'none';
                                        
                                                if (selectedValue === 'details') {
                                                    document.querySelector('.btn-details').style.display = 'inline-block';
                                                } else if (selectedValue === 'assay') {
                                                    document.querySelector('.btn-assay').style.display = 'inline-block';
                                                } else if (selectedValue === 'dissolution') {
                                                    document.querySelector('.btn-dissolution').style.display = 'inline-block';
                                                }
                                            }
                                        
                                            document.addEventListener('DOMContentLoaded', () => {
                                                const selectedValue = document.getElementById('analysis_type').value;
                                                handleSampleAnalysisChange(selectedValue);
                                            });
                                        </script> --}}
                                        
                                        
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Zone">Selection of Specifications or Standard Test Protocols (STPs)<span class="text-danger">*</span></label>
                                                <select id="specifications" name="specifications" {{ $data->stage == 4 ? 'required' : 'readonly' }} {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }} onchange="handleSpecificationChange(this.value)">
                                                    <option value="">--Select--</option>
                                                    <option value="Manufacturers Specifications" {{ $equipment->specifications == 'Manufacturers Specifications' ? 'selected' : '' }}>Manufacturers Specifications</option>
                                                    <option value="British Pharmacopoeia (BP)" {{ $equipment->specifications == 'British Pharmacopoeia (BP)' ? 'selected' : '' }}>British Pharmacopoeia (BP)</option>
                                                    <option value="European Pharmacopoeia (Ph. Eur.)" {{ $equipment->specifications == 'European Pharmacopoeia (Ph. Eur.)' ? 'selected' : '' }}>European Pharmacopoeia (Ph. Eur.)</option>
                                                    <option value="United States Pharmacopeia (USP)" {{ $equipment->specifications == 'United States Pharmacopeia (USP)' ? 'selected' : '' }}>United States Pharmacopeia (USP)</option>
                                                    <option value="Manufacturer’s STPs" {{ $equipment->specifications == 'Manufacturer’s STPs' ? 'selected' : '' }}>Manufacturer’s STPs</option>
                                                    <option value="Other Sources" {{ $equipment->specifications == 'Other Sources' ? 'selected' : '' }}>Other Sources</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <div id="details_section" style="display: none; margin-top: 10px;">
                                                    <label for="details">Details:</label>
                                                    <textarea id="details" name="details" rows="4" cols="50" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }} placeholder="Enter details here...">{{ $equipment->details }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="group-input" id="attachment_analysis">
                                                <label for="Calibration Procedure Reference/Document">Attachment</label>
                                                <div>
                                                    <small class="text-primary">Please attach all relevant or supporting documents</small>
                                                </div>
                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list">
                                                        @if ($equipment->attachment_analysis)
                                                            @foreach (json_decode($equipment->attachment_analysis) as $file)
                                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                    <b>{{ $file }}</b>
                                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank">
                                                                        <i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i>
                                                                    </a>
                                                                    <a type="button" class="remove-file" data-file-name="{{ $file }}">
                                                                        <i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i>
                                                                    </a>
                                                                </h6>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                    <div class="add-btn">
                                                        <div>Add</div>
                                                        <input {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}
                                                            type="file" 
                                                            id="myfile" 
                                                            name="attachment_analysis[]" 
                                                            oninput="addMultipleFiles(this, 'attachment_analysis')" 
                                                            multiple>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <script>
                                            function handleSpecificationChange(value) {
                                                const detailsSection = document.getElementById("details_section");
                                                const attachmentAnalysis = document.getElementById("attachment_analysis");
                                        
                                                detailsSection.style.display = "none";
                                                attachmentAnalysis.style.display = "none";
                                        
                                                if (value === "Manufacturer’s STPs" || value === "Other Sources") {
                                                    detailsSection.style.display = "block";
                                                    attachmentAnalysis.style.display = "block";
                                                }
                                            }
                                        
                                            document.addEventListener("DOMContentLoaded", function () {
                                                const selectedValue = document.getElementById("specifications").value;
                                                handleSpecificationChange(selectedValue);
                                            });
                                        </script>
                                        
                                        
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
                                                <label for="Zone">Acknowledgement<span class="text-danger">*</span></label>
                                                <select name="Acknowledgement" id="Acknowledgement" {{ $data->stage == 5 ? 'required' : 'readonly' }} {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}>
                                                    <option value="">--Select--</option>
                                                    <option value="Yes" {{ $equipment->Acknowledgement == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                    <option value="No" {{ $equipment->Acknowledgement == 'No' ? 'selected' : '' }}>No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Zone">MOA Change Needed<span class="text-danger">*</span></label>
                                                <select name="moa_change_needed" id="moa_change_needed" {{ $data->stage == 5 ? 'required' : 'readonly' }} {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}>
                                                    <option value="">--Select--</option>
                                                    <option value="Yes" {{ $equipment->moa_change_needed == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                    <option value="No" {{ $equipment->moa_change_needed == 'No' ? 'selected' : '' }}>No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12" id="moa_change_details_container" style="display: none;">
                                            <div class="group-input">
                                                <label for="Description">MOA Change Details<span class="text-danger">*</span></label>
                                                <textarea class="tiny" name="moa_change_details" id="moa_change_details" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}>{{ $equipment->moa_change_details }}</textarea>
                                            </div>
                                        </div>
                                        
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function () {
                                                const moaChangeNeeded = document.getElementById("moa_change_needed");
                                                const moaChangeDetailsContainer = document.getElementById("moa_change_details_container");
                                        
                                                function toggleMoaDetails() {
                                                    if (moaChangeNeeded.value === "Yes") {
                                                        moaChangeDetailsContainer.style.display = "block";
                                                    } else {
                                                        moaChangeDetailsContainer.style.display = "none";
                                                    }
                                                }
                                        
                                                toggleMoaDetails();
                                        
                                                moaChangeNeeded.addEventListener("change", toggleMoaDetails);
                                            });
                                        </script>
                                            <div class="col-lg-6 new-date-data-field">
                                                <div class="group-input input-date">
                                                    <label for="Next Preventive Maintenance Date">Analysis Start Date</label>
                                                    <input type="text" name="analysis_start_date" id="analysis_start_date" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }} value="{{ $equipment->analysis_start_date }}" class="datetimepicker" placeholder="Select Date and Time">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 new-date-data-field">
                                                <div class="group-input input-date">
                                                    <label for="Next Preventive Maintenance Date">Analysis End Date</label>
                                                    <input type="text" name="analysis_end_date" id="analysis_end_date" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }} value="{{ $equipment->analysis_end_date }}" class="datetimepicker" placeholder="Select Date and Time">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 new-date-data-field">
                                                <div class="group-input input-date">
                                                    <label for="Next Preventive Maintenance Date">Turn Around Time (TAT)</label>
                                                    <input type="text" name="turn_around_time" id="turn_around_time" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }} value="{{ $equipment->turn_around_time }}" readonly placeholder="Turn Around Time">
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="review_1_person">Reviewer-1<span class="text-danger">*</span></label>
                                                    <select multiple name="review_1_person[]" id="review_1_person" data-search="true" data-silent-initial-value-set="true" {{ $data->stage == 5 ? 'required' : 'readonly' }}>
                                                        @if($users)
                                                            @php
                                                                $selected_reviewers = $equipment->review_1_person ? explode(',', $equipment->review_1_person) : [];
                                                            @endphp
                                            
                                                            @foreach($users as $user)
                                                                <option value="{{ $user->id }}" 
                                                                    @if(in_array($user->id, $selected_reviewers)) selected @endif>
                                                                    {{ $user->name }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="hod_person">Reviewer-2<span class="text-danger">*</span></label>
                                                    <select multiple data-search="false"
                                                    data-silent-initial-value-set="true" name="review_2_person[]" id="reviewerPerson2" {{ $data->stage == 5 ? 'required' : 'readonly' }}>
                                                        @if($users)
                                                        @php
                                                            $selected_reviewers2 = $equipment->review_2_person ? explode(',', $equipment->review_2_person) : [];
                                                        @endphp
                                                        @foreach($users as $user)
                                                            <option value="{{ $user->id }}" 
                                                                @if(in_array($user->id, $selected_reviewers2)) selected @endif>
                                                                {{ $user->name }}
                                                            </option>
                                                        @endforeach
                                                            {{-- @foreach($users as $usr)
                                                                <option value="{{ $usr->id }}" @if ($usr->id == $equipment->review_2_person) selected @endif>{{ $usr->name }}</option>
                                                            @endforeach --}}
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="group-input">
                                                    <label for="hod_person">Approver<span class="text-danger">*</span></label>
                                                    <select multiple data-search="false"    
                                                    data-silent-initial-value-set="true" name="approver_person[]" id="approverPerson" {{ $data->stage == 5 ? 'required' : 'readonly' }}>
                                                        @if($users)
                                                            @php
                                                                $selected_reviewers3 = $equipment->approver_person ? explode(',', $equipment->approver_person) : [];
                                                            @endphp
                                                            @foreach($users as $user)
                                                                <option value="{{ $user->id }}" 
                                                                    @if(in_array($user->id, $selected_reviewers3)) selected @endif>
                                                                    {{ $user->name }}
                                                                </option>
                                                            @endforeach
                                                            {{-- @foreach($users as $use)
                                                                <option value="{{ $use->id }}" @if ($use->id == $equipment->approver_person) selected @endif>{{ $use->name }}</option>
                                                            @endforeach --}}
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
                                            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
                                            
                                            <script>
                                                document.addEventListener('DOMContentLoaded', function () {
                                                    flatpickr(".datetimepicker", {
                                                        enableTime: true,
                                                        dateFormat: "d-M-Y H:i",
                                                        time_24hr: true,
                                                        onChange: calculateTAT
                                                    });
                                            
                                                    function calculateTAT() {
                                                        const startDate = document.getElementById("analysis_start_date").value;
                                                        const endDate = document.getElementById("analysis_end_date").value;
                                            
                                                        if (startDate && endDate) {
                                                            const start = new Date(startDate);
                                                            const end = new Date(endDate);
                                            
                                                            const diffMs = end - start;
                                            
                                                            if (diffMs >= 0) {
                                                                const days = Math.floor(diffMs / (1000 * 60 * 60 * 24));
                                                                const hours = Math.floor((diffMs % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                                const minutes = Math.floor((diffMs % (1000 * 60 * 60)) / (1000 * 60));
                                            
                                                                document.getElementById("turn_around_time").value = `${days}d ${hours}h ${minutes}m`;
                                                            } else {
                                                                alert("End date must be after the start date!");
                                                                document.getElementById("turn_around_time").value = "";
                                                            }
                                                        }
                                                    }
                                            
                                                     document.getElementById("analysis_start_date").addEventListener("change", calculateTAT);
                                                    document.getElementById("analysis_end_date").addEventListener("change", calculateTAT);
                                                });
                                            </script>
                                            <div class="inner-block-content">
                                                <div class="pt-2 group-input">
                                                    <label style="display: flex; justify-content: space-between;" for="audit-agenda-grid">
                                                       <div>
                                                        Sample Coordinator
                                                        <button type="button" name="audit-agenda-grid" id="Observation" disabled>+</button>
                                                        <span class="text-primary" data-bs-toggle="modal"
                                                            data-bs-target="#observation-field-instruction-modal"
                                                            style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                            (Launch Instruction)
                                                        </span>
                                                       </div>
                                                    </label>
                                                    <div class="table-responsive table-container">
                                                        <table class="table table-bordered" id="job-result-table" style="width: 100%;">
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
                                                                        <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">LSL</div></th>
                                                                        <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">USL</div></th>
                                                                        <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Observed Value</div></th>
                                                                        <th style="border: 1px solid #000; padding: 8px;"><div style="width: 200px;">Analyst Name</div></th>
                                                                        <th style="border: 1px solid #000; padding: 8px;"><div style="width: 100px;">Action</div></th>
                                                                    </tr>
                                                                </thead>
                                                            <tbody>
                                                                @if ($ReceiptCoordinatorGrid && is_array($ReceiptCoordinatorGrid->data))
                                                                    @foreach ($ReceiptCoordinatorGrid->data as $index => $receipt_grid)
                                                                        <tr>
                                                                            <td><input disabled type="text" name="sample_coordinator[{{ $loop->index }}][serial]" value="{{ $loop->index+1 }}"></td>
                                                                            <td><input type="text" class="datepicker" readonly name="sample_coordinator[{{ $loop->index }}][assignment_date]" placeholder="DD-MM-YYYY" value="{{ array_key_exists('assignment_date', $receipt_grid) ? $receipt_grid['assignment_date'] : '' }}"></td>
                                                                            <td><input type="text" readonly name="sample_coordinator[{{ $loop->index }}][analytical_receipt]" value="{{ array_key_exists('analytical_receipt', $receipt_grid) ? $receipt_grid['analytical_receipt'] : '' }}"></td>
                                                                            <td><input type="text" readonly name="sample_coordinator[{{ $loop->index }}][sample_name]" value="{{ array_key_exists('sample_name', $receipt_grid) ? $receipt_grid['sample_name'] : '' }}"></td>
                                                                            <td><input type="text" readonly name="sample_coordinator[{{ $loop->index }}][Batch]" value="{{ array_key_exists('Batch', $receipt_grid) ? $receipt_grid['Batch'] : '' }}"></td>
                                                                            <td><input type="text" readonly name="sample_coordinator[{{ $loop->index }}][sample_quantity]" value="{{ array_key_exists('sample_quantity', $receipt_grid) ? $receipt_grid['sample_quantity'] : '' }}"></td>
                                                                            <td><input type="text" readonly class="datepicker" name="sample_coordinator[{{ $loop->index }}][manufacturing_date]" placeholder="DD-MM-YYYY" value="{{ array_key_exists('manufacturing_date', $receipt_grid) ? $receipt_grid['manufacturing_date'] : '' }}"></td>
                                                                            <td><input type="text" readonly class="datepicker" name="sample_coordinator[{{ $loop->index }}][expiry_date]" placeholder="DD-MM-YYYY" value="{{ array_key_exists('expiry_date', $receipt_grid) ? $receipt_grid['expiry_date'] : '' }}"></td>
                                                                            <td><input type="text" readonly name="sample_coordinator[{{ $loop->index }}][recommended_storage]" value="{{ array_key_exists('recommended_storage', $receipt_grid) ? $receipt_grid['recommended_storage'] : '' }}"></td>
                                                                            <td><input type="text" readonly name="sample_coordinator[{{ $loop->index }}][physical_observation]" value="{{ array_key_exists('physical_observation', $receipt_grid) ? $receipt_grid['physical_observation'] : '' }}"></td>
                                                                            <td><input type="text" readonly name="sample_coordinator[{{ $loop->index }}][Remarks]" {{ $data->stage == 0 || $data->stage == 5 ? 'readonly' : '' }} value="{{ array_key_exists('Remarks', $receipt_grid) ? $receipt_grid['Remarks'] : '' }}"></td>
                                                                            <td><input type="text" name="sample_coordinator[{{ $loop->index }}][LSL]" value="{{ array_key_exists('LSL', $receipt_grid) ? $receipt_grid['LSL'] : '' }}" {{ $data->stage == 5 ? '' : 'readonly' }}></td>
                                                                            <td><input type="text" name="sample_coordinator[{{ $loop->index }}][USL]" value="{{ array_key_exists('USL', $receipt_grid) ? $receipt_grid['USL'] : '' }}" {{ $data->stage == 5 ? '' : 'readonly' }}></td>
                                                                            <td><input type="text" name="sample_coordinator[{{ $loop->index }}][observed_value]" value="{{ array_key_exists('observed_value', $receipt_grid) ? $receipt_grid['observed_value'] : '' }}" {{ $data->stage == 5 ? '' : 'readonly' }}></td>
                                                                            <td><input type="text" name="sample_coordinator[{{ $loop->index }}][analyst_name]" value="{{ array_key_exists('analyst_name', $receipt_grid) ? $receipt_grid['analyst_name'] : '' }}" {{ $data->stage == 5 ? '' : 'readonly' }}></td>
                                                                            <td><button type="button" readonly class="btn btn-danger remove-row">Remove</button></td>
                                                                            <script>
                                                                                $(document).ready(function () {
                                                                                    $(".datepicker").datepicker({
                                                                                        dateFormat: "d-M-yy" 
                                                                                    });
                                                                                });
                                                                            </script>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                   {{-- N/A --}}
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="group-input">
                                                    <label for="Description">Sample Analysis Comment</label>
                                                    <textarea class="tiny" name="sample_analysis_Comment" id="sample_analysis_Comment" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}>{{ $equipment->sample_analysis_Comment }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="group-input">
                                                    <label for="Calibration Procedure Reference/Document">Sample Analysis Attachment</label>
                                                    <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                    <div class="file-attachment-field">
                                                        <div class="file-attachment-list" id="sample_analysis_attachment">
                                                            @if ($equipment->sample_analysis_attachment)
                                                                @foreach (json_decode($equipment->sample_analysis_attachment) as $file)
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
                                                            {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}
                                                                type="file" id="myfile" name="sample_analysis_attachment[]"
                                                                oninput="addMultipleFiles(this, 'sample_analysis_attachment')" multiple>
                                                        </div>
                                                    </div>
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


                                    <div class="d-flex align-item-end justify-content-end">
                      
                                        <button style="margin-bottom:20px;" class="button_theme1"> <a
                                                class="text-white"
                                                href="{{ url('detailstandardanalysis', $data->id) }}"> Print </a>
                                        </button>
                                    </div>
                                     <div class="row">

                                       
                                        <div class="col-12 sub-head">
                                            Details of Standards and Samples:
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Material Details">
                                                    Details of Standards and Samples:
                                                    <button type="button" id="addDetails_Standards" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}>+</button>
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
                                                            @if (!empty($Details_of_Standards) && is_array($Details_of_Standards->data))
                                                                @foreach ($Details_of_Standards->data as $index => $sample)
                                                                    <tr>
                                                                        <td><input disabled type="text" name="standards_samples_details[{{ $index }}][row]" value="{{ $index + 1 }}"></td>
                                                                        <td><input type="text" name="standards_samples_details[{{ $index }}][reg_no]" value="{{ $sample['reg_no'] }}"></td>
                                                                        <td><input type="date" name="standards_samples_details[{{ $index }}][date]" value="{{ $sample['date'] }}"></td>
                                                                        <td><input type="text" name="standards_samples_details[{{ $index }}][name]" value="{{ $sample['name'] }}"></td>
                                                                        <td><input type="number" name="standards_samples_details[{{ $index }}][qty]" value="{{ $sample['qty'] }}"></td>
                                                                        <td><input type="text" name="standards_samples_details[{{ $index }}][batch_company]" value="{{ $sample['batch_company'] }}"></td>
                                                                        <td><input type="date" name="standards_samples_details[{{ $index }}][mfg_date]" value="{{ $sample['mfg_date'] }}"></td>
                                                                        <td><input type="date" name="standards_samples_details[{{ $index }}][exp_date]" value="{{ $sample['exp_date'] }}"></td>
                                                                        <td><button type="button" class="removeRowBtn">Remove</button></td>
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                <tr class="no-data">
                                                                    <td colspan="9">No data found</td>
                                                                </tr>
                                                            @endif
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
                                                        return (
                                                            '<tr>' +
                                                            '<td><input disabled type="text" name="standards_samples_details[' + serialNumber + '][row]" value="' + (serialNumber + 1) + '"></td>' +
                                                            '<td><input type="text" name="standards_samples_details[' + serialNumber + '][reg_no]"></td>' +
                                                            '<td><input type="date" name="standards_samples_details[' + serialNumber + '][date]"></td>' +
                                                            '<td><input type="text" name="standards_samples_details[' + serialNumber + '][name]"></td>' +
                                                            '<td><input type="number" name="standards_samples_details[' + serialNumber + '][qty]"></td>' +
                                                            '<td><input type="text" name="standards_samples_details[' + serialNumber + '][batch_company]"></td>' +
                                                            '<td><input type="date" name="standards_samples_details[' + serialNumber + '][mfg_date]"></td>' +
                                                            '<td><input type="date" name="standards_samples_details[' + serialNumber + '][exp_date]"></td>' +
                                                            '<td><button type="button" class="removeRowBtn">Remove</button></td>' +
                                                            '</tr>'
                                                        );
                                                    }
                                        
                                                    var tableBody = $('#Details_Standards tbody');
                                                    var rowCount = tableBody.children('tr').not('.no-data').length;
                                        
                                                    // Remove "No data found" row if it exists
                                                    if (rowCount === 0) {
                                                        tableBody.find('.no-data').remove();
                                                        rowCount = 0; // Start count from 0 if no rows exist
                                                    }
                                        
                                                    var newRow = generateStandardsSamplesTableRow(rowCount);
                                                    tableBody.append(newRow);
                                                });
                                        
                                                // Remove row in Details of Standards and Samples table
                                                $(document).on('click', '.removeRowBtn', function() {
                                                    $(this).closest('tr').remove();
                                        
                                                    // Check if table is empty after deletion, add "No data found" row if so
                                                    if ($('#Details_Standards tbody tr').length === 0) {
                                                        $('#Details_Standards tbody').append('<tr class="no-data"><td colspan="9">No data found</td></tr>');
                                                    }
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
                                                    <button type="button" id="addDetails_Chemicals" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}>+</button>
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
                                                            @if (!empty($Details_of_Chemicals->data) && is_array($Details_of_Chemicals->data))
                                                                @foreach ($Details_of_Chemicals->data as $index => $detail)
                                                                    <tr>
                                                                        <td><input disabled type="text" name="chemicals_reagents_details[{{ $index }}][row]" value="{{ $index + 1 }}"></td>
                                                                        <td>
                                                                            <select name="chemicals_reagents_details[{{ $index }}][name]">
                                                                                <option value="">Select</option>
                                                                                <option value="Potassium Hydrogen Phosphate" {{ $detail['name'] == 'Potassium Hydrogen Phosphate' ? 'selected' : '' }}>Potassium Hydrogen Phosphate</option>
                                                                                <option value="Potassium Hydroxide" {{ $detail['name'] == 'Potassium Hydroxide' ? 'selected' : '' }}>Potassium Hydroxide</option>
                                                                                <option value="Acetonitrile" {{ $detail['name'] == 'Acetonitrile' ? 'selected' : '' }}>Acetonitrile</option>
                                                                                <option value="Water" {{ $detail['name'] == 'Water' ? 'selected' : '' }}>Water</option>
                                                                            </select>
                                                                        </td>
                                                                        <td><input type="text" name="chemicals_reagents_details[{{ $index }}][make]" value="{{ $detail['make'] ?? '' }}"></td>
                                                                        <td><input type="text" name="chemicals_reagents_details[{{ $index }}][batch_lot_no]" value="{{ $detail['batch_lot_no'] ?? '' }}"></td>
                                                                        <td><input type="date" name="chemicals_reagents_details[{{ $index }}][mfg_date]" value="{{ $detail['mfg_date'] ?? '' }}"></td>
                                                                        <td><input type="date" name="chemicals_reagents_details[{{ $index }}][exp_date]" value="{{ $detail['exp_date'] ?? '' }}"></td>
                                                                        <td><button type="button" class="removeRowBtn">Remove</button></td>
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                <tr class="no-data">
                                                                    <td colspan="7">No data found</td>
                                                                </tr>
                                                            @endif
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
                                                        return (
                                                            '<tr>' +
                                                            '<td><input disabled type="text" name="chemicals_reagents_details[' + serialNumber + '][row]" value="' + (serialNumber + 1) + '"></td>' +
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
                                                            '</tr>'
                                                        );
                                                    }
                                        
                                                    var tableBody = $('#Details_Chemicals tbody');
                                                    var rowCount = tableBody.children('tr').not('.no-data').length;
                                        
                                                    // Remove "No data found" row if it exists
                                                    if (rowCount === 0) {
                                                        tableBody.find('.no-data').remove();
                                                        rowCount = 0; // Start count from 0 if no rows exist
                                                    }
                                        
                                                    var newRow = generateChemicalsReagentsTableRow(rowCount);
                                                    tableBody.append(newRow);
                                                });
                                        
                                                // Remove row in Details of Chemicals and Reagents table
                                                $(document).on('click', '.removeRowBtn', function() {
                                                    $(this).closest('tr').remove();
                                        
                                                    // Check if table is empty after deletion, add "No data found" row if so
                                                    if ($('#Details_Chemicals tbody tr').length === 0) {
                                                        $('#Details_Chemicals tbody').append('<tr class="no-data"><td colspan="7">No data found</td></tr>');
                                                    }
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
                                    <button type="button" id="addDetails_Instruments" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}>+</button>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="Details_Instruments" style="width: 100%;">
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
                                            @if (!empty($Details_of_Instruments->data) && is_array($Details_of_Instruments->data))
                                                @foreach ($Details_of_Instruments->data as $index => $instrument)
                                                    <tr>
                                                        <td><input disabled type="text" name="instruments_used_details[{{ $index }}][row]" value="{{ $index + 1 }}"></td>
                                                        <td><input type="text" name="instruments_used_details[{{ $index }}][name]" value="{{ $instrument['name'] ?? '' }}"></td>
                                                        <td><input type="text" name="instruments_used_details[{{ $index }}][id]" value="{{ $instrument['id'] ?? '' }}"></td>
                                                        <td><input type="date" name="instruments_used_details[{{ $index }}][calibration_on]" value="{{ $instrument['calibration_on'] ?? '' }}"></td>
                                                        <td><input type="date" name="instruments_used_details[{{ $index }}][calibration_due]" value="{{ $instrument['calibration_due'] ?? '' }}"></td>
                                                        <td><button type="button" class="removeRowBtn">Remove</button></td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr class="no-data">
                                                    <td colspan="6">No data found</td>
                                                </tr>
                                            @endif
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
                                        return (
                                            '<tr>' +
                                            '<td><input disabled type="text" name="instruments_used_details[' + serialNumber + '][row]" value="' + (serialNumber + 1) + '"></td>' +
                                            '<td><input type="text" name="instruments_used_details[' + serialNumber + '][name]"></td>' +
                                            '<td><input type="text" name="instruments_used_details[' + serialNumber + '][id]"></td>' +
                                            '<td><input type="date" name="instruments_used_details[' + serialNumber + '][calibration_on]"></td>' +
                                            '<td><input type="date" name="instruments_used_details[' + serialNumber + '][calibration_due]"></td>' +
                                            '<td><button type="button" class="removeRowBtn">Remove</button></td>' +
                                            '</tr>'
                                        );
                                    }
                        
                                    var tableBody = $('#Details_Instruments tbody');
                                    var rowCount = tableBody.children('tr').not('.no-data').length;
                        
                                    // Remove "No data found" row if it exists
                                    if (rowCount === 0) {
                                        tableBody.find('.no-data').remove();
                                        rowCount = 0; // Start count from 0 if no rows exist
                                    }
                        
                                    var newRow = generateInstrumentsTableRow(rowCount);
                                    tableBody.append(newRow);
                                });
                        
                                // Remove row in Details of Instruments Used table
                                $(document).on('click', '.removeRowBtn', function() {
                                    $(this).closest('tr').remove();
                        
                                    // Check if table is empty after deletion, add "No data found" row if so
                                    if ($('#Details_Instruments tbody tr').length === 0) {
                                        $('#Details_Instruments tbody').append('<tr class="no-data"><td colspan="6">No data found</td></tr>');
                                    }
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
                                    <button type="button" id="addDetails_RelatedSubstances" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}>+</button>
                                </label>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="Details_RelatedSubstances" style="width: 100%;">
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
                                            @if (!empty($Details_of_Related_Substances->data) && is_array($Details_of_Related_Substances->data))
                                                @foreach ($Details_of_Related_Substances->data as $index => $detail)
                                                    <tr>
                                                        <td><input disabled type="text" name="related_substances_test_details[{{ $index }}][row]" value="{{ $index + 1 }}"></td>
                                                        <td><input type="text" name="related_substances_test_details[{{ $index }}][sample_name]" value="{{ $detail['sample_name'] ?? '' }}"></td>
                                                        <td><input type="text" name="related_substances_test_details[{{ $index }}][relative_retention_time]" value="{{ $detail['relative_retention_time'] ?? '' }}"></td>
                                                        <td><input type="text" name="related_substances_test_details[{{ $index }}][impurities]" value="{{ $detail['impurities'] ?? '' }}"></td>
                                                        <td><input type="number" name="related_substances_test_details[{{ $index }}][result]" value="{{ $detail['result'] ?? '' }}"></td>
                                                        <td><input type="number" name="related_substances_test_details[{{ $index }}][limit]" value="{{ $detail['limit'] ?? '' }}"></td>
                                                        <td><input type="text" name="related_substances_test_details[{{ $index }}][remarks]" value="{{ $detail['remarks'] ?? '' }}"></td>
                                                        <td><button type="button" class="removeRowBtn">Remove</button></td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr class="no-data">
                                                    <td colspan="8">No data found</td>
                                                </tr>
                                            @endif
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
                        
                                    function generateRelatedSubstancesRow(serialNumber) {
                                        return (
                                            '<tr>' +
                                            '<td><input disabled type="text" name="related_substances_test_details[' + serialNumber + '][row]" value="' + (serialNumber + 1) + '"></td>' +
                                            '<td><input type="text" name="related_substances_test_details[' + serialNumber + '][sample_name]"></td>' +
                                            '<td><input type="text" name="related_substances_test_details[' + serialNumber + '][relative_retention_time]"></td>' +
                                            '<td><input type="text" name="related_substances_test_details[' + serialNumber + '][impurities]"></td>' +
                                            '<td><input type="number" name="related_substances_test_details[' + serialNumber + '][result]"></td>' +
                                            '<td><input type="number" name="related_substances_test_details[' + serialNumber + '][limit]"></td>' +
                                            '<td><input type="text" name="related_substances_test_details[' + serialNumber + '][remarks]"></td>' +
                                            '<td><button type="button" class="removeRowBtn">Remove</button></td>' +
                                            '</tr>'
                                        );
                                    }
                        
                                    var tableBody = $('#Details_RelatedSubstances tbody');
                                    var rowCount = tableBody.children('tr').not('.no-data').length;
                        
                                    // Remove "No data found" row if it exists
                                    if (rowCount === 0) {
                                        tableBody.find('.no-data').remove();
                                        rowCount = 0; // Start count from 0 if no rows exist
                                    }
                        
                                    var newRow = generateRelatedSubstancesRow(rowCount);
                                    tableBody.append(newRow);
                                });
                        
                                // Remove row in Related Substances Test Results table
                                $(document).on('click', '.removeRowBtn', function() {
                                    $(this).closest('tr').remove();
                        
                                    // Check if table is empty after deletion, add "No data found" row if so
                                    if ($('#Details_RelatedSubstances tbody tr').length === 0) {
                                        $('#Details_RelatedSubstances tbody').append('<tr class="no-data"><td colspan="8">No data found</td></tr>');
                                    }
                                });
                            });
                        </script>

                        <div class="col-12">
                            <div class="group-input">
                                <label for="Description">Related Substance Comment<span class="text-danger">*</span></label>
                                <textarea class="tiny" name="related_substance_Comment" id="related_substance_Comment" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}>{{ $equipment->related_substance_Comment }}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="group-input">
                                <label for="Calibration Procedure Reference/Document">Related Substance Attachment</label>
                                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                <div class="file-attachment-field">
                                    <div class="file-attachment-list" id="related_substance_attachment">
                                        @if ($equipment->related_substance_attachment)
                                            @foreach (json_decode($equipment->related_substance_attachment) as $file)
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
                                        {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}
                                            type="file" id="myfile" name="related_substance_attachment[]"
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
                                        <button type="button"> <a href="{{ url('rcms/lims-dashboard') }}" class="text-white">Exit</a></button>
                                    </div>
                                </div>
                            </div>
        
                            <!-- Emission to Air ****************************-->
                            <div id="CCForm7" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="d-flex align-item-end justify-content-end">
                                        <a class="text-white" href="{{ url('AssayTestingReport', $data->id) }}">
                                            <button type="button" class="button_theme1" style="margin-bottom: 20px;">
                                                Print
                                            </button>
                                        </a>
                                    </div>
                                    <div class="row">
                                        {{-- <div class="col-12">
                                            <div class="group-input">
                                                <label for="Short Description">Objective </label>
                                                <input id="" type="text" name="objective_assay" value="{{$equipment->objective_assay}}">
                                            </div>
                                        </div>  
        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Short Description">Background </label>
                                                <input id="" type="text" name="background_assay" value="{{$equipment->background_assay}}">
                                            </div>
                                        </div>
                                       
                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="Short Description"> Method:</label>
                                                <input id="" type="text" name="method_assay" value="{{$equipment->method_assay}}">
                                            </div>
                                        </div> --}}
        
        
                                        <div class="col-12">
                                        <div class="group-input">
                                            <label for="root_cause">
                                            Details of Standards and Samples
                                                <button type="button" id="promate_add" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}>+</button>
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
                                                        @php
                                                            $productmateIndex = 0;
                                                            $decodedData = !empty($dataGrid->data) ? json_decode($dataGrid->data, true) : []; // Decode JSON data into an array
                                                        @endphp
        
                                                        @if (!empty($decodedData) && is_array($decodedData))
                                                            @foreach ($decodedData as $index => $Prodmaterial)
                                                                <tr>
                                                                    <td>{{ ++$productmateIndex }}</td>
                                                                    <td><input type="text" name="Product_Material[{{ $index }}][product_name_ca]" value="{{ array_key_exists('product_name_ca', $Prodmaterial) ? $Prodmaterial['product_name_ca'] : '' }}"></td>
                                                                    <td><input type="date" name="Product_Material[{{ $index }}][batch_no_pmd_ca]"
                                                                    value="{{ $Prodmaterial['batch_no_pmd_ca'] }}"></td>
                                                                    
                                                                    <td><input type="text" name="Product_Material[{{ $index }}][batch_size_pmd_ca]" value="{{ array_key_exists('batch_size_pmd_ca', $Prodmaterial) ? $Prodmaterial['batch_size_pmd_ca'] : '' }}"></td>
                                                                    <td><input type="text" name="Product_Material[{{ $index }}][pack_profile_pmd_ca]" value="{{ array_key_exists('pack_profile_pmd_ca', $Prodmaterial) ? $Prodmaterial['pack_profile_pmd_ca'] : '' }}"></td>
                                                                    <td><input type="text" name="Product_Material[{{ $index }}][released_quantity_pmd_ca]" value="{{ array_key_exists('released_quantity_pmd_ca', $Prodmaterial) ? $Prodmaterial['released_quantity_pmd_ca'] : '' }}"></td>
                                                                    <td><input type="text" name="Product_Material[{{ $index }}][remarks_ca]" value="{{ array_key_exists('remarks_ca', $Prodmaterial) ? $Prodmaterial['remarks_ca'] : '' }}"></td>
                                                                    <td><input type="date" name="Product_Material[{{ $index }}][mfg_date_pmd_ca]"
                                                                     value="{{ $Prodmaterial['mfg_date_pmd_ca'] }}"></td>
                                                                    <td><input type="date" name="Product_Material[{{ $index }}][expiry_date_pmd_ca]"
                                                                     value="{{ $Prodmaterial['expiry_date_pmd_ca'] }}"></td>
        
                                                                    <td><button type="text" class="removeRowBtn">Remove</button></td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="10">No records found</td>
                                                            </tr>
                                                        @endif
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
                                                        // '<td><input type="text" name="Product_Material[' + productserialno + '][batch_no_pmd_ca]"></td>' +
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
                                                        <button type="button" id="add_report_approval_row" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}>+</button>
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
                                                                @php
                                                                    $productmateIndex = 0;
                                                                    $decodedData1 = !empty($dataGrid2->data) ? json_decode($dataGrid2->data, true) : [];
                                                                @endphp
        
                                                                @if (!empty($decodedData1) && is_array($decodedData1))
                                                                    @foreach ($decodedData1 as $index => $Prodmaterial)
                                                                        <tr>
                                                                            <td>{{ ++$productmateIndex }}</td>
                                                                            <td><input type="text" name="Report_Approval[{{ $index }}][names_rrv]" value="{{ array_key_exists('names_rrv', $Prodmaterial) ? $Prodmaterial['names_rrv'] : '' }}"></td>
                                                                            <td><input type="text" name="Report_Approval[{{ $index }}][department_rrv]" value="{{ array_key_exists('department_rrv', $Prodmaterial) ? $Prodmaterial['department_rrv'] : '' }}"></td>
                                                                            <td><input type="text" name="Report_Approval[{{ $index }}][sign_rrv]" value="{{ array_key_exists('sign_rrv', $Prodmaterial) ? $Prodmaterial['sign_rrv'] : '' }}"></td>
        
                                                                            <td><input type="date" name="Report_Approval[{{ $index }}][mfg_date_pmd]"
                                                                            value="{{ $Prodmaterial['mfg_date_pmd'] }}"></td>
                                                                            
                                                                            <td><input type="date" name="Report_Approval[{{ $index }}][expiry_date_pmd]"
                                                                            value="{{ $Prodmaterial['expiry_date_pmd'] }}"></td>
                                                                            
                                                                            <td><button type="text" class="removeRowBtn">Remove</button></td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    <tr>
                                                                        <td colspan="10">No records found</td>
                                                                    </tr>
                                                                @endif
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
                                                        <button type="button" id="add_report_instruments" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}>+</button>
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
        
                                                                @php
                                                                    $productmateIndex = 0;
                                                                    $decodedData2 = !empty($dataGrid3->data) ? json_decode($dataGrid3->data, true) : [];
                                                                @endphp
        
                                                                @if (!empty($decodedData2) && is_array($decodedData2))
                                                                    @foreach ($decodedData2 as $index => $Prodmaterial)
                                                                        <tr>
                                                                            <td>{{ ++$productmateIndex }}</td>
                                                                            <td><input type="text" name="Details_Instruments[{{ $index }}][names_instrument]" value="{{ array_key_exists('names_instrument', $Prodmaterial) ? $Prodmaterial['names_instrument'] : '' }}"></td>
                                                                            <td><input type="text" name="Details_Instruments[{{ $index }}][instrument_id]" value="{{ array_key_exists('instrument_id', $Prodmaterial) ? $Prodmaterial['instrument_id'] : '' }}"></td>
        
                                                                            <td><input type="date" name="Details_Instruments[{{ $index }}][callobration_on_date]"
                                                                            value="{{ $Prodmaterial['callobration_on_date'] }}"></td>
        
                                                                            <td><input type="date" name="Details_Instruments[{{ $index }}][callobration_due_date]"
                                                                            value="{{ $Prodmaterial['callobration_due_date'] }}"></td>
        
                                                                            <td><button type="text" class="removeRowBtn">Remove</button></td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    <tr>
                                                                        <td colspan="10">No records found</td>
                                                                    </tr>
                                                                @endif
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
                                                        <button type="button" id="add_assay_test_result" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}>+</button>
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
                                                                 @php
                                                                    $productmateIndex = 0;
                                                                    $decodedData3 = !empty($dataGrid4->data) ? json_decode($dataGrid4->data, true) : [];
                                                                @endphp
        
                                                                @if (!empty($decodedData3) && is_array($decodedData3))
                                                                    @foreach ($decodedData3 as $index => $Prodmaterial)
                                                                        <tr>
                                                                            <td>{{ ++$productmateIndex }}</td>
                                                                            <td><input type="text" name="Assay_Test[{{ $index }}][names_of_sample]" value="{{ array_key_exists('names_of_sample', $Prodmaterial) ? $Prodmaterial['names_of_sample'] : '' }}"></td>
                                                                            <td><input type="text" name="Assay_Test[{{ $index }}][result]" value="{{ array_key_exists('result', $Prodmaterial) ? $Prodmaterial['result'] : '' }}"></td>
                                                                            <td><input type="text" name="Assay_Test[{{ $index }}][limit]" value="{{ array_key_exists('limit', $Prodmaterial) ? $Prodmaterial['limit'] : '' }}"></td>
                                                                            <td><input type="text" name="Assay_Test[{{ $index }}][remarks]" value="{{ array_key_exists('remarks', $Prodmaterial) ? $Prodmaterial['remarks'] : '' }}"></td>
                                                                            <td><button type="text" class="removeRowBtn">Remove</button></td>
                                                                        </tr>
                                                                    @endforeach
                                                                @else
                                                                    <tr>
                                                                        <td colspan="10">No records found</td>
                                                                    </tr>
                                                                @endif
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
        
        
                                        {{-- <div class="col-12">
                                            <div class="group-input">
                                                <label for="Short Description">Conclusion: </label>
                                                <input id="" type="text" name="conclusion_assay" value="{{$equipment->conclusion_assay}}">
                                            </div>
                                        </div>  --}}

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Description">Assay Analysis Comment<span class="text-danger">*</span></label>
                                                <textarea class="tiny" name="assay_analysis_Comment" id="assay_analysis_Comment" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}>{{ $equipment->assay_analysis_Comment }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Calibration Procedure Reference/Document">Assay Analysis Attachment</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="assay_analysis_attachment">
                                                        @if ($equipment->assay_analysis_attachment)
                                                            @foreach (json_decode($equipment->assay_analysis_attachment) as $file)
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
                                                        {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}
                                                            type="file" id="myfile" name="assay_analysis_attachment[]"
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
                                        <button type="button"> <a href="{{ url('rcms/lims-dashboard') }}" class="text-white">Exit</a></button>
                                    </div>
                                </div>
                            </div>
        
                            <!-- Chemical Waste ****************************-->
                            <div id="CCForm8" class="inner-block cctabcontent">
                                <div class="inner-block-content">

                                    <div class="d-flex align-item-end justify-content-end">
                                        <a class="text-white" href="{{ url('dissolutionreport', $data->id) }}">
                                            <button type="button" class="button_theme1" style="margin-bottom: 20px;">
                                                Print
                                            </button>
                                        </a>
                                    </div>
                                 <div class="row">

                                    {{-- <div class="col-12">
                                        <div class="group-input">
                                            <label for="due-dateextension">Objective:</label>
                                            <input type="text" name="objective_dissolution" value="{{ $data->objective_dissolution }}">
                                        </div>
                                    </div>


                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="due-dateextension">Background:</label>
                                            <input type="text" name="background_dissolution" value="{{ $data->background_dissolution }}">
                                        </div>
                                    </div>
    
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="due-dateextension">Method:</label>
                                            <input type="text" name="method_dissolution" value="{{ $data->method_dissolution }}">
                                        </div>
                                    </div>--}}
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="root_cause">
                                                Details of Standards and Samples:
                                                <button type="button" id="promate" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}>+</button>
                                                <span class="text-primary" data-bs-toggle="modal" data-bs-target="#document-details-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                    (Launch Instruction)
                                                </span>
                                            </label>
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="prod_mate" style="width: 100%;">
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
                                                        @php
                                                            $productmateIndex = 0;
                                                            $dissolutionGrid1 = !empty($dissolutionGrid->data) ? json_decode($dissolutionGrid->data, true) : [];
                                                        @endphp
    
                                                        @if (!empty($dissolutionGrid1) && is_array($dissolutionGrid1))
                                                            @foreach ($dissolutionGrid1 as $index => $Prodmateriyal)
                                                                <tr>
                                                                    <td>{{ ++$productmateIndex }}</td>
                                                                    <td>
                                                                        <input type="text" name="Product_MaterialDetails[{{ $index }}][product_name_ca]" 
                                                                            value="{{ array_key_exists('product_name_ca', $Prodmateriyal) ? $Prodmateriyal['product_name_ca'] : '' }}">
                                                                    </td>
                                           
                                                                    <td><input type="date" name="Product_MaterialDetails[{{ $index }}][batch_no_pmd_ca]" value="{{ $Prodmateriyal['batch_no_pmd_ca'] }}"></td>
                                                                    <td>
                                                                        <input type="text" name="Product_MaterialDetails[{{ $index }}][batch_size_pmd_ca]" 
                                                                            value="{{ array_key_exists('batch_size_pmd_ca', $Prodmateriyal) ? $Prodmateriyal['batch_size_pmd_ca'] : '' }}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="Product_MaterialDetails[{{ $index }}][pack_profile_pmd_ca]" 
                                                                            value="{{ array_key_exists('pack_profile_pmd_ca', $Prodmateriyal) ? $Prodmateriyal['pack_profile_pmd_ca'] : '' }}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="Product_MaterialDetails[{{ $index }}][released_quantity_pmd_ca]" 
                                                                            value="{{ array_key_exists('released_quantity_pmd_ca', $Prodmateriyal) ? $Prodmateriyal['released_quantity_pmd_ca'] : '' }}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="Product_MaterialDetails[{{ $index }}][remarks_ca]" 
                                                                            value="{{ array_key_exists('remarks_ca', $Prodmateriyal) ? $Prodmateriyal['remarks_ca'] : '' }}">
                                                                    </td>
    
                                                                    <td><input type="date" name="Product_MaterialDetails[{{ $index }}][mfg_date_pmd_ca]" value="{{ $Prodmateriyal['mfg_date_pmd_ca'] }}"></td>
    
                                                                    <td><input type="date" name="Product_MaterialDetails[{{ $index }}][expiry_date_pmd_ca]" value="{{ $Prodmateriyal['expiry_date_pmd_ca'] }}"></td>
                                                                    <td>
                                                                        <button type="button" class="removeRowBtn">Remove</button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="10">No data found</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <script>
                                        $(document).ready(function() {
                                            $('#promate').click(function(e) {
                                                e.preventDefault();
                                    
                                                function generateTableRow(productserialno) {
                                                    var html =
                                                        '<tr>' +
                                                            '<td>' + (productserialno + 1) + '</td>' +
                                                            '<td><input type="text" name="Product_MaterialDetails[' + productserialno + '][product_name_ca]"></td>' +
                                                            '<td><input type="date" name="Product_MaterialDetails[' + productserialno + '][batch_no_pmd_ca]"></td>' +
                                                            '<td><input type="text" name="Product_MaterialDetails[' + productserialno + '][batch_size_pmd_ca]"></td>' +
                                                            '<td><input type="text" name="Product_MaterialDetails[' + productserialno + '][pack_profile_pmd_ca]"></td>' +
                                                            '<td><input type="text" name="Product_MaterialDetails[' + productserialno + '][released_quantity_pmd_ca]"></td>' +
                                                            '<td><input type="text" name="Product_MaterialDetails[' + productserialno + '][remarks_ca]"></td>' +
                                                            '<td><input type="date" name="Product_MaterialDetails[' + productserialno +'][mfg_date_pmd_ca]"></td>' +
                                                            '<td><input type="date" name="Product_MaterialDetails[' + productserialno +'][expiry_date_pmd_ca]"></td>' +
                                                            '<td><button type="text" class="removeRowBtn">Remove</button></td>' +
                                                        '</tr>';
                                                    return html;
                                                }
                                    
                                                var tableBody = $('#prod_mate tbody');
                                                var rowCount = tableBody.children('tr').length;
                                                var newRow = generateTableRow(rowCount);
                                                tableBody.append(newRow);
                                                indexMaetDetails++;
                                            });
                                        });
                                    </script>
    
    
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="chemicals_reagents">
                                                Details of Chemicals and Reagents:
                                                <button type="button" id="chemicals_add" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}>+</button>
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
                                                        @php
                                                            $productmateIndex = 0;
                                                            $dissolution2 = !empty($dissolutionGrid2->data) ? json_decode($dissolutionGrid2->data, true) : [];
                                                        @endphp
                                                        @if (!empty($dissolution2) && is_array($dissolution2))
                                                            @foreach ($dissolution2 as $index => $Prodmateriyal)
                                                                <tr>
                                                                    <td>{{ ++$productmateIndex }}</td>
                                                                    <td>
                                                                        <input type="text" name="ChemicalsDetails[{{ $index }}][chemical_name]" 
                                                                            value="{{ $Prodmateriyal['chemical_name'] ?? '' }}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="ChemicalsDetails[{{ $index }}][make]" 
                                                                            value="{{ $Prodmateriyal['make'] ?? '' }}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" name="ChemicalsDetails[{{ $index }}][batch_lot_no]" 
                                                                            value="{{ $Prodmateriyal['batch_lot_no'] ?? '' }}">
                                                                    </td>
    
    
                                                                    <td><input type="date" name="ChemicalsDetails[{{ $index }}][mfg_date]" value="{{ $Prodmateriyal['mfg_date'] }}"></td>
    
                                                                    <td><input type="date" name="ChemicalsDetails[{{ $index }}][exp_date]" value="{{ $Prodmateriyal['exp_date'] }}"></td>
    
    
                                                                    <td>
                                                                        <button type="button" class="removeRowBtn">Remove</button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="7">No data found</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
    
                                <script>
                                    $(document).ready(function() {
                                        $('#chemicals_add').click(function(e) {
                                            e.preventDefault();
                                
                                            function generateTableRow(productserialno) {
                                                var html =
                                                    '<tr>' +
                                                        '<td>' + (productserialno + 1) + '</td>' +
                                                        '<td><input type="text" name="ChemicalsDetails[' + productserialno + '][chemical_name]"></td>' +
                                                        // '<td><input type="text" name="Product_MaterialDetails[' + productserialno + '][batch_no_pmd_ca]"></td>' +
                                                        // '<td><input type="date" name="ChemicalsDetails[' + productserialno + '][batch_no_pmd_ca]"></td>' +
                                                        '<td><input type="text" name="ChemicalsDetails[' + productserialno + '][make]"></td>' +
                                                        '<td><input type="text" name="ChemicalsDetails[' + productserialno + '][batch_lot_no]"></td>' +
                                                        // '<td><input type="text" name="ChemicalsDetails[' + productserialno + '][released_quantity_pmd_ca]"></td>' +
                                                        // '<td><input type="text" name="Product_MaterialDetails[' + productserialno + '][remarks_ca]"></td>' +
                                                        '<td><input type="date" name="ChemicalsDetails[' + productserialno +'][mfg_date]"></td>' +
                                                        '<td><input type="date" name="ChemicalsDetails[' + productserialno +'][exp_date]"></td>' +
                                                        '<td><button type="text" class="removeRowBtn">Remove</button></td>' +
                                                    '</tr>';
                                                return html;
                                            }
                                
                                            var tableBody = $('#chemicals_reagents_details tbody');
                                            var rowCount = tableBody.children('tr').length;
                                            var newRow = generateTableRow(rowCount);
                                            tableBody.append(newRow);
                                            indexMaetDetails++;
                                        });
                                    });
                                </script>
    
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="instruments_used">
                                            Details of Instruments Used:
                                            <button type="button" id="instrument_add" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}>+</button>
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
                                                    @php
                                                        $productmateIndex = 0;
                                                        $dissolution_test = !empty($dissolutionGrid3->data) ? json_decode($dissolutionGrid3->data, true) : [];
                                                    @endphp
                                                    @if (!empty($dissolution_test) && is_array($dissolution_test))
                                                        @foreach ($dissolution_test as $index => $Prodmateriyal)
                                                            <tr>
                                                                <td>{{ ++$productmateIndex }}</td>
                                                                <td>
                                                                    <input type="text" name="InstrumentDetails[{{ $index }}][instrument_name]" 
                                                                        value="{{ $Prodmateriyal['instrument_name'] ?? '' }}">
                                                                </td>
                                                                <td>
                                                                    <input type="text" name="InstrumentDetails[{{ $index }}][instrument_id]" 
                                                                        value="{{ $Prodmateriyal['instrument_id'] ?? '' }}">
                                                                </td>
    
                                                                <td>
                                                                    <input type="date" name="InstrumentDetails[{{ $index }}][calibration_on]" value="{{ $Prodmateriyal['calibration_on'] }}">
                                                                </td>
                                                                <td>
                                                                    <input type="date" name="InstrumentDetails[{{ $index }}][calibration_due]" value="{{ $Prodmateriyal['calibration_due'] }}">
                                                                </td>
    
                                                                <td>
                                                                    <button type="button" class="removeRowBtn">Remove</button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="6">No data found</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
    
                                <script>
                                  $(document).ready(function() {
                                    $('#instrument_add').click(function(e) {
                                        e.preventDefault();
                            
                                        function generateTableRow(productserialno) {
                                            var html =
                                                '<tr>' +
                                                    '<td>' + (productserialno + 1) + '</td>' +
                                                    '<td><input type="text" name="InstrumentDetails[' + productserialno + '][instrument_name]"></td>' +
                                                    '<td><input type="text" name="InstrumentDetails[' + productserialno + '][instrument_id]"></td>' +
                                                    '<td><input type="date" name="InstrumentDetails[' + productserialno +'][calibration_on]"></td>' +
                                                    '<td><input type="date" name="InstrumentDetails[' + productserialno +'][calibration_due]"></td>' +
                                                    '<td><button type="text" class="removeRowBtn">Remove</button></td>' +
                                                '</tr>';
                                            return html;
                                        }
                            
                                        var tableBody = $('#instruments_used_details tbody');
                                        var rowCount = tableBody.children('tr').length;
                                        var newRow = generateTableRow(rowCount);
                                        tableBody.append(newRow);
                                        indexMaetDetails++;
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
                                                    @php
                                                        $dissolution_test1 = !empty($dissolutionGrid4->data) ? json_decode($dissolutionGrid4->data, true) : [];
                                                    @endphp
                                                    @if (!empty($dissolution_test1) && is_array($dissolution_test1))
                                                        @foreach ($dissolution_test1 as $index => $testData)
                                                            <tr>
                                                                <td>1</td>
                                                                <td><label for="batch_no_{{ $index }}">Batch No. / Company Name</label></td>
                                                                <td><input type="text" name="DissolutionTest[{{ $index }}][batch_no]" id="batch_no_{{ $index }}" value="{{ $testData['batch_no'] ?? '' }}"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>2</td>
                                                                <td><label for="timepoint_{{ $index }}">Timepoint</label></td>
                                                                <td><input type="text" name="DissolutionTest[{{ $index }}][timepoint]" id="timepoint_{{ $index }}" value="{{ $testData['timepoint'] ?? '' }}"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>3</td>
                                                                <td><label for="minimum_{{ $index }}">Minimum</label></td>
                                                                <td><input type="text" name="DissolutionTest[{{ $index }}][minimum]" id="minimum_{{ $index }}" value="{{ $testData['minimum'] ?? '' }}"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>4</td>
                                                                <td><label for="maximum_{{ $index }}">Maximum</label></td>
                                                                <td><input type="text" name="DissolutionTest[{{ $index }}][maximum]" id="maximum_{{ $index }}" value="{{ $testData['maximum'] ?? '' }}"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>5</td>
                                                                <td><label for="average_{{ $index }}">Average</label></td>
                                                                <td><input type="text" name="DissolutionTest[{{ $index }}][average]" id="average_{{ $index }}" value="{{ $testData['average'] ?? '' }}"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>6</td>
                                                                <td><label for="remarks_{{ $index }}">Remarks</label></td>
                                                                <td><input type="text" name="DissolutionTest[{{ $index }}][remarks]" id="remarks_{{ $index }}" value="{{ $testData['remarks'] ?? '' }}"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>7</td>
                                                                <td><label for="limit_percent_{{ $index }}">Limit (%)</label></td>
                                                                <td><input type="text" name="DissolutionTest[{{ $index }}][limit_percent]" id="limit_percent_{{ $index }}" value="{{ $testData['limit_percent'] ?? '' }}"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>8</td>
                                                                <td><label for="conclusion_{{ $index }}">Conclusion</label></td>
                                                                <td><input type="text" name="DissolutionTest[{{ $index }}][conclusion]" id="conclusion_{{ $index }}" value="{{ $testData['conclusion'] ?? '' }}"></td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="3" class="text-center">No data found</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">Dissolution Analysis Comment<span class="text-danger">*</span></label>
                                        <textarea class="tiny" name="dissolution_analysis_Comment" id="dissolution_analysis_Comment" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}>{{ $equipment->dissolution_analysis_Comment }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Calibration Procedure Reference/Document">Dissolution Analysis Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="dissolution_analysis_attachment">
                                                @if ($equipment->dissolution_analysis_attachment)
                                                    @foreach (json_decode($equipment->dissolution_analysis_attachment) as $file)
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
                                                {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}
                                                    type="file" id="myfile" name="dissolution_analysis_attachment[]"
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
                                        <button type="button"> <a href="{{ url('rcms/lims-dashboard') }}" class="text-white">Exit</a></button>
                                    </div>
                                </div>
                            </div>
        
                            <div id="CCForm9" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="Zone">Review-1 Assesment<span class="text-danger">*</span></label>
                                                <select name="review_1_assesment" id="review_1_assesment" {{ $data->stage == 8 ? 'required' : 'readonly' }} {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}>
                                                    <option value="">--Select--</option>
                                                    <option value="OK" {{ $equipment->review_1_assesment == 'OK' ? 'selected' : '' }}>OK</option>
                                                    <option value="Not OK" {{ $equipment->review_1_assesment == 'Not OK' ? 'selected' : '' }}>Not OK</option>
                                                </select>
                                            </div>
                                        </div> 
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Description">Comment</label>
                                                <textarea class="tiny" name="Review1_Comment" id="Review1_Comment" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}>{{ $equipment->Review1_Comment }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Calibration Procedure Reference/Document">Review-1 Attachment</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="review1_attachment">
                                                        @if ($equipment->review1_attachment)
                                                            @foreach (json_decode($equipment->review1_attachment) as $file)
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
                                                        {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}
                                                            type="file" id="myfile" name="review1_attachment[]"
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
                                        <button type="button"> <a href="{{ url('rcms/lims-dashboard') }}" class="text-white">Exit</a></button>
                                    </div>
                                </div>
                            </div>

                            <div id="CCForm10" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="Zone">Review-2 Assesment<span class="text-danger">*</span></label>
                                                <select name="review_2_assesment" id="review_2_assesment" {{ $data->stage == 9 ? 'required' : 'readonly' }} {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}>
                                                    <option value="">--Select--</option>
                                                    <option value="OK" {{ $equipment->review_2_assesment == 'OK' ? 'selected' : '' }}>OK</option>
                                                    <option value="Not OK" {{ $equipment->review_2_assesment == 'Not OK' ? 'selected' : '' }}>Not OK</option>
                                                </select>
                                            </div>
                                        </div> 
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Description">Comment</label>
                                                <textarea class="tiny" name="Review2_Comment" id="Review2_Comment" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}>{{ $equipment->Review2_Comment }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Calibration Procedure Reference/Document">Review-2 Attachment</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="review2_attachment">
                                                        @if ($equipment->review2_attachment)
                                                            @foreach (json_decode($equipment->review2_attachment) as $file)
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
                                                        {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}
                                                            type="file" id="myfile" name="review2_attachment[]"
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
                                        <button type="button"> <a href="{{ url('rcms/lims-dashboard') }}" class="text-white">Exit</a></button>
                                    </div>
                                </div>
                            </div>

                            <div id="CCForm11" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="Zone">Assesment Of Approver<span class="text-danger">*</span></label>
                                                <select name="approver_assesment" id="approver_assesment" {{ $data->stage == 10 ? 'required' : 'readonly' }} {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}>
                                                    <option value="">--Select--</option>
                                                    <option value="Approve" {{ $equipment->approver_assesment == 'Approve' ? 'selected' : '' }}>Approve</option>
                                                    <option value="Reject" {{ $equipment->approver_assesment == 'Reject' ? 'selected' : '' }}>Reject</option>
                                                    <option value="Retest" {{ $equipment->approver_assesment == 'Retest' ? 'selected' : '' }}>Retest</option>
                                                </select>
                                            </div>
                                        </div> 
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Description">Comment</label>
                                                <textarea class="tiny" name="approver_Comment" id="approver_Comment" {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}>{{ $equipment->approver_Comment }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Calibration Procedure Reference/Document">Approver Attachment</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="approver_attachment">
                                                        @if ($equipment->approver_attachment)
                                                            @foreach (json_decode($equipment->approver_attachment) as $file)
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
                                                        {{ $data->stage == 0 || $data->stage == 11 || $data->stage == 7 ? 'disabled' : '' }}
                                                            type="file" id="myfile" name="approver_attachment[]"
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
                                        <button type="button"> <a href="{{ url('rcms/lims-dashboard') }}" class="text-white">Exit</a></button>
                                    </div>
                                </div>
                            </div>
        
                            <div id="CCForm12" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed By">Sample Receive By</label>
                                                <div class="static">{{ $equipment->pending_front_offiece_review_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed On">Sample Receive On</label>
                                                <div class="static">{{ $equipment->pending_front_offiece_review_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Cancelled By">Sample Receive Comment</label>
                                                <div class="static">{{ $equipment->pending_front_offiece_review_comment }}</div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed By">Cancel By</label>
                                                <div class="static">{{ $equipment->Cancel_By }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed On">Cancel On</label>
                                                <div class="static">{{ $equipment->Cancel_On }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Cancelled By">Cancel Comment</label>
                                                <div class="static">{{ $equipment->Cancel_Comment }}</div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed By">Transfer To Sample Coordinator By</label>
                                                <div class="static">{{ $equipment->pending_Review_by_sample_coordinator }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed On">Transfer To Sample Coordinator On</label>
                                                <div class="static">{{ $equipment->pending_Review_on_sample_coordinator }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Review Complete By">Transfer To Sample Coordinator Comment</label>
                                                <div class="static">{{ $equipment->pending_Review_comment_sample_coordinator }}</div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed By">Review Completed By Sample Coordinator</label>
                                                <div class="static">{{ $equipment->pending_allocation_sample_coordinator_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed On">Review Completed By Sample Coordinator On</label>
                                                <div class="static">{{ $equipment->pending_allocation_sample_coordinator_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Supervisor Approval By">Review Completed By Sample Coordinator Comment</label>
                                                <div class="static">{{ $equipment->pending_allocation_sample_coordinator_comment }}</div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed By">Allocation of Sample for Analysis Completed By</label>
                                                <div class="static">{{ $equipment->pending_sample_acknowledgement_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed On">Allocation of Sample for Analysis Completed On</label>
                                                <div class="static">{{ $equipment->pending_sample_acknowledgement_on}}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Supervisor Approval By">Allocation of Sample for Analysis Completed Comment</label>
                                                <div class="static">{{ $equipment->pending_sample_acknowledgement_comment }}</div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed By">Start Analysis By</label>
                                                <div class="static">{{ $equipment->Pending_sample_analysis_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed On">Start Analysis On</label>
                                                <div class="static">{{ $equipment->Pending_sample_analysis_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Supervisor Approval By">Start Analysis Comment</label>
                                                <div class="static">{{ $equipment->Pending_sample_analysis_comment }}</div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed By">Analysis Complete By</label>
                                                <div class="static">{{ $equipment->closed_done1_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed On">Analysis Complete On</label>
                                                <div class="static">{{ $equipment->closed_done1_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Supervisor Approval By">Analysis Complete Comment</label>
                                                <div class="static">{{ $equipment->closed_done1_comment }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed By">Analysis Completed & Verification Required By</label>
                                                <div class="static">{{ $equipment->pending_verification1_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed On">Analysis Completed & Verification Required On</label>
                                                <div class="static">{{ $equipment->pending_verification1_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Supervisor Approval By">Analysis Completed & Verification Required Comment</label>
                                                <div class="static">{{ $equipment->pending_verification1_comment }}</div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed By">Verification for Review-1 Complete By</label>
                                                <div class="static">{{ $equipment->pending_verification2_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed On">Verification for Review-1 Complete On</label>
                                                <div class="static">{{ $equipment->pending_verification2_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Supervisor Approval By">Verification for Review-1 Complete Comment</label>
                                                <div class="static">{{ $equipment->pending_verification2_comment }}</div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed By">Verification for Review-2 Complete By</label>
                                                <div class="static">{{ $equipment->pending_verification_approve_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed On">Verification for Review-2 Complete On</label>
                                                <div class="static">{{ $equipment->pending_verification_approve_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Supervisor Approval By">Verification for Review-2 Complete Comment</label>
                                                <div class="static">{{ $equipment->pending_verification_approve_comment }}</div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed By">Approval Complete By</label>
                                                <div class="static">{{ $equipment->closed_done2_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed On">Approval Complete On</label>
                                                <div class="static">{{ $equipment->closed_done2_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Supervisor Approval By">Approval Complete Comment</label>
                                                <div class="static">{{ $equipment->closed_done2_comment }}</div>
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
                <form action="{{ route('receiptStateChange', $equipment->id) }}" method="POST">
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

    <div class="modal fade" id="second-signature-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('receiptSecondStateChange', $equipment->id) }}" method="POST">
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
                            <input class="second-info" type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input class="second-info" type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment</label>
                            <input class="second-info" type="comment" name="comment">
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

  
    <div class="modal fade" id="MoreInfo-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('MoreInfoReceipt', $equipment->id) }}" method="POST">
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
                            <input class="more-info" type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input class="more-info" type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment <span class="text-danger">*</span></label>
                            <input class="more-info" type="comment" name="comment" required>
                        </div>
                    </div>

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

                <form action="{{ url('receiptCancel', $equipment->id) }}" method="POST">
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
        .more-info{
            width : 100%;
            border : 1px solid black;
            border-radius: 5px;

        }
        .second-info{
            width : 100%;
            border : 1px solid black;
            border-radius: 5px;

        }
    </style>


<script>
        VirtualSelect.init({
            ele: '#investigators, #department, #investigation_team, #root_cause_methodology, #review_1_person, #reviewerPerson2, #approverPerson'
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
            ele: '#related_records, #related_records2, #reviewer_person_value, #risk_assessment_related_record, #concerned_department_review'
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
    document.addEventListener('DOMContentLoaded', function() {
        var maxLength = 100;
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
        var maxLength = 500;
        $('#doceename').keyup(function() {
            var textlen = maxLength - $(this).val().length;
            $('#rcharsss').text(textlen);
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
<!--  Validation code  -->


<script>
document.addEventListener('DOMContentLoaded', function () {
    console.log("DOM fully loaded and parsed");

    const forms = document.querySelectorAll('.cctabcontent');
    const stage = {{ $data->stage }};  

    const fieldsToValidate = [
        { name: "Mode of Recipt", selector: '#mode_receipt', type: 'dropdown' },
        { name: "Sample Type", selector: "#sampleType", type: "dropdown" },
        { name: "Source of sample", selector: "#source_of_sample", type: "dropdown" },
        { name: "Standard Test Protocols", selector: "#specifications", type: "dropdown" },
        { name: "Acknowledgement", selector: "#Acknowledgement", type: "dropdown" },
        { name: "MOA Change Needed", selector: "#moa_change_needed", type: "dropdown" },
       
        
    ];

    forms.forEach((form) => {
        const saveButton = form.querySelector('.saveButton');

        if (saveButton) {
            saveButton.addEventListener('click', function (event) {
                event.preventDefault();  

                console.log(`Save data validation triggered for all forms.`);

                let hasError = false;  
                const invalidFields = []; 

                if (stage === 1 || stage === 2 || stage === 4 || stage === 5 || stage === 7) {
                    fieldsToValidate.forEach((field) => {
                        const fieldElement = document.querySelector(field.selector);

                        if (stage === 2 && field.name === "Sample Type") {
                            if (fieldElement && fieldElement.value.trim() === "") {
                                hasError = true;
                                invalidFields.push({
                                    label: field.name,
                                    element: fieldElement,
                                    placeholder: `Please select ${field.name}`,
                                    type: field.type,
                                });
                                fieldElement.classList.add("is-invalid");
                            } else {
                                fieldElement.classList.remove("is-invalid");
                            }
                        } else if (stage === 4 && field.name === "Standard Test Protocols") {
                            if (fieldElement && typeof fieldElement.value === "string" && fieldElement.value.trim() === "") {
                                hasError = true;
                                invalidFields.push({
                                    label: field.name,
                                    element: fieldElement,
                                    placeholder: `Please select ${field.name}`,
                                    type: field.type,
                                });
                                fieldElement.classList.add("is-invalid");
                            } else {
                                fieldElement.classList.remove("is-invalid");
                            }
                        } 
                        else if (stage === 5 && (field.name === "MOA Change Needed" || field.name === "Acknowledgement")) {  // corrected this condition
                            if (fieldElement && typeof fieldElement.value === "string" && fieldElement.value.trim() === "") {
                                hasError = true;
                                invalidFields.push({
                                    label: field.name,
                                    element: fieldElement,
                                    placeholder: `Please select ${field.name}`,
                                    type: field.type,
                                });
                                fieldElement.classList.add("is-invalid");
                            } else {
                                fieldElement.classList.remove("is-invalid");
                            }
                        } 
                          
                        else if (stage === 1 && (field.name !== "Sample Type" && field.name !== "Standard Test Protocols" && field.name !== "MOA Change Needed"  && field.name !== "Acknowledgement")) {
                            if (fieldElement && fieldElement.value.trim() === "") {
                                hasError = true;
                                invalidFields.push({
                                    label: field.name,
                                    element: fieldElement,
                                    placeholder: `Please select ${field.name}`,
                                    type: field.type,
                                });
                                fieldElement.classList.add("is-invalid");
                            } else {
                                fieldElement.classList.remove("is-invalid");
                            }
                        }
                    });
                }

                forms.forEach((currentForm) => {
                    const shortDescription = currentForm.querySelector('[name="received_from"]');
                    const breifDescription = currentForm.querySelector('[name="brief_description"]');
                    const SampleCoordinator = currentForm.querySelector('[name="Sample_coordinator_Comment"]');
             
                    
                    if (stage === 1 && shortDescription && shortDescription.value?.trim() === "") {
                        hasError = true;
                        invalidFields.push({
                            label: "Short Description is required",
                            element: shortDescription,
                            placeholder: "Please enter the short description",
                            type: "text"
                        });
                        shortDescription.classList.add('is-invalid');
                    } else {
                        shortDescription?.classList.remove('is-invalid');
                    }

                    if (stage === 1 && breifDescription && breifDescription.value?.trim() === "") {
                        hasError = true;
                        invalidFields.push({
                            label: "Breif Description of the sample is required",
                            element: breifDescription,
                            placeholder: "Please enter the brief description",
                            type: "text"
                        });
                        breifDescription.classList.add('is-invalid');
                    } else {
                        breifDescription?.classList.remove('is-invalid');
                    }

                  

                    if (stage === 3 && SampleCoordinator && SampleCoordinator.value?.trim() === "") {
                        hasError = true;
                        invalidFields.push({
                            label: "Sample Coordinator comments are required",
                            element: SampleCoordinator,
                            placeholder: "Please enter the short description",
                            type: "text"
                        });
                        SampleCoordinator.classList.add('is-invalid');
                    } else {
                        SampleCoordinator?.classList.remove('is-invalid');
                    }
                });

                if (hasError) {
                    event.stopPropagation(); 
                    console.log("Validation errors detected. Pop-up modal triggered.");
                    showValidationModal(invalidFields, function () {
                        console.log("Modal Save Button clicked. Re-validating fields.");

                        let recheckErrors = false;
                        invalidFields.forEach((field) => {
                            const fieldElement = field.element;
                            if (fieldElement && fieldElement.value.trim() === "") {
                                recheckErrors = true;
                                fieldElement.classList.add('is-invalid');
                            } else {
                                fieldElement.classList.remove('is-invalid');
                            }
                        });

                        if (!recheckErrors) {
                            const currentFormElement = saveButton.closest('form');
                            if (currentFormElement && typeof currentFormElement.submit === 'function') {
                                currentFormElement.submit();  
                                showToast("Record updated successfully!");
                            }

                        } else {
                            showToast("Please fill all required fields.");
                        }
                    });
                } else {
                    console.log("All forms passed validation. Proceeding with the update.");
                    const currentFormElement = saveButton.closest('form');
                    if (currentFormElement && typeof currentFormElement.submit === 'function') {
                        currentFormElement.submit();
                        showToast("Record updated successfully!");
                    }
                }
            });
        }
    });

    function showValidationModal(fields, onSaveCallback) {
    console.log("Displaying validation pop-up with fields to fill.", fields);

    let modalHtml = document.querySelector('#validationInputModal');
    if (!modalHtml) {
        modalHtml = document.createElement('div');
        modalHtml.id = 'validationInputModal';
        modalHtml.className = 'modal fade';
        modalHtml.tabIndex = -1;
        modalHtml.innerHTML = `
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-danger">Please Fill Required Fields</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="fieldInputContainer"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="submitModalData">Save</button>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(modalHtml);
    }

    const fieldContainer = document.getElementById('fieldInputContainer');
    fieldContainer.innerHTML = fields.map((field, index) => {
        if (field.type === 'dropdown') {
            let optionsHtml = '';

            if (field.label.trim() === "Mode of Recipt") {
                optionsHtml = `
                    <option value="">-- Select --</option>
                    <option value="Hand Delivery" ${field.element.value === 'Hand Delivery' ? 'selected' : ''}>Hand Delivery</option>
                    <option value="Post" ${field.element.value === 'Post' ? 'selected' : ''}>Post</option>
                    <option value="Courier" ${field.element.value === 'Courier' ? 'selected' : ''}>Courier</option>
                    <option value="Others" ${field.element.value === 'Others' ? 'selected' : ''}>Others</option>
                `;
            } else if (field.label.trim() === "Sample Type") {
                optionsHtml = `
                    <option value="">-- Select --</option>
                    <option value="N" ${field.element.value === 'N' ? 'selected' : ''}>New Drug Substance</option>
                    <option value="I" ${field.element.value === 'I' ? 'selected' : ''}>Indian Pharmacopoeia Reference Standard</option>
                    <option value="T" ${field.element.value === 'T' ? 'selected' : ''}>Proficiency Testing</option>
                    <option value="C" ${field.element.value === 'C' ? 'selected' : ''}>Inter Laboratory Comparison</option>
                    <option value="P" ${field.element.value === 'P' ? 'selected' : ''}>Phytopharmaceutical</option>
                    <option value="M" ${field.element.value === 'M' ? 'selected' : ''}>Miscellaneous</option>
                    <option value="0" ${field.element.value === '0' ? 'selected' : ''}>Others</option>
                `;
            } else if (field.label.trim() === "Source of sample") {
                optionsHtml = `
                    <option value="">-- Select --</option>
                    <option value="Stakeholder" ${field.element.value === 'Stakeholder' ? 'selected' : ''}>Stakeholder</option>
                    <option value="Market Purchase" ${field.element.value === 'Market Purchase' ? 'selected' : ''}>Market Purchase</option>
                `;
            } else if (field.label.trim() === "Standard Test Protocols") {
                optionsHtml = `
                    <option value="">-- Select --</option>
                    <option value="Manufacturers Specifications" ${field.element.value === 'Manufacturers Specifications' ? 'selected' : ''}>Manufacturers Specifications</option>
                    <option value="British Pharmacopoeia (BP)" ${field.element.value === 'British Pharmacopoeia (BP)' ? 'selected' : ''}>British Pharmacopoeia</option>
                    <option value="European Pharmacopoeia (Ph. Eur.)" ${field.element.value === 'European Pharmacopoeia (Ph. Eur.)' ? 'selected' : ''}>European Pharmacopoeia</option>
                    <option value="United States Pharmacopeia (USP)" ${field.element.value === 'United States Pharmacopeia (USP)' ? 'selected' : ''}>United States Pharmacopeia</option>
                    <option value="Manufacturer’s STPs" ${field.element.value === 'Manufacturer’s STPs' ? 'selected' : ''}>Manufacturer’s STPs</option>
                    <option value="Other Sources" ${field.element.value === 'Other Sources' ? 'selected' : ''}>Other Sources</option>
                `;
            } else if (field.label.trim() === "Acknowledgement") {
                optionsHtml = `
                    <option value="">-- Select --</option>
                    <option value="Yes" ${field.element.value === 'Yes' ? 'selected' : ''}>Yes</option>
                    <option value="No" ${field.element.value === 'No' ? 'selected' : ''}>No</option>
                `;
            } else if (field.label.trim() === "MOA Change Needed") {
                optionsHtml = `
                    <option value="">-- Select --</option>
                    <option value="Yes" ${field.element.value === 'Yes' ? 'selected' : ''}>Yes</option>
                    <option value="No" ${field.element.value === 'No' ? 'selected' : ''}>No</option>
                `;
            }  
            

            return `
                <div class="mb-3">
                    <label class="form-label">${field.label}</label>
                    <select class="form-control" id="inputField-${index}" data-field-key="${field.fieldKey}">
                        ${optionsHtml}
                    </select>
                </div>
            `;
        } else if (field.type === 'text') {
            return `
                <div class="mb-3">
                    <label class="form-label">${field.label}</label>
                    <input
                        type="text"
                        class="form-control"
                        id="inputField-${index}"
                        data-field-key="${field.fieldKey}"
                        placeholder="${field.placeholder || ''}"
                        value="${field.element.value || ''}"
                    />
                </div>
            `;
        }
        return ''; 
    }).join('');

    const saveButton = document.getElementById('submitModalData');
    saveButton.onclick = function () {
        fields.forEach((field, index) => {
            const input = document.getElementById(`inputField-${index}`);
            if (input) {
                field.element.value = input.value.trim();
            }
        });

        const validationModal = bootstrap.Modal.getInstance(modalHtml);
        validationModal.hide(); // Hide modal on save

        onSaveCallback(); // Execute callback function after validation success
    };

    const validationModal = new bootstrap.Modal(modalHtml);
    validationModal.show();
}


    function showToast(message) {
    
        console.log(message); 
    }
});


</script>

<!-- End -->



@endsection
