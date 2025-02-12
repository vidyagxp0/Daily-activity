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

    <style>
        @media print {

            /* Hide everything during printing */
            body * {
                visibility: hidden;
            }

            /* Make only the printable content visible */
            .printable-content,
            .printable-content * {
                visibility: visible;
            }

            /* Position the printable content at the top-left */
            .printable-content {
                position: absolute;
                top: 0;
                left: 0;
            }

            /* Hide the print button during printing */
            .button_theme1 {
                display: none;
            }
        }
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
                    {{ Helpers::getDivisionName($calibration->division_id) }} / Calibration Management
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

                    <div class="d-flex" style="gap:20px;">

                        <?php
                        $userRoles = DB::table('user_roles')
                            ->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => $data->division_id])
                            ->get();
                        $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                        ?>

                        <button class="button_theme1"> <a class="text-white"
                                href="{{ url('calibrationAuditTrail', $data->id) }}"> Audit Trail </a> </button>

                        @if ($data->stage == 1 && Helpers::check_roles($data->division_id, 'Calibration Management', 3))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Initiate Calibration
                            </button>
                        @elseif ($data->stage == 2 && Helpers::check_roles($data->division_id, 'Calibration Management', 3))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Out of Limits
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal2">
                                Within Limits
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>
                        @elseif ($data->stage == 3 && Helpers::check_roles($data->division_id, 'Calibration Management', 3))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Complete Actions
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-model">
                                Child
                            </button>
                        @elseif ($data->stage == 4 && Helpers::check_roles($data->division_id, 'Calibration Management', 3))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                QA Approval
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#modal1">
                                Additional Work Required
                            </button>
                        @endif
                        <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                            </a> </button>
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
                <div class="status">

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
                                <div class="active">Calibration In Progress</div>
                            @else
                                <div class="">Calibration In Progress</div>
                            @endif
                            @if ($data->stage >= 3)
                                <div class="active">Pending Out of Limits Actions</div>
                            @else
                                <div class="">Pending Out of Limits Actions</div>
                            @endif
                            @if ($data->stage >= 4)
                                <div class="active">Pending QA Approval</div>
                            @else
                                <div class="">Pending QA Approval</div>
                            @endif
                            @if ($data->stage >= 5)
                                <div class="active bg-danger">Closed-Done</div>
                            @else
                                <div class="">Closed-Done</div>
                            @endif

                        </div>
                    @endif
                </div>
                <div class="top-block">
                    <div><strong> Record Name :&nbsp;</strong>Calibration Management</div>
                    <div><strong> Site :&nbsp;</strong>{{ Helpers::getDivisionName($data->division_id) }}</div>
                    <div><strong> Current Status :&nbsp;</strong>{{ $data->status }}</div>
                    <div><strong> Initiated By :&nbsp;</strong>{{ Helpers::getInitiatorName($data->initiator_id) }}</div>
                </div>
            </div>
            <div class="modal right fade" id="myModal3" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-titles ml-10">Calibration Management Workflow</h4>
                        </div>
                        <div style="" class="modal-body main-new-workflow">
                            <Div class="button-box">
                                @if ($data->stage == 0)
                                    <div class="">
                                        <div class="mini_buttons  bg-danger">Closed-Cancelled</div>
                                    @else
                                        @if ($data->stage >= 1)
                                            <div class="active">
                                                Opened
                                            </div>
                                        @else
                                            <div class="mini_buttons">Opened</div>
                                        @endif
                                        <div class="down-logo">
                                            <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..."
                                                class="w-100 h-100">
                                        </div>
                                        @if ($data->stage >= 2)
                                            <div class="active">
                                                Calibration In Progress
                                            </div>
                                        @else
                                            <div class="mini_buttons">
                                                Calibration In Progress
                                            </div>
                                        @endif
                                        <div class="down-logo">
                                            <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}"
                                                alt="..." class="w-100 h-100">
                                        </div>
                                        @if ($data->stage >= 3)
                                            <div class="active">
                                                Pending Out of Limits Actions
                                            </div>
                                        @else
                                            <div class="mini_buttons">
                                                Pending Out of Limits Actions
                                            </div>
                                        @endif
                                        <div class="down-logo">
                                            <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}"
                                                alt="..." class="w-100 h-100">
                                        </div>
                                        @if ($data->stage >= 4)
                                            <div class="active">
                                                Pending QA Approval
                                            </div>
                                        @else
                                            <div class="mini_buttons">
                                                Pending QA Approval
                                            </div>
                                        @endif
                                        <div class="down-logo">
                                            <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}"
                                                alt="..." class="w-100 h-100">
                                        </div>
                                        @if ($data->stage >= 4)
                                            <div class="active bg-danger">
                                                Closed - Done
                                            </div>
                                        @else
                                            <div class="mini_buttons">
                                                Closed - Done
                                            </div>
                                        @endif
                                @endif
                            </Div>
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
                        <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Calibration Management</button>
                        {{-- <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">Calibration Management</button> --}}
                        <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Implementor Review</button>
                        <button class="cctablinks" onclick="openCity(event, 'CCForm3')">QA Review</button>
                        <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Activity Log</button>
                    </div>

                    <form id="CCFormInput" action="{{ route('updateCalibrationDetails', $data->id) }}" method="POST"
                        enctype="multipart/form-data">
                        <input type="hidden" name="stage" id="stage" value="{{ $data->stage }}">

                        @csrf
                        {{-- @method('PUT') --}}

                        <!-- Tab content -->
                        <div id="step-form">
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
                                                    value="{{ $data->record_number }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Division Code"><b>Site/Location Code</b></label>
                                                <input readonly type="text" name="division_code"
                                                    value="{{ Helpers::getDivisionName($calibration->division_id) }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Initiator"><b>Initiator</b></label>
                                                <input type="hidden" name="initiator_id">
                                                <input readonly type="text"
                                                    value="{{ $calibration->initiator_name }}">
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
                                                    {{ $calibration->stage == 0 || $calibration->stage == 9 ? 'disabled' : '' }}>
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
                                                    value="{{ Helpers::getdateFormat($calibration->due_date) }}"
                                                    name="due_date"{{ $calibration->stage == 0 || $calibration->stage == 9 ? 'disabled' : '' }}>
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
                                                        value="{{ $calibration->short_description }}" maxlength="255"
                                                        required
                                                        {{ $calibration->stage == 0 || $calibration->stage == 9 ? 'disabled' : '' }}>
                                                    @component('frontend.forms.language-model')
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Calibration Standard Reference</label>
                                                <input type="text" name="calibration_standard_preference"
                                                    value="{{ $calibration->calibration_standard_preference }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Zone">Calibration Frequency</label>
                                                <select name="callibration_frequency">
                                                    <option value="">Select Calibration Frequency</option>
                                                    <option value="Weekly"
                                                        {{ $calibration->callibration_frequency == 'Weekly' ? 'selected' : '' }}>
                                                        Weekly</option>
                                                    <option value="Fortnightly"
                                                        {{ $calibration->callibration_frequency == 'Fortnightly' ? 'selected' : '' }}>
                                                        Fortnightly</option>
                                                    <option value="Monthly"
                                                        {{ $calibration->callibration_frequency == 'Monthly' ? 'selected' : '' }}>
                                                        Monthly</option>
                                                    <option value="Quarterly"
                                                        {{ $calibration->callibration_frequency == 'Quarterly' ? 'selected' : '' }}>
                                                        Quarterly</option>
                                                    <option value="Half Yearly"
                                                        {{ $calibration->callibration_frequency == 'Half Yearly' ? 'selected' : '' }}>
                                                        Half Yearly</option>
                                                    <option value="Annually"
                                                        {{ $calibration->callibration_frequency == 'Annually' ? 'selected' : '' }}>
                                                        Annually</option>
                                                    <option value="Once in Two Years"
                                                        {{ $calibration->callibration_frequency == 'Once in Two Years' ? 'selected' : '' }}>
                                                        Once in Two Years</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Last Calibration Date">Last Calibration Date</label>
                                                <div class="calenderauditee">
                                                    <input type="text" id="last_calibration_date" readonly
                                                        placeholder="DD-MMM-YYYY"
                                                        value="{{ Helpers::getdateFormat($calibration->last_calibration_date) }}"
                                                        {{ $calibration->stage == 0 || $calibration->stage == 9 ? 'disabled' : '' }} />
                                                    <input type="date" id="last_calibration_date_checkdate"
                                                        name="last_calibration_date"
                                                        max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                        {{ $calibration->stage == 0 || $calibration->stage == 9 ? 'disabled' : '' }}
                                                        value="{{ $calibration->last_calibration_date }}"
                                                        class="hide-input"
                                                        oninput="handleDateInput(this, 'last_calibration_date');checkDate('last_calibration_date_checkdate','next_calibration_date_checkdate')" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Next Calibration Date">Next Calibration Date</label>
                                                <div class="calenderauditee">
                                                    <input type="text" id="next_calibration_date" readonly
                                                        placeholder="DD-MMM-YYYY"
                                                        value="{{ Helpers::getdateFormat($calibration->next_calibration_date) }}"
                                                        {{ $calibration->stage == 0 || $calibration->stage == 9 ? 'disabled' : '' }} />
                                                    <input type="date" id="next_calibration_date_checkdate"
                                                        name="next_calibration_date"
                                                        max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                        {{ $calibration->stage == 0 || $calibration->stage == 9 ? 'disabled' : '' }}
                                                        value="{{ $calibration->next_calibration_date }}"
                                                        class="hide-input"
                                                        oninput="handleDateInput(this, 'next_calibration_date');checkDate('last_calibration_date_checkdate','next_calibration_date_checkdate')" />
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Details">Calibration Due Reminder</label>
                                                <input type="number" name="calibration_due_reminder"
                                                    value="{{ $calibration->calibration_due_reminder }}">
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Details">Calibration Method/Procedure</label>
                                                <textarea name="calibration_method_procedure">{{ $calibration->calibration_method_procedure }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Calibration Procedure Reference/Document">Calibration Procedure
                                                    Reference/Document</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting
                                                        documents</small></div>

                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="calibration_procedure_attach">
                                                        @if ($calibration->calibration_procedure_attach)
                                                            @foreach (json_decode($calibration->calibration_procedure_attach) as $file)
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
                                                            {{ $calibration->stage == 0 || $calibration->stage == 9 ? 'disabled' : '' }}
                                                            type="file" id="myfile"
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
                                                <input type="text" name="calibration_used"
                                                    value="{{ $calibration->calibration_used }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Calibration Parameters</label>
                                                <input type="text" name="calibration_parameter"
                                                    value="{{ $calibration->calibration_parameter }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Zone">Unscheduled or Event Based Calibration?</label>
                                                <select name="event_based_calibration">
                                                    <option value="">--Select--</option>
                                                    <option value="Yes"
                                                        {{ $calibration->event_based_calibration == 'Yes' ? 'selected' : '' }}>
                                                        Yes</option>
                                                    <option value="No"
                                                        {{ $calibration->event_based_calibration == 'No' ? 'selected' : '' }}>
                                                        No</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Details">Reason for Unscheduled or Event Based
                                                    Calibration</label>
                                                <textarea name="event_based_calibration_reason">{{ $calibration->event_based_calibration_reason }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Event Reference No.</label>
                                                <input type="number" name="event_refernce_no"
                                                    value="{{ $calibration->event_refernce_no }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Calibration Checklist</label>
                                                <input type="text" name="calibration_checklist"
                                                    value="{{ $calibration->calibration_checklist }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Calibration Results</label>
                                                <input type="text" name="calibration_result"
                                                    value="{{ $calibration->calibration_result }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Calibration Certificate Number</label>
                                                <input type="number" name="calibration_certificate_result"
                                                    value="{{ $calibration->calibration_certificate_result }}">
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Calibration Certificate Attachment">Calibration Certificate
                                                    Attachment</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting
                                                        documents</small></div>

                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="calibration_certificate">
                                                        @if ($calibration->calibration_certificate)
                                                            @foreach (json_decode($calibration->calibration_certificate) as $file)
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
                                                            {{ $calibration->stage == 0 || $calibration->stage == 9 ? 'disabled' : '' }}
                                                            type="file" id="myfile"
                                                            name="calibration_certificate[]"
                                                            oninput="addMultipleFiles(this, 'calibration_certificate')"
                                                            multiple>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Calibrated By</label>
                                                <input type="text" name="calibrated_by"
                                                    value="{{ $calibration->calibrated_by }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Calibration Due Alert</label>
                                                <input type="text" name="calibration_due_alert"
                                                    value="{{ $calibration->calibration_due_alert }}">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Cost of Calibration</label>
                                                <input type="text"
                                                    name="calibration_cost"value="{{ $calibration->calibration_cost }}">
                                            </div>
                                        </div>

                                        <div class="pt-2 group-input">
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
                                                        @if ($CmCheckListGrid && is_array($CmCheckListGrid->data))
                                                            @foreach ($CmCheckListGrid->data as $index => $checklist_grid)
                                                                <tr>
                                                                    <td disabled><input type="text" name="cmchecklist[{{ $loop->index }}][serial]" value="{{ $loop->index + 1 }}"></td>
                                                                    <td><input type="text" name="cmchecklist[{{ $loop->index }}][checkpoint]" value="{{ array_key_exists('checkpoint', $checklist_grid) ? $checklist_grid['checkpoint'] : '' }}"></td>
                                                                    <td><input type="text" name="cmchecklist[{{ $loop->index }}][comment]" value="{{ array_key_exists('comment', $checklist_grid) ? $checklist_grid['comment'] : '' }}"></td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td><input type="text" name="cmchecklist[0][serial]" value="1"></td>
                                                                <td><input type="text" name="cmchecklist[0][checkpoint]"></td>
                                                                <td><input type="text" name="cmchecklist[0][comment]"></td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Details">Calibration Comments/Observations</label>
                                                <textarea name="calibration_comments">{{ $calibration->calibration_comments }}</textarea>
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


                            <div id="CCForm2" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Cancel By">Implementor Review Comment</label>
                                                {{-- <input type="text" name="Imp_review_comm"value="{{ $calibration->Imp_review_comm }}"> --}}
                                                <textarea name="Imp_review_comm">{{ $data->Imp_review_comm }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Calibration Certificate Attachment">Implementor Review
                                                    Attachment</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting
                                                        documents</small></div>

                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="Implementor_Attachment">
                                                        @if ($calibration->Implementor_Attachment)
                                                            @foreach (json_decode($calibration->Implementor_Attachment) as $file)
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
                                                            {{ $calibration->stage == 0 || $calibration->stage == 9 ? 'disabled' : '' }}
                                                            type="file" id="myfile" name="Implementor_Attachment[]"
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

                                        {{-- <button type="submit">Submit</button> --}}
                                        {{-- <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white">
                                                Exit </a> </button> --}}
                                    </div>
                                </div>
                            </div>

                            <div id="CCForm3" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Cancel By">QA Review Comment</label>
                                                {{-- <input type="text" name="qa_rev_comm"value="{{ $calibration->qa_rev_comm }}"> --}}
                                                <textarea name="qa_rev_comm">{{ $calibration->qa_rev_comm }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Calibration Certificate Attachment">QA Review
                                                    Attachment</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting
                                                        documents</small></div>

                                                <div class="file-attachment-field">
                                                    <div class="file-attachment-list" id="qa_rev_attachment">
                                                        @if ($calibration->qa_rev_attachment)
                                                            @foreach (json_decode($calibration->qa_rev_attachment) as $file)
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
                                                            {{ $calibration->stage == 0 || $calibration->stage == 9 ? 'disabled' : '' }}
                                                            type="file" id="myfile" name="qa_rev_attachment[]"
                                                            oninput="addMultipleFiles(this, 'qa_rev_attachment')" multiple>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>

                                        {{-- <button type="submit">Submit</button> --}}
                                        {{-- <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white">
                                                Exit </a> </button> --}}
                                    </div>
                                </div>
                            </div>

                            <div id="CCForm4" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="sub-head">Activity Log</div>

                                    <div class="d-flex align-item-end justify-content-end">
                                        <a href="route('rcms/calibrationActivityLog')">
                                            {{-- <button class="button_theme1" id="printButton" style="margin-bottom:20px;">Print </a></button> --}}
                                            {{-- <button id="printButton" class="btn btn-primary">Print PDF</button> --}}

                                            <button style="margin-bottom:20px;" class="button_theme1"> <a
                                                    class="text-white"
                                                    href="{{ url('calibrationActivityLog', $data->id) }}"> Print </a>
                                            </button>
                                    </div>

                            
                                    <div class="printable-content">
                                        {{-- <div class="row">
                                            <h5>
                                                <strong>Initiator Name:</strong> {{ $calibration->initiator_name }}
                                                &nbsp;&nbsp;&nbsp;
                                                <strong>Date of Initiation:</strong> {{ $calibration->intiation_date }}
                                            </h5>
                                        </div> --}}

                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <!-- Row for Initiate Calibration By and Initiate Calibration On -->
                                                    <tr>
                                                        <td>
                                                            <strong>Initiate Calibration By:</strong><br>
                                                            {{ $calibration->Initiate_Calibration_by }}
                                                        </td>
                                                        <td>
                                                            <strong>Initiate Calibration On:</strong><br>
                                                            @php
                                                                $initiateTime = $calibration->Initiate_Calibration_on;
                                                                $timeArray = explode(' | ', $initiateTime);
                                                                $timeInIST = isset($timeArray[0])
                                                                    ? $timeArray[0]
                                                                    : 'No IST Time Available';
                                                                $timeInGMT = isset($timeArray[1])
                                                                    ? $timeArray[1]
                                                                    : 'No GMT Time Available';
                                                                $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                                                echo $isIndia ? $timeInIST : $timeInGMT;
                                                            @endphp
                                                        </td>
                                                    </tr>

                                                    <!-- Row for Initiate Calibration Comments -->
                                                    <tr>
                                                        <td colspan="2">
                                                            <strong>Initiate Calibration Comments:</strong><br>
                                                            {{ $calibration->Initiate_Calibration_comments ?? 'Not Applicable' }}
                                                        </td>
                                                    </tr>

                                                    <!-- Add more rows for other data -->
                                                    <tr>
                                                        <td>
                                                            <strong>Within Limits By:</strong><br>
                                                            {{ $calibration->Within_Limits_by }}
                                                        </td>
                                                        <td>
                                                            <strong>Within Limits On:</strong><br>
                                                            @php
                                                                $withinLimitsTime = $calibration->Within_Limits_on;
                                                                $timeArray = explode(' | ', $withinLimitsTime);
                                                                $timeInIST = isset($timeArray[0])
                                                                    ? $timeArray[0]
                                                                    : 'No IST Time Available';
                                                                $timeInGMT = isset($timeArray[1])
                                                                    ? $timeArray[1]
                                                                    : 'No GMT Time Available';
                                                                $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                                                echo $isIndia ? $timeInIST : $timeInGMT;
                                                            @endphp
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="2">
                                                            <strong>Within Limits Comment:</strong><br>
                                                            {{ $calibration->Within_Limits_comment ?? 'Not Applicable' }}
                                                        </td>
                                                    </tr>

                                                    <!-- Repeat for all other rows -->
                                                    <!-- Row for Out of Limits By and Out of Limits On -->
                                                    <tr>
                                                        <td>
                                                            <strong>Out of Limits By:</strong><br>
                                                            {{ $calibration->Out_of_Limits_by }}
                                                        </td>
                                                        <td>
                                                            <strong>Out of Limits On:</strong><br>
                                                            @php
                                                                $outOfLimitsTime = $calibration->Out_of_Limits_on;
                                                                $timeArray = explode(' | ', $outOfLimitsTime);
                                                                $timeInIST = isset($timeArray[0])
                                                                    ? $timeArray[0]
                                                                    : 'No IST Time Available';
                                                                $timeInGMT = isset($timeArray[1])
                                                                    ? $timeArray[1]
                                                                    : 'No GMT Time Available';
                                                                $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                                                echo $isIndia ? $timeInIST : $timeInGMT;
                                                            @endphp
                                                        </td>
                                                    </tr>

                                                    <!-- Row for Complete Actions By and Complete Actions On -->
                                                    <tr>
                                                        <td>
                                                            <strong>Complete Actions By:</strong><br>
                                                            {{ $calibration->Complete_Actions_by }}
                                                        </td>
                                                        <td>
                                                            <strong>Complete Actions On:</strong><br>
                                                            @php
                                                                $completeActionsTime =
                                                                    $calibration->Complete_Actions_on;
                                                                $timeArray = explode(' | ', $completeActionsTime);
                                                                $timeInIST = isset($timeArray[0])
                                                                    ? $timeArray[0]
                                                                    : 'No IST Time Available';
                                                                $timeInGMT = isset($timeArray[1])
                                                                    ? $timeArray[1]
                                                                    : 'No GMT Time Available';
                                                                $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                                                echo $isIndia ? $timeInIST : $timeInGMT;
                                                            @endphp
                                                        </td>
                                                    </tr>

                                                    <!-- Row for Complete Actions Comment -->
                                                    <tr>
                                                        <td colspan="2">
                                                            <strong>Complete Actions Comment:</strong><br>
                                                            {{ $calibration->Complete_Actions_comment ?? 'Not Applicable' }}
                                                        </td>
                                                    </tr>

                                                    <!-- Row for Additional Work Required By and Additional Work Required On -->
                                                    <tr>
                                                        <td>
                                                            <strong>Additional Work Required By:</strong><br>
                                                            {{ $calibration->Additional_Work_Required_by }}
                                                        </td>
                                                        <td>
                                                            <strong>Additional Work Required On:</strong><br>
                                                            @php
                                                                $additionalWorkTime =
                                                                    $calibration->Additional_Work_Required_on;
                                                                $timeArray = explode(' | ', $additionalWorkTime);
                                                                $timeInIST = isset($timeArray[0])
                                                                    ? $timeArray[0]
                                                                    : 'No IST Time Available';
                                                                $timeInGMT = isset($timeArray[1])
                                                                    ? $timeArray[1]
                                                                    : 'No GMT Time Available';
                                                                $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                                                echo $isIndia ? $timeInIST : $timeInGMT;
                                                            @endphp
                                                        </td>
                                                    </tr>

                                                    <!-- Row for Additional Work Required Comment -->
                                                    <tr>
                                                        <td colspan="2">
                                                            <strong>Additional Work Required Comment:</strong><br>
                                                            {{ $calibration->Additional_Work_Required_comment ?? 'Not Applicable' }}
                                                        </td>
                                                    </tr>

                                                    <!-- Row for QA Approval By and QA Approval On -->
                                                    <tr>
                                                        <td>
                                                            <strong>QA Approval By:</strong><br>
                                                            {{ $calibration->QA_Approval_by }}
                                                        </td>
                                                        <td>
                                                            <strong>QA Approval On:</strong><br>
                                                            @php
                                                                $qaApprovalTime = $calibration->QA_Approval_on;
                                                                $timeArray = explode(' | ', $qaApprovalTime);
                                                                $timeInIST = isset($timeArray[0])
                                                                    ? $timeArray[0]
                                                                    : 'No IST Time Available';
                                                                $timeInGMT = isset($timeArray[1])
                                                                    ? $timeArray[1]
                                                                    : 'No GMT Time Available';
                                                                $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                                                echo $isIndia ? $timeInIST : $timeInGMT;
                                                            @endphp
                                                        </td>
                                                    </tr>

                                                    <!-- Row for QA Approval Comment -->
                                                    <tr>
                                                        <td colspan="2">
                                                            <strong>QA Approval Comment:</strong><br>
                                                            {{ $calibration->QA_Approval_comment ?? 'Not Applicable' }}
                                                        </td>
                                                    </tr>

                                                    <!-- Row for Cancel By and Cancel On -->
                                                    <tr>
                                                        <td>
                                                            <strong>Cancel By:</strong><br>
                                                            {{ $calibration->Cancel_by }}
                                                        </td>
                                                        <td>
                                                            <strong>Cancel On:</strong><br>
                                                            @php
                                                                $cancelTime = $calibration->Cancel_on;
                                                                $timeArray = explode(' | ', $cancelTime);
                                                                $timeInIST = isset($timeArray[0])
                                                                    ? $timeArray[0]
                                                                    : 'No IST Time Available';
                                                                $timeInGMT = isset($timeArray[1])
                                                                    ? $timeArray[1]
                                                                    : 'No GMT Time Available';
                                                                $isIndia = auth()->user()->timezone === 'Asia/Kolkata';
                                                                echo $isIndia ? $timeInIST : $timeInGMT;
                                                            @endphp
                                                        </td>
                                                    </tr>

                                                    <!-- Row for Cancel Comment -->
                                                    <tr>
                                                        <td colspan="2">
                                                            <strong>Cancel Comment:</strong><br>
                                                            {{ $calibration->Cancel_comment ?? 'Not Applicable' }}
                                                        </td>
                                                    </tr>

                                                    <!-- Row for Out of Limits Comment -->
                                                    <tr>
                                                        <td colspan="2">
                                                            <strong>Out of Limits Comment:</strong><br>
                                                            {{ $calibration->Out_of_Limits_comment ?? 'Not Applicable' }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    

                                    <div class="button-block">
                                        <button type="submit" class="saveButton">Save</button>
                                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                        {{-- <button type="submit">Submit</button> --}}
                                        {{-- <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white">
                                                Exit </a> </button> --}}
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

    <div class="modal fade" id="cancel-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ url('CalibrationCancel', $calibration->id) }}" method="POST">
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
                            <label for="comment">Comment <span class="text-danger"></span></label>
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

    <div class="modal fade" id="modal1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('Calibrationback', $data->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="mb-3 text-justify">
                            Please select a meaning and a outcome for this task and enter your username
                            and password for this task. You are performing an electronic signature,
                            which is legally binding equivalent of a hand written signature.
                        </div>
                        <div class="group-input">
                            <label for="username">Username<span class="text-danger">*</span></label>
                            <input type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password<span class="text-danger">*</span></label>
                            <input type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment<span class="text-danger">*</span></label>
                            <input type="comment" name="comment" required>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <!-- <div class="modal-footer">
                            <button type="submit" data-bs-dismiss="modal">Submit</button>
                            <button>Close</button>
                        </div> -->
                    <div class="modal-footer">
                        <button type="submit">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
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
                <form action="{{ url('CalibrationDetailsStateChange', $data->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="mb-3 text-justify">
                            Please select a meaning and a outcome for this task and enter your username
                            and password for this task. You are performing an electronic signature,
                            which is legally binding equivalent of a hand written signature.
                        </div>
                        <div class="group-input">
                            <label for="username">Username<span class="text-danger">*</span></label>
                            <input type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password<span class="text-danger">*</span></label>
                            <input type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment<span class="text-danger">*</span></label>
                            <input type="comment" name="comment" required>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <!-- <div class="modal-footer">
                            <button type="submit" data-bs-dismiss="modal">Submit</button>
                            <button>Close</button>
                        </div> -->
                    <div class="modal-footer">
                        <button type="submit">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="signature-modal2">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('CalibrationDetailsStateChangeNew', $data->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="mb-3 text-justify">
                            Please select a meaning and a outcome for this task and enter your username
                            and password for this task. You are performing an electronic signature,
                            which is legally binding equivalent of a hand written signature.
                        </div>
                        <div class="group-input">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment</label>
                            <input type="comment" class="form-control" name="comment">
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <!-- <div class="modal-footer">
                            <button type="submit" data-bs-dismiss="modal">Submit</button>
                            <button>Close</button>
                        </div> -->
                    <div class="modal-footer">
                        <button type="submit">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="child-model">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Child</h4>
                </div>
                <form action="{{ route('CalibrationChild', $data->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="group-input">
                            @if ($data->stage == 3)
                                <div>
                                    {{-- <label for="minor">
                                        <input type="radio" name="revision" id="minor" value="Effective-Check">
                                        Effectiveness Check
                                    </label> <br> --}}

                                    <label for="minor">
                                        <input type="radio" name="revision" id="minor" value="Action Item">
                                        Action Item
                                    </label>
                                </div>
                            @endif

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

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <style>
        #productTable,
        #materialTable {
            display: none;
        }
    </style>

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
    $(document).ready(function() {
        $('#CheckListAdd').click(function(e) {
            function generateTableRow(serialNumber) {
                var html =
                    '<tr>' +
                    '<td><input type="text" name="cmchecklist[' + serialNumber + '][serial]" value="' + serialNumber + '"></td>' +
                    '<td><input type="text" name="cmchecklist[' + serialNumber + '][checkpoint]"></td>' +
                    '<td><input type="text" name="cmchecklist[' + serialNumber + '][comment]"></td>' +
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
