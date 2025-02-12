@extends('frontend.rcms.layout.main_rcms')
@section('rcms_container')
    @php
        $users = DB::table('users')->select('id', 'name')->get();
    @endphp

    <style>
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

        /* #change-control-view > div.container-fluid > div.inner-block.state-block > div.status > div > div.active{
                        font-size: 12px;

                    } */
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
                    {{ Helpers::getDivisionName($equipment->division_id) }} / Preventive Maintenance
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
                        <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
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
                            <a class="text-white" href="{{ url('PrevantiveAuditTrail', $data->id) }}">
                                Audit Trail
                            </a>
                        </button>
                    
                        @if ($data->stage == 1)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Submit
                            </button>
                        @elseif($data->stage == 2)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Supervisor Approval
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>
                        @elseif($data->stage == 3)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Complete
                            </button>
                        @elseif($data->stage == 4)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#MoreInfo-modal">
                                Additional Work Required
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                QA Approval
                            </button>
                        @endif
                        <button class="button_theme1">
                            <a class="text-white" href="{{ url('rcms/qms-dashboard') }}">
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
                                <div class="active">Supervisor Review</div>
                            @else
                                <div class="">Supervisor Review</div>
                            @endif
                            @if ($data->stage >= 3)
                                <div class="active">Work in Progress</div>
                            @else
                                <div class="">Work in Progress</div>
                            @endif
                            @if ($data->stage >= 4)
                                <div class="active">Pending QA Approval</div>
                            @else
                                <div class="">Pending QA Approval</div>
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
                    <div><strong> Record Name :&nbsp;</strong>Preventive Maintenanc</div>
                    <div><strong> Site :&nbsp;</strong>{{ Helpers::getDivisionName($data->division_id) }}</div>
                    <div><strong> Current Status :&nbsp;</strong>{{ $data->status }}</div>
                    <div><strong> Initiated By :&nbsp;</strong>{{ Helpers::getInitiatorName($data->initiator_id) }}</div>
                </div>
            </div>
            <div class="modal right fade" id="myModal3" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-titles ml-10">Preventive Maintenanc Workflow</h4>
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
                                            Supervisor Review
                                        </div>
                                    @else
                                        <div class="mini_buttons">Supervisor Review</div>
                                    @endif
                                    <div class="down-logo">
                                        <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..." class="w-100 h-100">
                                    </div>
                                    @if ($data->stage >= 3 && (in_array(75, $userRoleIds) || in_array(18, $userRoleIds)))
                                        <div class="active">
                                            Work in Progress
                                        </div>
                                    @else
                                        <div class="mini_buttons">Work in Progress</div>
                                    @endif
                                    <div class="down-logo">
                                        <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..." class="w-100 h-100">
                                    </div>
                                    @if ($data->stage >= 4 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                                        <div class="active">
                                            Pending QA Approval
                                        </div>
                                    @else
                                        <div class="mini_buttons">Pending QA Approval</div>
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
                $equipmentParent = DB::table('equipment_lifecycle_information')->find($data->parent_id);

            @endphp
            <div id="change-control-fields">
                <div class="container-fluid">
                    <!-- Tab links -->
                    <div class="cctab">
                        @if($data->parent_id)
                        <button class="cctablinks" onclick="openCity(event, 'CCForm222')">
                            Equipment/Instrument Information
                        </button>
                    @endif
                        {{-- <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Equipment Information</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Qualification Details</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Calibration Details</button> --}}
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Preventive Maintenance Details</button>
                {{-- <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Spare Part Information</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Training Details</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm7')">Supervisor Review</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm8')">QA Review</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm9')">Equipment Retirement</button> --}}
                <button class="cctablinks" onclick="openCity(event, 'CCForm10')">Activity Log</button>
                    </div>

                    <form id="CCFormInput" action="{{ route('updatePreventiveMaintenance', $data->id) }}" method="POST"
                        enctype="multipart/form-data">
                        <input type="hidden" name="stage" id="stage" value="{{ $data->stage }}">

                        @csrf
                        {{-- @method('PUT') --}}

                        <!-- Tab content -->
                        {{-- <div id="step-form"> --}}
                        <div>
                            @if($data->parent_id)
                            <div id="CCForm222" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
    
                                        {{-- <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="RLS Record Number"><b>Record Number</b></label>
                                                <input readonly type="text" name="record_number"
                                                    value="{{ $equipmentParent->record_number }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Division Code"><b>Site/Location Code</b></label>
                                                <input readonly type="text" name="division_code"
                                                    value="{{ Helpers::getDivisionName($equipmentParent->division_id) }}">
                                            </div>
                                        </div>
    
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Initiator"><b>Initiator</b></label>
                                                <input type="hidden" name="initiator_id">
                                                <input readonly type="text" value="{{ $equipmentParent->initiator_name }} ">
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
                                                    {{ $equipmentParent->stage == 0 || $equipmentParent->stage == 10 ? 'disabled' : '' }}>
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
                                                    value="{{ Helpers::getdateFormat($equipmentParent->due_date) }}"
                                                    name="due_date"{{ $equipmentParent->stage == 0 || $equipmentParent->stage == 10 ? 'disabled' : '' }}>
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
                                                        value="{{ $equipmentParent->short_description }}" maxlength="255"
                                                        required
                                                        {{ $equipmentParent->stage == 0 || $equipmentParent->stage == 10 ? 'disabled' : '' }}>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        
                                    
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="equipment_id">Equipment/Instrument ID/Tag Number</label>
                                                <input type="number" name="equipment_id" value="{{ $equipmentParent->equipment_id }}" min="0" disabled/>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Equipment/Instrument_Name/Description">Equipment/Instrument Name/Description</label>
                                                <div class="relative-container">                                                    
                                                    <input type="text" name="equipment_name_description" value="{{ $equipmentParent->equipment_name_description }}" disabled/>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Manufacturer">Manufacturer</label>
                                                <div class="relative-container">                                                    
                                                    <input type="text" name="manufacturer" value="{{ $equipmentParent->manufacturer }}" disabled/>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Model_Number">Model Number</label>
                                                <input type="number" min="0" name="model_number" value="{{ $equipmentParent->model_number }}" disabled />
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Serial_Number">Serial Number</label>
                                                <input type="number" min="0" name="serial_number" value="{{ $equipmentParent->serial_number }}" disabled />
                                            </div>
                                        </div>
    
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Location">Location</label>
                                                <div class="relative-container">                                                    
                                                    <textarea name="location" disabled>{{ $equipmentParent->location }}</textarea>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Purchase Date">Purchase Date</label>
                                                <div class="calenderauditee">                                     
                                                    <input type="text"  id="purchase_date"  readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($equipmentParent->purchase_date) }}"
                                                    disabled/>
                                                    <input type="date" id="purchase_date_checkdate" name="purchase_date" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" disabled value="{{ $equipmentParent->purchase_date }}" class="hide-input"
                                                    oninput="handleDateInput(this, 'purchase_date');checkDate('purchase_date_checkdate','purchase_date1_checkdate')"/>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Installation Date">Installation Date</label>
                                                <div class="calenderauditee">                                     
                                                    <input type="text"  id="installation_date"  readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($equipmentParent->installation_date) }}"
                                                        disabled/>
                                                    <input type="date" id="installation_date_checkdate " readonly name="installation_date" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" disabled value="{{ $equipmentParent->installation_date }}" class="hide-input"
                                                    oninput="handleDateInput(this, 'installation_date');checkDate('installation_date_checkdate','installation_date1_checkdate')"/>
                                                </div>
                                            </div>
                                        </div>  
                                        
                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Warranty Expiration Date">Warranty Expiration Date</label>
                                                <div class="calenderauditee">                                     
                                                    <input type="text"  id="warranty_expiration_date"  readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($equipmentParent->warranty_expiration_date) }}"
                                                        {{ $equipmentParent->stage == 0 || $equipmentParent->stage == 10 ? 'disabled' : '' }}/>
                                                    <input type="date" id="warranty_expiration_date_checkdate" readonly name="warranty_expiration_date" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" {{ $equipmentParent->stage == 0 || $equipmentParent->stage == 10 ? 'disabled' : '' }} value="{{ $equipmentParent->warranty_expiration_date }}" class="hide-input"
                                                    oninput="handleDateInput(this, 'warranty_expiration_date');checkDate('warranty_expiration_date_checkdate','warranty_expiration_date1_checkdate')"/>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="criticality_level">Criticality Level </label>
                                                <select name="criticality_level" id="criticality_level" disabled>
                                                    <option value="">-- Select --</option>
                                                    <option value="High" {{ $equipmentParent->criticality_level == 'High' ? 'selected' : '' }}>High</option>
                                                    <option value="Medium" {{ $equipmentParent->criticality_level == 'Medium' ? 'selected' : '' }}>Medium</option>
                                                    <option value="Low" {{ $equipmentParent->criticality_level == 'Low' ? 'selected' : '' }}>Low</option>                                                   
                                                </select>
                                            </div>
                                        </div>
    
                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="asset_type">Asset Type</label>
                                                <select name="asset_type" id="asset_type" disabled>
                                                    <option value="">-- Select --</option>
                                                    <option value="Reactors" {{ $equipmentParent->asset_type == 'Reactors' ? 'selected' : '' }}>Reactors</option>
                                                    <option value="Mixers/Blenders" {{ $equipmentParent->asset_type == 'Mixers/Blenders' ? 'selected' : '' }}>Mixers/Blenders</option>
                                                    <option value="Granulators" {{ $equipmentParent->asset_type == 'Granulators' ? 'selected' : '' }}>Granulators</option>                                                   
                                                    <option value="Compressors" {{ $equipmentParent->asset_type == 'Compressors' ? 'selected' : '' }}>Compressors</option>                                                   
                                                    <option value="Coating Machines" {{ $equipmentParent->asset_type == 'Coating Machines' ? 'selected' : '' }}>Coating Machines</option>                                                   
                                                    <option value="Sterilizers" {{ $equipmentParent->asset_type == 'Sterilizers' ? 'selected' : '' }}>Sterilizers</option>                                                   
                                                    <option value="Centrifuges" {{ $equipmentParent->asset_type == 'Centrifuges' ? 'selected' : '' }}>Centrifuges</option>                                                   
                                                    <option value="Dryers" {{ $equipmentParent->asset_type == 'Dryers' ? 'selected' : '' }}>Dryers</option>                                                 
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
                                                <label for="Zone">PM Schedule</label>
                                                <select name="pm_schedule">
                                                    <option value="">Select PM Schedule</option>
                                                    <option value="Weekly" {{ $equipment->pm_schedule == 'Weekly' ? 'selected' : '' }}>Weekly</option>
                                                    <option value="Fortnightly" {{ $equipment->pm_schedule == 'Fortnightly' ? 'selected' : '' }}>Fortnightly</option>
                                                    <option value="Monthly" {{ $equipment->pm_schedule == 'Monthly' ? 'selected' : '' }}>Monthly</option>                                                   
                                                    <option value="Quarterly" {{ $equipment->pm_schedule == 'Quarterly' ? 'selected' : '' }}>Quarterly</option>
                                                    <option value="Half Yearly" {{ $equipment->pm_schedule == 'Half Yearly' ? 'selected' : '' }}>Half Yearly</option>
                                                    <option value="Annually" {{ $equipment->pm_schedule == 'Annually' ? 'selected' : '' }}>Annually</option>                                                   
                                                    <option value="Once in Two Years" {{ $equipment->pm_schedule == 'Once in Two Years' ? 'selected' : '' }}>Once in Two Years</option>                                                   
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Last Preventive Maintenance Date">Last Preventive Maintenance Date</label>
                                                <div class="calenderauditee">                                     
                                                    <input type="text"  id="last_pm_date"  readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($equipment->last_pm_date) }}"
                                                        {{ $equipment->stage == 0 || $equipment->stage == 9 ? 'disabled' : '' }}/>
                                                    <input type="date" id="last_pm_date_checkdate" name="last_pm_date" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" {{ $equipment->stage == 0 || $equipment->stage == 9 ? 'disabled' : '' }} value="{{ $equipment->last_pm_date }}" class="hide-input"
                                                    oninput="handleDateInput(this, 'last_pm_date');checkDate('last_pm_date_checkdate','next_pm_date_checkdate_checkdate')"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Next Preventive Maintenance Date">Next Preventive Maintenance Date</label>
                                                <div class="calenderauditee">                                     
                                                    <input type="text"  id="next_pm_date"  readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($equipment->next_pm_date) }}"
                                                        {{ $equipment->stage == 0 || $equipment->stage == 9 ? 'disabled' : '' }}/>
                                                    <input type="date" id="next_pm_date_checkdate" name="next_pm_date" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" {{ $equipment->stage == 0 || $equipment->stage == 9 ? 'disabled' : '' }} value="{{ $equipment->next_pm_date }}" class="hide-input"
                                                    oninput="handleDateInput(this, 'next_pm_date');checkDate('last_pm_date_checkdate','next_pm_date_checkdate_checkdate')"/>
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Corrective Action">PM Task Description</label>
                                                <textarea name="pm_task_description">{{ $equipment->pm_task_description }}</textarea>
                                            </div>
                                        </div>
        
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="search">Unscheduled or Event Based Preventive Maintenance?</label>
                                                <select name="event_based_PM">
                                                    <option value="">--Select--</option>
                                                    <option value="Yes" {{ $equipment->event_based_PM == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                    <option value="No" {{ $equipment->event_based_PM == 'No' ? 'selected' : '' }}>No</option>
                                                </select>
                                            </div>
                                        </div>
        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Corrective Action">Reason for Unscheduled or Event Based Preventive Maintenance</label>
                                                <textarea name="eventbased_pm_reason">{{ $equipment->eventbased_pm_reason }}</textarea>
                                            </div>
                                        </div>
        
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Event Reference No.</label>
                                                <input type="text" name="PMevent_refernce_no" value="{{ $equipment->PMevent_refernce_no }}">
                                            </div>
                                        </div>  
                                        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="PM Procedure Reference/Document">PM Procedure Reference/Document</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting
                                                        documents</small></div>
    
                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="pm_procedure_document">
                                                        @if ($equipment->pm_procedure_document)
                                                            @foreach (json_decode($equipment->pm_procedure_document) as $file)
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
                                                            type="file" id="myfile" name="pm_procedure_document[]"
                                                            oninput="addMultipleFiles(this, 'pm_procedure_document')" multiple>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Performed By</label>
                                                <input type="text" name="pm_performed_by" value="{{ $equipment->pm_performed_by }}">
                                            </div>
                                        </div>
        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Corrective Action">Maintenance Comments/Observations</label>
                                                <textarea name="maintenance_observation">{{ $equipment->maintenance_observation }}</textarea>
                                            </div>
                                        </div>
        
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Parts Replaced During Maintenance</label>
                                                <input type="text" name="replaced_parts" value="{{ $equipment->replaced_parts }}">
                                            </div>
                                        </div>
        
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Maintenance Work Order Number</label>
                                                <input type="text" name="work_order_number" value="{{ $equipment->work_order_number }}">
                                            </div>
                                        </div>
        
                                        <div class="pt-2 group-input">
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
                                                        @if ($PreventiveMaintenance_grid && is_array($PreventiveMaintenance_grid->data))
                                                            @foreach ($PreventiveMaintenance_grid->data as $index => $prevent_grid)
                                                                <tr>
                                                                    <td><input type="text" name="pmchecklist[{{ $loop->index }}][serial]" value="{{ $loop->index+1 }}"></td>
                                                                    <td><input type="text" name="pmchecklist[{{ $loop->index }}][checkpoint]" value=" {{ array_key_exists('checkpoint', $prevent_grid) ? $prevent_grid['checkpoint'] : '' }}"></td>
                                                                    <td><input type="text" name="pmchecklist[{{ $loop->index }}][comment]" value=" {{ array_key_exists('comment', $prevent_grid) ? $prevent_grid['comment'] : '' }}"></td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td><input type="text" name="pmchecklist[0][serial]" value="1"></td>
                                                                <td><input type="text" name="pmchecklist[0][checkpoint]"></td>
                                                                <td><input type="text" name="pmchecklist[0][comment]" ></td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                        
                                        <div class="col-12">
                                        <div class="group-input">
                                            <label for="short_description">Short Description<span class="text-danger">*</span></label>
                                            <span id="rchars">255</span> characters remaining
                                            <div class="relative-container">
                                                <input name="short_description"  id="short_description"  type="text"  maxlength="255"  value="{{ $data->short_description }}" 
                                                    required 
                                                    {{ $data->stage == 0 || $data->stage == 4 ? 'disabled' : '' }} >
                                                    @component('frontend.forms.language-model', ['readonly' => $data->stage == 0 || $data->stage == 4])
                                                    @endcomponent
                                            </div>   
                                          
                                        </div>
                                        <p id="docnameError" style="color:red">**Short Description is required</p>
                                    </div>
        
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Emergency Maintenance Flag</label>
                                                <input type="text" name="emergency_flag_maintenance" value="{{ $equipment->emergency_flag_maintenance }}">
                                            </div>
                                        </div>
        
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Cost of Maintenance</label>
                                                <input type="text" name="cost_of_maintenance" value="{{ $equipment->cost_of_maintenance }}">
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
                                            <div class="relative-container">                                                    
                                                <textarea name="urs_description" id="urs_description">{{ $equipment->urs_description }}</textarea>
                                                @component('frontend.forms.language-model')
                                                @endcomponent
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Description">Initial/Business/System Level Risk Assessment Details</label>
                                            <div class="relative-container">                                                    
                                                <textarea name="system_level_risk_assessment_details" id="system_level_risk_assessment_details">{{ $equipment->system_level_risk_assessment_details }}</textarea>
                                                @component('frontend.forms.language-model')
                                                @endcomponent
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <div class="col-12 mb-4">
                                <div class="group-input">
                                    <label for="agenda">
                                        Failure Mode and Effect Analysis
                                        <button type="button" name="agenda"
                                            onclick="addRootCauseAnalysisRiskAssessment('risk-assessment-risk-management')" {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>+</button>
                                        <!-- <span class="text-primary" style="font-size: 0.8rem; font-weight: 400;">
                                            (Launch Instruction)
                                        </span> -->
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
                                                        @if (!empty($data->risk_factor))
                                                            @foreach (unserialize($data->risk_factor) as $key => $riskFactor)
                                                                {{--  @dd($key, $riskFactor)  --}}

                                                                <tr>
                                                                    <td>{{ $key + 1 }}</td>
                                                                    <td><input name="risk_factor[]" type="text"
                                                                            value="{{ $riskFactor }}"
                                                                            {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td><input name="risk_element[]" type="text"
                                                                            value="{{ unserialize($data->risk_element)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td><input name="problem_cause[]" type="text"
                                                                            value="{{ unserialize($data->problem_cause)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td><input name="existing_risk_control[]"
                                                                            type="text"
                                                                            value="{{ unserialize($data->existing_risk_control)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td>
                                                                        <select onchange="calculateInitialResult(this)"
                                                                            class="fieldR" name="initial_severity[]"
                                                                            {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                            <option value="">-- Select --</option>
                                                                            <option value="1"
                                                                                {{ (unserialize($data->initial_severity)[$key] ?? null) == 1 ? 'selected' : '' }}>
                                                                                1</option>
                                                                            <option value="2"
                                                                                {{ (unserialize($data->initial_severity)[$key] ?? null) == 2 ? 'selected' : '' }}>
                                                                                2</option>
                                                                            <option value="3"
                                                                                {{ (unserialize($data->initial_severity)[$key] ?? null) == 3 ? 'selected' : '' }}>
                                                                                3</option>
                                                                            <!-- <option value="4"
                                                                                {{ (unserialize($data->initial_severity)[$key] ?? null) == 4 ? 'selected' : '' }}>
                                                                                4-Critical</option>
                                                                            <option value="5"
                                                                                {{ (unserialize($data->initial_severity)[$key] ?? null) == 5 ? 'selected' : '' }}>
                                                                                5-Catastrophic</option> -->
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select onchange="calculateInitialResult(this)"
                                                                            class="fieldP" name="initial_detectability[]"
                                                                            {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                            <option value="">-- Select --</option>
                                                                            <option value="1"
                                                                                {{ (unserialize($data->initial_detectability)[$key] ?? null) == 1 ? 'selected' : '' }}>
                                                                                1</option>
                                                                            <option value="2"
                                                                                {{ (unserialize($data->initial_detectability)[$key] ?? null) == 2 ? 'selected' : '' }}>
                                                                                2</option>
                                                                            <option value="3"
                                                                                {{ (unserialize($data->initial_detectability)[$key] ?? null) == 3 ? 'selected' : '' }}>
                                                                                3</option>
                                                                            <!-- <option value="4"
                                                                                {{ (unserialize($data->initial_detectability)[$key] ?? null) == 4 ? 'selected' : '' }}>
                                                                                4-Likely</option>
                                                                            <option value="5"
                                                                                {{ (unserialize($data->initial_detectability)[$key] ?? null) == 5 ? 'selected' : '' }}>
                                                                                5-Almost certain (every time)</option> -->
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select onchange="calculateInitialResult(this)"
                                                                            class="fieldN" name="initial_probability[]"
                                                                            {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                            <option value="">-- Select --</option>
                                                                            <option value="1"
                                                                                {{ (unserialize($data->initial_probability)[$key] ?? null) == 1 ? 'selected' : '' }}>
                                                                                1</option>
                                                                            <option value="2"
                                                                                {{ (unserialize($data->initial_probability)[$key] ?? null) == 2 ? 'selected' : '' }}>
                                                                                2</option>
                                                                            <option value="3"
                                                                                {{ (unserialize($data->initial_probability)[$key] ?? null) == 3 ? 'selected' : '' }}>
                                                                                3</option>
                                                                            <!-- <option value="4"
                                                                                {{ (unserialize($data->initial_probability)[$key] ?? null) == 4 ? 'selected' : '' }}>
                                                                                4-Unlikely to detect</option>
                                                                            <option value="5"
                                                                                {{ (unserialize($data->initial_probability)[$key] ?? null) == 5 ? 'selected' : '' }}>
                                                                                5-Not detectable</option> -->
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <input name="initial_rpn[]" class='initial-rpn'
                                                                            readonly
                                                                            value="{{ unserialize($data->initial_rpn)[$key] ?? null }}">
                                                                    </td>
                                                                    <td>
                                                                        <select onchange="calculateInitialResult(this)"
                                                                            class="fieldR" name="risk_acceptance[]"
                                                                            {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                            <option value="">-- Select --</option>
                                                                            <option value="Y"
                                                                                {{ (unserialize($data->risk_acceptance)[$key] ?? null) == 'Y' ? 'selected' : '' }}>
                                                                                Y</option>
                                                                            <option value="N"
                                                                                {{ (unserialize($data->risk_acceptance)[$key] ?? null) == 'N' ? 'selected' : '' }}>
                                                                                N</option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <input name="risk_control_measure[]"
                                                                            type="text"
                                                                            value="{{ unserialize($data->risk_control_measure)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td>
                                                                        <select onchange="calculateResidualResult(this)"
                                                                            class="residual-fieldR"
                                                                            name="residual_severity[]"
                                                                            {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                            <option value="">-- Select --</option>
                                                                            <option value="1"
                                                                                {{ (unserialize($data->residual_severity)[$key] ?? null) == 1 ? 'selected' : '' }}>
                                                                                1</option>
                                                                            <option value="2"
                                                                                {{ (unserialize($data->residual_severity)[$key] ?? null) == 2 ? 'selected' : '' }}>
                                                                                2</option>
                                                                            <option value="3"
                                                                                {{ (unserialize($data->residual_severity)[$key] ?? null) == 3 ? 'selected' : '' }}>
                                                                                3</option>
                                                                            <!-- <option value="4"
                                                                                {{ (unserialize($data->residual_severity)[$key] ?? null) == 4 ? 'selected' : '' }}>
                                                                                4-Critical</option>
                                                                            <option value="5"
                                                                                {{ (unserialize($data->residual_severity)[$key] ?? null) == 5 ? 'selected' : '' }}>
                                                                                5-Catastrophic</option> -->
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select onchange="calculateResidualResult(this)"
                                                                            class="residual-fieldP"
                                                                            name="residual_probability[]"
                                                                            {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                            <option value="">-- Select --</option>
                                                                            <option value="1"
                                                                                {{ (unserialize($data->residual_probability)[$key] ?? null) == 1 ? 'selected' : '' }}>
                                                                                1</option>
                                                                            <option value="2"
                                                                                {{ (unserialize($data->residual_probability)[$key] ?? null) == 2 ? 'selected' : '' }}>
                                                                                2</option>
                                                                            <option value="3"
                                                                                {{ (unserialize($data->residual_probability)[$key] ?? null) == 3 ? 'selected' : '' }}>
                                                                                3</option>
                                                                            <!-- <option value="4"
                                                                                {{ (unserialize($data->residual_probability)[$key] ?? null) == 4 ? 'selected' : '' }}>
                                                                                4-Likely</option>
                                                                            <option value="5"
                                                                                {{ (unserialize($data->residual_probability)[$key] ?? null) == 5 ? 'selected' : '' }}>
                                                                                5-Almost certain (every time)</option> -->
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select onchange="calculateResidualResult(this)"
                                                                            class="residual-fieldN"
                                                                            name="residual_detectability[]"
                                                                            {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                            <option value="">-- Select --</option>
                                                                            <option value="1"
                                                                                {{ (unserialize($data->residual_detectability)[$key] ?? null) == 1 ? 'selected' : '' }}>
                                                                                1</option>
                                                                            <option value="2"
                                                                                {{ (unserialize($data->residual_detectability)[$key] ?? null) == 2 ? 'selected' : '' }}>
                                                                                2</option>
                                                                            <option value="3"
                                                                                {{ (unserialize($data->residual_detectability)[$key] ?? null) == 3 ? 'selected' : '' }}>
                                                                                3</option>
                                                                            <!-- <option value="4"
                                                                                {{ (unserialize($data->residual_detectability)[$key] ?? null) == 4 ? 'selected' : '' }}>
                                                                                4-Unlikely to detect</option>
                                                                            <option value="5"
                                                                                {{ (unserialize($data->residual_detectability)[$key] ?? null) == 5 ? 'selected' : '' }}>
                                                                                5-Not detectable</option> -->
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <input name="residual_rpn[]" class='residual-rpn'
                                                                            readonly
                                                                            value="{{ unserialize($data->residual_rpn)[$key] ?? null }}">
                                                                    </td>
                                                                    <td>
                                                                        <select onchange="calculateInitialResult(this)"
                                                                            class="fieldR" name="risk_acceptance2[]"
                                                                            {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                            <option value="">-- Select --</option>
                                                                            <option value="Y"
                                                                                {{ (unserialize($data->risk_acceptance2)[$key] ?? null) == 'Y' ? 'selected' : '' }}>
                                                                                Y</option>
                                                                            <option value="N"
                                                                                {{ (unserialize($data->risk_acceptance2)[$key] ?? null) == 'N' ? 'selected' : '' }}>
                                                                                N</option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <input name="mitigation_proposal[]" type="text"
                                                                            value="{{ unserialize($data->mitigation_proposal)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td><button type="text" class="removeRowBtn"
                                                                            {{ $data->stage == 0 || $data->stage == 8 ? 'disabled' : '' }}>Remove</button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Supporting Documents">Supporting Documents</label>
                                            <div><small class="text-primary">Please Attach all relevant or supporting
                                                    documents</small></div>

                                            <div class="file-attachment-field">
                                                <div class="file-attachment-list" id="supporting_documents">
                                                    @if ($equipment->supporting_documents)
                                                        @foreach (json_decode($equipment->supporting_documents) as $file)
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
                                                        type="file" id="myfile" name="supporting_documents[]"
                                                        oninput="addMultipleFiles(this, 'supporting_documents')" multiple>
                                                </div>
                                            </div>
                                        </div>
                                    </div>       
                                       
        
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Description">FRS Description</label>
                                            <div class="relative-container">                                                    
                                                <textarea name="frs_description" id="frs_description">{{ $equipment->frs_description }}</textarea>
                                                @component('frontend.forms.language-model')
                                                @endcomponent
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="FRS Attachment">FRS Attachment</label>
                                            <div><small class="text-primary">Please Attach all relevant or supporting
                                                    documents</small></div>

                                            <div class="file-attachment-field">
                                                <div class="file-attachment-list" id="frs_attachment">
                                                    @if ($equipment->frs_attachment)
                                                        @foreach (json_decode($equipment->frs_attachment) as $file)
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
                                                        type="file" id="myfile" name="frs_attachment[]"
                                                        oninput="addMultipleFiles(this, 'frs_attachment')" multiple>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
        
        
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Description">Functional Risk Assessment Details</label>
                                            <div class="relative-container">                                                    
                                                <textarea name="functional_risk_assessment_details" id="functional_risk_assessment_details">{{ $equipment->functional_risk_assessment_details }}</textarea>
                                                @component('frontend.forms.language-model')
                                                @endcomponent
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="col-12">
                                        <div class="sub-head">Installation Qualification (IQ)</div>
                                        <div class="group-input">
                                                <label for="Type">IQ Test Plan</label>
                                                <select name="iq_test_plan" id="iq_test_plan">
                                                    <option value="">-- Select --</option>
                                                    <option value="Electrical" {{ $equipment->iq_test_plan == 'Electrical' ? 'selected' : '' }}>Electrical</option>
                                                    <option value="Mechanical" {{ $equipment->iq_test_plan == 'Mechanical' ? 'selected' : '' }}>Mechanical</option>
                                                    <option value="Environmental" {{ $equipment->iq_test_plan == 'Environmental' ? 'selected' : '' }}>Environmental</option>                                                    
                                                </select>
                                            </div>
                                    </div>  
                                   
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Description">IQ Protocol</label>
                                            <div class="relative-container">                                                    
                                                <input name="iq_protocol" id="iq_protocol" value="{{ $equipment->iq_protocol }}"></input>
                                                @component('frontend.forms.language-model')
                                                @endcomponent
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Description">IQ Execution</label>
                                            <div class="relative-container">                                                    
                                                <input name="iq_execution" id="iq_execution" value="{{ $equipment->iq_execution }}"></input>
                                                @component('frontend.forms.language-model')
                                                @endcomponent
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Description">IQ Report</label>
                                            <div class="relative-container">                                                    
                                                <input name="iq_report" id="iq_report" value="{{ $equipment->iq_report }}"></input>
                                                @component('frontend.forms.language-model')
                                                @endcomponent
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Equipment Qualification Attachment">Equipment Qualification Attachment</label>
                                            <div><small class="text-primary">Please Attach all relevant or supporting
                                                    documents</small></div>

                                            <div class="file-attachment-field">
                                                <div class="file-attachment-list" id="iq_attachment">
                                                    @if ($equipment->iq_attachment)
                                                        @foreach (json_decode($equipment->iq_attachment) as $file)
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
                                                        type="file" id="myfile" name="iq_attachment[]"
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
                                                    <option value="Electrical" {{ $equipment->dq_test_plan == 'Electrical' ? 'selected' : '' }}>Electrical</option>
                                                    <option value="Mechanical" {{ $equipment->dq_test_plan == 'Mechanical' ? 'selected' : '' }}>Mechanical</option>
                                                    <option value="Environmental" {{ $equipment->dq_test_plan == 'Environmental' ? 'selected' : '' }}>Environmental</option>                                                   
                                                
                                                </select>
                                            </div>
                                        </div>  
                                       
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Description">DQ Protocol</label>
                                                <div class="relative-container">                                                    
                                                    <input name="dq_protocol" id="dq_protocol" value="{{ $equipment->dq_protocol }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Description">DQ Execution</label>
                                                <div class="relative-container">                                                    
                                                    <input name="dq_execution" id="dq_execution" value="{{ $equipment->dq_execution }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Description">DQ Report</label>
                                                <div class="relative-container">                                                    
                                                    <input name="dq_report" id="dq_report" value="{{ $equipment->dq_report }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Equipment Qualification Attachment">Equipment Qualification Attachment</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting
                                                        documents</small></div>
    
                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="dq_attachment">
                                                        @if ($equipment->dq_attachment)
                                                            @foreach (json_decode($equipment->dq_attachment) as $file)
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
                                                            type="file" id="myfile" name="dq_attachment[]"
                                                            oninput="addMultipleFiles(this, 'dq_attachment')" multiple>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-12">
                                            <div class="sub-head">Operational Qualification (OQ)</div>
                                            <div class="group-input">
                                                <label for="Description">OQ Test Plan</label>
                                                <div class="relative-container">                                                    
                                                    <input name="oq_test_plan" id="oq_test_plan" value="{{ $equipment->oq_test_plan }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>  
                                       
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Description">OQ Protocol</label>
                                                <div class="relative-container">                                                    
                                                    <input name="oq_protocol" id="oq_protocol" value="{{ $equipment->oq_protocol }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Description">OQ Execution</label>
                                                <div class="relative-container">                                                    
                                                    <input name="oq_execution" id="oq_execution" value="{{ $equipment->oq_execution }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Description">OQ Report</label>
                                                <div class="relative-container">                                                    
                                                    <input name="oq_report" id="oq_report" value="{{ $equipment->oq_report }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Equipment Qualification Attachment">Equipment Qualification Attachment</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting
                                                        documents</small></div>
    
                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="oq_attachment">
                                                        @if ($equipment->oq_attachment)
                                                            @foreach (json_decode($equipment->oq_attachment) as $file)
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
                                                            type="file" id="myfile" name="oq_attachment[]"
                                                            oninput="addMultipleFiles(this, 'oq_attachment')" multiple>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>        
        
                                        <div class="col-12">
                                            <div class="sub-head">Performance Qualification (PQ)</div>
                                            <div class="group-input">
                                                <label for="Description">PQ Test Plan</label>
                                                <div class="relative-container">                                                    
                                                    <input name="pq_test_plan" id="pq_test_plan" value="{{ $equipment->pq_test_plan }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>  
                                       
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Description">PQ Protocol</label>
                                                <div class="relative-container">                                                    
                                                    <input name="pq_protocol" id="pq_protocol" value="{{ $equipment->pq_protocol }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Description">PQ Execution</label>
                                                <div class="relative-container">                                                    
                                                    <input name="pq_execution" id="pq_execution" value="{{ $equipment->pq_execution }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Description">PQ Report</label>
                                                <div class="relative-container">                                                    
                                                    <input name="pq_report" id="pq_report" value="{{ $equipment->pq_report }}"></input>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Equipment Qualification Attachment">Equipment Qualification Attachment</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting
                                                        documents</small></div>
    
                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="pq_attachment">
                                                        @if ($equipment->pq_attachment)
                                                            @foreach (json_decode($equipment->pq_attachment) as $file)
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
                                                            type="file" id="myfile" name="pq_attachment[]"
                                                            oninput="addMultipleFiles(this, 'pq_attachment')" multiple>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>        
        
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Description">Migration Details</label>
                                            <div class="relative-container">                                                    
                                                <textarea name="migration_details" id="migration_details">{{ $equipment->migration_details }}</textarea>
                                                @component('frontend.forms.language-model')
                                                @endcomponent
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Migration Attachment">Migration Attachment</label>
                                            <div><small class="text-primary">Please Attach all relevant or supporting
                                                    documents</small></div>

                                            <div class="file-attachment-field">
                                                <div class="file-attachment-list" id="migration_attachment">
                                                    @if ($equipment->migration_attachment)
                                                        @foreach (json_decode($equipment->migration_attachment) as $file)
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
                                                        type="file" id="myfile" name="migration_attachment[]"
                                                        oninput="addMultipleFiles(this, 'migration_attachment')" multiple>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
        
                                        
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Description">Configuration Specification Details</label>
                                            <div class="relative-container">                                                    
                                                <textarea name="configuration_specification_details" id="configuration_specification_details">{{ $equipment->configuration_specification_details }}</textarea>
                                                @component('frontend.forms.language-model')
                                                @endcomponent
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Configuration Specification Attachment">Configuration Specification Attachment</label>
                                            <div><small class="text-primary">Please Attach all relevant or supporting
                                                    documents</small></div>

                                            <div class="file-attachment-field">
                                                <div class="file-attachment-list" id="configuration_specification_attachment">
                                                    @if ($equipment->configuration_specification_attachment)
                                                        @foreach (json_decode($equipment->configuration_specification_attachment) as $file)
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
                                                        type="file" id="myfile" name="configuration_specification_attachment[]"
                                                        oninput="addMultipleFiles(this, 'configuration_specification_attachment')" multiple>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Description">Rquirement Traceability Details</label>
                                            <div class="relative-container">                                                    
                                                <textarea name="requirement_traceability_details" id="requirement_traceability_details">{{ $equipment->requirement_traceability_details }}</textarea>
                                                @component('frontend.forms.language-model')
                                                @endcomponent
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Requirement Traceability Attachment">Requirement Traceability Attachment</label>
                                            <div><small class="text-primary">Please Attach all relevant or supporting
                                                    documents</small></div>

                                            <div class="file-attachment-field">
                                                <div class="file-attachment-list" id="requirement_traceability_attachment">
                                                    @if ($equipment->requirement_traceability_attachment)
                                                        @foreach (json_decode($equipment->requirement_traceability_attachment) as $file)
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
                                                        type="file" id="myfile" name="requirement_traceability_attachment[]"
                                                        oninput="addMultipleFiles(this, 'requirement_traceability_attachment')" multiple>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
        
        
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Description">Validation Summary Report</label>
                                            <div class="relative-container">                                                    
                                                <textarea name="validation_summary_report" id="validation_summary_report">{{ $equipment->validation_summary_report }}</textarea>
                                                @component('frontend.forms.language-model')
                                                @endcomponent
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="Periodic Qualification Pending On">Periodic Qualification Pending On</label>
                                            <div class="calenderauditee">                                     
                                                <input type="text"  id="periodic_qualification_pending_on"  readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($equipment->periodic_qualification_pending_on) }}"
                                                    {{ $equipment->stage == 0 || $equipment->stage == 9 ? 'disabled' : '' }}/>
                                                <input type="date" id="periodic_qualification_pending_on_checkdate" name="periodic_qualification_pending_on" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" {{ $equipment->stage == 0 || $equipment->stage == 9 ? 'disabled' : '' }} value="{{ $equipment->periodic_qualification_pending_on }}" class="hide-input"
                                                oninput="handleDateInput(this, 'periodic_qualification_pending_on');checkDate('periodic_qualification_pending_on_checkdate','periodic_qualification_pending_on1_checkdate')"/>
                                            </div>
                                        </div>
                                    </div>
        
        
                                    <div class="col-12">
                                        <div class="group-input">
                                            <label for="Description">Periodic Qualification Notification (Days)</label>
                                            <input name="periodic_qualification_notification" id="periodic_qualification_notification" value="{{ $equipment->periodic_qualification_notification }}"></input>
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
                                                <input type="text" name="calibration_standard_preference" value="{{ $equipment->calibration_standard_preference }}">
                                            </div>
                                        </div>
        
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Zone">Calibration Frequency</label>
                                                <select name="callibration_frequency">
                                                    <option value="">Select Calibration Frequency</option>
                                                    <option value="Weekly" {{ $equipment->callibration_frequency == 'Weekly' ? 'selected' : '' }}>Weekly</option>
                                                    <option value="Fortnightly" {{ $equipment->callibration_frequency == 'Fortnightly' ? 'selected' : '' }}>Fortnightly</option>
                                                    <option value="Monthly" {{ $equipment->callibration_frequency == 'Monthly' ? 'selected' : '' }}>Monthly</option>                                                   
                                                    <option value="Quarterly" {{ $equipment->callibration_frequency == 'Quarterly' ? 'selected' : '' }}>Quarterly</option>
                                                    <option value="Half Yearly" {{ $equipment->callibration_frequency == 'Half Yearly' ? 'selected' : '' }}>Half Yearly</option>
                                                    <option value="Annually" {{ $equipment->callibration_frequency == 'Annually' ? 'selected' : '' }}>Annually</option>                                                   
                                                    <option value="Once in Two Years" {{ $equipment->callibration_frequency == 'Once in Two Years' ? 'selected' : '' }}>Once in Two Years</option>                                                   
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Last Calibration Date">Last Calibration Date</label>
                                                <div class="calenderauditee">                                     
                                                    <input type="text"  id="last_calibration_date"  readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($equipment->last_calibration_date) }}"
                                                        {{ $equipment->stage == 0 || $equipment->stage == 9 ? 'disabled' : '' }}/>
                                                    <input type="date" id="last_calibration_date_checkdate" name="last_calibration_date" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" {{ $equipment->stage == 0 || $equipment->stage == 9 ? 'disabled' : '' }} value="{{ $equipment->last_calibration_date }}" class="hide-input"
                                                    oninput="handleDateInput(this, 'last_calibration_date');checkDate('last_calibration_date_checkdate','next_calibration_date_checkdate')"/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Next Calibration Date">Next Calibration Date</label>
                                                <div class="calenderauditee">                                     
                                                    <input type="text"  id="next_calibration_date"  readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($equipment->next_calibration_date) }}"
                                                        {{ $equipment->stage == 0 || $equipment->stage == 9 ? 'disabled' : '' }}/>
                                                    <input type="date" id="next_calibration_date_checkdate" name="next_calibration_date" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" {{ $equipment->stage == 0 || $equipment->stage == 9 ? 'disabled' : '' }} value="{{ $equipment->next_calibration_date }}" class="hide-input"
                                                    oninput="handleDateInput(this, 'next_calibration_date');checkDate('last_calibration_date_checkdate','next_calibration_date_checkdate')"/>
                                                </div>
                                            </div>
                                        </div>
        
        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Details">Calibration Due Reminder</label>
                                                <input type="text" name="calibration_due_reminder" value="{{ $equipment->calibration_due_reminder }}">
                                            </div>
                                        </div>
        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Details">Calibration Method/Procedure</label>
                                                <textarea name="calibration_method_procedure">{{ $equipment->calibration_method_procedure }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Calibration Procedure Reference/Document">Calibration Procedure Reference/Document</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting
                                                        documents</small></div>
    
                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="calibration_procedure_attach">
                                                        @if ($equipment->calibration_procedure_attach)
                                                            @foreach (json_decode($equipment->calibration_procedure_attach) as $file)
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
                                                            type="file" id="myfile" name="calibration_procedure_attach[]"
                                                            oninput="addMultipleFiles(this, 'calibration_procedure_attach')" multiple>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
        
        
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Calibration Standards Used</label>
                                                <input type="text" name="calibration_used" value="{{ $equipment->calibration_used }}">
                                            </div>
                                        </div>
        
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Calibration Parameters</label>
                                                <input type="text" name="calibration_parameter" value="{{ $equipment->calibration_parameter }}">
                                            </div>
                                        </div>
        
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Zone">Unscheduled or Event Based Calibration?</label>
                                                <select name="event_based_calibration">
                                                    <option value="">--Select--</option>
                                                    <option value="Yes" {{ $equipment->event_based_calibration == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                    <option value="No" {{ $equipment->event_based_calibration == 'No' ? 'selected' : '' }}>No</option>
                                                </select>
                                            </div>
                                        </div>
        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Details">Reason for Unscheduled or Event Based Calibration</label>
                                                <textarea name="event_based_calibration_reason">{{ $equipment->event_based_calibration_reason }}</textarea>
                                            </div>
                                        </div>
        
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Event Reference No.</label>
                                                <input type="text" name="event_refernce_no" value="{{ $equipment->event_refernce_no }}">
                                            </div>
                                        </div>
        
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Calibration Checklist</label>
                                                <input type="text" name="calibration_checklist" value="{{ $equipment->calibration_checklist }}">
                                            </div>
                                        </div>
        
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Calibration Results</label>
                                                <input type="text" name="calibration_result" value="{{ $equipment->calibration_result }}">
                                            </div>
                                        </div>
        
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Calibration Certificate Number</label>
                                                <input type="text" name="calibration_certificate_result" value="{{ $equipment->calibration_certificate_result }}">
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Calibration Certificate Attachment">Calibration Certificate Attachment</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting
                                                        documents</small></div>
    
                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="calibration_certificate">
                                                        @if ($equipment->calibration_certificate)
                                                            @foreach (json_decode($equipment->calibration_certificate) as $file)
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
                                                            type="file" id="myfile" name="calibration_certificate[]"
                                                            oninput="addMultipleFiles(this, 'calibration_certificate')" multiple>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
        
               
        
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Calibrated By</label>
                                                <input type="text" name="calibrated_by" value="{{ $equipment->equipment_id }}">
                                            </div>
                                        </div>
        
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Calibration Due Alert</label>
                                                <input type="text" name="calibration_due_alert" value="{{ $equipment->calibration_due_alert }}">
                                            </div>
                                        </div>
        
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Cost of Calibration</label>
                                                <input type="text" name="calibration_cost" value="{{ $equipment->calibration_cost }}">
                                            </div>
                                        </div>
        
        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Details">Calibration Comments/Observations</label>
                                                <textarea name="calibration_comments">{{ $equipment->calibration_comments }}</textarea>
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
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">Exit</a></button>
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
                                                    <button type="button" name="hazop" onclick="addSparePartInformation('Spare-Part-Information')">+</button>
                                                    <span class="text-primary" style="font-size: 0.8rem; font-weight: 400;">
                                                        (Launch Instruction)
                                                    </span>
                                                </label>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" style="width: 200%" id="Spare-Part-Information">
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
                                                        @if (!empty($data->SpareEquipment_Name))
                                                            @foreach (unserialize($data->SpareEquipment_Name) as $key => $SpareEquipmentName)
                                                                <tr>
                                                                    <td>{{ $key + 1 }}</td>
                                                                    <td colspan="2">
                                                                        <input name="SpareEquipment_Name[]" type="text"
                                                                            value="{{ $SpareEquipmentName }}"
                                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <input name="SpareEquipment_ID[]" type="text"
                                                                            value="{{ unserialize($data->SpareEquipment_ID)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <input name="SparePart_ID[]" type="text"
                                                                            value="{{ unserialize($data->SparePart_ID)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <input name="SparePart_Name[]" type="text"
                                                                            value="{{ unserialize($data->SparePart_Name)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <input name="SpareManufacturer[]" type="text"
                                                                            value="{{ unserialize($data->SpareManufacturer)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <input name="SpareModel_Number[]" type="text"
                                                                            value="{{ unserialize($data->SpareModel_Number)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <input name="SpareSerial_Number[]" type="text"
                                                                            value="{{ unserialize($data->SpareSerial_Number)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <input name="SpareOEM[]" type="text"
                                                                            value="{{ unserialize($data->SpareOEM)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <input name="SparePart_Category[]" type="text"
                                                                            value="{{ unserialize($data->SparePart_Category)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <input name="SparePart_Group[]" type="text"
                                                                            value="{{ unserialize($data->SparePart_Group)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <input name="SparePart_Dimensions[]" type="text"
                                                                            value="{{ unserialize($data->SparePart_Dimensions)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <input name="SpareMaterial[]" type="text"
                                                                            value="{{ unserialize($data->SpareMaterial)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <input name="SpareWeight[]" type="text"
                                                                            value="{{ unserialize($data->SpareWeight)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <input name="SpareColor[]" type="text"
                                                                            value="{{ unserialize($data->SpareColor)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <input name="SparePart_Lifecycle_Stage[]" type="text"
                                                                            value="{{ unserialize($data->SparePart_Lifecycle_Stage)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <input name="SparePart_Status[]" type="text"
                                                                            value="{{ unserialize($data->SparePart_Status)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <input name="SpareAvailability[]" type="text"
                                                                            value="{{ unserialize($data->SpareAvailability)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <input name="SpareQuantity_on_Hand[]" type="text"
                                                                            value="{{ unserialize($data->SpareQuantity_on_Hand)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <input name="SpareQuantity_on_Order[]" type="text"
                                                                            value="{{ unserialize($data->SpareQuantity_on_Order)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <input name="SpareReorder_Point[]" type="text"
                                                                            value="{{ unserialize($data->SpareReorder_Point)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <input name="SpareSafety_Stock[]" type="text"
                                                                            value="{{ unserialize($data->SpareSafety_Stock)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <input name="SpareMinimum_Order_Quantity[]" type="text"
                                                                            value="{{ unserialize($data->SpareMinimum_Order_Quantity)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <input name="SpareLead_Time[]" type="text"
                                                                            value="{{ unserialize($data->SpareLead_Time)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <input name="SpareStock_Location[]" type="text"
                                                                            value="{{ unserialize($data->SpareStock_Location)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <input name="SpareBin_Number[]" type="text"
                                                                            value="{{ unserialize($data->SpareBin_Number)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <input name="SpareStock_Keeping_Unit[]" type="text"
                                                                            value="{{ unserialize($data->SpareStock_Keeping_Unit)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <input name="SpareLot_Number[]" type="text"
                                                                            value="{{ unserialize($data->SpareLot_Number)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <input name="SpareExpiry_Date[]" type="text"
                                                                            value="{{ unserialize($data->SpareExpiry_Date)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <input name="SpareSupplier_Name[]" type="text"
                                                                            value="{{ unserialize($data->SpareSupplier_Name)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <input name="SpareSupplier_Contact_Information[]" type="text"
                                                                            value="{{ unserialize($data->SpareSupplier_Contact_Information)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <input name="SpareSupplier_Lead_Time[]" type="text"
                                                                            value="{{ unserialize($data->SpareSupplier_Lead_Time)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <input name="SpareSupplier_Price[]" type="text"
                                                                            value="{{ unserialize($data->SpareSupplier_Price)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <input name="SpareSupplier_Part_Number[]" type="text"
                                                                            value="{{ unserialize($data->SpareSupplier_Part_Number)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <input name="SpareSupplier_Warranty_Information[]" type="text"
                                                                            value="{{ unserialize($data->SpareSupplier_Warranty_Information)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <input name="SpareSupplier_Performance_Metrics[]" type="text"
                                                                            value="{{ unserialize($data->SpareSupplier_Performance_Metrics)[$key] ?? null }}"
                                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <button type="button" class="removeRowBtn"
                                                                            {{ $data->stage == 0 || $data->stage == 9 ? 'disabled' : '' }}>
                                                                            Remove
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
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
                                                    <option value="">--Select--</option>
                                                    <option value="Yes" {{ $equipment->training_required == 'Yes' ? 'selected' : '' }}>Yes</option>
                                                    <option value="No" {{ $equipment->training_required == 'No' ? 'selected' : '' }}>No</option>
                                                </select>
                                            </div>
                                        </div>
        
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Corrective Action">Training Description</label>
                                                <textarea name="trining_description">{{ $equipment->trining_description }}</textarea>
                                            </div>
                                        </div>
        
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Initiator">Training Type</label>
                                                <input type="text" name="training_type" value="{{ $equipment->training_type }}">
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Training Attachment">Training Attachment</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting
                                                        documents</small></div>
    
                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="training_attachment">
                                                        @if ($equipment->training_attachment)
                                                            @foreach (json_decode($equipment->training_attachment) as $file)
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
                                                            type="file" id="myfile" name="training_attachment[]"
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
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">Exit</a></button>
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
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">Exit</a></button>
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
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">Exit</a></button>
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
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">Exit</a></button>
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
                                                <div class="static">{{ $equipment->cancel_By }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed On">Cancelled On</label>
                                                <div class="static">{{ $equipment->cancel_On }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Cancelled By">Cancelled Comment</label>
                                                <div class="static">{{ $equipment->cancel_comment }}</div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed By">Supervisor Approval By</label>
                                                <div class="static">{{ $equipment->Supervisor_Approval_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed On">Supervisor Approval On</label>
                                                <div class="static">{{ $equipment->Supervisor_Approval_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Supervisor Approval By">Supervisor Approval Comment</label>
                                                <div class="static">{{ $equipment->Supervisor_Approval_comment }}</div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed By">Complete By</label>
                                                <div class="static">{{ $equipment->Complete_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed On">Complete On</label>
                                                <div class="static">{{ $equipment->Complete_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Supervisor Approval By">Complete Comment</label>
                                                <div class="static">{{ $equipment->Complete_comment }}</div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed By">Additional Work Required By</label>
                                                <div class="static">{{ $equipment->additional_work_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed On">Additional Work Required On</label>
                                                <div class="static">{{ $equipment->additional_work_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Supervisor Approval By">Additional Work Required Comment</label>
                                                <div class="static">{{ $equipment->additional_work_comment }}</div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed By">QA Approval By</label>
                                                <div class="static">{{ $equipment->qa_approval_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Plan Proposed On">QA Approval On</label>
                                                <div class="static">{{ $equipment->qa_approval_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Supervisor Approval By">QA Approval Comment</label>
                                                <div class="static">{{ $equipment->qa_approval_comment }}</div>
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
                <form action="{{ route('PreventiveStateChange', $equipment->id) }}" method="POST">
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

                <form action="{{ route('MoreInfoPreventive', $equipment->id) }}" method="POST">
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

                <form action="{{ route('MoreInfoPreventive', $equipment->id) }}" method="POST">
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

    {{-- <div class="modal fade" id="child-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Child</h4>
                </div>
                <form action="{{ route('equipmentChild', $equipment->id) }}" method="POST">
                    @csrf
                    
                    <div class="modal-body">
                        <div class="group-input">
                            
                                <label for="major">
                                    <input type="radio" name="child_type" id="major" value="PM">
                                    PM
                                </label>                           
                            
                                <label for="major">
                                    <input type="radio" name="child_type" id="major" value="Calibration">
                                    Calibration
                                </label>
                                
                                <label for="major">
                                    <input type="radio" name="child_type" id="major" value="Deviation">
                                    Deviation
                                </label>

                                <label for="major">
                                    <input type="radio" name="child_type" id="major" value="Action Item">
                                    Action Item
                                </label>

                                <label for="major">
                                    <input type="radio" name="child_type" id="major" value="Change Control">
                                    Change Control
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
    </div> --}}





    <div class="modal fade" id="cancel-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ url('PreventiveCancel', $equipment->id) }}" method="POST">
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
